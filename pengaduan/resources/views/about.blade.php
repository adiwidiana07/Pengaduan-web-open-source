@extends('layouts.app')

@section('title', 'Tentang Kami - Pengaduan')

@section('content')
<div class="bg-[#fafafa]">
    <!-- Hero Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
            Tentang <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Pengaduan</span>
        </h1>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Menjembatani aspirasi masyarakat dengan transparansi penuh untuk menciptakan perubahan positif di lingkungan sekitar.
        </p>
    </div>

    <!-- Mission & Vision -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white border border-gray-200/80 p-8 rounded-2xl shadow-sm">
                <div class="text-3xl mb-4">🎯</div>
                <h2 class="text-xl font-bold text-gray-900">Misi Kami</h2>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Memberikan wadah penyampaian keluhan dan aspirasi publik secara gratis, aman, dan tanpa hambatan birokrasi yang rumit demi perbaikan sarana pelayanan publik.
                </p>
            </div>
            <div class="bg-white border border-gray-200/80 p-8 rounded-2xl shadow-sm">
                <div class="text-3xl mb-4">🛡️</div>
                <h2 class="text-xl font-bold text-gray-900">Privasi & Keamanan</h2>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Kami sangat mengutamakan anonimitas pelapor. Sistem kami tidak melacak identitas pribadi Anda, melainkan menggunakan token unik agar Anda dapat memantau aspirasi secara aman.
                </p>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white border-t border-b border-gray-200/80 py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 text-center tracking-tight">Cara Kerja Platform</h2>
            <p class="mt-2 text-sm text-gray-500 text-center">Tiga langkah mudah menyampaikan suara Anda.</p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4 border border-indigo-100">
                        1
                    </div>
                    <h3 class="font-bold text-gray-900">Tulis Aspirasi</h3>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed px-4">
                        Isi judul, pilih kategori keluhan, dan deskripsikan aspirasi Anda dengan detail.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4 border border-indigo-100">
                        2
                    </div>
                    <h3 class="font-bold text-gray-900">Pantau & Bagikan</h3>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed px-4">
                        Dapatkan token kepemilikan unik setelah mengirim untuk memantau diskusi dan respon dari pihak berwenang.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-lg font-bold mx-auto mb-4 border border-indigo-100">
                        3
                    </div>
                    <h3 class="font-bold text-gray-900">Dapatkan Respon</h3>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed px-4">
                        Aspirasi didukung publik melalui voting serta dibahas bersama secara transparan hingga mendapat tanggapan admin.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Section -->
    <div class="max-w-4xl mx-auto px-4 py-16 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Siap untuk Bersuara?</h2>
        <p class="mt-2 text-sm text-gray-500">Kirim keluhan atau dukung aspirasi masyarakat sekarang juga.</p>
        <div class="mt-6 flex justify-center gap-3">
            <a href="/aspirasi/create" class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
                Tulis Aspirasi
            </a>
            <a href="/aspirasi" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition-colors rounded-lg shadow-sm">
                Lihat Daftar Suara
            </a>
        </div>
    </div>
</div>
@endsection
