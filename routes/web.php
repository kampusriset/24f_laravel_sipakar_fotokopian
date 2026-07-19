<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokBarangController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

// Manajemen Users
Route::get('/register', [AuthController::class, 'RegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'LoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route Bisa diakses Kasir & Admin
Route::middleware(['auth'])->group(function () {
    // Home & Logout
    Route::get('/home', [HomeController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Manajemen Transaksi (Kasir bisa Read, Create, Update)
    Route::get('/transaksi', [TransaksiController::class, 'getMasterData'])->name('transaksi.index');
    Route::post('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');

    // Manajemen Stok Barang (Kasir bisa Read & Update)
    Route::get('/stok-barang', [StokBarangController::class, 'index'])->name('stok.index');
    Route::put('/stok-barang/{id}', [StokBarangController::class, 'update'])->name('stok.update');

    // Riwayat Transaksi
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});

// Route Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route Transaksi
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');

    // Route Stok Barang
    Route::post('/stok-barang', [StokBarangController::class, 'create'])->name('stok.create');
    Route::delete('/stok-barang/{id}', [StokBarangController::class, 'destroy'])->name('stok.delete');

    // Manajemen Laporan
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf']);
});
