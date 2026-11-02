@extends('layouts.app')

@section('title', 'Daftar Aspirasi - Pengaduan')

@section('content')
<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-12">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900">Aspirasi warga</h1>
            <p class="mt-2 text-base text-gray-700">Aspirasi yang bisa dibaca, didukung, dan didiskusikan siapa saja.</p>
        </div>
        @unless(auth()->user()?->isAdmin())
            <a href="{{ route('aspirasi.create') }}"
               class="inline-flex items-center justify-center min-h-11 px-5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-md">
                Tulis Aspirasi
            </a>
        @endunless
    </div>

    @if(session('success'))
        <div data-flash role="status" class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div data-flash role="alert" class="mt-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ session('error') }}</div>
    @endif

    <form action="{{ route('aspirasi.index') }}" method="GET" role="search"
          class="mt-8 grid grid-cols-1 sm:grid-cols-[1fr_11rem_9rem_auto] gap-3">
        <div>
            <label for="search" class="sr-only">Cari aspirasi</label>
            <input type="search" name="search" id="search" value="{{ request('search') }}" placeholder="Cari judul atau isi"
                   class="w-full min-h-11 px-3 text-sm border border-gray-300 rounded-md bg-white focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600">
        </div>
        <div>
            <label for="category_id" class="sr-only">Kategori</label>
            <select name="category_id" id="category_id"
                    class="w-full min-h-11 px-3 text-sm border border-gray-300 rounded-md bg-white focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600">
                <option value="">Semua kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="sort" class="sr-only">Urutkan</label>
            <select name="sort" id="sort"
                    class="w-full min-h-11 px-3 text-sm border border-gray-300 rounded-md bg-white focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600">
                <option value="latest" {{ request('sort') !== 'popular' ? 'selected' : '' }}>Terbaru</option>
                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling didukung</option>
            </select>
        </div>
        <button type="submit" class="min-h-11 px-5 text-sm font-semibold text-indigo-700 bg-white border border-indigo-600 hover:bg-indigo-50 transition-colors rounded-md">
            Terapkan
        </button>
    </form>

    @if(request('search') || request('category_id'))
        <p class="mt-4 text-sm text-gray-700">
            {{ $aspirations->total() }} aspirasi ditemukan.
            <a href="{{ route('aspirasi.index') }}" class="inline-flex items-center min-h-11 font-semibold text-indigo-700 underline underline-offset-4">Hapus filter</a>
        </p>
    @endif

    <div class="mt-8 border-t-2 border-gray-900">
        @forelse($aspirations as $aspiration)
            <article class="py-6 border-b border-gray-200">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <x-doc-no :id="$aspiration->id" />
                    <span class="text-xs font-semibold text-gray-700 bg-gray-100 rounded px-1.5 py-0.5">{{ $aspiration->category->nama_kategori ?? 'Umum' }}</span>
                    <span class="text-xs text-gray-600">{{ $aspiration->created_at->diffForHumans() }}</span>
                </div>
                <h2 class="mt-2 font-serif text-xl sm:text-2xl font-semibold leading-snug break-words">
                    <a href="{{ route('aspirasi.show', $aspiration) }}" class="text-gray-900 hover:text-indigo-700">{{ $aspiration->judul }}</a>
                </h2>
                <p class="mt-2 text-sm text-gray-700 leading-relaxed line-clamp-2 break-words">{{ $aspiration->isi }}</p>
                <p class="mt-3 text-sm text-gray-600">
                    <span class="font-semibold text-emerald-800">{{ $aspiration->upvote }} setuju</span>
                    <span aria-hidden="true"> · </span>
                    <span class="font-semibold text-rose-800">{{ $aspiration->downvote }} tidak setuju</span>
                    <span aria-hidden="true"> · </span>
                    {{ $aspiration->comments_count }} komentar
                </p>
            </article>
        @empty
            <div class="py-12">
                @if(request('search') || request('category_id'))
                    <p class="text-base font-semibold text-gray-900">Tidak ada aspirasi yang cocok dengan filter ini.</p>
                    <p class="mt-1 text-sm text-gray-700">Coba kata kunci lain atau pilih semua kategori.</p>
                @else
                    <p class="text-base font-semibold text-gray-900">Belum ada aspirasi yang tercatat.</p>
                    <p class="mt-1 text-sm text-gray-700">Aspirasi pertama akan muncul di sini setelah dikirim.</p>
                @endif
            </div>
        @endforelse
    </div>

    @if($aspirations->hasPages())
        <div class="mt-8">{{ $aspirations->links() }}</div>
    @endif
</div>
@endsection
