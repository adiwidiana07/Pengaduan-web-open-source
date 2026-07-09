@extends('layouts.app')

@section('title', 'Daftar Aspirasi - Pengaduan')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Daftar Aspirasi & Pengaduan</h1>
                <p class="mt-2 text-sm text-gray-500">Kumpulan aspirasi dari masyarakat secara transparan, demokratis, dan real-time.</p>
            </div>
            <a href="{{ route('aspirasi.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
                + Kirim Aspirasi Baru
            </a>
        </div>

        @if(session('success'))
            <div data-flash class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div data-flash class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-8 bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('aspirasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Cari Aspirasi</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" placeholder="Cari berdasarkan judul atau isi..." value="{{ request('search') }}" class="w-full pl-4 pr-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm">
                    </div>
                </div>

                <div>
                    <label for="category_id" class="sr-only">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <select name="sort" class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm">
                        <option value="latest" {{ request('sort') !== 'popular' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-xl shadow-sm">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($aspirations as $aspiration)
                <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">
                                {{ $aspiration->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h2 class="text-lg font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                            <a href="{{ route('aspirasi.show', $aspiration->id) }}">
                                {{ $aspiration->judul }}
                            </a>
                        </h2>

                        <p class="mt-3 text-sm text-gray-600 leading-relaxed line-clamp-3">
                            {{ $aspiration->isi }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center gap-4">
                            <span class="inline-flex items-center gap-1 font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                👍 {{ $aspiration->upvote }}
                            </span>
                            <span class="inline-flex items-center gap-1 font-semibold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg">
                                👎 {{ $aspiration->downvote }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-gray-600 bg-gray-50 px-2.5 py-1 rounded-lg">
                                💬 {{ $aspiration->comments->count() }} Komentar
                            </span>
                        </div>
                        <a href="{{ route('aspirasi.show', $aspiration->id) }}" class="font-bold text-indigo-600 hover:underline">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 bg-white border border-gray-200 rounded-2xl py-16 text-center shadow-sm">
                    <p class="text-2xl mb-2">📂</p>
                    <p class="text-sm font-semibold text-gray-900">Belum ada aspirasi ditemukan</p>
                    <p class="mt-1 text-xs text-gray-500">Silakan sesuaikan filter pencarian atau buat aspirasi baru.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $aspirations->links() }}
        </div>
    </div>
@endsection
