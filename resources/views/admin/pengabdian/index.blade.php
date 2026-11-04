@extends('layouts.admin')

@section('title', 'Manajemen Pengabdian kepada Masyarakat')
@section('breadcrumb', 'Pengabdian / Usulan & Pemantauan Progres')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul Pengabdian kepada Masyarakat -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold leading-4">
                <span>Modul SIM P3M • Bidang Pengabdian kepada Masyarakat</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-[#0B2A59] mt-2 leading-7 sm:leading-8">
                Manajemen Usulan & Progres Pengabdian kepada Masyarakat (PkM)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-3xl leading-5">
                Kelola usulan PkM dosen berbasis kemitraan desa binaan dan bengkel rakyat, tugaskan reviewer, dan pantau seluruh siklus progres mulai dari *submission* hingga *archive*.
            </p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($stats['butuh_reviewer'] > 0)
                <span class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 leading-4">
                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                    <span>{{ $stats['butuh_reviewer'] }} Usulan PkM Perlu Reviewer</span>
                </span>
            @else
                <span class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 leading-4">
                    <span>Semua Reviewer Terpenuhi</span>
                </span>
            @endif
        </div>
    </div>

    <!-- 4 MENU UTAMA MEJA KERJA PENGABDIAN MASYARAKAT (SESUAI DOKUMEN ACUAN PDF HALAMAN 3-4) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-xs">
        <nav class="flex space-x-2 overflow-x-auto text-xs font-semibold">
            <a href="{{ route('admin.pengabdian.index', array_merge(request()->except('tab', 'page'), ['tab' => 'masuk'])) }}"
               class="inline-flex items-center gap-2 px-4 py-3 rounded-xl transition-colors whitespace-nowrap {{ $selectedTab === 'masuk' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Daftar Proposal dan Laporan Masuk</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedTab === 'masuk' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $tabCounts['masuk'] }}
                </span>
            </a>

            <a href="{{ route('admin.pengabdian.index', array_merge(request()->except('tab', 'page'), ['tab' => 'belum_ditugaskan'])) }}"
               class="inline-flex items-center gap-2 px-4 py-3 rounded-xl transition-colors whitespace-nowrap {{ $selectedTab === 'belum_ditugaskan' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Belum Ditugaskan</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedTab === 'belum_ditugaskan' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }}">
                    {{ $tabCounts['belum_ditugaskan'] }}
                </span>
            </a>

            <a href="{{ route('admin.pengabdian.index', array_merge(request()->except('tab', 'page'), ['tab' => 'sedang_ditugaskan'])) }}"
               class="inline-flex items-center gap-2 px-4 py-3 rounded-xl transition-colors whitespace-nowrap {{ $selectedTab === 'sedang_ditugaskan' ? 'bg-purple-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Sedang Ditugaskan</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedTab === 'sedang_ditugaskan' ? 'bg-white/20 text-white' : 'bg-purple-100 text-purple-800' }}">
                    {{ $tabCounts['sedang_ditugaskan'] }}
                </span>
            </a>

            <a href="{{ route('admin.pengabdian.index', array_merge(request()->except('tab', 'page'), ['tab' => 'arsip'])) }}"
               class="inline-flex items-center gap-2 px-4 py-3 rounded-xl transition-colors whitespace-nowrap {{ $selectedTab === 'arsip' ? 'bg-slate-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Arsip Selesai</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedTab === 'arsip' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $tabCounts['arsip'] }}
                </span>
            </a>
        </nav>
    </div>

    <!-- PIPELINE INDIKATOR SIKLUS PKM (SUBMISSION S.D. ARCHIVE) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-4">Alur Tahapan Pengabdian Masyarakat</span>
            <span class="text-xs text-slate-500">Klik tab di bawah untuk menyaring data</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2">
            
            <a href="{{ route('admin.pengabdian.index') }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'semua' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-xs text-slate-400 font-medium">Semua</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'semua' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['total'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'diajukan']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'diajukan' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Submission</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'diajukan' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['submission'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'verifikasi_administrasi']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'verifikasi_administrasi' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Verifikasi</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'verifikasi_administrasi' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['verifikasi'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'sedang_direview']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'sedang_direview' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Review</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'sedang_direview' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['review'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'revisi']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'revisi' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Revisi</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'revisi' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['revisi'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'diterima']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'diterima' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Didanai</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'diterima' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['diterima'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'pelaksanaan']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'pelaksanaan' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Pelaksanaan</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'pelaksanaan' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['pelaksanaan'] }}</div>
            </a>

            <a href="{{ route('admin.pengabdian.index', ['status' => 'archive']) }}" 
               class="p-3 rounded-xl border text-center transition-colors leading-4 {{ $selectedStatus === 'archive' ? 'bg-[#0B2A59] text-white border-[#0B2A59]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                <div class="text-[11px] text-slate-400 font-medium">Archive</div>
                <div class="text-lg font-black mt-1 {{ $selectedStatus === 'archive' ? 'text-white' : 'text-[#0B2A59]' }}">{{ $stats['archive'] }}</div>
            </a>

        </div>
    </div>

    <!-- FILTER PENCARIAN & SELEKSI PRODI -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.pengabdian.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="hidden" name="tab" value="{{ $selectedTab }}">
            
            <!-- Filter Status Dropdown -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Status Tahapan</label>
                <select name="status" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua" {{ $selectedStatus === 'semua' ? 'selected' : '' }}>Semua Tahapan</option>
                    <option value="butuh_reviewer" {{ $selectedStatus === 'butuh_reviewer' ? 'selected' : '' }}>Perlu Reviewer Segera</option>
                    <option value="diajukan" {{ $selectedStatus === 'diajukan' ? 'selected' : '' }}>Submission (Baru Diajukan)</option>
                    <option value="verifikasi_administrasi" {{ $selectedStatus === 'verifikasi_administrasi' ? 'selected' : '' }}>Verifikasi Administrasi</option>
                    <option value="sedang_direview" {{ $selectedStatus === 'sedang_direview' ? 'selected' : '' }}>Sedang Dinilai Reviewer</option>
                    <option value="revisi" {{ $selectedStatus === 'revisi' ? 'selected' : '' }}>Perbaikan Revisi</option>
                    <option value="diterima" {{ $selectedStatus === 'diterima' ? 'selected' : '' }}>Didanai (Diterima)</option>
                    <option value="pelaksanaan" {{ $selectedStatus === 'pelaksanaan' ? 'selected' : '' }}>Pelaksanaan & Monev</option>
                    <option value="archive" {{ $selectedStatus === 'archive' ? 'selected' : '' }}>Archive (Arsip Selesai)</option>
                    <option value="ditolak" {{ $selectedStatus === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Filter 3 Program Studi PKTJ -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Program Studi</label>
                <select name="prodi" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua" {{ $selectedProdi === 'semua' ? 'selected' : '' }}>Semua Prodi</option>
                    @foreach($prodis as $p)
                        <option value="{{ $p->kode_prodi }}" {{ $selectedProdi == $p->kode_prodi ? 'selected' : '' }}>
                            {{ $p->jenjang }} {{ $p->kode_prodi }} - {{ $p->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tahun Anggaran -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Tahun Anggaran</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua" {{ $selectedYear === 'semua' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Cari Kata Kunci -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Judul / Kode / Pengusul</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Ketik kata kunci..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-[#0B2A59] text-white text-xs font-semibold rounded-lg hover:bg-blue-900 leading-4">Cari</button>
                    @if(request()->hasAny(['status', 'prodi', 'tahun', 'search']))
                        <a href="{{ route('admin.pengabdian.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>

        </form>
    </div>

    <!-- TABEL DATA USULAN & PENUGASAN REVIEWER PKM -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Kode & Judul PkM</th>
                        <th class="py-3.5 px-4">Ketua Pengusul & Prodi</th>
                        <th class="py-3.5 px-4">Tahun & Anggaran</th>
                        <th class="py-3.5 px-4">Status Progres</th>
                        <th class="py-3.5 px-4">Reviewer Ditugaskan</th>
                        <th class="py-3.5 px-4 text-right">Tindakan & Pengarsipan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($proposals as $prop)
                        @php
                            $statusBadge = match($prop->status) {
                                'diajukan' => 'bg-blue-100 text-blue-800',
                                'verifikasi_administrasi' => 'bg-indigo-100 text-indigo-800',
                                'sedang_direview' => 'bg-purple-100 text-purple-800',
                                'revisi' => 'bg-amber-100 text-amber-800',
                                'diterima' => 'bg-emerald-100 text-emerald-800',
                                'pelaksanaan' => 'bg-teal-100 text-teal-800',
                                'archive' => 'bg-slate-100 text-slate-800 border border-slate-300',
                                'ditolak' => 'bg-rose-100 text-rose-800',
                                default => 'bg-slate-100 text-slate-700',
                            };
                            $statusLabel = match($prop->status) {
                                'diajukan' => 'Submission Masuk',
                                'verifikasi_administrasi' => 'Lolos Berkas',
                                'sedang_direview' => 'Sedang Dinilai',
                                'revisi' => 'Perbaikan Revisi',
                                'diterima' => 'Didanai (Diterima)',
                                'pelaksanaan' => 'Pelaksanaan & Monev',
                                'archive' => 'Archive (Selesai)',
                                'ditolak' => 'Ditolak',
                                default => ucwords(str_replace('_', ' ', $prop->status)),
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            <!-- Kode & Judul PkM -->
                            <td class="py-3.5 px-4 max-w-sm">
                                <span class="font-bold text-[#0B2A59] block tracking-wide">{{ $prop->kode_usulan }}</span>
                                <div class="font-bold text-slate-900 leading-5 mt-1">{{ $prop->judul }}</div>
                                <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-2">
                                    <span>Skema: <strong>{{ $prop->skema }}</strong></span>
                                    <span>•</span>
                                    <span>Sumber: {{ $prop->sumber_dana }}</span>
                                </div>
                                <div class="mt-2.5 flex flex-wrap items-center gap-1.5 pt-2 border-t border-slate-100">
                                    @if($prop->file_proposal)
                                        <a href="{{ asset('storage/' . $prop->file_proposal) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-[#0B2A59] border border-blue-200 hover:bg-blue-100 transition-colors leading-4" title="Unduh Berkas Usulan Proposal PKM">
                                            <svg class="w-3 h-3 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>Proposal</span>
                                        </a>
                                    @endif
                                    @if($prop->file_revisi)
                                        <a href="{{ asset('storage/' . $prop->file_revisi) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition-colors leading-4" title="Unduh Berkas Revisi Proposal PKM">
                                            <svg class="w-3 h-3 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            <span>Revisi</span>
                                        </a>
                                    @endif
                                    @if($prop->monev && $prop->monev->file_laporan_kemajuan)
                                        <a href="{{ asset('storage/' . $prop->monev->file_laporan_kemajuan) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200 hover:bg-indigo-100 transition-colors leading-4" title="Unduh Berkas Monev Lapangan PKM">
                                            <svg class="w-3 h-3 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            <span>Monev</span>
                                        </a>
                                    @endif
                                    @if($prop->finalReport && $prop->finalReport->file_laporan_akhir)
                                        <a href="{{ asset('storage/' . $prop->finalReport->file_laporan_akhir) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition-colors leading-4" title="Unduh Berkas Laporan Akhir Kegiatan PKM">
                                            <svg class="w-3 h-3 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>Laporan Kegiatan</span>
                                        </a>
                                    @endif
                                    @if($prop->finalReport && $prop->finalReport->file_spj)
                                        <a href="{{ asset('storage/' . $prop->finalReport->file_spj) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-teal-50 text-teal-800 border border-teal-200 hover:bg-teal-100 transition-colors leading-4" title="Unduh Berkas SPJ 100%">
                                            <svg class="w-3 h-3 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            <span>SPJ</span>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Ketua & Prodi -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800 leading-4">{{ $prop->ketua->name }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">NIDN: {{ $prop->ketua->nidn_nip ?? '-' }}</div>
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $prop->prodi->kode_prodi }}
                                    </span>
                                </div>
                            </td>

                            <!-- Tahun & Anggaran -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">TA {{ $prop->tahun_anggaran }}</div>
                                <div class="text-slate-600 font-semibold mt-0.5">
                                    Rp {{ number_format($prop->total_anggaran, 0, ',', '.') }}
                                </div>
                            </td>

                            <!-- Status Progres -->
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusBadge }} leading-3 inline-block">
                                    {{ $statusLabel }}
                                </span>
                                @if($prop->catatan_admin)
                                    <div class="text-[10px] text-slate-400 mt-1 line-clamp-2 italic" title="{{ $prop->catatan_admin }}">
                                        "{{ $prop->catatan_admin }}"
                                    </div>
                                @endif
                            </td>

                            <!-- Reviewer Ditugaskan -->
                            <td class="py-3.5 px-4">
                                @if($prop->reviews->isEmpty())
                                    <div class="space-y-1.5">
                                        <span class="text-[11px] text-amber-700 font-medium block">Belum ada reviewer</span>
                                        <form method="POST" action="{{ route('admin.pengabdian.assign-reviewer', $prop) }}" class="flex items-center gap-1">
                                            @csrf
                                            <select name="reviewer_id" required class="h-8 border-slate-300 rounded text-[11px] leading-3 py-1 pr-6 max-w-[150px]">
                                                <option value="">Tugaskan Reviewer...</option>
                                                @foreach($reviewers as $rev)
                                                    <option value="{{ $rev->id }}">{{ $rev->name }} ({{ $rev->prodi->kode_prodi ?? '-' }})</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="h-8 px-2.5 bg-[#0B2A59] text-white text-[11px] font-semibold rounded hover:bg-blue-900 transition-colors leading-3">Tugaskan</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="space-y-1">
                                        @foreach($prop->reviews as $rev)
                                            <div class="p-1.5 rounded-lg bg-slate-50 border border-slate-100 text-[11px] flex items-center justify-between gap-2">
                                                <div>
                                                    <span class="font-semibold text-slate-800 block leading-3">{{ $rev->reviewer->name }}</span>
                                                    <span class="text-[10px] text-slate-500">Skor: {{ $rev->total_skor ?? '-' }} • {{ $rev->status_review }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            <!-- Aksi & Pengarsipan -->
                            <td class="py-3.5 px-4 text-right space-y-2">
                                
                                <!-- Update Status Dropdown -->
                                <form method="POST" action="{{ route('admin.pengabdian.update-status', $prop) }}" class="inline-flex items-center gap-1 justify-end">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="h-8 border-slate-300 rounded text-[11px] leading-3 py-1">
                                        <option value="diajukan" {{ $prop->status === 'diajukan' ? 'selected' : '' }}>Submission</option>
                                        <option value="verifikasi_administrasi" {{ $prop->status === 'verifikasi_administrasi' ? 'selected' : '' }}>Lolos Berkas</option>
                                        <option value="sedang_direview" {{ $prop->status === 'sedang_direview' ? 'selected' : '' }}>Sedang Dinilai</option>
                                        <option value="revisi" {{ $prop->status === 'revisi' ? 'selected' : '' }}>Revisi</option>
                                        <option value="diterima" {{ $prop->status === 'diterima' ? 'selected' : '' }}>Didanai</option>
                                        <option value="pelaksanaan" {{ $prop->status === 'pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                                        <option value="archive" {{ $prop->status === 'archive' ? 'selected' : '' }}>Archive (Arsip)</option>
                                        <option value="ditolak" {{ $prop->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <button type="submit" class="h-8 px-2 bg-slate-800 text-white text-[11px] font-semibold rounded hover:bg-slate-700 leading-3">Update</button>
                                </form>

                                <!-- Tombol Khusus Pengarsipan (Archive) -->
                                @if(in_array($prop->status, ['diterima', 'pelaksanaan']))
                                    <div>
                                        <form method="POST" action="{{ route('admin.pengabdian.archive', $prop) }}" onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan kegiatan pengabdian masyarakat ini? Seluruh pelaporan akhir dianggap telah tuntas.');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold border border-slate-300 transition-colors leading-3">
                                                <span>Arsipkan Kegiatan (Archive)</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Tidak ada usulan pengabdian kepada masyarakat yang sesuai dengan kriteria filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($proposals->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
