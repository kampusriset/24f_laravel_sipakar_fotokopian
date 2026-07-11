<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    // Create
    public function create(Request $request) {
        DB::beginTransaction();

        try {
            $pelangganId = $request->pelanggan_id;

            $request->validate([
                'nama_pelanggan' => 'required|string',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
                'layanan_id' => 'required',
                'file_dokumen' => 'nullable|file|mimes:pdf',
            ]);

            // Proses Pelanggan
            if(!$pelangganId) {
                $pelangganBaru = Pelanggan::create([
                    'nama' => $request->nama_pelanggan,
                    'no_hp' => $request->no_hp ?? '-',
                    'alamat' => $request->alamat ?? '-',
                ]);
                $pelangganId = $pelangganBaru->id;
            }

            // Logika Halaman PDF
            $jumlahHalaman = 1;
            $namaFileFisik = null;

            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                
                // nama unik agar file tidak tertimpa jika namanya sama
                $namaFileFisik = time() . '_' . $file->getClientOriginalName();
                
                // Menggunakan Smalot PDF untuk menghitung jumlah halaman
                $pdfParser = new Parser();
                $pdf = $pdfParser->parseFile($file->getPathname());
                $jumlahHalaman = count($pdf->getPages());
                
                // Simpan file ke dalam folder storage/app/public/dokumen
                $file->storeAs('public/dokumen', $namaFileFisik);
            }

            // Kalkulasi Harga
            $layanan = Layanan::findOrFail($request->layanan_id);
            $hargaSatuan = $layanan->harga_per_lembar;
            $totalHarga = $jumlahHalaman * $hargaSatuan;

            // Simpan ke Database
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelangganId,
                'operator_id' => auth('sanctum')->id() ?? 1, 
                'tanggal' => Carbon::now(),
                'total_harga' => $totalHarga
            ]);

            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'total_bayar' => $totalHarga,
                'metode' => $request->metode ?? 'Cash',
                'tanggal_bayar' => Carbon::now(),
            ]);

            DetailLayanan::create([
                'transaksi_id' => $transaksi->id,
                'layanan_id' => $layanan->id,
                'jumlah_halaman' => $jumlahHalaman,
                'harga_satuan' => $hargaSatuan,
                'file_dokumen' => $namaFileFisik,
                'subtotal' => $totalHarga,
                'waktu_deadline' => $request->waktu_deadline ? Carbon::parse($request->waktu_deadline) : Carbon::now()->addHours(2),
                'status_antrean' => 'Menunggu',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil disimpan. Terdeteksi ' . $jumlahHalaman . ' halaman, Total: Rp ' . number_format($totalHarga, 0, ',', '.'));
            
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // Update
    public function update(Request $request, $id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error', 
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
                'status' => 'error',
                'message' => 'Gagal edit transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
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
// method riwayat
    public function riwayat(Request $request) {
    try {
        // Ambil semua data transaksi beserta relasinya
        $riwayat = Transaksi::with([
            'pelanggan:id,nama,no_hp,alamat', 
            'operator:id,nama,email',
            'pembayaran', 
            'detailLayanan.layanan'
        ])
        ->orderBy('tanggal', 'desc')
        ->get();

        // [PERCABANGAN] Jalur API: Jika dipanggil oleh api.php / meminta JSON
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data riwayat transaksi berhasil diambil',
                'data' => $riwayat
            ], 200);
        }

        // [PERCABANGAN] Jalur UI/Web: Jika diakses biasa lewat browser (Navbar)
        return view('riwayat', compact('riwayat'));

    } catch (\Exception $e) {
        // [PERCABANGAN ERROR] Sesuai analisis Zidan
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat riwayat transaksi: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()->with('error', 'Gagal memuat riwayat transaksi: ' . $e->getMessage());
    }
}
    }
}