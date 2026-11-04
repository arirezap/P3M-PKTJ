<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'P3M Politeknik Keselamatan Transportasi Jalan')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal.')">
    
    <!-- Favicon / Shortcut Icon (Logo PKTJ) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPKTJ.png') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-800 font-sans antialiased selection:bg-yellow-400 selection:text-[#0B2A59]">
    
    <!-- Unified Institutional Header -->
    <x-public-navbar />

    <!-- Main Page Content -->
    @yield('content')
    {{ $slot ?? '' }}

    <!-- Unified Institutional Footer -->
    <x-public-footer />

    @stack('scripts')
</body>
</html>
