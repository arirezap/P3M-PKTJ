@extends('layouts.dashboard')

@section('title', 'Lembar Penilaian Usulan: ' . $review->proposal->kode_usulan)
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-6">

    <!-- Navigasi Kembali & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('reviewer.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-[#0B2A59] transition-colors leading-4 min-h-[44px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Beranda Penugasan</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400">Kode Usulan:</span>
            <span class="text-xs font-bold text-[#0B2A59] px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-xl">
                {{ $review->proposal->kode_usulan }}
            </span>
        </div>
    </div>

    <!-- Banner Status Penilaian Proposal -->
    @if($review->status_review === 'selesai')
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-emerald-950 leading-5">Penilaian Proposal Telah Dikirimkan ke P3M</h2>
                    <p class="text-xs text-emerald-800 mt-0.5 leading-4">
                        Diserahkan pada {{ $review->tanggal_review ? $review->tanggal_review->translatedFormat('d F Y, H:i') : '-' }} WIB dengan rekomendasi: 
                        <strong class="uppercase font-extrabold text-emerald-900">{{ str_replace('_', ' ', $review->rekomendasi) }}</strong>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <span class="block text-[11px] font-semibold text-emerald-700 uppercase tracking-wider leading-3">Total Skor Akhir</span>
                    <span class="text-2xl font-black text-emerald-950 leading-7">{{ number_format($review->total_skor, 2) }} / 7.00</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Tautan Aksi Cepat Monev & Laporan Akhir jika ada -->
    @if($review->proposal->monev || $review->proposal->finalReport)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($review->proposal->monev)
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center justify-between gap-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700 bg-white px-2 py-0.5 rounded border border-blue-200">Tahap Monev</span>
                        <h4 class="text-xs font-bold text-slate-900 mt-1">Instrumen Monev Telah Diisi Pengusul</h4>
                        <span class="text-[11px] text-slate-500">Status: {{ $review->proposal->monev->status_monev }}</span>
                    </div>
                    <a href="{{ route('reviewer.reviews.monev.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 whitespace-nowrap">
                        Evaluasi Monev
                    </a>
                </div>
            @endif

            @if($review->proposal->finalReport)
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center justify-between gap-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-white px-2 py-0.5 rounded border border-emerald-200">Tahap Penutupan</span>
                        <h4 class="text-xs font-bold text-slate-900 mt-1">Dokumen Laporan Akhir Telah Diunggah</h4>
                        <span class="text-[11px] text-slate-500">Status: {{ $review->proposal->finalReport->status_laporan }}</span>
                    </div>
                    <a href="{{ route('reviewer.reviews.final-report.show', $review) }}" class="inline-flex items-center justify-center min-h-[44px] px-4 rounded-xl text-xs font-semibold text-white bg-emerald-800 hover:bg-emerald-900 transition-colors leading-4 whitespace-nowrap">
                        Evaluasi Laporan Akhir
                    </a>
                </div>
            @endif
        </div>
    @endif

    <!-- TAHAP 1: PERMINTAAN (PDF Hal. 16 & 18) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 1
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Permintaan Penelaahan Usulan</span>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-[#0B2A59] leading-7">
                    Informasi Penugasan & Berkas Usulan
                </h2>
                <p class="text-xs text-slate-500 leading-4">
                    Tipe Telaah: <strong class="text-slate-800">{{ $review->proposal->file_revisi ? 'Usulan Revisi' : 'Usulan Baru' }}</strong> • Skema: <strong class="text-slate-800">{{ $review->proposal->skema }}</strong>
                </p>
            </div>

            <!-- Tombol Berkas PDF Usulan -->
            <div class="flex flex-col sm:flex-row gap-2 flex-shrink-0">
                @if($review->proposal->file_proposal)
                    <a href="{{ asset('storage/' . $review->proposal->file_proposal) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Berkas Usulan (PDF)</span>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-medium min-h-[44px]">
                        Berkas Belum Diunggah
                    </span>
                @endif

                @if($review->proposal->file_revisi)
                    <a href="{{ asset('storage/' . $review->proposal->file_revisi) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Unduh Naskah Revisi (PDF)</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Jadwal Penugasan Telaah (Admin Request, Respon Reviewer, Batas Waktu) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 border border-slate-200/80 rounded-xl text-xs leading-4">
            <div class="space-y-1">
                <span class="text-slate-500 block">Waktu Penugasan Admin (Request):</span>
                <strong class="text-slate-800 text-sm block font-bold leading-5">{{ $review->created_at->translatedFormat('d F Y') }}</strong>
                <span class="text-slate-400 text-[11px]">Diteruskan oleh Administrator SIM</span>
            </div>
            <div class="space-y-1">
                <span class="text-slate-500 block">Respon Persetujuan Reviewer:</span>
                @if($review->disetujui_review_at)
                    <strong class="text-emerald-700 text-sm block font-bold leading-5">Disetujui</strong>
                    <span class="text-slate-500 text-[11px]">{{ $review->disetujui_review_at->translatedFormat('d F Y, H:i') }} WIB</span>
                @else
                    <strong class="text-amber-700 text-sm block font-bold leading-5">Menunggu Tanggapan</strong>
                    <span class="text-slate-500 text-[11px]">Silakan klik "Setujui Review" di bawah</span>
                @endif
            </div>
            <div class="space-y-1">
                <span class="text-slate-500 block">Batas Waktu Review (Deadline):</span>
                <strong class="text-rose-700 text-sm block font-bold leading-5">
                    {{ $review->batas_waktu_review ? \Carbon\Carbon::parse($review->batas_waktu_review)->translatedFormat('d F Y') : '-' }}
                </strong>
                <span class="text-slate-400 text-[11px]">Maksimal telaah diserahkan</span>
            </div>
        </div>

        <!-- Ringkasan Identitas Usulan & Tim Peneliti -->
        <div class="space-y-3 pt-2">
            <h3 class="text-sm font-bold text-slate-900 leading-5">{{ $review->proposal->judul }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-slate-600">
                <div>
                    <span class="text-slate-400">Ketua Tim:</span>
                    <strong class="text-slate-800 block">{{ $review->proposal->ketua->name }}</strong>
                    <span class="text-slate-500 text-[11px]">NIDN/NIP: {{ $review->proposal->ketua->nidn_nip ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400">Program Studi:</span>
                    <strong class="text-slate-800 block">{{ $review->proposal->prodi->nama_prodi }}</strong>
                    <span class="text-slate-500 text-[11px]">Jenjang {{ $review->proposal->prodi->jenjang }} ({{ $review->proposal->prodi->kode_prodi }})</span>
                </div>
                <div>
                    <span class="text-slate-400">Total Anggaran (RAB):</span>
                    <strong class="text-[#0B2A59] block font-bold">Rp {{ number_format($review->proposal->total_anggaran, 0, ',', '.') }}</strong>
                    <span class="text-slate-500 text-[11px]">{{ $review->proposal->sumber_dana ?? 'DIPA PKTJ' }}</span>
                </div>
            </div>
        </div>

        <!-- Kotak Persetujuan Penugasan & Tombol Setujui Review (PDF Hal. 16 & 18) -->
        @if(!$review->disetujui_review_at && $review->status_review !== 'selesai')
            <form method="POST" action="{{ route('reviewer.reviews.agree', $review) }}" class="p-4 bg-amber-50 border border-amber-200 rounded-xl space-y-3">
                @csrf
                <div class="flex items-start gap-3">
                    <input type="checkbox" name="persetujuan_komitmen" id="persetujuan_komitmen_agree" value="1" required class="mt-1 text-[#0B2A59] focus:ring-[#0B2A59] rounded">
                    <label for="persetujuan_komitmen_agree" class="text-xs text-amber-950 leading-5 cursor-pointer">
                        <strong>Kotak Persetujuan Review:</strong> Saya menyatakan bersedia menelaah usulan ini secara profesional, objektif, bebas dari benturan kepentingan, serta sanggup menyelesaikan penilaian sebelum batas waktu yang ditentukan.
                    </label>
                </div>
                <div class="pt-1 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-bold transition-all min-h-[44px] shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Setujui Review & Buka Lembar Penilaian</span>
                    </button>
                </div>
            </form>
        @else
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-xs text-emerald-900 leading-4">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Penugasan telah disetujui. Silakan mengisi formulir evaluasi rubrik penilaian, catatan revisi, dan konfirmasi hasil telaah di bawah ini.</span>
            </div>
        @endif
    </div>

    <!-- TAHAP 2, 3, & 4: REVIEW, ATRIBUT REVISI, & KONFIRMASI (PDF Hal. 16 & 18) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                    Tahap 2
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">
                    {{ $review->proposal->jenis === 'penelitian' ? 'Rubrik Penelitian (5 Kriteria)' : 'Rubrik Pengabdian (6 Kriteria)' }}
                </span>
            </div>
            <h2 class="text-xl font-bold text-[#0B2A59] leading-7 mt-2">Lembar Penilaian Mutu Usulan</h2>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Pilih skor mutu baku untuk setiap kriteria penilaian. Skala 6 tingkat baku: 1 (Buruk), 2 (Sangat Kurang), 3 (Kurang), 5 (Cukup), 6 (Baik), 7 (Sangat Baik). Skor 4 ditiadakan. Total nilai dihitung secara otomatis: Nilai = &Sigma;(Bobot &times; Skor).
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <strong>Mohon periksa kembali isian formulir:</strong>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $isPenelitian = ($review->proposal->jenis === 'penelitian');

            // Kriteria Penelitian (PDF Hal. 16)
            $kriteriaPenelitian = [
                1 => [
                    'nama' => 'Perumusan Masalah, Tujuan, dan Peta Jalan',
                    'bobot' => 15,
                    'desc' => 'Ketajaman perumusan masalah penelitian keselamatan transportasi, kejelasan tujuan, dan kesesuaian dengan Roadmap Penelitian PKTJ.'
                ],
                2 => [
                    'nama' => 'Luaran (Proses dan Produk)',
                    'bobot' => 35,
                    'desc' => 'Kebermaknaan target hasil: a) Produk/Kebijakan/Model/TTG, b) HKI Paten/Hak Cipta, c) Publikasi Ilmiah Berkala Nasional/Internasional.'
                ],
                3 => [
                    'nama' => 'Tinjauan Pustaka',
                    'bobot' => 15,
                    'desc' => 'Kedalaman studi pustaka, kemutakhiran referensi jurnal 5 tahun terakhir, rekam jejak kemajuan tim, dan studi pendahuluan.'
                ],
                4 => [
                    'nama' => 'Metode Penelitian',
                    'bobot' => 20,
                    'desc' => 'Desain ketepatan metode penelitian, keandalan instrumen uji laboratorium/lapangan, dan teknik analisis data.'
                ],
                5 => [
                    'nama' => 'Kelayakan Pelaksanaan',
                    'bobot' => 15,
                    'desc' => 'Kesesuaian jadwal kegiatan, kualifikasi/pembagian personalia tim, kewajaran rincian RAB, dan sarana laboratorium penunjang.'
                ],
            ];

            // Kriteria Pengabdian kepada Masyarakat (PDF Hal. 18)
            $kriteriaPengabdian = [
                1 => [
                    'nama' => 'Analisis Situasi',
                    'bobot' => 20,
                    'desc' => 'Kondisi riil mitra sasaran saat ini dan urgensi persoalan umum yang dihadapi mitra (sekolah, bengkel, karoseri, pengemudi, dsb).'
                ],
                2 => [
                    'nama' => 'Permasalahan Prioritas & Solusi',
                    'bobot' => 15,
                    'desc' => 'Ketajaman penetapan masalah prioritas mitra serta kesesuaian solusi teknologi/pelatihan dengan kompetensi keahlian tim dosen PKTJ.'
                ],
                3 => [
                    'nama' => 'Target Luaran',
                    'bobot' => 15,
                    'desc' => 'Jenis luaran dan ketepatan spesifikasi luaran yang dijanjikan sesuai kebutuhan nyata kegiatan pengabdian.'
                ],
                4 => [
                    'nama' => 'Ketepatan Metode Pendekatan',
                    'bobot' => 20,
                    'desc' => 'Efektivitas metode pendekatan pemecahan masalah, susunan rencana kegiatan, dan keaktifan partisipasi pihak mitra.'
                ],
                5 => [
                    'nama' => 'Kelayakan Institusi Perguruan Tinggi',
                    'bobot' => 10,
                    'desc' => 'Kualifikasi tim pelaksana, relevansi keahlian, sinergi peran, rekam jejak pengabdian, kewajaran jadwal, dan kelengkapan lampiran.'
                ],
                6 => [
                    'nama' => 'Kelayakan Usulan Anggaran Biaya',
                    'bobot' => 20,
                    'desc' => 'Kewajaran alokasi anggaran: bahan habis pakai, peralatan kerja, transportasi lapangan, dan operasional lain.'
                ],
            ];

            $daftarKriteria = $isPenelitian ? $kriteriaPenelitian : $kriteriaPengabdian;

            $skalaBaku = [
                1 => ['label' => '1 - Buruk', 'desc' => 'Tidak memenuhi standar'],
                2 => ['label' => '2 - Sangat Kurang', 'desc' => 'Sangat lemah'],
                3 => ['label' => '3 - Kurang', 'desc' => 'Banyak kekurangan'],
                5 => ['label' => '5 - Cukup', 'desc' => 'Memenuhi minimum'],
                6 => ['label' => '6 - Baik', 'desc' => 'Metode jelas & rapi'],
                7 => ['label' => '7 - Sangat Baik', 'desc' => 'Sangat inovatif'],
            ];
        @endphp

        <form method="POST" action="{{ route('reviewer.reviews.update', $review) }}" enctype="multipart/form-data" class="space-y-8" id="rubrikForm">
            @csrf
            @method('PUT')

            <!-- Loop Rubrik Kriteria Penilaian -->
            <div class="space-y-6">
                @foreach($daftarKriteria as $idx => $kriteria)
                    @php
                        $inputName = "kriteria_{$idx}";
                        $savedValue = old($inputName, $review->detail_nilai[$inputName] ?? null);
                    @endphp
                    <div class="p-5 border border-slate-200 rounded-2xl bg-slate-50/50 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/60 pb-3">
                            <div class="flex items-start gap-3">
                                <span class="w-7 h-7 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                                    {{ $idx }}
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 leading-5">{{ $kriteria['nama'] }}</h3>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-4">{{ $kriteria['desc'] }}</p>
                                </div>
                            </div>
                            <div class="sm:self-center pl-10 sm:pl-0 flex-shrink-0">
                                <span class="px-2.5 py-1 rounded bg-blue-100 text-[#0B2A59] text-xs font-bold leading-4">
                                    Bobot: {{ $kriteria['bobot'] }}%
                                </span>
                            </div>
                        </div>

                        <!-- Pilihan Radio Skor Baku (1, 2, 3, 5, 6, 7) -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5 pt-1">
                            @foreach($skalaBaku as $score => $scoreInfo)
                                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors text-center relative group min-h-[44px]">
                                    <input type="radio" name="{{ $inputName }}" value="{{ $score }}" data-bobot="{{ $kriteria['bobot'] / 100 }}" class="score-radio text-[#0B2A59] focus:ring-[#0B2A59]" {{ (string)$savedValue === (string)$score ? 'checked' : '' }} required>
                                    <span class="text-xs font-bold text-slate-800 mt-1 leading-4">{{ $scoreInfo['label'] }}</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5 leading-3">{{ $scoreInfo['desc'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Rekapitulasi Total Skor Akhir Dinamis -->
            <div class="p-6 bg-gradient-to-r from-slate-900 to-[#0B2A59] text-white rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-md">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-300 leading-4">Kalkulasi Skor Baku Berbobot</span>
                    <h3 class="text-base font-bold leading-6">Total Skor Usulan: &Sigma; (Bobot &times; Skor)</h3>
                    <p class="text-xs text-slate-300 leading-4">
                        Skala penilaian mutu baku 1.00 – 7.00.
                    </p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <span class="block text-xs text-slate-300 leading-4">Kualifikasi:</span>
                        <span class="text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4" id="kualifikasi_badge">
                            Menunggu Penilaian
                        </span>
                    </div>

                    <div class="w-px h-12 bg-white/20"></div>

                    <div class="text-right">
                        <span class="block text-xs text-slate-300 leading-4">Total Nilai:</span>
                        <div class="text-3xl sm:text-4xl font-black text-amber-400 leading-9 sm:leading-10">
                            <span id="grand_total_skor">0.00</span>
                            <span class="text-base text-slate-300 font-normal">/ 7.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAHAP 3: ATRIBUT REVISI & KOMENTAR PENILAI (PDF Hal. 16 & 18) -->
            <div class="space-y-6 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 3
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Atribut Revisi & Komentar Penilai</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Pilihan Rekomendasi (Revisi, Diterima, Ditolak) -->
                    <div class="md:col-span-1 space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">
                            Penetapan Rekomendasi: <span class="text-rose-500">*</span>
                        </label>

                        <div class="space-y-2">
                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors min-h-[44px]">
                                <input type="radio" name="rekomendasi" value="diterima" 
                                    {{ old('rekomendasi', $review->rekomendasi) === 'diterima' ? 'checked' : '' }} required
                                    class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                <div class="text-xs leading-4">
                                    <strong class="text-emerald-900 block font-bold">1. Diterima</strong>
                                    <span class="text-slate-500 text-[11px]">Usulan memenuhi syarat dan layak didanai.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors min-h-[44px]">
                                <input type="radio" name="rekomendasi" value="revisi" 
                                    {{ in_array(old('rekomendasi', $review->rekomendasi), ['revisi', 'diterima_dengan_revisi']) ? 'checked' : '' }} required
                                    class="mt-0.5 text-amber-600 focus:ring-amber-500">
                                <div class="text-xs leading-4">
                                    <strong class="text-amber-900 block font-bold">2. Revisi</strong>
                                    <span class="text-slate-500 text-[11px]">Pengusul wajib menyempurnakan naskah/RAB.</span>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors min-h-[44px]">
                                <input type="radio" name="rekomendasi" value="ditolak" 
                                    {{ old('rekomendasi', $review->rekomendasi) === 'ditolak' ? 'checked' : '' }} required
                                    class="mt-0.5 text-rose-600 focus:ring-rose-500">
                                <div class="text-xs leading-4">
                                    <strong class="text-rose-900 block font-bold">3. Ditolak</strong>
                                    <span class="text-slate-500 text-[11px]">Substansi belum memenuhi kualifikasi mutu minimum.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Unggah Berkas Tabel Catatan Revisi Word/PDF -->
                        <div class="pt-4 border-t border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800 leading-4">
                                Unggah Tabel Catatan Revisi (Word/PDF):
                            </label>
                            <p class="text-[11px] text-slate-500 leading-4">
                                Berkas tabel catatan perbaikan format Word (.doc, .docx) atau PDF (maks 10 MB).
                            </p>
                            <input type="file" name="file_catatan_revisi" accept=".doc,.docx,.pdf" class="text-xs text-slate-600 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer min-h-[44px]">
                            @if($review->file_catatan_revisi)
                                <div class="pt-1">
                                    <a href="{{ asset('storage/' . $review->file_catatan_revisi) }}" target="_blank" class="text-[11px] text-[#0B2A59] underline font-semibold">
                                        Unduh Lampiran Catatan Revisi Saat Ini
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Catatan Evaluasi Reviewer -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="space-y-1.5">
                            <label for="catatan_reviewer" class="block text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">
                                Komentar Penilai (Catatan Evaluasi): <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="catatan_reviewer" id="catatan_reviewer" rows="7" required minlength="10"
                                placeholder="Tuliskan ulasan kualitatif terkait metodologi, kelayakan anggaran belanja, maupun penguatan target luaran bagi pengusul..."
                                class="w-full p-3.5 border-slate-300 rounded-xl text-xs leading-5 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('catatan_reviewer', $review->catatan_reviewer) }}</textarea>
                            <p class="text-[11px] text-slate-400 leading-4">
                                Catatan ini akan diteruskan ke tim pengusul sebagai umpan balik akademik jika usulan memerlukan revisi.
                            </p>
                        </div>

                        <!-- Persetujuan Komitmen & Integritas -->
                        <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/50">
                            <label class="flex items-start gap-3 cursor-pointer min-h-[44px]">
                                <input type="checkbox" name="persetujuan_komitmen" value="1" required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59] rounded" {{ old('persetujuan_komitmen', $review->persetujuan_komitmen) ? 'checked' : '' }}>
                                <span class="text-xs text-slate-800 leading-5">
                                    <strong>Pernyataan Independensi & Integritas:</strong> Saya menyatakan bahwa penelaahan ini dilakukan secara independen, objektif, bebas dari benturan kepentingan, serta menjunjung tinggi standar etika keilmuan P3M PKTJ.
                                </span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <!-- TAHAP 4: KONFIRMASI (PDF Hal. 16 & 18) -->
            <div class="space-y-4 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">
                        Tahap 4
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Konfirmasi Penelaahan</span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                    <span class="text-xs font-bold text-slate-800 block">Apakah Anda mengonfirmasi hasil penilaian ini sudah final dan siap diserahkan ke P3M?</span>
                    <div class="flex flex-wrap items-center gap-6 text-xs">
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="setuju" {{ old('konfirmasi_hasil', $review->konfirmasi_hasil ?? 'setuju') === 'setuju' ? 'checked' : '' }} required class="text-[#0B2A59] focus:ring-[#0B2A59]">
                            <span class="font-bold text-emerald-900">Setuju (Konfirmasi dan Serahkan Hasil Telaah)</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer min-h-[44px]">
                            <input type="radio" name="konfirmasi_hasil" value="tidak_setuju" {{ old('konfirmasi_hasil', $review->konfirmasi_hasil) === 'tidak_setuju' ? 'checked' : '' }} required class="text-slate-600 focus:ring-slate-500">
                            <span class="font-medium text-slate-600">Tidak Setuju (Tunda Penyerahan)</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Aksi Simpan & Kirim -->
                <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-end gap-3">
                    <a href="{{ route('reviewer.dashboard') }}" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors text-center min-h-[44px] flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors text-center min-h-[44px] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Hasil Telaah Usulan</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<!-- JavaScript Kalkulasi Dinamis Rubrik Nilai 1-7 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioInputs = document.querySelectorAll('.score-radio');
    const elTotal = document.getElementById('grand_total_skor');
    const elBadge = document.getElementById('kualifikasi_badge');

    function calculateScore() {
        let total = 0;
        let checkedCount = 0;

        radioInputs.forEach(input => {
            if (input.checked) {
                const bobot = parseFloat(input.getAttribute('data-bobot')) || 0;
                const score = parseFloat(input.value) || 0;
                total += (score * bobot);
                checkedCount++;
            }
        });

        elTotal.textContent = total.toFixed(2);

        if (checkedCount === 0) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-slate-700 text-slate-300';
            elBadge.textContent = 'Menunggu Penilaian';
        } else if (total >= 5.5) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-emerald-500/20 text-emerald-300 border border-emerald-400/40';
            elBadge.textContent = 'Sangat Baik / Baik';
        } else if (total >= 4.0) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-amber-500/20 text-amber-300 border border-amber-400/40';
            elBadge.textContent = 'Cukup / Perlu Revisi';
        } else {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-rose-500/20 text-rose-300 border border-rose-400/40';
            elBadge.textContent = 'Kurang / Sangat Kurang';
        }
    }

    radioInputs.forEach(input => {
        input.addEventListener('change', calculateScore);
    });

    calculateScore();
});
</script>
@endsection
