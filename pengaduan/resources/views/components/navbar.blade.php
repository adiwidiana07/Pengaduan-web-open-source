<nav class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200/80">
    <div class="flex items-center gap-6">
        <a href="/" class="flex items-center text-xl font-bold tracking-tight text-gray-900">
            <p class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Pengaduan</p>
        </a>
    </div>

    <div class="flex items-center gap-4">
        <a href="/" class="nav-link text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Home</a>
        <a href="/aspirasi" class="nav-link text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Aspirasi</a>
        <a href="/my-aspirations" class="nav-link text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Aspirasi Saya</a>
        <a href="/about" class="nav-link text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Tentang</a>
        @auth
            <a href="/dashboard" class="nav-link text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" id="logout-form-nav" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();" class="ml-2 inline-flex items-center justify-center px-5 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-colors rounded-lg shadow-sm">
                Keluar
            </a>
        @else
            <a href="/login" class="ml-2 inline-flex items-center justify-center px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors rounded-lg shadow-sm">
                Masuk
            </a>
        @endauth
    </div>
</nav>
