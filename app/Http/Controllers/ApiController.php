<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\DetailLayanan;

class ApiController extends Controller
{
    // Ambil data jenis layanan
    public function getLayanan() {
        $layanan = Layanan::all();

        return response()->json([
            'status' => 'success',
            'data' => $layanan,
        ]);
    }

    public function getAntrean() {
        $antrean = DetailLayanan::with(['layanan', 'transaksi.pelanggan', 'transaksi.operator'])
                    ->where('status_antrean', 'Menunggu')
                    ->orderBy('waktu_deadline', 'asc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $antrean,
        ]);
    }
}
