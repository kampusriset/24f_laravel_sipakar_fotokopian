<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/layanan', [ApiController::class, 'getLayanan']);
Route::get('/antrean', [ApiController::class, 'getAntrean']);