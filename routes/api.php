<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PerangkatPrinterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/antrean', [AntreanController::class, 'index']);
Route::get('/master-data', [TransaksiController::class, 'getMasterData']);
Route::get('/printer', [PerangkatPrinterController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // Manajemen Transaksi
    Route::post('/transaksi', [TransaksiController::class, 'create']);
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete']);

    // Manajemen Antrean
    Route::put('/antrean/{id}/status', [AntreanController::class, 'updateStatus']);

    // Manajemen Printer
    Route::post('/printer', [PerangkatPrinterController::class, 'create']);
    Route::put('/printer/{id}', [PerangkatPrinterController::class, 'update']);
    Route::delete('/printer/{id}', [PerangkatPrinterController::class, 'delete']);

    // Manajemen Stok Barang?
    // Manajemen Operator?
    // Manajemen Layanan?
    // Manajemen Pelanggan?
});
