<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // role tidak mass-assignable; akun dari form publik selalu berperan 'user'.
        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('my.aspirations'))->with('success', 'Akun berhasil dibuat. Sekarang Anda bisa menulis aspirasi dan berkomentar.');
    }
}
