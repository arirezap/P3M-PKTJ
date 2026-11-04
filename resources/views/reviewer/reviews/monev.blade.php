@extends('layouts.dashboard')

@section('title', 'Evaluasi Pemantauan dan Evaluasi (Monev) - ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-6">

    <!-- Navigasi Kembali & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('reviewer.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Beranda Reviewer</a>
                <span>/</span>
                <a href="{{ route('reviewer.reviews.show', $review) }}" class="hover:text-[#0B2A59] hover:underline">{{ $proposal->kode_usulan }}</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Evaluasi Monev</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Evaluasi Pemantauan dan Evaluasi (Monev)</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 leading-4">Penelaahan capaian antara dan evaluasi pelaksanaan kegiatan di lapangan oleh pengusul.</p>
        </div>

        <div>
            <a href="{{ route('reviewer.reviews.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Usulan
            </a>
        </div>
    </div>

    <!-- TAHAP 1: PERMINTAAN MONEV (PDF Hal. 17 & 19) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 1
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Permintaan Evaluasi Monev</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 leading-6">{{ $proposal->judul }}</h2>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 pt-1">
                    <span>Ketua: <strong class="text-slate-800">{{ $proposal->ketua->name }}</strong></span>
                    <span>•</span>
                    <span>Prodi: <strong class="text-slate-800">{{ $proposal->prodi->nama_prodi }} ({{ $proposal->prodi->kode_prodi }})</strong></span>
                    <span>•</span>
                    <span>Tahun Anggaran <strong class="text-slate-800">{{ $proposal->tahun_anggaran }}</strong></span>
                </div>
            </div>

            @if($monev->file_bukti_luaran)
                <a href="{{ asset('storage/' . $monev->file_bukti_luaran) }}" target="_blank" class="inline-flex items-center justify-center gap-2 min-h-[44px] px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Bukti Luaran Sementara</span>
                </a>
            @endif
        </div>

        <!-- Jadwal Monev -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 border border-slate-200/80 rounded-xl text-xs leading-4">
            <div>
                <span class="text-slate-500 block">Waktu Pengisian Monev:</span>
                <strong class="text-slate-800 block text-sm font-bold mt-0.5">{{ $monev->tanggal_monev ? $monev->tanggal_monev->translatedFormat('d F Y') : '-' }}</strong>
                <span class="text-slate-400 text-[11px]">Diserahkan oleh pengusul</span>
            </div>
            <div>
                <span class="text-slate-500 block">Status Monev:</span>
                <strong class="text-[#0B2A59] block text-sm font-bold mt-0.5 uppercase">{{ $monev->status_monev }}</strong>
                <span class="text-slate-400 text-[11px]">{{ $monev->status_monev === 'dinilai' ? 'Penilaian selesai' : 'Memerlukan telaah' }}</span>
            </div>
            <div>
                <span class="text-slate-500 block">Batas Waktu Penilaian:</span>
                <strong class="text-rose-700 block text-sm font-bold mt-0.5">{{ $review->batas_waktu_review ? \Carbon\Carbon::parse($review->batas_waktu_review)->translatedFormat('d F Y') : '-' }}</strong>
                <span class="text-slate-400 text-[11px]">Sesuai jadwal tahapan</span>
            </div>
        </div>

        <!-- Jawaban 7 Butir Pilihan Ganda Pengusul -->
        <div class="space-y-3 pt-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">Data 7 Butir Capaian Pengusul (Pilihan Ganda):</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">1. Capaian Kegiatan Utama / Riset:</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5">{{ $monev->capaian_penelitian }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">2. Publikasi Ilmiah:</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ $monev->publikasi_ilmiah }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">3. Pemakalah Pertemuan Ilmiah:</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ str_replace('_', ' ', $monev->pemakalah_ilmiah) }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">4. Hak Kekayaan Intelektual (HKI):</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ str_replace('_', ' ', $monev->hki) }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">5. Teknologi Tepat Guna (TTG):</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ str_replace('_', ' ', $monev->teknologi_tepat_guna) }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-500 block leading-4">6. Purwarupa / Produk Rekayasa:</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ str_replace('_', ' ', $monev->produk_purwarupa) }}</strong>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 md:col-span-2">
                    <span class="text-slate-500 block leading-4">7. Buku Ajar / Monograf:</span>
                    <strong class="text-slate-900 font-bold leading-5 block mt-0.5 uppercase">{{ str_replace('_', ' ', $monev->buku_ajar) }}</strong>
                </div>
            </div>
        </div>

        <!-- Jawaban 7 Butir Evaluasi Essai Pengusul -->
        <div class="space-y-3 pt-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">Uraian Evaluasi Faktual Pelaksanaan (Essai Pengusul):</h3>
            <div class="space-y-2 text-xs">
                @php
                    $essaiLabels = [
                        'kegiatan_terlaksana' => '1. Uraian Kegiatan yang Telah Terlaksana',
                        'kesesuaian_waktu' => '2. Kesesuaian Jadwal dan Waktu Pelaksanaan',
                        'kesesuaian_metode' => '3. Kesesuaian Metode Pendekatan dengan Usulan',
                        'kesesuaian_personalia' => '4. Kesesuaian Personalia dan Peran Anggota Tim',
                        'kesesuaian_anggaran' => '5. Kesesuaian Penggunaan Anggaran Belanja (RAB)',
                        'kesesuaian_sarpras' => '6. Dukungan Sarana, Prasarana, dan Laboratorium',
                        'kesesuaian_target' => '7. Realisasi Capaian Target Luaran Sementara',
                    ];
                @endphp
                @foreach($essaiLabels as $key => $lbl)
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                        <span class="font-bold text-slate-800 block">{{ $lbl }}:</span>
                        <p class="text-slate-600 leading-5 whitespace-pre-line">{{ $monev->$key ?? '-' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAHAP 2 & 3: REVIEW RUBRIK 7 KOMPONEN & KONFIRMASI (PDF Hal. 17 & 19) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                    Tahap 2
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Rubrik 7 Komponen Capaian Monev</span>
            </div>
            <h2 class="text-xl font-bold text-[#0B2A59] leading-7 mt-2">Formulir Evaluasi Capaian Monev</h2>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Pilih skor mutu baku 1, 2, 3, 5, 6, atau 7 untuk masing-masing dari 7 komponen berbobot (skor 4 ditiadakan).
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <strong>Mohon periksa kembali isian evaluasi monev:</strong>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $komponenMonev = [
                1 => ['nama' => 'Capaian Kegiatan Utama / Penelitian', 'bobot' => 25, 'desc' => 'Tingkat kemajuan riset laboratorium/lapangan dibandingkan timeline usulan awal.'],
                2 => ['nama' => 'Publikasi Ilmiah', 'bobot' => 20, 'desc' => 'Draf manuskrip artikel, status submission jurnal, atau penerimaan naskah.'],
                3 => ['nama' => 'Pemakalah dalam Pertemuan Ilmiah', 'bobot' => 10, 'desc' => 'Keikutsertaan sebagai pemakalah pada seminar ilmiah nasional / internasional.'],
                4 => ['nama' => 'Hak Kekayaan Intelektual (HKI)', 'bobot' => 5, 'desc' => 'Persiapan dokumen paten, hak cipta, atau desain industri.'],
                5 => ['nama' => 'Teknologi Tepat Guna (TTG)', 'bobot' => 10, 'desc' => 'Penerapan alat, panduan operasional, atau aplikasi teknologi yang siap dimanfaatkan.'],
                6 => ['nama' => 'Produk / Model / Purwarupa / Rekayasa', 'bobot' => 20, 'desc' => 'Wujud fisik purwarupa, model keselamatan transportasi, atau rekayasa sistem.'],
                7 => ['nama' => 'Buku Ajar / Monograf', 'bobot' => 10, 'desc' => 'Penyusunan bahan ajar perkuliahan atau draf naskah buku ber-ISBN.'],
            ];

            $skalaBaku = [
                1 => ['label' => '1 - Buruk', 'desc' => 'Belum ada progres'],
                2 => ['label' => '2 - Sangat Kurang', 'desc' => 'Kemajuan sangat minim'],
                3 => ['label' => '3 - Kurang', 'desc' => 'Progres di bawah target'],
                5 => ['label' => '5 - Cukup', 'desc' => 'Memenuhi target minimal'],
                6 => ['label' => '6 - Baik', 'desc' => 'Sesuai tahapan target'],
                7 => ['label' => '7 - Sangat Baik', 'desc' => 'Melampaui target usulan'],
            ];
        @endphp

        <form method="POST" action="{{ route('reviewer.reviews.monev.update', $review) }}" class="space-y-8" id="monevForm">
            @csrf
            @method('PUT')

            <!-- Loop 7 Komponen Berbobot -->
            <div class="space-y-6">
                @foreach($komponenMonev as $idx => $comp)
                    @php $inputName = "monev_{$idx}"; @endphp
                    <div class="p-5 border border-slate-200 rounded-2xl bg-slate-50/50 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/60 pb-3">
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                                    {{ $idx }}
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 leading-5">{{ $comp['nama'] }}</h3>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-4">{{ $comp['desc'] }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded bg-blue-100 text-[#0B2A59] text-xs font-bold leading-4 self-start sm:self-center">
                                Bobot: {{ $comp['bobot'] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 pt-1">
                            @foreach($skalaBaku as $score => $info)
                                <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors text-center min-h-[44px]">
                                    <input type="radio" name="{{ $inputName }}" value="{{ $score }}" data-bobot="{{ $comp['bobot'] / 100 }}" class="monev-radio text-[#0B2A59] focus:ring-[#0B2A59]" {{ old($inputName) == $score ? 'checked' : '' }} required>
                                    <span class="text-xs font-bold text-slate-800 mt-1 leading-4">{{ $info['label'] }}</span>
                                    <span class="text-[10px] text-slate-400 leading-3 mt-0.5">{{ $info['desc'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Rekapitulasi Skor Monev -->
            <div class="p-6 bg-gradient-to-r from-slate-900 to-[#0B2A59] text-white rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-md">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-300 leading-4">Total Nilai Kemajuan Monev</span>
                    <h3 class="text-base font-bold leading-6">Akumulasi Skor Terbobot</h3>
                    <p class="text-xs text-slate-300 leading-4">Skala mutu baku 1.00 – 7.00</p>
                </div>
                <div class="text-right">
                    <span class="block text-xs text-slate-300 leading-4">Skor Akhir Monev:</span>
                    <div class="text-3xl font-black text-amber-400 leading-9">
                        <span id="monev_total_skor">0.00</span>
                        <span class="text-base text-slate-300 font-normal">/ 7.00</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Evaluasi Monev -->
            <div class="space-y-1.5 text-xs">
                <label for="catatan_reviewer" class="font-bold text-slate-800 uppercase tracking-wider leading-4 block">
                    Komentar Penilai & Arahan Menuju Laporan Akhir: <span class="text-rose-500">*</span>
                </label>
                <p class="text-slate-500 leading-4">Berikan catatan konstruktif terkait pemenuhan target output sebelum penyerahan laporan akhir kegiatan.</p>
                <textarea id="catatan_reviewer" name="catatan_reviewer" rows="5" required minlength="10" class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3.5 leading-5" placeholder="Tuliskan arahan percepatan luaran, perbaikan metodologi lapangan, atau kelengkapan berkas...">{{ old('catatan_reviewer', $monev->catatan_reviewer) }}</textarea>
            </div>

            <!-- TAHAP 3: KONFIRMASI MONEV (PDF Hal. 17 & 19) -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 3
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Konfirmasi Penilaian Monev</span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                    <span class="text-xs font-bold text-slate-800 block">Apakah Anda mengonfirmasi hasil penilaian Monev ini siap diserahkan ke P3M?</span>
                    <div class="flex flex-wrap items-center gap-6 text-xs">
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="setuju" {{ old('konfirmasi_hasil', $monev->konfirmasi_hasil ?? 'setuju') === 'setuju' ? 'checked' : '' }} required class="text-[#0B2A59] focus:ring-[#0B2A59]">
                            <span class="font-bold text-emerald-900">Setuju (Konfirmasi dan Serahkan Evaluasi Monev)</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="tidak_setuju" {{ old('konfirmasi_hasil', $monev->konfirmasi_hasil) === 'tidak_setuju' ? 'checked' : '' }} required class="text-slate-600 focus:ring-slate-500">
                            <span class="font-medium text-slate-600">Tidak Setuju (Tunda Penyerahan)</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Aksi Simpan -->
                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="{{ route('reviewer.reviews.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center min-h-[44px] px-6 rounded-xl text-xs font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                        Simpan Hasil Penilaian Monev
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Script Hitung Skor Monev -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioInputs = document.querySelectorAll('.monev-radio');
    const elTotal = document.getElementById('monev_total_skor');

    function calculateMonevScore() {
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
        input.addEventListener('change', calculateMonevScore);
    });

    calculateMonevScore();
});
</script>
@endsection
