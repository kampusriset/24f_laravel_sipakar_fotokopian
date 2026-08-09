<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function RegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kasir' 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => $request->role,
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function LoginForm()
    {
        if (Auth::check()) {
            $role = strtolower(Auth::user()->role ?? '');

            if ($role === 'admin') {
                return redirect('/admin'); 
            } elseif ($role === 'kasir') {
                return redirect('/home'); 
            }

            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Sesi tidak valid, silakan login ulang.']);
        }
        
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower($user->role ?? ''); 

            if ($role === 'admin') {
                return redirect('/admin'); 
            } elseif ($role === 'kasir') {
                return redirect('/home'); 
            }
            
            Auth::logout();
            return back()->withErrors(['email' => 'Role akun Anda tidak valid.']);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}