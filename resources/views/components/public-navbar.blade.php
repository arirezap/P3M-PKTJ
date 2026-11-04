@php
    $nav = $navSettings ?? \App\Models\Setting::getNavigationSettings();
@endphp
<!-- Top Mini Header (Identitas Kementerian Perhubungan & Status Autentikasi) -->
<div class="bg-[#0B2A59] text-slate-200 text-xs py-2 px-4 sm:px-6 lg:px-8 border-b border-yellow-500/30 leading-4">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <span class="font-medium tracking-wide">{{ $nav['top_bar_kemenhub'] ?? 'Kementerian Perhubungan Republik Indonesia' }}</span>
            <span class="text-slate-400 hidden md:inline">|</span>
            <span class="text-slate-300 hidden md:inline">{{ $nav['top_bar_bpsdm'] ?? 'BPSDM Perhubungan' }}</span>
        </div>
        
        @auth
            @php
                $user = auth()->user();
                $topDashboardUrl = $user->isAdmin() 
                    ? route('admin.dashboard') 
                    : ($user->isReviewer() ? route('reviewer.dashboard') : route('dosen.dashboard'));
                $topRoleLabel = $user->isAdmin() 
                    ? 'Admin' 
                    : ($user->isReviewer() ? 'Reviewer' : 'Dosen');
            @endphp
            <div class="flex items-center gap-3 text-xs text-slate-300">
                <span>Masuk: <strong class="text-white">{{ $user->name }}</strong> ({{ $topRoleLabel }})</span>
                <span class="text-slate-400">|</span>
                <a href="{{ $topDashboardUrl }}" class="text-yellow-400 font-semibold hover:underline">Dashboard</a>
                <span class="text-slate-400">|</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-300 hover:text-white hover:underline focus:outline-none">
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <div class="flex items-center gap-3 text-xs text-slate-300">
                <span class="hidden md:inline">{{ $nav['top_bar_campus_info'] ?? 'Kampus PKTJ Tegal: Jl. Semeru No. 3' }}</span>
                <span class="hidden md:inline text-slate-500">|</span>
                <span class="hidden sm:inline text-yellow-400/90 font-medium">{{ $nav['top_bar_tagline'] ?? 'Portal P3M PKTJ' }}</span>
                <span class="hidden sm:inline text-slate-500">|</span>
                <a href="{{ route('login') }}" class="text-slate-300 hover:text-yellow-400 transition-colors flex items-center gap-2 focus:outline-none py-1 px-2 rounded hover:bg-white/10" title="Login">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>{{ $nav['navbar_login_button'] ?? 'Login' }}</span>
                </a>
            </div>
        @endauth
    </div>
</div>

