@extends('layouts.admin')

@section('title', 'Profil - Dashboard')
@section('page_title', 'Profil Pengguna')

@section('content')
<div class="max-w-2xl bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-base font-bold text-gray-900">Informasi Akun</h3>
        <p class="text-sm text-gray-500 mt-1">Perbarui detail profil dan kata sandi administrator Anda.</p>
    </div>

    @if(session('success'))
        <div data-flash class="mx-6 mt-6 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6" data-loading>
        @csrf
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600">
                {{ strtoupper(substr($user->name ?? 'AD', 0, 2)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 border @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-1 transition-colors">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2.5 border @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-1 transition-colors">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru (Opsional)</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full px-4 py-2.5 border @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 @enderror rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-1 transition-colors pr-10">
                    <button type="button" data-toggle-password="password" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm">&#128065;</button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors pr-10">
                    <button type="button" data-toggle-password="password_confirmation" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm">&#128065;</button>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
