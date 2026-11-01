<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dasbor') - SIM P3M PKTJ</title>

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-700 antialiased font-sans min-h-screen flex flex-col justify-between">

    <!-- Header Dasbor SIM P3M -->
    <header class="bg-[#0B2A59] text-white sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                
                <!-- Brand & Logo -->
                <div class="flex items-center gap-3">
                    <a href="/" target="_blank" class="flex items-center gap-2 group focus:outline-none">
                        <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-10 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold tracking-tight text-white leading-4">SIM P3M</span>
                            <span class="text-[10px] text-yellow-400 font-medium leading-3">Politeknik Keselamatan Transportasi Jalan</span>
                        </div>
                    </a>
                    <span class="text-slate-400 hidden sm:inline">|</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-white/10 text-slate-200 border border-white/20 hidden md:inline leading-4">
                        @yield('portal_name', 'Portal Pengguna')
                    </span>
                </div>

                <!-- User Profile & Tombol Keluar (Logout) -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-semibold text-white leading-4">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-yellow-300 font-medium leading-3">
                            {{ ucfirst(Auth::user()->role) }} @if(Auth::user()->prodi) • {{ Auth::user()->prodi->kode_prodi }} @endif
                        </span>
                    </div>

                    <a href="/" target="_blank" class="hidden lg:inline-flex items-center gap-1.5 h-9 px-3 text-xs font-medium text-slate-200 hover:text-white bg-white/10 hover:bg-white/20 rounded-lg transition-colors leading-4">
                        <span>Portal Publik</span>
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <!-- Tombol Keluar Form -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center justify-center h-9 px-3 text-xs font-semibold text-white bg-rose-700 hover:bg-rose-800 rounded-lg transition-all duration-150 active:scale-[0.98] focus:outline-none leading-4">
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- Konten Halaman Dasbor -->
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full space-y-6">
        
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

    <!-- Footer Dasbor -->
    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200 bg-white leading-4">
        &copy; {{ date('Y') }} P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.
    </footer>

</body>
</html>
