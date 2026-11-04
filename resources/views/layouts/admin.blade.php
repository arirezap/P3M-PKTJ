<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - CMS P3M PKTJ</title>

    <!-- Favicon / Shortcut Icon (Logo PKTJ) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPKTJ.png') }}">

    <!-- Meta CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Self-Hosted TinyMCE -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-700 antialiased font-sans min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity">
    </div>

    <!-- Sidebar Navigasi Admin (Lebar 260px, Kelipatan 4px) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0B2A59] text-white flex flex-col justify-between transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 flex-shrink-0 shadow-lg">
        
        <!-- Header Sidebar -->
        <div>
            <div class="h-16 px-6 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 focus:outline-none">
                    <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-9 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-white leading-4">CMS P3M</span>
                        <span class="text-[10px] text-yellow-400 font-medium leading-3">Politeknik Keselamatan Transportasi Jalan</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-300 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Menu Navigasi Sidebar -->
            <nav class="p-4 space-y-6 text-xs leading-4 overflow-y-auto max-h-[calc(100vh-140px)]">
                
                <!-- Kelompok: Navigasi Utama SIM P3M (Sesuai Matriks Excel) -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-4">Menu Utama SIM</div>
                    
                    <!-- Home -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Home (Dasbor)</span>
                    </a>

                    <!-- Sub-Menu 1: Penelitian -->
                    <a href="{{ route('admin.penelitian.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.penelitian.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        <span>Penelitian</span>
                    </a>

                    <!-- Sub-Menu 2: Pengabdian kepada Masyarakat -->
                    <a href="{{ route('admin.pengabdian.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.pengabdian.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Pengabdian Masyarakat</span>
                    </a>

                    <!-- Sub-Menu 3: Pengaturan (Pengguna & Sistem) -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Pengaturan Akun & SIM</span>
                    </a>
                </div>

                <!-- Kelompok: Pengelolaan CMS Publik -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-4">CMS Portal Publik</div>
                    
                    <a href="{{ route('admin.posts.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span>Berita & Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.documents.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.documents.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Dokumen, SOP & Panduan</span>
                    </a>

                    <a href="{{ route('admin.researches.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.researches.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Data Riset per Prodi</span>
                    </a>

                    <a href="{{ route('admin.outputs.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.outputs.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Luaran Riset (Publikasi & HKI)</span>
                    </a>

                    <a href="{{ route('admin.collaborations.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.collaborations.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Kerjasama Riset</span>
                    </a>

                    <a href="{{ route('admin.community-services.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.community-services.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <span>Data Pengabdian (PkM)</span>
                    </a>

                    <a href="{{ route('admin.community-service-outputs.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.community-service-outputs.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Luaran Pengabdian</span>
                    </a>

                    <a href="{{ route('admin.settings.profile') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.settings.profile*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>Pengaturan Beranda & Video</span>
                    </a>

                    <a href="{{ route('admin.settings.visi-misi') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.settings.visi-misi*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span>Visi, Misi & Tujuan</span>
                    </a>

                    <a href="{{ route('admin.settings.header-footer') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.settings.header-footer*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span>Pengaturan Header & Footer</span>
                    </a>

                    <a href="{{ route('admin.organization.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.organization.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Struktur Organisasi (SDM)</span>
                    </a>
                </div>

                <!-- Kelompok: Manajemen Sistem Usulan -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-4">Manajemen Usulan (SIM)</div>
                    
                    <a href="{{ route('admin.proposals.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.proposals.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Proposal & Penugasan</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-yellow-500 text-slate-900 font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Akun Dosen & Reviewer</span>
                    </a>
                </div>

            </nav>
        </div>

        <!-- Bagian Bawah Sidebar -->
        <div class="p-4 border-t border-white/10 space-y-2 text-xs">
            <a href="/" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-colors leading-4">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Portal Publik</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-900/50 transition-colors leading-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Konten Utama Panel Admin -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        
        <!-- Header Bagian Atas -->
        <header class="bg-white border-b border-slate-200 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="text-xs font-semibold text-slate-500 leading-4">
                    @yield('breadcrumb', 'Panel Kerja Admin P3M')
                </div>
            </div>

            <!-- Profil User Admin & Role Switcher -->
            <div class="flex items-center gap-3">
                @if(Auth::check() && Auth::user()->isMultiRole())
                    <div x-data="{ roleSwitcherOpen: false }" class="relative">
                        <button @click="roleSwitcherOpen = !roleSwitcherOpen" 
                                type="button" 
                                class="inline-flex items-center gap-2 h-9 px-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-semibold text-slate-700 transition-colors shadow-2xs">
                            <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <span class="hidden md:inline">Pindah Peran</span>
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="roleSwitcherOpen" 
                             @click.away="roleSwitcherOpen = false" 
                             x-cloak 
                             class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50 text-xs">
                            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">Pilih Panel Peran</div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3 py-2 bg-purple-50 text-purple-900 font-semibold">
                                <span>Panel Administrator</span>
                                <span class="text-[10px] bg-purple-200 text-purple-800 px-1.5 py-0.5 rounded font-bold">Aktif</span>
                            </a>
                            @if(Auth::user()->isReviewer())
                                <a href="{{ route('reviewer.dashboard') }}" class="flex items-center justify-between px-3 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 font-medium transition-colors">
                                    <span>Portal Reviewer</span>
                                    <span class="text-xs text-slate-400">&rarr;</span>
                                </a>
                            @endif
                            @if(Auth::user()->isPeneliti())
                                <a href="{{ route('dosen.dashboard') }}" class="flex items-center justify-between px-3 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-900 font-medium transition-colors">
                                    <span>Portal Dosen / Peneliti</span>
                                    <span class="text-xs text-slate-400">&rarr;</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold text-slate-900 leading-4">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-yellow-600 font-semibold leading-3">Administrator P3M</div>
                </div>
                <div class="w-9 h-9 rounded-full bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Wadah Halaman Konten -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between leading-5 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Notifikasi Error -->
            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-center justify-between leading-5 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')

        </main>

        <!-- Footer Admin -->
        <footer class="py-4 px-6 text-center text-xs text-slate-400 bg-white border-t border-slate-200 leading-4">
            &copy; {{ date('Y') }} P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.
        </footer>

    </div>

    @stack('scripts')
</body>
</html>
