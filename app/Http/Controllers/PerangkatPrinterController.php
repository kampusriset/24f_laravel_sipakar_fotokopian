<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerangkatPrinter;

class PerangkatPrinterController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $printer = PerangkatPrinter::all();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'data' => $printer]);
        }

        return view('admin.perangkatPrinter', compact('printer'));
    }

    // CREATE
    public function create(Request $request)
    {
        $request->validate([
            'nama_printer' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Perbaikan',
        ]);

        $printer = PerangkatPrinter::create([
            'nama_printer' => $request->nama_printer,
            'status' => $request->status ?? 'Aktif'
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Printer berhasil ditambahkan',
                'data' => $printer
            ], 201);
        }

        return redirect()->back()->with('success', 'Perangkat printer berhasil ditambahkan!');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $printer = PerangkatPrinter::find($id);

        if (!$printer) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Printer tidak ditemukan'
                ], 404);
            }
            return redirect()->back()->with('error', 'Perangkat printer tidak ditemukan');
        }

        $request->validate([
            'nama_printer' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Perbaikan',
        ]);

        $printer->nama_printer = $request->nama_printer;
        $printer->status = $request->status;
        $printer->save();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data printer berhasil diperbarui',
                'data' => $printer
            ], 200);
        }

        return redirect()->back()->with('success', 'Data printer berhasil diperbarui!');
    }

    // DELETE
    public function delete(Request $request, $id)
    {
        $printer = PerangkatPrinter::find($id);

        if (!$printer) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Printer tidak ditemukan'
                ], 404);
            }
            return redirect()->back()->with('error', 'Printer tidak ditemukan');
        }

        $printer->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Printer berhasil dihapus'
            ], 200);
        }

        return redirect()->back()->with('success', 'Perangkat printer berhasil dihapus');
    }
}
