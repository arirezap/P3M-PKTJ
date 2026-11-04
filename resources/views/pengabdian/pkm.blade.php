@extends('layouts.public')

@section('title', 'Pengabdian Kepada Masyarakat - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori kegiatan pengabdian kepada masyarakat (PkM) dosen dan taruna P3M Politeknik Keselamatan Transportasi Jalan Tegal tersusun per tahun berdasarkan sumber dana (DIPA PKTJ, Kemdiktisaintek, Mitra Industri, Mandiri).')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedService: null,
    viewMode: 'table',
    openDetail(item) {
        this.selectedService = item;
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
                        <li class="font-semibold text-[#0B2A59]">Pengabdian Kepada Masyarakat</li>
                    </ol>
                </nav>

                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                        <span class="w-2 h-2 rounded-full bg-[#C5A55D]"></span>
                        <span>Tridharma Perguruan Tinggi Vokasi Kemenhub</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B2A59] tracking-tight leading-tight">
                        Pengabdian Kepada Masyarakat
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Portofolio aksi nyata pengabdian vokasi sivitas akademika Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal berbasis kemitraan desa binaan, sekolah ramah anak, standardisasi bengkel rakyat, dan edukasi keselamatan transportasi darat, tersusun per tahun anggaran berdasarkan klasifikasi sumber pendanaan.
                    </p>
                </div>

                <!-- 4 Kartu Metrik Ringkasan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                    <!-- Kartu 1: Total Kegiatan PkM -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-4">Total Kegiatan</span>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0B2A59] flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-9">
                            {{ $totalKegiatan }} <span class="text-xs font-medium text-slate-500">Kegiatan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Terdaftar dalam repositori PkM P3M</p>
                    </div>

                    <!-- Kartu 2: Akumulasi Dana PkM -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider leading-4">Total Alokasi Dana</span>
                            <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-8 truncate" title="Rp {{ number_format($totalDana, 0, ',', '.') }}">
                            Rp {{ number_format($totalDana / 1000000, 1, ',', '.') }} <span class="text-xs font-medium text-slate-500">Jt</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">DIPA PKTJ, Kemdiktisaintek, Industri & Mandiri</p>
                    </div>

                    <!-- Kartu 3: Rata-Rata Anggaran -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-4">Rata-Rata Anggaran</span>
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-8 truncate">
                            Rp {{ number_format($avgDana / 1000000, 1, ',', '.') }} <span class="text-xs font-medium text-slate-500">Jt / Kegiatan</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Rata-rata alokasi dana per kegiatan</p>
                    </div>

                    <!-- Kartu 4: Mitra & Lokasi Sasaran -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">Mitra & Wilayah Sasaran</span>
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-8">
                            {{ $totalMitra }} <span class="text-xs font-medium text-slate-500">Mitra / {{ $totalLokasi }} Lokasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Desa binaan, sekolah & bengkel UMKM</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bagian Visual: Tampilan Statistik Grafik & Proporsi PkM -->
        <section class="py-12 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4 mb-2">
                            <span>Visualisasi Statistik Capaian</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Grafik Tren Pengabdian & Serapan Sumber Dana
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Distribusi kuantitas kegiatan PkM dan serapan dana per tahun pada 3 Program Studi PKTJ.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Kolom Kiri: Visual Bar Chart Capaian per Tahun -->
                    <div class="lg:col-span-8 bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-4 flex-wrap gap-3">
                            <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Kuantitas PkM per Tahun Anggaran</h3>
                            <div class="flex items-center gap-3 text-xs text-slate-600 flex-wrap">
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#0B2A59]"></span> DIPA PKTJ</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-yellow-500"></span> Kemdiktisaintek</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-600"></span> Mitra Industri</span>
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-slate-400"></span> Mandiri</span>
                            </div>
                        </div>

                        <!-- Bar Chart Container -->
                        <div class="space-y-6 pt-2">
                            @forelse($yearlyStats as $stat)
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                                        <div class="flex items-center gap-2">
                                            <span class="w-12 font-bold text-[#0B2A59] text-sm leading-5">{{ $stat['tahun'] }}</span>
                                            <span class="text-slate-500 font-normal">({{ $stat['total_kegiatan'] }} Kegiatan PkM)</span>
                                        </div>
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($stat['total_dana'], 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Stacked Progress Bar Multi-Kelipatan 4px -->
                                    <div class="w-full h-7 bg-white border border-slate-200 rounded-xl overflow-hidden flex shadow-xs">
                                        @php
                                            $total = max(1, $stat['total_kegiatan']);
                                            $dipaPct = ($stat['dipa'] / $total) * 100;
                                            $kemdikPct = ($stat['kemdiktisaintek'] / $total) * 100;
                                            $industriPct = ($stat['industri'] / $total) * 100;
                                            $mandiriPct = ($stat['mandiri'] / $total) * 100;
                                        @endphp
                                        
                                        @if($stat['dipa'] > 0)
                                            <div style="width: {{ $dipaPct }}%" class="h-full bg-[#0B2A59] text-white text-[10px] font-bold flex items-center justify-center transition-all" title="DIPA PKTJ: {{ $stat['dipa'] }} kegiatan">
                                                {{ $stat['dipa'] }}
                                            </div>
                                        @endif
                                        @if($stat['kemdiktisaintek'] > 0)
                                            <div style="width: {{ $kemdikPct }}%" class="h-full bg-yellow-500 text-slate-900 text-[10px] font-bold flex items-center justify-center transition-all" title="Kemdiktisaintek: {{ $stat['kemdiktisaintek'] }} kegiatan">
                                                {{ $stat['kemdiktisaintek'] }}
                                            </div>
                                        @endif
                                        @if($stat['industri'] > 0)
                                            <div style="width: {{ $industriPct }}%" class="h-full bg-emerald-600 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Mitra Industri: {{ $stat['industri'] }} kegiatan">
                                                {{ $stat['industri'] }}
                                            </div>
                                        @endif
                                        @if($stat['mandiri'] > 0)
                                            <div style="width: {{ $mandiriPct }}%" class="h-full bg-slate-400 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Mandiri: {{ $stat['mandiri'] }} kegiatan">
                                                {{ $stat['mandiri'] }}
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

                    <!-- Kolom Kanan: Distribusi Anggaran 3 Program Studi -->
                    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                        <div class="border-b border-slate-100 pb-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Distribusi Keilmuan</span>
                            <h3 class="text-base font-bold text-[#0B2A59] leading-6">Capaian 3 Program Studi</h3>
                            <p class="text-xs text-slate-500 mt-0.5 leading-4">Proporsi kegiatan pengabdian masyarakat PKTJ.</p>
                        </div>

                        <div class="space-y-4">
                            @foreach($prodiStats as $ps)
                                @php
                                    $prodiPct = $totalKegiatan > 0 ? ($ps['total_kegiatan'] / $totalKegiatan) * 100 : 0;
                                @endphp
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-bold text-[#0B2A59] text-sm leading-5">{{ $ps['kode'] }}</span>
                                            <p class="text-[11px] text-slate-500 leading-4">{{ $ps['nama'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-extrabold text-slate-900 text-sm leading-5">{{ $ps['total_kegiatan'] }} Kegiatan</span>
                                            <p class="text-[11px] font-semibold text-emerald-700 leading-4">Rp {{ number_format($ps['total_dana'] / 1000000, 1, ',', '.') }} Jt</p>
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

        <!-- Daftar Kegiatan Pengabdian Berdasarkan Sumber Dana & Tersusun per Tahun -->
        <section class="py-12 sm:py-16 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Daftar Portofolio Pengabdian Masyarakat
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Menampilkan {{ $services->count() }} kegiatan pengabdian yang memenuhi kriteria filter.
                        </p>
                    </div>

                    <!-- Tombol Panduan / SIM P3M & Toggle View -->
                    <div class="flex items-center gap-3">
                        <!-- Toggle View Mode: Tabel vs Kartu -->
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

                        @auth
                            @if(auth()->user()->isDosen())
                                <a href="{{ route('dosen.proposals.create') }}" class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm leading-4">
                                    <span>Ajukan Usulan PkM</span>
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- 1. Tab Bar Sumber Dana (Berdasarkan Sumber Dana Sesuai Mandat) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm overflow-x-auto">
                    <div class="flex items-center gap-1.5 min-w-max">
                        <a href="{{ route('pengabdian.pkm', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'semua'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Semua Sumber Dana</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['semua'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.pkm', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'dipa'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'dipa' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>DIPA PKTJ / Internal</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'dipa' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['dipa'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.pkm', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'kemdiktisaintek'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'kemdiktisaintek' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Kemdiktisaintek / DRTPM</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'kemdiktisaintek' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['kemdiktisaintek'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.pkm', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'industri'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'industri' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Mitra Industri / CSR</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'industri' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['industri'] }}
                            </span>
                        </a>

                        <a href="{{ route('pengabdian.pkm', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'mandiri'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'mandiri' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Mandiri / Swadana</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'mandiri' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['mandiri'] }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- 2. Filter Bar: Tahun, Prodi & Pencarian -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <form method="GET" action="{{ route('pengabdian.pkm') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                        <input type="hidden" name="sumber_dana" value="{{ $activeTab }}">

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
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Tahun Anggaran</label>
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
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Cari Judul / Pelaksana / Lokasi / Mitra</label>
                            <div class="flex gap-2">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci pengabdian..." 
                                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                                <button type="submit" 
                                        class="h-11 px-5 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition-all shadow-sm flex items-center gap-1.5 leading-4 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Cari</span>
                                </button>
                                @if(request()->hasAny(['prodi', 'tahun', 'q']) || $activeTab !== 'semua')
                                    <a href="{{ route('pengabdian.pkm') }}" 
                                       class="h-11 px-4 border border-slate-300 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 flex items-center justify-center leading-4 flex-shrink-0"
                                       title="Reset Semua Filter">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 3. Daftar Kegiatan Tersusun per Tahun Anggaran (Grouping per Tahun) -->
                <div class="space-y-10">
                    @forelse($servicesByYear as $year => $yearServices)
                        <div class="space-y-4">
                            
                            <!-- Header Tahun Anggaran -->
                            <div class="flex items-center justify-between border-b-2 border-[#0B2A59]/20 pb-3 flex-wrap gap-2">
                                <div class="flex items-center gap-3">
                                    <span class="px-3.5 py-1.5 rounded-xl bg-[#0B2A59] text-white font-extrabold text-sm leading-5 shadow-xs">
                                        Tahun Anggaran {{ $year }}
                                    </span>
                                    <span class="text-xs text-slate-500 font-medium">
                                        {{ $yearServices->count() }} Kegiatan Terlaksana
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-700">
                                    Total Alokasi: <span class="font-bold text-[#0B2A59]">Rp {{ number_format($yearServices->sum('anggaran'), 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Mode Tampilan: TABEL DATA -->
                            <div x-show="viewMode === 'table'" class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                                <th class="py-3.5 px-4 min-w-[280px]">Judul Kegiatan & Lokasi Sasaran</th>
                                                <th class="py-3.5 px-4">Prodi</th>
                                                <th class="py-3.5 px-4 min-w-[160px]">Ketua & Tim Pelaksana</th>
                                                <th class="py-3.5 px-4 min-w-[150px]">Mitra Kerjasama</th>
                                                <th class="py-3.5 px-4">Sumber Dana</th>
                                                <th class="py-3.5 px-4 text-right">Anggaran</th>
                                                <th class="py-3.5 px-4 text-center">Berkas Laporan</th>
                                                <th class="py-3.5 px-4 text-center">Rincian</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($yearServices as $idx => $item)
                                                <tr class="hover:bg-slate-50/80 transition-colors">
                                                    <td class="py-4 px-4 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                                                    <td class="py-4 px-4">
                                                        <div class="font-bold text-slate-900 leading-snug hover:text-[#0B2A59] transition-colors cursor-pointer"
                                                             @click="openDetail({{ json_encode($item) }})">
                                                            {{ $item->judul }}
                                                        </div>
                                                        @if($item->lokasi_kegiatan)
                                                            <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                                <span>{{ $item->lokasi_kegiatan }}</span>
                                                            </div>
                                                        @endif
                                                        @if($item->skema)
                                                            <div class="text-[10px] text-slate-400 mt-0.5">
                                                                Skema: {{ $item->skema }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 whitespace-nowrap">
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                            {{ $item->prodi->kode_prodi }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4 text-slate-700">
                                                        <div class="font-medium text-slate-900">{{ $item->ketua_pelaksana }}</div>
                                                        @if($item->anggota)
                                                            <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1" title="{{ $item->anggota }}">{{ $item->anggota }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="py-4 px-4 text-slate-600">
                                                        <span class="leading-5">{{ $item->mitra ?? '-' }}</span>
                                                    </td>
                                                    <td class="py-4 px-4 whitespace-nowrap">
                                                        @php
                                                            $sourceLower = strtolower($item->sumber_dana);
                                                            $badgeClass = 'bg-slate-100 text-slate-800 border-slate-200';
                                                            if (str_contains($sourceLower, 'dipa') || str_contains($sourceLower, 'internal')) {
                                                                $badgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                                                            } elseif (str_contains($sourceLower, 'kemdik') || str_contains($sourceLower, 'drtpm')) {
                                                                $badgeClass = 'bg-yellow-50 text-yellow-800 border-yellow-200';
                                                            } elseif (str_contains($sourceLower, 'industri') || str_contains($sourceLower, 'mitra') || str_contains($sourceLower, 'csr')) {
                                                                $badgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                                            }
                                                        @endphp
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold border {{ $badgeClass }}">
                                                            {{ $item->sumber_dana }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4 text-right whitespace-nowrap font-bold text-slate-900">
                                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                                    </td>
                                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                                        @if($item->berkas_laporan)
                                                            <a href="{{ route('pengabdian.pkm.unduh', $item) }}" 
                                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors leading-4"
                                                               title="Unduh Berkas Laporan Pengabdian PDF">
                                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <span>Unduh PDF</span>
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

                            <!-- Mode Tampilan: KARTU RESPONSIF (Touch-Friendly & Mobile/Tablet) -->
                            <div x-show="viewMode === 'card'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($yearServices as $item)
                                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:border-blue-300 transition-all">
                                        <div class="space-y-3">
                                            <!-- Badges Header -->
                                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                    {{ $item->prodi->kode_prodi }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                                    {{ $item->sumber_dana }}
                                                </span>
                                            </div>

                                            <!-- Judul Kegiatan -->
                                            <h3 class="text-sm font-bold text-slate-900 leading-snug hover:text-[#0B2A59] transition-colors cursor-pointer"
                                                @click="openDetail({{ json_encode($item) }})">
                                                {{ $item->judul }}
                                            </h3>

                                            <!-- Lokasi Sasaran -->
                                            @if($item->lokasi_kegiatan)
                                                <div class="text-xs text-slate-600 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    <span class="font-medium">{{ $item->lokasi_kegiatan }}</span>
                                                </div>
                                            @endif

                                            <!-- Pelaksana & Mitra -->
                                            <div class="text-xs space-y-1 text-slate-600 pt-1 border-t border-slate-100">
                                                <div>Pelaksana: <strong class="text-slate-800">{{ $item->ketua_pelaksana }}</strong></div>
                                                @if($item->mitra)
                                                    <div>Mitra: <span class="text-slate-700">{{ $item->mitra }}</span></div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Footer Kartu: Anggaran & Tombol Aksi -->
                                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                            <div>
                                                <span class="text-[10px] text-slate-400 block leading-3">Anggaran</span>
                                                <span class="font-extrabold text-[#0B2A59] text-xs leading-4">
                                                    Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @if($item->berkas_laporan)
                                                    <a href="{{ route('pengabdian.pkm.unduh', $item) }}" 
                                                       class="h-9 px-3 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors flex items-center gap-1 leading-4"
                                                       title="Unduh Berkas PDF">
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
                                <h3 class="text-base font-bold text-slate-800 leading-6">Tidak Ada Data Kegiatan Pengabdian</h3>
                                <p class="text-xs text-slate-500 leading-5">
                                    Tidak ditemukan kegiatan pengabdian masyarakat yang sesuai dengan kriteria filter sumber dana, program studi, atau kata kunci pencarian Anda.
                                </p>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('pengabdian.pkm') }}" class="inline-flex items-center gap-2 h-10 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all leading-4">
                                    <span>Reset Semua Filter</span>
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

    </main>

    <!-- Modal Detail Kegiatan Pengabdian Masyarakat -->
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
                              x-text="selectedService?.prodi?.kode_prodi"></span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-[#0B2A59] border border-blue-200"
                              x-text="'Tahun Anggaran ' + selectedService?.tahun"></span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700"
                              x-text="selectedService?.sumber_dana"></span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] leading-snug pt-1" x-text="selectedService?.judul"></h3>
                </div>
                <button @click="detailModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="space-y-4 text-xs">
                
                <!-- Ringkasan Manfaat & Dampak -->
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 space-y-1.5">
                    <h4 class="font-bold text-[#0B2A59] text-xs leading-4">Ringkasan Kegiatan & Manfaat bagi Masyarakat</h4>
                    <p class="text-slate-600 leading-relaxed text-justify" x-text="selectedService?.ringkasan || 'Informasi ringkasan manfaat aksi nyata pengabdian ini tercatat dalam laporan akhir.'"></p>
                </div>

                <!-- Detail Grid Informasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Ketua Pelaksana</span>
                        <span class="font-semibold text-slate-800 text-xs leading-4" x-text="selectedService?.ketua_pelaksana"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Anggota Tim</span>
                        <span class="text-slate-700 text-xs leading-4" x-text="selectedService?.anggota || '-'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Lokasi Sasaran / Desa Binaan</span>
                        <span class="font-medium text-slate-800 text-xs leading-4" x-text="selectedService?.lokasi_kegiatan || '-'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Mitra Kerjasama</span>
                        <span class="text-slate-700 text-xs leading-4" x-text="selectedService?.mitra || '-'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Skema Pengabdian</span>
                        <span class="text-slate-700 text-xs leading-4" x-text="selectedService?.skema || 'PkM Kemitraan'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 block text-[11px] leading-4">Alokasi Anggaran</span>
                        <span class="font-bold text-[#0B2A59] text-xs leading-4" x-text="'Rp ' + (new Intl.NumberFormat('id-ID').format(selectedService?.anggaran || 0))"></span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3 flex-wrap">
                <template x-if="selectedService?.berkas_laporan">
                    <a :href="'/pengabdian/pkm/' + selectedService?.id + '/unduh'" 
                       class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-xs leading-4">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Berkas Laporan Lengkap (PDF)</span>
                    </a>
                </template>
                <template x-if="!selectedService?.berkas_laporan">
                    <span class="text-slate-400 text-xs italic">Berkas laporan PDF belum tersedia untuk publikasi.</span>
                </template>

                <button @click="detailModalOpen = false" type="button" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 leading-4">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>
@endsection
