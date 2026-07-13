<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

// TESTIMONI DULU BUAT RESTOK BARANGNYA WORK ATO GA | KALO GA BISA COBA PKEK LOGIKA UPDATE
class StokBarangController extends Controller
{
    // READ
    public function index(Request $request)
    {
        // $stok = StokBarang::all();
        $barang = StokBarang::orderBy('created_at', 'desc')->get();

        if($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ], 200);
        }

        return view('barang.index', compact('barang'));
    }

    // CREATE
    public function create(Request $request)
    {
        // Validasi input database
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah_stok' => 'required|integer|min:1',
            'satuan' => 'required|string',
        ]);

        try {
            // Logika kalo input barang yang sudah ada (restok) nanti akan menambahkan otomatis tanpa membuat data lagi
            $barangLama = StokBarang::where('nama_barang', $request->nama_barang)->first();

            if ($barangLama) {
                // tambahkan stok lama dengan stok inputan baru 
                $barangLama->jumlah_stok += $request->jumlah_stok;
                $barangLama->save();

                if($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Stok ditambahkan (Restock berhasil)',
                        'data' => $barangLama
                    ], 200);
                }

                return redirect()->back()->with('success', 'Stok ditambahakan (Restock berhasil)');
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
                    'message' => 'Gagall menyimpan barang: '. $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyimpman barang: ' . $e->getMessage());
        }
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $barang = StokBarang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan'
            ], 404);

            return redirect()->back()->with('error', 'Barang tidak ditemukan');
        }

        // Validasi Update Data
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah_stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        try {
            // $barang->update($request->all());

            // Untuk Update jika ada datanya
            $barang->nama_barang = $request->nama_barang ?? $barang->nama_barang;
            $barang->kategori = $request->kategori ?? $barang->kategori;
            $barang->jumlah_stok = $request->jumlah_stok ?? $barang->jumlah_stok;
            $barang->satuan = $request->satuan ?? $barang->satuan;
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
            if($request->excptsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui barang: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }
    }

    // DELETE
    public function delete($id)
    {
        $barang = StokBarang::find($id);

        if (!$barang) {
            if($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Barang tidak ditemukan'
                ], 404);
            }
        }

        try {
            $barang->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil dihapus.'
            ], 200);
        } catch(\Exception $e) {
            if($request->expectsJson()) {
                return response()->json([
                    'statis' => 'error',
                    'message' => 'Gagal menghapus barang: ' . $e->getMesage()
                ], 500);

                return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
            }
        }
    }
}