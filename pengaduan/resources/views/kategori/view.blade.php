@extends('layouts.app')

@section('title', 'View Kategori - Pengaduan')
@section('page_title', 'View Kategori')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900">Kategori</h1>
        <div class="mt-6">
            <p><strong>Nama Kategori:</strong> {{ $kategori->nama_kategori }}</p>
        </div>
    </div>
@endsection