<?php

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;

Route::get('/riwayat', function () { //DIPINDAH KE DALAM CONTROLLER CEK ROUTE BAGIAN TRANSAKSI, DIBIKIN GITU AE BIAR CLEAN KODENE
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

// Read part Home
Route::get('/', [HomeController::class, 'index']);

// Manajemen Transaksi
Route::get('/transaksi', [TransaksiController::class, 'getMasterData'])->name('transaksi.getMasterData');
Route::post('/transaksi', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');

// Manajemen Stok Barang
Route::get('/stok-barang', [StokBarangController::class, 'index'])->name('stok.index');
Route::post('/stok-barang', [StokBarangController::class, 'create'])->name('stok.create');
Route::put('/stok-barang/{id}', [StokBarangController::class, 'update'])->name('stok.update');
Route::delete('/stok-barang/{id}', [StokBarangController::class, 'destroy'])->name('stok.delete');
