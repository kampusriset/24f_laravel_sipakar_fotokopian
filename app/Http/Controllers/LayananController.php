<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // READ
    public function index()
    {
        $layanan = Layanan::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $layanan
        ]);
    }

    // CREATE
    public function create(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string',
            'harga_per_lembar' => 'required|numeric',
        ]);

        $layanan = Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_per_lembar' => $request->harga_per_lembar,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Layanan baru berhasil ditambahkan',
            'data' => $layanan
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Layanan tidak ditemukan'
            ], 404);
        }

        // Untuk Update jika ada datanya (?? Null Coalescing Operator)
        $layanan->nama_layanan = $request->nama_layanan ?? $layanan->nama_layanan;
        $layanan->harga_per_lembar = $request->harga_per_lembar ?? $layanan->harga_per_lembar;
        $layanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data layanan/harga berhasil diperbarui',
            'data' => $layanan
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Layanan tidak ditemukan'
            ], 404);
        }

        $layanan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Layanan berhasil dihapus.'
        ]);
    }
}