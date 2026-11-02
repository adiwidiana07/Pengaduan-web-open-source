@extends('layouts.admin')

@section('title', $aspiration->judul . ' - Detail Aspirasi')
@section('page_title', 'Detail Aspirasi')

@section('content')
@php($reachedThreshold = $aspiration->reports_count >= $threshold)
<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.aspirasi.index') }}"
           class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('error'))
        <div data-flash role="alert" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div data-flash role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    {{-- ===== Moderasi ===== --}}
    <section aria-labelledby="moderasi-title"
             class="mb-6 rounded-2xl border p-6 {{ $reachedThreshold ? 'border-rose-200 bg-rose-50/60' : 'border-gray-200 bg-white' }}">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 id="moderasi-title" class="text-sm font-bold text-gray-900">Laporan masyarakat</h2>
                <p class="mt-1 text-3xl font-extrabold {{ $reachedThreshold ? 'text-rose-700' : 'text-gray-900' }}">
                    {{ $aspiration->reports_count }}<span class="text-base font-semibold text-gray-500"> / {{ $threshold }} ambang</span>
                </p>
                <p class="mt-1 text-xs text-gray-600">
                    @if($reachedThreshold)
                        Ambang tercapai. Anda dapat menghapus aspirasi ini.
                    @else
                        Penghapusan oleh admin baru tersedia setelah {{ $threshold }} laporan.
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($aspiration->reports_count > 0)
                    <form action="{{ route('admin.laporan.dismiss', $aspiration) }}" method="POST"
                          data-confirm="Tolak semua {{ $aspiration->reports_count }} laporan untuk aspirasi ini? Jumlah laporan akan kembali ke 0.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="min-h-11 px-4 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50">
                            Tolak Laporan
                        </button>
                    </form>
                @endif
                @if($reachedThreshold)
                    <form action="{{ route('admin.aspirasi.destroy', $aspiration) }}" method="POST"
                          data-confirm="Hapus aspirasi ini secara permanen? Komentar, dukungan, dan laporannya ikut terhapus.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="min-h-11 px-4 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700">
                            Hapus Aspirasi
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if($reasonCounts->isNotEmpty())
            <dl class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                @foreach($reasonCounts as $alasan => $total)
                    <div class="flex items-center justify-between border-b border-gray-200/70 py-1.5">
                        <dt class="text-gray-700">{{ $reasons[$alasan] ?? $alasan }}</dt>
                        <dd class="font-bold text-gray-900">{{ $total }}</dd>
                    </div>
                @endforeach
            </dl>
        @endif

        @if($notes->isNotEmpty())
            <details class="mt-4">
                <summary class="cursor-pointer text-sm font-semibold text-indigo-700">Catatan pelapor ({{ $notes->count() }} terbaru)</summary>
                <ul class="mt-3 space-y-2">
                    @foreach($notes as $note)
                        <li class="rounded-lg bg-white border border-gray-200 px-3 py-2 text-sm text-gray-700 break-words">
                            <span class="text-xs font-semibold text-gray-500">{{ $note->alasanLabel() }} · {{ $note->created_at->diffForHumans() }}</span>
                            <p class="mt-0.5">{{ $note->catatan }}</p>
                        </li>
                    @endforeach
                </ul>
            </details>
        @endif
    </section>

    <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-6 text-xs text-gray-500 font-semibold">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                        {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                    </span>
                    <span aria-hidden="true">&bull;</span>
                    <span>Anonim</span>
                </div>
                <span>{{ $aspiration->created_at->format('d M Y, H:i') }}</span>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight break-words">
                {{ $aspiration->judul }}
            </h1>

            <div class="mt-6 text-sm text-gray-700 leading-relaxed whitespace-pre-line break-words border-b border-gray-100 pb-8">
                {{ $aspiration->isi }}
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border border-emerald-200 text-emerald-700 bg-emerald-50">
                    👍 Setuju ({{ $aspiration->upvote }})
                </span>
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border border-rose-200 text-rose-700 bg-rose-50">
                    👎 Tidak Setuju ({{ $aspiration->downvote }})
                </span>
            </div>
        </div>
    </article>

    <section class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">
            Komentar Masyarakat
            <span class="ml-1 text-sm font-semibold text-gray-500">({{ $aspiration->comments->count() }})</span>
        </h2>

        <div class="space-y-4">
            @forelse($aspiration->comments as $comment)
                <div class="flex flex-col p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-2">
                        <span>Anonim</span>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed break-words">{{ $comment->isi }}</p>
                </div>
            @empty
                <div class="text-center py-10 text-sm text-gray-500">
                    <p class="text-2xl mb-2" aria-hidden="true">💬</p>
                    Belum ada komentar dari masyarakat.
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
