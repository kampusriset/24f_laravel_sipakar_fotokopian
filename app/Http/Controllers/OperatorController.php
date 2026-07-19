<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    // READ
    public function index()
    {
        $operators = Operator::with('user')->get();

        return view('admin.operator', compact('operators'));
    }

    // CREATE
    public function create(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,kasir'
        ]);

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            Operator::create([
                'nama'    => $request->nama,
                'user_id' => $user->id
            ]);
        });

        return redirect()->back()->with('success', 'Karyawan berhasil didaftarkan');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $operator = Operator::findOrfail($id);
        $user = $operator->user;

        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($request, $operator, $user) {
            $operator->update(['nama' => $request->nama]);

            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        });

        return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui');
    }

    // DELETE
    public function delete($id)
    {
        $operator = Operator::findOrfail($id);
        $user = $operator->user;

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri saat sedang login!');
        }

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Admin tidak bisa dihapus!');
        }

        $operator->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Akses karyawan berhasil dicabut/dihapus');
    }
}
