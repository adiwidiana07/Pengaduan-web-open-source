<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->homeFor(Auth::user()));
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        // Admin hanya kembali ke halaman dashboard; warga tidak pernah diarahkan ke dashboard.
        $intended = (string) $request->session()->get('url.intended', '');
        $intendedIsDashboard = str_starts_with(parse_url($intended, PHP_URL_PATH) ?? '', '/dashboard');
        if ($intended !== '' && $request->user()->isAdmin() !== $intendedIsDashboard) {
            $request->session()->forget('url.intended');
        }

        return redirect()->intended($this->homeFor($request->user()));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }

    private function homeFor($user): string
    {
        return $user->isAdmin() ? '/dashboard' : route('my.aspirations');
    }
}
