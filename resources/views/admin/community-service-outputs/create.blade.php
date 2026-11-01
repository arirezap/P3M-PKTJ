@extends('layouts.admin')

@section('title', 'Tambah Data Luaran Pengabdian')
@section('breadcrumb', 'CMS Portal / Luaran Pengabdian / Tambah Baru')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Tambah Data Luaran Pengabdian Masyarakat</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Catat hasil publikasi, produk teknologi tepat guna (TTG), modul mitra, HKI, atau rekayasa desa binaan.</p>
        </div>
        <a href="{{ route('admin.community-service-outputs.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 leading-4">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Formulir Tambah Data Luaran PkM -->
    <form method="POST" action="{{ route('admin.community-service-outputs.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-5">
        @csrf

        <!-- Baris Kategori & Program Studi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="kategori" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kategori Luaran <span class="text-rose-500">*</span></label>
                <select id="kategori" name="kategori" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="">Pilih Kategori Luaran</option>
                    <option value="publikasi" {{ old('kategori') == 'publikasi' ? 'selected' : '' }}>Publikasi Pengabdian (Jurnal/Prosiding)</option>
                    <option value="ttg" {{ old('kategori') == 'ttg' ? 'selected' : '' }}>Teknologi Tepat Guna (TTG)</option>
                    <option value="modul" {{ old('kategori') == 'modul' ? 'selected' : '' }}>Modul / Buku Panduan Mitra</option>
                    <option value="hki" {{ old('kategori') == 'hki' ? 'selected' : '' }}>Hak Cipta / HKI Pengabdian</option>
                    <option value="desa_binaan" {{ old('kategori') == 'desa_binaan' ? 'selected' : '' }}>Dampak Rekayasa Desa Binaan</option>
                </select>
                @error('kategori') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="prodi_id" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Program Studi <span class="text-rose-500">*</span></label>
                <select id="prodi_id" name="prodi_id" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="">Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
                @error('prodi_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Judul Luaran -->
        <div>
            <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Luaran / Nama Produk / Modul <span class="text-rose-500">*</span></label>
            <textarea id="judul" name="judul" rows="3" required placeholder="Contoh: Penerapan Alat Uji Opasitas Portabel Berbasis Mikrokontroler untuk Kalibrasi Bengkel Rakyat..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('judul') }}</textarea>
            @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Tim Pelaksana & Tahun -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="pelaksana" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tim Pelaksana / Author / Inovator <span class="text-rose-500">*</span></label>
                <input type="text" id="pelaksana" name="pelaksana" value="{{ old('pelaksana') }}" required placeholder="Nama lengkap & tim dosen/taruna..."
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('pelaksana') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tahun" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tahun Capaian <span class="text-rose-500">*</span></label>
                <input type="number" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="2020" max="2035"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('tahun') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Terkait Kegiatan PkM Induk (Opsional) -->
        <div>
            <label for="community_service_id" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Terkait Kegiatan Pengabdian Induk (Opsional)</label>
            <select id="community_service_id" name="community_service_id" class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                <option value="">Tidak Terhubung / Kegiatan Terpisah</option>
                @foreach($communityServices as $cs)
                    <option value="{{ $cs->id }}" {{ old('community_service_id') == $cs->id ? 'selected' : '' }}>
                        [{{ $cs->tahun }}] {{ Str::limit($cs->judul, 70) }} ({{ $cs->prodi->kode_prodi }})
                    </option>
                @endforeach
            </select>
            @error('community_service_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Mitra Sasaran & Lokasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="mitra_sasaran" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Mitra Sasaran / Komunitas</label>
                <input type="text" id="mitra_sasaran" name="mitra_sasaran" value="{{ old('mitra_sasaran') }}" placeholder="Contoh: Asosiasi Bengkel Pantura Mandiri"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('mitra_sasaran') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="lokasi" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Wilayah / Lokasi Kegiatan</label>
                <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Desa Kalinyamat Kulon, Kota Tegal"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('lokasi') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Deskripsi Manfaat / Dampak Nyata -->
        <div>
            <label for="deskripsi_manfaat" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Deskripsi Manfaat & Evaluasi Hasil Pengabdian</label>
            <textarea id="deskripsi_manfaat" name="deskripsi_manfaat" rows="3" placeholder="Tuliskan analisis kemanfaatan nyata terhadap keselamatan transportasi, efisiensi operasional mitra, atau keberdayaan masyarakat..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('deskripsi_manfaat') }}</textarea>
            @error('deskripsi_manfaat') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Indikator Keberhasilan & Tingkat Kepuasan Mitra -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="indikator_keberhasilan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Indikator Keberhasilan Capaian</label>
                <input type="text" id="indikator_keberhasilan" name="indikator_keberhasilan" value="{{ old('indikator_keberhasilan') }}" placeholder="Contoh: 25 mekanik desa terlatih dengan akurasi 95%"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('indikator_keberhasilan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tingkat_kepuasan_mitra" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tingkat Kepuasan Mitra</label>
                <input type="text" id="tingkat_kepuasan_mitra" name="tingkat_kepuasan_mitra" value="{{ old('tingkat_kepuasan_mitra', '95% (Sangat Baik)') }}" placeholder="Contoh: 95% (Sangat Baik)"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('tingkat_kepuasan_mitra') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Tautan Dokumen Eksternal & Upload Berkas PDF -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="link_dokumen" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tautan Eksternal / DOI / PDKI</label>
                <input type="text" id="link_dokumen" name="link_dokumen" value="{{ old('link_dokumen') }}" placeholder="https://doi.org/... atau link publikasi"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('link_dokumen') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="berkas_luaran" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Berkas Bukti Luaran (PDF, Maks 10 MB)</label>
                <input type="file" id="berkas_luaran" name="berkas_luaran" accept=".pdf"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200">
                @error('berkas_luaran') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.community-service-outputs.index') }}" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center leading-4">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm active:scale-[0.98] transition-all leading-4">
                Simpan Data Luaran
            </button>
        </div>

    </form>

</div>
@endsection
