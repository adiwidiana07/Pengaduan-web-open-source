@extends('layouts.admin')

@section('title', 'Edit Kategori - Dashboard')
@section('page_title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-base font-bold text-gray-900">Informasi Kategori</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi kategori aspirasi.</p>
        </div>

        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="p-6 space-y-6" data-loading>
            @csrf
            @method('PUT')
            <div>
                <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required maxlength="255"
                    class="w-full px-4 py-2.5 border @error('nama_kategori') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-1 transition-colors">
                @error('nama_kategori')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" maxlength="500" data-auto-resize
                    class="w-full px-4 py-2.5 border @error('deskripsi') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-1 transition-colors">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('kategori.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
