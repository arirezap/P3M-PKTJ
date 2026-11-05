@extends('layouts.admin')

@section('title', 'Pengaturan Rencana Strategis')
@section('breadcrumb', 'CMS Portal / Profil / Rencana Strategis')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">Pengaturan Rencana Strategis (Renstra)</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola teks pengantar, narasi kebijakan, serta unggah berkas PDF Renstra Penelitian dan Renstra Pengabdian PKTJ.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('profil.rencana-strategis') }}" target="_blank" class="inline-flex items-center gap-2 h-10 px-4 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-all leading-4">
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

    <!-- Formulir CMS Pengaturan Renstra -->
    <form method="POST" action="{{ route('admin.settings.renstra.update') }}" enctype="multipart/form-data" class="space-y-8">
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
                    <label for="renstra_badge" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Label Lencana (Badge)
                    </label>
                    <input type="text" id="renstra_badge" name="renstra_badge" value="{{ old('renstra_badge', $settings['renstra_badge'] ?? '') }}"
                           placeholder="Contoh: Arah Kebijakan Kelembagaan 2026 - 2031"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('renstra_badge') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="renstra_title" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Judul Utama Halaman <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="renstra_title" name="renstra_title" value="{{ old('renstra_title', $settings['renstra_title'] ?? '') }}" required
                           placeholder="Contoh: Rencana Strategis Penelitian & Pengabdian kepada Masyarakat"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('renstra_title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="renstra_lead" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Deskripsi / Paragraf Pengantar <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="renstra_lead" name="renstra_lead" rows="3" required
                              class="w-full p-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('renstra_lead', $settings['renstra_lead'] ?? '') }}</textarea>
                    @error('renstra_lead') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="renstra_custom_html" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Konten HTML / Catatan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea id="renstra_custom_html" name="renstra_custom_html" rows="4"
                              placeholder="Dapat diisi instruksi, maklumat arah kebijakan, atau catatan pengantar dalam format HTML sederhana."
                              class="w-full p-4 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('renstra_custom_html', $settings['renstra_custom_html'] ?? '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1 leading-4">Konten ini akan dirender secara rapi di atas penampil berkas PDF.</p>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Dokumen PDF Renstra Penelitian 2026-2031 -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 2</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Berkas Dokumen Renstra Penelitian 2026-2031</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Berkas digital yang akan langsung di-embed pada Tab Rencana Strategis Penelitian.</p>
            </div>

            <div class="space-y-4">
                @if($renstraPenelitian)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div class="space-y-1">
                            <div class="font-bold text-slate-800 leading-4">{{ $renstraPenelitian->judul }}</div>
                            <div class="text-slate-500 leading-4">
                                Berkas: <code class="text-slate-600 bg-slate-200 px-1 py-1 rounded">{{ $renstraPenelitian->file_path }}</code> 
                                ({{ $renstraPenelitian->file_size }}) • Diunduh: {{ $renstraPenelitian->download_count }} kali
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $renstraPenelitian->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-semibold leading-4">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Buka Berkas Saat Ini</span>
                        </a>
                    </div>
                @else
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 leading-4">
                        Belum ada berkas PDF Renstra Penelitian yang tersimpan. Silakan unggah berkas PDF baru di bawah ini.
                    </div>
                @endif

                <div>
                    <label for="file_renstra_penelitian" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Unggah / Ganti Berkas PDF Renstra Penelitian <span class="text-slate-400 font-normal">(Maksimal 20 MB, Format .pdf)</span>
                    </label>
                    <input type="file" id="file_renstra_penelitian" name="file_renstra_penelitian" accept="application/pdf"
                           class="w-full text-xs text-slate-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 border border-slate-300 rounded-xl cursor-pointer">
                    @error('file_renstra_penelitian') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 3: Dokumen PDF Renstra Pengabdian Kepada Masyarakat -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 3</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Berkas Dokumen Renstra Pengabdian kepada Masyarakat</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Berkas digital yang akan langsung di-embed pada Tab Rencana Strategis Pengabdian.</p>
            </div>

            <div class="space-y-4">
                @if($renstraPengabdian)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div class="space-y-1">
                            <div class="font-bold text-slate-800 leading-4">{{ $renstraPengabdian->judul }}</div>
                            <div class="text-slate-500 leading-4">
                                Berkas: <code class="text-slate-600 bg-slate-200 px-1 py-1 rounded">{{ $renstraPengabdian->file_path }}</code> 
                                ({{ $renstraPengabdian->file_size }}) • Diunduh: {{ $renstraPengabdian->download_count }} kali
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $renstraPengabdian->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-semibold leading-4">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Buka Berkas Saat Ini</span>
                        </a>
                    </div>
                @else
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 leading-4">
                        Belum ada berkas PDF Renstra Pengabdian yang tersimpan. Silakan unggah berkas PDF baru di bawah ini.
                    </div>
                @endif

                <div>
                    <label for="file_renstra_pengabdian" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Unggah / Ganti Berkas PDF Renstra Pengabdian <span class="text-slate-400 font-normal">(Maksimal 20 MB, Format .pdf)</span>
                    </label>
                    <input type="file" id="file_renstra_pengabdian" name="file_renstra_pengabdian" accept="application/pdf"
                           class="w-full text-xs text-slate-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 border border-slate-300 rounded-xl cursor-pointer">
                    @error('file_renstra_pengabdian') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
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
                <span>Simpan Pengaturan & Berkas Renstra</span>
            </button>
        </div>
    </form>

</div>
@endsection
