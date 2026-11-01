@extends('layouts.admin')

@section('title', 'Tulis Publikasi Baru')
@section('breadcrumb', 'CMS Portal / Berita & Pengumuman / Tulis Baru')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Tulis Publikasi Baru</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Isi rincian berita, agenda diseminasi, atau pengumuman P3M PKTJ.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 leading-4">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Formulir Publikasi -->
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf

        <!-- Judul -->
        <div>
            <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Judul Publikasi <span class="text-rose-500">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Sosialisasi Call for Proposals Penelitian TA 2026"
                   class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
            @error('judul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Baris Kategori, Tanggal, & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="kategori" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Kategori <span class="text-rose-500">*</span></label>
                <select id="kategori" name="kategori" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita Kegiatan</option>
                    <option value="agenda" {{ old('kategori') == 'agenda' ? 'selected' : '' }}>Agenda Diseminasi</option>
                    <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman P3M</option>
                </select>
            </div>

            <div>
                <label for="tanggal_publikasi" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Tanggal Publikasi <span class="text-rose-500">*</span></label>
                <input type="date" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required
                       class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Status Terbit <span class="text-rose-500">*</span></label>
                <select id="status" name="status" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4">
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Terbitkan (Publish)</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draf (Simpan Saja)</option>
                </select>
            </div>
        </div>

        <!-- Ringkasan Singkat -->
        <div>
            <label for="ringkasan" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Ringkasan Singkat (Lead Paragraph)</label>
            <textarea id="ringkasan" name="ringkasan" rows="2" placeholder="1-2 kalimat pengantar yang akan tampil pada kartu cuplikan berita..."
                      class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('ringkasan') }}</textarea>
            @error('ringkasan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Gambar Sampul -->
        <div>
            <label for="gambar_sampul" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Berkas Gambar Sampul (Opsional)</label>
            <input type="file" id="gambar_sampul" name="gambar_sampul" accept="image/*"
                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200 leading-4">
            <span class="text-[11px] text-slate-400 mt-1 block">Format: JPG, PNG, WebP. Maksimal 2 MB.</span>
            @error('gambar_sampul') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Isi Konten Lengkap (TinyMCE Rich Text Editor) -->
        <div>
            <label for="editor-konten" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Isi Konten Lengkap <span class="text-rose-500">*</span></label>
            <textarea id="editor-konten" name="konten" rows="12">{{ old('konten') }}</textarea>
            @error('konten') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Opsi Sematkan (Pin) -->
        <div class="pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}
                       class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                <span class="text-xs font-semibold text-slate-700 leading-4">Sematkan sebagai Pengumuman Penting (Tampil di bagian teratas)</span>
            </label>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.posts.index') }}" class="h-11 px-5 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center leading-4">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm active:scale-[0.98] transition-all leading-4">
                Simpan & Terbitkan
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#editor-konten',
                license_key: 'gpl',
                height: 420,
                menubar: false,
                plugins: 'advlist autolink lists link image charmap preview searchreplace visualblocks code fullscreen table wordcount',
                toolbar: 'undo redo | blocks | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link | removeformat fullscreen',
                content_style: 'body { font-family: Poppins, sans-serif; font-size: 14px; line-height: 1.6; color: #334155; }',
                branding: false,
                promotion: false
            });
        }
    });
</script>
@endpush
