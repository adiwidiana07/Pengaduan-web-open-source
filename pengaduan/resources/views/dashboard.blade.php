@extends('layouts.admin')

@section('title', 'Dashboard - Pengaduan')
@section('page_title', 'Ringkasan')

@section('content')
<div class="space-y-8">
    @if(session('success'))
        <div data-flash class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Pengaduan</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAspirations }}</h3>
            </div>
            <div class="text-2xl w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                💬
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Upvotes</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUpvotes }}</h3>
            </div>
            <div class="text-2xl w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                👍
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Downvotes</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalDownvotes }}</h3>
            </div>
            <div class="text-2xl w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center">
                👎
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Kategori</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalCategories }}</h3>
            </div>
            <div class="text-2xl w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                📁
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Aspirasi & Pengaduan Terbaru</h3>
            <a href="{{ route('admin.aspirasi.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase border-b border-gray-200">
                        <th class="px-6 py-4">Pelapor (Token)</th>
                        <th class="px-6 py-4">Judul Pengaduan</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Dukungan</th>
                        <th class="px-6 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($latestAspirations as $aspiration)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">Anonim ({{ substr($aspiration->owner_token, 0, 8) }})</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.aspirasi.show', $aspiration->id) }}" class="text-gray-600 hover:text-indigo-600 transition-colors">
                                    {{ $aspiration->judul }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $aspiration->category->nama_kategori ?? 'Tanpa Kategori' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-800">
                                    👍 {{ $aspiration->upvote }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-50 text-rose-800 ml-1">
                                    👎 {{ $aspiration->downvote }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $aspiration->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">
                                Belum ada pengaduan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
