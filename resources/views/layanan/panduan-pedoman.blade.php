@extends('layouts.public')

@section('title', 'Panduan dan Pedoman Layanan - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Pusat unduhan Pedoman Penelitian dan Pengembangan SDM, Pedoman Pengabdian kepada Masyarakat dan Pengembangan Kualitas Kepakaran, Proses PkM, dan Panduan Penggunaan Sistem Informasi SIM P3M PKTJ.')

@section('content')
<div x-data="{ 
    previewModalOpen: false, 
    activeDoc: null,
    openPreview(item) {
        this.activeDoc = item;
        this.previewModalOpen = true;
    }
}">
<main class="flex-1">

    <!-- Hero Section Header (Skema Navy Kemenhub & Strict 4px Grid) -->
    <section class="bg-gradient-to-b from-blue-50/70 via-slate-50/40 to-white py-12 sm:py-16 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Breadcrumbs -->
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                    <li>
                        <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li>
                        <span class="text-slate-400">Layanan</span>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="font-semibold text-[#0B2A59]">Panduan dan Pedoman</li>
                </ol>
            </nav>

            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                    <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Layanan Penjaminan Mutu & Repositori Pedoman</span>
                </div>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">
                    Panduan & Pedoman Mutu Tridharma
                </h1>
                
                <p class="text-sm sm:text-base text-slate-600 leading-6 max-w-2xl">
                    Pusat repositori dokumen rujukan civitas akademika Politeknik Keselamatan Transportasi Jalan dalam pelaksanaan riset vokasi terapan, hilirisasi pengabdian masyarakat, peningkatan kepakaran SDM, dan petunjuk teknis sistem digital SIM P3M.
                </p>
            </div>

            <!-- Ringkasan Statistik Metrik Spasial Kelipatan 4px -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-200">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0B2A59] flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-[#0B2A59] leading-7">{{ $stats['total_dokumen'] }}</div>
                        <div class="text-xs text-slate-500 font-medium leading-4">Dokumen Panduan Berlaku</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-[#0B2A59] leading-7">{{ number_format($stats['total_unduhan'], 0, ',', '.') }}</div>
                        <div class="text-xs text-slate-500 font-medium leading-4">Akumulasi Akses Unduh</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-700 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-[#0B2A59] leading-7">{{ $stats['tahun_terkini'] }}</div>
                        <div class="text-xs text-slate-500 font-medium leading-4">Edisi Standar Mutu Mutakhir</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4 Dokumen Mandat Unggulan (Featured Guidelines Section) -->
    <section class="py-12 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 leading-4">Mandat Standar Mutu</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#0B2A59] mt-1 leading-7 sm:leading-8">
                        Empat Pedoman Utama Pelaksanaan Tridharma
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                        Dokumen acuan pokok yang wajib dipedomani dalam penyusunan proposal, pelaksanaan kegiatan, hingga pertanggungjawaban luaran.
                    </p>
                </div>
                <div class="text-xs text-slate-500 font-medium flex items-center gap-1.5 leading-4">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <span>Tersedia untuk Diunduh Langsung</span>
                </div>
            </div>

            <!-- Grid 4 Kartu Interaktif -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @foreach($featuredDocs as $item)
                    @php
                        $doc = $item['doc'];
                        $title = $doc ? $doc->judul : $item['title'];
                        $desc = $doc && $doc->deskripsi ? $doc->deskripsi : $item['default_desc'];
                        $fileSize = $doc ? $doc->file_size : '2.0 MB';
                        $year = $doc ? ($doc->tahun ?? '2026') : '2026';
                        $downloads = $doc ? $doc->download_count : 0;
                        $downloadRoute = $doc ? route('layanan.panduan-pedoman.unduh', $doc) : '#';
                        $badgeBg = match($item['icon_color']) {
                            'indigo' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                            'emerald' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'teal' => 'bg-teal-50 text-teal-800 border-teal-200',
                            default => 'bg-blue-50 text-blue-800 border-blue-200',
                        };
                        $accentColor = match($item['icon_color']) {
                            'indigo' => 'text-indigo-700 bg-indigo-50 border-indigo-100',
                            'emerald' => 'text-emerald-700 bg-emerald-50 border-emerald-100',
                            'teal' => 'text-teal-700 bg-teal-50 border-teal-100',
                            default => 'text-blue-700 bg-blue-50 border-blue-100',
                        };
                    @endphp

                    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                        <div class="space-y-4">
                            
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-12 h-12 rounded-xl {{ $accentColor }} border flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeBg }} leading-4">
                                    {{ $item['badge'] }}
                                </span>
                            </div>

                            <div>
                                <div class="text-xs font-semibold text-slate-400 tracking-wide uppercase leading-4">{{ $item['subtitle'] }}</div>
                                <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] mt-1 leading-6 group-hover:text-blue-900 transition-colors">
                                    {{ $title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-5 line-clamp-3">
                                    {{ $desc }}
                                </p>
                            </div>

                            <!-- Metadata Info Kelipatan 4px -->
                            <div class="pt-4 border-t border-slate-100 grid grid-cols-3 gap-2 text-xs text-slate-500 leading-4">
                                <div>
                                    <span class="block text-slate-400 text-[11px]">Tahun Berlaku</span>
                                    <strong class="text-slate-800 font-semibold">{{ $year }}</strong>
                                </div>
                                <div>
                                    <span class="block text-slate-400 text-[11px]">Ukuran Berkas</span>
                                    <strong class="text-slate-800 font-semibold">{{ $fileSize }}</strong>
                                </div>
                                <div>
                                    <span class="block text-slate-400 text-[11px]">Total Diunduh</span>
                                    <strong class="text-slate-800 font-semibold">{{ $downloads }}x</strong>
                                </div>
                            </div>

                        </div>

                        <!-- Tombol Aksi Langsung (Preview & Unduh) -->
                        <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between gap-3">
                            <button type="button"
                                    @click="openPreview({
                                        judul: '{{ addslashes($title) }}',
                                        kategori: '{{ $item['badge'] }}',
                                        deskripsi: '{{ addslashes($desc) }}',
                                        tahun: '{{ $year }}',
                                        file_size: '{{ $fileSize }}',
                                        download_count: '{{ $downloads }}',
                                        download_url: '{{ $downloadRoute }}'
                                    })"
                                    class="inline-flex items-center justify-center h-11 px-4 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-[#0B2A59] transition-colors active:scale-[0.98] leading-4">
                                <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Pratinjau Ringkas</span>
                            </button>

                            <a href="{{ $downloadRoute }}"
                               class="inline-flex items-center justify-center h-11 px-5 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs hover:shadow transition-all active:scale-[0.98] leading-4">
                                <svg class="w-4 h-4 mr-1.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Berkas PDF</span>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>

    <!-- Infografis Alur & Tahapan Pelaksanaan PkM & Penelitian -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-800 leading-4">Alur Tata Laksana</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] leading-8 sm:leading-9">
                    Tahapan Pelaksanaan Penelitian & Pengabdian
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-5">
                    Mekanisme terpadu pengelolaan Tridharma PKTJ mulai dari perumusan proposal hingga hilirisasi luaran berdaya guna bagi keselamatan transportasi nasional.
                </p>
            </div>

            <!-- Steps Grid 4 Kolom Spasial -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                
                <!-- Langkah 1 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 relative flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A59] font-black flex items-center justify-center text-sm leading-4">
                            01
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Pengusulan & Seleksi Berkas</h3>
                        <p class="text-xs text-slate-600 leading-5">
                            Dosen menyusun proposal penelitian terapan atau pengabdian masyarakat mengacu pada buku pedoman, dilampiri dokumen mitra dan diunggah melalui portal SIM P3M.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-200 text-[11px] font-semibold text-slate-500 leading-4">
                        Output: Usulan Terdaftar di SIM
                    </div>
                </div>

                <!-- Langkah 2 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 relative flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-900 font-black flex items-center justify-center text-sm leading-4">
                            02
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Penilaian & Penetapan DIPA</h3>
                        <p class="text-xs text-slate-600 leading-5">
                            Reviewer independen melakukan telaah substansi, kelayakan anggaran, dan dampak mitigasi keselamatan jalan. Proposal yang lolos diterbitkan SK penetapan penugasan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-200 text-[11px] font-semibold text-slate-500 leading-4">
                        Output: Kontrak Penugasan Riset/PkM
                    </div>
                </div>

                <!-- Langkah 3 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 relative flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-900 font-black flex items-center justify-center text-sm leading-4">
                            03
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Implementasi & Monev Lapangan</h3>
                        <p class="text-xs text-slate-600 leading-5">
                            Pelaksanaan pengujian prototipe atau pendampingan masyarakat di desa binaan, disertai monitoring evaluasi kemajuan berkala oleh tim penjamin mutu P3M.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-200 text-[11px] font-semibold text-slate-500 leading-4">
                        Output: Berita Acara Monev Lapangan
                    </div>
                </div>

                <!-- Langkah 4 -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 relative flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 font-black flex items-center justify-center text-sm leading-4">
                            04
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Pelaporan & Hilirisasi Luaran</h3>
                        <p class="text-xs text-slate-600 leading-5">
                            Penyampaian laporan akhir, pencatatan Hak Kekayaan Intelektual (HKI/Paten), publikasi pada jurnal ilmiah bereputasi, serta diseminasi kepada pemangku kepentingan.
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-200 text-[11px] font-semibold text-slate-500 leading-4">
                        Output: Sertifikat HKI & Publikasi
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Direktori Berkas Dokumen Lengkap (Filter Kategori & Pencarian) -->
    <section id="direktori-dokumen" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800 leading-4">Pusat Repositori</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#0B2A59] mt-1 leading-7 sm:leading-8">
                        Direktori Seluruh Berkas & Panduan Operasional
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                        Telusuri dokumen pedoman, standar operasional prosedur (SOP), dan rencana strategis dengan kata kunci atau filter kategori.
                    </p>
                </div>
            </div>

            <!-- Panel Filter & Pencarian -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs space-y-5">
                
                <!-- Filter Pills Kategori -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs">
                    <a href="{{ route('layanan.panduan-pedoman') }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Semua Dokumen
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'pedoman_penelitian']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'pedoman_penelitian' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Pedoman Penelitian & SDM
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'pedoman_pengabdian']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'pedoman_pengabdian' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Pedoman PkM & Kepakaran
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'proses_pengabdian']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'proses_pengabdian' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Proses Pengabdian
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'panduan_sistem']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'panduan_sistem' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Panduan SIM P3M
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'sop']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'sop' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Standar Operasional (SOP)
                    </a>
                    <a href="{{ route('layanan.panduan-pedoman', ['kategori' => 'renstra']) }}" 
                       class="px-4 py-2 rounded-xl font-semibold whitespace-nowrap transition-colors leading-4 {{ $selectedKategori === 'renstra' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Renstra & Roadmap
                    </a>
                </div>

                <!-- Form Pencarian Kata Kunci -->
                <form method="GET" action="{{ route('layanan.panduan-pedoman') }}" class="flex flex-col sm:flex-row gap-3">
                    @if($selectedKategori !== 'semua')
                        <input type="hidden" name="kategori" value="{{ $selectedKategori }}">
                    @endif
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               name="q" 
                               value="{{ $searchQuery }}" 
                               placeholder="Ketik kata kunci judul, topik pedoman, atau tahun terbit..." 
                               class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent leading-4">
                    </div>
                    <button type="submit" class="h-11 px-6 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs transition-colors flex items-center justify-center gap-1.5 leading-4">
                        <span>Cari Dokumen</span>
                    </button>
                    @if(!empty($searchQuery) || $selectedKategori !== 'semua')
                        <a href="{{ route('layanan.panduan-pedoman') }}" class="h-11 px-4 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-600 text-xs font-semibold transition-colors flex items-center justify-center leading-4">
                            Reset Filter
                        </a>
                    @endif
                </form>

            </div>

            <!-- Grid Hasil Dokumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents as $doc)
                    @php
                        $kategoriLabel = match($doc->kategori) {
                            'pedoman_penelitian' => 'Pedoman Penelitian & SDM',
                            'pedoman_pengabdian' => 'Pedoman PkM & Kepakaran',
                            'proses_pengabdian' => 'Proses Pengabdian',
                            'panduan_sistem', 'panduan' => 'Panduan SIM P3M',
                            'sop_penelitian' => 'SOP Penelitian DIPA',
                            'sop_pengabdian' => 'SOP Pengabdian Masyarakat',
                            'renstra_penelitian' => 'Renstra Riset 2026-2031',
                            'renstra_pengabdian' => 'Renstra PkM 2026-2031',
                            'renstra' => 'Renstra Induk P3M',
                            'roadmap' => 'Roadmap Penelitian',
                            default => ucwords(str_replace('_', ' ', $doc->kategori)),
                        };
                        $badgeTheme = match($doc->kategori) {
                            'pedoman_penelitian' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                            'pedoman_pengabdian' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'proses_pengabdian' => 'bg-teal-50 text-teal-700 border-teal-200',
                            'panduan_sistem', 'panduan' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'sop_penelitian', 'sop_pengabdian' => 'bg-amber-50 text-amber-700 border-amber-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                        };
                    @endphp

                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-shadow duration-200 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border uppercase tracking-wider {{ $badgeTheme }} leading-3">
                                    {{ $kategoriLabel }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium leading-4">
                                    {{ $doc->tahun ?? '-' }}
                                </span>
                            </div>

                            <h3 class="text-sm font-bold text-[#0B2A59] leading-5 line-clamp-2">
                                {{ $doc->judul }}
                            </h3>

                            <p class="text-xs text-slate-500 leading-4 line-clamp-2">
                                {{ $doc->deskripsi ?? 'Dokumen panduan penjamin mutu Tridharma Politeknik Keselamatan Transportasi Jalan.' }}
                            </p>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 leading-4">
                                <span>Ukuran: <strong class="text-slate-600">{{ $doc->file_size ?? 'PDF' }}</strong></span>
                                <span>Diunduh: <strong class="text-slate-600">{{ $doc->download_count }}x</strong></span>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                            <button type="button"
                                    @click="openPreview({
                                        judul: '{{ addslashes($doc->judul) }}',
                                        kategori: '{{ $kategoriLabel }}',
                                        deskripsi: '{{ addslashes($doc->deskripsi ?? 'Dokumen panduan penjamin mutu Tridharma Politeknik Keselamatan Transportasi Jalan.') }}',
                                        tahun: '{{ $doc->tahun ?? '-' }}',
                                        file_size: '{{ $doc->file_size ?? '-' }}',
                                        download_count: '{{ $doc->download_count }}',
                                        download_url: '{{ route('layanan.panduan-pedoman.unduh', $doc) }}'
                                    })"
                                    class="text-xs text-[#0B2A59] hover:text-blue-800 font-semibold inline-flex items-center gap-1 leading-4">
                                <span>Pratinjau</span>
                            </button>

                            <a href="{{ route('layanan.panduan-pedoman.unduh', $doc) }}" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-[#0B2A59] text-xs font-semibold transition-colors leading-4">
                                <svg class="w-3.5 h-3.5 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh PDF</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-3">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700 leading-5">Dokumen Tidak Ditemukan</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto leading-4">
                            Tidak ada berkas yang sesuai dengan kata kunci pencarian atau filter kategori yang dipilih.
                        </p>
                        <a href="{{ route('layanan.panduan-pedoman') }}" class="inline-flex items-center text-xs font-semibold text-[#0B2A59] hover:underline pt-2 leading-4">
                            Kembali ke Semua Dokumen
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Navigasi Halaman Pagination -->
            @if($documents->hasPages())
                <div class="pt-6">
                    {{ $documents->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- Tanya Jawab Operasional (FAQ Dosen & Peneliti) -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-800 leading-4">Bantuan Teknis</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] leading-8 sm:leading-9">
                    Tanya Jawab Seputar Panduan & Sistem
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-5">
                    Informasi ringkas mengenai regulasi pengusulan, pemenuhan luaran wajib, dan pengelolaan akun SIM P3M.
                </p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: 1 }">
                
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button type="button" @click="openFaq = openFaq === 1 ? null : 1" class="w-full p-5 text-left bg-slate-50/70 hover:bg-slate-50 flex items-center justify-between gap-4 font-bold text-sm text-[#0B2A59] leading-5">
                        <span>Bagaimana cara memperoleh akses akun SIM P3M untuk pengusulan proposal?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="p-5 text-xs sm:text-sm text-slate-600 border-t border-slate-100 leading-6 bg-white">
                        Akun dosen pengusul dibuat secara otomatis bagi seluruh dosen tetap PKTJ Tegal. Anda dapat masuk menggunakan alamat email dinas institusi terdaftar. Apabila mengalami kendala kredensial atau pergantian data profil, silakan hubungi unit pengelola data P3M di Gedung Direktorat PKTJ atau melalui email p3m@pktj.ac.id.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button type="button" @click="openFaq = openFaq === 2 ? null : 2" class="w-full p-5 text-left bg-slate-50/70 hover:bg-slate-50 flex items-center justify-between gap-4 font-bold text-sm text-[#0B2A59] leading-5">
                        <span>Apa saja luaran wajib yang dipersyaratkan dalam penelitian skema DIPA Kemenhub?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="p-5 text-xs sm:text-sm text-slate-600 border-t border-slate-100 leading-6 bg-white">
                        Berdasarkan Pedoman Penelitian dan Pengembangan SDM PKTJ, luaran wajib skema DIPA meliputi: 1) Laporan Akhir Hasil Penelitian berstandar institusi, 2) Publikasi artikel ilmiah minimal pada jurnal nasional terakreditasi SINTA atau prosiding internasional terindeks, dan 3) Pendaftaran Hak Cipta / Paten terdaftar di DJKI Kemenkumham RI.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button type="button" @click="openFaq = openFaq === 3 ? null : 3" class="w-full p-5 text-left bg-slate-50/70 hover:bg-slate-50 flex items-center justify-between gap-4 font-bold text-sm text-[#0B2A59] leading-5">
                        <span>Bagaimana kriteria kemitraan desa binaan dalam pengabdian kepada masyarakat?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="p-5 text-xs sm:text-sm text-slate-600 border-t border-slate-100 leading-6 bg-white">
                        Mengacu pada Dokumen Proses Pengabdian kepada Masyarakat, mitra desa binaan diprioritaskan pada wilayah yang memiliki titik rawan kecelakaan (black spot), komunitas angkutan pedesaan, karang taruna pelopor keselamatan, atau bengkel UMKM yang membutuhkan transfer iptek standardisasi kelaikan kendaraan.
                    </div>
                </div>

                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button type="button" @click="openFaq = openFaq === 4 ? null : 4" class="w-full p-5 text-left bg-slate-50/70 hover:bg-slate-50 flex items-center justify-between gap-4 font-bold text-sm text-[#0B2A59] leading-5">
                        <span>Apakah format proposal dan laporan keuangan disediakan dalam format terpisah?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="p-5 text-xs sm:text-sm text-slate-600 border-t border-slate-100 leading-6 bg-white">
                        Seluruh template formulir pengusulan, format Rencana Anggaran Biaya (RAB) standar biaya masukan (SBM) Kemenkeu, dan lembar pengesahan telah dilampirkan dalam lampiran berkas Pedoman Penelitian dan SOP Pengusulan yang dapat diunduh pada halaman ini.
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Modal Pratinjau Interaktif Dokumen (Alpine.js) -->
    <div x-show="previewModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" 
         aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="previewModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 sm:p-8 space-y-5 border border-slate-200"
                 @click.outside="previewModalOpen = false">
                
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-[#0B2A59] uppercase tracking-wider leading-3" x-text="activeDoc ? activeDoc.kategori : ''"></span>
                        <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] leading-6" x-text="activeDoc ? activeDoc.judul : ''"></h3>
                    </div>
                    <button type="button" @click="previewModalOpen = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors leading-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2 text-xs">
                    <div class="flex items-center justify-between text-slate-500 leading-4">
                        <span>Tahun Pemberlakuan:</span>
                        <strong class="text-slate-800" x-text="activeDoc ? activeDoc.tahun : '-'"></strong>
                    </div>
                    <div class="flex items-center justify-between text-slate-500 leading-4">
                        <span>Ukuran File:</span>
                        <strong class="text-slate-800" x-text="activeDoc ? activeDoc.file_size : '-'"></strong>
                    </div>
                    <div class="flex items-center justify-between text-slate-500 leading-4">
                        <span>Akumulasi Unduhan:</span>
                        <strong class="text-slate-800" x-text="activeDoc ? activeDoc.download_count + ' kali' : '0 kali'"></strong>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1 leading-4">Ringkasan Materi Dokumen</h4>
                    <p class="text-xs text-slate-600 leading-5" x-text="activeDoc ? activeDoc.deskripsi : ''"></p>
                </div>

                <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                    <button type="button" @click="previewModalOpen = false" class="h-11 px-5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 leading-4">
                        Tutup
                    </button>
                    <a :href="activeDoc ? activeDoc.download_url : '#'" 
                       class="h-11 px-6 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 leading-4">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh Berkas Sekarang</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

</main>
</div>
@endsection
