@extends('layouts.public')

@section('title', 'Kerjasama Pengabdian kepada Masyarakat - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori kegiatan kerjasama bidang pengabdian kepada masyarakat (PkM) P3M PKTJ bersama Dinas Perhubungan, BUMN transportasi, industri, dan komunitas desa binaan, tersusun per tahun.')

@section('content')
<main class="flex-1 bg-slate-50 min-h-screen pb-20" x-data="{ detailModalOpen: false, activeCollab: null }">

    <!-- 1. Hero Header Banner Institusional -->
    <section class="bg-[#0B2A59] text-white border-b border-yellow-500/30 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-300 leading-4">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition-colors">Beranda</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-300">Pengabdian</span>
                <span class="text-slate-400">/</span>
                <span class="text-yellow-400 font-semibold">Kerjasama Pengabdian</span>
            </nav>

            <div class="space-y-3 max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-950/60 border border-yellow-500/30 text-yellow-400 text-xs font-semibold leading-4">
                    <span>Sinergi & Kemitraan Pengabdian Masyarakat</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-8 sm:leading-10">
                    Kerjasama Pengabdian kepada Masyarakat
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-6 max-w-3xl">
                    Rekapitulasi kegiatan kemitraan pengabdian kepada masyarakat (PkM) sivitas akademika Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal bersama Dinas Perhubungan, Korlantas Polri, BUMN transportasi, asosiasi bengkel, dan komunitas desa binaan keselamatan jalan, tersusun per tahun.
                </p>
            </div>

            <!-- 4 Kartu Metrik Ringkasan Utama (Strict 4px Spatial Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Total Kemitraan PkM</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-white leading-8">{{ $totalKerjasama }}</div>
                    <span class="text-[11px] text-yellow-400 font-medium leading-3 block">Pengabdian Terpadu</span>
                </div>
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Kerjasama Aktif</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400 leading-8">{{ $totalAktif }}</div>
                    <span class="text-[11px] text-slate-300 font-medium leading-3 block">Program Berjalan</span>
                </div>
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Pemerintah & BUMN</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-yellow-400 leading-8">{{ $totalPemerintahBumn }}</div>
                    <span class="text-[11px] text-slate-300 font-medium leading-3 block">Mitra Sektor Publik</span>
                </div>
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Dokumen Legalitas</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-white leading-8">{{ $totalDokumen }}</div>
                    <span class="text-[11px] text-slate-300 font-medium leading-3 block">Berkas MoU / PKS Sah</span>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. Panel Filter Multi-Dimensi & Pencarian -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-4">
            
            <form method="GET" action="{{ route('pengabdian.kerjasama') }}" class="space-y-4">
                
                <!-- Baris Atas: Input Pencarian & Pilihan Filter -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-6 relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Cari nama mitra, topik kerjasama, atau no. MoU/PKS..." 
                               class="w-full h-11 pl-10 pr-4 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:bg-white transition-colors leading-5">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Filter Dropdown Program Studi (3 Program Studi PKTJ) -->
                    <div class="md:col-span-3">
                        <select name="prodi" onchange="this.form.submit()" class="w-full h-11 px-3 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B2A59] text-slate-700 leading-4">
                            <option value="semua">Semua Program Studi (3 Prodi)</option>
                            @foreach ($prodis as $pr)
                                <option value="{{ $pr->id }}" {{ $selectedProdi == $pr->id ? 'selected' : '' }}>
                                    {{ $pr->jenjang }} {{ $pr->kode_prodi }} - {{ $pr->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Dropdown Status -->
                    <div class="md:col-span-2">
                        <select name="status" onchange="this.form.submit()" class="w-full h-11 px-3 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B2A59] text-slate-700 leading-4">
                            <option value="semua">Semua Status</option>
                            <option value="aktif" {{ $selectedStatus === 'aktif' ? 'selected' : '' }}>Hanya Aktif</option>
                            <option value="selesai" {{ $selectedStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Tombol Cari / Reset -->
                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="w-full h-11 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-lg text-xs font-semibold flex items-center justify-center transition-colors shadow-xs">
                            Filter
                        </button>
                    </div>

                </div>

                <!-- Baris Bawah: Navigasi Kategori Mitra & Tab Tahun -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-3 border-t border-slate-100">
                    
                    <!-- Kategori Mitra Pills -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-semibold text-slate-500 mr-1 leading-4">Kategori Mitra:</span>
                        
                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'semua'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Semua Kategori</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['semua'] }}</span>
                        </a>

                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'pemerintah'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'pemerintah' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Pemerintah</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'pemerintah' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['pemerintah'] }}</span>
                        </a>

                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'bumn'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'bumn' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>BUMN / BUMD</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'bumn' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['bumn'] }}</span>
                        </a>

                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'industri'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'industri' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Industri & Bengkel</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'industri' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['industri'] }}</span>
                        </a>

                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'perguruan_tinggi'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'perguruan_tinggi' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Perguruan Tinggi</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'perguruan_tinggi' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['perguruan_tinggi'] }}</span>
                        </a>

                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['kategori' => 'lainnya'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'lainnya' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Komunitas & Desa Binaan</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'lainnya' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['lainnya'] }}</span>
                        </a>
                    </div>

                    <!-- Navigasi Tab Tahun -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="text-xs font-semibold text-slate-500 mr-1 leading-4">Tahun:</span>
                        <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['tahun' => 'semua'])) }}" 
                           class="px-2.5 py-1 rounded text-xs font-semibold transition-colors {{ $selectedYear === 'semua' ? 'bg-yellow-500 text-slate-900 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                            Semua
                        </a>
                        @foreach ($availableYears as $yr)
                            <a href="{{ route('pengabdian.kerjasama', array_merge(request()->query(), ['tahun' => $yr])) }}" 
                               class="px-2.5 py-1 rounded text-xs font-semibold transition-colors {{ $selectedYear == $yr ? 'bg-yellow-500 text-slate-900 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                                {{ $yr }}
                            </a>
                        @endforeach
                    </div>

                </div>

            </form>

        </div>
    </section>

    <!-- 3. Daftar Kegiatan Kerjasama (Tersusun per Tahun) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-12">
        
        @if ($collaborationsByYear->isEmpty())
            <!-- Tampilan Data Tidak Ditemukan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center mx-auto text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-slate-800 leading-6">Data Kerjasama Pengabdian Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-5">
                        Tidak ada data kemitraan pengabdian kepada masyarakat yang sesuai dengan kriteria filter atau kata kunci yang Anda masukkan. Silakan atur ulang filter pencarian Anda.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('pengabdian.kerjasama') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-lg bg-[#0B2A59] text-white text-xs font-semibold hover:bg-blue-900 transition-colors">
                        Atur Ulang Filter
                    </a>
                </div>
            </div>
        @else
            <!-- Loop Kelompok per Tahun Descending -->
            @foreach ($collaborationsByYear as $tahun => $items)
                <div class="space-y-6">
                    
                    <!-- Header Kelompok Tahun -->
                    <div class="flex items-center justify-between border-b-2 border-slate-200 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center h-9 px-3.5 rounded-lg bg-[#0B2A59] text-white text-base font-bold tracking-tight">
                                Tahun {{ $tahun }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 leading-7">
                                Kerjasama Pengabdian kepada Masyarakat
                            </h2>
                        </div>
                        <span class="text-xs font-semibold text-slate-500 leading-4">
                            {{ $items->count() }} Kegiatan Kemitraan
                        </span>
                    </div>

                    <!-- Grid Kartu Data Kerjasama (Strict 4px Spatial Grid) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($items as $collab)
                            <div class="bg-white rounded-2xl border border-slate-200 hover:border-blue-300 shadow-xs hover:shadow-md transition-all duration-200 p-6 flex flex-col justify-between space-y-4">
                                
                                <div class="space-y-3">
                                    
                                    <!-- Badge Header: Kategori Mitra & Status Kerjasama -->
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider
                                                @if ($collab->kategori_mitra === 'pemerintah') bg-blue-100 text-blue-900
                                                @elseif ($collab->kategori_mitra === 'bumn') bg-amber-100 text-amber-900
                                                @elseif ($collab->kategori_mitra === 'industri') bg-emerald-100 text-emerald-900
                                                @else bg-purple-100 text-purple-900 @endif">
                                                {{ $collab->kategori_label }}
                                            </span>

                                            @if ($collab->prodi)
                                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700">
                                                    {{ $collab->prodi->jenjang }} {{ $collab->prodi->kode_prodi }}
                                                </span>
                                            @endif
                                        </div>

                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold flex items-center gap-1.5
                                            {{ $collab->status_kerjasama === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $collab->status_kerjasama === 'aktif' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $collab->status_kerjasama === 'aktif' ? 'Kerjasama Aktif' : 'Selesai' }}</span>
                                        </span>
                                    </div>

                                    <!-- Nama Mitra Strategis -->
                                    <div>
                                        <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] leading-6 tracking-tight">
                                            {{ $collab->nama_mitra }}
                                        </h3>
                                        @if ($collab->judul_kerjasama)
                                            <p class="text-xs sm:text-sm font-semibold text-slate-800 mt-1 leading-5">
                                                {{ $collab->judul_kerjasama }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Deskripsi Ruang Lingkup Kerjasama -->
                                    @if ($collab->deskripsi)
                                        <p class="text-xs text-slate-600 leading-5 line-clamp-3">
                                            {{ $collab->deskripsi }}
                                        </p>
                                    @endif

                                    <!-- Data Pendukung: Nomor MoU & Periode Pelaksanaan -->
                                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 space-y-1.5 text-xs">
                                        <div class="flex items-start justify-between gap-2">
                                            <span class="text-slate-500 font-medium">Nomor Perjanjian:</span>
                                            <span class="font-bold text-slate-800 text-right">{{ $collab->nomor_mou_pks ?? 'Dalam Proses Penomoran' }}</span>
                                        </div>
                                        @if ($collab->tanggal_mulai && $collab->tanggal_berakhir)
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-slate-500 font-medium">Masa Berlaku:</span>
                                                <span class="text-slate-700 font-medium text-right">
                                                    {{ $collab->tanggal_mulai->translatedFormat('d M Y') }} s/d {{ $collab->tanggal_berakhir->translatedFormat('d M Y') }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-slate-500 font-medium">Tahun Kerjasama:</span>
                                                <span class="text-slate-700 font-medium text-right">Tahun Anggaran {{ $collab->tahun }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <!-- Bagian Aksi / Unduh Berkas MoU/PKS & Modal Rincian (Touch target 44px) -->
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                    <button type="button"
                                            @click="activeCollab = {{ json_encode($collab) }}; detailModalOpen = true"
                                            class="inline-flex items-center gap-1.5 h-11 px-3.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-[#0B2A59] hover:bg-slate-100 transition-colors leading-4">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Rincian</span>
                                    </button>

                                    @if ($collab->file_dokumen)
                                        <a href="{{ route('pengabdian.kerjasama.unduh', $collab->id) }}" 
                                           class="inline-flex items-center gap-1.5 h-11 px-4 rounded-lg text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-[#0B2A59] hover:text-white border border-blue-200 transition-colors leading-4">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Unduh Dokumen MoU / PKS</span>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 h-11 px-3 text-xs text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed leading-4">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            <span>Dokumen Khusus Internal</span>
                                        </span>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        @endif

    </section>

    <!-- 4. Modal Interaktif Rincian Kerjasama Pengabdian -->
    <div x-show="detailModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="detailModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/60 transition-opacity" 
                 @click="detailModalOpen = false" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="detailModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                
                <template x-if="activeCollab">
                    <div>
                        <!-- Header Modal -->
                        <div class="bg-[#0B2A59] text-white p-6 flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <span class="text-xs font-semibold text-yellow-400 uppercase tracking-wider block" x-text="activeCollab.kategori_mitra ? activeCollab.kategori_mitra.toUpperCase() : 'MITRA'"></span>
                                <h3 class="text-lg sm:text-xl font-bold leading-6 tracking-tight" x-text="activeCollab.nama_mitra"></h3>
                                <p class="text-xs text-slate-300" x-text="activeCollab.judul_kerjasama"></p>
                            </div>
                            <button @click="detailModalOpen = false" type="button" class="text-slate-300 hover:text-white p-1 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Konten Rincian Modal -->
                        <div class="p-6 space-y-6 text-xs text-slate-700">
                            
                            <!-- Ruang Lingkup / Deskripsi -->
                            <div class="space-y-1">
                                <span class="font-bold text-slate-900 block leading-4">Ruang Lingkup & Kemanfaatan Pengabdian</span>
                                <p class="text-slate-600 leading-relaxed text-xs" x-text="activeCollab.deskripsi || 'Rincian deskripsi kemitraan pengabdian belum dicatat secara lengkap.'"></p>
                            </div>

                            <!-- Metadata Legalitas Tabel Rinci -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <span class="text-slate-500 block leading-3 text-[11px]">Nomor Dokumen Perjanjian (MoU/PKS)</span>
                                        <span class="font-bold text-slate-900 leading-4 block mt-0.5" x-text="activeCollab.nomor_mou_pks || '-'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block leading-3 text-[11px]">Tahun Pelaksanaan</span>
                                        <span class="font-bold text-slate-900 leading-4 block mt-0.5" x-text="'Tahun Anggaran ' + activeCollab.tahun"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block leading-3 text-[11px]">Status Kemitraan</span>
                                        <span class="font-bold leading-4 block mt-0.5" :class="activeCollab.status_kerjasama === 'aktif' ? 'text-emerald-700' : 'text-slate-600'" x-text="activeCollab.status_kerjasama === 'aktif' ? 'Kerjasama Aktif Berjalan' : 'Selesai / Terarsip'"></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block leading-3 text-[11px]">Klasifikasi Program</span>
                                        <span class="font-bold text-slate-900 leading-4 block mt-0.5" x-text="activeCollab.jenis_kegiatan === 'keduanya' ? 'Riset & Pengabdian' : 'Pengabdian kepada Masyarakat'"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Modal -->
                        <div class="bg-slate-100 p-4 flex items-center justify-between gap-3 border-t border-slate-200">
                            <span class="text-[11px] text-slate-500 leading-4">P3M PKTJ Tegal</span>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="detailModalOpen = false" class="h-10 px-4 rounded-lg bg-white border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    Tutup
                                </button>
                                <template x-if="activeCollab.file_dokumen">
                                    <a :href="'/pengabdian/kerjasama/' + activeCollab.id + '/unduh'" class="inline-flex items-center gap-1.5 h-10 px-4 rounded-lg bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Unduh Berkas Legalitas</span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>

    <!-- 5. Banner Ajakan Kemitraan Pengabdian Masyarakat -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="bg-gradient-to-r from-[#0B2A59] to-blue-900 rounded-2xl p-6 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 border border-yellow-500/30">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-1.5 text-yellow-400 text-xs font-bold uppercase tracking-wider">
                    <span>Inisiasi Kerjasama Pengabdian Baru</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold leading-7">
                    Kolaborasi Pengabdian & Desa Binaan Bersama PKTJ
                </h3>
                <p class="text-xs sm:text-sm text-slate-200 leading-5">
                    Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ membuka ruang kemitraan pengabdian vokasi, pembinaan keselamatan lalu lintas jalan, pendampingan uji kelaikan armada, dan standardisasi teknologi bengkel rakyat bersama pemerintah daerah, BUMN, industri, dan organisasi kemasyarakatan.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="mailto:p3m@pktj.ac.id" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-xs sm:text-sm font-bold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 transition-colors shadow-sm leading-5">
                    Hubungi Pengelola P3M PKTJ
                </a>
            </div>
        </div>
    </section>

</main>
@endsection
