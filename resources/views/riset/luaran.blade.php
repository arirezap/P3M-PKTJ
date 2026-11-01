@extends('layouts.public')

@section('title', 'Luaran Penelitian & Pengembangan Vokasi - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Katalog luaran riset terapan P3M PKTJ Tegal: Publikasi Ilmiah, Hak Kekayaan Intelektual (HKI), dan Produk/Jasa Teknologi dengan adopsi lisensi terbuka, keselarasan peta jalan, dan kemitraan strategis.')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedOutput: null,
    openDetail(item) {
        this.selectedOutput = item;
        this.detailModalOpen = true;
    }
}">
<main class="flex-1">

        <!-- Hero Section Header -->
        <section class="bg-gradient-to-b from-blue-50/70 via-slate-50/40 to-white py-12 sm:py-16 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                        <li>
                            <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                        </li>
                        <li>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                        <li>
                            <span class="text-slate-400">Riset</span>
                        </li>
                        <li>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                        <li class="font-semibold text-[#0B2A59]">Luaran Penelitian</li>
                    </ol>
                </nav>

                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span>Diseminasi Hasil Riset & Hilirisasi Vokasi Kemenhub</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B2A59] tracking-tight leading-tight">
                        Luaran Penelitian & Pengembangan Vokasi
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Etalase publikasi ilmiah, hak kekayaan intelektual (HKI), dan produk/jasa teknologi terapan sivitas akademika PKTJ Tegal yang mengadopsi lisensi terbuka, berorientasi keberlanjutan peta jalan, serta bermitra nyata dengan industri transportasi.
                    </p>
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white border border-slate-200 text-[#0B2A59] shadow-sm leading-4">D4 RSTJ</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white border border-slate-200 text-[#0B2A59] shadow-sm leading-4">D4 TRO</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white border border-slate-200 text-[#0B2A59] shadow-sm leading-4">D3 TO</span>
                    </div>
                </div>

                <!-- 4 Kartu Metrik Capaian Luaran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                    <!-- Kartu 1: Total Portofolio Luaran -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Total Luaran</span>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0B2A59] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-[#0B2A59] leading-9">{{ $totalOutputs }}</span>
                            <span class="text-xs text-slate-500 font-medium">Judul Luaran</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-4 pt-1 border-t border-slate-100">
                            Tersebar di 3 Program Studi PKTJ
                        </p>
                    </div>

                    <!-- Kartu 2: Publikasi Ilmiah SINTA & Scopus -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Publikasi Ilmiah</span>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-blue-700 leading-9">{{ $totalPublikasi }}</span>
                            <span class="text-xs text-slate-500 font-medium">Artikel Jurnal</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-4 pt-1 border-t border-slate-100">
                            Jurnal Terindeks SINTA & Scopus Bereputasi
                        </p>
                    </div>

                    <!-- Kartu 3: HKI (Paten & Hak Cipta) -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Sentra HKI</span>
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-amber-700 leading-9">{{ $totalHki }}</span>
                            <span class="text-xs text-slate-500 font-medium">Sertifikat Terdaftar</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-4 pt-1 border-t border-slate-100">
                            Paten Sederhana & Hak Cipta Terdaftar DJKI
                        </p>
                    </div>

                    <!-- Kartu 4: Produk / Jasa & Lisensi Terbuka -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Produk & Lisensi</span>
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-emerald-700 leading-9">{{ $totalProduk }}</span>
                            <span class="text-xs text-slate-500 font-medium">Prototipe & Sistem</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-4 pt-1 border-t border-slate-100">
                            {{ $openLicenseCount }} Mengadopsi Lisensi Terbuka (Open Access)
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Daftar Luaran: Tab 3 Pilar & Filter Interaktif -->
        <section class="py-12 sm:py-16 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Katalog Luaran Penelitian Terpadu
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Menampilkan {{ $outputs->total() }} karya luaran terdaftar yang memenuhi kriteria pencarian dan filter aktif.
                        </p>
                    </div>

                    <!-- Tombol Panduan SIM P3M -->
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm leading-4 self-start sm:self-auto">
                        <span>Daftarkan Luaran Baru</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- 1. Tab Bar 3 Pilar Luaran -->
                <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm overflow-x-auto">
                    <div class="flex items-center gap-1.5 min-w-max">
                        <a href="{{ route('riset.luaran', array_merge(request()->except('kategori', 'page'), ['kategori' => 'semua'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Semua Luaran</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['semua'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.luaran', array_merge(request()->except('kategori', 'page'), ['kategori' => 'publikasi'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'publikasi' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>1. Publikasi Ilmiah</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'publikasi' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['publikasi'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.luaran', array_merge(request()->except('kategori', 'page'), ['kategori' => 'hki'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'hki' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>2. Hak Kekayaan Intelektual (HKI)</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'hki' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['hki'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.luaran', array_merge(request()->except('kategori', 'page'), ['kategori' => 'produk'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'produk' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>3. Produk & Jasa Teknologi</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'produk' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['produk'] }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. Baris Filter Interaktif Multi-Device -->
                <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-sm space-y-4">
                    <form method="GET" action="{{ route('riset.luaran') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4">
                        <input type="hidden" name="kategori" value="{{ $activeTab }}">

                        <!-- Filter Program Studi PKTJ -->
                        <div class="lg:col-span-3">
                            <label class="block text-xs font-bold text-slate-700 mb-1 leading-4">Program Studi</label>
                            <select name="prodi" onchange="this.form.submit()"
                                    class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                                <option value="semua">Semua 3 Program Studi</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->kode_prodi }}" {{ $selectedProdi === $prodi->kode_prodi ? 'selected' : '' }}>
                                        {{ $prodi->jenjang }} {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun Realisasi -->
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1 leading-4">Tahun Luaran</label>
                            <select name="tahun" onchange="this.form.submit()"
                                    class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                                <option value="semua">Semua Tahun</option>
                                @foreach($tahunList as $thn)
                                    <option value="{{ $thn }}" {{ (string)$selectedTahun === (string)$thn ? 'selected' : '' }}>
                                        Tahun {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Lisensi Terbuka -->
                        <div class="lg:col-span-3">
                            <label class="block text-xs font-bold text-slate-700 mb-1 leading-4">Adopsi Lisensi</label>
                            <select name="lisensi" onchange="this.form.submit()"
                                    class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                                <option value="semua">Semua Status Lisensi</option>
                                <option value="terbuka" {{ $selectedLisensi === 'terbuka' ? 'selected' : '' }}>Hanya Lisensi Terbuka (Open Access / CC / Open Source)</option>
                            </select>
                        </div>

                        <!-- Pencarian Instan -->
                        <div class="lg:col-span-4">
                            <label class="block text-xs font-bold text-slate-700 mb-1 leading-4">Cari Kata Kunci</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul, inventor, mitra..."
                                           class="w-full h-11 pl-9 pr-3 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit" class="h-11 px-4 bg-[#0B2A59] hover:bg-blue-900 text-white font-semibold text-xs rounded-xl shadow-sm leading-4 transition-colors">
                                    Cari
                                </button>
                                @if(request()->hasAny(['prodi', 'tahun', 'lisensi', 'q']))
                                    <a href="{{ route('riset.luaran', ['kategori' => $activeTab]) }}" 
                                       class="h-11 px-3 border border-slate-300 text-slate-600 hover:bg-slate-50 font-medium text-xs rounded-xl flex items-center leading-4 transition-colors">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>

                <!-- 3. Daftar Kartu Luaran Penelitian (Responsif Multi-Device) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($outputs as $item)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between space-y-4">
                            
                            <div class="space-y-3">
                                <!-- Lencana Kategori, Prodi & Tahun -->
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($item->kategori === 'publikasi')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800">
                                                Publikasi Ilmiah
                                            </span>
                                        @elseif($item->kategori === 'hki')
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800">
                                                Sentra HKI
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">
                                                Produk & Jasa
                                            </span>
                                        @endif

                                        <span class="px-2 py-0.5 rounded-md bg-[#0B2A59]/10 text-[#0B2A59] font-bold text-[10px]">
                                            {{ $item->prodi ? $item->prodi->jenjang . ' ' . $item->prodi->kode_prodi : 'PKTJ' }}
                                        </span>
                                    </div>

                                    <span class="text-xs font-semibold text-slate-400">Tahun {{ $item->tahun }}</span>
                                </div>

                                <!-- Judul Luaran -->
                                <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-3 hover:text-[#0B2A59] transition-colors">
                                    {{ $item->judul }}
                                </h3>

                                <!-- Penulis / Inventor -->
                                <p class="text-xs text-slate-600 line-clamp-1 leading-4">
                                    <span class="font-semibold text-slate-700">Oleh:</span> {{ $item->author_inventor }}
                                </p>

                                <!-- Keterangan Spesifik -->
                                @if($item->nama_jurnal_penerbit)
                                    <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100/60 text-[11px] text-blue-900 leading-4">
                                        <span class="font-semibold block">Wadah Publikasi:</span>
                                        <span class="line-clamp-1">{{ $item->nama_jurnal_penerbit }}</span>
                                    </div>
                                @elseif($item->nomor_registrasi_hki)
                                    <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-100/60 text-[11px] text-amber-900 leading-4">
                                        <span class="font-semibold block">No. Registrasi DJKI:</span>
                                        <span class="font-mono">{{ $item->nomor_registrasi_hki }}</span>
                                    </div>
                                @elseif($item->tingkat_kesiapan_terapan)
                                    <div class="p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-100/60 text-[11px] text-emerald-900 leading-4">
                                        <span class="font-semibold block">Kesiapan Teknologi:</span>
                                        <span>{{ $item->tingkat_kesiapan_terapan }} - Sistem Uji Operasional</span>
                                    </div>
                                @endif

                                <!-- Indikator Akreditasi: Lisensi Terbuka & Roadmap -->
                                <div class="space-y-1.5 pt-1 text-[11px] leading-4 border-t border-slate-100">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span class="text-slate-500 font-medium">Lisensi:</span>
                                        <span class="font-bold text-emerald-700 line-clamp-1">{{ $item->lisensi ?? 'Lisensi Standar Kedinasan' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        <span class="text-slate-500 font-medium">Roadmap:</span>
                                        <span class="font-semibold text-slate-700 line-clamp-1">{{ $item->fase_roadmap ?? 'Peta Jalan Riset PKTJ' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        <span class="text-slate-500 font-medium">Mitra:</span>
                                        <span class="font-semibold text-slate-700 line-clamp-1">{{ $item->mitra_kerjasama ?? 'PKTJ Mandiri' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi Kartu -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                <button @click="openDetail({{ json_encode($item) }})" type="button"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0B2A59] hover:text-blue-900 leading-4 p-1">
                                    <span>Rincian & Kemanfaatan</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>

                                <div class="flex items-center gap-1.5">
                                    @if($item->link_dokumen)
                                        <a href="{{ $item->link_dokumen }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors" title="Buka Tautan Luar (DOI/SINTA/DJKI)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif

                                    @if($item->berkas_luaran)
                                        <a href="{{ route('riset.luaran.unduh', $item) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#0B2A59] text-white hover:bg-blue-900 transition-colors" title="Unduh Berkas Dokumen PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full bg-white border border-slate-200 rounded-3xl p-12 text-center space-y-3 shadow-sm">
                            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 leading-6">Tidak Ditemukan Data Luaran Penelitian</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                                Tidak ada karya publikasi ilmiah, HKI, atau produk terapan yang sesuai dengan kriteria filter yang Anda tentukan. Silakan atur ulang filter pencarian Anda.
                            </p>
                            <div class="pt-2">
                                <a href="{{ route('riset.luaran') }}" class="inline-flex items-center justify-center h-10 px-5 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 leading-4">
                                    Tampilkan Semua Luaran
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Navigasi Halaman (Pagination) -->
                @if($outputs->hasPages())
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex items-center justify-center">
                        {{ $outputs->links() }}
                    </div>
                @endif

            </div>
        </section>

    </main>

    <!-- Modal Popup Detail Luaran Penelitian (Alpine.js) -->
    <div x-show="detailModalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         @keydown.escape.window="detailModalOpen = false">
        
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto border border-slate-100"
             @click.outside="detailModalOpen = false">
            
            <!-- Header Modal -->
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-900" 
                              x-text="selectedOutput?.kategori?.toUpperCase()"></span>
                        <span class="px-2 py-0.5 rounded-md bg-[#0B2A59]/10 text-[#0B2A59] font-bold text-[10px]"
                              x-text="(selectedOutput?.prodi?.jenjang ? selectedOutput.prodi.jenjang + ' ' : '') + (selectedOutput?.prodi?.kode_prodi || 'PKTJ')"></span>
                        <span class="text-xs font-semibold text-slate-400" x-text="'Tahun ' + selectedOutput?.tahun"></span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug" x-text="selectedOutput?.judul"></h3>
                </div>
                <button @click="detailModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Konten Rincian Indikator -->
            <div class="space-y-4 text-xs">
                
                <!-- Tim Peneliti / Inventor -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-slate-400 block text-[11px] leading-3">Penulis / Inventor:</span>
                    <span class="font-bold text-slate-800 text-xs leading-5 mt-0.5 block" x-text="selectedOutput?.author_inventor"></span>
                </div>

                <!-- Rincian Identitas Publikasi / HKI / TKT -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Wadah Terbit / Registrasi:</span>
                        <span class="font-bold text-slate-800 text-xs leading-5 mt-0.5 block" 
                              x-text="selectedOutput?.nama_jurnal_penerbit || selectedOutput?.nomor_registrasi_hki || selectedOutput?.tingkat_kesiapan_terapan || 'Tervalidasi PKTJ'"></span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Lisensi Luaran:</span>
                        <span class="font-bold text-emerald-700 text-xs leading-5 mt-0.5 block" 
                              x-text="selectedOutput?.lisensi || 'Lisensi Terbuka Kedinasan'"></span>
                    </div>
                </div>

                <!-- Mitra & Realisasi Dana -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Mitra Kerjasama:</span>
                        <span class="font-bold text-slate-800 text-xs leading-5 mt-0.5 block" 
                              x-text="selectedOutput?.mitra_kerjasama || 'Mandiri / Internal PKTJ'"></span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Realisasi Dana R&D:</span>
                        <span class="font-bold text-slate-800 text-xs leading-5 mt-0.5 block" 
                              x-text="(selectedOutput?.sumber_dana || 'DIPA PKTJ') + ' • Rp ' + Number(selectedOutput?.realisasi_dana || 0).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <!-- Keselarasan Peta Jalan Riset -->
                <div class="p-3.5 rounded-xl bg-blue-50/60 border border-blue-100 text-blue-900">
                    <span class="text-blue-700 block text-[11px] font-semibold leading-3">Keselarasan Roadmap Riset Keselamatan:</span>
                    <span class="font-bold text-xs leading-5 mt-0.5 block" x-text="selectedOutput?.fase_roadmap || 'Fase Roadmap Riset PKTJ Terpadu'"></span>
                </div>

                <!-- Deskripsi Keberlanjutan & Kemanfaatan -->
                <div>
                    <h4 class="font-bold text-slate-800 mb-1 leading-4">Keberlanjutan & Kemanfaatan Nyata Bagi Keselamatan Jalan:</h4>
                    <p class="text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs" 
                       x-text="selectedOutput?.deskripsi_kemanfaatan || 'Karya luaran penelitian terapan ini berkontribusi langsung pada penguatan keselamatan transportasi perhubungan darat, pencegahan risiko kecelakaan lalu lintas, dan peningkatan kelaikan armada.'">
                    </p>
                </div>
            </div>

            <!-- Footer Modal & Tombol Aksi -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                <button @click="detailModalOpen = false" type="button" class="h-10 px-4 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 font-semibold leading-4">
                    Tutup
                </button>
                
                <div class="flex items-center gap-2">
                    <template x-if="selectedOutput?.link_dokumen">
                        <a :href="selectedOutput?.link_dokumen" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 h-10 px-4 rounded-xl font-semibold text-[#0B2A59] border border-[#0B2A59] hover:bg-blue-50 transition-colors leading-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Buka Tautan Luar</span>
                        </a>
                    </template>

                    <template x-if="selectedOutput?.berkas_luaran">
                        <a :href="'/riset/luaran/' + selectedOutput?.id + '/unduh'"
                           class="inline-flex items-center gap-1.5 h-10 px-5 rounded-xl font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Bukti PDF</span>
                        </a>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Institusi Kemenhub -->
</div>
@endsection
