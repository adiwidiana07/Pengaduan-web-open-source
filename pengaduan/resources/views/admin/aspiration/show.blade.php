@extends('layouts.admin')

@section('title', $aspiration->judul . ' - Detail Aspirasi')
@section('page_title', 'Detail Aspirasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.aspirasi.index') }}"
           class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-6 text-xs text-gray-400 font-semibold">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                        {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                    </span>
                    <span>&bull;</span>
                    <span>Anonim ({{ substr($aspiration->owner_token, 0, 8) }})</span>
                </div>
                <span>{{ $aspiration->created_at->format('d M Y, H:i') }}</span>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">
                {{ $aspiration->judul }}
            </h1>

            <div class="mt-6 text-sm text-gray-700 leading-relaxed whitespace-pre-line border-b border-gray-100 pb-8">
                {{ $aspiration->isi }}
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border border-emerald-200 text-emerald-700 bg-emerald-50">
                    👍 Setuju ({{ $aspiration->upvote }})
                </span>
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border border-rose-200 text-rose-700 bg-rose-50">
                    👎 Tidak Setuju ({{ $aspiration->downvote }})
                </span>
            </div>
        </div>
    </article>

    <section class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">
            Komentar Masyarakat
            <span class="ml-1 text-sm font-semibold text-gray-400">({{ $aspiration->comments->count() }})</span>
        </h2>

        <div class="space-y-4">
            @forelse($aspiration->comments as $comment)
                <div class="flex flex-col p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-400 font-semibold mb-2">
                        <span>Anonim ({{ substr($comment->owner_token, 0, 8) }})</span>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->isi }}</p>
                </div>
            @empty
                <div class="text-center py-10 text-sm text-gray-400">
                    <p class="text-2xl mb-2">💬</p>
                    Belum ada komentar dari masyarakat.
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
