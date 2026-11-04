@extends('layouts.dashboard')

@section('title', 'Instrumen Pemantauan dan Evaluasi (Monev) - ' . $proposal->kode_usulan)
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
                <span class="text-slate-700 font-semibold">Instrumen Monev</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Instrumen Pemantauan dan Evaluasi (Monev)</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 leading-4">Formulir evaluasi kemajuan kegiatan riset dan capaian luaran antara bagi tim pelaksana.</p>
        </div>

        <div>
            <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Usulan
            </a>
        </div>
    </div>

    <!-- Ringkasan Identitas Kegiatan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-600 leading-4">Identitas Usulan Kegiatan</h2>
        </div>
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-500 leading-4">Judul Kegiatan:</span>
            <h3 class="text-base font-bold text-slate-900 leading-6">{{ $proposal->judul }}</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs pt-2 border-t border-slate-100">
            <div>
                <span class="text-slate-500 block leading-4">Kode Usulan:</span>
                <strong class="text-[#0B2A59] leading-5">{{ $proposal->kode_usulan }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Program Studi Homebase:</span>
                <strong class="text-slate-800 leading-5">{{ $proposal->prodi->kode_prodi }} - {{ $proposal->prodi->nama_prodi }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Skema Pendanaan:</span>
                <strong class="text-slate-800 leading-5">{{ $proposal->skema }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Tahun Anggaran:</span>
                <strong class="text-slate-800 leading-5">T.A. {{ $proposal->tahun_anggaran }}</strong>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-2">
            <div class="font-bold flex items-center gap-2 text-sm leading-5">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Mohon Periksa Kembali Isian Formulir</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dosen.proposals.monev.store', $proposal) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- ==================== BAGIAN A: 7 BUTIR PILIHAN GANDA CAPAIAN ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian A</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">7 Butir Indikator Capaian Kinerja (Pilihan Ganda)</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Pilih opsi capaian kemajuan yang paling mencerminkan kondisi riil di lapangan.</p>
            </div>

            <div class="space-y-6">

                <!-- 1. Capaian Penelitian / Kegiatan Utama -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        1. Capaian Kegiatan Utama / Metodologi Riset <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Tingkat persentase ketercapaian target pelaksanaan tahapan kegiatan sampai saat ini.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach([
                            '25%' => '25% (Tahap awal persiapan & kajian teori)',
                            '50%' => '50% (Pengujian lapangan / eksperimen lab)',
                            '75%' => '75% (Analisis data & sintesis temuan)',
                            '100%' => '100% (Tahapan riset selesai menyeluruh)'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="capaian_penelitian" value="{{ $val }}" {{ old('capaian_penelitian') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Publikasi Ilmiah -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        2. Publikasi Ilmiah Berkala <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Status kesiapan naskah artikel ilmiah untuk dipublikasikan pada jurnal terakreditasi / bereputasi.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach([
                            'draft' => 'Draf Naskah Artikel Sedang Disusun',
                            'submitted' => 'Naskah Sudah Dikirim (Submitted)',
                            'under_review' => 'Dalam Penelaahan Reviewer (Under Review)',
                            'accepted' => 'Diterima Penerbit (Accepted / LoA)',
                            'published' => 'Artikel Telah Terbit (Published / DOI)'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="publikasi_ilmiah" value="{{ $val }}" {{ old('publikasi_ilmiah') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Sebagai Pemakalah dalam Pertemuan Ilmiah -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        3. Sebagai Pemakalah dalam Pertemuan Ilmiah <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Tingkat keikutsertaan diseminasi hasil pada konferensi / seminar nasional maupun internasional.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach([
                            'terdaftar' => 'Terdaftar Peserta Seminar',
                            'mengirim_abstrak' => 'Mengirimkan Abstrak Makalah',
                            'menyajikan_makalah' => 'Menyajikan Presentasi Makalah',
                            'prosiding_terbit' => 'Naskah Prosiding Terbit'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="pemakalah_ilmiah" value="{{ $val }}" {{ old('pemakalah_ilmiah') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Hak Kekayaan Intelektual (HKI) -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        4. Hak Kekayaan Intelektual (Paten / Hak Cipta) <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Tahapan permohonan perlindungan HKI atas karya inovasi transportasi ke Direktorat Jenderal KI.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach([
                            'penyiapan_dokumen' => 'Penyiapan Berkas Deskripsi Ciptaan / Paten',
                            'pendaftaran_djki' => 'Telah Diajukan ke DJKI (Nomor Permohonan)',
                            'sertifikat_terbit' => 'Sertifikat Perlindungan HKI Telah Terbit'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="hki" value="{{ $val }}" {{ old('hki') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Teknologi Tepat Guna (TTG) -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        5. Teknologi Tepat Guna (TTG) Transportasi <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Progres implementasi metode atau alat praktis yang diterapkan pada sektor transportasi jalan.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach([
                            'penjajakan' => 'Penjajakan Kebutuhan Lapangan',
                            'desain_alat' => 'Penyusunan Desain Teknis TTG',
                            'uji_lapangan' => 'Pengujian Lapangan di Mitra',
                            'terimplementasi' => 'Telah Dimanfaatkan Pengguna'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="teknologi_tepat_guna" value="{{ $val }}" {{ old('teknologi_tepat_guna') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 6. Produk / Model / Purwarupa / Rekayasa Sosial -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        6. Produk / Model / Purwarupa / Rekayasa Sistem <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Kesiapan wujud fisik purwarupa peralatan otomotif / rekayasa keselamatan jalan.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach([
                            'konseptual' => 'Arsitektur & Konsep Purwarupa',
                            'desain_teknis' => 'Rancang Bangun Komponen Teknis',
                            'prototipe_awal' => 'Purwarupa Awal Siap Uji Coba',
                            'produk_teruji' => 'Purwarupa Telah Lolos Uji Fungsi'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="produk_purwarupa" value="{{ $val }}" {{ old('produk_purwarupa') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 7. Buku Ajar / Monograf -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        7. Buku Ajar / Buku Monograf Ber-ISBN <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Progres penulisan materi hasil kegiatan menjadi buku referensi akademik vokasi.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach([
                            'outline' => 'Outline Bab & Rencana Isi',
                            'draf_naskah' => 'Penyusunan Draf Bab Naskah',
                            'editing' => 'Tahap Editing & Penataan Layout',
                            'isbn_terbit' => 'Buku Ber-ISBN Telah Terbit'
                        ] as $val => $label)
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 bg-white hover:border-[#0B2A59] cursor-pointer transition-colors">
                                <input type="radio" name="buku_ajar" value="{{ $val }}" {{ old('buku_ajar') === $val ? 'checked' : '' }} required class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                                <span class="text-xs text-slate-700 font-medium leading-4">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- ==================== BAGIAN B: 7 BUTIR ESSAI KESESUAIAN ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian B</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">7 Butir Evaluasi Pelaksanaan Kegiatan (Essai)</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Berikan deskripsi komprehensif, lugas, dan faktual terhadap seluruh aspek evaluasi berikut.</p>
            </div>

            <div class="space-y-5 text-xs">

                <!-- 1. Kegiatan Terlaksana -->
                <div class="space-y-1.5">
                    <label for="kegiatan_terlaksana" class="font-bold text-slate-800 leading-4 block">
                        8. Uraian Kegiatan yang Sudah Dilaksanakan Sampai Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Jelaskan tahapan riset atau kegiatan pengabdian yang telah selesai dieksekusi di lapangan.</p>
                    <textarea id="kegiatan_terlaksana" name="kegiatan_terlaksana" rows="4" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Contoh: Telah menyelesaikan pengujian sensor pengereman di lintasan sirkuit keselamatan PKTJ...">{{ old('kegiatan_terlaksana') }}</textarea>
                </div>

                <!-- 2. Kesesuaian Waktu -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_waktu" class="font-bold text-slate-800 leading-4 block">
                        9. Kesesuaian Waktu Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Jelaskan apakah kegiatan berjalan sesuai jadwal pada proposal. Berikan alasan komprehensif jika ada deviasi timeline.</p>
                    <textarea id="kesesuaian_waktu" name="kesesuaian_waktu" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Uraikan kesesuaian waktu atau kendala keterlambatan...">{{ old('kesesuaian_waktu') }}</textarea>
                </div>

                <!-- 3. Kesesuaian Metode -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_metode" class="font-bold text-slate-800 leading-4 block">
                        10. Kesesuaian Metode atau Rancangan Penelitian <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Uraikan apakah metode pengujian, sampling, atau pendekatan sesuai dengan usulan awal. Jelaskan penyesuaian teknis bila ada.</p>
                    <textarea id="kesesuaian_metode" name="kesesuaian_metode" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Uraikan keselarasan metodologi atau modifikasi teknis...">{{ old('kesesuaian_metode') }}</textarea>
                </div>

                <!-- 4. Kesesuaian Personalia -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_personalia" class="font-bold text-slate-800 leading-4 block">
                        11. Kesesuaian Kontribusi Personalia Tim <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Jelaskan peran nyata dan kontribusi aktif masing-masing anggota tim dosen serta taruna/mahasiswa pelaksana.</p>
                    <textarea id="kesesuaian_personalia" name="kesesuaian_personalia" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Jelaskan kontribusi ketua, dosen anggota, dan taruna...">{{ old('kesesuaian_personalia') }}</textarea>
                </div>

                <!-- 5. Kesesuaian Anggaran -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_anggaran" class="font-bold text-slate-800 leading-4 block">
                        12. Kesesuaian Anggaran dan Penyerapan Dana <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Uraikan persentase serapan biaya sampai saat ini terhadap rincian pos anggaran belanja proposal.</p>
                    <textarea id="kesesuaian_anggaran" name="kesesuaian_anggaran" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Uraikan realisasi anggaran bahan, perjalanan, atau honorarium...">{{ old('kesesuaian_anggaran') }}</textarea>
                </div>

                <!-- 6. Kesesuaian Sarana Prasarana -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_sarpras" class="font-bold text-slate-800 leading-4 block">
                        13. Kesesuaian Sarana dan Prasarana Penunjang <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Jelaskan dukungan fasilitas laboratorium pengujian, ketersediaan sarpras di PKTJ/mitra, atau kendala fasilitas.</p>
                    <textarea id="kesesuaian_sarpras" name="kesesuaian_sarpras" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Uraikan kondisi sarana prasarana pengujian...">{{ old('kesesuaian_sarpras') }}</textarea>
                </div>

                <!-- 7. Kesesuaian Target vs Realita -->
                <div class="space-y-1.5">
                    <label for="kesesuaian_target" class="font-bold text-slate-800 leading-4 block">
                        14. Kesesuaian Pelaksanaan dengan Usulan (Analisis Gap Target) <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-slate-500 leading-4">Berikan analisis komparasi antara target yang dijanjikan pada usulan awal dengan realitas lapangan dan rencana percepatan.</p>
                    <textarea id="kesesuaian_target" name="kesesuaian_target" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Uraikan gap target serta langkah tindak lanjut penyelesaian...">{{ old('kesesuaian_target') }}</textarea>
                </div>

            </div>
        </div>

        <!-- ==================== BAGIAN C: UNGGAH BUKTI & KONFIRMASI ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian C</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">Unggah Berkas Bukti Luaran & Konfirmasi</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Lampirkan bukti dukung sementara untuk verifikasi silang oleh tim penilai monev.</p>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        Berkas Bukti Luaran Sementara (PDF / ZIP)
                    </label>
                    <p class="text-xs text-slate-500 leading-4">
                        Dapat berupa: draf artikel jurnal, bukti tanda terima submit jurnal, bukti pendaftaran DJKI, foto dokumentasi purwarupa, atau materi monograf. Maksimal ukuran berkas 20 MB.
                    </p>
                    <input type="file" name="file_bukti_luaran" accept=".pdf,.zip,.rar" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
                </div>

                <div class="pt-2">
                    <label class="flex items-start gap-3 p-4 rounded-xl border border-blue-200 bg-blue-50/50 cursor-pointer">
                        <input type="checkbox" required name="pernyataan_integritas" value="1" class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59] rounded">
                        <span class="text-xs text-slate-800 leading-5">
                            <strong>Pernyataan Kebenaran Data:</strong> Saya menyatakan dengan sebenar-benarnya bahwa seluruh isian indikator capaian dan penjelasan evaluasi kemajuan kegiatan ini disusun berdasarkan kondisi faktual di lapangan serta dapat dipertanggungjawabkan kepada pengelola P3M PKTJ.
                        </span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center h-10 px-6 rounded-xl text-xs font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                    Kirimkan Instrumen Monev ke P3M
                </button>
            </div>
        </div>

    </form>

</div>
@endsection

