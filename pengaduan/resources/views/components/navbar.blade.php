@php
    $user = auth()->user();
    $links = [['/', 'Home'], ['/aspirasi', 'Aspirasi']];
    if ($user && ! $user->isAdmin()) {
        $links[] = ['/my-aspirations', 'Aspirasi Saya'];
    }
    if ($user?->isAdmin()) {
        $links[] = ['/dashboard', 'Dashboard'];
    }
    $links[] = ['/about', 'Tentang'];
@endphp

<nav class="relative bg-white border-b border-gray-200/80" aria-label="Navigasi utama">
    <div class="flex items-center justify-between px-4 sm:px-6 py-3">
        <a href="/" class="font-serif text-xl font-bold text-indigo-800">Pengaduan</a>

        {{-- Desktop --}}
        <div class="hidden md:flex items-center gap-5">
            @foreach($links as [$href, $label])
                <a href="{{ $href }}" class="nav-link text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">{{ $label }}</a>
            @endforeach

            @auth
                <form action="{{ route('logout') }}" method="POST" class="ml-1">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors rounded-md">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-indigo-700 bg-white border border-indigo-600 hover:bg-indigo-50 transition-colors rounded-md">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-md">
                    Daftar
                </a>
            @endauth
        </div>

        {{-- Mobile toggle --}}
        <button type="button" data-nav-toggle aria-controls="mobile-nav" aria-expanded="false"
                class="md:hidden inline-flex items-center gap-2 min-h-11 px-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Menu
        </button>
    </div>

    {{-- Mobile panel --}}
    <div id="mobile-nav" class="hidden md:hidden border-t border-gray-100 px-4 pb-4 pt-2">
        <div class="flex flex-col">
            @foreach($links as [$href, $label])
                <a href="{{ $href }}" class="nav-link flex items-center min-h-11 px-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50">{{ $label }}</a>
            @endforeach
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 flex gap-2">
            @auth
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full min-h-11 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center min-h-11 text-sm font-semibold text-indigo-700 bg-white border border-indigo-600 rounded-md hover:bg-indigo-50">Masuk</a>
                <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center min-h-11 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
