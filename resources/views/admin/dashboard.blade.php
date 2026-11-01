@extends('layouts.admin')

@section('title', 'Dasbor Administrator SIM P3M')
@section('breadcrumb', 'Home / Dasbor Utama')

@section('content')
<div class="space-y-8">
    
    <!-- Sambutan & Status Sistem -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4">
                <span>Panel Kerja Administrator P3M</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] mt-2 leading-8 sm:leading-9">
                Selamat Datang, {{ Auth::user()->name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-5">
                Pusat kendali Sistem Informasi Manajemen Penelitian dan Pengabdian kepada Masyarakat. Pilih modul kerja di bawah ini untuk mengelola pengajuan usulan, menugaskan reviewer, dan memantau progres kegiatan dari *submission* hingga *archive*.
            </p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <span class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 leading-4">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                <span>Sistem SIM Aktif & Terhubung</span>
            </span>
        </div>
    </div>

    <!-- TIGA HUB PILIHAN UTAMA (Home Sub-Menu: Penelitian, Pengabdian, Pengaturan) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-4">Navigasi Utama SIM</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Pilihan Modul Kerja Utama</h2>
            </div>
            <span class="text-xs text-slate-500">Pilih akses sesuai kebutuhan operasional</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Pilihan 1: Penelitian -->
            <div class="bg-white border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-800 border border-indigo-200 leading-4">
                            Sub-Menu 1
                        </span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-[#0B2A59] group-hover:text-blue-900 transition-colors leading-6">
                            Penelitian
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-5">
                            Kelola pengajuan proposal riset dosen, berikan penugasan reviewer substansi, dan pantau seluruh siklus progres mulai dari submission hingga archive.
                        </p>
                    </div>

                    <!-- Mini Stats Grid Kelipatan 4px -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs leading-4">
                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 text-[11px] block">Total Usulan</span>
                            <strong class="text-slate-800 text-sm font-extrabold">{{ $penelitianStats['total'] }} Usulan</strong>
                        </div>
                        <div class="bg-amber-50/70 p-2.5 rounded-xl border border-amber-100">
                            <span class="text-amber-700 text-[11px] block">Butuh Tindakan</span>
                            <strong class="text-amber-800 text-sm font-extrabold">{{ $penelitianStats['butuh_tindakan'] }} Berkas</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('admin.penelitian.index') }}" 
                       class="w-full h-11 px-4 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs flex items-center justify-center gap-2 transition-colors active:scale-[0.98] leading-4">
                        <span>Akses Modul Penelitian</span>
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pilihan 2: Pengabdian kepada Masyarakat -->
            <div class="bg-white border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 leading-4">
                            Sub-Menu 2
                        </span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-[#0B2A59] group-hover:text-blue-900 transition-colors leading-6">
                            Pengabdian kepada Masyarakat
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-5">
                            Kelola pengajuan usulan pengabdian masyarakat (PkM), verifikasi mitra desa binaan/bengkel, tugaskan reviewer, dan pantau progres hingga archive.
                        </p>
                    </div>

                    <!-- Mini Stats Grid Kelipatan 4px -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs leading-4">
                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 text-[11px] block">Total Usulan PkM</span>
                            <strong class="text-slate-800 text-sm font-extrabold">{{ $pengabdianStats['total'] }} Usulan</strong>
                        </div>
                        <div class="bg-amber-50/70 p-2.5 rounded-xl border border-amber-100">
                            <span class="text-amber-700 text-[11px] block">Butuh Tindakan</span>
                            <strong class="text-amber-800 text-sm font-extrabold">{{ $pengabdianStats['butuh_tindakan'] }} Berkas</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('admin.pengabdian.index') }}" 
                       class="w-full h-11 px-4 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs flex items-center justify-center gap-2 transition-colors active:scale-[0.98] leading-4">
                        <span>Akses Modul Pengabdian</span>
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pilihan 3: Pengaturan -->
            <div class="bg-white border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 leading-4">
                            Sub-Menu 3
                        </span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-[#0B2A59] group-hover:text-blue-900 transition-colors leading-6">
                            Pengaturan
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 leading-5">
                            Kelola akun pengguna (Dosen & Reviewer), aktivasi akun, penetapan hak akses, profil lembaga, serta konfigurasi sistem informasi SIM P3M PKTJ.
                        </p>
                    </div>

                    <!-- Mini Stats Grid Kelipatan 4px -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs leading-4">
                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 text-[11px] block">Dosen Terdaftar</span>
                            <strong class="text-slate-800 text-sm font-extrabold">{{ $pengaturanStats['total_dosen'] }} Orang</strong>
                        </div>
                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 text-[11px] block">Reviewer Aktif</span>
                            <strong class="text-slate-800 text-sm font-extrabold">{{ $pengaturanStats['reviewer_aktif'] }} Penilai</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100">
                    <a href="{{ route('admin.users.index') }}" 
                       class="w-full h-11 px-4 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs flex items-center justify-center gap-2 transition-colors active:scale-[0.98] leading-4">
                        <span>Buka Pengaturan Akun & Sistem</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- PIPELINE SIKLUS HIDUP USULAN (Submission hingga Archive) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-4">Pemantauan Terpadu</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Pipeline Tahapan Kegiatan (Submission s.d. Archive)</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Rekapitulasi sebaran seluruh usulan penelitian dan pengabdian masyarakat pada tiap fase proses.</p>
            </div>
            <div class="text-xs font-semibold text-slate-600 bg-slate-100 px-3.5 py-1.5 rounded-xl border border-slate-200 self-start sm:self-auto leading-4">
                Total {{ $penelitianStats['total'] + $pengabdianStats['total'] }} Usulan Terdata
            </div>
        </div>

        <!-- 7 Tahapan Pipeline Grid Kelipatan 4px -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            
            <!-- Tahap 1: Submission -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>01</span>
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['submission'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Submission Masuk</div>
                <div class="text-[10px] text-slate-400 leading-3">Tahap pengajuan</div>
            </div>

            <!-- Tahap 2: Verifikasi Berkas -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>02</span>
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['verifikasi'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Seleksi Berkas</div>
                <div class="text-[10px] text-slate-400 leading-3">Administrasi</div>
            </div>

            <!-- Tahap 3: Penugasan & Review -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>03</span>
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['review'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Dalam Penilaian</div>
                <div class="text-[10px] text-slate-400 leading-3">Reviewer substansi</div>
            </div>

            <!-- Tahap 4: Revisi Proposal -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>04</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['revisi'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Perbaikan Revisi</div>
                <div class="text-[10px] text-slate-400 leading-3">Respons catatan</div>
            </div>

            <!-- Tahap 5: Penetapan / Didanai -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>05</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['diterima'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Didanai / Lolos</div>
                <div class="text-[10px] text-slate-400 leading-3">Kontrak DIPA</div>
            </div>

            <!-- Tahap 6: Pelaksanaan & Monev -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>06</span>
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['pelaksanaan'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Pelaksanaan</div>
                <div class="text-[10px] text-slate-400 leading-3">Monev lapangan</div>
            </div>

            <!-- Tahap 7: Archive (Arsip Selesai) -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 space-y-2">
                <div class="flex items-center justify-between text-slate-400 text-[11px] font-bold leading-3">
                    <span>07</span>
                    <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                </div>
                <div class="text-xl font-black text-[#0B2A59] leading-6">{{ $pipelineStats['archive'] }}</div>
                <div class="text-[11px] font-semibold text-slate-700 leading-4">Arsip Selesai</div>
                <div class="text-[10px] text-slate-400 leading-3">Archive permanen</div>
            </div>

        </div>
    </div>

    <!-- USULAN MASUK YANG MEMERLUKAN TINDAKAN SEGERA (Penugasan Reviewer / Verifikasi) -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-[#0B2A59] leading-6">Pengajuan Masuk Memerlukan Tindakan Admin</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Daftar usulan baru yang menunggu verifikasi administrasi dan penugasan reviewer oleh admin.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.penelitian.index', ['status' => 'butuh_reviewer']) }}" class="text-xs font-semibold text-[#0B2A59] hover:underline leading-4">
                    Lihat Usulan Penelitian →
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3 px-4">Kode & Judul Usulan</th>
                        <th class="py-3 px-4">Bidang</th>
                        <th class="py-3 px-4">Pengusul & Prodi</th>
                        <th class="py-3 px-4">Tahun / Anggaran</th>
                        <th class="py-3 px-4">Status Usulan</th>
                        <th class="py-3 px-4 text-right">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($urgentProposals as $prop)
                        @php
                            $targetUrl = $prop->jenis === 'penelitian' 
                                ? route('admin.penelitian.index', ['search' => $prop->kode_usulan]) 
                                : route('admin.pengabdian.index', ['search' => $prop->kode_usulan]);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-xs">
                                <span class="font-bold text-[#0B2A59] block">{{ $prop->kode_usulan }}</span>
                                <div class="font-medium text-slate-900 leading-5 mt-0.5 line-clamp-2">{{ $prop->judul }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $prop->jenis === 'penelitian' ? 'bg-indigo-100 text-indigo-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $prop->jenis }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800">{{ $prop->ketua->name }}</div>
                                <div class="text-[11px] text-slate-400">Prodi: {{ $prop->prodi->kode_prodi }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-700">TA {{ $prop->tahun_anggaran }}</div>
                                <div class="text-slate-500 font-medium text-[11px]">Rp {{ number_format($prop->total_anggaran, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 leading-3">
                                    {{ str_replace('_', ' ', $prop->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ $targetUrl }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-xs transition-colors leading-4">
                                    <span>Tugaskan Reviewer</span>
                                    <span>→</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Saat ini tidak ada pengajuan usulan baru yang membutuhkan penugasan reviewer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODUL CMS PENGELOLAAN KONTEN PORTAL PUBLIK (Pintasan Pendukung) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-4">Pendukung Portal</span>
                <h2 class="text-base font-bold text-[#0B2A59] leading-6">CMS Konten Publik P3M</h2>
            </div>
            <span class="text-xs text-slate-400">Data publikasi dan profil kelembagaan</span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- CMS 1: Berita, Agenda & Pengumuman -->
            <a href="{{ route('admin.posts.index') }}" 
               class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs hover:border-[#0B2A59] transition-all duration-200 hover:shadow-md flex flex-col justify-between space-y-4 group">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-[#0B2A59] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-5">CMS Berita & Agenda</h3>
                    <p class="text-xs text-slate-500 leading-4">
                        Kelola publikasi artikel kegiatan, diseminasi riset, dan pengumuman pembukaan *Call for Proposals*.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="font-medium text-slate-400">{{ $stats['total_posts'] }} Konten Aktif</span>
                    <span class="font-semibold text-[#0B2A59] group-hover:translate-x-1 transition-transform">Kelola →</span>
                </div>
            </a>

            <!-- CMS 2: Pusat Unduhan Dokumen & SOP -->
            <a href="{{ route('admin.documents.index') }}" 
               class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs hover:border-[#0B2A59] transition-all duration-200 hover:shadow-md flex flex-col justify-between space-y-4 group">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-5">Dokumen, Panduan & SOP</h3>
                    <p class="text-xs text-slate-500 leading-4">
                        Unggah dan kelola berkas Pedoman Riset/SDM, Pedoman PkM, Proses PkM, dan Buku Panduan SIM P3M.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="font-medium text-slate-400">{{ $stats['total_documents'] }} File Terpasang</span>
                    <span class="font-semibold text-[#0B2A59] group-hover:translate-x-1 transition-transform">Kelola →</span>
                </div>
            </a>

            <!-- CMS 3: Data Riset & Pengabdian -->
            <a href="{{ route('admin.researches.index') }}" 
               class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs hover:border-[#0B2A59] transition-all duration-200 hover:shadow-md flex flex-col justify-between space-y-4 group">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-5">Data Rekap 3 Prodi</h3>
                    <p class="text-xs text-slate-500 leading-4">
                        Kelola data rekapitulasi capaian per prodi (D4 RSTJ, D4 TRO, D3 TO) untuk grafik dan tabel publik.
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="font-medium text-slate-400">{{ $stats['total_researches'] + $stats['total_community_services'] }} Data Rekap</span>
                    <span class="font-semibold text-[#0B2A59] group-hover:translate-x-1 transition-transform">Kelola →</span>
                </div>
            </a>

        </div>
    </div>

</div>
@endsection
