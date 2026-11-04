@extends('layouts.public')

@section('title', 'Standar Operasional Prosedur (SOP) - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Pusat unduhan berkas Standar Operasional Prosedur (SOP) P3M PKTJ dengan pemisahan tegas antara SOP Bidang Penelitian dan SOP Bidang Pengabdian kepada Masyarakat.')

@section('content')
<div x-data="{ 
    previewModalOpen: false, 
    activeDoc: null,
    activeTab: 'semua',
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
                    <li class="font-semibold text-[#0B2A59]">Standar Operasional Prosedur (SOP)</li>
                </ol>
            </nav>

            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100/70 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                    <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Layanan Tata Kelola & Mutu Tridharma</span>
                </div>
                
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">
                    Standar Operasional Prosedur (SOP)
                </h1>
                
                <p class="text-sm sm:text-base text-slate-600 leading-6 max-w-2xl">
                    Kumpulan berkas Standar Operasional Prosedur tata kelola Tridharma di lingkungan Politeknik Keselamatan Transportasi Jalan, dipisahkan secara tegas antara tata laksana bidang penelitian dan pengabdian kepada masyarakat.
                </p>
            </div>

            <!-- Ringkasan Statistik Metrik Spasial Kelipatan 4px -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-slate-200">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider leading-4">SOP Penelitian</div>
                    <div class="text-2xl font-black text-[#0B2A59] mt-1 leading-8">{{ $stats['total_penelitian'] }}</div>
                    <div class="text-[11px] text-slate-400 mt-1 leading-4">Prosedur Riset DIPA & Mandiri</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider leading-4">SOP Pengabdian</div>
                    <div class="text-2xl font-black text-emerald-700 mt-1 leading-8">{{ $stats['total_pengabdian'] }}</div>
                    <div class="text-[11px] text-slate-400 mt-1 leading-4">Prosedur Kemitraan & PkM</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider leading-4">Total Berkas SOP</div>
                    <div class="text-2xl font-black text-slate-700 mt-1 leading-8">{{ $stats['total_sop'] }}</div>
                    <div class="text-[11px] text-slate-400 mt-1 leading-4">Dokumen Mutu Aktif</div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider leading-4">Total Unduhan</div>
                    <div class="text-2xl font-black text-amber-600 mt-1 leading-8">{{ number_format($stats['total_unduhan'], 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-400 mt-1 leading-4">Akses Berkas Digital</div>
                </div>
            </div>

        </div>
    </section>

    <!-- Konten Utama: Filter Kategori & Pencarian -->
    <section class="py-12 bg-slate-50/60 min-h-[500px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Panel Navigasi Tab & Form Pencarian -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-2xs space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    
                    <!-- Tab Pemisah Baku (Penelitian vs Pengabdian) -->
                    <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl">
                        <button type="button" 
                                @click="activeTab = 'semua'"
                                :class="activeTab === 'semua' ? 'bg-[#0B2A59] text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-4 py-2 text-xs font-bold rounded-lg transition-colors leading-4">
                            Semua SOP ({{ $sopPenelitian->count() + $sopPengabdian->count() }})
                        </button>
                        <button type="button" 
                                @click="activeTab = 'penelitian'"
                                :class="activeTab === 'penelitian' ? 'bg-[#0B2A59] text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-4 py-2 text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5 leading-4">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                            <span>SOP Bidang Penelitian ({{ $sopPenelitian->count() }})</span>
                        </button>
                        <button type="button" 
                                @click="activeTab = 'pengabdian'"
                                :class="activeTab === 'pengabdian' ? 'bg-emerald-700 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-4 py-2 text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5 leading-4">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>SOP Bidang Pengabdian ({{ $sopPengabdian->count() }})</span>
                        </button>
                    </div>

                    <!-- Pencarian Kata Kunci -->
                    <form action="{{ route('layanan.sop') }}" method="GET" class="relative max-w-xs w-full">
                        <input type="text" 
                               name="q" 
                               value="{{ $searchQuery }}" 
                               placeholder="Cari judul atau nomor SOP..." 
                               class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-300 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        @if(!empty($searchQuery))
                            <a href="{{ route('layanan.sop') }}" class="absolute right-3 top-2.5 text-xs text-slate-400 hover:text-slate-600 leading-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </form>

                </div>

                @if(!empty($searchQuery))
                    <div class="text-xs text-slate-500 pt-2 border-t border-slate-100 leading-4">
                        Menampilkan hasil pencarian untuk: <span class="font-bold text-[#0B2A59]">"{{ $searchQuery }}"</span>
                    </div>
                @endif
            </div>

            <!-- BAGIAN 1: SOP BIDANG PENELITIAN -->
            <div x-show="activeTab === 'semua' || activeTab === 'penelitian'" class="space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-[#0B2A59]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#0B2A59] leading-6">SOP Bidang Penelitian</h2>
                            <p class="text-xs text-slate-500 leading-4">Prosedur baku tahapan usulan riset, penilaian reviewer, monev, dan laporan akhir</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 leading-4">{{ $sopPenelitian->count() }} Dokumen</span>
                </div>

                @if($sopPenelitian->isEmpty())
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-xs text-slate-500 leading-5">
                        Tidak ada berkas SOP Bidang Penelitian yang sesuai dengan kriteria pencarian.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($sopPenelitian as $doc)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-[#0B2A59] border border-blue-200 leading-3">
                                            SOP Penelitian
                                        </span>
                                        <span class="text-[11px] font-semibold text-slate-400 leading-4">
                                            {{ $doc->tahun ?: 'Tahun ' . date('Y') }}
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-[#0B2A59] hover:text-blue-900 leading-5">
                                        {{ $doc->judul }}
                                    </h3>
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-5">
                                        {{ $doc->deskripsi ?: 'Standar operasional prosedur pelaksanaan kegiatan penelitian terapan vokasi di lingkungan Politeknik Keselamatan Transportasi Jalan.' }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                                    <div class="flex items-center gap-3 text-slate-400 text-[11px] leading-4">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            <span>{{ $doc->file_size ?: 'PDF' }}</span>
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>{{ $doc->download_count }}x diunduh</span>
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                @click="openPreview({
                                                    id: '{{ $doc->id }}',
                                                    judul: '{{ addslashes($doc->judul) }}',
                                                    kategori: 'SOP Bidang Penelitian',
                                                    deskripsi: '{{ addslashes($doc->deskripsi ?: 'Standar operasional prosedur pelaksanaan kegiatan penelitian terapan vokasi di lingkungan Politeknik Keselamatan Transportasi Jalan.') }}',
                                                    tahun: '{{ $doc->tahun ?: date('Y') }}',
                                                    file_size: '{{ $doc->file_size ?: 'PDF' }}',
                                                    download_url: '{{ route('layanan.panduan-pedoman.unduh', $doc->id) }}'
                                                })"
                                                class="px-3 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs transition-colors leading-4">
                                            Pratinjau
                                        </button>
                                        <a href="{{ route('layanan.panduan-pedoman.unduh', $doc->id) }}" 
                                           class="px-3.5 py-2 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white font-semibold text-xs inline-flex items-center gap-1.5 transition-colors leading-4">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>Unduh PDF</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- BAGIAN 2: SOP BIDANG PENGABDIAN KEPADA MASYARAKAT -->
            <div x-show="activeTab === 'semua' || activeTab === 'pengabdian'" class="space-y-4 pt-6">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#0B2A59] leading-6">SOP Bidang Pengabdian kepada Masyarakat</h2>
                            <p class="text-xs text-slate-500 leading-4">Prosedur baku pendampingan kemitraan, verifikasi desa binaan, monev lapang, dan pertanggungjawaban</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 leading-4">{{ $sopPengabdian->count() }} Dokumen</span>
                </div>

                @if($sopPengabdian->isEmpty())
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-xs text-slate-500 leading-5">
                        Tidak ada berkas SOP Bidang Pengabdian kepada Masyarakat yang sesuai dengan kriteria pencarian.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($sopPengabdian as $doc)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 leading-3">
                                            SOP Pengabdian (PkM)
                                        </span>
                                        <span class="text-[11px] font-semibold text-slate-400 leading-4">
                                            {{ $doc->tahun ?: 'Tahun ' . date('Y') }}
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-[#0B2A59] hover:text-emerald-900 leading-5">
                                        {{ $doc->judul }}
                                    </h3>
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-5">
                                        {{ $doc->deskripsi ?: 'Standar operasional prosedur pelaksanaan pengabdian kepada masyarakat, transfer teknologi, dan pendampingan mitra keselamatan transportasi jalan.' }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                                    <div class="flex items-center gap-3 text-slate-400 text-[11px] leading-4">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            <span>{{ $doc->file_size ?: 'PDF' }}</span>
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>{{ $doc->download_count }}x diunduh</span>
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                @click="openPreview({
                                                    id: '{{ $doc->id }}',
                                                    judul: '{{ addslashes($doc->judul) }}',
                                                    kategori: 'SOP Bidang Pengabdian (PkM)',
                                                    deskripsi: '{{ addslashes($doc->deskripsi ?: 'Standar operasional prosedur pelaksanaan pengabdian kepada masyarakat, transfer teknologi, dan pendampingan mitra keselamatan transportasi jalan.') }}',
                                                    tahun: '{{ $doc->tahun ?: date('Y') }}',
                                                    file_size: '{{ $doc->file_size ?: 'PDF' }}',
                                                    download_url: '{{ route('layanan.panduan-pedoman.unduh', $doc->id) }}'
                                                })"
                                                class="px-3 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs transition-colors leading-4">
                                            Pratinjau
                                        </button>
                                        <a href="{{ route('layanan.panduan-pedoman.unduh', $doc->id) }}" 
                                           class="px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs inline-flex items-center gap-1.5 transition-colors leading-4">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>Unduh PDF</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- Modal Pratinjau Interaktif Dokumen SOP (Alpine.js) -->
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 text-xs text-slate-600 border-t border-b border-slate-100 py-4 leading-5">
                    <p class="font-medium text-slate-700" x-text="activeDoc ? activeDoc.deskripsi : ''"></p>
                    
                    <div class="grid grid-cols-2 gap-2 pt-2 text-[11px] text-slate-500 leading-4">
                        <div>
                            <span class="text-slate-400 block">Tahun Penerapan:</span>
                            <span class="font-semibold text-slate-700" x-text="activeDoc ? activeDoc.tahun : '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Format & Ukuran Berkas:</span>
                            <span class="font-semibold text-slate-700" x-text="activeDoc ? activeDoc.file_size : 'PDF'"></span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" 
                            @click="previewModalOpen = false"
                            class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs transition-colors leading-4">
                        Tutup
                    </button>
                    <a :href="activeDoc ? activeDoc.download_url : '#'" 
                       class="px-5 py-2.5 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white font-semibold text-xs inline-flex items-center gap-2 shadow-xs transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Unduh Dokumen PDF</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

</main>
</div>
@endsection

