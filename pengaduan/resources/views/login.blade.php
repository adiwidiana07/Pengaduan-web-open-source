@extends('layouts.app')

@section('title', 'Masuk - Pengaduan')

@section('content')
<div class="w-full max-w-md mx-auto px-4 py-8">
    <div class="bg-white border border-gray-200/80 rounded-lg p-6 sm:p-8">
        <div class="text-center mb-8">
            <h1 class="font-serif text-3xl font-bold text-gray-900">Masuk</h1>
            <p class="mt-2 text-sm text-gray-500">Masuk untuk mengirim, mengubah, atau melaporkan aspirasi.</p>
        </div>

        @if(session('success'))
            <div data-flash role="status" class="mb-6 p-4 rounded-md bg-green-50 border border-green-200 text-sm text-green-700 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6" data-loading>
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-4 py-2.5 border @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-md text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 transition-colors">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 border @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-md text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 transition-colors pr-12">
                    <button type="button" data-toggle-password="password" aria-label="Tampilkan password"
                        class="absolute right-1 top-1/2 -translate-y-1/2 w-10 h-10 text-gray-500 hover:text-gray-700 text-sm">
                        &#128065;
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" value="1" class="w-4 h-4 accent-indigo-600">
                Ingat saya
            </label>

            <button type="submit"
                class="w-full py-2.5 px-4 min-h-11 border border-transparent rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">
                Masuk ke Akun
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
