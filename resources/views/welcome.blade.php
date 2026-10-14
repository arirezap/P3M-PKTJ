<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>P3M PKTJ - Pusat Penelitian dan Pengabdian kepada Masyarakat</title>

    <!-- Meta SEO -->
    <meta name="description" content="Portal Resmi Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal.">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-700 antialiased font-sans flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <!-- Top Mini Header (Institutional Identity) -->
    <div class="bg-[#0B2A59] text-slate-200 text-xs py-2 px-4 sm:px-8 border-b border-yellow-500/30">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
                <span class="font-medium tracking-wide">Kementerian Perhubungan Republik Indonesia</span>
            </div>
            <div class="text-slate-300 text-[11px] sm:text-xs">
                Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand & Logo -->
                <a href="/" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-[#0B2A59] rounded-lg p-1">
                    <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-12 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-tight text-[#0B2A59] leading-tight">P3M PKTJ</span>
                        <span class="text-[11px] text-slate-500 font-medium leading-tight">Pusat Penelitian & Pengabdian kepada Masyarakat</span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="#beranda" class="text-sm font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1">Beranda</a>
                    
                    <!-- Profil Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none">
                            <span>Profil</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-0 mt-1 w-56 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50">
                            <a href="#renstra" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Rencana Strategis (Renstra)</a>
                            <a href="#roadmap" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Roadmap Penelitian</a>
                            <a href="#visimisi" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Visi, Misi & Tujuan</a>
                            <a href="#peneliti" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Profil Peneliti & Dosen</a>
                            <a href="#sdm" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Struktur Organisasi (SDM)</a>
                        </div>
                    </div>

                    <!-- Riset Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none">
                            <span>Riset</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="absolute left-0 mt-1 w-56 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50">
                            <a href="#kegiatan-riset" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Kegiatan Penelitian</a>
                            <a href="#luaran-riset" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Luaran (Publikasi, HKI, Produk)</a>
                            <a href="#kerjasama-riset" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Kerjasama Penelitian</a>
                        </div>
                    </div>

                    <!-- Pengabdian Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none">
                            <span>Pengabdian</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="absolute left-0 mt-1 w-56 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50">
                            <a href="#kegiatan-pkm" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Kegiatan Pengabdian (PkM)</a>
                            <a href="#luaran-pkm" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Luaran Pengabdian</a>
                            <a href="#kerjasama-pkm" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Kerjasama Pengabdian</a>
                        </div>
                    </div>

                    <!-- Layanan Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium text-slate-700 hover:text-[#0B2A59] py-2 focus:outline-none">
                            <span>Layanan</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="absolute left-0 mt-1 w-56 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50">
                            <a href="#panduan" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">Panduan & Pedoman</a>
                            <a href="#sop" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]">SOP Penelitian & Pengabdian</a>
                        </div>
                    </div>

                    <!-- Jurnal Link -->
                    <a href="https://ejournal.pktj.ac.id" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1 text-sm font-medium text-slate-700 hover:text-[#0B2A59]">
                        <span>Jurnal</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </nav>

                <!-- Action Button (Login / SIM P3M) -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="/login" class="inline-flex items-center justify-center h-10 px-5 text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 rounded-lg transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59]">
                        Login SIM P3M
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center w-11 h-11 rounded-lg text-slate-700 hover:text-[#0B2A59] hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#0B2A59]" aria-label="Buka menu navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div x-show="mobileMenuOpen" x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="#beranda" @click="mobileMenuOpen = false" class="block py-2 text-sm font-semibold text-[#0B2A59] border-l-4 border-yellow-500 pl-3">Beranda</a>
            
            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Profil</span>
                <div class="pl-2 mt-1 space-y-1">
                    <a href="#renstra" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Rencana Strategis (Renstra)</a>
                    <a href="#roadmap" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Roadmap Penelitian</a>
                    <a href="#visimisi" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Visi, Misi & Tujuan</a>
                    <a href="#peneliti" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Profil Peneliti & Dosen</a>
                    <a href="#sdm" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Struktur Organisasi</a>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Riset & Inovasi</span>
                <div class="pl-2 mt-1 space-y-1">
                    <a href="#kegiatan-riset" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Kegiatan Penelitian</a>
                    <a href="#luaran-riset" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Luaran (Publikasi, HKI, Produk)</a>
                    <a href="#kerjasama-riset" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Kerjasama Riset</a>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Pengabdian (PkM)</span>
                <div class="pl-2 mt-1 space-y-1">
                    <a href="#kegiatan-pkm" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Kegiatan Pengabdian</a>
                    <a href="#luaran-pkm" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Luaran Pengabdian</a>
                    <a href="#kerjasama-pkm" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Kerjasama Pengabdian</a>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Layanan</span>
                <div class="pl-2 mt-1 space-y-1">
                    <a href="#panduan" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">Panduan & Pedoman</a>
                    <a href="#sop" @click="mobileMenuOpen = false" class="block py-1.5 text-xs font-medium text-slate-700">SOP Penelitian & SOP Pengabdian</a>
                    <a href="https://ejournal.pktj.ac.id" target="_blank" class="block py-1.5 text-xs font-medium text-slate-700">Portal Jurnal OJS ↗</a>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200">
                <a href="/login" class="flex items-center justify-center w-full h-11 text-sm font-semibold text-white bg-[#0B2A59] rounded-lg">
                    Login SIM P3M
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">

        <!-- Hero Section -->
        <section id="beranda" class="relative bg-white border-b border-slate-200 py-16 sm:py-20 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Column: Copy & CTAs -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-slate-100 border border-slate-200 text-xs font-semibold text-[#0B2A59]">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                            <span>Pusat Penelitian & Pengabdian kepada Masyarakat</span>
                        </div>

                        <div class="space-y-3">
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                Riset Unggulan & Pengabdian Berbasis <span class="text-[#0B2A59]">Keselamatan Transportasi</span>
                            </h1>
                            <div class="w-16 h-1 bg-yellow-500 rounded"></div>
                        </div>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                            Mewujudkan inovasi iptek terapan yang solutif, berdaya saing, dan berorientasi pada peningkatan keselamatan serta efisiensi transportasi jalan nasional melalui sinergi sivitas akademika PKTJ.
                        </p>

                        <!-- Action Buttons (Strict 4px grid: h-12 = 48px, px-6 = 24px) -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                            <a href="#kegiatan-riset" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59]">
                                Jelajahi Data Riset & PkM
                            </a>
                            <a href="#panduan" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors focus:ring-2 focus:ring-slate-300">
                                Unduh Panduan & SOP
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Institutional Identity Card / Video Profile -->
                    <div class="lg:col-span-5">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-16 w-auto object-contain">
                                <div>
                                    <h2 class="text-base font-bold text-slate-900 leading-snug">P3M PKTJ Tegal</h2>
                                    <p class="text-xs text-slate-500">Badan Pengembangan SDM Perhubungan</p>
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed border-t border-slate-200 pt-4">
                                Mengelola skema penelitian dasar, terapan, dan pengabdian masyarakat dosen vokasi guna mendukung kebijakan keselamatan jalan Kementerian Perhubungan RI.
                            </p>

                            <div class="space-y-3 pt-2">
                                <div class="flex items-center justify-between text-xs py-2 border-b border-slate-200/80">
                                    <span class="text-slate-500 font-medium">Periode Renstra Aktif</span>
                                    <span class="font-semibold text-[#0B2A59]">2026 – 2031</span>
                                </div>
                                <div class="flex items-center justify-between text-xs py-2 border-b border-slate-200/80">
                                    <span class="text-slate-500 font-medium">Fokus Bidang</span>
                                    <span class="font-semibold text-[#0B2A59]">Keselamatan & Otomasi Jalan</span>
                                </div>
                                <div class="flex items-center justify-between text-xs py-2">
                                    <span class="text-slate-500 font-medium">Status Pendaftaran Hibah</span>
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Dibuka
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Quick Stats Counter (Clean & Direct) -->
        <section class="bg-slate-50 border-b border-slate-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-white border border-slate-200 rounded-xl p-6 text-center space-y-1">
                        <div class="text-3xl font-extrabold text-[#0B2A59]">128+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Kegiatan Penelitian</div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-6 text-center space-y-1">
                        <div class="text-3xl font-extrabold text-[#0B2A59]">84+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Kegiatan Pengabdian</div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-6 text-center space-y-1">
                        <div class="text-3xl font-extrabold text-[#0B2A59]">45+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">HKI & Paten Terdaftar</div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-xl p-6 text-center space-y-1">
                        <div class="text-3xl font-extrabold text-[#0B2A59]">32+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Mitra Kerjasama</div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Section: Layanan Dokumen & Regulasi (Renstra, Roadmap, SOP) -->
        <section id="panduan" class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600">Pusat Layanan Dokumen</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] mt-1">Panduan, Pedoman & SOP</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md">
                        Akses resmi dokumen rencana strategis, pedoman pengajuan proposal, dan standar operasional prosedur P3M PKTJ.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Dokumen 1: Renstra -->
                    <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between hover:border-slate-300 transition-colors space-y-4">
                        <div class="space-y-2">
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-[#0B2A59]">Renstra</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">Rencana Strategis Penelitian 2026–2031</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Dokumen arah kebijakan dan target capaian penelitian 5 tahun ke depan.</p>
                        </div>
                        <a href="#" class="inline-flex items-center gap-2 text-xs font-semibold text-[#0B2A59] hover:underline pt-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>

                    <!-- Dokumen 2: Roadmap -->
                    <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between hover:border-slate-300 transition-colors space-y-4">
                        <div class="space-y-2">
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-yellow-50 text-yellow-800">Peta Jalan</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">Roadmap Penelitian Keselamatan Jalan</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Peta jalan riset terpadu fokus teknologi keselamatan transportasi darat.</p>
                        </div>
                        <a href="#" class="inline-flex items-center gap-2 text-xs font-semibold text-[#0B2A59] hover:underline pt-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>

                    <!-- Dokumen 3: SOP Penelitian -->
                    <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between hover:border-slate-300 transition-colors space-y-4">
                        <div class="space-y-2">
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">SOP</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">SOP Pelaksanaan Penelitian Dosen</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Alur pengajuan, desk evaluasi, monev, hingga penyusunan laporan akhir (LPJ).</p>
                        </div>
                        <a href="#" class="inline-flex items-center gap-2 text-xs font-semibold text-[#0B2A59] hover:underline pt-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>

                    <!-- Dokumen 4: SOP Pengabdian -->
                    <div class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between hover:border-slate-300 transition-colors space-y-4">
                        <div class="space-y-2">
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">SOP</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">SOP Pengabdian kepada Masyarakat</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Standar prosedur kemitraan masyarakat desa dan pelatihan binaan.</p>
                        </div>
                        <a href="#" class="inline-flex items-center gap-2 text-xs font-semibold text-[#0B2A59] hover:underline pt-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Section: Callout SIM P3M (Alur Pengajuan Riset) -->
        <section class="py-16 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-[#0B2A59] rounded-2xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="space-y-3 max-w-2xl">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-400">Sistem Informasi Manajemen</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Siap Mengajukan Proposal Penelitian atau PkM?</h2>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Kirimkan usulan proposal riset dan pengabdian Anda, ajukan rincian anggaran biaya (RAB), dan pantau tahapan proses review secara transparan hingga penetapan keputusan.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="/login" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-bold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400">
                            Masuk ke Portal Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Official Kemenhub Dark Navy Footer -->
    <footer class="bg-[#0B2A59] text-slate-300 border-t border-yellow-500/30 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
                
                <!-- Institutional Info -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-12 w-auto object-contain">
                        <div>
                            <div class="text-base font-bold text-white leading-tight">P3M PKTJ</div>
                            <div class="text-xs text-slate-400">Politeknik Keselamatan Transportasi Jalan</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed max-w-sm">
                        Lembaga pengelola penelitian, publikasi ilmiah, Hak Kekayaan Intelektual (HKI), dan pengabdian kepada masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan Tegal.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <div>Jl. Semeru No. 3, Tegal, Jawa Tengah 52125</div>
                        <div>Email: <a href="mailto:p3m@pktj.ac.id" class="text-yellow-400 hover:underline">p3m@pktj.ac.id</a></div>
                    </div>
                </div>

                <!-- Navigasi Cepat -->
                <div class="lg:col-span-3 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Utama</div>
                    <ul class="text-xs space-y-2">
                        <li><a href="#renstra" class="hover:text-yellow-400 transition-colors">Rencana Strategis 2026–2031</a></li>
                        <li><a href="#roadmap" class="hover:text-yellow-400 transition-colors">Roadmap Penelitian</a></li>
                        <li><a href="#kegiatan-riset" class="hover:text-yellow-400 transition-colors">Data Kegiatan Riset & PkM</a></li>
                        <li><a href="#luaran-riset" class="hover:text-yellow-400 transition-colors">Publikasi & HKI Dosen</a></li>
                        <li><a href="#peneliti" class="hover:text-yellow-400 transition-colors">Direktori Dosen & Kepakaran</a></li>
                    </ul>
                </div>

                <!-- Tautan Resmi & Regulasi -->
                <div class="lg:col-span-4 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-white">Tautan Terkait</div>
                    <ul class="text-xs space-y-2">
                        <li><a href="https://pktj.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">Website Resmi PKTJ Tegal ↗</a></li>
                        <li><a href="https://dephub.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">Kementerian Perhubungan RI ↗</a></li>
                        <li><a href="https://ejournal.pktj.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">Portal Jurnal OJS PKTJ ↗</a></li>
                        <li><a href="https://sinta.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">SINTA Kemdiktisaintek ↗</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright & Disclaimer -->
            <div class="pt-8 border-t border-slate-700/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <div>
                    &copy; {{ date('Y') }} P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <span class="text-slate-500">Standar UI: Grid 4px & Multi-Device Responsive</span>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
