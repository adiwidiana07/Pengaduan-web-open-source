@extends('layouts.admin')

@section('title', 'Aspirasi - Dashboard')
@section('page_title', 'Kelola Aspirasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-500">Kelola seluruh aspirasi dan pengaduan masyarakat.</p>
    </div>

    @if(session('error'))
        <div data-flash role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 shadow-sm">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div data-flash class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <form action="{{ route('admin.aspirasi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari judul atau isi aspirasi..." value="{{ request('search') }}" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
                <div class="sm:w-44">
                    <label for="sort" class="sr-only">Urutkan</label>
                    <select name="sort" id="sort" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Terbaru</option>
                        <option value="reports" {{ request('sort') === 'reports' ? 'selected' : '' }}>Laporan terbanyak</option>
                    </select>
                </div>
                <div class="sm:w-48">
                    <select name="category_id" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-xl focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-xl shadow-sm">
                    Cari
                </button>
                @if(request('search') || request('category_id') || request('sort'))
                    <a href="{{ route('admin.aspirasi.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors inline-flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase border-b border-gray-200">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Dukungan</th>
                        <th class="px-6 py-4">Komentar</th>
                        <th class="px-6 py-4">Laporan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($aspirations as $aspiration)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ $aspiration->id }}</td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                <a href="{{ route('admin.aspirasi.show', $aspiration->id) }}" class="hover:text-indigo-600 transition-colors font-medium">
                                    {{ $aspiration->judul }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                    {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-emerald-600 font-semibold">👍 {{ $aspiration->upvote }}</span>
                                <span class="text-rose-600 font-semibold ml-1">👎 {{ $aspiration->downvote }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $aspiration->comments_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($aspiration->reports_count >= $threshold)
                                    <span class="font-bold text-rose-700">{{ $aspiration->reports_count }}</span><span class="text-gray-500"> / {{ $threshold }}</span>
                                @else
                                    <span class="text-gray-500">{{ $aspiration->reports_count }} / {{ $threshold }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">{{ $aspiration->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.aspirasi.show', $aspiration->id) }}" class="text-xs font-semibold text-indigo-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 font-medium">
                                Belum ada aspirasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aspirations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $aspirations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
