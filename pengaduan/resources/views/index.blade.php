@extends('layouts.app')

@section('title', 'Web App Pengaduan - Layanan Aspirasi & Pengaduan Online')

@section('content')
<div class="max-w-3xl mx-auto px-4 text-center py-16 sm:py-24">
    <div class="mb-10">
        <h1 class="text-6xl sm:text-7xl font-extrabold tracking-tight select-none">
            <p class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent"><span class="text-indigo-600">Peng</span>aduan</p>
        </h1>
        <p class="mt-4 text-lg sm:text-xl text-gray-500 font-normal max-w-xl mx-auto leading-relaxed">
            Sampaikan aspirasi dan pengaduan Anda secara cepat, transparan, dan terpercaya.
        </p>
    </div>

    <div class="flex flex-row items-center justify-center gap-3 sm:gap-4">
        <a href="/aspirasi/create" class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
            Buat Pengaduanmu
        </a>
        <a href="/aspirasi" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition-colors rounded-lg shadow-sm">
            Lihat Pengaduan
        </a>
    </div>

    <div class="mt-16 flex flex-wrap justify-center gap-x-6 gap-y-2 text-xs text-gray-400">
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
            <span>100% Anonim & Aman</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>Respon Cepat</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-violet-500"></span>
            <span>Transparan</span>
        </div>
    </div>
</div>
@endsection
