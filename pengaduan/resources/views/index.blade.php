@extends('layouts.app')

@section('title', 'Pengaduan - Aspirasi dan Pengaduan Warga')

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-12 sm:py-20">

    {{-- Focal point: what this place is and the one action that matters --}}
    <section aria-labelledby="hero-title">
        <h1 id="hero-title" class="font-serif text-4xl sm:text-5xl font-bold leading-tight text-gray-900">
            Sampaikan aspirasi untuk lingkungan Anda.
        </h1>
        <p class="mt-5 text-lg text-gray-700 leading-relaxed max-w-2xl">
            Tulis keluhan atau usulan, lalu warga lain bisa mendukung dan berdiskusi. Aspirasi tampil sebagai Anonim, dan admin pun tidak dapat melihat siapa penulisnya.
        </p>
        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3">
            @unless(auth()->user()?->isAdmin())
                <a href="{{ route('aspirasi.create') }}"
                   class="inline-flex items-center justify-center min-h-11 px-6 text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-md">
                    Tulis Aspirasi
                </a>
            @endunless
            <a href="{{ route('aspirasi.index') }}" class="inline-flex items-center min-h-11 text-base font-semibold text-indigo-700 hover:text-indigo-900 underline underline-offset-4">
                Baca semua aspirasi warga
            </a>
        </div>
    </section>

    {{-- Real content: the register of latest aspirations --}}
    <section aria-labelledby="latest-title" class="mt-16 sm:mt-20">
        <div class="flex items-baseline justify-between gap-4 border-b-2 border-gray-900 pb-2">
            <h2 id="latest-title" class="font-serif text-2xl font-semibold text-gray-900">Aspirasi terbaru</h2>
            @if($latest->isNotEmpty())
                <a href="{{ route('aspirasi.index') }}" class="inline-flex items-center min-h-11 text-sm font-semibold text-indigo-700 hover:underline">Lihat semua</a>
            @endif
        </div>

        @if($latest->isEmpty())
            <div class="py-10">
                <p class="text-base text-gray-700">Belum ada aspirasi yang tercatat.</p>
                @unless(auth()->user()?->isAdmin())
                    <p class="mt-1 text-sm text-gray-600">Aspirasi pertama akan muncul di sini setelah dikirim.</p>
                @endunless
            </div>
        @else
            <ol class="divide-y divide-gray-200">
                @foreach($latest as $aspiration)
                    <li class="py-5">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                            <x-doc-no :id="$aspiration->id" />
                            <span class="text-xs text-gray-600">{{ $aspiration->category->nama_kategori ?? 'Umum' }}</span>
                            <span class="text-xs text-gray-600">{{ $aspiration->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <h3 class="mt-1 font-serif text-xl font-semibold leading-snug break-words">
                            <a href="{{ route('aspirasi.show', $aspiration) }}" class="text-gray-900 hover:text-indigo-700">{{ $aspiration->judul }}</a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $aspiration->upvote }} setuju · {{ $aspiration->downvote }} tidak setuju · {{ $aspiration->comments_count }} komentar
                        </p>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>

    {{-- The question every citizen asks before writing --}}
    <section aria-labelledby="privacy-title" class="mt-16 rounded-lg bg-indigo-50 px-6 py-6">
        <h2 id="privacy-title" class="font-serif text-xl font-semibold text-indigo-900">Siapa yang bisa tahu saya yang menulis?</h2>
        <p class="mt-2 text-sm text-indigo-950 leading-relaxed">
            Tidak ada yang melihat nama atau email Anda pada aspirasi. Database hanya menyimpan kode acak sebagai penanda pemilik, sehingga admin tidak dapat menghubungkan aspirasi ke akun Anda.
        </p>
        <a href="/about#privasi" class="mt-3 inline-flex items-center min-h-11 text-sm font-semibold text-indigo-800 underline underline-offset-4">Baca cara kerjanya</a>
    </section>
</div>
@endsection
