<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // public function redirect()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function callback()
    // {
    //     try {
    //         $googleUser = Socialite::driver('google')->user();

    //         // Cek apakah email tersebut sudah didaftarkan oleh Admin
    //         $registeredUser = User::where('email', $googleUser->getEmail())->first();

    //         if ($registeredUser) {
    //             $registeredUser->update([
    //                 'google_id' => $googleUser->getId(),
    //             ]);

    //             Auth::login($registeredUser);

    //             return redirect('/home');

    //         } else {
    //             return redirect('/login')->with('error', 'Akses ditolak! Email Anda tidak terdaftar di sistem POS.');
    //         }

    //     } catch (\Exception $e) {
    //         return redirect('/login')->with('error', 'Terjadi kesalahan saat mencoba login dengan Google.');
    //     }
    // }

    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                return redirect('/login')
                    ->with(
                        'error',
                        'Silakan register terlebih dahulu.'
                    );
            }

            if ($user->google_id == null) {
                $user->update([
                    'google_id' => $googleUser->id,
                    ]);
            }

            Auth::login($user);

            return redirect('/home');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan saat memproses otentikasi Google.');
        }
    }
}
