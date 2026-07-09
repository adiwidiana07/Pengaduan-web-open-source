<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Pengaduan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-[#fafafa] text-[#202124] antialiased">
    @include('components.navbar')
    <main class="flex-grow flex flex-col justify-center">
        @yield('content')
    </main>
    @include('components.footer')
</body>
</html>