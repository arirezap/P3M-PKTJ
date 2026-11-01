@extends('layouts.dashboard')

@section('title', 'Ubah Usulan: ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-6" x-data="{
    step: 1,
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
    
    // Tim Pengusul Dinamis
    members: [
        @if(old('members'))
            @foreach(old('members') as $m)
                { nama: '{{ addslashes($m['nama']) }}', peran: '{{ $m['peran'] }}', nidn_nim: '{{ addslashes($m['nidn_nim'] ?? '') }}', tugas: '{{ addslashes($m['tugas'] ?? '') }}' },
            @endforeach
        @else
            @foreach($proposal->members as $m)
                { nama: '{{ addslashes($m->nama) }}', peran: '{{ $m->peran }}', nidn_nim: '{{ addslashes($m->nidn_nim ?? '') }}', tugas: '{{ addslashes($m->tugas ?? '') }}' },
            @endforeach
        @endif
    ],
    addMember(peran = 'dosen_anggota') {
        this.members.push({ nama: '', peran: peran, nidn_nim: '', tugas: '' });
    },
    removeMember(index) {
        this.members.splice(index, 1);
    },
    selectDosen(index, event) {
        const option = event.target.selectedOptions[0];
        if (option && option.value) {
            this.members[index].nama = option.dataset.name || '';
            this.members[index].nidn_nim = option.dataset.nidn || '';
        }
    },

    // Rencana Anggaran Biaya (RAB) Dinamis
    budgets: [
        @if(old('budgets'))
            @foreach(old('budgets') as $b)
                { kategori_belanja: '{{ $b['kategori_belanja'] }}', uraian: '{{ addslashes($b['uraian']) }}', volume: {{ (float) $b['volume'] }}, satuan: '{{ addslashes($b['satuan']) }}', harga_satuan: {{ (float) $b['harga_satuan'] }} },
            @endforeach
        @else
            @foreach($proposal->budgets as $b)
                { kategori_belanja: '{{ $b->kategori_belanja }}', uraian: '{{ addslashes($b->uraian) }}', volume: {{ (float) $b->volume }}, satuan: '{{ addslashes($b->satuan) }}', harga_satuan: {{ (float) $b->harga_satuan }} },
            @endforeach
        @endif
    ],
    addBudget(kategori = 'bahan_habis_pakai') {
        this.budgets.push({ kategori_belanja: kategori, uraian: '', volume: 1, satuan: 'Paket', harga_satuan: 0 });
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
                <span class="text-slate-700 font-semibold">Ubah Data Usulan</span>
            </div>
            <h1 class="text-2xl font-bold text-[#0B2A59] mt-1 leading-8">Ubah Usulan: {{ $proposal->kode_usulan }}</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Perbarui informasi kegiatan, tim pengusul, rincian biaya anggaran (RAB), atau berkas proposal.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Batal & Kembali
            </a>
        </div>
    </div>

    <!-- Stepper Navigasi Alur Form -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4">
            
            <button type="button" @click="step = 1" 
                    :class="step === 1 ? 'border-[#0B2A59] bg-blue-50/50 text-[#0B2A59]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                    class="p-3 rounded-xl border text-left transition-colors flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                     :class="step === 1 ? 'bg-[#0B2A59] text-white' : 'bg-slate-200 text-slate-700'">
                    1
                </div>
                <div>
                    <div class="text-xs font-bold leading-4">1. Skema & Data</div>
                    <div class="text-[10px] text-slate-500 leading-3">Kategori, Judul, Abstrak</div>
                </div>
            </button>

            <button type="button" @click="step = 2" 
                    :class="step === 2 ? 'border-[#0B2A59] bg-blue-50/50 text-[#0B2A59]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                    class="p-3 rounded-xl border text-left transition-colors flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                     :class="step === 2 ? 'bg-[#0B2A59] text-white' : 'bg-slate-200 text-slate-700'">
                    2
                </div>
                <div>
                    <div class="text-xs font-bold leading-4">2. Tim Pengusul</div>
                    <div class="text-[10px] text-slate-500 leading-3">Ketua, Anggota & Taruna</div>
                </div>
            </button>

            <button type="button" @click="step = 3" 
                    :class="step === 3 ? 'border-[#0B2A59] bg-blue-50/50 text-[#0B2A59]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                    class="p-3 rounded-xl border text-left transition-colors flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                     :class="step === 3 ? 'bg-[#0B2A59] text-white' : 'bg-slate-200 text-slate-700'">
                    3
                </div>
                <div>
                    <div class="text-xs font-bold leading-4">3. Rincian RAB</div>
                    <div class="text-[10px] text-slate-500 leading-3">Anggaran Biaya Dinamis</div>
                </div>
            </button>

            <button type="button" @click="step = 4" 
                    :class="step === 4 ? 'border-[#0B2A59] bg-blue-50/50 text-[#0B2A59]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                    class="p-3 rounded-xl border text-left transition-colors flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs"
                     :class="step === 4 ? 'bg-[#0B2A59] text-white' : 'bg-slate-200 text-slate-700'">
                    4
                </div>
                <div>
                    <div class="text-xs font-bold leading-4">4. Berkas & Kirim</div>
                    <div class="text-[10px] text-slate-500 leading-3">Unggah PDF & Finalisasi</div>
                </div>
            </button>

        </div>
    </div>

    <!-- Formulir Edit Usulan -->
    <form method="POST" action="{{ route('dosen.proposals.update', $proposal) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- ==================== TAHAP 1: SKEMA & IDENTITAS USULAN ==================== -->
        <div x-show="step === 1" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-base font-bold text-[#0B2A59] leading-6">Tahap 1: Kategori, Skema & Identitas Usulan</h2>
                    <p class="text-xs text-slate-500 leading-4">Sesuaikan skema pendanaan dan judul naskah proposal.</p>
                </div>

                <!-- Pilihan Kategori Kegiatan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3"
                               :class="jenis === 'penelitian' ? 'border-[#0B2A59] bg-blue-50/40 ring-2 ring-[#0B2A59]' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="jenis" value="penelitian" x-model="jenis" class="mt-1 text-[#0B2A59] focus:ring-[#0B2A59]">
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-5">Penelitian (Riset)</div>
                                <p class="text-xs text-slate-500 mt-1 leading-4">Riset terapan keselamatan transportasi dan otomasi kendaraan vokasi.</p>
                            </div>
                        </label>

                        <label class="p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-3"
                               :class="jenis === 'pengabdian' ? 'border-[#0B2A59] bg-blue-50/40 ring-2 ring-[#0B2A59]' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="jenis" value="pengabdian" x-model="jenis" class="mt-1 text-[#0B2A59] focus:ring-[#0B2A59]">
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-5">Pengabdian kepada Masyarakat (PkM)</div>
                                <p class="text-xs text-slate-500 mt-1 leading-4">Kemitraan desa binaan, sosialisasi keselamatan, dan pelatihan vokasi.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Grid Skema, Prodi, Tahun & Sumber Dana -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Skema Hibah -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Skema Hibah Pendanaan <span class="text-rose-500">*</span></label>
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

                    <!-- Program Studi (Hanya 3 Program Studi PKTJ) -->
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
                        <input type="text" name="sumber_dana" value="{{ old('sumber_dana', $proposal->sumber_dana) }}" required placeholder="Contoh: DIPA PKTJ, BPSDM Perhubungan" class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    </div>

                </div>

                <!-- Judul Usulan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Usulan Penelitian / Pengabdian <span class="text-rose-500">*</span></label>
                    <textarea name="judul" rows="3" required placeholder="Tuliskan judul usulan..." class="w-full p-4 border-slate-300 rounded-xl text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('judul', $proposal->judul) }}</textarea>
                </div>

                <!-- Abstrak -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Abstrak / Ringkasan Usulan</label>
                    <textarea name="abstrak" rows="5" placeholder="Uraikan ringkasan usulan..." class="w-full p-4 border-slate-300 rounded-xl text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('abstrak', $proposal->abstrak) }}</textarea>
                </div>

            </div>

            <!-- Tombol Lanjut ke Tahap 2 -->
            <div class="flex items-center justify-end">
                <button type="button" @click="step = 2" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Tim Pengusul</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== TAHAP 2: TIM PENGUSUL ==================== -->
        <div x-show="step === 2" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-bold text-[#0B2A59] leading-6">Tahap 2: Susunan Tim Peneliti & Pengabdi</h2>
                        <p class="text-xs text-slate-500 leading-4">Kelola susunan anggota dosen dan taruna pendamping.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="addMember('dosen_anggota')" class="inline-flex items-center justify-center h-9 px-3 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            + Tambah Dosen Anggota
                        </button>
                        <button type="button" @click="addMember('mahasiswa')" class="inline-flex items-center justify-center h-9 px-3 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            + Tambah Taruna / Mhs
                        </button>
                    </div>
                </div>

                <!-- Kartu Ketua Pengusul -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-900 leading-4">{{ $user->name }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-100 text-[#0B2A59]">Ketua Pengusul</span>
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 leading-3">
                                NIDN: {{ $user->nidn_nip ?? '-' }} &bull; Prodi: {{ $user->prodi?->kode_prodi ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Pengusul Utama</span>
                </div>

                <!-- Daftar Anggota Tim Dinamis -->
                <div class="space-y-4">
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-500 leading-4">Daftar Anggota Tim</div>

                    <template x-if="members.length === 0">
                        <div class="p-6 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl">
                            Belum ada anggota tambahan yang didaftarkan.
                        </div>
                    </template>

                    <div class="space-y-3">
                        <template x-for="(member, index) in members" :key="index">
                            <div class="p-4 rounded-xl border border-slate-200 bg-white space-y-3 shadow-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-700" x-text="'Anggota #' + (index + 1) + ' (' + (member.peran === 'dosen_anggota' ? 'Dosen Anggota' : 'Taruna / Mahasiswa') + ')'"></span>
                                    <button type="button" @click="removeMember(index)" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                        Hapus Baris
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                    <div class="sm:col-span-3">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Peran Anggota</label>
                                        <select :name="'members[' + index + '][peran]'" x-model="member.peran" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                            <option value="dosen_anggota">Dosen Anggota</option>
                                            <option value="mahasiswa">Taruna / Mahasiswa</option>
                                        </select>
                                    </div>

                                    <template x-if="member.peran === 'dosen_anggota'">
                                        <div class="sm:col-span-4">
                                            <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Pilih Dosen PKTJ</label>
                                            <select @change="selectDosen(index, $event)" class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                                <option value="">-- Pilih dari Daftar Dosen --</option>
                                                @foreach($dosenList as $dosen)
                                                    <option value="{{ $dosen->id }}" data-name="{{ $dosen->name }}" data-nidn="{{ $dosen->nidn_nip }}">
                                                        {{ $dosen->name }} ({{ $dosen->prodi?->kode_prodi ?? '-' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </template>

                                    <div :class="member.peran === 'dosen_anggota' ? 'sm:col-span-5' : 'sm:col-span-5'">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Nama Lengkap & Gelar</label>
                                        <input type="text" :name="'members[' + index + '][nama]'" x-model="member.nama" required placeholder="Nama lengkap..." class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">NIDN / NIM</label>
                                        <input type="text" :name="'members[' + index + '][nidn_nim]'" x-model="member.nidn_nim" placeholder="Nomor Induk..." class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>

                                    <div class="sm:col-span-8">
                                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Uraian Tugas</label>
                                        <input type="text" :name="'members[' + index + '][tugas]'" x-model="member.tugas" placeholder="Uraian tugas anggota..." class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Tombol Navigasi Stepper -->
            <div class="flex items-center justify-between">
                <button type="button" @click="step = 1" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Skema & Data</span>
                </button>
                <button type="button" @click="step = 3" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Rincian Anggaran (RAB)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== TAHAP 3: RINCIAN ANGGARAN BIAYA (RAB) ==================== -->
        <div x-show="step === 3" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-bold text-[#0B2A59] leading-6">Tahap 3: Penyusunan Rencana Anggaran Biaya (RAB)</h2>
                        <p class="text-xs text-slate-500 leading-4">Perbarui daftar item biaya dan harga satuan usulan.</p>
                    </div>
                    <button type="button" @click="addBudget()" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors leading-4 shadow-sm">
                        + Tambah Item Belanja
                    </button>
                </div>

                <!-- Tabel Item Anggaran Biaya Dinamis -->
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                <th class="py-3 px-3 w-48">Kategori Belanja</th>
                                <th class="py-3 px-3 min-w-[200px]">Uraian Kebutuhan</th>
                                <th class="py-3 px-3 w-20">Volume</th>
                                <th class="py-3 px-3 w-24">Satuan</th>
                                <th class="py-3 px-3 w-36">Harga Satuan (Rp)</th>
                                <th class="py-3 px-3 w-36 text-right">Subtotal (Rp)</th>
                                <th class="py-3 px-3 w-16 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(budget, bIdx) in budgets" :key="bIdx">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="p-2">
                                        <select :name="'budgets[' + bIdx + '][kategori_belanja]'" x-model="budget.kategori_belanja" required class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs">
                                            @foreach($kategoriBelanja as $kKey => $kLabel)
                                                <option value="{{ $kKey }}">{{ $kLabel }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="text" :name="'budgets[' + bIdx + '][uraian]'" x-model="budget.uraian" required placeholder="Uraian kebutuhan..." class="w-full h-9 px-3 border-slate-300 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="number" step="0.01" min="0.01" :name="'budgets[' + bIdx + '][volume]'" x-model.number="budget.volume" required class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs text-right">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" :name="'budgets[' + bIdx + '][satuan]'" x-model="budget.satuan" required placeholder="Unit..." class="w-full h-9 px-2 border-slate-300 rounded-lg text-xs">
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
                                <td colspan="5" class="py-3 px-4 text-right">TOTAL KESELURUHAN ANGGARAN USULAN (RAB):</td>
                                <td class="py-3 px-4 text-right text-sm text-[#0B2A59]" x-text="formatRupiah(grandTotal)"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tombol Navigasi Stepper -->
            <div class="flex items-center justify-between">
                <button type="button" @click="step = 2" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali: Tim Pengusul</span>
                </button>
                <button type="button" @click="step = 4" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-colors shadow-sm leading-4">
                    <span>Lanjut: Berkas Proposal & Finalisasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== TAHAP 4: BERKAS & FINALISASI ==================== -->
        <div x-show="step === 4" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-base font-bold text-[#0B2A59] leading-6">Tahap 4: Berkas Proposal PDF & Pembaruan</h2>
                    <p class="text-xs text-slate-500 leading-4">Ganti naskah berkas dokumen jika terdapat pembaruan file PDF.</p>
                </div>

                <!-- Status Berkas Saat Ini -->
                @if($proposal->file_proposal)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-xs">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div>
                                <span class="font-bold text-slate-900">Berkas Proposal Saat Ini:</span>
                                <span class="text-slate-500 ml-1">Sudah terunggah di server</span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="text-xs font-semibold text-[#0B2A59] hover:underline">
                            Lihat Berkas PDF
                        </a>
                    </div>
                @endif

                <!-- Input Penggantian File PDF -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Ganti Berkas Dokumen Proposal (Opsional, PDF maks. 10MB)</label>
                    <input type="file" name="file_proposal" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200">
                    <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah berkas proposal yang telah diunggah sebelumnya.</p>
                </div>

                <!-- Pilihan Aksi: Simpan Perubahan -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" @click="step = 3" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali: Rincian RAB</span>
                    </button>

                    <div class="flex items-center gap-3 w-full sm:w-auto flex-col sm:flex-row">
                        <button type="submit" name="action_type" value="draft" class="w-full sm:w-auto inline-flex items-center justify-center h-12 px-6 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                            Simpan Perubahan
                        </button>

                        @if($proposal->status === 'draft')
                            <button type="submit" name="action_type" value="diajukan" class="w-full sm:w-auto inline-flex items-center justify-center h-12 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                                Simpan & Ajukan ke P3M
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>
@endsection
