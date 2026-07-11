<?php

use App\Models\Layanan;
use App\Models\Transaksi;
// use App\Models\Pelanggan;
// use App\Models\pembayaran;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Logika mengambil 5 data transaksi 
Route::get('/', function() {
    $transaksiTerbaru = DB::table('transaksi')
                        ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                        ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                        ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                        ->select(
                            'pelanggan.nama as nama_pelanggan',
                            'detail_layanan.file_dokumen',
                            'detail_layanan.jumlah_halaman',
                            'detail_layanan.waktu_deadline',
                            'pembayaran.metode',
                            'detail_layanan.status_antrean',
                        )
                        ->orderBy('transaksi.created_at', 'desc')
                        ->take(5)
                        ->get();

    $daftarLayanan = \App\Models\Layanan::all();

    return view('home', compact('transaksiTerbaru', 'daftarLayanan'));
});

// Logika pemanggilan data transaki, pelanggan, detail layanan, pembayaran
Route::get('/transaksi', function () {
    $antreanAktif = DB::table('transaksi')
                    ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                    ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                    ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
                    ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                    ->select(
                        'transaksi.id as id_transaksi',
                        'pelanggan.nama as nama_pelanggan',
                        'detail_layanan.file_dokumen',
                        'layanan.nama_layanan',
                        'detail_layanan.waktu_deadline',
                        'pembayaran.metode',
                        'detail_layanan.status_antrean',
                    )
                    ->where('detail_layanan.status_antrean', '!=', 'Selesai')
                    ->orderBy('detail_layanan.waktu_deadline', 'asc')
                    ->get();

    return view('transaksi', compact('antreanAktif'));
});

// Submit Transaksi
Route::post('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'create']);

