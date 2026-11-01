@extends('layouts.admin')

@section('title', 'Ubah Dokumen')
@section('breadcrumb', 'CMS Portal / Dokumen & SOP / Ubah')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Ubah Informasi Dokumen</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Perbarui judul, kategori, atau ganti berkas dokumen.</p>
        </div>
        <a href="{{ route('admin.documents.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 leading-4">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Formulir Ubah Dokumen -->
    <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <!-- Judul Dokumen -->
        <div>
            <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Nama / Judul Dokumen <span class="text-rose-500">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $document->judul) }}" required
                   class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
            @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Baris Kategori & Tahun -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="kategori" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kategori Dokumen <span class="text-rose-500">*</span></label>
                <select id="kategori" name="kategori" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="pedoman_penelitian" {{ old('kategori', $document->kategori) == 'pedoman_penelitian' ? 'selected' : '' }}>Pedoman Penelitian dan Pengembangan SDM</option>
                    <option value="pedoman_pengabdian" {{ old('kategori', $document->kategori) == 'pedoman_pengabdian' ? 'selected' : '' }}>Pedoman PkM dan Pengembangan Kualitas Kepakaran</option>
                    <option value="proses_pengabdian" {{ old('kategori', $document->kategori) == 'proses_pengabdian' ? 'selected' : '' }}>Dokumen Proses Pengabdian kepada Masyarakat</option>
                    <option value="panduan_sistem" {{ old('kategori', $document->kategori) == 'panduan_sistem' || old('kategori', $document->kategori) == 'panduan' ? 'selected' : '' }}>Buku Panduan Penggunaan SIM P3M</option>
                    <option value="renstra_penelitian" {{ old('kategori', $document->kategori) == 'renstra_penelitian' ? 'selected' : '' }}>Renstra Penelitian (2026-2031)</option>
                    <option value="renstra_pengabdian" {{ old('kategori', $document->kategori) == 'renstra_pengabdian' ? 'selected' : '' }}>Renstra Pengabdian kepada Masyarakat</option>
                    <option value="renstra" {{ old('kategori', $document->kategori) == 'renstra' ? 'selected' : '' }}>Rencana Strategis (Renstra) Umum</option>
                    <option value="roadmap" {{ old('kategori', $document->kategori) == 'roadmap' ? 'selected' : '' }}>Roadmap Penelitian</option>
                    <option value="sop_penelitian" {{ old('kategori', $document->kategori) == 'sop_penelitian' ? 'selected' : '' }}>SOP Penelitian</option>
                    <option value="sop_pengabdian" {{ old('kategori', $document->kategori) == 'sop_pengabdian' ? 'selected' : '' }}>SOP Pengabdian</option>
                </select>
            </div>

            <div>
                <label for="tahun" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tahun Berlaku / Anggaran</label>
                <input type="text" id="tahun" name="tahun" value="{{ old('tahun', $document->tahun) }}"
                       class="w-full h-11 px-4 border-slate-300 rounded-xl text-xs leading-4">
            </div>
        </div>

        <!-- Berkas Dokumen Pengganti -->
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Berkas Dokumen Saat Ini</label>
            <div class="mb-3 flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                <span class="font-medium text-slate-800">{{ basename($document->file_path) }} ({{ $document->file_size }})</span>
                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-[#0B2A59] font-bold hover:underline">Unduh Berkas ↗</a>
            </div>

            <label for="file_dokumen" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Ganti Berkas (Opsional)</label>
            <input type="file" id="file_dokumen" name="file_dokumen" accept=".pdf,.docx,.xlsx"
                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200 leading-4">
            <span class="text-[11px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengganti file. Maksimal 20 MB.</span>
            @error('file_dokumen') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Keterangan / Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Keterangan Singkat Isi Dokumen</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('deskripsi', $document->deskripsi) }}</textarea>
            @error('deskripsi') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.documents.index') }}" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center leading-4">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm active:scale-[0.98] transition-all leading-4">
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>
@endsection
