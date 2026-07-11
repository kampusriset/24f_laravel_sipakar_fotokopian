<?php

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// Rute riwayat dipindahkan ke atas agar diprioritaskan oleh Laravel
Route::get('/riwayat', function () {
    // Mengambil semua transaksi yang statusnya 'Selesai' dengan Join Tabel yang benar
    $riwayatTransaksi = DB::table('transaksi')
                        ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                        ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                        ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                        ->select(
                            'pelanggan.nama as nama_pelanggan',
                            'detail_layanan.file_dokumen',
                            'detail_layanan.jumlah_halaman',
                            'pembayaran.metode',
                            'detail_layanan.status_antrean',
                            'transaksi.updated_at'
                        )
                        ->where('detail_layanan.status_antrean', '=', 'Selesai')
                        ->orderBy('transaksi.updated_at', 'desc')
                        ->get();

    return view('riwayat', compact('riwayatTransaksi'));
});

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
                            'detail_layanan.status_antrean'
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
