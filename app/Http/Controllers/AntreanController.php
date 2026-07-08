<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailLayanan;

class AntreanController extends Controller
{
    // Ambil data
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

    // Update Status antrean
    public function updateStatus($id) {
        $antrean = DetailLayanan::find($id);

        if (!$antrean) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data antrean tidak ditemukan'
            ], 404);
        }

        $antrean->status_antrean = 'Selesai';
        $antrean->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status berhasil di rubah'
        ]);
    }
}
