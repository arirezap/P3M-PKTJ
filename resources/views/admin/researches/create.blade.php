@extends('layouts.admin')

@section('title', 'Tambah Data Riset')
@section('breadcrumb', 'CMS Portal / Data Riset / Tambah Baru')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Tambah Data Riset Dosen</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Data ini akan langsung memperbarui grafik dan tabel di halaman portal publik.</p>
        </div>
        <a href="{{ route('admin.researches.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 leading-4">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Formulir Tambah Data Riset -->
    <form method="POST" action="{{ route('admin.researches.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-5">
        @csrf

        <!-- Judul Penelitian -->
        <div>
            <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Penelitian <span class="text-rose-500">*</span></label>
            <textarea id="judul" name="judul" rows="2" required placeholder="Contoh: Rancang Bangun Sensor Deteksi Kelelahan Pengemudi Angkutan Umum..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('judul') }}</textarea>
            @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Abstrak / Ringkasan Riset -->
        <div>
            <label for="abstrak" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Abstrak / Ringkasan Eksekutif Penelitian</label>
            <textarea id="abstrak" name="abstrak" rows="4" placeholder="Uraikan ringkasan latar belakang, metode penelitian, dan temuan/hasil utama..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('abstrak') }}</textarea>
            @error('abstrak') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
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

        <!-- Ketua Peneliti & Anggota -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="ketua_peneliti" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama Ketua Peneliti <span class="text-rose-500">*</span></label>
                <input type="text" id="ketua_peneliti" name="ketua_peneliti" value="{{ old('ketua_peneliti') }}" required placeholder="Nama lengkap & gelar..."
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
                @error('ketua_peneliti') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="anggota" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Anggota Peneliti (Dosen/Taruna)</label>
                <input type="text" id="anggota" name="anggota" value="{{ old('anggota') }}" placeholder="Pisahkan dengan tanda koma..."
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>
        </div>

        <!-- Skema, Sumber Dana & Anggaran -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="skema" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Skema Hibah</label>
                <input type="text" id="skema" name="skema" value="{{ old('skema', 'Penelitian Terapan Unggulan') }}"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>

            <div>
                <label for="sumber_dana" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Sumber Dana <span class="text-rose-500">*</span></label>
                <input type="text" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana', 'DIPA PKTJ') }}" required
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>

            <div>
                <label for="anggaran" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nominal Anggaran (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" id="anggaran" name="anggaran" value="{{ old('anggaran', 25000000) }}" required min="0" step="1000"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>
        </div>

        <!-- Status Riset -->
        <div>
            <label for="status" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Status Pelaksanaan <span class="text-rose-500">*</span></label>
            <select id="status" name="status" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Berjalan" {{ old('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
            </select>
        </div>

        <!-- Berkas Laporan Penelitian (PDF) -->
        <div>
            <label for="berkas_laporan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Berkas Laporan Penelitian / Ringkasan Eksekutif (PDF)</label>
            <input type="file" id="berkas_laporan" name="berkas_laporan" accept="application/pdf"
                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
            <p class="text-[11px] text-slate-400 mt-1.5 leading-4">Format berkas: PDF (.pdf). Maksimal ukuran file: 10 MB.</p>
            @error('berkas_laporan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.researches.index') }}" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center leading-4">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm active:scale-[0.98] transition-all leading-4">
                Simpan Data Riset
            </button>
        </div>

    </form>

</div>
@endsection
