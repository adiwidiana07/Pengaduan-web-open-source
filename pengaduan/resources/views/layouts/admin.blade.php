<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard - Pengaduan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full text-gray-900 antialiased">
    @php($readyReports = \App\Models\Aspiration::has('reports', '>=', config('pengaduan.report_threshold'))->count())
    @php($navClass = fn ($active) => 'flex items-center gap-3 px-4 min-h-11 text-sm font-semibold rounded-lg transition-colors '.($active ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'))

    {{-- Sidebar: always visible from lg, slide-over panel below lg --}}
    <aside id="admin-sidebar" data-open-class="flex"
           class="hidden lg:flex w-64 max-w-[85vw] bg-white border-r border-gray-200 flex-col fixed inset-y-0 left-0 z-30 shadow-xl lg:shadow-none">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <a href="/" class="font-serif text-xl font-bold text-indigo-800">Pengaduan</a>
            <button type="button" data-nav-close="admin-sidebar" aria-label="Tutup menu"
                    class="lg:hidden w-11 h-11 -mr-3 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="flex-grow overflow-y-auto px-4 py-6 space-y-1" aria-label="Navigasi admin">
            <a href="/dashboard" class="{{ $navClass(Request::is('dashboard')) }}">
                <span aria-hidden="true">📊</span>
                Dashboard
            </a>
            <a href="/dashboard/aspirasi" class="{{ $navClass(Request::is('dashboard/aspirasi*')) }}">
                <span aria-hidden="true">📋</span>
                Semua Aspirasi
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="{{ $navClass(Request::is('dashboard/laporan*')) }}">
                <span aria-hidden="true">🚩</span>
                Laporan
                @if($readyReports > 0)
                    <span class="ml-auto inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full bg-rose-600 text-white text-xs font-bold"
                          title="{{ $readyReports }} aspirasi mencapai ambang laporan">
                        {{ $readyReports }}<span class="sr-only"> aspirasi mencapai ambang</span>
                    </span>
                @endif
            </a>
            <a href="/dashboard/kategori" class="{{ $navClass(Request::is('dashboard/kategori*')) }}">
                <span aria-hidden="true">📁</span>
                Kategori Aspirasi
            </a>
            <a href="/dashboard/statistik" class="{{ $navClass(Request::is('dashboard/statistik')) }}">
                <span aria-hidden="true">📈</span>
                Statistik
            </a>
            <a href="/dashboard/profil" class="{{ $navClass(Request::is('dashboard/profil')) }}">
                <span aria-hidden="true">👤</span>
                Profil
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center gap-3 px-4 py-2">
                <div class="w-8 h-8 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-semibold text-indigo-600" aria-hidden="true">
                    {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 min-h-11 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <span aria-hidden="true">🚪</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-64 flex flex-col min-h-screen min-w-0">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center gap-3 px-4 sm:px-8 sticky top-0 z-10">
            <button type="button" data-nav-toggle aria-controls="admin-sidebar" aria-expanded="false" aria-label="Buka menu"
                    class="lg:hidden w-11 h-11 -ml-2 rounded-lg flex items-center justify-center text-gray-700 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h2 class="font-serif text-xl font-semibold text-gray-900 truncate">@yield('page_title', 'Ringkasan')</h2>
        </header>

        <main class="flex-grow p-4 sm:p-8 min-w-0">
            @yield('content')
        </main>
    </div>
</body>
</html>
