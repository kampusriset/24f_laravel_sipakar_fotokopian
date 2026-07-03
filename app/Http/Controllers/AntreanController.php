<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailLayanan;

class AntreanController extends Controller
{
    public function index() {
        $antrean = DetailLayanan::with(['layanan', 'transaksi.pelanggan', 'transaksi.operator'])
                    ->where('status_antrean', 'Menunggu')
                    ->orderBy('waktu_deadline', 'asc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $antrean
        ]);
    }
}
