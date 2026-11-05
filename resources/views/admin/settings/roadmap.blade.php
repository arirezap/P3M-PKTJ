@extends('layouts.admin')

@section('title', 'Pengaturan Roadmap Penelitian')
@section('breadcrumb', 'CMS Portal / Profil / Roadmap Penelitian')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">Pengaturan Roadmap Penelitian</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola teks pengantar, narasi peta jalan, serta unggah berkas PDF Roadmap Penelitian PKTJ.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('profil.roadmap-penelitian') }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-all leading-4">
                <span>Lihat Halaman Publik</span>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Alert Kesalahan Validasi -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1">
            <div class="font-bold leading-5">Terjadi kesalahan pengisian formulir:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir CMS Pengaturan Roadmap -->
    <form method="POST" action="{{ route('admin.settings.roadmap.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Narasi & Teks Header Halaman -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 1</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Identitas & Narasi Pengantar</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Kustomisasi badge, judul utama, deskripsi pengantar, dan konten HTML tambahan.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="roadmap_badge" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Label Lencana (Badge)
                    </label>
                    <input type="text" id="roadmap_badge" name="roadmap_badge" value="{{ old('roadmap_badge', $settings['roadmap_badge'] ?? '') }}"
                           placeholder="Contoh: Peta Jalan Riset Terapan PKTJ"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('roadmap_badge') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="roadmap_title" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Judul Utama Halaman <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="roadmap_title" name="roadmap_title" value="{{ old('roadmap_title', $settings['roadmap_title'] ?? '') }}" required
                           placeholder="Contoh: Roadmap Penelitian"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('roadmap_title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="roadmap_lead" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Deskripsi / Paragraf Pengantar <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="roadmap_lead" name="roadmap_lead" rows="3" required
                              class="w-full p-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('roadmap_lead', $settings['roadmap_lead'] ?? '') }}</textarea>
                    @error('roadmap_lead') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="roadmap_custom_html" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Konten HTML / Catatan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea id="roadmap_custom_html" name="roadmap_custom_html" rows="4"
                              placeholder="Dapat diisi instruksi, maklumat klaster keilmuan, atau catatan pengantar dalam format HTML sederhana."
                              class="w-full p-4 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('roadmap_custom_html', $settings['roadmap_custom_html'] ?? '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1 leading-4">Konten ini akan dirender secara rapi di atas penampil berkas PDF.</p>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Dokumen PDF Roadmap Penelitian -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 2</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Berkas Dokumen Roadmap Penelitian</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Berkas digital yang akan langsung di-embed pada penampil dokumen publik.</p>
            </div>

            <div class="space-y-4">
                @if($roadmapDokumen)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div class="space-y-1">
                            <div class="font-bold text-slate-800 leading-4">{{ $roadmapDokumen->judul }}</div>
                            <div class="text-slate-500 leading-4">
                                Berkas: <code class="text-slate-600 bg-slate-200 px-1 py-1 rounded">{{ $roadmapDokumen->file_path }}</code> 
                                ({{ $roadmapDokumen->file_size }}) • Diunduh: {{ $roadmapDokumen->download_count }} kali
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $roadmapDokumen->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-semibold leading-4">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Buka Berkas Saat Ini</span>
                        </a>
                    </div>
                @else
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 leading-4">
                        Belum ada berkas PDF Roadmap Penelitian yang tersimpan. Silakan unggah berkas PDF baru di bawah ini.
                    </div>
                @endif

                <div>
                    <label for="file_roadmap" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Unggah / Ganti Berkas PDF Roadmap Penelitian <span class="text-slate-400 font-normal">(Maksimal 20 MB, Format .pdf)</span>
                    </label>
                    <input type="file" id="file_roadmap" name="file_roadmap" accept="application/pdf"
                           class="w-full text-xs text-slate-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 border border-slate-300 rounded-xl cursor-pointer">
                    @error('file_roadmap') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <a href="{{ route('admin.dashboard') }}" class="h-12 px-6 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all flex items-center justify-center leading-5">
                Batal
            </a>
            <button type="submit" class="h-12 px-8 rounded-xl bg-[#0B2A59] hover:bg-blue-900 active:scale-[0.98] text-white text-xs font-semibold shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 leading-5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Pengaturan & Berkas Roadmap</span>
            </button>
        </div>
    </form>

</div>
@endsection

