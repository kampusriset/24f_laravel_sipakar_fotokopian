<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\DetailLayanan;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Read | Ambil data gabungan dari Layanan & Pelanggan
    public function getMasterData(Request $request) {
        $pelanggan = Pelanggan::select('id', 'nama')->get();
        $layanan = Layanan::select('id', 'nama_layanan', 'harga_per_lembar')->get();
        
        $transaksi = DB::table('transaksi')
                    ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                    ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                    ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
                    ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                    ->select(
                        'transaksi.id as id_transaksi',
                        'pelanggan.nama as nama_pelanggan',
                        'detail_layanan.file_dokumen',
                        'detail_layanan.jumlah_halaman',
                        'detail_layanan.layanan_id',
                        'layanan.nama_layanan',
                        'pelanggan.no_hp',
                        'pelanggan.alamat',
                        'detail_layanan.waktu_deadline',
                        'pembayaran.metode',
                        'detail_layanan.status_antrean',
                        'transaksi.total_harga',    
                        'pembayaran.total_bayar'
                    )
                    ->where('detail_layanan.status_antrean', '!=', 'Selesai')
                    ->orderBy('detail_layanan.waktu_deadline', 'asc')
                    ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pelanggan' => $pelanggan,
                    'layanan' => $layanan,
                    'transaksi' => $transaksi,
                ]
            ]);
        }
        return view('transaksi', compact('transaksi', 'pelanggan', 'layanan'));
    }

    // Method Create
    public function create(Request $request) {
        DB::beginTransaction();

        try {
            // $pelangganId = $request->pelanggan_id;

            // Validasi Input
            $request->validate([
                'nama_pelanggan' => 'required|string',
                'no_hp'          => 'nullable|string',
                'alamat'         => 'nullable|string',
                'layanan_id'     => 'required',
                'waktu_deadline' => 'required|date_format:H:i', 
                'metode'         => 'required|string',
                'sumber_dokumen' => 'required|in:digital,fisik',
                'file_dokumen'   => 'required_if:sumber_dokumen,digital|mimes:pdf,docx,doc|nullable',
                'jumlah_halaman_manual' => 'required_if:sumber_dokumen,fisik|numeric|min:1|nullable',
            ]);

            $pelanggan = Pelanggan::updateOrCreate(
                ['no_hp' => $request->no_hp ?? '-'],
                [
                    'nama'   => $request->nama_pelanggan,
                    'alamat' => $request->alamat ?? '-'
                ]
            );
            $pelangganId = $pelanggan->id;

            // Logika Halaman PDF
            $jumlahHalaman = 1;
            $namaFileFisik = null;

            if ($request->sumber_dokumen === 'digital') {
                if ($request->hasFile('file_dokumen')) {
                    $file = $request->file('file_dokumen');
                    $ekstensi = strtolower($file->getClientOriginalExtension());
                    $namaFileFisik = time() . '_' . $file->getClientOriginalName();

                    // Simpan file
                    $file->storeAs('public/dokumen', $namaFileFisik);

                    // LOGIKA CEK HALAMAN
                    if ($ekstensi === 'pdf') {
                        $pdfParser = new Parser();
                        $pdf = $pdfParser->parseFile($file->getPathname());
                        $jumlahHalaman = count($pdf->getPages());

                } elseif ($ekstensi === 'docx') {
                        $zip = new \ZipArchive();

                        if ($zip->open($file->getPathname()) === true) {

                            if (($index = $zip->locateName('docProps/app.xml')) !== false) {
                                $xmlData = $zip->getFromIndex($index);
                                $xml = simplexml_load_string($xmlData);

                                if ($xml && isset($xml->Pages)) {
                                    $jumlahHalaman = (int) $xml->Pages;
                                }
                            }
                            $zip->close();
                        }

                        if ($jumlahHalaman == 0) $jumlahHalaman = 1; 
                    }
                }
            } else {
                $namaFileFisik = '';
                $jumlahHalaman = $request->jumlah_halaman_manual;
            }

            // Kalkulasi Harga
            $layanan = Layanan::findOrFail($request->layanan_id);
            $hargaSatuan = $layanan->harga_per_lembar;
            $totalHarga = $jumlahHalaman * $hargaSatuan;

            $operator = \App\Models\Operator::where('user_id', Auth::id())->first();
            $operatorId = $operator ? $operator->id : 1;

            // Simpan ke Database
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelangganId,
                'operator_id'  => $operatorId,
                'total_harga'  => $totalHarga

            ]);

            Pembayaran::create([
                'transaksi_id'  => $transaksi->id,
                'total_bayar'   => $totalHarga,
                'metode'        => $request->metode,
                'tanggal_bayar' => Carbon::now(),

            ]);

            $waktuSelesai = Carbon::today()->format('Y-m-d') . ' ' . $request->waktu_deadline . ':00';

            DetailLayanan::create([
                'transaksi_id'   => $transaksi->id,
                'layanan_id'     => $layanan->id,
                'jumlah_halaman' => $jumlahHalaman,
                'harga_satuan'   => $hargaSatuan,
                'file_dokumen'   => $namaFileFisik,
                'subtotal'       => $totalHarga,
                'waktu_deadline' => Carbon::parse($waktuSelesai),
                'status_antrean' => 'Menunggu',

            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Transaksi berhasil disimpan',
                    'data'    => [
                        'jumlah_halaman' => $jumlahHalaman,
                        'total_harga'    => $totalHarga
                    ]
                ], 201);
            }

            return redirect()->back()->with('success', 'Transaksi berhasil disimpan ke antrean.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // Method Update
    public function update(Request $request, $id) {
        $transaksi = Transaksi::find($id);

        // Cek Transaksi
        if (!$transaksi) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        // Validasi Update
        if (!$request->has('status_antrean')) { 
            $request->validate([
                'nama_pelanggan' => 'nullable|string|max:255',
                'no_hp'          => 'nullable|string',
                'alamat'         => 'nullable|string',
                'file_dokumen'   => 'nullable|file|mimes:pdf',
                'jumlah_halaman' => 'nullable|numeric|min:1',
                'metode'         => 'nullable|string',
            ]);
        }

        DB::beginTransaction();

        try {
            $detail = DetailLayanan::where('transaksi_id', $id)->first();
            $pesanSukses = 'Data berhasil diperbarui';

            // Logika Update Status
            if ($request->has('status_antrean')) {
                if ($detail) {
                    $detail->status_antrean = $request->status_antrean; 
                    $detail->save();
                }
                $pesanSukses = 'Status pesanan berhasil diubah menjadi ' . $request->status_antrean;
                
            } else {
                // Logika Update Full Data
                $pelanggan = DB::table('pelanggan')->where('id', $transaksi->pelanggan_id)->first();
                if ($pelanggan) {
                    DB::table('pelanggan')
                        ->where('id', $transaksi->pelanggan_id)
                        ->update([
                            'nama'   => $request->nama_pelanggan ?? $pelanggan->nama,
                            'no_hp'  => $request->no_hp ?? $pelanggan->no_hp,
                            'alamat' => $request->alamat ?? $pelanggan->alamat
                        ]);
                }

                if ($detail) {
                    if ($request->hasFile('file_dokumen')) {
                        $file = $request->file('file_dokumen');
                        $namaFileFisik = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs('public/dokumen', $namaFileFisik);
                        
                        $detail->file_dokumen = $namaFileFisik; 
                    }

                    // Inputan Baru
                    $layananId = $request->layanan_id ?? $detail->layanan_id;
                    
                    $jumlahHalaman = $request->jumlah_halaman ?? $detail->jumlah_halaman;

                    // Kalkulasi Harga
                    $layanan = Layanan::find($layananId);
                    $hargaSatuan = $layanan ? $layanan->harga_per_lembar : $detail->harga_satuan;
                    $totalHarga = $jumlahHalaman * $hargaSatuan;

                    $detail->layanan_id = $layananId;
                    $detail->jumlah_halaman = $jumlahHalaman;
                    $detail->harga_satuan = $hargaSatuan;
                    $detail->subtotal = $totalHarga;
                    $detail->save();
                    
                    $transaksi->total_harga = $totalHarga;
                    $transaksi->save();

                    $pembayaran = Pembayaran::where('transaksi_id', $id)->first();
                    if ($pembayaran) {
                        $pembayaran->total_bayar = $totalHarga;
                        $pembayaran->metode = $request->metode ?? $pembayaran->metode;
                        $pembayaran->save();
                    }
                }
                $pesanSukses = 'Transaksi berhasil terupdate';
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['status' => 'success', 'message' => $pesanSukses], 200);
            }
            return redirect()->back()->with('success', $pesanSukses);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Gagal edit: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal edit transaksi: ' . $e->getMessage());
        }
    }

    // Method Delete
    public function delete(Request $request, $id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            DetailLayanan::where('transaksi_id', $id)->delete();
            Pembayaran::where('transaksi_id', $id)->delete();
            $transaksi->delete();

            DB::commit();

            if ($transaksi) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success', 
                        'message' => 'Transaksi berhasil dihapus'
                    ], 201);
                }
            
                return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            if($request->expectJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
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

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data riwayat transaksi berhasil diambil',
                    'data' => $riwayat
                ], 200);
            }

            return view('riwayat', compact('riwayat'));

        } catch (\Exception $e) {
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