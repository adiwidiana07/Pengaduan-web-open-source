@extends('layouts.app')

@section('title', 'Aspirasi Saya - Pengaduan')
@section('page_title', 'Aspirasi Saya')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Aspirasi Saya</h1>
            <p class="mt-2 text-sm text-gray-500">Daftar aspirasi yang telah Anda buat berdasarkan token di perangkat ini.</p>
        </div>

        @if(session('success'))
            <div data-flash class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

        <div class="space-y-4">
            @forelse($aspirations as $aspiration)
                <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="text-xs text-gray-400 font-medium">
                            {{ $aspiration->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <h2 class="text-lg font-bold text-gray-900">
                        <a href="{{ route('aspirasi.show', $aspiration->id) }}" class="hover:text-indigo-600 transition-colors">
                            {{ $aspiration->judul }}
                        </a>
                    </h2>

                    <p class="mt-2 text-sm text-gray-600 leading-relaxed line-clamp-2">
                        {{ $aspiration->isi }}
                    </p>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center gap-4">
                            <span class="font-semibold text-emerald-600">👍 {{ $aspiration->upvote }}</span>
                            <span class="font-semibold text-rose-600">👎 {{ $aspiration->downvote }}</span>
                            <span class="text-gray-600">💬 {{ $aspiration->comments_count ?? $aspiration->comments->count() }} Komentar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('aspirasi.edit', $aspiration->id) }}" class="font-semibold text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('aspirasi.destroy', $aspiration->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menghapus aspirasi ini?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-semibold text-red-600 hover:underline bg-transparent border-0 p-0 cursor-pointer">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-2xl py-16 text-center shadow-sm">
                    <p class="text-4xl mb-4">📋</p>
                    <p class="text-sm font-semibold text-gray-900">Belum ada aspirasi</p>
                    <p class="mt-1 text-xs text-gray-500">Anda belum membuat aspirasi apapun dari perangkat ini.</p>
                    <a href="{{ route('aspirasi.create') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
                        + Buat Aspirasi Baru
                    </a>
                </div>
            @endforelse
        </div>

        @if(method_exists($aspirations, 'hasPages') && $aspirations->hasPages())
            <div class="mt-8">
                {{ $aspirations->links() }}
            </div>
        @endif
    </div>
@endsection
