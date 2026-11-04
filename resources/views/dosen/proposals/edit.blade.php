@extends('layouts.dashboard')

@section('title', 'Ubah Usulan: ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-6" x-data="{
    step: 1,
    totalSteps: 8,
    jenis: '{{ old('jenis', $proposal->jenis) }}',
    skemaListPenelitian: [
        'Penelitian Terapan Vokasi Keselamatan Transportasi',
        'Penelitian Dosen Pemula (PDP)',
        'Penelitian Unggulan Manajemen Rekayasa Lalu Lintas',
        'Penelitian Kerjasama Industri Otomotif'
    ],
    skemaListPengabdian: [
        'Pengabdian Kemitraan Masyarakat (PKM)',
        'Pemberdayaan Desa Binaan Vokasi Transportasi',
        'Sosialisasi & Edukasi Budaya Keselamatan Jalan'
    ],
    skema: '{{ old('skema', $proposal->skema) }}',
    lamaKegiatanTahun: {{ (int) old('lama_kegiatan_tahun', $proposal->lama_kegiatan_tahun ?? 1) }},

    // Sub Menu 2: Anggota Tim Dinamis
    members: [
        @if(old('members'))
            @foreach(old('members') as $m)
                {
                    nama: '{{ addslashes($m['nama']) }}',
                    peran: '{{ $m['peran'] }}',
                    kategori_anggota: '{{ $m['kategori_anggota'] ?? 'internal' }}',
                    asal_instansi: '{{ addslashes($m['asal_instansi'] ?? '') }}',
                    negara: '{{ addslashes($m['negara'] ?? 'Indonesia') }}',
                    nidn_nim: '{{ addslashes($m['nidn_nim'] ?? '') }}',
                    jabatan_fungsional: '{{ addslashes($m['jabatan_fungsional'] ?? '') }}',
                    prodi: '{{ addslashes($m['prodi'] ?? '') }}',
                    angkatan: '{{ addslashes($m['angkatan'] ?? '') }}',
                    tugas: '{{ addslashes($m['tugas'] ?? '') }}'
                },
            @endforeach
        @else
            @foreach($proposal->members as $m)
                {
                    nama: '{{ addslashes($m->nama) }}',
                    peran: '{{ $m->peran }}',
                    kategori_anggota: '{{ $m->kategori_anggota ?? 'internal' }}',
                    asal_instansi: '{{ addslashes($m->asal_instansi ?? '') }}',
                    negara: '{{ addslashes($m->negara ?? 'Indonesia') }}',
                    nidn_nim: '{{ addslashes($m->nidn_nim ?? '') }}',
                    jabatan_fungsional: '',
                    prodi: '',
                    angkatan: '',
                    tugas: '{{ addslashes($m->tugas ?? '') }}'
                },
            @endforeach
        @endif
    ],
    addMember(peran = 'dosen_anggota', kategori = 'internal') {
        const instansi = (kategori === 'eksternal') ? '' : 'Politeknik Keselamatan Transportasi Jalan';
        this.members.push({
            nama: '',
            peran: peran,
            kategori_anggota: kategori,
            asal_instansi: instansi,
            negara: 'Indonesia',
            nidn_nim: '',
            jabatan_fungsional: '',
            prodi: '',
            angkatan: '',
            tugas: ''
        });
    },
    removeMember(index) {
        this.members.splice(index, 1);
    },
    selectDosen(index, event) {
        const option = event.target.selectedOptions[0];
        if (option && option.value) {
            this.members[index].nama = option.dataset.name || '';
            this.members[index].nidn_nim = option.dataset.nidn || '';
            this.members[index].kategori_anggota = 'internal';
            this.members[index].asal_instansi = 'Politeknik Keselamatan Transportasi Jalan';
            this.members[index].negara = 'Indonesia';
            this.members[index].prodi = option.dataset.prodi || '';
        }
    },

    // Sub Menu 4: Luaran & Target Dinamis
    luaran: [
        @if(old('luaran_target'))
            @foreach(old('luaran_target') as $l)
                { jenis: '{{ addslashes($l['jenis']) }}', keterangan: '{{ addslashes($l['keterangan'] ?? '') }}' },
            @endforeach
        @elseif(!empty($proposal->luaran_target))
            @foreach($proposal->luaran_target as $l)
                { jenis: '{{ addslashes($l['jenis'] ?? 'Jurnal Nasional') }}', keterangan: '{{ addslashes($l['keterangan'] ?? '') }}' },
            @endforeach
        @else
            { jenis: 'Jurnal Nasional', keterangan: 'Artikel ilmiah terakreditasi Sinta 2 / Sinta 3' },
            { jenis: 'HKI', keterangan: 'Pencatatan Hak Cipta perangkat lunak / model panduan' }
        @endif
    ],
    addLuaran(jenis = 'Jurnal Nasional') {
        this.luaran.push({ jenis: jenis, keterangan: '' });
    },
    removeLuaran(index) {
        this.luaran.splice(index, 1);
    },

    // Sub Menu 5: Rencana Anggaran Biaya (RAB) Dinamis
    budgets: [
        @if(old('budgets'))
            @foreach(old('budgets') as $b)
                {
                    kategori_belanja: '{{ $b['kategori_belanja'] }}',
                    tahun_ke: {{ (int) ($b['tahun_ke'] ?? 1) }},
                    uraian: '{{ addslashes($b['uraian']) }}',
                    volume: {{ (float) $b['volume'] }},
                    satuan: '{{ addslashes($b['satuan']) }}',
                    harga_satuan: {{ (float) $b['harga_satuan'] }}
                },
            @endforeach
        @elseif($proposal->budgets->isNotEmpty())
            @foreach($proposal->budgets as $b)
                {
                    kategori_belanja: '{{ $b->kategori_belanja }}',
                    tahun_ke: {{ (int) ($b->tahun_ke ?? 1) }},
                    uraian: '{{ addslashes($b->uraian) }}',
                    volume: {{ (float) $b->volume }},
                    satuan: '{{ addslashes($b->satuan) }}',
                    harga_satuan: {{ (float) $b->harga_satuan }}
                },
            @endforeach
        @else
            { kategori_belanja: 'bahan_habis_pakai', tahun_ke: 1, uraian: 'Kertas HVS, Tinta & ATK Administrasi', volume: 1, satuan: 'Paket', harga_satuan: 1500000 },
            { kategori_belanja: 'perjalanan_lapangan', tahun_ke: 1, uraian: 'Survei dan Pengambilan Data Lapangan', volume: 2, satuan: 'Hari', harga_satuan: 1200000 }
        @endif
    ],
    addBudget(kategori = 'bahan_habis_pakai') {
        this.budgets.push({ kategori_belanja: kategori, tahun_ke: 1, uraian: '', volume: 1, satuan: 'Paket', harga_satuan: 0 });
    },
    removeBudget(index) {
        this.budgets.splice(index, 1);
    },
    calculateSubtotal(b) {
        const vol = parseFloat(b.volume) || 0;
        const harga = parseFloat(b.harga_satuan) || 0;
        return vol * harga;
    },
    get grandTotal() {
        return this.budgets.reduce((total, b) => total + this.calculateSubtotal(b), 0);
    },

    // Sub Menu 6: Jadwal Kegiatan Dinamis
    jadwal: [
        @if(old('jadwal_kegiatan'))
            @foreach(old('jadwal_kegiatan') as $j)
                {
                    nama_kegiatan: '{{ addslashes($j['nama_kegiatan']) }}',
                    tahun: {{ (int) ($j['tahun'] ?? 1) }},
                    tanggal_mulai: '{{ $j['tanggal_mulai'] ?? '' }}',
                    tanggal_selesai: '{{ $j['tanggal_selesai'] ?? '' }}'
                },
            @endforeach
        @elseif(!empty($proposal->jadwal_kegiatan))
            @foreach($proposal->jadwal_kegiatan as $j)
                {
                    nama_kegiatan: '{{ addslashes($j['nama_kegiatan'] ?? '') }}',
                    tahun: {{ (int) ($j['tahun'] ?? 1) }},
                    tanggal_mulai: '{{ $j['tanggal_mulai'] ?? '' }}',
                    tanggal_selesai: '{{ $j['tanggal_selesai'] ?? '' }}'
                },
            @endforeach
        @else
            { nama_kegiatan: 'Persiapan, Studi Literatur & Koordinasi Tim', tahun: 1, tanggal_mulai: '', tanggal_selesai: '' },
            { nama_kegiatan: 'Pelaksanaan Pengujian & Pengambilan Data', tahun: 1, tanggal_mulai: '', tanggal_selesai: '' },
            { nama_kegiatan: 'Analisis Data & Penyusunan Laporan Hasil', tahun: 1, tanggal_mulai: '', tanggal_selesai: '' }
        @endif
    ],
    addJadwal() {
        this.jadwal.push({ nama_kegiatan: '', tahun: 1, tanggal_mulai: '', tanggal_selesai: '' });
    },
    removeJadwal(index) {
        this.jadwal.splice(index, 1);
    },

    // Sub Menu 8: Konfirmasi
    persetujuan: '{{ old('persetujuan_konfirmasi', $proposal->persetujuan_konfirmasi ? '1' : '1') }}',

    formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }
}">

    <!-- Breadcrumb & Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('dosen.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Dasbor Usulan</a>
                <span>/</span>
                <a href="{{ route('dosen.proposals.show', $proposal) }}" class="hover:text-[#0B2A59] hover:underline">{{ $proposal->kode_usulan }}</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Ubah Usulan</span>
            </div>
            <h1 class="text-2xl font-bold text-[#0B2A59] mt-1 leading-8">Ubah Data Usulan: {{ $proposal->kode_usulan }}</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Perbarui isian 8 sub-menu usulan kegiatan ilmiah sebelum proses telaah dilanjutkan.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Batal & Kembali
            </a>
        </div>
    </div>

    <!-- Stepper 8 Sub-Menu (PDF Hal. 5-7 & 10-12) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm overflow-x-auto">
        <div class="flex items-center gap-2 min-w-max">
            @php
                $submenus = [
                    1 => ['title' => 'Identitas Usulan', 'desc' => 'Skema, judul, data rekening'],
                    2 => ['title' => 'Anggota Tim', 'desc' => 'Internal, eksternal, taruna'],
                    3 => ['title' => 'Atribut Usulan', 'desc' => 'Unggah naskah proposal'],
                    4 => ['title' => 'Luaran & Target', 'desc' => 'Jurnal, HKI, produk/jasa'],
                    5 => ['title' => 'Rencana Anggaran', 'desc' => 'Rincian anggaran belanja'],
                    6 => ['title' => 'Jadwal Kegiatan', 'desc' => 'Matriks jadwal tahapan'],
                    7 => ['title' => 'Kelengkapan Lain', 'desc' => 'Mitra & dana tambahan'],
                    8 => ['title' => 'Konfirmasi', 'desc' => 'Persetujuan & pengiriman'],
                ];
            @endphp

            @foreach($submenus as $sNum => $sData)
                <button type="button" @click="step = {{ $sNum }}"
                        :class="step === {{ $sNum }} ? 'border-[#0B2A59] bg-blue-50/60 text-[#0B2A59] ring-1 ring-[#0B2A59]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                        class="p-2.5 px-3 rounded-xl border text-left transition-colors flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center font-bold text-xs"
                         :class="step === {{ $sNum }} ? 'bg-[#0B2A59] text-white' : 'bg-slate-200 text-slate-700'">
                        {{ $sNum }}
                    </div>
                    <div class="hidden md:block">
                        <div class="text-xs font-bold leading-4 whitespace-nowrap">{{ $sData['title'] }}</div>
                        <div class="text-[10px] text-slate-400 leading-3 whitespace-nowrap">{{ $sData['desc'] }}</div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Formulir Utama Edit Usulan -->
    <form method="POST" action="{{ route('dosen.proposals.update', $proposal) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- ==================== SUB MENU 1: IDENTITAS USULAN ==================== -->
        <div x-show="step === 1" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 1</span>
                    <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Identitas Usulan Kegiatan</h2>
                    <p class="text-xs text-slate-500 leading-4">Isian umum identitas usulan proposal dan data rekening penampung dana hibah.</p>
                </div>

                <!-- Jenis Kegiatan (Penelitian / Pengabdian kepada Masyarakat) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Jenis Kegiatan <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3"
                               :class="jenis === 'penelitian' ? 'border-[#0B2A59] bg-blue-50/40 ring-2 ring-[#0B2A59]' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="jenis" value="penelitian" x-model="jenis" class="mt-1 text-[#0B2A59] focus:ring-[#0B2A59]">
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-5">1) Penelitian</div>
                                <p class="text-xs text-slate-500 mt-1 leading-4">Pengembangan teknologi rekayasa otomotif dan keselamatan transportasi jalan.</p>
                            </div>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3"
                               :class="jenis === 'pengabdian' ? 'border-[#0B2A59] bg-blue-50/40 ring-2 ring-[#0B2A59]' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="jenis" value="pengabdian" x-model="jenis" class="mt-1 text-[#0B2A59] focus:ring-[#0B2A59]">
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-5">2) Pengabdian kepada Masyarakat (PKM)</div>
                                <p class="text-xs text-slate-500 mt-1 leading-4">Penerapan teknologi tepat guna, desa binaan, dan edukasi keselamatan lalu lintas.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Judul Usulan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Usulan Kegiatan <span class="text-rose-500">*</span></label>
                    <textarea name="judul" rows="3" required placeholder="Tuliskan judul usulan secara lengkap, spesifik, dan jelas..." class="w-full p-4 border-slate-300 rounded-xl text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('judul', $proposal->judul) }}</textarea>
                </div>

                <!-- Ringkasan Usulan (Maksimal 500 kata) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Ringkasan Usulan Kegiatan</label>
                    <textarea name="abstrak" rows="5" placeholder="Uraikan latar belakang masalah, urgensi riset, metodologi pelaksanaan, dan target capaian utama..." class="w-full p-4 border-slate-300 rounded-xl text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('abstrak', $proposal->abstrak) }}</textarea>
                    <span class="text-[11px] text-slate-400 mt-1 block">Isian teks ringkasan maksimal 500 kata.</span>
                </div>

                <!-- Kata Kunci -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kata Kunci</label>
                    <input type="text" name="kata_kunci" value="{{ old('kata_kunci', $proposal->kata_kunci) }}" placeholder="Contoh: keselamatan jalan, pengereman otomatis, sensor cerdas" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    <span class="text-[11px] text-slate-400 mt-1 block">Pisahkan setiap kata kunci dengan tanda koma.</span>
                </div>

                <!-- Grid Atribut Identitas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Bidang Fokus -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Bidang Fokus</label>
                        <input type="text" name="bidang_fokus" value="{{ old('bidang_fokus', $proposal->bidang_fokus) }}" placeholder="Prioritas keselamatan transportasi" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <!-- Lama Kegiatan (Pilihan dalam Tahun) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Lama Kegiatan (Tahun) <span class="text-rose-500">*</span></label>
                        <select name="lama_kegiatan_tahun" x-model.number="lamaKegiatanTahun" class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                            <option value="1">1 Tahun Anggaran</option>
                            <option value="2">2 Tahun (Tahun Jamak)</option>
                            <option value="3">3 Tahun (Tahun Jamak)</option>
                        </select>
                    </div>

                    <!-- Topik Kegiatan -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Topik Kegiatan</label>
                        <input type="text" name="topik_kegiatan" value="{{ old('topik_kegiatan', $proposal->topik_kegiatan) }}" placeholder="Contoh: Pengujian sensor blind spot armada bus perkotaan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <!-- Lokasi Penelitian / Lokus -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Lokasi Penelitian</label>
                        <input type="text" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan', $proposal->lokasi_kegiatan) }}" placeholder="Lokus pelaksanaan kegiatan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <!-- Skema Pendanaan -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Skema Kegiatan <span class="text-rose-500">*</span></label>
                        <select name="skema" x-model="skema" required class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                            <template x-if="jenis === 'penelitian'">
                                <template x-for="item in skemaListPenelitian" :key="item">
                                    <option :value="item" x-text="item"></option>
                                </template>
                            </template>
                            <template x-if="jenis === 'pengabdian'">
                                <template x-for="item in skemaListPengabdian" :key="item">
                                    <option :value="item" x-text="item"></option>
                                </template>
                            </template>
                        </select>
                    </div>

                    <!-- Program Studi (Hanya 3 Prodi PKTJ) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Program Studi Homebase <span class="text-rose-500">*</span></label>
                        <select name="prodi_id" required class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ (old('prodi_id', $proposal->prodi_id) == $prodi->id) ? 'selected' : '' }}>
                                    {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun Anggaran -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tahun Anggaran <span class="text-rose-500">*</span></label>
                        <select name="tahun_anggaran" required class="w-full h-11 px-3 border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                            <option value="2026" {{ old('tahun_anggaran', $proposal->tahun_anggaran) == '2026' ? 'selected' : '' }}>Tahun 2026</option>
                            <option value="2027" {{ old('tahun_anggaran', $proposal->tahun_anggaran) == '2027' ? 'selected' : '' }}>Tahun 2027</option>
                        </select>
                    </div>

                    <!-- Sumber Dana -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Sumber Pendanaan</label>
                        <input type="text" name="sumber_dana" value="{{ old('sumber_dana', $proposal->sumber_dana) }}" required placeholder="Contoh: DIPA PKTJ, Kerjasama Industri" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <!-- Usulan Biaya (Terkalkulasi Otomatis dari RAB) -->
                    <div class="md:col-span-3 p-4 rounded-xl bg-blue-50/50 border border-blue-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-[#0B2A59] block">Usulan Biaya (Total Anggaran):</span>
                            <span class="text-[11px] text-slate-500">Nominal terakumulasi otomatis dari input Rencana Anggaran (RAB) di Sub Menu 5.</span>
                        </div>
                        <div class="text-xl font-bold text-[#0B2A59]" x-text="formatRupiah(grandTotal)"></div>
                    </div>
                </div>

                <!-- Dana Rekening (Nama Bank, No Rekening, Nama Rekening) -->
                <div class="pt-4 border-t border-slate-200">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Dana Rekening Penerima Hibah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama Bank</label>
                            <input type="text" name="bank_nama" value="{{ old('bank_nama', $proposal->bank_nama) }}" placeholder="Contoh: Bank BRI / Bank BNI" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nomor Rekening</label>
                            <input type="text" name="bank_rekening" value="{{ old('bank_rekening', $proposal->bank_rekening) }}" placeholder="Contoh: 0123-01-000123-50-1" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama Rekening</label>
                            <input type="text" name="bank_pemilik" value="{{ old('bank_pemilik', $proposal->bank_pemilik) }}" placeholder="Sesuai buku tabungan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="button" @click="step = 2" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 2 (Anggota Tim)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 2: ANGGOTA TIM ==================== -->
        <div x-show="step === 2" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 2</span>
                        <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Anggota Tim Pengusul</h2>
                        <p class="text-xs text-slate-500 leading-4">1) Dosen Internal PKTJ, 2) Dosen Eksternal, 3) Taruna/Mahasiswa PKTJ.</p>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="button" @click="addMember('dosen_anggota', 'internal')" class="inline-flex items-center justify-center h-9 px-3 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            + Dosen PKTJ
                        </button>
                        <button type="button" @click="addMember('dosen_anggota', 'eksternal')" class="inline-flex items-center justify-center h-9 px-3 rounded-lg text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors leading-4">
                            + Dosen Eksternal
                        </button>
                        <button type="button" @click="addMember('mahasiswa', 'taruna')" class="inline-flex items-center justify-center h-9 px-3 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            + Taruna / Mahasiswa
                        </button>
                    </div>
                </div>

                <!-- Kartu Ketua Pengusul (Dosen Internal PKTJ) -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ substr($proposal->ketua?->name ?? $user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-900 leading-4">{{ $proposal->ketua?->name ?? $user->name }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-[#0B2A59]">Ketua Pengusul</span>
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 leading-3">
                                NIDN/NIP: {{ $proposal->ketua?->nidn_nip ?? '-' }} &bull; Prodi: {{ $proposal->prodi?->kode_prodi ?? '-' }} &bull; Status: Dosen Internal PKTJ
                            </div>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500">Ketua Tim Pengusul</span>
                </div>

                <!-- Daftar Anggota Tim Dinamis -->
                <div class="space-y-4">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Susunan Anggota Tim Peneliti / Pengabdi</div>

                    <template x-if="members.length === 0">
                        <div class="p-6 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl space-y-1">
                            <div>Belum ada anggota tim tambahan yang dimasukkan.</div>
                            <p class="text-[11px]">Gunakan tombol di atas untuk menambahkan Dosen Internal PKTJ, Dosen Eksternal, atau Taruna/Mahasiswa.</p>
                        </div>
                    </template>

                    <div class="space-y-3">
                        <template x-for="(member, index) in members" :key="index">
                            <div class="p-4 rounded-xl border border-slate-200 bg-white space-y-3 shadow-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-700" x-text="'Anggota #' + (index + 1) + ' (' + (member.kategori_anggota === 'internal' ? 'Dosen Internal' : (member.kategori_anggota === 'eksternal' ? 'Dosen Eksternal' : 'Taruna/Mahasiswa')) + ')'"></span>
                                    <button type="button" @click="removeMember(index)" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                        Hapus Baris
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Kategori</label>
                                        <select :name="'members[' + index + '][kategori_anggota]'" x-model="member.kategori_anggota" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                            <option value="internal">1) Dosen Internal PKTJ</option>
                                            <option value="eksternal">2) Dosen Eksternal</option>
                                            <option value="taruna">3) Taruna/Mahasiswa</option>
                                        </select>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Peran Tim</label>
                                        <select :name="'members[' + index + '][peran]'" x-model="member.peran" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                            <option value="dosen_anggota">Dosen Anggota</option>
                                            <option value="mahasiswa">Taruna / Mahasiswa</option>
                                        </select>
                                    </div>

                                    <template x-if="member.kategori_anggota === 'internal'">
                                        <div class="sm:col-span-6">
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Pilih Dosen PKTJ</label>
                                            <select @change="selectDosen(index, $event)" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                                <option value="">-- Pilih dari Daftar Dosen --</option>
                                                @foreach($dosenList as $dosen)
                                                    <option value="{{ $dosen->id }}" data-name="{{ $dosen->name }}" data-nidn="{{ $dosen->nidn_nip }}" data-prodi="{{ $dosen->prodi?->kode_prodi }}">
                                                        {{ $dosen->name }} ({{ $dosen->prodi?->kode_prodi ?? '-' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </template>

                                    <div :class="member.kategori_anggota === 'internal' ? 'sm:col-span-6' : 'sm:col-span-6'">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Nama Lengkap</label>
                                        <input type="text" :name="'members[' + index + '][nama]'" x-model="member.nama" required placeholder="Nama lengkap anggota" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3" x-text="member.kategori_anggota === 'taruna' ? 'Notar / NIM' : 'NIDN / NIP'"></label>
                                        <input type="text" :name="'members[' + index + '][nidn_nim]'" x-model="member.nidn_nim" placeholder="Nomor identitas" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>

                                    <template x-if="member.kategori_anggota === 'internal'">
                                        <div class="sm:col-span-6">
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Jabatan Fungsional</label>
                                            <input type="text" :name="'members[' + index + '][jabatan_fungsional]'" x-model="member.jabatan_fungsional" placeholder="Contoh: Asisten Ahli / Lektor" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                        </div>
                                    </template>

                                    <template x-if="member.kategori_anggota === 'internal' || member.kategori_anggota === 'taruna'">
                                        <div class="sm:col-span-6">
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Prodi (D4 RSTJ / D4 TRO / D3 TO)</label>
                                            <select :name="'members[' + index + '][prodi]'" x-model="member.prodi" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                                <option value="">-- Pilih Program Studi PKTJ --</option>
                                                <option value="D4 RSTJ">D4 RSTJ (Rekayasa Sistem Transportasi Jalan)</option>
                                                <option value="D4 TRO">D4 TRO (Teknologi Rekayasa Otomotif)</option>
                                                <option value="D3 TO">D3 TO (Teknologi Otomotif)</option>
                                            </select>
                                        </div>
                                    </template>

                                    <template x-if="member.kategori_anggota === 'taruna'">
                                        <div class="sm:col-span-6">
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Angkatan Taruna</label>
                                            <input type="text" :name="'members[' + index + '][angkatan]'" x-model="member.angkatan" placeholder="Contoh: Angkatan 64" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                        </div>
                                    </template>

                                    <div class="sm:col-span-4" x-show="member.kategori_anggota === 'eksternal'">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Asal Instansi / Institusi</label>
                                        <input type="text" :name="'members[' + index + '][asal_instansi]'" x-model="member.asal_instansi" placeholder="Instansi/Kampus luar PKTJ" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>
                                    <div class="sm:col-span-2" x-show="member.kategori_anggota === 'eksternal'">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Negara</label>
                                        <input type="text" :name="'members[' + index + '][negara]'" x-model="member.negara" placeholder="Indonesia" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>

                                    <div class="sm:col-span-12">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Uraian Tugas dalam Kegiatan</label>
                                        <input type="text" :name="'members[' + index + '][tugas]'" x-model="member.tugas" placeholder="Peran dan kontribusi teknis dalam kegiatan" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 1" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 1</span>
                </button>
                <button type="button" @click="step = 3" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 3 (Atribut Usulan)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 3: ATRIBUT USULAN (UPLOAD PROPOSAL) ==================== -->
        <div x-show="step === 3" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 3</span>
                    <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Atribut Usulan (Unggah Berkas Naskah Proposal)</h2>
                    <p class="text-xs text-slate-500 leading-4">Isikan keterangan nama file, pilih file naskah proposal PDF, dan unggah file proposal.</p>
                </div>

                @if($proposal->file_proposal)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-[#0B2A59] flex items-center justify-center font-bold text-xs">
                                PDF
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">Berkas Proposal Saat Ini:</span>
                                <span class="text-[11px] text-slate-500">{{ $proposal->nama_berkas_proposal ?? basename($proposal->file_proposal) }}</span>
                            </div>
                        </div>
                        <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank" class="text-xs font-semibold text-[#0B2A59] hover:underline">
                            Lihat Berkas
                        </a>
                    </div>
                @endif

                <!-- Keterangan Nama Berkas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Keterangan Nama Berkas Dokumen</label>
                    <input type="text" name="nama_berkas_proposal" value="{{ old('nama_berkas_proposal', $proposal->nama_berkas_proposal) }}" placeholder="Contoh: Proposal_Riset_Keselamatan_Vokasi_2026.pdf" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                </div>

                <!-- Unggah File Berkas PDF Proposal -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Perbarui Berkas Proposal (PDF, Maksimal 10 MB)</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-[#0B2A59] transition-colors space-y-3">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <div class="text-xs text-slate-600">
                            <label for="file_proposal_edit" class="font-bold text-[#0B2A59] hover:underline cursor-pointer">Pilih berkas baru</label> jika ingin mengganti naskah
                        </div>
                        <input id="file_proposal_edit" type="file" name="file_proposal" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200">
                        <p class="text-[11px] text-slate-400">Kosongkan jika tidak ingin mengganti file proposal yang sudah ada.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 2" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 2</span>
                </button>
                <button type="button" @click="step = 4" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 4 (Luaran & Target)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 4: LUARAN & TARGET ==================== -->
        <div x-show="step === 4" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 4</span>
                        <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Luaran & Target Kegiatan</h2>
                        <p class="text-xs text-slate-500 leading-4">Luaran yang disyaratkan skema muncul otomatis. Klik "Tambah Luaran" untuk menambahkan luaran lainnya.</p>
                    </div>
                    <button type="button" @click="addLuaran()" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 shadow-sm">
                        + Tambah Luaran
                    </button>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4 w-56">Jenis Luaran</th>
                                <th class="py-3 px-4">Deskripsi / Target Kualifikasi Spesifik</th>
                                <th class="py-3 px-4 w-16 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(item, idx) in luaran" :key="idx">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="p-3 text-center font-bold text-slate-600" x-text="idx + 1"></td>
                                    <td class="p-3">
                                        <select :name="'luaran_target[' + idx + '][jenis]'" x-model="item.jenis" required class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                            <option value="Jurnal Nasional">Jurnal Nasional</option>
                                            <option value="Jurnal Internasional">Jurnal Internasional</option>
                                            <option value="HKI">Hak Kekayaan Intelektual (HKI)</option>
                                            <option value="Produk/Jasa">Produk / Jasa / Purwarupa</option>
                                            <option value="Buku Ajar">Buku Ajar / Monograf Ber-ISBN</option>
                                        </select>
                                    </td>
                                    <td class="p-3">
                                        <input type="text" :name="'luaran_target[' + idx + '][keterangan]'" x-model="item.keterangan" placeholder="Contoh: Terbit pada jurnal terindeks Sinta 2 / Hak Cipta Perangkat Lunak" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-3 text-center">
                                        <button type="button" @click="removeLuaran(idx)" class="text-rose-600 hover:text-rose-800 p-1" title="Hapus">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 3" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 3</span>
                </button>
                <button type="button" @click="step = 5" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 5 (Rencana Anggaran)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 5: RENCANA ANGGARAN (RAB) ==================== -->
        <div x-show="step === 5" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 5</span>
                        <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Rencana Anggaran (RAB)</h2>
                        <p class="text-xs text-slate-500 leading-4">Pilih jenis belanja: honorarium, bahan habis pakai, biaya perjalanan, biaya sewa. Isikan urutan tahun anggaran.</p>
                    </div>
                    <button type="button" @click="addBudget()" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 shadow-sm">
                        + Tambah Rencana Anggaran
                    </button>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                <th class="py-3 px-3 w-44">Jenis Belanja</th>
                                <th class="py-3 px-3 w-24">Tahun Ke-</th>
                                <th class="py-3 px-3 min-w-[200px]">Nama Item / Uraian</th>
                                <th class="py-3 px-3 w-20">Volume</th>
                                <th class="py-3 px-3 w-24">Detail / Satuan</th>
                                <th class="py-3 px-3 w-36">Biaya Satuan (Rp)</th>
                                <th class="py-3 px-3 w-36 text-right">Total (Rp)</th>
                                <th class="py-3 px-3 w-16 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(budget, bIdx) in budgets" :key="bIdx">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="p-2">
                                        <select :name="'budgets[' + bIdx + '][kategori_belanja]'" x-model="budget.kategori_belanja" required class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs">
                                            <option value="honorarium">Honorarium</option>
                                            <option value="bahan_habis_pakai">Bahan Habis Pakai</option>
                                            <option value="perjalanan_lapangan">Biaya Perjalanan</option>
                                            <option value="sewa_alat">Biaya Sewa</option>
                                            <option value="publikasi_diseminasi">Publikasi / HKI</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <select :name="'budgets[' + bIdx + '][tahun_ke]'" x-model.number="budget.tahun_ke" class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs font-semibold">
                                            <option value="1">Th. 1</option>
                                            <option value="2">Th. 2</option>
                                            <option value="3">Th. 3</option>
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="text" :name="'budgets[' + bIdx + '][uraian]'" x-model="budget.uraian" required placeholder="Nama item kebutuhan" class="w-full h-9 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="number" step="0.01" min="0.01" :name="'budgets[' + bIdx + '][volume]'" x-model.number="budget.volume" required class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs text-right">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" :name="'budgets[' + bIdx + '][satuan]'" x-model="budget.satuan" required placeholder="Unit/Paket/Hari" class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="number" step="1000" min="0" :name="'budgets[' + bIdx + '][harga_satuan]'" x-model.number="budget.harga_satuan" required class="w-full h-9 px-3 border-slate-300 rounded-lg text-xs text-right">
                                    </td>
                                    <td class="p-2 text-right font-bold text-slate-800" x-text="formatRupiah(calculateSubtotal(budget))"></td>
                                    <td class="p-2 text-center">
                                        <button type="button" @click="removeBudget(bIdx)" class="text-rose-600 hover:text-rose-800 p-1" title="Hapus baris">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-50 border-t-2 border-slate-300 font-bold text-xs text-slate-900">
                                <td colspan="6" class="py-3 px-4 text-right">TOTAL USULAN BIAYA ANGGARAN (RAB):</td>
                                <td class="py-3 px-4 text-right text-sm text-[#0B2A59]" x-text="formatRupiah(grandTotal)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 4" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 4</span>
                </button>
                <button type="button" @click="step = 6" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 6 (Jadwal Kegiatan)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 6: JADWAL KEGIATAN ==================== -->
        <div x-show="step === 6" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 6</span>
                        <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Jadwal Kegiatan</h2>
                        <p class="text-xs text-slate-500 leading-4">Isikan nama tahapan kegiatan, urutan tahun kegiatan, serta tanggal mulai dan tanggal selesai.</p>
                    </div>
                    <button type="button" @click="addJadwal()" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 shadow-sm">
                        + Tambah Jadwal Kegiatan
                    </button>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4 min-w-[220px]">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-28">Urutan Tahun</th>
                                <th class="py-3 px-4 w-40">Tanggal Mulai</th>
                                <th class="py-3 px-4 w-40">Tanggal Selesai</th>
                                <th class="py-3 px-4 w-16 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(j, jIdx) in jadwal" :key="jIdx">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="p-3 text-center font-bold text-slate-600" x-text="jIdx + 1"></td>
                                    <td class="p-3">
                                        <input type="text" :name="'jadwal_kegiatan[' + jIdx + '][nama_kegiatan]'" x-model="j.nama_kegiatan" required placeholder="Contoh: Pengujian laboratorium sensor rem" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-3">
                                        <select :name="'jadwal_kegiatan[' + jIdx + '][tahun]'" x-model.number="j.tahun" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs font-semibold">
                                            <option value="1">Tahun 1</option>
                                            <option value="2">Tahun 2</option>
                                            <option value="3">Tahun 3</option>
                                        </select>
                                    </td>
                                    <td class="p-3">
                                        <input type="date" :name="'jadwal_kegiatan[' + jIdx + '][tanggal_mulai]'" x-model="j.tanggal_mulai" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-3">
                                        <input type="date" :name="'jadwal_kegiatan[' + jIdx + '][tanggal_selesai]'" x-model="j.tanggal_selesai" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-3 text-center">
                                        <button type="button" @click="removeJadwal(jIdx)" class="text-rose-600 hover:text-rose-800 p-1" title="Hapus">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 5" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 5</span>
                </button>
                <button type="button" @click="step = 7" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 7 (Kelengkapan Lain)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 7: KELENGKAPAN LAIN (MITRA & DOKUMEN) ==================== -->
        <div x-show="step === 7" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 7</span>
                    <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Kelengkapan Lain (Mitra & Dokumen Pendukung)</h2>
                    <p class="text-xs text-slate-500 leading-4">Isian tambah mitra, dana mitra (dari luar), dana tambahan, dan dokumen pendukung.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama Mitra Kerjasama</label>
                        <input type="text" name="nama_mitra" value="{{ old('nama_mitra', $proposal->nama_mitra) }}" placeholder="Contoh: PT Trans Industri / Dinas Perhubungan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Bentuk Kontribusi Partisipasi Mitra</label>
                        <input type="text" name="kontribusi_mitra" value="{{ old('kontribusi_mitra', $proposal->kontribusi_mitra) }}" placeholder="Contoh: Penyediaan sarana pengujian dan fasilitas lapangan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Dana Mitra (Dari Luar / In-Cash Rp)</label>
                        <input type="number" step="1000" min="0" name="dana_mitra" value="{{ old('dana_mitra', $proposal->dana_mitra) }}" placeholder="Nominal kontribusi dana dari luar" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Dana Tambahan (Pendamping Rp)</label>
                        <input type="number" step="1000" min="0" name="dana_tambahan" value="{{ old('dana_tambahan', $proposal->dana_tambahan) }}" placeholder="Nominal dana pendamping lainnya" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                    <div class="sm:col-span-2">
                        @if($proposal->file_mitra)
                            <div class="mb-2 p-3 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                                <span class="text-slate-700">Berkas surat kesediaan mitra saat ini tersimpan: <strong>{{ basename($proposal->file_mitra) }}</strong></span>
                                <a href="{{ Storage::url($proposal->file_mitra) }}" target="_blank" class="text-[#0B2A59] hover:underline font-semibold">Unduh Berkas</a>
                            </div>
                        @endif
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Perbarui Dokumen Kesediaan Mitra (PDF, Maks 10 MB)</label>
                        <input type="file" name="file_mitra" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-800 hover:file:bg-slate-200">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" @click="step = 6" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Sub Menu 6</span>
                </button>
                <button type="button" @click="step = 8" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Sub Menu 8 (Konfirmasi)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== SUB MENU 8: KONFIRMASI ==================== -->
        <div x-show="step === 8" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#0B2A59] text-white">Sub Menu 8</span>
                    <h2 class="text-base font-bold text-[#0B2A59] mt-2 leading-6">Konfirmasi & Pengiriman Usulan</h2>
                    <p class="text-xs text-slate-500 leading-4">Pilih setuju untuk menyetujui ketentuan yang ada, dan memilih untuk menyelesaikan proses pengusulan.</p>
                </div>

                <!-- Ringkasan Singkat Seluruh Isian -->
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-700">Rekapitulasi Pengusulan Kegiatan</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs leading-5">
                        <div>
                            <span class="text-slate-500 block">Jenis Kegiatan:</span>
                            <strong class="text-slate-800 capitalize" x-text="jenis"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Skema:</span>
                            <strong class="text-slate-800" x-text="skema"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Anggota Tim:</span>
                            <strong class="text-slate-800" x-text="members.length + ' Anggota (+ Ketua)'"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Total Anggaran (RAB):</span>
                            <strong class="text-[#0B2A59]" x-text="formatRupiah(grandTotal)"></strong>
                        </div>
                    </div>
                </div>

                <!-- Pilihan Setuju / Tidak Setuju -->
                <div class="p-5 rounded-xl border border-slate-200 space-y-3">
                    <label class="block text-xs font-bold text-slate-800 leading-4">Persetujuan Ketentuan Pengusulan P3M PKTJ <span class="text-rose-500">*</span></label>
                    <div class="space-y-2">
                        <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition-colors"
                               :class="persetujuan === '1' ? 'border-[#0B2A59] bg-blue-50/40 ring-1 ring-[#0B2A59]' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="persetujuan_konfirmasi" value="1" x-model="persetujuan" class="mt-0.5 text-[#0B2A59] focus:ring-[#0B2A59]">
                            <span class="text-xs text-slate-700 font-medium leading-5">
                                <strong>Setuju:</strong> Saya menyetujui seluruh ketentuan pengusulan yang berlaku di lingkungan P3M Politeknik Keselamatan Transportasi Jalan, menyatakan kebenaran data personalia dan anggaran yang diajukan, serta bersedia mematuhi kode etik akademik.
                            </span>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer transition-colors"
                               :class="persetujuan === '0' ? 'border-rose-400 bg-rose-50/40' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="persetujuan_konfirmasi" value="0" x-model="persetujuan" class="mt-0.5 text-rose-600 focus:ring-rose-600">
                            <span class="text-xs text-slate-700 font-medium leading-5">
                                <strong>Tidak Setuju:</strong> Belum dapat menyetujui ketentuan (usulan hanya dapat disimpan sebagai draf sementara).
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Aksi: Simpan Draf vs Kirim Usulan -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" @click="step = 7" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali: Sub Menu 7</span>
                    </button>

                    <div class="flex items-center gap-3 w-full sm:w-auto flex-col sm:flex-row">
                        <!-- Simpan Draf -->
                        <button type="submit" name="action_type" value="draft" class="w-full sm:w-auto inline-flex items-center justify-center h-11 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            Simpan sebagai Draf Usulan
                        </button>

                        <!-- Kirim Usulan -->
                        <button type="submit" name="action_type" value="diajukan" :disabled="persetujuan !== '1'"
                                :class="persetujuan === '1' ? 'bg-[#0B2A59] hover:bg-blue-900 text-white cursor-pointer shadow-sm' : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                class="w-full sm:w-auto inline-flex items-center justify-center h-11 px-6 rounded-xl text-xs font-semibold transition-all leading-4">
                            Kirimkan Usulan ke P3M PKTJ
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>
@endsection
