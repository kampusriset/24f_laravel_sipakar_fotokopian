<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $pelanggans = Pelanggan::orderBy('created_at', 'desc')->get();
        
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $pelanggans
            ]);
        }

        return view('admin.pelanggan', compact('pelanggans'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Pelanggan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
        }

        // Update data
        $pelanggan->nama = $request->nama ?? $pelanggan->nama;
        $pelanggan->no_hp = $request->no_hp ?? $pelanggan->no_hp;
        $pelanggan->alamat = $request->alamat ?? $pelanggan->alamat;
        $pelanggan->save();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data pelanggan berhasil diperbarui',
                'data' => $pelanggan
            ]);
        }
        
        return redirect()->back()->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // DELETE
    public function delete(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Pelanggan tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
        }

        try {
            $pelanggan->delete();
            
            if ($request->expectsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Data pelanggan berhasil dihapus']);
            }
            
            return redirect()->back()->with('success', 'Data pelanggan berhasil dihapus.');
            
        } catch (\Exception $e) {
            $pesanError = 'Pelanggan tidak bisa dihapus karena masih memiliki riwayat transaksi di sistem.';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => $pesanError
                ], 400);
            }
            
            return redirect()->back()->with('error', $pesanError);
        }
    }
}