<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $layanan = Layanan::all();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'data' => $layanan]);
        }

        return view('admin.layanan', compact('layanan'));
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

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Layanan ditambahkan', 'data' => $layanan]);
        }

        return redirect()->back()->with('success', 'Layanan berhasil ditambahkan!');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan'
                ], 404);
            }
            return redirect()->back()->with('error', 'Layanan tidak ditemukan');
        }

        $layanan->nama_layanan = $request->nama_layanan ?? $layanan->nama_layanan;
        $layanan->harga_per_lembar = $request->harga_per_lembar ?? $layanan->harga_per_lembar;
        $layanan->save();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data diperbarui'
            ], 200);
        }

        return redirect()->back()->with('success', 'Data harga layanan berhasil diperbarui!');
    }

    // DELETE
    public function delete(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan'
                ], 404);
            }

            return redirect()->back()->with('error', 'Layanan tidak ditemukan');
        }

        try {
            $layanan->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Layanan berhasil dihapus'
                ], 200);
            }
            return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            $msg = 'Layanan tidak bisa dihapus karena sudah digunakan dalam transaksi.';

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $msg
                ], 400);
            }

            return redirect()->back()->with('error', $msg);
        }
    }
}
