<?php

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Logika mengambil 5 data transaksi 
Route::get('/', function() {
    // Read
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

// Manajemen Transaksi
Route::get('/transaksi', [TransaksiController::class, 'getMasterData'])->name('transaksi.getMasterData');
Route::post('/transaksi', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');