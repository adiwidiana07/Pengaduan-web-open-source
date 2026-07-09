@extends('layouts.app')

@section('title', 'Aspirasi Terkirim - Pengaduan')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-16 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Aspirasi Berhasil Dikirim!</h1>
        <p class="mt-3 text-sm text-gray-500">Aspirasi Anda telah terbit secara publik. Terima kasih atas partisipasi Anda.</p>

        <div class="mt-8 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm text-left">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Token Pemilik Anda (Owner Token)</h2>
            <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                Gunakan token di bawah ini jika Anda ingin mengedit atau menghapus aspirasi ini di masa mendatang. Jangan bagikan token ini kepada orang lain.
            </p>

            <div class="mt-4 flex items-center gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                <code class="flex-1 text-sm font-mono text-indigo-600 select-all font-semibold overflow-x-auto whitespace-nowrap">{{ $token }}</code>
                <button data-clipboard="{{ $token }}"
                        class="text-xs font-semibold text-gray-500 hover:text-indigo-600 bg-white border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors">
                    Salin
                </button>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('aspirasi.show', $aspiration->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
                Lihat Detail Aspirasi
            </a>
            <a href="{{ route('aspirasi.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition-colors rounded-lg shadow-sm">
                Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
