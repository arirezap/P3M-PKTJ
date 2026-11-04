@extends('layouts.dashboard')

@section('title', 'Dokumen Laporan Akhir - ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('dosen.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Dasbor Usulan</a>
                <span>/</span>
                <a href="{{ route('dosen.proposals.show', $proposal) }}" class="hover:text-[#0B2A59] hover:underline">{{ $proposal->kode_usulan }}</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Laporan Akhir</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Dokumen Laporan Akhir Kegiatan</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Usulan
            </a>
        </div>
    </div>

    <!-- Status Evaluasi Laporan Akhir -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Status Penelaahan Laporan Akhir</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">Diserahkan pada: {{ $finalReport->tanggal_penyerahan ? $finalReport->tanggal_penyerahan->translatedFormat('d F Y H:i') : '-' }} WIB</p>
            </div>
            <div>
                @php
                    $reportStatusClasses = [
                        'terkirim' => 'bg-blue-50 text-[#0B2A59] border-blue-200',
                        'proses_review' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'revisi' => 'bg-rose-50 text-rose-800 border-rose-200',
                        'diterima' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                    ];
                    $reportStatusLabels = [
                        'terkirim' => 'Laporan Akhir Terkirim ke P3M',
                        'proses_review' => 'Sedang Dinilai Reviewer',
                        'revisi' => 'Perlu Perbaikan / Revisi',
                        'diterima' => 'Laporan Diterima & Disetujui',
                    ];
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold leading-4 border {{ $reportStatusClasses[$finalReport->status_laporan] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                    {{ $reportStatusLabels[$finalReport->status_laporan] ?? ucfirst($finalReport->status_laporan) }}
                </span>
            </div>
        </div>

        <!-- Progress Laporan (PDF Hal. 9: 1. Terkirim, 2. Proses Review, 3. Revisi/Tanpa Revisi, 5. Selesai) -->
        @php
            $reportSteps = [
                1 => ['label' => '1. Terkirim', 'desc' => 'Laporan diserahkan ke P3M'],
                2 => ['label' => '2. Proses Review', 'desc' => 'Penilaian oleh reviewer'],
                3 => ['label' => '3. Revisi / Tanpa Revisi', 'desc' => 'Tindak lanjut hasil review'],
                4 => ['label' => '5. Selesai', 'desc' => 'Laporan diterima definitif'],
            ];

            $currentReportStep = match($finalReport->status_laporan) {
                'terkirim' => 1,
                'proses_review' => 2,
                'revisi' => 3,
                'diterima' => 4,
                default => 1,
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            @foreach($reportSteps as $rNum => $rInfo)
                @php
                    $isPassed = ($rNum <= $currentReportStep);
                    $isCurrent = ($rNum === $currentReportStep);
                @endphp
                <div class="p-3 rounded-xl border flex items-center gap-3 transition-colors {{ $isCurrent ? 'border-[#0B2A59] bg-blue-50/40 ring-1 ring-[#0B2A59]' : ($isPassed ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200 bg-slate-50 opacity-60') }}">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 {{ $isCurrent ? 'bg-[#0B2A59] text-white' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-700') }}">
                        @if($isPassed && !$isCurrent)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $rNum }}
                        @endif
                    </div>
                    <div>
                        <div class="text-xs font-bold leading-4 {{ $isCurrent ? 'text-[#0B2A59]' : ($isPassed ? 'text-emerald-900' : 'text-slate-700') }}">{{ $rInfo['label'] }}</div>
                        <div class="text-[10px] text-slate-500 leading-3 mt-0.5">{{ $rInfo['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($finalReport->status_laporan === 'revisi')
            <div class="p-5 rounded-xl bg-amber-50 border border-amber-200 space-y-3">
                <div class="flex items-center gap-2 text-amber-900 font-bold text-xs">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Catatan Reviewer: Diperlukan Perbaikan Laporan Akhir</span>
                </div>
                @if($finalReport->catatan_reviewer)
                    <div class="p-3 rounded-lg bg-white border border-amber-200 text-xs text-slate-800 leading-5">
                        {{ $finalReport->catatan_reviewer }}
                    </div>
                @endif
                <form method="POST" action="{{ route('dosen.proposals.final-report.revision', $proposal) }}" enctype="multipart/form-data" class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @csrf
                    <input type="file" name="file_revisi_laporan" required accept=".pdf" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-900 hover:file:bg-amber-200">
                    <button type="submit" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-amber-700 hover:bg-amber-800 transition-colors leading-4 whitespace-nowrap">
                        Unggah Berkas Revisi Laporan (PDF)
                    </button>
                </form>
            </div>
        @elseif($finalReport->total_skor_laporan !== null || $finalReport->catatan_reviewer)
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800">Ulasan & Skor Reviewer:</span>
                    @if($finalReport->total_skor_laporan !== null)
                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-[#0B2A59] text-white">
                            Skor Akhir: {{ number_format($finalReport->total_skor_laporan, 1) }}
                        </span>
                    @endif
                </div>
                @if($finalReport->catatan_reviewer)
                    <p class="text-xs text-slate-700 leading-5 bg-white p-3 rounded-lg border border-slate-200 whitespace-pre-line">
                        {{ $finalReport->catatan_reviewer }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Berkas Dokumen Unduhan -->
        <div class="pt-2 flex flex-wrap items-center gap-3">
            @if($finalReport->file_laporan_akhir)
                <a href="{{ asset('storage/' . $finalReport->file_laporan_akhir) }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Naskah Laporan Akhir (PDF)</span>
                </a>
            @endif

            @if($finalReport->file_revisi_laporan)
                <a href="{{ asset('storage/' . $finalReport->file_revisi_laporan) }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Naskah Revisi (PDF)</span>
                </a>
            @endif

            @if($finalReport->file_bukti_spj)
                <a href="{{ asset('storage/' . $finalReport->file_bukti_spj) }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold text-emerald-900 bg-emerald-100 hover:bg-emerald-200 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Rekapitulasi SPJ Belanja</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Ringkasan Hasil & Perubahan Personalia -->
    @if($finalReport->ringkasan_hasil || $finalReport->perubahan_anggota)
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Ringkasan Hasil & Personalia</h2>
            </div>
            <div class="space-y-4 text-xs">
                @if($finalReport->ringkasan_hasil)
                    <div>
                        <span class="font-bold text-slate-800 block mb-1 leading-4">Ringkasan Intisari Hasil:</span>
                        <p class="text-slate-700 leading-6 whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ $finalReport->ringkasan_hasil }}
                        </p>
                    </div>
                @endif
                @if($finalReport->perubahan_anggota)
                    <div>
                        <span class="font-bold text-slate-800 block mb-1 leading-4">Catatan Perubahan Anggota Peneliti:</span>
                        <p class="text-slate-700 leading-6 whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-100">
                            {{ $finalReport->perubahan_anggota }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Realisasi Serapan Anggaran 100% -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Realisasi Serapan Anggaran Biaya (100%)</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">Perbandingan antara usulan RAB yang disetujui dengan realisasi belanja fisik.</p>
            </div>
            <div class="text-sm font-extrabold text-emerald-700 leading-5">
                Total Realisasi: Rp {{ number_format($finalReport->total_realisasi_anggaran, 0, ',', '.') }}
            </div>
        </div>

        @if(!empty($finalReport->rincian_realisasi) && is_array($finalReport->rincian_realisasi))
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                            <th class="py-3 px-4">Kategori Belanja</th>
                            <th class="py-3 px-4">Uraian Kebutuhan</th>
                            <th class="py-3 px-4 text-right">Rencana Usulan</th>
                            <th class="py-3 px-4 text-right">Realisasi</th>
                            <th class="py-3 px-4">Keterangan / Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($finalReport->rincian_realisasi as $row)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 font-semibold text-slate-700 capitalize whitespace-nowrap">
                                    {{ str_replace('_', ' ', $row['kategori'] ?? '-') }}
                                </td>
                                <td class="py-3 px-4 text-slate-800">{{ $row['uraian'] ?? '-' }}</td>
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    Rp {{ number_format((float)($row['anggaran_usulan'] ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-slate-900 whitespace-nowrap">
                                    Rp {{ number_format((float)($row['realisasi'] ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-slate-600">{{ $row['keterangan'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50 border-t-2 border-slate-300 font-bold text-slate-900">
                            <td colspan="3" class="py-3 px-4 text-right">TOTAL REALISASI SERAPAN:</td>
                            <td class="py-3 px-4 text-right text-emerald-800 whitespace-nowrap">
                                Rp {{ number_format($finalReport->total_realisasi_anggaran, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="p-4 rounded-xl bg-slate-50 text-xs text-slate-700 flex items-center justify-between">
                <span>Total Serapan Anggaran yang Dilaporkan:</span>
                <strong class="text-sm font-bold text-emerald-700">Rp {{ number_format($finalReport->total_realisasi_anggaran, 0, ',', '.') }}</strong>
            </div>
        @endif
    </div>

    <!-- Pemutakhiran Luaran Akhir Definitif -->
    @if(!empty($finalReport->capaian_luaran) && is_array($finalReport->capaian_luaran))
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Pemutakhiran Luaran Akhir Definitif</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                @php $luaran = $finalReport->capaian_luaran; @endphp

                @if(!empty($luaran['jurnal']['nama_jurnal']) || !empty($luaran['jurnal']['doi_url']))
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <span class="font-bold text-[#0B2A59] block leading-4">Publikasi Jurnal Ilmiah</span>
                        <div class="text-slate-800 leading-5">
                            <strong>Nama Jurnal:</strong> {{ $luaran['jurnal']['nama_jurnal'] ?? '-' }}
                        </div>
                        @if(!empty($luaran['jurnal']['doi_url']))
                            <div>
                                <a href="{{ $luaran['jurnal']['doi_url'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-700 hover:underline font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Tautan DOI Naskah Terbit</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($luaran['hki']['judul_hki']) || !empty($luaran['hki']['nomor_hki']))
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <span class="font-bold text-[#0B2A59] block leading-4">Hak Kekayaan Intelektual (HKI)</span>
                        <div class="text-slate-800 leading-5">
                            <strong>Judul Ciptaan / Paten:</strong> {{ $luaran['hki']['judul_hki'] ?? '-' }}
                        </div>
                        <div class="text-slate-600 leading-5">
                            <strong>Nomor DJKI:</strong> {{ $luaran['hki']['nomor_hki'] ?? '-' }}
                        </div>
                    </div>
                @endif

                @if(!empty($luaran['prosiding']['nama_konferensi']) || !empty($luaran['prosiding']['link_prosiding']))
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <span class="font-bold text-[#0B2A59] block leading-4">Prosiding Seminar / Pemakalah</span>
                        <div class="text-slate-800 leading-5">
                            <strong>Konferensi:</strong> {{ $luaran['prosiding']['nama_konferensi'] ?? '-' }}
                        </div>
                        @if(!empty($luaran['prosiding']['link_prosiding']))
                            <div>
                                <a href="{{ $luaran['prosiding']['link_prosiding'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-700 hover:underline font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Tautan Naskah Prosiding</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($luaran['produk']['spesifikasi']) || !empty($luaran['produk']['link_dokumentasi']))
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <span class="font-bold text-[#0B2A59] block leading-4">Purwarupa / Produk Terapan</span>
                        <div class="text-slate-800 leading-5">
                            <strong>Spesifikasi:</strong> {{ $luaran['produk']['spesifikasi'] ?? '-' }}
                        </div>
                        @if(!empty($luaran['produk']['link_dokumentasi']))
                            <div>
                                <a href="{{ $luaran['produk']['link_dokumentasi'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-700 hover:underline font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Tautan Dokumentasi Pengujian</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection

