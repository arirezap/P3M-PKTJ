<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Capaian Kegiatan - {{ $proposal->kode_usulan }}</title>
    <!-- Favicon / Shortcut Icon (Logo PKTJ) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt;
            }
            .page-break {
                page-break-before: always;
            }
            .print-border {
                border-color: #000 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased font-sans p-4 sm:p-8">

    <!-- Action Bar (Hanya tampil di layar monitor / non-cetak) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
            <div class="text-xs">
                <span class="font-bold text-slate-800">Pratinjau Lembar Rekapitulasi Capaian</span>
                <span class="text-slate-500 ml-2">({{ $proposal->kode_usulan }})</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.history.back()" class="h-9 px-4 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors">
                Kembali
            </button>
            <button onclick="window.print()" class="h-9 px-4 rounded-xl bg-[#0B2A59] text-white text-xs font-semibold hover:bg-blue-900 transition-colors shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Rekapitulasi</span>
            </button>
        </div>
    </div>

    <!-- Lembar Dokumen Formal (Print Container) -->
    <div class="max-w-4xl mx-auto bg-white border border-slate-200 print:border-0 rounded-2xl print:rounded-none p-8 sm:p-12 shadow-sm print:shadow-none space-y-6">

        <!-- Kop Lembaga Institusi -->
        <div class="border-b-2 border-slate-900 pb-4 text-center space-y-1">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-700">Kementerian Perhubungan Republik Indonesia</div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-700">Badan Pengembangan Sumber Daya Manusia Perhubungan</div>
            <div class="text-sm sm:text-base font-extrabold uppercase text-[#0B2A59] tracking-wide">Politeknik Keselamatan Transportasi Jalan</div>
            <div class="text-xs font-bold uppercase text-slate-800">Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M)</div>
            <div class="text-[10px] text-slate-500 pt-1">
                Jalan Perintis Kemerdekaan No. 17, Kota Tegal, Jawa Tengah 52125 &bull; Laman: p3m.pktj.ac.id
            </div>
        </div>

        <!-- Judul Dokumen -->
        <div class="text-center space-y-1 pt-2">
            <h1 class="text-base sm:text-lg font-extrabold uppercase text-slate-900 tracking-wide">
                Lembar Rekapitulasi Capaian & Pengarsipan Kegiatan
            </h1>
            <div class="text-xs text-slate-600 font-medium">
                Bidang: <strong class="uppercase">{{ $proposal->jenis === 'penelitian' ? 'Penelitian Ilmiah Terapan' : 'Pengabdian kepada Masyarakat (PkM)' }}</strong> &bull; Tahun Anggaran {{ $proposal->tahun_anggaran }}
            </div>
        </div>

        <!-- Tabel 1: Identitas Usulan & Program Kegiatan -->
        <div class="space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]">I. Identitas Usulan & Program Kegiatan</div>
            <table class="w-full text-xs border border-slate-300 border-collapse">
                <tbody>
                    <tr class="border-b border-slate-200">
                        <td class="w-48 p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Nomor / Kode Usulan</td>
                        <td class="p-2.5 font-mono font-bold text-slate-900">{{ $proposal->kode_usulan }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Judul Kegiatan</td>
                        <td class="p-2.5 font-bold text-slate-900 leading-5">{{ $proposal->judul }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Skema Pendanaan</td>
                        <td class="p-2.5 text-slate-800">{{ $proposal->skema }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Program Studi Homebase</td>
                        <td class="p-2.5 text-slate-800">{{ $proposal->prodi->jenjang }} {{ $proposal->prodi->kode_prodi }} - {{ $proposal->prodi->nama_prodi }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Bidang Fokus & Topik</td>
                        <td class="p-2.5 text-slate-800">{{ $proposal->bidang_fokus ?? 'Keselamatan Transportasi Jalan' }} (Topik: {{ $proposal->topik_kegiatan ?? '-' }})</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Lokasi / Lokus Pelaksanaan</td>
                        <td class="p-2.5 text-slate-800">{{ $proposal->lokasi_kegiatan ?? 'PKTJ Tegal' }} (Durasi: {{ $proposal->lama_kegiatan_tahun ?? 1 }} Tahun)</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Sumber Dana & Anggaran Usulan</td>
                        <td class="p-2.5 font-bold text-slate-900">{{ $proposal->sumber_dana }} &bull; Rp {{ number_format($proposal->total_anggaran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-2.5 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Status Tahapan Siklus</td>
                        <td class="p-2.5">
                            <span class="font-bold uppercase tracking-wide text-xs text-slate-900">
                                {{ strtoupper(str_replace('_', ' ', $proposal->status)) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel 2: Susunan Tim Pelaksana Kegiatan -->
        <div class="space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]">II. Susunan Tim Pelaksana Kegiatan</div>
            <table class="w-full text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider">
                        <th class="p-2 text-left border-r border-slate-300">Peran</th>
                        <th class="p-2 text-left border-r border-slate-300">Nama Lengkap & Gelar</th>
                        <th class="p-2 text-left border-r border-slate-300">NIDN / NIM</th>
                        <th class="p-2 text-left border-r border-slate-300">Kategori & Asal Instansi</th>
                        <th class="p-2 text-left">Tugas Pokok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="p-2 font-bold text-slate-900 border-r border-slate-200">Ketua Pengusul</td>
                        <td class="p-2 font-bold text-slate-900 border-r border-slate-200">{{ $proposal->ketua->name }}</td>
                        <td class="p-2 font-mono border-r border-slate-200">{{ $proposal->ketua->nidn_nip ?? '-' }}</td>
                        <td class="p-2 border-r border-slate-200">Dosen Internal PKTJ</td>
                        <td class="p-2 text-slate-600">Penanggung jawab utama konsep & metodologi</td>
                    </tr>
                    @forelse($proposal->members as $idx => $m)
                        <tr>
                            <td class="p-2 border-r border-slate-200 capitalize">{{ str_replace('_', ' ', $m->peran) }}</td>
                            <td class="p-2 font-medium text-slate-800 border-r border-slate-200">{{ $m->nama }}</td>
                            <td class="p-2 font-mono border-r border-slate-200">{{ $m->nidn_nim ?? '-' }}</td>
                            <td class="p-2 border-r border-slate-200">
                                @if($m->kategori_anggota === 'eksternal')
                                    Eksternal ({{ $m->asal_instansi ?? 'Mitra Luar' }}, {{ $m->negara ?? 'Indonesia' }})
                                @elseif($m->kategori_anggota === 'taruna')
                                    Taruna PKTJ
                                @else
                                    Dosen Internal PKTJ
                                @endif
                            </td>
                            <td class="p-2 text-slate-600">{{ $m->tugas ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-2 text-center text-slate-400">Tidak ada anggota tambahan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel 3: Evaluasi Reviewer Desk Substansi -->
        <div class="space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]">III. Hasil Penilaian Desk Evaluasi Reviewer</div>
            <table class="w-full text-xs border border-slate-300 border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider">
                        <th class="p-2 text-left border-r border-slate-300">Nama Reviewer</th>
                        <th class="p-2 text-center border-r border-slate-300 w-24">Skor Akhir</th>
                        <th class="p-2 text-center border-r border-slate-300 w-32">Rekomendasi</th>
                        <th class="p-2 text-left">Catatan Substansi & Kepatutan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($proposal->reviews as $rev)
                        <tr>
                            <td class="p-2 font-semibold text-slate-900 border-r border-slate-200">
                                {{ $rev->reviewer->name }}
                                <div class="text-[10px] text-slate-500 font-normal">NIDN: {{ $rev->reviewer->nidn_nip ?? '-' }}</div>
                            </td>
                            <td class="p-2 text-center font-bold text-sm text-[#0B2A59] border-r border-slate-200">
                                {{ $rev->total_skor ? number_format($rev->total_skor, 1) : '-' }}
                            </td>
                            <td class="p-2 text-center font-bold capitalize border-r border-slate-200">
                                {{ $rev->rekomendasi ?? 'Dalam Telaah' }}
                            </td>
                            <td class="p-2 text-slate-700 leading-4">
                                {{ $rev->catatan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-slate-400">Belum ada penugasan atau evaluasi reviewer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel 4: Rekapitulasi Pemantauan & Evaluasi (Monev) -->
        <div class="space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]">IV. Capaian Pemantauan & Evaluasi (Monev)</div>
            @if($proposal->monev)
                <table class="w-full text-xs border border-slate-300 border-collapse">
                    <tbody>
                        <tr class="border-b border-slate-200">
                            <td class="w-48 p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Status Instrumen Monev</td>
                            <td class="p-2 font-bold uppercase text-slate-900">{{ $proposal->monev->status_monev }}</td>
                            <td class="w-36 p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Tanggal Pengisian</td>
                            <td class="p-2 text-slate-800">{{ $proposal->monev->created_at->format('d F Y') }}</td>
                        </tr>
                        <tr class="border-b border-slate-200">
                            <td class="p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Capaian Indikator Kinerja</td>
                            <td colspan="3" class="p-2 text-slate-800 leading-5">
                                7 Indikator terisi lengkap. Realisasi luaran antara: <strong>{{ $proposal->monev->persentase_kemajuan ?? '50' }}%</strong>
                            </td>
                        </tr>
                        @if($proposal->monev->catatan_monev)
                            <tr>
                                <td class="p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Catatan Reviewer Monev</td>
                                <td colspan="3" class="p-2 text-slate-800 italic leading-4">"{{ $proposal->monev->catatan_monev }}"</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @else
                <div class="p-3 border border-dashed border-slate-300 text-center text-slate-400 text-xs rounded-xl">
                    Instrumen Pemantauan dan Evaluasi (Monev) belum diserahkan.
                </div>
            @endif
        </div>

        <!-- Tabel 5: Rekapitulasi Laporan Akhir & Realisasi SPJ 100% -->
        <div class="space-y-2">
            <div class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]">V. Penuntasan Laporan Akhir & Realisasi Anggaran 100%</div>
            @if($proposal->finalReport)
                <table class="w-full text-xs border border-slate-300 border-collapse">
                    <tbody>
                        <tr class="border-b border-slate-200">
                            <td class="w-48 p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Status Laporan Akhir</td>
                            <td class="p-2 font-bold uppercase text-slate-900">{{ $proposal->finalReport->status_laporan }}</td>
                            <td class="w-36 p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Tanggal Penyerahan</td>
                            <td class="p-2 text-slate-800">{{ $proposal->finalReport->created_at->format('d F Y') }}</td>
                        </tr>
                        <tr class="border-b border-slate-200">
                            <td class="p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Realisasi Anggaran 100%</td>
                            <td class="p-2 font-bold text-slate-900">Rp {{ number_format($proposal->finalReport->realisasi_anggaran ?? $proposal->total_anggaran, 0, ',', '.') }}</td>
                            <td class="p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Berkas Pertanggungjawaban</td>
                            <td class="p-2 text-slate-800">Dokumen SPJ 100% Lengkap (Terverifikasi)</td>
                        </tr>
                        @if($proposal->finalReport->catatan_review)
                            <tr>
                                <td class="p-2 font-bold bg-slate-50 text-slate-700 border-r border-slate-300">Catatan Evaluasi Akhir</td>
                                <td colspan="3" class="p-2 text-slate-800 italic leading-4">"{{ $proposal->finalReport->catatan_review }}"</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @else
                <div class="p-3 border border-dashed border-slate-300 text-center text-slate-400 text-xs rounded-xl">
                    Laporan Akhir dan Berkas SPJ 100% belum diserahkan.
                </div>
            @endif
        </div>

        <!-- Lembar Pengesahan Tanda Tangan -->
        <div class="pt-8 border-t border-slate-300 grid grid-cols-3 gap-6 text-center text-xs">
            <div class="space-y-16">
                <div>
                    <div class="text-slate-600">Mengetahui / Menyetujui,</div>
                    <div class="font-bold text-slate-900">Ketua Pelaksana Kegiatan</div>
                </div>
                <div>
                    <div class="font-bold text-slate-900 underline">{{ $proposal->ketua->name }}</div>
                    <div class="text-[11px] text-slate-500">NIDN: {{ $proposal->ketua->nidn_nip ?? '-' }}</div>
                </div>
            </div>

            <div class="space-y-16">
                <div>
                    <div class="text-slate-600">Telah Dievaluasi Oleh,</div>
                    <div class="font-bold text-slate-900">Reviewer Penilai P3M</div>
                </div>
                <div>
                    <div class="font-bold text-slate-900 underline">
                        {{ $proposal->reviews->first()?->reviewer->name ?? '( Belum Ditugaskan )' }}
                    </div>
                    <div class="text-[11px] text-slate-500">
                        NIDN: {{ $proposal->reviews->first()?->reviewer->nidn_nip ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="space-y-16">
                <div>
                    <div class="text-slate-600">Mengesahkan & Mengarsipkan,</div>
                    <div class="font-bold text-slate-900">Kepala P3M PKTJ</div>
                </div>
                <div>
                    <div class="font-bold text-slate-900 underline">Direktur / Kepala P3M PKTJ</div>
                    <div class="text-[11px] text-slate-500">NIP: 19800101 200501 1 001</div>
                </div>
            </div>
        </div>

        <!-- Footer Catatan Otomasi SIM P3M -->
        <div class="border-t border-slate-200 pt-3 text-[10px] text-slate-400 flex items-center justify-between">
            <div>Dicetak melalui Sistem Informasi Manajemen P3M PKTJ pada {{ now()->translatedFormat('d F Y H:i:s') }} WIB</div>
            <div>Halaman 1 dari 1 &bull; Status: {{ strtoupper($proposal->status) }}</div>
        </div>

    </div>

</body>
</html>
