@extends('layouts.public')

@section('title', 'Kerjasama Penelitian - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori kegiatan kerjasama bidang penelitian P3M PKTJ bersama instansi pemerintah, BUMN, industri manufaktur otomotif, dan perguruan tinggi, tersusun per tahun.')

@section('content')
<main class="flex-1 bg-slate-50 min-h-screen pb-20">

    <!-- 1. Hero Header Banner Institusional -->
    <section class="bg-[#0B2A59] text-white border-b border-yellow-500/30 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-300 leading-4">
                <a href="{{ route('beranda') }}" class="hover:text-yellow-400 transition-colors">Beranda</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-300">Riset</span>
                <span class="text-slate-400">/</span>
                <span class="text-yellow-400 font-semibold">Kerjasama Penelitian</span>
            </nav>

            <div class="space-y-3 max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-950/60 border border-yellow-500/30 text-yellow-400 text-xs font-semibold leading-4">
                    <span>Sinergi & Kemitraan Riset Keselamatan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-8 sm:leading-10">
                    Kerjasama Bidang Penelitian
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-6 max-w-3xl">
                    Rekapitulasi kegiatan kemitraan riset terapan strategis P3M PKTJ bersama Korlantas Polri, Kementerian Perhubungan, BUMN transportasi, serta pelaku industri manufaktur otomotif nasional yang tersusun berdasarkan tahun pelaksanaan.
                </p>
            </div>

            <!-- 4 Kartu Metrik Ringkasan Utama (Strict 4px Spatial Grid) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4">
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Total Kemitraan</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-white leading-8">{{ $totalKerjasama }}</div>
                    <span class="text-[11px] text-yellow-400 font-medium leading-3 block">Riset Berkelanjutan</span>
                </div>
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Kerjasama Aktif</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400 leading-8">{{ $totalAktif }}</div>
                    <span class="text-[11px] text-slate-300 font-medium leading-3 block">Masa Berlaku Berjalan</span>
                </div>
                <div class="bg-white/10 backdrop-blur-xs border border-white/10 rounded-xl p-4 space-y-1">
                    <span class="text-xs text-slate-300 font-medium leading-4 block">Industri & BUMN</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-yellow-400 leading-8">{{ $totalIndustriBumn }}</div>
                    <span class="text-[11px] text-slate-300 font-medium leading-3 block">Mitra Sektor Riil</span>
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
            
            <form method="GET" action="{{ route('riset.kerjasama') }}" class="space-y-4">
                
                <!-- Baris Atas: Input Pencarian & Pilihan Tahun -->
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

                    <!-- Filter Dropdown Program Studi (3 Prodi) -->
                    <div class="md:col-span-3">
                        <select name="prodi" onchange="this.form.submit()" class="w-full h-11 px-3 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B2A59] text-slate-700 leading-4">
                            <option value="semua">Semua Program Studi (3 Prodi)</option>
                            @foreach ($prodis as $pr)
                                <option value="{{ $pr->id }}" {{ $selectedProdi == $pr->id ? 'selected' : '' }}>
                                    {{ $pr->kode_prodi }} - {{ $pr->nama_prodi }}
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
                        
                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['kategori' => 'semua'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Semua Kategori</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['semua'] }}</span>
                        </a>

                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['kategori' => 'pemerintah'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'pemerintah' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Pemerintah</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'pemerintah' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['pemerintah'] }}</span>
                        </a>

                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['kategori' => 'bumn'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'bumn' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>BUMN / BUMD</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'bumn' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['bumn'] }}</span>
                        </a>

                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['kategori' => 'industri'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'industri' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Industri Otomotif</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'industri' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['industri'] }}</span>
                        </a>

                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['kategori' => 'perguruan_tinggi'])) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedKategori === 'perguruan_tinggi' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <span>Perguruan Tinggi</span>
                            <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $selectedKategori === 'perguruan_tinggi' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $kategoriCounts['perguruan_tinggi'] }}</span>
                        </a>
                    </div>

                    <!-- Navigasi Tab Tahun -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="text-xs font-semibold text-slate-500 mr-1 leading-4">Tahun:</span>
                        <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['tahun' => 'semua'])) }}" 
                           class="px-2.5 py-1 rounded text-xs font-semibold transition-colors {{ $selectedYear === 'semua' ? 'bg-yellow-500 text-slate-900 font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                            Semua
                        </a>
                        @foreach ($availableYears as $yr)
                            <a href="{{ route('riset.kerjasama', array_merge(request()->query(), ['tahun' => $yr])) }}" 
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
                    <h3 class="text-base font-bold text-slate-800 leading-6">Data Kerjasama Penelitian Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-5">
                        Tidak ada data kemitraan riset yang sesuai dengan kriteria filter atau kata kunci yang Anda masukkan. Silakan atur ulang filter pencarian Anda.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('riset.kerjasama') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-lg bg-[#0B2A59] text-white text-xs font-semibold hover:bg-blue-900 transition-colors">
                        Atur Ulang Filter
                    </a>
                </div>
            </div>
        @else
            <!-- Loop Kelompok per Tahun -->
            @foreach ($collaborationsByYear as $tahun => $items)
                <div class="space-y-6">
                    
                    <!-- Header Kelompok Tahun -->
                    <div class="flex items-center justify-between border-b-2 border-slate-200 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center h-9 px-3.5 rounded-lg bg-[#0B2A59] text-white text-base font-bold tracking-tight">
                                Tahun {{ $tahun }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 leading-7">
                                Kerjasama Bidang Penelitian
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
                                                    {{ $collab->prodi->kode_prodi }}
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

                                <!-- Bagian Aksi / Unduh Berkas MoU/PKS (Touch target 44px) -->
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                                    <div class="text-[11px] text-slate-400 leading-4">
                                        Data Pendukung Riset
                                    </div>

                                    @if ($collab->file_dokumen)
                                        <a href="{{ route('riset.kerjasama.unduh', $collab->id) }}" 
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

    <!-- 4. Banner Ajakan Kemitraan Strategis Riset -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="bg-gradient-to-r from-[#0B2A59] to-blue-900 rounded-2xl p-6 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 border border-yellow-500/30">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-1.5 text-yellow-400 text-xs font-bold uppercase tracking-wider">
                    <span>Inisiasi Kerjasama Riset Baru</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold leading-7">
                    Bermitra Riset Keselamatan Transportasi dengan P3M PKTJ
                </h3>
                <p class="text-xs sm:text-sm text-slate-200 leading-5">
                    Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ membuka peluang kerjasama riset terapan, pengujian kelaikan teknologi keselamatan, dan kajian kebijakan transportasi jalan dengan kementerian, pemerintah daerah, BUMN, serta pelaku industri manufaktur otomotif.
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
