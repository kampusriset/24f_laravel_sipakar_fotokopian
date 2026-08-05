<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
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

            if ($user->google_id == null || $user->email_verified_at == null) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                    ]);
            }

            Auth::login($user);

            return redirect('/home');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan saat memproses otentikasi Google.');
        }
    }
}
