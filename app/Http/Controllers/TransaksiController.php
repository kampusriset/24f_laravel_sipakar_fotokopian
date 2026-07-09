<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use App\Models\DetailLayanan;
use Illuminate\Support\Facades\DB;

// CEK KODENYA DAN CEK WORK OR NOT
class TransaksiController extends Controller
{
    // Read | Ambil data gabungan dari Layanan & Pelanggan
    public function getMasterData() {
        $pelanggan = Pelanggan::select('id', 'nama')->get();
        $layanan = Layanan::select('id', 'nama_layanan', 'harga_per_lembar')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'pelanggan' => $pelanggan,
                'layanan' => $layanan,
            ]
        ]);
    }

    // Create (SUDAH DILENGKAPI FITUR BACA PDF OTOMATIS)
    public function create(Request $request) {
        DB::beginTransaction();

        try {
            $pelangganId = $request->pelanggan_id;

            $request->validate([
                'nama_pelanggan' => 'required|string',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
                'layanan_id' => 'required',
                'file_dokumen' => 'nullable|file|mimes:pdf', // Pastikan file-nya PDF
            ]);

            // 1. Proses Pelanggan
            if(!$pelangganId) {
                $pelangganBaru = Pelanggan::create([
                    'nama' => $request->nama_pelanggan,
                    'no_hp' => $request->no_hp ?? '-',
                    'alamat' => $request->alamat ?? '-',
                ]);
                $pelangganId = $pelangganBaru->id;
            }

            // 2. Logika Ekstrak Halaman PDF
            $jumlahHalaman = 1; // Nilai dasar jika tidak ada file (misal untuk fotocopy dokumen fisik)
            $namaFileFisik = null;

            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                
                // Beri nama unik agar file tidak tertimpa jika namanya sama
                $namaFileFisik = time() . '_' . $file->getClientOriginalName();
                
                // Gunakan Smalot PDF Parser untuk menghitung jumlah lembar otomatis
                $pdfParser = new Parser();
                $pdf = $pdfParser->parseFile($file->getPathname());
                $jumlahHalaman = count($pdf->getPages());
                
                // Simpan file asli ke dalam folder storage/app/public/dokumen
                $file->storeAs('public/dokumen', $namaFileFisik);
            }

            // 3. Kalkulasi Harga Secara Aman di Backend (Bukan dari Frontend)
            $layanan = Layanan::findOrFail($request->layanan_id);
            $hargaSatuan = $layanan->harga_per_lembar;
            $totalHarga = $jumlahHalaman * $hargaSatuan;

            // 4. Simpan ke Database
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelangganId,
                'operator_id' => auth('sanctum')->id() ?? 1, // Fallback ke kasir 1 jika testing tanpa login
                'tanggal' => Carbon::now(),
                'total_harga' => $totalHarga // Harga hasil hitungan mesin
            ]);

            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'total_bayar' => $totalHarga,
                'metode' => $request->metode ?? 'Cash', // Default ke cash
                'tanggal_bayar' => Carbon::now(),
            ]);

            DetailLayanan::create([
                'transaksi_id' => $transaksi->id,
                'layanan_id' => $layanan->id,
                'jumlah_halaman' => $jumlahHalaman, // Jumlah halaman dari PDF
                'harga_satuan' => $hargaSatuan,
                'file_dokumen' => $namaFileFisik, // Nama file yang tersimpan
                'subtotal' => $totalHarga,
                'waktu_deadline' => $request->waktu_deadline ? Carbon::parse($request->waktu_deadline) : Carbon::now()->addHours(2),
                'status_antrean' => 'Menunggu',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan. Terdeteksi ' . $jumlahHalaman . ' halaman, Total: Rp ' . number_format($totalHarga, 0, ',', '.')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update (TYPO DIPERBAIKI)
    public function update(Request $request, $id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error', // Diubah jadi error, karena ini kondisi gagal
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $detail = DetailLayanan::where('transaksi_id', $id)->first();
            if($detail) {
                $detail->layanan_id = $request->layanan_id;
                $detail->jumlah_halaman = $request->jumlah_halaman;
                $detail->harga_satuan = $request->harga_satuan;
                $detail->subtotal = $request->total_harga;
                $detail->save();
            }

            $transaksi->total_harga = $request->total_harga;
            $transaksi->save();

            // TYPO DIPERBAIKI: transsaksi_id menjadi transaksi_id
            $pembayaran = Pembayaran::where('transaksi_id', $id)->first();
            if($pembayaran) {
                $pembayaran->total_bayar = $request->total_harga;
                $pembayaran->metode = $request->metode;
                $pembayaran->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data transaksi berhasil diperbaiki',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error', // Diubah jadi error
                'message' => 'Gagal edit transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete (TYPO DIPERBAIKI)
    public function delete($id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            // TYPO DIPERBAIKI: Menggunakan titik dua ganda (::)
            DetailLayanan::where('transaksi_id', $id)->delete();
            Pembayaran::where('transaksi_id', $id)->delete();
            $transaksi->delete();

            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Data transaksi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}