@extends('layouts.dashboard')

@section('title', 'Evaluasi Laporan Akhir Kegiatan - ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('reviewer.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Beranda Reviewer</a>
                <span>/</span>
                <a href="{{ route('reviewer.reviews.show', $review) }}" class="hover:text-[#0B2A59] hover:underline">{{ $proposal->kode_usulan }}</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Evaluasi Laporan Akhir</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Evaluasi Laporan Akhir Kegiatan</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 leading-4">Penilaian kualitas dokumen pertanggungjawaban akhir, realisasi serapan anggaran 100%, dan ketercapaian luaran definitif.</p>
        </div>

        <div>
            <a href="{{ route('reviewer.reviews.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Usulan
            </a>
        </div>
    </div>

    <!-- TAHAP 1: PERMINTAAN LAPORAN AKHIR (PDF Hal. 17 & 20) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 border-b border-slate-100 pb-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 1
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Permintaan Evaluasi Laporan Akhir</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 leading-6">{{ $proposal->judul }}</h2>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 pt-1">
                    <span>Ketua: <strong class="text-slate-800">{{ $proposal->ketua->name }}</strong></span>
                    <span>•</span>
                    <span>Prodi: <strong class="text-slate-800">{{ $proposal->prodi->nama_prodi }}</strong></span>
                    <span>•</span>
                    <span>Tahun Anggaran <strong class="text-slate-800">{{ $proposal->tahun_anggaran }}</strong></span>
                </div>
            </div>

            <!-- Berkas Unduhan Laporan Akhir & SPJ -->
            <div class="flex flex-col sm:flex-row gap-2 flex-shrink-0">
                @if($finalReport->file_laporan_akhir)
                    <a href="{{ asset('storage/' . $finalReport->file_laporan_akhir) }}" target="_blank" class="inline-flex items-center justify-center gap-2 min-h-[44px] px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Naskah Laporan Akhir (PDF)</span>
                    </a>
                @endif
                @if($finalReport->file_bukti_spj)
                    <a href="{{ asset('storage/' . $finalReport->file_bukti_spj) }}" target="_blank" class="inline-flex items-center justify-center gap-2 min-h-[44px] px-4 rounded-xl text-xs font-semibold text-emerald-900 bg-emerald-100 hover:bg-emerald-200 transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Berkas SPJ</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Jadwal Telaah Laporan Akhir -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 border border-slate-200/80 rounded-xl text-xs leading-4">
            <div>
                <span class="text-slate-500 block">Waktu Penyerahan Laporan:</span>
                <strong class="text-slate-800 block text-sm font-bold mt-0.5">{{ $finalReport->tanggal_penyerahan ? $finalReport->tanggal_penyerahan->translatedFormat('d F Y') : '-' }}</strong>
                <span class="text-slate-400 text-[11px]">Diunggah oleh tim pengusul</span>
            </div>
            <div>
                <span class="text-slate-500 block">Status Laporan:</span>
                <strong class="text-[#0B2A59] block text-sm font-bold mt-0.5 uppercase">{{ $finalReport->status_laporan }}</strong>
                <span class="text-slate-400 text-[11px]">Kesiapan penelaahan reviewer</span>
            </div>
            <div>
                <span class="text-slate-500 block">Batas Waktu Review:</span>
                <strong class="text-rose-700 block text-sm font-bold mt-0.5">{{ $review->batas_waktu_review ? \Carbon\Carbon::parse($review->batas_waktu_review)->translatedFormat('d F Y') : '-' }}</strong>
                <span class="text-slate-400 text-[11px]">Tenggat penetapan rekomendasi</span>
            </div>
        </div>

        @if($finalReport->ringkasan_hasil)
            <div class="space-y-1.5 text-xs pt-1">
                <span class="font-bold text-slate-700 uppercase tracking-wider block leading-4">Ringkasan Intisari Hasil:</span>
                <p class="text-slate-600 leading-5 bg-slate-50 p-4 rounded-xl border border-slate-200 whitespace-pre-line">
                    {{ $finalReport->ringkasan_hasil }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-1">
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                <span class="text-slate-500 block leading-4">Realisasi Serapan Anggaran Biaya:</span>
                <strong class="text-emerald-700 text-sm font-bold block mt-0.5">Rp {{ number_format($finalReport->total_realisasi_anggaran, 0, ',', '.') }}</strong>
                <span class="text-[11px] text-slate-400">Total usulan DIPA: Rp {{ number_format($proposal->total_anggaran, 0, ',', '.') }}</span>
            </div>
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200">
                <span class="text-slate-500 block leading-4">Perubahan Personalia Anggota:</span>
                <strong class="text-slate-800 text-sm font-bold block mt-0.5">{{ $finalReport->perubahan_anggota ? 'Terdapat Perubahan' : 'Tidak Ada Perubahan' }}</strong>
                <span class="text-[11px] text-slate-400">Sesuai lampiran SK tim pelaksana</span>
            </div>
        </div>
    </div>

    <!-- TAHAP 2, 3, & 4: REVIEW 4 KRITERIA, ATRIBUT REVISI, & KONFIRMASI (PDF Hal. 17 & 20) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                    Tahap 2
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Rubrik 4 Kriteria Baku Laporan Akhir</span>
            </div>
            <h2 class="text-xl font-bold text-[#0B2A59] leading-7 mt-2">Formulir Evaluasi Laporan Akhir Kegiatan</h2>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Pilih skor mutu baku 1, 2, 3, 5, 6, atau 7 untuk masing-masing 4 kriteria baku penilaian (skor 4 ditiadakan).
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <strong>Mohon periksa kembali isian evaluasi laporan:</strong>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $kriteriaLaporan = [
                1 => ['nama' => 'Kesesuaian Hasil dengan Tujuan dan Sasaran', 'bobot' => 30, 'desc' => 'Tingkat ketercapaian substansi ilmiah dibandingkan tujuan awal usulan riset/kegiatan pengabdian.'],
                2 => ['nama' => 'Realisasi Capaian Luaran Definitif', 'bobot' => 30, 'desc' => 'Kelengkapan bukti fisik artikel jurnal yang dipublikasikan, sertifikat pendaftaran HKI, atau teknologi terapan.'],
                3 => ['nama' => 'Tingkat Kemanfaatan Hasil', 'bobot' => 25, 'desc' => 'Dampak nyata bagi peningkatan kapasitas perguruan tinggi, kebermanfaatan mitra masyarakat/industri, atau rekomendasi kebijakan.'],
                4 => ['nama' => 'Kesiapan dan Presentasi Hasil', 'bobot' => 15, 'desc' => 'Sistematika penulisan laporan akhir, ketajaman pembahasan, kejernihan penyajian data grafis, serta kelengkapan SPJ.'],
            ];

            $skalaBaku = [
                1 => ['label' => '1 - Buruk', 'desc' => 'Hasil tidak sesuai sasaran'],
                2 => ['label' => '2 - Sangat Kurang', 'desc' => 'Kualitas sangat minim'],
                3 => ['label' => '3 - Kurang', 'desc' => 'Banyak kekurangan substansi'],
                5 => ['label' => '5 - Cukup', 'desc' => 'Memenuhi standar minimum'],
                6 => ['label' => '6 - Baik', 'desc' => 'Pembahasan tajam & rapi'],
                7 => ['label' => '7 - Sangat Baik', 'desc' => 'Sangat komprehensif & bermutu'],
            ];
        @endphp

        <form method="POST" action="{{ route('reviewer.reviews.final-report.update', $review) }}" enctype="multipart/form-data" class="space-y-8" id="reportForm">
            @csrf
            @method('PUT')

            <!-- Loop 4 Kriteria Baku -->
            <div class="space-y-6">
                @foreach($kriteriaLaporan as $idx => $crit)
                    @php $inputName = "kriteria_{$idx}"; @endphp
                    <div class="p-5 border border-slate-200 rounded-2xl bg-slate-50/50 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/60 pb-3">
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                                    {{ $idx }}
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 leading-5">{{ $crit['nama'] }}</h3>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-4">{{ $crit['desc'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded bg-blue-100 text-[#0B2A59] text-xs font-bold leading-4 self-start sm:self-center">
                                Bobot: {{ $crit['bobot'] }}%
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 pt-1">
                            @foreach($skalaBaku as $score => $info)
                                <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors text-center min-h-[44px]">
                                    <input type="radio" name="{{ $inputName }}" value="{{ $score }}" data-bobot="{{ $crit['bobot'] / 100 }}" class="report-radio text-[#0B2A59] focus:ring-[#0B2A59]" {{ old($inputName) == $score ? 'checked' : '' }} required>
                                    <span class="text-xs font-bold text-slate-800 mt-1 leading-4">{{ $info['label'] }}</span>
                                    <span class="text-[10px] text-slate-400 leading-3 mt-0.5">{{ $info['desc'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Rekapitulasi Skor Laporan Akhir -->
            <div class="p-6 bg-gradient-to-r from-slate-900 to-[#0B2A59] text-white rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-300 leading-4">Total Nilai Laporan Akhir</span>
                    <h3 class="text-base font-bold leading-6">Akumulasi Nilai Terbobot</h3>
                    <p class="text-xs text-slate-300 leading-4">Skala mutu baku 1.00 – 7.00</p>
                </div>
                <div class="text-right">
                    <span class="block text-xs text-slate-300 leading-4">Skor Akhir:</span>
                    <div class="text-3xl font-black text-amber-400 leading-9">
                        <span id="report_total_skor">0.00</span>
                        <span class="text-base text-slate-300 font-normal">/ 7.00</span>
                    </div>
                </div>
            </div>

            <!-- TAHAP 3: ATRIBUT REVISI & KOMENTAR PENILAI (PDF Hal. 17 & 20) -->
            <div class="space-y-6 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 3
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Atribut Revisi & Komentar Penilai</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Pilihan Rekomendasi (Revisi / Diterima) -->
                    <div class="md:col-span-1 space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">
                            Rekomendasi Laporan: <span class="text-rose-500">*</span>
                        </label>

                        <div class="space-y-2">
                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors min-h-[44px]">
                                <input type="radio" name="rekomendasi" value="diterima" 
                                    {{ old('rekomendasi', $finalReport->status_laporan) === 'diterima' ? 'checked' : '' }} required
                                    class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                <div class="text-xs leading-4">
                                    <strong class="text-emerald-900 block font-bold">1. Diterima (Lolos Arsip)</strong>
                                    <span class="text-slate-500 text-[11px]">Laporan lengkap dan siap diarsipkan oleh admin.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors min-h-[44px]">
                                <input type="radio" name="rekomendasi" value="revisi" 
                                    {{ old('rekomendasi', $finalReport->status_laporan) === 'revisi' ? 'checked' : '' }} required
                                    class="mt-0.5 text-amber-600 focus:ring-amber-500">
                                <div class="text-xs leading-4">
                                    <strong class="text-amber-900 block font-bold">2. Revisi Laporan</strong>
                                    <span class="text-slate-500 text-[11px]">Pengusul wajib melengkapi kekurangan laporan.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Unggah Berkas Tabel Catatan Revisi Word/PDF -->
                        <div class="pt-4 border-t border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800 leading-4">
                                Unggah Tabel Catatan Revisi (Word/PDF):
                            </label>
                            <p class="text-[11px] text-slate-500 leading-4">
                                Berkas masukan perbaikan format Word (.doc, .docx) atau PDF (maks 10 MB).
                            </p>
                            <input type="file" name="file_catatan_revisi" accept=".doc,.docx,.pdf" class="text-xs text-slate-600 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer min-h-[44px]">
                            @if($finalReport->file_catatan_revisi)
                                <div class="pt-1">
                                    <a href="{{ asset('storage/' . $finalReport->file_catatan_revisi) }}" target="_blank" class="text-[11px] text-[#0B2A59] underline font-semibold">
                                        Unduh Lampiran Catatan Revisi Laporan Saat Ini
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Catatan Evaluasi Reviewer -->
                    <div class="md:col-span-2 space-y-2 text-xs">
                        <label for="catatan_reviewer" class="font-bold text-slate-800 uppercase tracking-wider leading-4 block">
                            Komentar Penilai (Catatan Evaluasi Laporan): <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-slate-500 leading-4">Ulasan komprehensif mengenai capaian substansi, saran keberlanjutan hasil riset, atau rincian bagian yang wajib direvisi.</p>
                        <textarea id="catatan_reviewer" name="catatan_reviewer" rows="7" required minlength="10" class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3.5 leading-5" placeholder="Tuliskan ulasan hasil riset dan rekomendasi hilirisasi produk...">{{ old('catatan_reviewer', $finalReport->catatan_reviewer) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- TAHAP 4: KONFIRMASI LAPORAN AKHIR (PDF Hal. 17 & 20) -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 4
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Konfirmasi Penilaian Laporan Akhir</span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                    <span class="text-xs font-bold text-slate-800 block">Apakah Anda mengonfirmasi hasil penilaian Laporan Akhir ini siap diserahkan ke P3M?</span>
                    <div class="flex flex-wrap items-center gap-6 text-xs">
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="setuju" {{ old('konfirmasi_hasil', $finalReport->konfirmasi_hasil ?? 'setuju') === 'setuju' ? 'checked' : '' }} required class="text-[#0B2A59] focus:ring-[#0B2A59]">
                            <span class="font-bold text-emerald-900">Setuju (Konfirmasi dan Serahkan Evaluasi Laporan)</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="tidak_setuju" {{ old('konfirmasi_hasil', $finalReport->konfirmasi_hasil) === 'tidak_setuju' ? 'checked' : '' }} required class="text-slate-600 focus:ring-slate-500">
                            <span class="font-medium text-slate-600">Tidak Setuju (Tunda Penyerahan)</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Aksi Simpan -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('reviewer.reviews.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center min-h-[44px] px-6 rounded-xl text-xs font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                        Simpan Hasil Penilaian Laporan Akhir
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Script Hitung Skor Laporan Akhir -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioInputs = document.querySelectorAll('.report-radio');
    const elTotal = document.getElementById('report_total_skor');

    function calculateReportScore() {
        let total = 0;
        radioInputs.forEach(input => {
            if (input.checked) {
                const bobot = parseFloat(input.getAttribute('data-bobot')) || 0;
                const score = parseFloat(input.value) || 0;
                total += (score * bobot);
            }
        });
        elTotal.textContent = total.toFixed(2);
    }

    radioInputs.forEach(input => {
        input.addEventListener('change', calculateReportScore);
    });

    calculateReportScore();
});
</script>
@endsection
