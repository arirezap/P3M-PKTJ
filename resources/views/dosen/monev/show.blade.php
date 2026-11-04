@extends('layouts.dashboard')

@section('title', 'Hasil Pemantauan dan Evaluasi (Monev) - ' . $proposal->kode_usulan)
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
                <span class="text-slate-700 font-semibold">Hasil Monev</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Hasil Pemantauan dan Evaluasi (Monev)</h1>
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

    <!-- Status Penilaian Monev -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Status Evaluasi Kemajuan (Monev)</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">Tanggal Pengiriman: {{ $monev->tanggal_monev ? $monev->tanggal_monev->translatedFormat('d F Y H:i') : '-' }} WIB</p>
            </div>
            <div>
                @php
                    $monevStatusClasses = [
                        'terkirim' => 'bg-blue-50 text-[#0B2A59] border-blue-200',
                        'proses_penilaian' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'dinilai' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                    ];
                    $monevStatusLabels = [
                        'terkirim' => 'Monev Terkirim ke P3M',
                        'proses_penilaian' => 'Sedang Dinilai Reviewer',
                        'dinilai' => 'Penilaian Selesai',
                    ];
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold leading-4 border {{ $monevStatusClasses[$monev->status_monev] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                    {{ $monevStatusLabels[$monev->status_monev] ?? ucfirst($monev->status_monev) }}
                </span>
            </div>
        </div>

        <!-- Progress Monev 3-Tahap (PDF Hal. 8: 1. Terkirim, 2. Proses Penilaian, 3. Selesai) -->
        @php
            $monevSteps = [
                1 => ['label' => '1. Terkirim', 'desc' => 'Monev tersimpan ke P3M'],
                2 => ['label' => '2. Proses Penilaian', 'desc' => 'Penelaahan oleh reviewer'],
                3 => ['label' => '3. Selesai', 'desc' => 'Nilai dan catatan terbit'],
            ];

            $currentMonevStep = match($monev->status_monev) {
                'terkirim' => 1,
                'proses_penilaian' => 2,
                'dinilai' => 3,
                default => 1,
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach($monevSteps as $mNum => $mInfo)
                @php
                    $isPassed = ($mNum <= $currentMonevStep);
                    $isCurrent = ($mNum === $currentMonevStep);
                @endphp
                <div class="p-3 rounded-xl border flex items-center gap-3 transition-colors {{ $isCurrent ? 'border-[#0B2A59] bg-blue-50/40 ring-1 ring-[#0B2A59]' : ($isPassed ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200 bg-slate-50 opacity-60') }}">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 {{ $isCurrent ? 'bg-[#0B2A59] text-white' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-700') }}">
                        @if($isPassed && !$isCurrent)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $mNum }}
                        @endif
                    </div>
                    <div>
                        <div class="text-xs font-bold leading-4 {{ $isCurrent ? 'text-[#0B2A59]' : ($isPassed ? 'text-emerald-900' : 'text-slate-700') }}">{{ $mInfo['label'] }}</div>
                        <div class="text-[10px] text-slate-500 leading-3 mt-0.5">{{ $mInfo['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($monev->total_skor_monev !== null || $monev->catatan_reviewer)
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800">Ulasan & Rekomendasi Reviewer:</span>
                    @if($monev->total_skor_monev !== null)
                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-[#0B2A59] text-white">
                            Skor Monev: {{ number_format($monev->total_skor_monev, 1) }}
                        </span>
                    @endif
                </div>
                @if($monev->catatan_reviewer)
                    <p class="text-xs text-slate-700 leading-5 bg-white p-3 rounded-lg border border-slate-200 whitespace-pre-line">
                        {{ $monev->catatan_reviewer }}
                    </p>
                @endif
            </div>
        @else
            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-200 text-xs text-slate-700 leading-5">
                Instrumen monev telah tersimpan pada basis data P3M. Evaluasi penilai internal PKTJ akan ditampilkan di halaman ini setelah proses visitasi/penilaian selesai.
            </div>
        @endif
    </div>

    <!-- Rekapitulasi 7 Butir Capaian Pilihan Ganda -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Rekapitulasi 7 Butir Capaian Kinerja</h2>
        </div>

        @php
            $pgLabels = [
                'capaian_penelitian' => [
                    'title' => '1. Capaian Kegiatan Utama / Riset',
                    'values' => [
                        '25%' => '25% (Tahap awal persiapan & kajian teori)',
                        '50%' => '50% (Pengujian lapangan / eksperimen lab)',
                        '75%' => '75% (Analisis data & sintesis temuan)',
                        '100%' => '100% (Tahapan riset selesai menyeluruh)'
                    ]
                ],
                'publikasi_ilmiah' => [
                    'title' => '2. Publikasi Ilmiah Berkala',
                    'values' => [
                        'draft' => 'Draf Naskah Artikel Sedang Disusun',
                        'submitted' => 'Naskah Sudah Dikirim (Submitted)',
                        'under_review' => 'Dalam Penelaahan Reviewer (Under Review)',
                        'accepted' => 'Diterima Penerbit (Accepted / LoA)',
                        'published' => 'Artikel Telah Terbit (Published / DOI)'
                    ]
                ],
                'pemakalah_ilmiah' => [
                    'title' => '3. Pemakalah dalam Pertemuan Ilmiah',
                    'values' => [
                        'terdaftar' => 'Terdaftar Peserta Seminar',
                        'mengirim_abstrak' => 'Mengirimkan Abstrak Makalah',
                        'menyajikan_makalah' => 'Menyajikan Presentasi Makalah',
                        'prosiding_terbit' => 'Naskah Prosiding Terbit'
                    ]
                ],
                'hki' => [
                    'title' => '4. Hak Kekayaan Intelektual (HKI)',
                    'values' => [
                        'penyiapan_dokumen' => 'Penyiapan Berkas Deskripsi Ciptaan / Paten',
                        'pendaftaran_djki' => 'Telah Diajukan ke DJKI (Nomor Permohonan)',
                        'sertifikat_terbit' => 'Sertifikat Perlindungan HKI Telah Terbit'
                    ]
                ],
                'teknologi_tepat_guna' => [
                    'title' => '5. Teknologi Tepat Guna (TTG)',
                    'values' => [
                        'penjajakan' => 'Penjajakan Kebutuhan Lapangan',
                        'desain_alat' => 'Penyusunan Desain Teknis TTG',
                        'uji_lapangan' => 'Pengujian Lapangan di Mitra',
                        'terimplementasi' => 'Telah Dimanfaatkan Pengguna'
                    ]
                ],
                'produk_purwarupa' => [
                    'title' => '6. Produk / Purwarupa / Rekayasa',
                    'values' => [
                        'konseptual' => 'Arsitektur & Konsep Purwarupa',
                        'desain_teknis' => 'Rancang Bangun Komponen Teknis',
                        'prototipe_awal' => 'Purwarupa Awal Siap Uji Coba',
                        'produk_teruji' => 'Purwarupa Telah Lolos Uji Fungsi'
                    ]
                ],
                'buku_ajar' => [
                    'title' => '7. Buku Ajar / Monograf',
                    'values' => [
                        'outline' => 'Outline Bab & Rencana Isi',
                        'draf_naskah' => 'Penyusunan Draf Bab Naskah',
                        'editing' => 'Tahap Editing & Penataan Layout',
                        'isbn_terbit' => 'Buku Ber-ISBN Telah Terbit'
                    ]
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            @foreach($pgLabels as $field => $info)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-1">
                    <span class="text-slate-500 font-semibold block leading-4">{{ $info['title'] }}</span>
                    <strong class="text-slate-900 leading-5 block text-xs">
                        {{ $info['values'][$monev->$field] ?? $monev->$field }}
                    </strong>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Rekapitulasi 7 Butir Essai Evaluasi Pelaksanaan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 leading-4">Uraian Evaluasi Pelaksanaan (7 Butir Essai)</h2>
        </div>

        <div class="space-y-4 text-xs">
            @php
                $essayItems = [
                    'kegiatan_terlaksana' => '8. Uraian Kegiatan yang Sudah Dilaksanakan',
                    'kesesuaian_waktu' => '9. Kesesuaian Waktu Penelitian',
                    'kesesuaian_metode' => '10. Kesesuaian Metode atau Rancangan Penelitian',
                    'kesesuaian_personalia' => '11. Kesesuaian Kontribusi Personalia Tim',
                    'kesesuaian_anggaran' => '12. Kesesuaian Anggaran dan Penyerapan Biaya',
                    'kesesuaian_sarpras' => '13. Kesesuaian Sarana dan Prasarana Penunjang',
                    'kesesuaian_target' => '14. Kesesuaian Pelaksanaan dengan Usulan (Analisis Gap Target)',
                ];
            @endphp

            @foreach($essayItems as $key => $title)
                <div class="p-4 rounded-xl border border-slate-200 space-y-2">
                    <span class="font-bold text-[#0B2A59] block leading-4">{{ $title }}</span>
                    <p class="text-slate-700 leading-5 whitespace-pre-line bg-slate-50 p-3 rounded-lg border border-slate-100">
                        {{ $monev->$key }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Lampiran Berkas Luaran Sementara -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">Berkas Bukti Luaran Sementara</h3>
            <p class="text-xs text-slate-500 mt-1 leading-4">Dokumen fisik pendukung capaian antara yang diunggah saat pelaporan monev.</p>
        </div>
        <div>
            @if($monev->file_bukti_luaran)
                <a href="{{ asset('storage/' . $monev->file_bukti_luaran) }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Berkas Bukti Luaran</span>
                </a>
            @else
                <span class="text-xs text-slate-400 italic">Tidak ada berkas tambahan yang diunggah.</span>
            @endif
        </div>
    </div>

</div>
@endsection

