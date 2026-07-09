<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard - Pengaduan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-gray-900 antialiased flex">
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 left-0 z-20">
        <div class="px-6 py-5 border-b border-gray-200">
           <a href="/" class="flex items-center text-xl font-bold tracking-tight text-gray-900">
            <p class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Pengaduan</p>
        </a>
        </div>
        <nav class="flex-grow px-4 py-6 space-y-1">
            <a href="/dashboard" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors {{ Request::is('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span>📊</span>
                Dashboard
            </a>
            <a href="/dashboard/aspirasi" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors {{ Request::is('dashboard/aspirasi*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span>📋</span>
                Semua Aspirasi
            </a>
            <a href="/dashboard/kategori" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors {{ Request::is('dashboard/kategori*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span>📁</span>
                Kategori Aspirasi
            </a>
            <a href="/dashboard/statistik" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors {{ Request::is('dashboard/statistik') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span>📈</span>
                Statistik
            </a>
            <a href="/dashboard/profil" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold rounded-lg transition-colors {{ Request::is('dashboard/profil') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span>👤</span>
                Profil
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center gap-3 px-4 py-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-semibold text-indigo-600">
                    {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-xxs text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@pengaduan.id' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mt-2 flex items-center gap-3 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                <span>🚪</span>
                Keluar
            </a>
        </div>
    </aside>

    <div class="pl-64 flex flex-col flex-grow min-h-screen">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="text-lg font-bold text-gray-800">@yield('page_title', 'Ringkasan')</h2>
            <div class="flex items-center gap-4">
                <button class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors">
                    <span>🔔</span>
                </button>
            </div>
        </header>

        <main class="flex-grow p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
