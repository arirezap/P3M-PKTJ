@extends('layouts.public')

@section('title', 'Kegiatan Penelitian Terapan - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori kegiatan penelitian terapan dosen dan taruna P3M Politeknik Keselamatan Transportasi Jalan Tegal tersusun per tahun berdasarkan sumber dana (DIPA Kemenhub, Kemdiktisaintek, Industri, Mandiri).')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedResearch: null,
    openDetail(item) {
        this.selectedResearch = item;
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
                        <li class="font-semibold text-[#0B2A59]">Kegiatan Penelitian</li>
                    </ol>
                </nav>

                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span>Tridharma Perguruan Tinggi Vokasi Kemenhub</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B2A59] tracking-tight leading-tight">
                        Kegiatan & Rekapitulasi Penelitian Terapan
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Basis data portofolio riset terapan dosen dan taruna Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal yang diklasifikasikan berdasarkan sumber pendanaan, tersusun kronologis per tahun anggaran pada 3 Program Studi di lingkungan PKTJ.
                    </p>
                </div>

                <!-- 4 Kartu Metrik Ringkasan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                    <!-- Kartu 1: Total Judul Riset -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider leading-4">Total Riset</span>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0B2A59] flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-9">
                            {{ $totalRiset }} <span class="text-xs font-medium text-slate-500">Judul</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Terdaftar dalam repositori riset P3M</p>
                    </div>

                    <!-- Kartu 2: Akumulasi Dana Riset -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider leading-4">Total Realisasi Dana</span>
                            <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight leading-8 truncate" title="Rp {{ number_format($totalDana, 0, ',', '.') }}">
                            Rp {{ number_format($totalDana / 1000000, 1, ',', '.') }} <span class="text-xs font-medium text-slate-500">Jt</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">DIPA Kemenhub, Hibah & Mitra</p>
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
                            Rp {{ number_format($avgDana / 1000000, 1, ',', '.') }} <span class="text-xs font-medium text-slate-500">Jt / Riset</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">Rata-rata alokasi dana per judul</p>
                    </div>

                    <!-- Kartu 4: 3 Program Studi PKTJ -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">3 Program Studi</span>
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1">
                            @foreach($prodiStats as $ps)
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 border border-blue-200 text-[#0B2A59] font-bold text-[10px] leading-4" title="{{ $ps['nama'] }}: {{ $ps['total_riset'] }} riset">
                                    {{ $ps['kode'] }} ({{ $ps['total_riset'] }})
                                </span>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-slate-500 leading-4">D4 RSTJ, D4 TRO, D3 TO</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bagian Visual: Tampilan Statistik Grafik & Proporsi Riset -->
        <section class="py-12 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4 mb-2">
                            <span>Visualisasi Statistik Capaian</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Grafik Tren Penelitian & Serapan Sumber Dana
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Distribusi kuantitas riset dan serapan dana per tahun pada 3 Program Studi PKTJ.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Kolom Kiri: Visual Bar Chart Capaian per Tahun (SVG Native Responsive) -->
                    <div class="lg:col-span-8 bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                            <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Kuantitas Riset per Tahun Anggaran</h3>
                            <div class="flex items-center gap-3 text-xs text-slate-600">
                                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-[#0B2A59]"></span> DIPA PKTJ/Kemenhub</span>
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
                                            <span class="text-slate-500 font-normal">({{ $stat['total_riset'] }} Kegiatan Riset)</span>
                                        </div>
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($stat['total_dana'], 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Stacked Progress Bar Multi-Kelipatan 4px -->
                                    <div class="w-full h-7 bg-white border border-slate-200 rounded-xl overflow-hidden flex shadow-xs">
                                        @php
                                            $total = max(1, $stat['total_riset']);
                                            $dipaPct = ($stat['dipa'] / $total) * 100;
                                            $kemdikPct = ($stat['kemdiktisaintek'] / $total) * 100;
                                            $industriPct = ($stat['industri'] / $total) * 100;
                                            $mandiriPct = ($stat['mandiri'] / $total) * 100;
                                        @endphp
                                        
                                        @if($stat['dipa'] > 0)
                                            <div style="width: {{ $dipaPct }}%" class="h-full bg-[#0B2A59] text-white text-[10px] font-bold flex items-center justify-center transition-all" title="DIPA Kemenhub: {{ $stat['dipa'] }} riset">
                                                {{ $stat['dipa'] }}
                                            </div>
                                        @endif
                                        @if($stat['kemdiktisaintek'] > 0)
                                            <div style="width: {{ $kemdikPct }}%" class="h-full bg-yellow-500 text-slate-900 text-[10px] font-bold flex items-center justify-center transition-all" title="Kemdiktisaintek: {{ $stat['kemdiktisaintek'] }} riset">
                                                {{ $stat['kemdiktisaintek'] }}
                                            </div>
                                        @endif
                                        @if($stat['industri'] > 0)
                                            <div style="width: {{ $industriPct }}%" class="h-full bg-emerald-600 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Mitra Industri: {{ $stat['industri'] }} riset">
                                                {{ $stat['industri'] }}
                                            </div>
                                        @endif
                                        @if($stat['mandiri'] > 0)
                                            <div style="width: {{ $mandiriPct }}%" class="h-full bg-slate-400 text-white text-[10px] font-bold flex items-center justify-center transition-all" title="Mandiri: {{ $stat['mandiri'] }} riset">
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
                            <h3 class="text-base font-bold text-[#0B2A59] leading-6">Serapan Riset 3 Program Studi</h3>
                            <p class="text-xs text-slate-500 mt-0.5 leading-4">Proporsi kegiatan riset vokasi PKTJ.</p>
                        </div>

                        <div class="space-y-4">
                            @foreach($prodiStats as $ps)
                                @php
                                    $prodiPct = $totalRiset > 0 ? ($ps['total_riset'] / $totalRiset) * 100 : 0;
                                @endphp
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-bold text-[#0B2A59] text-sm leading-5">{{ $ps['kode'] }}</span>
                                            <p class="text-[11px] text-slate-500 leading-4">{{ $ps['nama'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-extrabold text-slate-900 text-sm leading-5">{{ $ps['total_riset'] }} Riset</span>
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

        <!-- Daftar Kegiatan Penelitian Berdasarkan Sumber Dana & Tersusun per Tahun -->
        <section class="py-12 sm:py-16 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            Daftar Portofolio Kegiatan Penelitian
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                            Menampilkan {{ $researches->count() }} kegiatan penelitian terapan yang memenuhi kriteria filter.
                        </p>
                    </div>

                    @auth
                        @if(auth()->user()->isDosen())
                            <a href="{{ route('dosen.proposals.create') }}" class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm leading-4 self-start sm:self-auto">
                                <span>Ajukan Usulan Penelitian</span>
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- 1. Tab Bar Sumber Dana (Berdasarkan Sumber Dana Sesuai Mandat) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm overflow-x-auto">
                    <div class="flex items-center gap-1.5 min-w-max">
                        <a href="{{ route('riset.penelitian', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'semua'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Semua Sumber Dana</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['semua'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.penelitian', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'dipa'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'dipa' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>DIPA PKTJ / Kemenhub</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'dipa' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['dipa'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.penelitian', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'kemdiktisaintek'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'kemdiktisaintek' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Kemdiktisaintek / Nasional</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'kemdiktisaintek' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['kemdiktisaintek'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.penelitian', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'industri'])) }}"
                           class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold leading-4 transition-all {{ $activeTab === 'industri' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <span>Mitra Industri / Eksternal</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'industri' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $tabCounts['industri'] }}
                            </span>
                        </a>

                        <a href="{{ route('riset.penelitian', array_merge(request()->except('sumber_dana'), ['sumber_dana' => 'mandiri'])) }}"
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
                    <form method="GET" action="{{ route('riset.penelitian') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
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
                            <label class="block text-xs font-semibold text-slate-700 leading-4">Cari Judul / Nama Peneliti</label>
                            <div class="flex gap-2">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci riset..." 
                                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                                <button type="submit" 
                                        class="h-11 px-5 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition-all shadow-sm flex items-center gap-1.5 leading-4 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Cari</span>
                                </button>
                                @if(request()->hasAny(['prodi', 'tahun', 'q']) || $activeTab !== 'semua')
                                    <a href="{{ route('riset.penelitian') }}" 
                                       class="h-11 px-4 border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-semibold rounded-xl flex items-center leading-4 flex-shrink-0">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 3. Tabel Data Penelitian: Tersusun per Tahun Anggaran -->
                @forelse($researchesByYear as $tahun => $itemsInYear)
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm space-y-0">
                        <!-- Header Tahun Anggaran -->
                        <div class="bg-gradient-to-r from-blue-50/80 via-slate-50 to-white px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                    {{ substr($tahun, 2) }}
                                </span>
                                <div>
                                    <h3 class="text-base font-bold text-[#0B2A59] leading-6">Tahun Anggaran {{ $tahun }}</h3>
                                    <p class="text-xs text-slate-500 leading-4">Tersusun sebanyak {{ $itemsInYear->count() }} kegiatan penelitian terapan</p>
                                </div>
                            </div>
                            <div class="text-xs font-semibold text-slate-700 bg-white border border-slate-200 px-3 py-1.5 rounded-xl shadow-2xs">
                                Total Alokasi: <span class="font-bold text-[#0B2A59]">Rp {{ number_format($itemsInYear->sum('anggaran'), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Tabel Penelitian Dalam Tahun Terkait -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-50/60 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider leading-4">
                                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                                        <th class="py-3.5 px-4 min-w-[280px]">Judul Penelitian & Abstrak</th>
                                        <th class="py-3.5 px-4 w-28 text-center">Prodi</th>
                                        <th class="py-3.5 px-4 min-w-[180px]">Tim Peneliti</th>
                                        <th class="py-3.5 px-4 min-w-[140px]">Sumber Dana</th>
                                        <th class="py-3.5 px-4 min-w-[120px]">Anggaran</th>
                                        <th class="py-3.5 px-4 w-28 text-center">Data Pendukung</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($itemsInYear as $idx => $r)
                                        <tr class="hover:bg-slate-50/70 transition-colors">
                                            <td class="py-4 px-4 text-center font-semibold text-slate-400">
                                                {{ $idx + 1 }}
                                            </td>

                                            <!-- Judul & Cuplikan Abstrak -->
                                            <td class="py-4 px-4">
                                                <div class="space-y-1">
                                                    <h4 class="font-bold text-slate-900 leading-5 text-sm hover:text-[#0B2A59] cursor-pointer"
                                                        @click="openDetail({{ json_encode($r) }})">
                                                        {{ $r->judul }}
                                                    </h4>
                                                    @if($r->abstrak)
                                                        <p class="text-slate-500 text-[11px] leading-4 line-clamp-2">
                                                            {{ $r->abstrak }}
                                                        </p>
                                                    @endif
                                                    <div class="flex items-center gap-2 pt-0.5">
                                                        <span class="text-[10px] text-slate-400 font-mono">Skema: {{ $r->skema ?? 'Penelitian Terapan' }}</span>
                                                        <span class="text-slate-300">•</span>
                                                        <span class="inline-flex items-center text-[10px] font-semibold {{ $r->status === 'Selesai' ? 'text-emerald-700' : 'text-blue-700' }}">
                                                            {{ $r->status }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Badge Program Studi -->
                                            <td class="py-4 px-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider leading-3 bg-blue-50 text-[#0B2A59] border border-blue-200">
                                                    {{ $r->prodi->kode_prodi }}
                                                </span>
                                            </td>

                                            <!-- Tim Peneliti -->
                                            <td class="py-4 px-4">
                                                <div class="space-y-0.5">
                                                    <div class="font-bold text-slate-900 leading-4">{{ $r->ketua_peneliti }}</div>
                                                    <div class="text-[11px] text-slate-400 leading-4">Ketua Peneliti</div>
                                                    @if($r->anggota)
                                                        <div class="text-[11px] text-slate-600 pt-1 leading-4">
                                                            <span class="text-slate-400">Anggota:</span> {{ $r->anggota }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Sumber Dana -->
                                            <td class="py-4 px-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold leading-4 {{ str_contains(strtolower($r->sumber_dana), 'dipa') || str_contains(strtolower($r->sumber_dana), 'internal') ? 'bg-blue-100 text-[#0B2A59]' : (str_contains(strtolower($r->sumber_dana), 'kemdik') ? 'bg-yellow-100 text-yellow-900' : (str_contains(strtolower($r->sumber_dana), 'industri') ? 'bg-emerald-100 text-emerald-900' : 'bg-slate-100 text-slate-700')) }}">
                                                    {{ $r->sumber_dana }}
                                                </span>
                                            </td>

                                            <!-- Nominal Anggaran -->
                                            <td class="py-4 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                                Rp {{ number_format($r->anggaran, 0, ',', '.') }}
                                            </td>

                                            <!-- Aksi & Data Pendukung -->
                                            <td class="py-4 px-4 text-center">
                                                <div class="inline-flex flex-col gap-1 items-center">
                                                    <button type="button" @click="openDetail({{ json_encode($r) }})"
                                                            class="inline-flex items-center gap-1 h-8 px-3 rounded-lg text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-blue-100 transition-colors leading-4">
                                                        <span>Detail</span>
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>

                                                    @if($r->berkas_laporan)
                                                        <a href="{{ route('riset.penelitian.unduh', $r) }}" 
                                                           class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 hover:underline leading-3"
                                                           title="Unduh Berkas Laporan PDF">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            <span>PDF</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0B2A59] flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 leading-6">Tidak Ada Data Penelitian yang Sesuai</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-5">
                            Silakan coba sesuaikan kata kunci pencarian, ubah filter program studi, atau pilih tab kategori sumber dana lainnya.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('riset.penelitian') }}" class="inline-flex items-center h-10 px-5 rounded-xl text-xs font-semibold text-[#0B2A59] bg-blue-50 hover:bg-blue-100 transition-colors leading-4">
                                Tampilkan Semua Data
                            </a>
                        </div>
                    </div>
                @endforelse

            </div>
        </section>

    </main>

    <!-- Modal Detail Interaktif Penelitian -->
    <div x-show="detailModalOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="detailModalOpen = false" 
             class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6">
            
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0B2A59] border border-blue-200"
                          x-text="selectedResearch?.prodi?.kode_prodi + ' • Tahun ' + selectedResearch?.tahun">
                    </span>
                    <h3 class="text-base sm:text-lg font-bold text-[#0B2A59] leading-6" x-text="selectedResearch?.judul"></h3>
                </div>
                <button @click="detailModalOpen = false" type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Rincian Informasi Riset -->
            <div class="space-y-4 text-xs">
                <!-- Tim Peneliti -->
                <div class="bg-slate-50 rounded-2xl p-4 space-y-2 border border-slate-100">
                    <div>
                        <span class="text-slate-400 block text-[11px] leading-4">Ketua Peneliti:</span>
                        <span class="font-bold text-slate-900 text-sm leading-5" x-text="selectedResearch?.ketua_peneliti"></span>
                    </div>
                    <template x-if="selectedResearch?.anggota">
                        <div class="border-t border-slate-200/60 pt-2">
                            <span class="text-slate-400 block text-[11px] leading-4">Anggota Peneliti (Dosen / Taruna):</span>
                            <span class="font-medium text-slate-700 leading-5" x-text="selectedResearch?.anggota"></span>
                        </div>
                    </template>
                </div>

                <!-- Skema, Sumber Dana & Anggaran -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Sumber Pendanaan:</span>
                        <span class="font-bold text-[#0B2A59] text-xs leading-5 mt-1 block" x-text="selectedResearch?.sumber_dana"></span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[11px] leading-3">Skema Hibah:</span>
                        <span class="font-semibold text-slate-800 text-xs leading-5 mt-1 block" x-text="selectedResearch?.skema || 'Penelitian Terapan'"></span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 col-span-2 sm:col-span-1">
                        <span class="text-slate-400 block text-[11px] leading-3">Total Anggaran:</span>
                        <span class="font-bold text-emerald-700 text-xs leading-5 mt-1 block" 
                              x-text="'Rp ' + Number(selectedResearch?.anggaran || 0).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <!-- Abstrak / Ringkasan Eksekutif -->
                <div>
                    <h4 class="font-bold text-slate-800 mb-1 leading-4">Abstrak / Ringkasan Penelitian:</h4>
                    <p class="text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs" 
                       x-text="selectedResearch?.abstrak || 'Ringkasan penelitian belum diunggah untuk kegiatan riset ini.'">
                    </p>
                </div>
            </div>

            <!-- Footer Modal & Tombol Unduh -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
                <span class="text-slate-400">Status: <strong class="text-slate-800" x-text="selectedResearch?.status"></strong></span>
                
                <div class="flex items-center gap-2">
                    <button @click="detailModalOpen = false" type="button" class="h-10 px-4 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 font-semibold leading-4">
                        Tutup
                    </button>
                    <template x-if="selectedResearch?.berkas_laporan">
                        <a :href="'{{ url('riset/penelitian') }}/' + selectedResearch?.id + '/unduh'"
                           class="inline-flex items-center gap-1.5 h-10 px-5 rounded-xl font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Laporan PDF</span>
                        </a>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Institusi Kemenhub -->
</div>
@endsection
