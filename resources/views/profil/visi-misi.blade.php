@extends('layouts.public')

@section('title', 'Visi, Misi & Tujuan - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Visi, Misi, dan Tujuan Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan Tegal.')

@section('content')

<main class="flex-1">

        <!-- Breadcrumb Bar -->
        <nav aria-label="Breadcrumb" class="bg-slate-50 border-b border-slate-200 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <ol class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                    <li>
                        <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                    </li>
                    <li class="text-slate-400">/</li>
                    <li>
                        <span class="text-slate-600">Profil</span>
                    </li>
                    <li class="text-slate-400">/</li>
                    <li class="font-bold text-[#0B2A59]" aria-current="page">Visi, Misi & Tujuan</li>
                </ol>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="py-12 sm:py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                        <span>Landasan Filosofis & Haluan Kelembagaan</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-9 sm:leading-10">
                        Visi, Misi & Tujuan Strategis <span class="text-[#0B2A59]">P3M PKTJ</span>
                    </h1>
                    <div class="w-20 h-1 bg-yellow-500 rounded"></div>
                    <p class="text-sm sm:text-base text-slate-600 leading-6 sm:leading-7">
                        Arah haluan kelembagaan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal dalam memandu riset terapan keselamatan perhubungan darat, pengabdian aksi nyata, dan tata kelola akademik bereputasi di bawah Badan Pengembangan Sumber Daya Manusia Perhubungan.
                    </p>
                </div>

                <!-- Highlight Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 mt-8 border-t border-slate-100">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Periode Sasaran</span>
                        <div class="text-xl font-bold text-[#0B2A59] leading-7">Hingga Tahun 2031</div>
                        <p class="text-xs text-slate-500 leading-4">Rencana strategis jangka menengah terpadu.</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Sinergi Akademik</span>
                        <div class="text-xl font-bold text-[#0B2A59] leading-7">3 Program Studi PKTJ</div>
                        <p class="text-xs text-slate-500 leading-4">D4 RSTJ, D4 TRO, dan D3 TO bersinergi penuh.</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Nilai Budaya Kerja</span>
                        <div class="text-xl font-bold text-emerald-700 leading-7">PRESTASI Kemenhub</div>
                        <p class="text-xs text-slate-500 leading-4">Profesional, Etika, Standar, Tangguh, Akuntabel, Sinergi, Inovatif.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 1. Section Visi Kelembagaan P3M PKTJ -->
        <section class="py-16 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-4xl mx-auto">
                    <!-- Kartu Visi Kelembagaan (Bingkai Navy Kokoh & Elegan) -->
                    <div class="bg-gradient-to-br from-[#0B2A59] to-blue-900 rounded-2xl p-8 sm:p-12 text-white shadow-xl border-4 border-white space-y-6 relative overflow-hidden">
                        
                        <!-- Aksen Ornamen Elegan -->
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
                        
                        <div class="space-y-3 relative z-10">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-yellow-400 text-[#0B2A59] text-xs font-bold leading-4">
                                <span>Pernyataan Visi Kelembagaan</span>
                            </div>
                            <h2 class="text-sm sm:text-base font-semibold text-blue-200 uppercase tracking-wider leading-5">
                                {{ $settings['visi_title'] ?? 'Visi P3M Politeknik Keselamatan Transportasi Jalan' }}
                            </h2>
                        </div>

                        <!-- Teks Visi Utama -->
                        <blockquote class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-8 sm:leading-10 tracking-tight relative z-10">
                            &ldquo;{{ $settings['visi_statement'] ?? 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.' }}&rdquo;
                        </blockquote>

                        <div class="w-24 h-1 bg-yellow-400 rounded relative z-10"></div>

                        <!-- Narasi Penjelas Visi -->
                        <p class="text-xs sm:text-sm text-blue-100 leading-6 max-w-3xl relative z-10">
                            {{ $settings['visi_subtext'] ?? 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah naungan Badan Pengembangan SDM Perhubungan, Kementerian Perhubungan Republik Indonesia.' }}
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 2. Section 5 Butir Misi Kelembagaan -->
        <section class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center max-w-3xl mx-auto space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pilar Aksi Kelembagaan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-9">
                        5 Butir Misi Utama P3M PKTJ
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-5">
                        Langkah operasional yang dilaksanakan secara konsisten dalam mentransformasikan visi menjadi capaian nyata akademik dan pengabdian masyarakat.
                    </p>
                </div>

                <!-- 5 Kartu Misi Berderet Rapi -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                    
                    <!-- Misi 1 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A59] font-extrabold text-sm flex items-center justify-center leading-4">01</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Riset Terapan</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-6">Penelitian Keselamatan Jalan</h3>
                            <p class="text-xs text-slate-600 leading-5">
                                {{ $settings['misi_1'] ?? 'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.' }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-[11px] text-[#0B2A59] font-semibold">
                            Fokus: Audit Geometri & Kelaikan Jalan
                        </div>
                    </div>

                    <!-- Misi 2 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-800 font-extrabold text-sm flex items-center justify-center leading-4">02</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pengabdian Nyata</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-6">Pengabdian & Desa Binaan</h3>
                            <p class="text-xs text-slate-600 leading-5">
                                {{ $settings['misi_2'] ?? 'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.' }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-[11px] text-yellow-700 font-semibold">
                            Fokus: Edukasi & Transfer Teknologi UMKM
                        </div>
                    </div>

                    <!-- Misi 3 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A59] font-extrabold text-sm flex items-center justify-center leading-4">03</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sinergi Kemitraan</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-6">Kemitraan Multisektor</h3>
                            <p class="text-xs text-slate-600 leading-5">
                                {{ $settings['misi_3'] ?? 'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.' }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-[11px] text-[#0B2A59] font-semibold">
                            Fokus: Kolaborasi Regulator & Industri
                        </div>
                    </div>

                    <!-- Misi 4 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-sm flex items-center justify-center leading-4">04</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Invensi & Luaran</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-6">Hilirisasi HKI & Jurnal Ilmiah</h3>
                            <p class="text-xs text-slate-600 leading-5">
                                {{ $settings['misi_4'] ?? 'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.' }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-[11px] text-emerald-700 font-semibold">
                            Fokus: Paten, Hak Cipta & Jurnal OJS
                        </div>
                    </div>

                    <!-- Misi 5 (Mengisi 2 Kolom di Desktop) -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200 md:col-span-2 lg:col-span-2">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A59] font-extrabold text-sm flex items-center justify-center leading-4">05</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tata Kelola Modern</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-6">Tata Kelola Kelembagaan & SIM P3M</h3>
                            <p class="text-xs text-slate-600 leading-5">
                                {{ $settings['misi_5'] ?? 'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.' }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-[11px] text-[#0B2A59] font-semibold">
                            Fokus: Akuntabilitas Anggaran & Layanan Usulan Daring
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 3. Section Tujuan Strategis & Sasaran Mutu -->
        <section class="py-16 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="max-w-3xl space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Indikator Capaian Kinerja</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-9">
                        Tujuan Strategis & Sasaran Mutu P3M
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-6">
                        {{ $settings['tujuan_lead'] ?? 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.' }}
                    </p>
                </div>

                <!-- 4 Kartu Tujuan Strategis -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Tujuan 1 -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                01
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-6">
                                {{ $settings['tujuan_1_title'] ?? 'Reduksi Fatalitas Kecelakaan' }}
                            </h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-6">
                            {{ $settings['tujuan_1_desc'] ?? 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.' }}
                        </p>
                    </div>

                    <!-- Tujuan 2 -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0B2A59] flex items-center justify-center font-bold text-xs flex-shrink-0">
                                02
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-6">
                                {{ $settings['tujuan_2_title'] ?? 'Kemandirian Riset Vokasi' }}
                            </h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-6">
                            {{ $settings['tujuan_2_desc'] ?? 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.' }}
                        </p>
                    </div>

                    <!-- Tujuan 3 -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                03
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-6">
                                {{ $settings['tujuan_3_title'] ?? 'Penguatan HKI & Jurnal Ilmiah' }}
                            </h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-6">
                            {{ $settings['tujuan_3_desc'] ?? 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.' }}
                        </p>
                    </div>

                    <!-- Tujuan 4 -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                04
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-6">
                                {{ $settings['tujuan_4_title'] ?? 'Pemberdayaan Masyarakat Pantura' }}
                            </h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-6">
                            {{ $settings['tujuan_4_desc'] ?? 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.' }}
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. Section Sinergi 3 Program Studi PKTJ -->
        <section class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                
                <div class="max-w-3xl space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pengampu Tri Dharma Perguruan Tinggi</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8">
                        Sinergi 3 Program Studi PKTJ Tegal
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-5">
                        Pencapaian visi, misi, dan tujuan kelembagaan ditopang oleh kepakaran dosen dan taruna dari tiga program studi di lingkungan PKTJ:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- D4 RSTJ -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-7 space-y-3 shadow-sm hover:border-[#0B2A59] transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D4 RSTJ</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 leading-5">Rekayasa Sistem Transportasi Jalan</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Mengemban misi riset rekayasa geometri jalan, audit black spot Pantura, keselamatan persimpangan jalan, dan manajemen lalu lintas cerdas perkotaan.
                        </p>
                    </div>

                    <!-- D4 TRO -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-7 space-y-3 shadow-sm hover:border-[#0B2A59] transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D4 TRO</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 leading-5">Teknologi Rekayasa Otomotif</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Mengemban misi riset kelaikan armada angkutan, dinamika sistem rem kendaraan, konversi kendaraan listrik (EV), dan simulasi uji tabrak vokasi.
                        </p>
                    </div>

                    <!-- D3 TO -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-7 space-y-3 shadow-sm hover:border-[#0B2A59] transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D3 TO</span>
                            <span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 font-semibold text-[10px] leading-4">Diploma Tiga</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 leading-5">Teknologi Otomotif</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Mengemban misi standardisasi perawatan berkala kendaraan bermotor, uji emisi gas buang, transfer teknologi bengkel rakyat, dan edukasi keselamatan mekanikal.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. Tautan Dokumen Haluan Terkait (Renstra & Roadmap) -->
        <section class="py-12 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Dokumen Haluan Kelembagaan</h3>
                        <p class="text-xs text-slate-500 leading-4 mt-0.5">Akses rencana strategis dan peta jalan riset operasional pendamping visi-misi.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Renstra Card Link -->
                    <a href="{{ route('profil.rencana-strategis') }}" 
                       class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 flex items-center justify-between gap-4 shadow-sm hover:shadow transition-all group">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Pedoman Jangka Menengah</span>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-5">
                                Rencana Strategis (Renstra) 2026 - 2031
                            </div>
                            <p class="text-xs text-slate-500 leading-4">Memuat Dokumen Renstra Penelitian & Pengabdian Masyarakat.</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0B2A59] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0B2A59] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </a>

                    <!-- Roadmap Card Link -->
                    <a href="{{ route('profil.roadmap-penelitian') }}" 
                       class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 flex items-center justify-between gap-4 shadow-sm hover:shadow transition-all group">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Peta Jalan 3 Fase</span>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-5">
                                Roadmap Penelitian Keselamatan Terpadu
                            </div>
                            <p class="text-xs text-slate-500 leading-4">Memuat tahapan riset terpadu, target paten, dan klaster prodi.</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0B2A59] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0B2A59] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Call to Action ke SIM P3M -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-[#0B2A59] to-blue-900 rounded-2xl p-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-md">
                    <div class="space-y-2 text-center md:text-left">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-400 leading-4">Sinergi Sivitas Akademika</span>
                        <h3 class="text-xl sm:text-2xl font-bold leading-7">Wujudkan Visi Bersama Melalui Usulan Riset Berkualitas</h3>
                        <p class="text-xs sm:text-sm text-blue-100 max-w-xl leading-5">
                            Pengajuan proposal penelitian dan pengabdian masyarakat dosen dibuka secara terstruktur melalui Sistem Informasi Manajemen (SIM P3M PKTJ).
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center h-12 px-6 text-sm font-semibold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 rounded-xl transition-all shadow active:scale-[0.98] leading-5 whitespace-nowrap">
                            Masuk ke SIM P3M
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer Institusi (Kemenhub) -->

@endsection
