@extends('layouts.admin')

@section('title', 'Statistik - Dashboard')
@section('page_title', 'Statistik Pengaduan')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-gray-900 mb-6">Dukungan Masyarakat (Votes)</h3>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-sm font-semibold mb-2">
                        <span class="text-gray-600">Upvotes (👍 {{ $totalUpvotes }} Dukungan)</span>
                        <span class="text-indigo-600">{{ $upvotePercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $upvotePercent }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm font-semibold mb-2">
                        <span class="text-gray-600">Downvotes (👎 {{ $totalDownvotes }} Dukungan)</span>
                        <span class="text-rose-600">{{ $downvotePercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-rose-500 h-full rounded-full" style="width: {{ $downvotePercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-gray-900 mb-6">Distribusi Kategori</h3>
            <div class="space-y-4">
                @forelse($categories as $category)
                    @php
                        $percentage = $totalAspirations > 0 ? round(($category->aspirations_count / $totalAspirations) * 100) : 0;
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-600 w-1/3 truncate" title="{{ $category->nama_kategori }}">{{ $category->nama_kategori }}</span>
                        <div class="w-1/2 bg-gray-100 h-2 rounded-full overflow-hidden mr-4">
                            <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-900 w-1/12 text-right">{{ $category->aspirations_count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada data kategori.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 mb-4">Statistik Bulanan ({{ date('Y') }})</h3>
        <div class="flex items-end justify-between h-48 pt-6 border-b border-gray-100 px-4">
            @foreach($monthlyCounts as $monthNum => $count)
                <div class="flex flex-col items-center w-[7%] group">
                    @php
                        $heightPercent = $maxMonthlyCount > 0 ? round(($count / $maxMonthlyCount) * 100) : 0;
                        $heightStyle = $count > 0 ? max($heightPercent, 4) : 0;
                        $isCurrentMonth = $monthNum == (int)date('n');
                    @endphp
                    <div class="w-8 {{ $isCurrentMonth ? 'bg-indigo-600' : 'bg-indigo-100 group-hover:bg-indigo-200' }} transition-all duration-300 rounded-t-md relative" style="height: {{ $heightStyle }}%">
                        <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold {{ $isCurrentMonth ? 'text-indigo-650' : 'text-gray-700' }} opacity-0 group-hover:opacity-100 transition-opacity">{{ $count }}</span>
                    </div>
                    <span class="text-xs {{ $isCurrentMonth ? 'text-gray-900 font-semibold' : 'text-gray-500' }} mt-2 font-medium">{{ $monthNames[$monthNum] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
