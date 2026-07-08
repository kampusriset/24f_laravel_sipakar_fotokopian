<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

// TESTIMONI DULU BUAT RESTOK BARANGNYA WORK ATO GA | KALO GA BISA COBA PKEK LOGIKA UPDATE
class StokBarangController extends Controller
{
    // READ
    public function index()
    {
        $stok = StokBarang::all();
        return response()->json([
            'status' => 'success',
            'data' => $stok
        ]);
    }

    // CREATE
    public function create(Request $request)
    {
        // Validasi input database
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah_stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        // $barang = StokBarang::create([
        //     'nama_barang' => $request->nama_barang,
        //     'kategori' => $request->kategori,
        //     'jumlah_stok' => $request->jumlah_stok,
        //     'satuan' => $request->satuan,
        // ]);

        // Logika kalo input barang yang sudah ada (restok) nanti akan menambahkan otomatis tanpa membuat data lagi
        $barangLama = StokBarang::where('nama_barang', $request->nama_barang)->first();

        if ($barangLama) {
            // tambahkan stok lama dengan stok inputan baru 
            $barangLama->jumlah_stok += $request->jumlah_stok;
            $barangLama->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Stok ditambahkan (Restock berhasil)',
                'data' => $barangLama
            ]);
        }

        $barangBaru = StokBarang::create([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah_stok' => $request->jumlah_stok,
            'satuan' => $request->satuan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Barang baru berhasil ditambahkan.',
            'data' => $barangBaru
        ]);
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
        }

        // Jika input kosong, dia akan pakai data yang lama (??)
        $barang->nama_barang = $request->nama_barang ?? $barang->nama_barang;
        $barang->kategori = $request->kategori ?? $barang->kategori;
        $barang->jumlah_stok = $request->jumlah_stok ?? $barang->jumlah_stok;
        $barang->satuan = $request->satuan ?? $barang->satuan;
        $barang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data stok barang berhasil diperbarui',
            'data' => $barang
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $barang = StokBarang::find($id);

        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil dihapus.'
        ]);
    }
}