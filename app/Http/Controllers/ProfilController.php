<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Operator; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id, 
            'password' => 'nullable|min:6'
        ]);

        // Update Data User (Tabel users: Email & Password)
        $user->email = $request->email;
        
        // Cek jika kolom password diisi, maka enkripsi lalu simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Update Data Operator (Tabel operators: Nama)
        $operator = Operator::where('user_id', $user->id)->first();
        if ($operator) {
            $operator->nama = $request->nama;
            $operator->save();
        }

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}