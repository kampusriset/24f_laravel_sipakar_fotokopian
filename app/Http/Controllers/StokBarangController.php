<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $stokBarang = StokBarang::orderBy('created_at', 'desc')->get();

        if($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $stokBarang
            ], 200);
        }

        return view('stokBarang', compact('stokBarang'));
    }

    // CREATE
    public function create(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah_stok' => 'required|integer|min:1',
            'satuan' => 'required|string',
        ]);

        try {
            $barangLama = StokBarang::where('nama_barang', $request->nama_barang)->first();

            if ($barangLama) {
                $barangLama->jumlah_stok += $request->jumlah_stok;
                $barangLama->save();

                if($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Stok ditambahkan (Restock berhasil)',
                        'data' => $barangLama
                    ], 200);
                }
                return redirect()->back()->with('success', 'Stok ditambahkan (Restock berhasil)');
            } else {
                $barangBaru = StokBarang::create([
                    'nama_barang' => $request->nama_barang,
                    'kategori' => $request->kategori,
                    'jumlah_stok' => $request->jumlah_stok,
                    'satuan' => $request->satuan,
                ]);                
                
                if($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Barang baru berhasil ditambahkan.',
                        'data' => $barangBaru
                    ], 201);
                }
                return redirect()->back()->with('success', 'Barang baru berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan barang: '. $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $barang = StokBarang::find($id);

        if (!$barang) {
            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Barang tidak ditemukan'
                ], 404);
            }
            return redirect()->back()->with('error', 'Barang tidak ditemukan');
        }

        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah_stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        try {
            $barang->nama_barang = $request->nama_barang;
            $barang->kategori = $request->kategori;
            $barang->jumlah_stok = $request->jumlah_stok;
            $barang->satuan = $request->satuan;
            $barang->save();

            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data stok barang berhasil diperbarui',
                    'data' => $barang
                ], 200);
            }

            return redirect()->back()->with('success', 'Barang berhasil diperbarui');
        } catch(\Exception $e) {
            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui barang: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }
    }

    // DELETE
    public function delete(Request $request, $id)
    {
        $barang = StokBarang::find($id);

        if (!$barang) {
            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Barang tidak ditemukan'
                ], 404);
            }
            return redirect()->back()->with('error', 'Barang tidak ditemukan');
        }

        try {
            $barang->delete();
            return response()->json([
                'status' => 'success', 
                'message' => 'Barang berhasil dihapus.'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Gagal menghapus barang: ' . $e->getMessage()
            ], 500);
        }
    }
}