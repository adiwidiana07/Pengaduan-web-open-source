@extends('layouts.app')

@section('title', 'Daftar Akun - Pengaduan')

@section('content')
<div class="w-full max-w-md mx-auto px-4 py-8">
    <div class="bg-white border border-gray-200/80 rounded-lg p-6 sm:p-8">
        <div class="text-center mb-6">
            <h1 class="font-serif text-3xl font-bold text-gray-900">Daftar Akun</h1>
            <p class="mt-2 text-sm text-gray-500">Akun dipakai untuk mengelola aspirasi Anda sendiri.</p>
        </div>

        <div class="mb-6 rounded-md bg-indigo-50 px-4 py-3 text-xs text-indigo-900 leading-relaxed">
            Aspirasi tetap tampil sebagai <strong>Anonim</strong>. Nama dan email Anda tidak ditampilkan di aspirasi, dan admin tidak dapat melihat akun mana yang menulis aspirasi tertentu.
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5" data-loading>
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="100" autocomplete="nickname"
                    class="w-full px-4 py-2.5 border @error('name') border-red-300 @else border-gray-200 @enderror rounded-md text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <p class="mt-1.5 text-xs text-gray-500">Hanya terlihat oleh Anda di akun ini. Nama panggilan pun boleh.</p>
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-4 py-2.5 border @error('email') border-red-300 @else border-gray-200 @enderror rounded-md text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" required autocomplete="new-password" minlength="8"
                    class="w-full px-4 py-2.5 border @error('password') border-red-300 @else border-gray-200 @enderror rounded-md text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <p class="mt-1.5 text-xs text-gray-500">Minimal 8 karakter.</p>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-md text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full py-2.5 px-4 min-h-11 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">
                Buat Akun
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:underline">Masuk</a>
        </p>
    </div>
</div>
@endsection
