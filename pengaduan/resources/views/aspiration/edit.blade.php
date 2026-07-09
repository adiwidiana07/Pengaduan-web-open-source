@extends('layouts.app')

@section('title', 'Edit Aspirasi - Pengaduan')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Aspirasi</h1>
            <p class="mt-2 text-sm text-gray-600">Perbarui informasi aspirasi Anda secara aman.</p>
        </div>

        @if(session('success'))
            <div data-flash class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('aspirasi.update', $aspiration->id) }}" method="POST" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm" data-loading>
            @csrf
            @method('PUT')

            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $aspiration->judul) }}" required maxlength="255"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('judul') border-red-400 @enderror">
                @error('judul')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" required
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('category_id') border-red-400 @enderror">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $aspiration->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Aspirasi</label>
                <textarea name="isi" id="isi" rows="6" required data-auto-resize
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error('isi') border-red-400 @enderror">{{ old('isi', $aspiration->isi) }}</textarea>
                @error('isi')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('aspirasi.show', $aspiration->id) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Batal</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition-colors shadow-sm">
                    Perbarui Aspirasi
                </button>
            </div>
        </form>
    </div>
@endsection
