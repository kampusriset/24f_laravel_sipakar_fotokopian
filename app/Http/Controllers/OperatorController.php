<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    // READ
    public function index()
    {
        $operators = Operator::select('id', 'nama', 'email', 'created_at')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $operators
        ]);
    }

    // CREATE
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:operator,email',
            'password' => 'required|string|min:6',
        ]);

        $operator = Operator::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Karyawan berhasil didaftarkan',
            'data' => [
                'id' => $operator->id,
                'nama' => $operator->nama,
                'email' => $operator->email
            ]
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $operator = Operator::find($id);

        if (!$operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        if ($request->email && $request->email !== $operator->email) {
            $request->validate(['email' => 'unique:operator,email']);
        }

        $operator->nama = $request->nama ?? $operator->nama;
        $operator->email = $request->email ?? $operator->email;
        
        // reset password karyawan VIA admin
        if ($request->password) {
            $operator->password = Hash::make($request->password);
        }
        
        $operator->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diperbarui'
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $operator = Operator::find($id);

        if (!$operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        if ($id == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin tidak bisa dihapus!'
            ], 403);
        }

        $operator->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Akses karyawan berhasil dicabut/dihapus'
        ]);
    }
}