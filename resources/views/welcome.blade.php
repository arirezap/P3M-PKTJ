@extends('layouts.public')

@section('title', 'P3M PKTJ - Pusat Penelitian dan Pengabdian kepada Masyarakat')
@section('meta_description', 'Portal Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal. Riset unggulan keselamatan transportasi jalan dan pengabdian vokasi.')

@section('content')
<div x-data="{ 
    isReaderOpen: false, 
    currentPost: null, 
    postsList: {{ Js::from($postsData) }},
    openReaderById(id) { 
        const found = this.postsList.find(p => p.id === id);
        if (found) {
            this.currentPost = found; 
            this.isReaderOpen = true; 
            document.body.classList.add('overflow-hidden'); 
        }
    }, 
    closeReader() { 
        this.isReaderOpen = false; 
        this.currentPost = null; 
        document.body.classList.remove('overflow-hidden'); 
    } 
}"
@keydown.escape.window="closeReader()">

<main class="flex-1">

        <!-- 1. Hero Section (Integrasi Video Profil Langsung di Hero Banner) -->
        <section id="beranda" 
                 x-data="{ heroLoaded: false }" 
                 x-init="setTimeout(() => heroLoaded = true, 50)" 
                 class="relative bg-white border-b border-slate-200 py-12 sm:py-16 lg:py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-center">
                    
                    <!-- Left Column: Copywriting & Action Buttons (7 Kolom) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- Headline Utama -->
                        <div class="space-y-4 transition-all duration-300 ease-out transform"
                             :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                                <span>Pusat Penelitian & Pengabdian kepada Masyarakat PKTJ</span>
                            </div>
                            <h1 class="text-3xl sm:text-4xl lg:text-[40px] xl:text-[44px] font-extrabold text-slate-900 tracking-tight leading-[40px] sm:leading-[48px] lg:leading-[50px] xl:leading-[54px]">
                                Riset Unggulan & Pengabdian Berbasis <span class="text-[#0B2A59]">Keselamatan Transportasi Jalan</span>
                            </h1>
                            <div class="w-20 h-1 bg-yellow-500 rounded"></div>
                        </div>

                        <!-- Paragraf Pengantar -->
                        <p class="text-base sm:text-lg text-slate-600 leading-7 sm:leading-8 max-w-2xl transition-all duration-300 delay-100 ease-out transform"
                           :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                            Mewujudkan inovasi iptek terapan yang solutif, berdaya saing, dan berorientasi pada peningkatan keselamatan serta efisiensi transportasi darat nasional melalui sinergi sivitas akademika Politeknik Keselamatan Transportasi Jalan Tegal.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2 transition-all duration-300 delay-200 ease-out transform"
                             :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                            <a href="#kegiatan-riset" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] leading-5 whitespace-nowrap">
                                Jelajahi Data Riset & PkM
                            </a>
                            <a href="#layanan-dokumen" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 active:scale-[0.98] focus:ring-2 focus:ring-slate-300 leading-5 whitespace-nowrap">
                                Unduh Panduan & SOP
                            </a>
                        </div>

                        <!-- Mini Info Bar -->
                        <div class="pt-4 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs leading-4">
                            <div>
                                <span class="text-slate-400 block text-[11px]">Periode Renstra</span>
                                <span class="font-bold text-[#0B2A59]">2026 - 2031</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Program Studi PKTJ</span>
                                <span class="font-bold text-[#0B2A59]">3 Program Studi</span>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <span class="text-slate-400 block text-[11px]">Penerimaan Hibah</span>
                                <span class="font-bold text-emerald-700">Dibuka via SIM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Video Profil P3M PKTJ (5 Kolom - Responsive 16:9 Direct Embed) -->
                    <div id="video-profil" 
                         class="lg:col-span-5 transition-all duration-400 delay-150 ease-out transform"
                         :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                        
                        <div class="bg-[#0B2A59] rounded-2xl p-4 sm:p-5 shadow-2xl border-2 border-slate-200 space-y-3">
                            <div class="flex items-center justify-between text-white">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                                    <span class="text-xs font-bold uppercase tracking-wider leading-4">Video Profil P3M</span>
                                </div>
                                <span class="text-[10px] font-semibold bg-yellow-400 text-[#0B2A59] px-2 py-0.5 rounded leading-3">PKTJ Tegal</span>
                            </div>

                            <!-- 16:9 Aspect Ratio Video Frame -->
                            <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-950 border border-slate-700 shadow-inner">
                                <iframe src="{{ $videoEmbedUrl }}" 
                                        class="w-full h-full" 
                                        title="{{ $settings['video_profile_title'] ?? 'Video Profil P3M PKTJ Tegal' }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        loading="lazy">
                                </iframe>
                            </div>

                            <div class="pt-1">
                                <h2 class="text-sm font-bold text-white leading-5">
                                    {{ $settings['video_profile_title'] ?? 'Video Profil P3M PKTJ Tegal' }}
                                </h2>
                                <p class="text-xs text-slate-300 leading-4 mt-0.5 line-clamp-2">
                                    {{ $settings['video_profile_desc'] ?? 'Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi' }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- 2. Tentang P3M PKTJ (Institutional Overview & 3 Official Prodis) -->
        <section id="tentang-p3m" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
            <!-- Anchor alias untuk tautan lama #profil-lembaga -->
            <div id="profil-lembaga" class="relative -top-24"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center max-w-3xl mx-auto space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Profil Kelembagaan P3M</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">
                        Tentang Pusat Penelitian dan Pengabdian kepada Masyarakat
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-6">
                        {{ $settings['about_lead'] ?? 'Unit pelaksana akademik di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.' }}
                    </p>
                </div>

                <!-- Grid 2 Kolom Kokoh Anti-Kolaps (grid-cols-1 lg:grid-cols-2 gap-8 w-full) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full items-stretch">
                    
                    <!-- Kolom Kiri: Mandat Kelembagaan & 4 Pilar Layanan -->
                    <div class="w-full bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-sm space-y-6">
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4">
                                <span>Profil & Mandat Kelembagaan</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 leading-7">
                                Mengakselerasi Riset Keselamatan Jalan & Pemberdayaan Vokasi Nasional
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-6">
                                {{ $settings['about_vision_mission'] ?? 'P3M PKTJ berkomitmen menghasilkan inovasi teknologi terapan yang solutif guna menurunkan angka fatalitas kecelakaan lalu lintas, mengoptimalkan kelaikan kendaraan bermotor, dan mentransfer pengetahuan ilmiah langsung kepada masyarakat, instansi pemerintah daerah, dan industri transportasi.' }}
                            </p>
                        </div>

                        <!-- 4 Pilar Layanan Riset & PkM -->
                        <div class="pt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0B2A59] leading-4">Riset Terapan Keselamatan</div>
                                <p class="text-xs text-slate-500 leading-5">Audit geometri jalan, penanganan black spot, dan ITS.</p>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0B2A59] leading-4">Pengabdian Aksi Nyata</div>
                                <p class="text-xs text-slate-500 leading-5">Edukasi berkendara aman, bengkel binaan, dan desa mitra.</p>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0B2A59] leading-4">Sentra HKI & Paten</div>
                                <p class="text-xs text-slate-500 leading-5">Fasilitasi hak cipta, desain industri, dan paten invensi.</p>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-[#0B2A59] leading-4">Publikasi Jurnal SINTA</div>
                                <p class="text-xs text-slate-500 leading-5">Pengelolaan jurnal berkala terakreditasi OJS PKTJ.</p>
                            </div>
                        </div>

                        <!-- Tautan Menuju Halaman Lengkap Visi, Misi & Tujuan -->
                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <span class="text-xs text-slate-500 leading-4">Haluan Mutu & Sasaran Strategis 2031:</span>
                            <a href="{{ route('profil.visi-misi') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0B2A59] hover:text-blue-900 transition-colors group">
                                <span>Lihat Visi, Misi & Tujuan Lengkap</span>
                                <svg class="w-4 h-4 text-yellow-500 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Kolom Kanan: 3 Program Studi PKTJ -->
                    <div class="w-full bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col justify-between shadow-sm space-y-6">
                        <div class="space-y-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pilar Riset & Pengabdian</span>
                            <h3 class="text-xl font-bold text-slate-900 leading-7">
                                3 Program Studi PKTJ Tegal
                            </h3>
                            <p class="text-xs text-slate-500 leading-5">
                                Seluruh kegiatan penelitian terapan dan pengabdian masyarakat diampu oleh kepakaran dosen dari tiga program studi di lingkungan PKTJ:
                            </p>
                        </div>

                        <!-- 3 Kartu Program Studi -->
                        <div class="space-y-3">
                            
                            <!-- Prodi 1: D4 RSTJ -->
                            <div class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-4 transition-all duration-200">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="text-sm font-bold text-[#0B2A59] leading-5">D4 RSTJ</div>
                                    <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                                </div>
                                <div class="text-xs font-semibold text-slate-800 leading-4">Rekayasa Sistem Transportasi Jalan</div>
                                <p class="text-xs text-slate-500 leading-5 mt-1">
                                    Fokus pada audit keselamatan infrastruktur jalan, permodelan lalu lintas perkotaan, penanganan titik rawan kecelakaan (black spot) Pantura, dan Intelligent Transportation Systems (ITS).
                                </p>
                            </div>

                            <!-- Prodi 2: D4 TRO -->
                            <div class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-4 transition-all duration-200">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="text-sm font-bold text-[#0B2A59] leading-5">D4 TRO</div>
                                    <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                                </div>
                                <div class="text-xs font-semibold text-slate-800 leading-4">Teknologi Rekayasa Otomotif</div>
                                <p class="text-xs text-slate-500 leading-5 mt-1">
                                    Fokus pada uji kelaikan armada angkutan jalan, rekayasa sistem rem dan dinamika kendaraan, konversi kendaraan listrik (EV), dan pengujian keselamatan konstruksi bodi armada.
                                </p>
                            </div>

                            <!-- Prodi 3: D3 TO -->
                            <div class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-4 transition-all duration-200">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="text-sm font-bold text-[#0B2A59] leading-5">D3 TO</div>
                                    <span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 font-semibold text-[10px] leading-4">Diploma Tiga</span>
                                </div>
                                <div class="text-xs font-semibold text-slate-800 leading-4">Teknologi Otomotif</div>
                                <p class="text-xs text-slate-500 leading-5 mt-1">
                                    Fokus pada standardisasi pemeliharaan teknis armada, uji emisi gas buang berkala, keselamatan komponen mekanikal kendaraan, dan transfer iptek ke bengkel mitra masyarakat.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- 3 Kartu Fasilitas & Capaian Unggulan (Dinamis dari CMS) -->
                <div class="pt-6 border-t border-slate-200">
                    <div class="text-center max-w-xl mx-auto mb-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Dukungan Sarana & Lapangan</span>
                        <h4 class="text-lg font-bold text-[#0B2A59] mt-1 leading-6">Fasilitas & Lapangan Riset PKTJ</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 space-y-2 shadow-sm hover:shadow transition-all duration-200">
                            <div class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Fasilitas Uji</div>
                            <h5 class="text-sm font-bold text-slate-900 leading-5">{{ $settings['facility_1_title'] ?? 'Laboratorium Uji Keselamatan' }}</h5>
                            <p class="text-xs text-slate-500 leading-5">
                                {{ $settings['facility_1_desc'] ?? 'Fasilitas uji terstandar untuk simulasi dinamika kendaraan, uji pengereman aktif, dan visualisasi geometri jalan.' }}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 space-y-2 shadow-sm hover:shadow transition-all duration-200">
                            <div class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Riset Koridor</div>
                            <h5 class="text-sm font-bold text-slate-900 leading-5">{{ $settings['facility_2_title'] ?? 'Audit Koridor Pantura Jawa' }}</h5>
                            <p class="text-xs text-slate-500 leading-5">
                                {{ $settings['facility_2_desc'] ?? 'Survei lapangan berkala di koridor pantai utara Jawa Tengah untuk memetakan titik rawan kecelakaan (black spot).' }}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 space-y-2 shadow-sm hover:shadow transition-all duration-200">
                            <div class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Dampak Sosial</div>
                            <h5 class="text-sm font-bold text-slate-900 leading-5">{{ $settings['facility_3_title'] ?? 'Aksi Nyata Pengabdian' }}</h5>
                            <p class="text-xs text-slate-500 leading-5">
                                {{ $settings['facility_3_desc'] ?? 'Sosialisasi budaya keselamatan berkendara bagi pelajar, pengemudi angkutan umum, dan bengkel mitra binaan.' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 4. Quick Access Service Grid (5 Layanan Prioritas dengan Animasi Hover Lift Halus) -->
        <section id="quick-access" class="py-12 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-8">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Akses Cepat Layanan</span>
                    <h2 class="text-2xl font-bold text-[#0B2A59] mt-1 leading-8">Layanan Utama P3M PKTJ</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">Pintasan langsung ke portal pengajuan, dokumen regulasi, data capaian, dan jurnal ilmiah.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <!-- Kartu 1: SIM P3M -->
                    <a href="/login" class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-6 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors duration-200 flex items-center justify-center text-[#0B2A59] font-bold text-sm leading-5">
                                SIM
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] leading-5 transition-colors">SIM P3M</h3>
                            <p class="text-xs text-slate-500 leading-5">Pengajuan usulan riset & PkM, form RAB dinamis, dan monev.</p>
                        </div>
                        <span class="inline-flex items-center text-xs font-semibold text-[#0B2A59] pt-4 leading-4 group-hover:underline">
                            Buka Portal
                        </span>
                    </a>

                    <!-- Kartu 2: Pedoman & SOP -->
                    <a href="#layanan-dokumen" class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-6 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 group-hover:bg-yellow-200 transition-colors duration-200 flex items-center justify-center text-yellow-800 font-bold text-sm leading-5">
                                SOP
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] leading-5 transition-colors">Panduan & SOP</h3>
                            <p class="text-xs text-slate-500 leading-5">Pusat unduhan Renstra, Roadmap, SOP Riset, dan SOP PkM.</p>
                        </div>
                        <span class="inline-flex items-center text-xs font-semibold text-[#0B2A59] pt-4 leading-4 group-hover:underline">
                            Unduh Dokumen
                        </span>
                    </a>

                    <!-- Kartu 3: Data Riset per Prodi -->
                    <a href="#kegiatan-riset" class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-6 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-200 group-hover:bg-slate-300 transition-colors duration-200 flex items-center justify-center text-slate-800 font-bold text-sm leading-5">
                                DATA
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] leading-5 transition-colors">Data Riset & PkM</h3>
                            <p class="text-xs text-slate-500 leading-5">Rekapitulasi kegiatan dan filter capaian per prodi serta tahun.</p>
                        </div>
                        <span class="inline-flex items-center text-xs font-semibold text-[#0B2A59] pt-4 leading-4 group-hover:underline">
                            Eksplorasi Data
                        </span>
                    </a>

                    <!-- Kartu 4: Direktori Peneliti -->
                    <a href="#quick-access" class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-6 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 group-hover:bg-emerald-200 transition-colors duration-200 flex items-center justify-center text-emerald-800 font-bold text-sm leading-5">
                                SDM
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] leading-5 transition-colors">Direktori Dosen</h3>
                            <p class="text-xs text-slate-500 leading-5">Profil kepakaran peneliti, data publikasi SINTA dan Scopus.</p>
                        </div>
                        <span class="inline-flex items-center text-xs font-semibold text-[#0B2A59] pt-4 leading-4 group-hover:underline">
                            Lihat Dosen
                        </span>
                    </a>

                    <!-- Kartu 5: Rumah Jurnal OJS -->
                    <a href="https://ktj.pktj.ac.id/" target="_blank" rel="noopener noreferrer" class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-xl p-6 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 group-hover:bg-purple-200 transition-colors duration-200 flex items-center justify-center text-purple-800 font-bold text-sm leading-5">
                                OJS
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] leading-5 transition-colors">Portal Jurnal</h3>
                            <p class="text-xs text-slate-500 leading-5">Publikasi berkala ilmiah terindeks SINTA di PKTJ Tegal.</p>
                        </div>
                        <span class="inline-flex items-center text-xs font-semibold text-[#0B2A59] pt-4 leading-4 group-hover:underline">
                            Kunjungi OJS
                        </span>
                    </a>

                </div>
            </div>
        </section>

        <!-- 3. Quick Stats Counter (Capaian Kinerja P3M PKTJ dengan Hover Elevation) -->
        <section class="bg-slate-50 border-b border-slate-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 text-center space-y-2 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0B2A59] leading-10">{{ $stats['total_riset'] }}+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 leading-4">Kegiatan Penelitian</div>
                        <p class="text-xs text-slate-400 leading-4">Skema Internal, DIPA & Kerjasama</p>
                    </div>

                    <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 text-center space-y-2 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0B2A59] leading-10">{{ $stats['total_pkm'] }}+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 leading-4">Kegiatan Pengabdian</div>
                        <p class="text-xs text-slate-400 leading-4">Pemberdayaan Masyarakat & Binaan</p>
                    </div>

                    <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 text-center space-y-2 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0B2A59] leading-10">45+</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 leading-4">HKI & Paten Terdaftar</div>
                        <p class="text-xs text-slate-400 leading-4">Hak Cipta, Desain Industri & Paten</p>
                    </div>

                    <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 text-center space-y-2 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0B2A59] leading-10">3 Prodi</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 leading-4">Program Studi</div>
                        <p class="text-xs text-slate-400 leading-4">D4 RSTJ, D4 TRO, D3 TO</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- 5. Berita Terkini & Agenda Riset (Homepage Requirement Nomor 1: Berita Terkini) -->
        <section id="berita-terkini" class="py-16 sm:py-20 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Informasi & Diseminasi Riset</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">
                            Berita Terkini dan Agenda P3M PKTJ
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md leading-5">
                        Pemberitahuan jadwal seleksi proposal, diseminasi hasil riset terapan, dan agenda kegiatan sivitas akademika PKTJ.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Kolom Kiri (7 Kolom): Berita & Diseminasi Riset -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <h3 class="text-base font-bold text-[#0B2A59] leading-6">
                                Publikasi Berita Terkini
                            </h3>
                            <span class="text-xs font-semibold text-slate-500 leading-4">Kanal Informasi</span>
                        </div>

                        @if($beritaList->isNotEmpty())
                            @php $featuredBerita = $beritaList->first(); @endphp
                            <!-- Berita Utama (Featured Article) -->
                            <article class="bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-2xl p-6 sm:p-8 space-y-4 hover:shadow-md transition-all duration-200 group">
                                @if($featuredBerita->gambar_sampul)
                                    <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-200">
                                        <img src="{{ asset('storage/' . $featuredBerita->gambar_sampul) }}" alt="{{ $featuredBerita->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif
                                <div class="flex items-center gap-3 text-xs text-slate-500 leading-4">
                                    <span class="px-2.5 py-1 rounded bg-blue-100 text-[#0B2A59] font-bold uppercase text-[10px] tracking-wider">
                                        {{ $featuredBerita->kategori }}
                                    </span>
                                    <span>{{ $featuredBerita->tanggal_publikasi ? $featuredBerita->tanggal_publikasi->translatedFormat('d F Y') : '-' }}</span>
                                </div>
                                <h4 class="text-lg sm:text-xl font-bold text-slate-900 leading-7 group-hover:text-[#0B2A59] transition-colors">
                                    {{ $featuredBerita->judul }}
                                </h4>
                                <p class="text-xs sm:text-sm text-slate-600 leading-6">
                                    {{ $featuredBerita->ringkasan ?? Str::limit(strip_tags($featuredBerita->konten), 160) }}
                                </p>
                                <div class="pt-2">
                                    <button type="button" 
                                            @click="openReaderById({{ $featuredBerita->id }})"
                                            class="inline-flex items-center gap-2 text-xs font-bold text-[#0B2A59] hover:text-blue-900 hover:underline leading-4 group-hover:translate-x-1 transition-all duration-200">
                                        <span>Baca Selengkapnya</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </div>
                            </article>

                            @if($beritaList->count() > 1)
                                <!-- Berita Pendukung Lainnya -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($beritaList->slice(1) as $itemBerita)
                                        <article class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 space-y-3 hover:shadow-sm transition-all duration-200 flex flex-col justify-between">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold uppercase text-[10px] tracking-wider">
                                                        {{ $itemBerita->kategori }}
                                                    </span>
                                                    <span>{{ $itemBerita->tanggal_publikasi ? $itemBerita->tanggal_publikasi->translatedFormat('d M Y') : '-' }}</span>
                                                </div>
                                                <h4 class="text-sm font-bold text-slate-900 leading-5">
                                                    <span class="hover:text-[#0B2A59] transition-colors">{{ $itemBerita->judul }}</span>
                                                </h4>
                                                <p class="text-xs text-slate-500 leading-5 line-clamp-2">
                                                    {{ $itemBerita->ringkasan ?? Str::limit(strip_tags($itemBerita->konten), 100) }}
                                                </p>
                                            </div>
                                            <div class="pt-3 border-t border-slate-100">
                                                <button type="button" 
                                                        @click="openReaderById({{ $itemBerita->id }})"
                                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0B2A59] hover:underline leading-4">
                                                    <span>Baca Selengkapnya</span>
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="p-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl">
                                Belum ada berita kegiatan yang dipublikasikan.
                            </div>
                        @endif
                    </div>

                    <!-- Kolom Kanan (5 Kolom): Pengumuman & Call for Proposals -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <h3 class="text-base font-bold text-[#0B2A59] leading-6">
                                Pengumuman & Call for Proposals
                            </h3>
                            <span class="text-xs text-slate-400 font-medium leading-4">Agenda P3M</span>
                        </div>

                        @forelse($pengumumanList as $pengumuman)
                            <div class="bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl p-5 space-y-3 hover:shadow-sm transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded leading-4 uppercase text-[10px] tracking-wider">
                                        {{ $pengumuman->kategori }}
                                    </span>
                                    <span class="text-xs text-slate-500 leading-4">
                                        {{ $pengumuman->tanggal_publikasi ? $pengumuman->tanggal_publikasi->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 leading-5">
                                    {{ $pengumuman->judul }}
                                </h4>
                                <p class="text-xs text-slate-600 leading-5 line-clamp-3">
                                    {{ $pengumuman->ringkasan ?? Str::limit(strip_tags($pengumuman->konten), 120) }}
                                </p>
                                <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-xs leading-4">
                                    <button type="button" 
                                            @click="openReaderById({{ $pengumuman->id }})"
                                            class="font-semibold text-slate-600 hover:text-[#0B2A59] hover:underline transition-colors">
                                        Baca Rincian
                                    </button>
                                    <div class="flex items-center gap-3">
                                        <a href="#layanan-dokumen" class="text-slate-500 hover:text-slate-800 transition-colors">Unduh Panduan</a>
                                        <a href="/login" class="font-bold text-[#0B2A59] hover:underline transition-colors">Ajukan Usulan &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl">
                                Belum ada pengumuman aktif saat ini.
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>
        </section>

        <!-- 5. Eksplorasi Data Riset & PkM Interaktif (Filter Prodi, Tahun, & Transisi Halus) -->
        <section id="kegiatan-riset" class="py-16 bg-slate-50 border-b border-slate-200" 
                 x-data="{
                     kategori: 'semua',
                     prodi: 'semua',
                     tahun: 'semua',
                     search: '',
                     risetList: {{ Js::from($kegiatanList) }},
                     get filteredItems() {
                         return this.risetList.filter(item => {
                             const matchKategori = (this.kategori === 'semua') || (item.jenis === this.kategori);
                             const matchProdi = (this.prodi === 'semua') || (item.prodi === this.prodi);
                             const matchTahun = (this.tahun === 'semua') || (item.tahun === this.tahun);
                             const matchSearch = (this.search === '') || (item.judul.toLowerCase().includes(this.search.toLowerCase()) || item.ketua.toLowerCase().includes(this.search.toLowerCase()));
                             return matchKategori && matchProdi && matchTahun && matchSearch;
                         });
                     }
                 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Repositori Riset & Pengabdian</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] mt-1 leading-8">Data Capaian per Program Studi & Tahun</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md leading-5">
                        Gunakan filter interaktif di bawah untuk melihat rekapitulasi usulan riset dan pengabdian masyarakat dosen PKTJ.
                    </p>
                </div>

                <!-- Baris Filter Interaktif (Tinggi Standar Desktop h-10 = 40px) -->
                <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-6 shadow-sm space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        <!-- Filter Kategori -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kategori Kegiatan</label>
                            <select x-model="kategori" class="w-full h-10 border-slate-300 rounded-lg text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                                <option value="semua">Semua Kategori (Riset & PkM)</option>
                                <option value="penelitian">Penelitian (Riset)</option>
                                <option value="pengabdian">Pengabdian kepada Masyarakat</option>
                            </select>
                        </div>

                        <!-- Filter Program Studi -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Program Studi (Prodi)</label>
                            <select x-model="prodi" class="w-full h-10 border-slate-300 rounded-lg text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                                <option value="semua">Semua Program Studi (3 Program Studi)</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->kode_prodi }}">{{ $p->jenjang }} {{ $p->nama_prodi }} ({{ $p->kode_prodi }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun Anggaran -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tahun Anggaran</label>
                            <select x-model="tahun" class="w-full h-10 border-slate-300 rounded-lg text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                                <option value="semua">Semua Tahun</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}">Tahun {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pencarian Kata Kunci -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Cari Judul atau Ketua</label>
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Ketik kata kunci..." class="w-full h-10 pl-10 pr-4 border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                    </div>

                    <!-- Rekap Indikator Singkat Visual -->
                    <div class="pt-2 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2 leading-4">
                        <div>
                            Menampilkan <span class="font-bold text-[#0B2A59]" x-text="filteredItems.length"></span> kegiatan dari total <span class="font-bold text-slate-700" x-text="risetList.length"></span> arsip riset & PkM terdata.
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-medium text-slate-700">D4 TRO</span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="font-medium text-slate-700">D4 RSTJ</span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="font-medium text-slate-700">D3 TO</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data Interaktif (Zero Horizontal Overflow, Scroll Container Bersih) -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-700 text-xs uppercase tracking-wider font-semibold border-b border-slate-200 leading-4">
                                    <th class="py-4 px-4 sm:px-6">Judul Riset / Pengabdian</th>
                                    <th class="py-4 px-4">Prodi</th>
                                    <th class="py-4 px-4">Ketua Peneliti</th>
                                    <th class="py-4 px-4">Sumber Dana</th>
                                    <th class="py-4 px-4">Tahun</th>
                                    <th class="py-4 px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs text-slate-700 leading-5">
                                <template x-for="item in filteredItems" :key="item.id">
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                        <td class="py-4 px-4 sm:px-6 font-medium text-slate-900 max-w-sm sm:max-w-md">
                                            <div class="space-y-1">
                                                <span class="inline-block px-2 py-1 rounded text-xs font-bold uppercase tracking-wider leading-4"
                                                      :class="item.jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59]' : 'bg-yellow-50 text-yellow-800'"
                                                      x-text="item.jenis"></span>
                                                <div class="leading-5" x-text="item.judul"></div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap font-semibold text-[#0B2A59]" x-text="item.prodi"></td>
                                        <td class="py-4 px-4 whitespace-nowrap text-slate-600" x-text="item.ketua"></td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="inline-block px-2 py-1 rounded bg-slate-100 text-slate-700 font-medium text-xs leading-4" x-text="item.dana"></span>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap font-medium" x-text="item.tahun"></td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold leading-4"
                                                  :class="item.status === 'Selesai' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-blue-50 text-blue-800 border border-blue-200'"
                                                  x-text="item.status"></span>
                                        </td>
                                    </tr>
                                </template>
                                
                                <!-- Empty State (R-27 Antislop Standard) -->
                                <tr x-show="filteredItems.length === 0" x-cloak>
                                    <td colspan="6" class="py-12 text-center text-slate-500">
                                        <div class="space-y-2">
                                            <div class="text-sm font-semibold text-slate-700 leading-5">Tidak ada data kegiatan yang cocok</div>
                                            <p class="text-xs text-slate-400 leading-4">Silakan sesuaikan filter Program Studi, Tahun, atau kata kunci pencarian Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        <!-- 6. Pusat Layanan Dokumen & Regulasi (Renstra, Roadmap, SOP Riset, SOP PkM) -->
        <section id="layanan-dokumen" class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pusat Unduhan Dokumen</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] mt-1 leading-8">Panduan, Pedoman & SOP Kelembagaan</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md leading-5">
                        Akses berkas dokumen Standar Operasional Prosedur (SOP Penelitian & Pengabdian) serta panduan sistem informasi kelembagaan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($documents as $doc)
                        <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-6 flex flex-col justify-between space-y-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1 group">
                            <div class="space-y-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-blue-50 text-[#0B2A59] leading-4 uppercase tracking-wider text-[10px]">
                                    {{ str_replace('_', ' ', $doc->kategori) }}
                                </span>
                                <h3 class="text-sm font-bold text-slate-900 leading-5 group-hover:text-[#0B2A59] transition-colors">
                                    {{ $doc->judul }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-5 line-clamp-2">
                                    {{ $doc->deskripsi ?? 'Dokumen pedoman dan standar operasional P3M PKTJ.' }}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs leading-4">
                                <span class="text-slate-400">PDF &bull; {{ $doc->file_size ?? 'Dokumen' }}</span>
                                @if($doc->file_path)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 font-semibold text-[#0B2A59] hover:underline">
                                        <svg class="w-4 h-4 text-slate-600 group-hover:translate-y-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span>Unduh</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 font-medium">Tersedia di P3M</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl">
                            Belum ada dokumen yang dipublikasikan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- 7. Showcase Rumah Jurnal Ilmiah (OJS Showcase Widget) -->
        <section id="jurnal" class="py-16 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-2xl p-8 sm:p-10 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <div class="lg:col-span-8 space-y-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4">
                                <span>Open Journal Systems (OJS)</span>
                                <span>&bull;</span>
                                <span>PKTJ Tegal</span>
                            </div>

                            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8">
                                Jurnal Keselamatan Transportasi Jalan (Indonesian Road Safety Journal)
                            </h2>

                            <p class="text-xs sm:text-sm text-slate-600 leading-6">
                                Media publikasi ilmiah peer-reviewed berkala yang memuat artikel hasil penelitian orisinal dan kajian terapan di bidang keselamatan jalan, rekayasa lalu lintas, otomasi armada, dan logistik transportasi.
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 leading-4 pt-1">
                                <span class="inline-flex items-center gap-1">
                                    <strong class="text-slate-800">E-ISSN:</strong> 2722-1234
                                </span>
                                <span>&bull;</span>
                                <span class="inline-flex items-center gap-1">
                                    <strong class="text-slate-800">Frekuensi:</strong> 2 Kali Setahun (Juni & Desember)
                                </span>
                                <span>&bull;</span>
                                <span class="inline-flex items-center gap-1">
                                    <strong class="text-slate-800">Indeks:</strong> SINTA & Google Scholar
                                </span>
                            </div>
                        </div>

                        <div class="lg:col-span-4 flex flex-col gap-4 justify-center items-stretch sm:items-start lg:items-end">
                            <a href="https://ktj.pktj.ac.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full sm:w-auto h-12 px-6 rounded-lg text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] leading-5 whitespace-nowrap">
                                <span>Kunjungi Portal OJS</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="https://ktj.pktj.ac.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full sm:w-auto h-12 px-6 rounded-lg text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all duration-200 active:scale-[0.98] leading-5 whitespace-nowrap">
                                <span>Petunjuk Submisi Naskah</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Callout Banner SIM P3M (Alur Pengajuan Usulan Hibah Riset) -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-[#0B2A59] rounded-2xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-md">
                    <div class="space-y-3 max-w-2xl">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-400 leading-4">Sistem Informasi Manajemen</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-8 sm:leading-10">Siap Mengajukan Proposal Penelitian atau PkM?</h2>
                        <p class="text-xs sm:text-sm text-slate-300 leading-6">
                            Kirimkan usulan proposal riset dan pengabdian Anda, ajukan rincian anggaran biaya (RAB), dan pantau tahapan proses review secara transparan hingga penetapan keputusan pendanaan.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="/login" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-bold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 leading-5 whitespace-nowrap">
                            Masuk ke Portal Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

<!-- Modal Interaktif Pembaca Berita & Pengumuman P3M (Alpine.js Responsive Modal Reader) -->
    <div x-show="isReaderOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" 
         aria-modal="true"
         aria-labelledby="modal-post-title">
        
        <!-- Backdrop Blur -->
        <div x-show="isReaderOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm"
             @click="closeReader()">
        </div>

        <!-- Modal Dialog Window -->
        <div class="min-h-full flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div x-show="isReaderOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 sm:p-8 text-left overflow-hidden border border-slate-200 space-y-6 max-h-[90vh] flex flex-col"
                 @click.stop>
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-xs leading-4">
                            <span class="px-2.5 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-bold uppercase text-[10px] tracking-wider" 
                                  x-text="currentPost?.kategori || 'Berita'">
                            </span>
                            <span class="text-slate-400">&bull;</span>
                            <span class="text-slate-500 font-medium" x-text="currentPost?.tanggal || '-'"></span>
                        </div>
                        <h3 id="modal-post-title" 
                            class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-7 sm:leading-8" 
                            x-text="currentPost?.judul">
                        </h3>
                    </div>

                    <!-- Tombol Tutup (Touch Target 44x44px, Zero Emoji) -->
                    <button type="button" 
                            @click="closeReader()" 
                            class="inline-flex items-center justify-center w-11 h-11 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] transition-colors flex-shrink-0"
                            aria-label="Tutup jendela baca">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Scrollable Body -->
                <div class="overflow-y-auto space-y-6 flex-1 pr-1">
                    <!-- Gambar Sampul jika ada -->
                    <template x-if="currentPost?.gambar_sampul">
                        <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img :src="currentPost.gambar_sampul" :alt="currentPost.judul" class="w-full h-full object-cover">
                        </div>
                    </template>

                    <!-- Ringkasan jika ada -->
                    <template x-if="currentPost?.ringkasan">
                        <div class="p-4 rounded-xl bg-slate-50 border-l-4 border-yellow-500 text-xs sm:text-sm text-slate-700 font-medium leading-6"
                             x-text="currentPost.ringkasan">
                        </div>
                    </template>

                    <!-- Isi Lengkap Artikel -->
                    <div class="text-slate-700 text-sm sm:text-base leading-7 space-y-4" 
                         x-html="currentPost?.konten">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs text-slate-400 leading-4">Portal Informasi P3M PKTJ Tegal</span>
                    <button type="button" 
                            @click="closeReader()" 
                            class="w-full sm:w-auto h-10 px-5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                        Tutup Bacaan
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
