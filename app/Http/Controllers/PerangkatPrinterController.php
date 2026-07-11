<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerangkatPrinter;

class PerangkatPrinterController extends Controller
{
    public function index() {
        $printers = PerangkatPrinter::all();

        return response()->json([
            'status' => 'success',
            'data' => $printers
        ]);
    }

    public function create(Request $request) {
        $printer = PerangkatPrinter::create([
            'nama_printer' => $request->nama_printer,
            'status' => $request->status ?? 'Aktif'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Perangkat printer berhasil ditambahkan',
            'data' => $printer
        ]);
    }

    public function update(Request $request, $id) {
        $printer = PerangkatPrinter::find($id);

        if (!$printer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perangkat printer tidak ditemukan'
            ], 404);
        }

        // Untuk Update jika ada datanya (?? Null Coalescing Operator)
        $printer->nama_printer = $request->nama_printer ?? $printer->naam_printer;
        $printer->status = $request->status ?? $printer->status;
        $printer->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data printer berhasil diperbarui',
            'data' => $printer
        ]);
    }

    public function delete($id) {
        $printer = PerangkatPrinter::find($id);

        if (!$printer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perangkat printer tidak ditemukan'
            ], 404);
        }

        $printer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Perangkat printer berhasil dihapus'
        ]);
    }
}
