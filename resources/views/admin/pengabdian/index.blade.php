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
                                @if($prop->file_proposal)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $prop->file_proposal) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#0B2A59] hover:underline">
                                            <span>Unduh Berkas Usulan</span>
                                            <span>↗</span>
                                        </a>
                                        @if($prop->file_revisi)
                                            <span class="text-slate-300 mx-1">|</span>
                                            <a href="{{ asset('storage/' . $prop->file_revisi) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 hover:underline">
                                                <span>Berkas Revisi</span>
                                                <span>↗</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
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
