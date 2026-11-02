@extends('layouts.admin')

@section('title', 'Laporan - Dashboard')
@section('page_title', 'Laporan Aspirasi')

@section('content')
<div class="space-y-6 max-w-5xl">
    <p class="text-sm text-gray-600 max-w-2xl">
        Aspirasi yang dilaporkan masyarakat, diurutkan dari laporan terbanyak. Aspirasi baru bisa dihapus setelah mencapai
        <strong class="text-gray-900">{{ $threshold }} laporan</strong>. Identitas pelapor dan penulis tidak tersedia untuk admin.
    </p>

    @if(session('success'))
        <div data-flash role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div data-flash role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ session('error') }}</div>
    @endif

    @if($readyCount > 0)
        <p class="text-sm font-semibold text-rose-700">
            {{ $readyCount }} aspirasi sudah mencapai ambang dan menunggu keputusan Anda.
        </p>
    @endif

    <div class="space-y-3">
        @forelse($aspirations as $aspiration)
            @php($ready = $aspiration->reports_count >= $threshold)
            @php($percent = min(100, (int) round($aspiration->reports_count / max($threshold, 1) * 100)))
            <article class="bg-white border rounded-2xl p-5 {{ $ready ? 'border-rose-300' : 'border-gray-200' }}">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold">
                            <span>{{ $aspiration->category->nama_kategori ?? 'Umum' }}</span>
                            <span aria-hidden="true">·</span>
                            <span>{{ $aspiration->created_at->format('d M Y') }}</span>
                        </div>
                        <h2 class="mt-1 font-bold text-gray-900 truncate">
                            <a href="{{ route('admin.aspirasi.show', $aspiration) }}" class="hover:text-indigo-600">{{ $aspiration->judul }}</a>
                        </h2>

                        <div class="mt-3 flex items-center gap-3">
                            <div class="h-1.5 flex-1 max-w-xs rounded-full bg-gray-100 overflow-hidden"
                                 role="meter" aria-valuemin="0" aria-valuemax="{{ $threshold }}" aria-valuenow="{{ $aspiration->reports_count }}"
                                 aria-label="Laporan menuju ambang">
                                <div class="h-full {{ $ready ? 'bg-rose-600' : 'bg-gray-400' }}" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="text-sm whitespace-nowrap {{ $ready ? 'font-bold text-rose-700' : 'text-gray-600' }}">
                                {{ $aspiration->reports_count }} / {{ $threshold }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 sm:justify-end">
                        <a href="{{ route('admin.aspirasi.show', $aspiration) }}"
                           class="inline-flex items-center min-h-11 px-4 rounded-xl text-sm font-semibold text-indigo-700 hover:bg-indigo-50">
                            Lihat Alasan
                        </a>
                        <form action="{{ route('admin.laporan.dismiss', $aspiration) }}" method="POST"
                              data-confirm="Tolak semua {{ $aspiration->reports_count }} laporan untuk aspirasi ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="min-h-11 px-4 rounded-xl text-sm font-semibold text-gray-700 border border-gray-200 hover:bg-gray-50">
                                Tolak Laporan
                            </button>
                        </form>
                        @if($ready)
                            <form action="{{ route('admin.aspirasi.destroy', $aspiration) }}" method="POST"
                                  data-confirm="Hapus aspirasi ini secara permanen?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="min-h-11 px-4 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl py-14 text-center">
                <p class="text-sm font-semibold text-gray-900">Belum ada laporan</p>
                <p class="mt-1 text-xs text-gray-500">Aspirasi yang dilaporkan masyarakat akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

    @if($aspirations->hasPages())
        <div>{{ $aspirations->links() }}</div>
    @endif
</div>
@endsection