<!-- Main Navigation Bar (Responsif Anti-Patah & Anti-Menabrak di Layar Laptop 1024px-1280px) -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-xs" 
        x-data="{ mobileMenuOpen: false }"
        x-effect="if (mobileMenuOpen) { document.body.classList.add('overflow-hidden') } else { document.body.classList.remove('overflow-hidden') }"
        @keydown.escape.window="mobileMenuOpen = false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">
            
            <!-- Brand & Logo PKTJ -->
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-[#0B2A59] rounded-lg p-1 flex-shrink-0">
                <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-11 sm:h-12 w-auto object-contain">
                <div class="flex flex-col">
                    <span class="text-base sm:text-lg font-bold tracking-tight text-[#0B2A59] leading-6 whitespace-nowrap">{{ $nav['brand_title'] ?? 'P3M PKTJ' }}</span>
                    <span class="text-xs text-slate-500 font-medium leading-4 hidden 2xl:block whitespace-nowrap">{{ $nav['brand_subtitle_1'] ?? 'Pusat Penelitian & Pengabdian kepada Masyarakat' }}</span>
                    <span class="text-xs text-slate-500 font-medium leading-4 hidden xl:block 2xl:hidden whitespace-nowrap">{{ $nav['brand_subtitle_2'] ?? 'Politeknik Keselamatan Transportasi Jalan' }}</span>
                </div>
            </a>

            <!-- Desktop Navigation Menu (7 Menu Baku Seragam) -->
            <nav class="hidden lg:flex items-center gap-3 xl:gap-5 2xl:gap-6 text-sm font-medium leading-5 flex-shrink-0">
                <!-- 1. Beranda -->
                <a href="{{ route('beranda') }}" 
                   class="{{ request()->routeIs('beranda') ? 'font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1' : 'text-slate-700 hover:text-[#0B2A59] py-2' }} focus:outline-none whitespace-nowrap transition-colors">
                    {{ $nav['menu_beranda_label'] ?? 'Beranda' }}
                </a>
                
                <!-- 2. Profil Dropdown (5 Sub-Item) -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" 
                            class="flex items-center gap-1 {{ request()->routeIs('profil.*') ? 'font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1' : 'text-slate-700 hover:text-[#0B2A59] py-2' }} focus:outline-none focus:text-[#0B2A59] whitespace-nowrap transition-colors" 
                            :aria-expanded="open.toString()">
                        <span>{{ $nav['menu_profil_label'] ?? 'Profil' }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 pointer-events-none" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 top-full pt-2 w-64 z-50">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-lg py-2">
                            <a href="{{ route('profil.rencana-strategis') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('profil.rencana-strategis') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Rencana Strategis (Renstra)
                            </a>
                            <a href="{{ route('profil.roadmap-penelitian') }}" @click="open = false" 
                                class="block px-4 py-2 text-xs {{ request()->routeIs('profil.roadmap-penelitian') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Roadmap Penelitian
                            </a>
                            <a href="{{ route('profil.visi-misi') }}" @click="open = false" 
                                class="block px-4 py-2 text-xs {{ request()->routeIs('profil.visi-misi') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Visi, Misi & Tujuan
                            </a>
                            <a href="{{ route('profil.peneliti') }}" @click="open = false" 
                                class="block px-4 py-2 text-xs {{ request()->routeIs('profil.peneliti') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Profil Peneliti & Dosen
                            </a>
                            <a href="{{ route('profil.sdm') }}" @click="open = false" 
                                class="block px-4 py-2 text-xs {{ request()->routeIs('profil.sdm') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Sumber Daya Manusia (SDM)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Riset Dropdown (3 Sub-Item Baku) -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" 
                            class="flex items-center gap-1 {{ request()->routeIs('riset.*') ? 'font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1' : 'text-slate-700 hover:text-[#0B2A59] py-2' }} focus:outline-none focus:text-[#0B2A59] whitespace-nowrap transition-colors" 
                            :aria-expanded="open.toString()">
                        <span>{{ $nav['menu_riset_label'] ?? 'Riset' }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 pointer-events-none" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 top-full pt-2 w-64 z-50">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-lg py-2">
                            <a href="{{ route('riset.penelitian') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('riset.penelitian') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Kegiatan Penelitian
                            </a>
                            <a href="{{ route('riset.luaran') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('riset.luaran') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Luaran Penelitian (Publikasi, HKI, Produk)
                            </a>
                            <a href="{{ route('riset.kerjasama') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('riset.kerjasama') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Kerjasama Bidang Penelitian
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Pengabdian Dropdown (3 Sub-Item Baku) -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" 
                            class="flex items-center gap-1 {{ request()->routeIs('pengabdian.*') ? 'font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1' : 'text-slate-700 hover:text-[#0B2A59] py-2' }} focus:outline-none focus:text-[#0B2A59] whitespace-nowrap transition-colors" 
                            :aria-expanded="open.toString()">
                        <span>{{ $nav['menu_pengabdian_label'] ?? 'Pengabdian' }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 pointer-events-none" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 top-full pt-2 w-64 z-50">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-lg py-2">
                            <a href="{{ route('pengabdian.pkm') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('pengabdian.pkm') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Pengabdian Kepada Masyarakat
                            </a>
                            <a href="{{ route('pengabdian.luaran') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('pengabdian.luaran') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Hasil Analisis Luaran
                            </a>
                            <a href="{{ route('pengabdian.kerjasama') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('pengabdian.kerjasama') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Kerjasama Pengabdian
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 5. Layanan Dropdown (2 Sub-Item Baku) -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open" type="button" 
                            class="flex items-center gap-1 {{ request()->routeIs('layanan.*') ? 'font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1' : 'text-slate-700 hover:text-[#0B2A59] py-2' }} focus:outline-none focus:text-[#0B2A59] whitespace-nowrap transition-colors" 
                            :aria-expanded="open.toString()">
                        <span>{{ $nav['menu_layanan_label'] ?? 'Layanan' }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 pointer-events-none" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 top-full pt-2 w-64 z-50">
                        <div class="bg-white border border-slate-200 rounded-xl shadow-lg py-2">
                            <a href="{{ route('layanan.panduan-pedoman') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('layanan.panduan-pedoman') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Panduan dan Pedoman
                            </a>
                            <a href="{{ route('layanan.sop') }}" @click="open = false" 
                               class="block px-4 py-2 text-xs {{ request()->routeIs('layanan.sop') ? 'font-bold text-[#0B2A59] bg-blue-50' : 'font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]' }} leading-4">
                                Standar Operasional Prosedur (SOP)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 6. Tautan Jurnal PKTJ -->
                <a href="{{ $nav['navbar_jurnal_url'] ?? 'https://ktj.pktj.ac.id/' }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1 text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none whitespace-nowrap transition-colors">
                    <span>{{ $nav['navbar_jurnal_label'] ?? 'Jurnal' }}</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- 7. Tautan Menu Ekstra (Jika Diisi di CMS) -->
                @if(!empty($nav['navbar_custom_link_label']) && !empty($nav['navbar_custom_link_url']))
                    <a href="{{ $nav['navbar_custom_link_url'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1 text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none whitespace-nowrap transition-colors">
                        <span>{{ $nav['navbar_custom_link_label'] }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif
            </nav>

            <!-- 8. Tombol Aksi Pengguna Terautentikasi (Hanya Tampil Jika Login) -->
            @auth
                <div class="hidden sm:flex items-center gap-2 flex-shrink-0">
                    @php
                        $user = auth()->user();
                        $dashboardUrl = $user->isAdmin() 
                            ? route('admin.dashboard') 
                            : ($user->isReviewer() ? route('reviewer.dashboard') : route('dosen.dashboard'));
                        $portalLabel = $user->isAdmin() 
                            ? 'Panel Admin' 
                            : ($user->isReviewer() ? 'Portal Reviewer' : 'Portal Dosen');
                    @endphp
                    <a href="{{ $dashboardUrl }}" class="inline-flex items-center gap-2 h-10 px-4 text-xs xl:text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 rounded-lg transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] leading-5 whitespace-nowrap">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>{{ $portalLabel }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari sistem SIM P3M" class="inline-flex items-center justify-center h-10 px-3 text-xs font-semibold text-slate-600 hover:text-rose-600 bg-slate-100 hover:bg-rose-50 border border-slate-200 rounded-lg transition-colors leading-5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="sr-only">Keluar</span>
                        </button>
                    </form>
                </div>
            @endauth

            <!-- Tombol Aksi Langsung & Hamburger Mobile (< 1024px) -->
            <div class="flex items-center gap-2 lg:hidden flex-shrink-0">
                <!-- Pintasan Dashboard Mobile (< 640px jika login) -->
                @auth
                    @php
                        $user = auth()->user();
                        $mobileDirectUrl = $user->isAdmin() 
                            ? route('admin.dashboard') 
                            : ($user->isReviewer() ? route('reviewer.dashboard') : route('dosen.dashboard'));
                    @endphp
                    <div class="sm:hidden">
                        <a href="{{ $mobileDirectUrl }}" class="inline-flex items-center justify-center h-10 px-3 text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 rounded-lg transition-colors leading-4">
                            Portal
                        </a>
                    </div>
                @endauth

                <!-- Tombol Hamburger Mobile (Tap target 48x48px) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center w-12 h-12 rounded-lg text-slate-700 hover:text-[#0B2A59] hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] transition-colors" aria-label="Buka menu navigasi utama">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Navigation (Multi-Device Responsive, Seragam 100%) -->
    <div x-show="mobileMenuOpen" x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lg:hidden border-t border-slate-200 bg-white px-4 pt-4 pb-28 space-y-4 shadow-2xl max-h-[calc(100vh-5rem)] max-h-[calc(100dvh-5rem)] overflow-y-auto overscroll-contain touch-pan-y [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-thumb]:bg-slate-300 [&::-webkit-scrollbar-thumb]:rounded-full">
        <a href="{{ route('beranda') }}" @click="mobileMenuOpen = false" 
           class="flex items-center min-h-[44px] px-3 py-2 text-sm font-semibold {{ request()->routeIs('beranda') ? 'text-[#0B2A59] bg-blue-50/80 border-l-4 border-yellow-500 font-bold' : 'text-slate-700 hover:bg-slate-50' }} rounded-r-lg leading-5 transition-colors">
            {{ $nav['menu_beranda_label'] ?? 'Beranda' }}
        </a>
        
        <div class="pt-2 border-t border-slate-100">
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider leading-4 px-2">{{ $nav['menu_profil_label'] ?? 'Profil' }}</span>
            <div class="mt-1 space-y-1">
                <a href="{{ route('profil.rencana-strategis') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('profil.rencana-strategis') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Rencana Strategis (Renstra 2026-2031)
                </a>
                <a href="{{ route('profil.roadmap-penelitian') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('profil.roadmap-penelitian') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Roadmap Penelitian
                </a>
                <a href="{{ route('profil.visi-misi') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('profil.visi-misi') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Visi, Misi & Tujuan
                </a>
                <a href="{{ route('profil.peneliti') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('profil.peneliti') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Profil Peneliti & Dosen
                </a>
                <a href="{{ route('profil.sdm') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('profil.sdm') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Sumber Daya Manusia (SDM)
                </a>
            </div>
        </div>

        <div class="pt-2 border-t border-slate-100">
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider leading-4 px-2">{{ $nav['menu_riset_label'] ?? 'Riset' }}</span>
            <div class="mt-1 space-y-1">
                <a href="{{ route('riset.penelitian') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('riset.penelitian') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Kegiatan Penelitian
                </a>
                <a href="{{ route('riset.luaran') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('riset.luaran') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Luaran Penelitian (Publikasi, HKI, Produk)
                </a>
                <a href="{{ route('riset.kerjasama') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('riset.kerjasama') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Kerjasama Bidang Penelitian
                </a>
            </div>
        </div>

        <div class="pt-2 border-t border-slate-100">
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider leading-4 px-2">{{ $nav['menu_pengabdian_label'] ?? 'Pengabdian' }}</span>
            <div class="mt-1 space-y-1">
                <a href="{{ route('pengabdian.pkm') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('pengabdian.pkm') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Pengabdian Kepada Masyarakat
                </a>
                <a href="{{ route('pengabdian.luaran') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('pengabdian.luaran') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Hasil Analisis Luaran
                </a>
                <a href="{{ route('pengabdian.kerjasama') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('pengabdian.kerjasama') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Kerjasama Pengabdian
                </a>
            </div>
        </div>

        <div class="pt-2 border-t border-slate-100">
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider leading-4 px-2">{{ $nav['menu_layanan_label'] ?? 'Layanan' }}</span>
            <div class="mt-1 space-y-1">
                <a href="{{ route('layanan.panduan-pedoman') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('layanan.panduan-pedoman') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Panduan dan Pedoman
                </a>
                <a href="{{ route('layanan.sop') }}" @click="mobileMenuOpen = false" 
                   class="flex items-center min-h-[44px] px-3 py-2 rounded-lg text-xs {{ request()->routeIs('layanan.sop') ? 'font-bold text-[#0B2A59] bg-blue-50 border-l-2 border-yellow-500' : 'font-medium text-slate-700 hover:bg-slate-50' }} leading-4 transition-colors">
                    Standar Operasional Prosedur (SOP)
                </a>
            </div>
        </div>

        <div class="pt-2 border-t border-slate-100">
            <a href="{{ $nav['navbar_jurnal_url'] ?? 'https://ktj.pktj.ac.id/' }}" target="_blank" rel="noopener noreferrer" @click="mobileMenuOpen = false" 
               class="flex items-center justify-between min-h-[44px] px-3 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59] leading-4 transition-colors">
                <span>{{ $nav['navbar_jurnal_label'] ?? 'Jurnal' }}</span>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>

        @if(!empty($nav['navbar_custom_link_label']) && !empty($nav['navbar_custom_link_url']))
            <div class="pt-2 border-t border-slate-100">
                <a href="{{ $nav['navbar_custom_link_url'] }}" target="_blank" rel="noopener noreferrer" @click="mobileMenuOpen = false" 
                   class="flex items-center justify-between min-h-[44px] px-3 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59] leading-4 transition-colors">
                    <span>{{ $nav['navbar_custom_link_label'] }}</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        @endif

        <!-- Bagian Autentikasi / Panel Akun pada Mobile Drawer (Hanya Tampil Jika Terautentikasi) -->
        @auth
            <div class="pt-4 border-t border-slate-200">
                @php
                    $user = auth()->user();
                    $drawerDashboardUrl = $user->isAdmin() 
                        ? route('admin.dashboard') 
                        : ($user->isReviewer() ? route('reviewer.dashboard') : route('dosen.dashboard'));
                    $drawerPortalLabel = $user->isAdmin() 
                        ? 'Buka Panel Admin' 
                        : ($user->isReviewer() ? 'Buka Portal Reviewer' : 'Buka Portal Dosen');
                    $drawerRoleName = $user->isAdmin() 
                        ? 'Administrator P3M' 
                        : ($user->isReviewer() ? 'Reviewer Proposal' : 'Dosen Peneliti');
                @endphp
                <div class="space-y-3">
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-slate-800 leading-4">{{ $user->name }}</div>
                            <div class="text-[11px] text-slate-500 leading-3">{{ $drawerRoleName }}</div>
                        </div>
                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-100 text-[#0B2A59]">Aktif</span>
                    </div>
                    <a href="{{ $drawerDashboardUrl }}" class="flex items-center justify-center gap-2 w-full h-12 text-sm font-semibold text-white bg-[#0B2A59] rounded-lg shadow-sm leading-5">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>{{ $drawerPortalLabel }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full h-11 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100 transition-colors leading-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Keluar dari SIM P3M</span>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</header>
