<?php

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\pembayaran;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function() {
    $transaksiTerbaru = Transaksi::with(['pelanggan', 'pembayaran'])
                        ->orderBy('created_at', 'desc')
                        ->take(5) 
                        ->get();

    $daftarLayanan = Layanan::all();

    return view('home', compact('transaksiTerbaru', 'daftarLayanan'));
});

Route::get('/transaksi', function () {
    return view('transaksi');
});

