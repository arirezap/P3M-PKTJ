@extends('layouts.dashboard')

@section('title', 'Detail Usulan: ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('dosen.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Dasbor Usulan</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">{{ $proposal->kode_usulan }}</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">{{ $proposal->kode_usulan }}</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
        </div>

        <!-- Tombol Aksi Sesuai Status -->
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('dosen.dashboard') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Dasbor
            </a>

            @if($proposal->status === 'draft')
                <a href="{{ route('dosen.proposals.edit', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                    Ubah Draf Usulan
                </a>

                <form method="POST" action="{{ route('dosen.proposals.destroy', $proposal) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draf usulan ini? Tindakan tidak dapat dibatalkan.');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-3 rounded-xl text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 transition-colors leading-4">
                        Hapus
                    </button>
                </form>

                <form method="POST" action="{{ route('dosen.proposals.submit', $proposal) }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                        Kirimkan Usulan ke P3M
                    </button>
                </form>
            @elseif($proposal->status === 'revisi')
                <a href="{{ route('dosen.proposals.edit', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 transition-colors leading-4 font-bold">
                    Edit Data Usulan / Anggaran
                </a>
            @endif
        </div>
    </div>

    <!-- ==================== ALUR PELACAK STATUS USULAN (STEPPER TRACKER) ==================== -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Tahapan Alur Seleksi Proposal</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">Pantau status perjalanan proposal dari pengajuan hingga penetapan pendanaan.</p>
            </div>
            <div>
                @php
                    $statusLabels = [
                        'draft' => 'Draf Usulan',
                        'diajukan' => 'Diajukan ke P3M',
                        'verifikasi_administrasi' => 'Lolos Berkas Administrasi',
                        'sedang_direview' => 'Sedang Dinilai Reviewer',
                        'revisi' => 'Perbaikan / Revisi Diperlukan',
                        'diterima' => 'Usulan Diterima & Didanai',
                        'ditolak' => 'Belum Lolos Pendanaan',
                    ];
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold leading-4 border {{ $proposal->status === 'diterima' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($proposal->status === 'revisi' ? 'bg-rose-50 text-rose-800 border-rose-200' : 'bg-blue-50 text-[#0B2A59] border-blue-200') }}">
                    Status: {{ $statusLabels[$proposal->status] ?? ucfirst($proposal->status) }}
                </span>
            </div>
        </div>

        <!-- Visual Stepper Progress Bar -->
        @php
            $steps = [
                1 => ['label' => 'Draf Usulan', 'desc' => 'Penyusunan data & RAB'],
                2 => ['label' => 'Diajukan', 'desc' => 'Terkirim ke P3M PKTJ'],
                3 => ['label' => 'Seleksi Administrasi', 'desc' => 'Verifikasi berkas'],
                4 => ['label' => 'Penilaian Reviewer', 'desc' => 'Desk evaluasi substansi'],
                5 => ['label' => 'Keputusan Akhir', 'desc' => 'Penetapan pendanaan'],
            ];

            // Tentukan step aktif berdasarkan status
            $currentStep = match($proposal->status) {
                'draft' => 1,
                'diajukan' => 2,
                'verifikasi_administrasi' => 3,
                'sedang_direview', 'revisi' => 4,
                'diterima', 'ditolak' => 5,
                default => 1,
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            @foreach($steps as $sNum => $sInfo)
                @php
                    $isPassed = ($sNum < $currentStep) || ($sNum === 5 && $proposal->status === 'diterima');
                    $isCurrent = ($sNum === $currentStep);
                @endphp
                <div class="p-3 rounded-xl border flex md:flex-col items-center md:items-start gap-3 transition-colors {{ $isCurrent ? 'border-[#0B2A59] bg-blue-50/40 ring-1 ring-[#0B2A59]' : ($isPassed ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200 bg-slate-50 opacity-60') }}">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 {{ $isCurrent ? 'bg-[#0B2A59] text-white' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-700') }}">
                        @if($isPassed)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $sNum }}
                        @endif
                    </div>
                    <div>
                        <div class="text-xs font-bold leading-4 {{ $isCurrent ? 'text-[#0B2A59]' : ($isPassed ? 'text-emerald-900' : 'text-slate-700') }}">{{ $sInfo['label'] }}</div>
                        <div class="text-[10px] text-slate-500 leading-3 mt-0.5">{{ $sInfo['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Alert Khusus Status: REVISI -->
        @if($proposal->status === 'revisi')
            <div class="p-5 rounded-xl bg-amber-50 border border-amber-200 space-y-3">
                <div class="flex items-center gap-2 text-amber-900 font-bold text-xs">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Perhatian: Reviewer / Pengelola P3M Meminta Perbaikan Usulan</span>
                </div>
                <p class="text-xs text-amber-800 leading-5">
                    Silakan baca catatan reviewer di bawah ini, lakukan penyesuaian naskah proposal, dan unggah berkas revisi PDF yang telah diperbaiki.
                </p>
                @if($proposal->catatan_admin)
                    <div class="p-3 rounded-lg bg-white border border-amber-200 text-xs text-slate-800 leading-5">
                        <strong>Catatan Admin / Reviewer:</strong> {{ $proposal->catatan_admin }}
                    </div>
                @endif

                <!-- Formulir Unggah Berkas Revisi -->
                <form method="POST" action="{{ route('dosen.proposals.upload-revision', $proposal) }}" enctype="multipart/form-data" class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @csrf
                    <input type="file" name="file_revisi" required accept=".pdf" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-900 hover:file:bg-amber-200">
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-amber-700 hover:bg-amber-800 transition-colors leading-4 whitespace-nowrap">
                        Unggah Berkas Revisi (PDF)
                    </button>
                </form>
            </div>
        @endif

        <!-- Alert Khusus Status: DITERIMA -->
        @if($proposal->status === 'diterima')
            <div class="p-5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 space-y-2">
                <div class="font-bold flex items-center gap-2 text-sm leading-5">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Selamat! Usulan Proposal Anda Dinyatakan Diterima & Didanai</span>
                </div>
                <p class="leading-5">
                    Usulan ini telah lolos desk evaluasi substansi dan ditetapkan untuk mendapatkan pendanaan DIPA PKTJ Tahun Anggaran {{ $proposal->tahun_anggaran }}. Pengelola P3M akan menghubungi Anda terkait penandatanganan kontrak penugasan penelitian.
                </p>
            </div>
        @endif
    </div>

    <!-- ==================== INFORMASI UTAMA & ABSTRAK ==================== -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Identitas & Deskripsi Usulan</h2>
        </div>

        <div class="space-y-4">
            <div>
                <span class="text-xs font-semibold text-slate-500 leading-4">Judul Kegiatan:</span>
                <h3 class="text-lg font-bold text-slate-900 mt-1 leading-6">{{ $proposal->judul }}</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs pt-2 border-t border-slate-100">
                <div>
                    <span class="text-slate-500 block leading-4">Skema Pendanaan:</span>
                    <strong class="text-slate-800 leading-5">{{ $proposal->skema }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block leading-4">Program Studi Homebase:</span>
                    <strong class="text-[#0B2A59] leading-5">{{ $proposal->prodi->kode_prodi }} - {{ $proposal->prodi->nama_prodi }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block leading-4">Tahun Anggaran:</span>
                    <strong class="text-slate-800 leading-5">T.A. {{ $proposal->tahun_anggaran }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block leading-4">Sumber Pendanaan:</span>
                    <strong class="text-slate-800 leading-5">{{ $proposal->sumber_dana }}</strong>
                </div>
            </div>

            @if($proposal->abstrak)
                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <span class="text-xs font-bold text-slate-700 leading-4">Abstrak / Ringkasan Riset:</span>
                    <p class="text-xs text-slate-600 leading-6 whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-200">
                        {{ $proposal->abstrak }}
                    </p>
                </div>
            @endif

            <!-- Berkas Proposal PDF -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="text-xs">
                    <span class="text-slate-500">Berkas Proposal PDF:</span>
                    @if($proposal->file_proposal)
                        <span class="font-semibold text-slate-800 ml-1">Tersedia (Terunggah)</span>
                    @else
                        <span class="text-amber-600 font-semibold ml-1">Belum diunggah</span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    @if($proposal->file_proposal)
                        <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="inline-flex items-center gap-2 h-9 px-3 rounded-lg text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Naskah Proposal PDF</span>
                        </a>
                    @endif

                    @if($proposal->file_revisi)
                        <a href="{{ asset('storage/' . $proposal->file_revisi) }}" target="_blank" class="inline-flex items-center gap-2 h-9 px-3 rounded-lg text-xs font-semibold text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors leading-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Berkas Revisi PDF</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SUSUNAN TIM PENGUSUL ==================== -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Susunan Tim Pengusul</h2>
            <span class="text-xs text-slate-500 font-medium leading-4">Total: {{ $proposal->members->count() + 1 }} Peneliti</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3 px-4">Nama Lengkap & Gelar</th>
                        <th class="py-3 px-4">Peran dalam Tim</th>
                        <th class="py-3 px-4">NIDN / NIM</th>
                        <th class="py-3 px-4">Uraian Tugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Baris Ketua Pengusul -->
                    <tr class="bg-blue-50/30">
                        <td class="py-3 px-4 font-bold text-slate-900">
                            {{ $proposal->ketua->name }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-[#0B2A59] text-white">
                                Ketua Pengusul
                            </span>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">{{ $proposal->ketua->nidn_nip ?? '-' }}</td>
                        <td class="py-3 px-4 text-slate-600">Penanggung jawab utama konsep riset, metodologi, dan tata kelola anggaran.</td>
                    </tr>

                    <!-- Baris Anggota Tim -->
                    @forelse($proposal->members as $member)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $member->nama }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $member->peran === 'dosen_anggota' ? 'bg-slate-100 text-slate-800' : 'bg-emerald-50 text-emerald-800' }}">
                                    {{ $member->peran === 'dosen_anggota' ? 'Dosen Anggota' : 'Taruna / Mahasiswa' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $member->nidn_nim ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $member->tugas ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-400">Tidak ada anggota tambahan yang didaftarkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== RINCIAN ANGGARAN BIAYA (RAB) ==================== -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Rincian Rencana Anggaran Biaya (RAB)</h2>
            <div class="text-sm font-extrabold text-[#0B2A59] leading-5">
                Total: Rp {{ number_format($proposal->total_anggaran, 0, ',', '.') }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3 px-4">Kategori Belanja</th>
                        <th class="py-3 px-4">Uraian Kebutuhan</th>
                        <th class="py-3 px-4 text-right">Volume</th>
                        <th class="py-3 px-4">Satuan</th>
                        <th class="py-3 px-4 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-right">Total Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($proposal->budgets as $budget)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-semibold text-slate-700 capitalize whitespace-nowrap">
                                {{ str_replace('_', ' ', $budget->kategori_belanja) }}
                            </td>
                            <td class="py-3 px-4 text-slate-800">{{ $budget->uraian }}</td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">{{ number_format($budget->volume, 2) }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">{{ $budget->satuan }}</td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">Rp {{ number_format($budget->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-right font-bold text-slate-900 whitespace-nowrap">Rp {{ number_format($budget->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada rincian anggaran biaya yang diinputkan.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 border-t-2 border-slate-300 font-bold text-slate-900">
                        <td colspan="5" class="py-3 px-4 text-right">TOTAL KESELURUHAN ANGGARAN USULAN (RAB):</td>
                        <td class="py-3 px-4 text-right text-sm text-[#0B2A59] whitespace-nowrap">
                            Rp {{ number_format($proposal->total_anggaran, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ==================== CATATAN EVALUASI & REVIEW ==================== -->
    @if($proposal->reviews->isNotEmpty())
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Hasil Penilaian & Catatan Reviewer</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">Ulasan evaluasi desk proposal oleh penilai yang ditugaskan oleh Admin P3M PKTJ.</p>
            </div>

            <div class="space-y-4">
                @foreach($proposal->reviews as $rev)
                    <div class="p-5 rounded-xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Reviewer: {{ $rev->reviewer->name }}</span>
                                <span class="text-[11px] text-slate-500">({{ $rev->reviewer->prodi?->kode_prodi ?? 'Reviewer PKTJ' }})</span>
                            </div>
                            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $rev->status_review === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $rev->status_review }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-2 border-t border-slate-200">
                            <div>
                                <span class="text-slate-500">Skor Akhir Evaluasi:</span>
                                <strong class="text-slate-900 ml-1 text-sm font-bold">{{ $rev->total_skor ? number_format($rev->total_skor, 1) : 'Belum Dinilai' }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-500">Rekomendasi Reviewer:</span>
                                <strong class="text-[#0B2A59] ml-1 font-semibold capitalize">{{ $rev->rekomendasi ?? 'Dalam proses telaah' }}</strong>
                            </div>
                        </div>

                        @if($rev->catatan)
                            <div class="text-xs text-slate-700 leading-5 pt-2 border-t border-slate-200">
                                <strong class="block text-slate-800 mb-1">Catatan & Masukan Reviewer:</strong>
                                <p class="bg-white p-3 rounded-lg border border-slate-200 whitespace-pre-line">{{ $rev->catatan }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
