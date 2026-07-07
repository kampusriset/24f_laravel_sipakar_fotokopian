<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\TransaksiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/antrean', [AntreanController::class, 'index']);
Route::put('/antrean/{id}/status', [AntreanController::class, 'updateStatus']);
Route::get('/master-data', [TransaksiController::class, 'getMasterData']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'create']);
});
Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
