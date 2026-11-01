@extends('layouts.admin')

@section('title', 'Tambah Data Pengabdian')
@section('breadcrumb', 'CMS Portal / Data Pengabdian / Tambah Baru')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Tambah Data Kegiatan Pengabdian (PkM)</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Data kemitraan desa binaan, sekolah mitra, atau UMKM yang tampil pada rekapitulasi portal publik.</p>
        </div>
        <a href="{{ route('admin.community-services.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 leading-4">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Formulir Tambah Data PkM -->
    <form method="POST" action="{{ route('admin.community-services.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-5">
        @csrf

        <!-- Judul Pengabdian -->
        <div>
            <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Kegiatan Pengabdian <span class="text-rose-500">*</span></label>
            <textarea id="judul" name="judul" rows="3" required placeholder="Contoh: Edukasi dan Audit Kelengkapan Perlengkapan Jalan di Lingkungan Sekolah Ramah Anak..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('judul') }}</textarea>
            @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Ringkasan / Kemanfaatan Pengabdian -->
        <div>
            <label for="ringkasan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Ringkasan Kegiatan & Manfaat bagi Masyarakat</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" placeholder="Tuliskan ringkasan aksi nyata, dampak edukasi keselamatan, atau manfaat transfer teknologi bagi mitra sasaran..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('ringkasan') }}</textarea>
            @error('ringkasan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Baris Prodi & Tahun -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

            <div>
                <label for="tahun" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tahun Anggaran <span class="text-rose-500">*</span></label>
                <input type="number" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="2020" max="2035"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('tahun') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Ketua Pelaksana & Anggota -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="ketua_pelaksana" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama Ketua Pelaksana <span class="text-rose-500">*</span></label>
                <input type="text" id="ketua_pelaksana" name="ketua_pelaksana" value="{{ old('ketua_pelaksana') }}" required placeholder="Nama lengkap & gelar..."
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('ketua_pelaksana') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="anggota" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Anggota Pelaksana (Dosen / Taruna)</label>
                <input type="text" id="anggota" name="anggota" value="{{ old('anggota') }}" placeholder="Pisahkan dengan koma..."
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('anggota') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Mitra Kegiatan & Lokasi / Desa Binaan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="mitra" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Mitra Kegiatan (Instansi/Sekolah/Industri)</label>
                <input type="text" id="mitra" name="mitra" value="{{ old('mitra') }}" placeholder="Contoh: SD Negeri 1 Kraton Kota Tegal"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('mitra') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="lokasi_kegiatan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Lokasi Sasaran / Desa Binaan</label>
                <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}" placeholder="Contoh: Desa Kalinyamat Kulon, Kota Tegal"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('lokasi_kegiatan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Skema, Sumber Dana & Anggaran -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="skema" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Skema PkM</label>
                <input type="text" id="skema" name="skema" value="{{ old('skema', 'PkM Kemitraan Wilayah') }}"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>

            <div>
                <label for="sumber_dana" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Sumber Dana <span class="text-rose-500">*</span></label>
                <input type="text" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana', 'DIPA PKTJ') }}" required placeholder="DIPA PKTJ / Kemdiktisaintek / Mitra"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('sumber_dana') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="anggaran" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nominal Anggaran (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" id="anggaran" name="anggaran" value="{{ old('anggaran', 15000000) }}" required min="0" step="1000"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('anggaran') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Status Pelaksanaan & Berkas Laporan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Status Pelaksanaan <span class="text-rose-500">*</span></label>
                <select id="status" name="status" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Berjalan" {{ old('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                </select>
                @error('status') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="berkas_laporan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Berkas Laporan PkM (PDF, Maks 10 MB)</label>
                <input type="file" id="berkas_laporan" name="berkas_laporan" accept=".pdf"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200">
                @error('berkas_laporan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.community-services.index') }}" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center leading-4">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm active:scale-[0.98] transition-all leading-4">
                Simpan Data Pengabdian
            </button>
        </div>

    </form>

</div>
@endsection
