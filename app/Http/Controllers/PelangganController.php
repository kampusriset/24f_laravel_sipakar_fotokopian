<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // READ
    public function index()
    {
        $pelanggan = Pelanggan::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $pelanggan
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        // Untuk mengecek sudah ada data pelanggan atau belum
        $pelanggan->nama = $request->nama ?? $pelanggan->nama;
        $pelanggan->no_hp = $request->no_hp ?? $pelanggan->no_hp;
        $pelanggan->alamat = $request->alamat ?? $pelanggan->alamat;
        $pelanggan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pelanggan berhasil diperbarui',
            'data' => $pelanggan
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        try {
            $pelanggan->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pelanggan tidak bisa dihapus karena masih memiliki riwayat transaksi di kasir.'
            ], 400);
        }
    }
}