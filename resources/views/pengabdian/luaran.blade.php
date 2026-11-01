@extends('layouts.public')

@section('title', 'Hasil Analisis Luaran Pengabdian kepada Masyarakat - P3M PKTJ')
@section('meta_description', 'Analisis capaian dan evaluasi dampak terhadap luaran pengabdian kepada masyarakat (PkM) dosen dan taruna Politeknik Keselamatan Transportasi Jalan Tegal: publikasi ilmiah pengabdian, teknologi tepat guna (TTG), modul mitra, HKI, dan desa binaan.')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedOutput: null,
    viewMode: 'table',
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
                            <span class="text-slate-400">Pengabdian</span>
                        </li>
                        <li>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                        <li class="font-semibold text-[#0B2A59]">Hasil Analisis Luaran</li>
                    </ol>
                </nav>

                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                        <span class="w-2 h-2 rounded-full bg-[#C5A55D]"></span>
                        <span>Evaluasi Dampak & Kemanfaatan Vokasi Kemenhub</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B2A59] tracking-tight leading-tight">
                        Hasil Analisis Luaran Pengabdian
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Hasil analisis dan evaluasi terukur terhadap luaran kegiatan Pengabdian kepada Masyarakat (PkM) sivitas akademika Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal yang mencakup publikasi jurnal pengabdian, penerapan teknologi tepat guna (TTG), modul standardisasi bengkel mitra, perlindungan hak cipta (HKI), dan keberlanjutan rekayasa desa binaan keselamatan jalan.
                    </p>
                </div>

                <!-- 4 Kartu Metrik Analisis Dampak -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                    <!-- Kartu 1: Total Luaran Terverifikasi -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-4">Total Luaran PkM</span>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0B2A59] flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-9">
                            {{ $totalLuaran }} <span class="text-xs font-medium text-slate-500">Luaran</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Terdaftar & terevaluasi P3M</p>
                    </div>

                    <!-- Kartu 2: Indeks Kepuasan Mitra -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider leading-4">Kepuasan Mitra</span>
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2m-7 0H4a2 2 0 00-2 2v6a2 2 0 002 2h3" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 tracking-tight leading-9">
                            {{ $avgKepuasan }}%
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Indeks survei kepuasan mitra sasaran</p>
                    </div>

                    <!-- Kartu 3: Mitra & Desa Binaan -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">Mitra & Desa Sasaran</span>
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-9">
                            {{ $totalMitra }} <span class="text-xs font-medium text-slate-500">Mitra</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">{{ $totalDesaBinaan }} wilayah binaan keselamatan</p>
                    </div>

                    <!-- Kartu 4: Produk TTG & Modul Mitra -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider leading-4">TTG & Modul Terapan</span>
                            <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-9">
                            {{ $totalTtgModul }} <span class="text-xs font-medium text-slate-500">Inovasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Alat bantu praktis & SOP terapan</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bagian Visualisasi: Grafik Tren & Distribusi Capaian 3 Program Studi -->
        <section class="py-12 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4 mb-2">
                            <span>Visualisasi Hasil Analisis</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Grafik Capaian Luaran per Tahun & Sebaran Keilmuan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Analisis kuantitatif luaran PkM per kategori pada 3 Program Studi PKTJ.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Kolom Kiri: Visual Bar Chart Capaian per Tahun -->
                    <div class="lg:col-span-8 bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-4 flex-wrap gap-3">
                            <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Komposisi Luaran per Tahun Anggaran</h3>
                            <div class="flex items-center gap-3 text-xs text-slate-600 flex-wrap">
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#0B2A59]"></span> Publikasi</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-600"></span> TTG</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-amber-500"></span> Modul</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-purple-600"></span> HKI</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-rose-500"></span> Desa Binaan</span>
                            </div>
                        </div>

                        <!-- Bar Chart Container -->
                        <div class="space-y-6 pt-2">
                            @forelse($yearlyStats as $stat)
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                                        <div class="flex items-center gap-2">
                                            <span class="w-12 font-bold text-[#0B2A59] text-sm leading-5">{{ $stat['tahun'] }}</span>
                                            <span class="text-slate-500 font-normal">({{ $stat['total'] }} Luaran Tercatat)</span>
                                        </div>
                                    </div>

                                    <!-- Stacked Progress Bar Multi-Kelipatan 4px -->
                                    <div class="w-full h-7 bg-white border border-slate-200 rounded-xl overflow-hidden flex shadow-xs">
                                        @php
                                            $total = max(1, $stat['total']);
                                            $pubPct = ($stat['publikasi'] / $total) * 100;
                                            $ttgPct = ($stat['ttg'] / $total) * 100;
                                            $modPct = ($stat['modul'] / $total) * 100;
                                            $hkiPct = ($stat['hki'] / $total) * 100;
                                            $desaPct = ($stat['desa_binaan'] / $total) * 100;
                                        @endphp
                                        
                                        @if($stat['publikasi'] > 0)
                                            <div style="width: {{ $pubPct }}%" class="h-full bg-[#0B2A59] text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Publikasi: {{ $stat['publikasi'] }}">
                                                {{ $stat['publikasi'] }}
                                            </div>
                                        @endif
                                        @if($stat['ttg'] > 0)
                                            <div style="width: {{ $ttgPct }}%" class="h-full bg-emerald-600 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Teknologi TTG: {{ $stat['ttg'] }}">
                                                {{ $stat['ttg'] }}
                                            </div>
                                        @endif
                                        @if($stat['modul'] > 0)
                                            <div style="width: {{ $modPct }}%" class="h-full bg-amber-500 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Modul SOP: {{ $stat['modul'] }}">
                                                {{ $stat['modul'] }}
                                            </div>
                                        @endif
                                        @if($stat['hki'] > 0)
                                            <div style="width: {{ $hkiPct }}%" class="h-full bg-purple-600 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="HKI: {{ $stat['hki'] }}">
                                                {{ $stat['hki'] }}
                                            </div>
                                        @endif
                                        @if($stat['desa_binaan'] > 0)
                                            <div style="width: {{ $desaPct }}%" class="h-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Desa Binaan: {{ $stat['desa_binaan'] }}">
                                                {{ $stat['desa_binaan'] }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Breakdown per 3 Program Studi PKTJ -->
                                    <div class="flex items-center gap-4 text-[11px] text-slate-500 pl-14">
                                        <span>D4 RSTJ: <strong class="text-slate-800">{{ $stat['rstj'] }}</strong></span>
                                        <span>•</span>
                                        <span>D4 TRO: <strong class="text-slate-800">{{ $stat['tro'] }}</strong></span>
                                        <span>•</span>
                                        <span>D3 TO: <strong class="text-slate-800">{{ $stat['to'] }}</strong></span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-8 text-center text-xs text-slate-400">
                                    Belum ada data grafik yang dapat divisualisasikan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Kolom Kanan: Distribusi Capaian 3 Program Studi -->
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                        <div class="border-b border-slate-100 pb-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Distribusi Keilmuan</span>
                            <h3 class="text-base font-bold text-[#0B2A59] leading-6">Capaian 3 Program Studi</h3>
                            <p class="text-xs text-slate-500 mt-0.5 leading-4">Proporsi kontribusi luaran pengabdian PKTJ.</p>
                        </div>

                        <div class="space-y-4">
                            @foreach($prodiStats as $ps)
                                @php
                                    $prodiPct = $totalLuaran > 0 ? ($ps['total'] / $totalLuaran) * 100 : 0;
                                @endphp
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-bold text-[#0B2A59] text-sm leading-5">{{ $ps['kode'] }}</span>
                                            <p class="text-[11px] text-slate-500 leading-4">{{ $ps['nama'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-extrabold text-slate-900 text-sm leading-5">{{ $ps['total'] }} Luaran</span>
                                            <p class="text-[11px] font-semibold text-blue-700 leading-4">
                                                {{ $ps['publikasi'] }} Pub / {{ $ps['ttg'] + $ps['modul'] }} TTG
                                            </p>
                                        </div>
                                    </div>
                                    <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#0B2A59] rounded-full" style="width: {{ $prodiPct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-2 text-[11px] text-slate-400 text-center leading-4">
                            Sumber Data: Sistem Informasi Manajemen SIM P3M PKTJ Tegal
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Daftar Luaran Pengabdian Berdasarkan Kategori & Tersusun per Tahun -->
        <section class="py-12 sm:py-16 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Portofolio Hasil Analisis Luaran
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Menampilkan {{ $outputs->count() }} data capaian luaran pengabdian yang terverifikasi.
                        </p>
                    </div>

                    <!-- Tombol Panduan & Toggle View -->
                    <div class="flex items-center gap-3">
                        <div class="inline-flex p-1 bg-white border border-slate-200 rounded-xl shadow-xs">
                            <button @click="viewMode = 'table'" type="button" 
                                    class="h-9 px-3 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all"
                                    :class="viewMode === 'table' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                <span>Tabel</span>
                            </button>
                            <button @click="viewMode = 'card'" type="button" 
                                    class="h-9 px-3 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all"
                                    :class="viewMode === 'card' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                <span>Kartu</span>
                            </button>
                        </div>

                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm leading-4">
                            <span>Ajukan Luaran PkM</span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- 1. Tab Bar Kategori Luaran -->
                <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm overflow-x-auto">
                    <div class="flex items-center gap-1.5 min-w-max">
                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'semua'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Semua Luaran</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['semua'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'publikasi'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'publikasi' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Publikasi Pengabdian</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'publikasi' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['publikasi'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'ttg'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'ttg' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Teknologi TTG</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'ttg' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['ttg'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'modul'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'modul' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Modul & SOP Mitra</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'modul' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['modul'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'hki'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'hki' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Hak Cipta / HKI</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'hki' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['hki'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.luaran', array_merge(request()->except('kategori'), ['kategori' => 'desa_binaan'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'desa_binaan' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Dampak Desa Binaan</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'desa_binaan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['desa_binaan'] }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. Filter Bar: Prodi, Tahun & Pencarian -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <form method="GET" action="{{ route('pengabdian.luaran') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                        <input type="hidden" name="kategori" value="{{ $activeTab }}">

                        <!-- Filter Program Studi -->
                        <div class="lg:col-span-4 space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Program Studi</label>
                            <select name="prodi" onchange="this.form.submit()" class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs leading-4">
                                <option value="semua">Semua Program Studi</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->kode_prodi }}" {{ request('prodi') == $p->kode_prodi ? 'selected' : '' }}>
                                        {{ $p->kode_prodi }} - {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun Anggaran -->
                        <div class="lg:col-span-3 space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Tahun Capaian</label>
                            <select name="tahun" onchange="this.form.submit()" class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs leading-4">
                                <option value="semua">Semua Tahun</option>
                                @foreach($availableYears as $yr)
                                    <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>
                                        Tahun {{ $yr }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pencarian Kata Kunci -->
                        <div class="lg:col-span-5 space-y-1.5">
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Cari Judul / Pelaksana / Mitra / Dampak</label>
                            <div class="flex gap-2">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci luaran..." 
                                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                                <button type="submit" 
                                        class="h-11 px-5 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition-all shadow-sm flex items-center gap-1.5 leading-4 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Cari</span>
                                </button>
                                @if(request()->hasAny(['prodi', 'tahun', 'q']) || $activeTab !== 'semua')
                                    <a href="{{ route('pengabdian.luaran') }}" 
                                       class="h-11 px-4 border border-slate-300 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 flex items-center justify-center leading-4 flex-shrink-0"
                                       title="Reset Semua Filter">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 3. Daftar Luaran Tersusun per Tahun Anggaran -->
                <div class="space-y-10">
                    @forelse($outputsByYear as $year => $yearOutputs)
                        <div class="space-y-4">
                            
                            <!-- Header Tahun Anggaran -->
                            <div class="flex items-center justify-between border-b-2 border-[#0B2A59]/20 pb-3 flex-wrap gap-2">
                                <div class="flex items-center gap-3">
                                    <span class="px-3.5 py-1.5 rounded-xl bg-[#0B2A59] text-white font-extrabold text-sm leading-5 shadow-xs">
                                        Tahun Anggaran {{ $year }}
                                    </span>
                                    <span class="text-xs text-slate-500 font-medium">
                                        {{ $yearOutputs->count() }} Luaran Terdokumentasi
                                    </span>
                                </div>
                            </div>

                            <!-- Mode Tampilan: TABEL DATA -->
                            <div x-show="viewMode === 'table'" class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                                <th class="py-3.5 px-4 min-w-[280px]">Judul Luaran & Sasaran Mitra</th>
                                                <th class="py-3.5 px-4">Kategori</th>
                                                <th class="py-3.5 px-4">Prodi</th>
                                                <th class="py-3.5 px-4 min-w-[150px]">Tim Pelaksana</th>
                                                <th class="py-3.5 px-4 min-w-[200px]">Indikator Keberhasilan & Dampak</th>
                                                <th class="py-3.5 px-4 text-center">Kepuasan</th>
                                                <th class="py-3.5 px-4 text-center">Bukti Laporan</th>
                                                <th class="py-3.5 px-4 text-center">Rincian</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($yearOutputs as $idx => $item)
                                                <tr class="hover:bg-slate-50/80 transition-colors">
                                                    <td class="py-4 px-4 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                                                    <td class="py-4 px-4">
                                                        <div class="font-bold text-slate-900 leading-snug hover:text-[#0B2A59] transition-colors cursor-pointer"
                                                             @click="openDetail({{ json_encode($item) }})">
                                                            {{ $item->judul }}
                                                        </div>
                                                        @if($item->mitra_sasaran || $item->lokasi)
                                                            <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                                <span>{{ $item->mitra_sasaran ?? '-' }} ({{ $item->lokasi ?? '-' }})</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 whitespace-nowrap">
                                                        @php
                                                            $kategoriLabels = [
                                                                'publikasi' => 'Publikasi',
                                                                'ttg' => 'Teknologi TTG',
                                                                'modul' => 'Modul & SOP',
                                                                'hki' => 'Hak Cipta',
                                                                'desa_binaan' => 'Desa Binaan',
                                                            ];
                                                            $badgeClasses = [
                                                                'publikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                                'ttg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                                'modul' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                                'hki' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                                'desa_binaan' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                            ];
                                                        @endphp
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $badgeClasses[$item->kategori] ?? 'bg-slate-50 text-slate-700' }}">
                                                            {{ $kategoriLabels[$item->kategori] ?? ucfirst($item->kategori) }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4 whitespace-nowrap">
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                            {{ $item->prodi->kode_prodi }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4 text-slate-700">
                                                        <div class="font-medium text-slate-900">{{ $item->pelaksana }}</div>
                                                    </td>
                                                    <td class="py-4 px-4 text-slate-600">
                                                        <div class="leading-relaxed line-clamp-2" title="{{ $item->indikator_keberhasilan }}">
                                                            {{ $item->indikator_keberhasilan ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                                        @if($item->tingkat_kepuasan_mitra)
                                                            <span class="inline-block text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                                                {{ $item->tingkat_kepuasan_mitra }}
                                                            </span>
                                                        @else
                                                            <span class="text-slate-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                                        @if($item->berkas_luaran)
                                                            <a href="{{ route('pengabdian.luaran.unduh', $item) }}" 
                                                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors leading-4"
                                                               title="Unduh Berkas Bukti Laporan PDF">
                                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span>Unduh</span>
                                                            </a>
                                                        @elseif($item->link_dokumen)
                                                            <a href="{{ $item->link_dokumen }}" target="_blank" rel="noopener noreferrer"
                                                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition-colors leading-4">
                                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                                <span>Link</span>
                                                            </a>
                                                        @else
                                                            <span class="text-slate-400 text-[11px]">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                                        <button @click="openDetail({{ json_encode($item) }})" type="button"
                                                                class="h-8 px-2.5 rounded-lg text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-blue-100 transition-colors leading-4">
                                                            Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Mode Tampilan: KARTU RESPONSIF -->
                            <div x-show="viewMode === 'card'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($yearOutputs as $item)
                                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:border-blue-300 transition-all">
                                        <div class="space-y-3">
                                            <!-- Badges Header -->
                                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                    {{ $item->prodi->kode_prodi }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $badgeClasses[$item->kategori] ?? 'bg-slate-50 text-slate-700' }}">
                                                    {{ $kategoriLabels[$item->kategori] ?? ucfirst($item->kategori) }}
                                                </span>
                                            </div>

                                            <!-- Judul Luaran -->
                                            <h3 class="text-sm font-bold text-slate-900 leading-snug hover:text-[#0B2A59] transition-colors cursor-pointer"
                                                @click="openDetail({{ json_encode($item) }})">
                                                {{ $item->judul }}
                                            </h3>

                                            <!-- Sasaran & Lokasi -->
                                            @if($item->mitra_sasaran || $item->lokasi)
                                                <div class="text-xs text-slate-600 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    <span class="font-medium">{{ $item->mitra_sasaran ?? '-' }} ({{ $item->lokasi ?? '-' }})</span>
                                                </div>
                                            @endif

                                            <!-- Indikator Dampak -->
                                            @if($item->indikator_keberhasilan)
                                                <div class="text-xs text-slate-600 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                                    <strong class="text-slate-800 block text-[11px] mb-0.5">Indikator Keberhasilan:</strong>
                                                    <span>{{ $item->indikator_keberhasilan }}</span>
                                                </div>
                                            @endif

                                            <!-- Pelaksana -->
                                            <div class="text-xs text-slate-500 pt-1">
                                                Pelaksana: <span class="font-medium text-slate-800">{{ $item->pelaksana }}</span>
                                            </div>
                                        </div>

                                        <!-- Footer Kartu: Kepuasan & Tombol Aksi -->
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                            <div>
                                                @if($item->tingkat_kepuasan_mitra)
                                                    <span class="text-[10px] text-slate-400 block leading-3">Kepuasan</span>
                                                    <span class="font-bold text-emerald-700 text-xs leading-4">
                                                        {{ $item->tingkat_kepuasan_mitra }}
                                                    </span>
                                                @else
                                                    <span class="text-[10px] text-slate-400">Tahun {{ $item->tahun }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @if($item->berkas_luaran)
                                                    <a href="{{ route('pengabdian.luaran.unduh', $item) }}" 
                                                       class="h-9 px-3 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors flex items-center gap-1 leading-4"
                                                       title="Unduh Berkas Bukti PDF">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                        <span>PDF</span>
                                                    </a>
                                                @endif
                                                <button @click="openDetail({{ json_encode($item) }})" type="button"
                                                        class="h-9 px-3 rounded-lg text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-blue-100 transition-colors leading-4">
                                                    Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @empty
                        <!-- Empty State Jika Filter Kosong -->
                        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center max-w-lg mx-auto space-y-4 shadow-sm">
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-[#0B2A59] mx-auto flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-base font-bold text-slate-800 leading-6">Tidak Ada Data Luaran Pengabdian</h3>
                                <p class="text-xs text-slate-500 leading-5">
                                    Tidak ditemukan luaran pengabdian yang sesuai dengan kriteria kategori, program studi, atau kata kunci pencarian Anda.
                                </p>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('pengabdian.luaran') }}" class="inline-flex items-center gap-2 h-10 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all leading-4">
                                    <span>Reset Semua Filter</span>
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

    </main>

    <!-- Modal Detail Hasil Analisis Luaran PkM -->
    <div x-show="detailModalOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="detailModalOpen = false"></div>

        <!-- Panel Modal -->
        <div class="relative bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl z-10 overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
                <div class="space-y-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200"
                              x-text="selectedOutput?.prodi?.kode_prodi"></span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-[#0B2A59] border border-blue-200"
                              x-text="'Tahun Anggaran ' + selectedOutput?.tahun"></span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 capitalize"
                              x-text="selectedOutput?.kategori?.replace('_', ' ')"></span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] leading-snug pt-1" x-text="selectedOutput?.judul"></h3>
                </div>
                <button @click="detailModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="space-y-4 text-xs">
                
                <!-- Deskripsi Manfaat & Evaluasi Hasil -->
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 space-y-1.5">
                    <h4 class="font-bold text-[#0B2A59] text-xs leading-4">Deskripsi Manfaat & Evaluasi Hasil Pengabdian</h4>
                    <p class="text-slate-600 leading-relaxed text-justify" x-text="selectedOutput?.deskripsi_manfaat || 'Informasi deskripsi manfaat pengabdian ini tercatat lengkap pada dokumen pendukung.'"></p>
                </div>

                <!-- Indikator Keberhasilan -->
                <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 space-y-1.5">
                    <h4 class="font-bold text-emerald-900 text-xs leading-4">Indikator Keberhasilan Capaian</h4>
                    <p class="text-emerald-800 font-medium leading-relaxed" x-text="selectedOutput?.indikator_keberhasilan || '-'"></p>
                </div>

                <!-- Detail Grid Informasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Tim Pelaksana / Author</span>
                        <span class="font-semibold text-slate-800 text-xs leading-4" x-text="selectedOutput?.pelaksana"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Tingkat Kepuasan Mitra</span>
                        <span class="font-bold text-emerald-700 text-xs leading-4" x-text="selectedOutput?.tingkat_kepuasan_mitra || '-'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Mitra Sasaran</span>
                        <span class="text-slate-700 text-xs leading-4" x-text="selectedOutput?.mitra_sasaran || '-'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Wilayah / Lokasi</span>
                        <span class="text-slate-700 text-xs leading-4" x-text="selectedOutput?.lokasi || '-'"></span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <template x-if="selectedOutput?.berkas_luaran">
                        <a :href="'/pengabdian/luaran/' + selectedOutput?.id + '/unduh'" 
                           class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-xs leading-4">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh Berkas Bukti (PDF)</span>
                        </a>
                    </template>
                    <template x-if="selectedOutput?.link_dokumen">
                        <a :href="selectedOutput?.link_dokumen" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-all leading-4">
                            <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Tautan Eksternal</span>
                        </a>
                    </template>
                </div>

                <button @click="detailModalOpen = false" type="button" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 leading-4">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>
@endsection
