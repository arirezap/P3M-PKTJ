@extends('layouts.admin')

@section('title', 'Pengaturan Visi, Misi & Tujuan')
@section('breadcrumb', 'CMS Portal / Profil / Visi, Misi & Tujuan')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">Pengaturan Visi, Misi & Tujuan</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola narasi visi kelembagaan, 5 butir misi institusi, dan sasaran strategis mutu P3M PKTJ yang tampil pada portal publik.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('profil.visi-misi') }}" target="_blank" class="inline-flex items-center gap-1.5 h-10 px-4 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-all leading-4">
                <span>Lihat Halaman Publik</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi Berhasil -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium leading-5">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Formulir CMS Pengaturan Visi, Misi & Tujuan -->
    <form method="POST" action="{{ route('admin.settings.visi-misi.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Pernyataan Visi P3M -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 1</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Pernyataan Visi P3M</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Visi jangka menengah dan komitmen institusional di bawah BPSDMP Kemenhub.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="visi_title" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Judul Visi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="visi_title" name="visi_title" value="{{ old('visi_title', $settings['visi_title'] ?? '') }}" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('visi_title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="visi_statement" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Pernyataan Visi Utama <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="visi_statement" name="visi_statement" rows="3" required
                              class="w-full p-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-6">{{ old('visi_statement', $settings['visi_statement'] ?? '') }}</textarea>
                    @error('visi_statement') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="visi_subtext" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Narasi Penjelas / Komitmen Visi
                    </label>
                    <textarea id="visi_subtext" name="visi_subtext" rows="2"
                              class="w-full p-4 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('visi_subtext', $settings['visi_subtext'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Bagian 2: 5 Butir Misi Kelembagaan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 2</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">5 Butir Misi Kelembagaan</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Pilar operasional riset, pengabdian masyarakat, kemitraan, hilirisasi, dan tata kelola digital.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="misi_1" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Misi 1: Riset Terapan Keselamatan Jalan <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="misi_1" name="misi_1" rows="2" required
                              class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('misi_1', $settings['misi_1'] ?? '') }}</textarea>
                    @error('misi_1') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="misi_2" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Misi 2: Pengabdian Aksi Nyata & Desa Binaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="misi_2" name="misi_2" rows="2" required
                              class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('misi_2', $settings['misi_2'] ?? '') }}</textarea>
                    @error('misi_2') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="misi_3" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Misi 3: Kemitraan Strategis Transportasi <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="misi_3" name="misi_3" rows="2" required
                              class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('misi_3', $settings['misi_3'] ?? '') }}</textarea>
                    @error('misi_3') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="misi_4" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Misi 4: Hilirisasi HKI, Paten & Publikasi Jurnal
                    </label>
                    <textarea id="misi_4" name="misi_4" rows="2"
                              class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('misi_4', $settings['misi_4'] ?? '') }}</textarea>
                </div>

                <div>
                    <label for="misi_5" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Misi 5: Tata Kelola Digital & SIM P3M
                    </label>
                    <textarea id="misi_5" name="misi_5" rows="2"
                              class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('misi_5', $settings['misi_5'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Bagian 3: Tujuan Strategis & Sasaran Mutu -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 3</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Tujuan Strategis & Sasaran Mutu</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">4 Indikator capaian strategis luaran riset dan dampak sosial pengabdian kepada masyarakat.</p>
            </div>

            <div>
                <label for="tujuan_lead" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                    Pengantar Sasaran Strategis
                </label>
                <textarea id="tujuan_lead" name="tujuan_lead" rows="2"
                          class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('tujuan_lead', $settings['tujuan_lead'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <!-- Tujuan 1 -->
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Tujuan 1</span>
                    <div>
                        <label for="tujuan_1_title" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Judul Tujuan 1 <span class="text-rose-500">*</span></label>
                        <input type="text" id="tujuan_1_title" name="tujuan_1_title" value="{{ old('tujuan_1_title', $settings['tujuan_1_title'] ?? '') }}" required
                               class="w-full h-10 px-3 border border-slate-300 rounded-lg text-xs leading-4">
                    </div>
                    <div>
                        <label for="tujuan_1_desc" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Uraian Sasaran <span class="text-rose-500">*</span></label>
                        <textarea id="tujuan_1_desc" name="tujuan_1_desc" rows="3" required
                                  class="w-full p-3 border border-slate-300 rounded-lg text-xs leading-5">{{ old('tujuan_1_desc', $settings['tujuan_1_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Tujuan 2 -->
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Tujuan 2</span>
                    <div>
                        <label for="tujuan_2_title" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Judul Tujuan 2 <span class="text-rose-500">*</span></label>
                        <input type="text" id="tujuan_2_title" name="tujuan_2_title" value="{{ old('tujuan_2_title', $settings['tujuan_2_title'] ?? '') }}" required
                               class="w-full h-10 px-3 border border-slate-300 rounded-lg text-xs leading-4">
                    </div>
                    <div>
                        <label for="tujuan_2_desc" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Uraian Sasaran <span class="text-rose-500">*</span></label>
                        <textarea id="tujuan_2_desc" name="tujuan_2_desc" rows="3" required
                                  class="w-full p-3 border border-slate-300 rounded-lg text-xs leading-5">{{ old('tujuan_2_desc', $settings['tujuan_2_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Tujuan 3 -->
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Tujuan 3</span>
                    <div>
                        <label for="tujuan_3_title" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Judul Tujuan 3</label>
                        <input type="text" id="tujuan_3_title" name="tujuan_3_title" value="{{ old('tujuan_3_title', $settings['tujuan_3_title'] ?? '') }}"
                               class="w-full h-10 px-3 border border-slate-300 rounded-lg text-xs leading-4">
                    </div>
                    <div>
                        <label for="tujuan_3_desc" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Uraian Sasaran</label>
                        <textarea id="tujuan_3_desc" name="tujuan_3_desc" rows="3"
                                  class="w-full p-3 border border-slate-300 rounded-lg text-xs leading-5">{{ old('tujuan_3_desc', $settings['tujuan_3_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Tujuan 4 -->
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3">Tujuan 4</span>
                    <div>
                        <label for="tujuan_4_title" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Judul Tujuan 4</label>
                        <input type="text" id="tujuan_4_title" name="tujuan_4_title" value="{{ old('tujuan_4_title', $settings['tujuan_4_title'] ?? '') }}"
                               class="w-full h-10 px-3 border border-slate-300 rounded-lg text-xs leading-4">
                    </div>
                    <div>
                        <label for="tujuan_4_desc" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Uraian Sasaran</label>
                        <textarea id="tujuan_4_desc" name="tujuan_4_desc" rows="3"
                                  class="w-full p-3 border border-slate-300 rounded-lg text-xs leading-5">{{ old('tujuan_4_desc', $settings['tujuan_4_desc'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan Aksi -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <button type="reset" class="h-11 px-5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors leading-4">
                Batal Perubahan
            </button>
            <button type="submit" class="h-11 px-6 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-xs font-semibold text-white shadow-sm hover:shadow active:scale-[0.98] transition-all leading-4">
                Simpan & Publikasikan Visi, Misi & Tujuan
            </button>
        </div>

    </form>

</div>
@endsection
