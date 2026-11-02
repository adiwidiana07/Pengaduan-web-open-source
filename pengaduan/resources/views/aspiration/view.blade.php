@extends('layouts.app')

@section('title', $aspiration->judul . ' - Aspirasi')
@section('page_title', 'Detail Aspirasi')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div data-flash role="status" class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div data-flash role="alert" class="mb-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Back Link --}}
    <div class="mb-4">
        <a href="{{ route('aspirasi.index') }}"
           class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- ===== Main Aspiration Card ===== --}}
    <article class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-8">
        <div class="p-6 sm:p-8">

            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center justify-between gap-2 mb-6 text-xs text-gray-500 font-semibold">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <x-doc-no :id="$aspiration->id" />
                    <span class="text-xs font-semibold text-gray-700 bg-gray-100 rounded px-1.5 py-0.5">{{ $aspiration->category->nama_kategori ?? 'Umum' }}</span>
                    <span class="text-gray-600">{{ $canManage ? 'Anonim (aspirasi Anda)' : 'Anonim' }}</span>
                </div>
                <span class="text-gray-600">{{ $aspiration->created_at->translatedFormat('d M Y, H:i') }}</span>
            </div>

            {{-- Title --}}
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 leading-tight break-words">
                {{ $aspiration->judul }}
            </h1>

            {{-- Body --}}
            <div class="mt-6 text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line break-words border-b border-gray-100 pb-8">
                {{ $aspiration->isi }}
            </div>

            {{-- Voting & Actions --}}
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">

                {{-- Vote Buttons --}}
                <div class="flex flex-wrap items-center gap-2">
                    <form action="{{ route('aspirasi.vote', $aspiration->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote_type" value="upvote">
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 min-h-11 rounded-md text-sm font-semibold
                                       border border-emerald-200 text-emerald-700 bg-emerald-50
                                       hover:bg-emerald-100 transition-colors">
                            Setuju ({{ $aspiration->upvote }})
                        </button>
                    </form>
                    <form action="{{ route('aspirasi.vote', $aspiration->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote_type" value="downvote">
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 min-h-11 rounded-md text-sm font-semibold
                                       border border-rose-200 text-rose-700 bg-rose-50
                                       hover:bg-rose-100 transition-colors">
                            Tidak setuju ({{ $aspiration->downvote }})
                        </button>
                    </form>
                </div>

                {{-- Owner actions / report --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if($canManage)
                        <a href="{{ route('aspirasi.edit', $aspiration->id) }}"
                           class="px-4 py-2 min-h-11 rounded-md text-sm font-semibold border border-gray-200
                                  text-gray-700 bg-white hover:bg-gray-50 transition-colors inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Aspirasi
                        </a>
                        <form action="{{ route('aspirasi.destroy', $aspiration->id) }}" method="POST"
                              data-confirm="Apakah Anda yakin ingin menghapus aspirasi ini? Tindakan ini tidak dapat dibatalkan.">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 min-h-11 rounded-md text-sm font-semibold text-white
                                           bg-red-600 hover:bg-red-700 transition-colors inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    @elseif($canReport)
                        <button type="button" data-dialog-open="report-dialog"
                                class="px-4 py-2 min-h-11 rounded-md text-sm font-semibold border border-gray-200
                                       text-gray-600 bg-white hover:bg-gray-50 hover:text-rose-700 transition-colors inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21V4m0 0h13l-2 4 2 4H3"/>
                            </svg>
                            Laporkan
                        </button>
                    @elseif($hasReported)
                        <p class="text-xs font-semibold text-gray-500">Anda sudah melaporkan aspirasi ini.</p>
                    @endif
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center min-h-11 text-xs font-semibold text-gray-600 hover:text-indigo-700 underline underline-offset-2">
                            Masuk untuk melaporkan
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </article>

    {{-- ===== Comments Section ===== --}}
    <section class="bg-white border border-gray-200 rounded-lg p-6 sm:p-8">
        <h2 class="font-serif text-2xl font-semibold text-gray-900 mb-6">
            Diskusi
            <span class="ml-1 text-sm font-semibold text-gray-500">({{ $aspiration->comments->count() }})</span>
        </h2>

        @guest
            <div class="mb-8 rounded-md border border-indigo-100 bg-indigo-50 px-5 py-5">
                <p class="text-sm font-semibold text-indigo-950">Masuk untuk ikut berdiskusi.</p>
                <p class="mt-1 text-sm text-indigo-950">Komentar tetap tampil sebagai Anonim dan tidak terhubung ke akun Anda.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center min-h-11 px-5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-md">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center min-h-11 px-5 text-sm font-semibold text-indigo-700 bg-white border border-indigo-600 hover:bg-indigo-50 transition-colors rounded-md">
                        Daftar
                    </a>
                </div>
            </div>
        @endguest

        @if(auth()->user()?->isAdmin())
            <p class="mb-8 text-sm text-gray-600">Akun administrator tidak dapat berkomentar.</p>
        @endif

        @if(auth()->check() && ! auth()->user()->isAdmin())
        {{-- New Comment Form --}}
        <form action="{{ route('aspirasi.comment', $aspiration->id) }}" method="POST" class="mb-8" data-loading>
            @csrf
            <div>
                <label for="isi" class="sr-only">Tulis Komentar</label>
                <textarea name="isi" id="isi" rows="3" required maxlength="1000" data-auto-resize
                          placeholder="Tulis komentar/masukan Anda secara anonim di sini..."
                          class="w-full px-4 py-3 text-sm border border-gray-300 rounded-md
                                 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 resize-none"></textarea>
            </div>
            <div class="mt-2 flex justify-end">
                <button type="submit"
                        class="px-5 py-2 min-h-11 text-sm font-semibold text-white bg-indigo-600
                               hover:bg-indigo-700 transition-colors rounded-md">
                    Kirim Komentar
                </button>
            </div>
            @error('isi')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </form>
        @endif

        {{-- Comment List --}}
        <div class="space-y-4">
            @forelse($aspiration->comments as $comment)
                <div class="flex flex-col p-4 bg-gray-50 rounded-md border border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-2">
                        <span>Anonim</span>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed break-words">{{ $comment->isi }}</p>
                </div>
            @empty
                <div class="text-center py-10 text-sm text-gray-500">
                    Belum ada diskusi. Jadilah yang pertama memberikan masukan!
                </div>
            @endforelse
        </div>
    </section>

</div>

@if($canReport)
{{-- ======================== REPORT DIALOG ======================== --}}
<dialog id="report-dialog" aria-labelledby="report-title"
        @if($errors->report->any()) data-open-on-load @endif
        class="w-[calc(100%-2rem)] max-w-md m-auto rounded-lg border border-gray-200 bg-white p-0 shadow-xl backdrop:bg-gray-950/50">
    <form action="{{ route('aspirasi.report', $aspiration->id) }}" method="POST" class="p-6 sm:p-8" data-loading>
        @csrf
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h2 id="report-title" class="font-serif text-xl font-semibold text-gray-900">Laporkan aspirasi ini</h2>
                <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                    Admin hanya melihat jumlah dan alasan laporan, tidak melihat siapa yang melapor.
                </p>
            </div>
            <button type="button" data-dialog-close aria-label="Tutup"
                    class="w-11 h-11 -mr-2 -mt-2 flex-shrink-0 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <fieldset>
            <legend class="text-sm font-semibold text-gray-700 mb-2">Alasan</legend>
            <div class="space-y-1">
                @foreach($reportReasons as $value => $label)
                    <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:bg-rose-50 has-[:checked]:text-rose-800 text-sm text-gray-700">
                        <input type="radio" name="alasan" value="{{ $value }}" required
                               {{ old('alasan') === $value ? 'checked' : '' }}
                               class="w-4 h-4 accent-rose-600">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
            @error('alasan', 'report')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </fieldset>

        <div class="mt-4">
            <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Catatan <span class="font-normal text-gray-500">(opsional)</span>
            </label>
            <textarea name="catatan" id="catatan" rows="3" maxlength="500"
                      placeholder="Jelaskan singkat bagian mana yang bermasalah."
                      class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 resize-none">{{ old('catatan') }}</textarea>
            @error('catatan', 'report')
                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex items-center gap-2">
            <button type="button" data-dialog-close
                    class="flex-1 py-2.5 min-h-11 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                Batal
            </button>
            <button type="submit"
                    class="flex-1 py-2.5 min-h-11 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-md transition-colors">
                Kirim Laporan
            </button>
        </div>
    </form>
</dialog>
@endif

@endsection
