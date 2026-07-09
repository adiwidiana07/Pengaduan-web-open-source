@extends('layouts.app')

@section('title', 'Verifikasi Token Pemilik - Pengaduan')
@section('page_title', 'Verifikasi Token')

@section('content')
    <div class="max-w-md mx-auto px-4 py-16">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Verifikasi Token Pemilik</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Aspirasi ini bersifat anonim. Masukkan token pemilik untuk memverifikasi hak akses edit atau hapus Anda.
                </p>
            </div>

            @if(session('error') || (isset($error) && $error))
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-xs text-rose-800 shadow-sm flex items-center gap-2">
                    <span>❌</span> {{ session('error') ?? $error }}
                </div>
            @endif

            <form action="{{ route('aspirasi.edit', $aspiration->id) }}" method="GET" class="space-y-4">
                <div>
                    <label for="token" class="block text-sm font-semibold text-gray-700 mb-1">Token Pemilik (UUID)</label>
                    <input type="text" name="token" id="token" required placeholder="Contoh: 123e4567-e89b-12d3-a456-426614174000" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm font-mono">
                </div>

                <button type="submit" class="w-full py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-xl shadow-sm">
                    Verifikasi & Lanjutkan
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <a href="{{ route('aspirasi.show', $aspiration->id) }}" class="font-semibold text-gray-500 hover:text-indigo-600 transition-colors">
                    ← Kembali ke Detail
                </a>
            </div>
        </div>
    </div>
@endsection
