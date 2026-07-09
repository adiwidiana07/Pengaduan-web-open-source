@extends('layouts.app')

@section('title', 'Buat Aspirasi - Pengaduan')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Buat Aspirasi</h1>
            <p class="mt-2 text-sm text-gray-600">Sampaikan pendapat Anda secara anonim dan langsung terlihat publik.</p>
        </div>

        <form action="{{ route('aspirasi.store') }}" method="POST" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm" data-loading>
            @csrf

            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required maxlength="255"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('judul') border-red-400 @enderror">
                @error('judul')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" required
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('category_id') border-red-400 @enderror">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Aspirasi</label>
                <textarea name="isi" id="isi" rows="6" required data-auto-resize
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('isi') border-red-400 @enderror">{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('aspirasi.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Kembali</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors shadow-sm">
                    Kirim Aspirasi
                </button>
            </div>
        </form>
    </div>
@endsection
