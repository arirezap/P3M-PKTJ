@extends('layouts.public')

@section('title', 'Sumber Daya Manusia & Struktur Organisasi - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Struktur organisasi dan susunan sumber daya manusia Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan Tegal.')

@section('content')
<div x-data="{ imageModalOpen: false }">
<main class="flex-1">

        <!-- Hero Section Header -->
        <section class="bg-gradient-to-b from-blue-50/70 via-slate-50/40 to-white py-12 sm:py-16 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="mb-6">
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
                            <span class="text-slate-400">Profil</span>
                        </li>
                        <li>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                        <li class="font-semibold text-[#0B2A59]">Sumber Daya Manusia</li>
                    </ol>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span>Tata Kelola Kelembagaan Vokasi Kemenhub</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B2A59] tracking-tight leading-tight">
                            {{ $settings['org_title'] ?? 'Struktur Organisasi & Sumber Daya Manusia P3M' }}
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-3xl">
                            {{ $settings['org_lead_text'] ?? 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan.' }}
                        </p>
                    </div>

                    <!-- Institutional Info Box -->
                    <div class="lg:col-span-4">
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center text-[#0B2A59]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-bold text-yellow-600 uppercase tracking-wider leading-3">Legalitas Organisasi</span>
                                    <h3 class="text-xs font-bold text-slate-900 leading-4">SK Direktur PKTJ</h3>
                                </div>
                            </div>
                            <div class="space-y-2 text-xs">
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Nomor Surat Keputusan:</span>
                                    <span class="font-semibold text-slate-800 leading-4 font-mono">{{ $settings['org_sk_number'] ?? 'SK Direktur PKTJ' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Masa Bakti Kepengurusan:</span>
                                    <span class="font-semibold text-[#0B2A59] leading-4">{{ $settings['org_period'] ?? '2026 – 2031' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Jumlah Personil Aktif:</span>
                                    <span class="font-bold text-emerald-700 leading-4">{{ $members->count() }} Pejabat & Pengurus</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bagian Visual: Bagan Struktur Organisasi -->
        <section class="py-12 sm:py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4 mb-2">
                            <span>Diagram Garis Komando & Koordinasi</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">Bagan Struktur Organisasi P3M</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">Hierarki kepengurusan dan alur koordinasi fungsional kelembagaan P3M PKTJ.</p>
                    </div>

                    @if(!empty($settings['org_chart_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['org_chart_image']))
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <button @click="imageModalOpen = true" type="button"
                                    class="inline-flex items-center gap-2 h-11 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                <span>Perbesar Gambar</span>
                            </button>
                            <a href="{{ asset('storage/' . $settings['org_chart_image']) }}" download="Bagan_Struktur_Organisasi_P3M_PKTJ"
                               class="inline-flex items-center gap-2 h-11 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Bagan</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Wadah Bagan Visual Gambar / Skema Interaktif -->
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-4 sm:p-8 shadow-sm">
                    @if(!empty($settings['org_chart_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['org_chart_image']))
                        <div class="relative group cursor-pointer overflow-hidden rounded-2xl bg-white border border-slate-200" @click="imageModalOpen = true">
                            <img src="{{ asset('storage/' . $settings['org_chart_image']) }}" 
                                 alt="Bagan Struktur Organisasi P3M PKTJ" 
                                 class="w-full h-auto max-h-[600px] object-contain mx-auto transition-transform duration-300 group-hover:scale-[1.01]">
                            <div class="absolute inset-0 bg-[#0B2A59]/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-4 py-2 rounded-xl bg-[#0B2A59] text-white text-xs font-semibold shadow-md flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                    <span>Klik untuk memperbesar tampilan bagan</span>
                                </span>
                            </div>
                        </div>
                    @else
                        <!-- Skema Bagan Visual Hirarki Fungsional (Tree View Standar) -->
                        <div class="max-w-4xl mx-auto py-6 space-y-8">
                            
                            <!-- Tingkat 1: Pengarah / Direktur PKTJ -->
                            <div class="flex flex-col items-center">
                                <div class="bg-[#0B2A59] text-white border-2 border-yellow-400 rounded-2xl p-5 shadow-md w-full max-w-md text-center space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-300">Pelindung & Pengarah Institusional</span>
                                    <h3 class="text-base font-bold text-white leading-6">Direktur PKTJ</h3>
                                    @if($p = $pengarah->firstWhere('urutan', 1) ?? $pengarah->first())
                                        <p class="text-xs text-blue-200 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                                <div class="w-0.5 h-6 bg-slate-300"></div>
                            </div>

                            <!-- Tingkat 2: Penanggung Jawab Akademik & Riset (Wadir I) -->
                            <div class="flex flex-col items-center">
                                <div class="bg-white border-2 border-[#0B2A59] rounded-2xl p-4 shadow-sm w-full max-w-md text-center space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700">Penanggung Jawab Akademik</span>
                                    <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Wakil Direktur I Bidang Akademik</h3>
                                    @if($p = $pengarah->firstWhere('urutan', 2) ?? $pengarah->skip(1)->first())
                                        <p class="text-xs text-slate-500 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                                <div class="w-0.5 h-6 bg-slate-300"></div>
                            </div>

                            <!-- Tingkat 3: Pimpinan Inti P3M -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto relative">
                                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-center space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#0B2A59]">Pimpinan Satuan Kerja</span>
                                    <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Kepala Pusat P3M</h3>
                                    @if($p = $pimpinan->firstWhere('urutan', 3) ?? $pimpinan->first())
                                        <p class="text-xs text-slate-600 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-center space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#0B2A59]">Ketatausahaan & Keuangan</span>
                                    <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Sekretaris P3M</h3>
                                    @if($p = $pimpinan->firstWhere('urutan', 4) ?? $pimpinan->skip(1)->first())
                                        <p class="text-xs text-slate-600 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="w-0.5 h-6 bg-slate-300"></div>
                            </div>

                            <!-- Tingkat 4: 3 Koordinator Bidang Strategis -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center space-y-1 shadow-xs">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Bidang Penelitian</span>
                                    <h3 class="text-xs font-bold text-slate-900 leading-4">Koordinator Penelitian & Hilirisasi</h3>
                                    @if($p = $koordinator->firstWhere('urutan', 5) ?? $koordinator->first())
                                        <p class="text-xs text-slate-500 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                                <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center space-y-1 shadow-xs">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Bidang Pengabdian</span>
                                    <h3 class="text-xs font-bold text-slate-900 leading-4">Koordinator Pengabdian Masyarakat</h3>
                                    @if($p = $koordinator->firstWhere('urutan', 6) ?? $koordinator->skip(1)->first())
                                        <p class="text-xs text-slate-500 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                                <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center space-y-1 shadow-xs">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-purple-600">Sentra HKI & Publikasi</span>
                                    <h3 class="text-xs font-bold text-slate-900 leading-4">Koordinator HKI & Jurnal Ilmiah</h3>
                                    @if($p = $koordinator->firstWhere('urutan', 7) ?? $koordinator->skip(2)->first())
                                        <p class="text-xs text-slate-500 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="w-0.5 h-6 bg-slate-300"></div>
                            </div>

                            <!-- Tingkat 5: Staf Administrasi & Pengelola SIM P3M -->
                            <div class="flex flex-col items-center">
                                <div class="bg-slate-100 border border-slate-200 rounded-2xl p-3 w-full max-w-md text-center space-y-0.5">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Unit Pendukung Teknis</span>
                                    <h3 class="text-xs font-bold text-slate-800 leading-4">Staf Administrasi & Pengelola SIM P3M</h3>
                                    @if($p = $staf->firstWhere('urutan', 8) ?? $staf->first())
                                        <p class="text-xs text-slate-500 leading-4">{{ $p->nama }}</p>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- Direktori Anggota & Personil Struktural Berdasarkan Hierarki -->
        <section class="py-12 sm:py-16 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="text-center max-w-3xl mx-auto space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/70 text-[#0B2A59] text-xs font-semibold leading-4">
                        <span>Susunan Personil & Penugasan</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">
                        Daftar Pengurus & Pejabat Struktur Organisasi
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Tenaga pendidik dan fungsional yang bertugas mengawal mutu penelitian, pengabdian masyarakat, serta hilirisasi teknologi keselamatan transportasi di PKTJ.
                    </p>
                </div>

                <!-- Bagian A: Pimpinan & Pengarah Institusional -->
                @if($pengarah->isNotEmpty() || $pimpinan->isNotEmpty())
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                            <span class="w-3 h-3 rounded-full bg-[#0B2A59]"></span>
                            <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Pengarah & Pimpinan Satuan Kerja P3M</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($pengarah->concat($pimpinan) as $personil)
                                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-4">
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-4">
                                            @if($personil->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($personil->foto))
                                                <img src="{{ asset('storage/' . $personil->foto) }}" alt="{{ $personil->nama }}"
                                                     class="w-14 h-14 rounded-2xl object-cover border border-slate-200 flex-shrink-0 shadow-xs">
                                            @else
                                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#0B2A59] to-blue-800 text-white font-bold text-base flex items-center justify-center flex-shrink-0 shadow-xs">
                                                    {{ strtoupper(substr($personil->nama, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold leading-4 {{ str_contains(strtolower($personil->jabatan), 'pengarah') || str_contains(strtolower($personil->jabatan), 'direktur') ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-[#0B2A59]' }}">
                                                    {{ $personil->jabatan }}
                                                </span>
                                                <h4 class="text-sm font-bold text-slate-900 mt-1 leading-5">{{ $personil->nama }}</h4>
                                                @if($personil->nip_nidn)
                                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $personil->nip_nidn }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if($personil->deskripsi_tugas)
                                            <p class="text-xs text-slate-600 leading-5 border-t border-slate-100 pt-3">
                                                {{ $personil->deskripsi_tugas }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="pt-2 text-[11px] text-slate-400 font-medium">
                                        Urutan Hierarki #{{ $personil->urutan }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Bagian B: Koordinator Bidang Strategis & Sentra HKI -->
                @if($koordinator->isNotEmpty())
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                            <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Koordinator Bidang Teknis & Sentra HKI</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($koordinator as $personil)
                                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-4">
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-4">
                                            @if($personil->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($personil->foto))
                                                <img src="{{ asset('storage/' . $personil->foto) }}" alt="{{ $personil->nama }}"
                                                     class="w-14 h-14 rounded-2xl object-cover border border-slate-200 flex-shrink-0 shadow-xs">
                                            @else
                                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 text-white font-bold text-base flex items-center justify-center flex-shrink-0 shadow-xs">
                                                    {{ strtoupper(substr($personil->nama, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-800 leading-4">
                                                    {{ $personil->jabatan }}
                                                </span>
                                                <h4 class="text-sm font-bold text-slate-900 mt-1 leading-5">{{ $personil->nama }}</h4>
                                                @if($personil->nip_nidn)
                                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $personil->nip_nidn }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if($personil->deskripsi_tugas)
                                            <p class="text-xs text-slate-600 leading-5 border-t border-slate-100 pt-3">
                                                {{ $personil->deskripsi_tugas }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="pt-2 text-[11px] text-slate-400 font-medium">
                                        Urutan Hierarki #{{ $personil->urutan }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Bagian C: Staf Pendukung & Pengelola SIM P3M -->
                @if($staf->isNotEmpty())
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                            <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                            <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Staf Administrasi & Pengelola SIM P3M</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($staf as $personil)
                                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-4">
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-4">
                                            @if($personil->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($personil->foto))
                                                <img src="{{ asset('storage/' . $personil->foto) }}" alt="{{ $personil->nama }}"
                                                     class="w-14 h-14 rounded-2xl object-cover border border-slate-200 flex-shrink-0 shadow-xs">
                                            @else
                                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-[#0B2A59] font-bold text-base flex items-center justify-center flex-shrink-0 border border-slate-200">
                                                    {{ strtoupper(substr($personil->nama, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700 leading-4">
                                                    {{ $personil->jabatan }}
                                                </span>
                                                <h4 class="text-sm font-bold text-slate-900 mt-1 leading-5">{{ $personil->nama }}</h4>
                                                @if($personil->nip_nidn)
                                                    <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $personil->nip_nidn }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if($personil->deskripsi_tugas)
                                            <p class="text-xs text-slate-600 leading-5 border-t border-slate-100 pt-3">
                                                {{ $personil->deskripsi_tugas }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="pt-2 text-[11px] text-slate-400 font-medium">
                                        Urutan Hierarki #{{ $personil->urutan }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </section>

        <!-- Informasi Tugas Pokok & Fungsi Inti (Tupoksi P3M) -->
        <section class="py-12 sm:py-16 bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                
                <div class="text-center max-w-3xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider leading-4">Standar Tata Kerja</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#0B2A59] tracking-tight leading-8">Tugas Pokok & Wewenang Kelembagaan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">P3M PKTJ menjalankan 4 pilar fungsional tridharma perguruan tinggi bidang keselamatan transportasi jalan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Pilar 1 -->
                    <div class="p-6 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-sm">
                            01
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Penelitian Terapan Vokasi</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Mengkoordinasikan, memfasilitasi, dan mereviu penelitian dosen serta taruna pada 3 Program Studi (D4 RSTJ, D4 TRO, D3 TO).
                        </p>
                    </div>

                    <!-- Pilar 2 -->
                    <div class="p-6 rounded-2xl bg-yellow-50/60 border border-yellow-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-yellow-500 text-slate-900 flex items-center justify-center font-bold text-sm">
                            02
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-5">Pengabdian Berbasis Aksi</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Menyelenggarakan aksi nyata keselamatan berkendara, pembinaan desa rukun lalu lintas, dan standardisasi kelaikan kendaraan.
                        </p>
                    </div>

                    <!-- Pilar 3 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center font-bold text-sm">
                            03
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-5">Sentra HKI & Publikasi</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Memfasilitasi pendaftaran Hak Cipta, Paten inovasi otomotif, serta pengelolaan Indonesian Road Safety Journal terindeks SINTA.
                        </p>
                    </div>

                    <!-- Pilar 4 -->
                    <div class="p-6 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-sm">
                            04
                        </div>
                        <h3 class="text-sm font-bold text-[#0B2A59] leading-5">Akuntabilitas & Tata Kelola</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Menjamin transparansi alokasi dana DIPA, monitoring kemajuan proposal, dan pelaporan capaian kinerja penelitian terpadu.
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Modal Lightbox Bagan Organisasi -->
    @if(!empty($settings['org_chart_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['org_chart_image']))
        <div x-show="imageModalOpen" x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click.away="imageModalOpen = false" 
                 class="relative bg-white rounded-3xl max-w-5xl w-full p-4 sm:p-6 shadow-2xl border border-slate-200 space-y-4">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-[#0B2A59] leading-6">{{ $settings['org_title'] ?? 'Bagan Struktur Organisasi P3M PKTJ' }}</h3>
                        <p class="text-xs text-slate-500 leading-4">Masa Bakti: {{ $settings['org_period'] ?? '2026 – 2031' }}</p>
                    </div>
                    <button @click="imageModalOpen = false" type="button" 
                            class="w-9 h-9 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="overflow-auto max-h-[80vh] flex items-center justify-center bg-slate-50 rounded-2xl p-2">
                    <img src="{{ asset('storage/' . $settings['org_chart_image']) }}" 
                         alt="Bagan Struktur Organisasi P3M PKTJ" 
                         class="max-w-full h-auto rounded-xl">
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                    <span class="text-slate-500 font-mono">{{ $settings['org_sk_number'] ?? '' }}</span>
                    <a href="{{ asset('storage/' . $settings['org_chart_image']) }}" download="Bagan_Struktur_Organisasi_P3M_PKTJ"
                       class="inline-flex items-center gap-1.5 h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh Berkas Gambar</span>
                    </a>
                </div>

            </div>
        </div>
    @endif

    <!-- Footer Institusi Kemenhub -->
</div>
@endsection
