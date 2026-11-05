@extends('layouts.admin')

@section('title', 'Pengaturan Visi, Misi & Tujuan')
@section('breadcrumb', 'CMS Portal / Profil / Visi, Misi & Tujuan')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">Pengaturan Visi, Misi & Tujuan</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola narasi visi kelembagaan, butir misi institusi, dan sasaran strategis mutu P3M PKTJ yang tampil pada portal publik.</p>
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

    <!-- Formulir CMS Pengaturan Visi, Misi & Tujuan -->
    <form method="POST" action="{{ route('admin.settings.visi-misi.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Identitas & Narasi Header Halaman -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 1</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Identitas & Narasi Header Halaman</h2>
                <p class="text-xs text-slate-500 mt-1 leading-4">Kustomisasi badge, judul utama halaman, dan deskripsi pengantar pada portal publik.</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="visi_badge" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Label Lencana (Badge)
                    </label>
                    <input type="text" id="visi_badge" name="visi_badge" value="{{ old('visi_badge', $settings['visi_badge'] ?? '') }}"
                           placeholder="Contoh: Arah Haluan Riset & Pengabdian PKTJ 2026 - 2031"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('visi_badge') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="page_title" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Judul Utama Halaman <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="page_title" name="page_title" value="{{ old('page_title', $settings['page_title'] ?? '') }}" required
                           placeholder="Contoh: Visi, Misi & Tujuan P3M"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    @error('page_title') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="page_lead" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Deskripsi / Paragraf Pengantar Halaman <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="page_lead" name="page_lead" rows="3" required
                              class="w-full p-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('page_lead', $settings['page_lead'] ?? '') }}</textarea>
                    @error('page_lead') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 2: Pernyataan Visi P3M -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 2</span>
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

        <!-- Bagian 3: Butir Misi Kelembagaan (Dinamis) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6"
             x-data="{
                misis: {{ json_encode(old('misi_items', $misiList)) }},
                addMisi() {
                    this.misis.push('');
                },
                removeMisi(index) {
                    if (this.misis.length > 1) {
                        this.misis.splice(index, 1);
                    }
                }
             }">
            <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 3</span>
                    <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Butir Misi Kelembagaan</h2>
                    <p class="text-xs text-slate-500 mt-0.5 leading-4">Pilar operasional riset terapan, pengabdian masyarakat, kemitraan strategis, dan tata kelola digital. Jumlah butir dapat ditambah atau dikurangi secara dinamis (minimal 1 butir).</p>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" @click="addMisi()"
                            class="inline-flex items-center gap-2 h-10 px-4 rounded-xl bg-blue-50 text-[#0B2A59] hover:bg-blue-100 border border-blue-200 text-xs font-semibold transition-colors leading-4">
                        <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Butir Misi</span>
                    </button>
                </div>
            </div>

            <!-- List Dinamis Misi -->
            <div class="space-y-4">
                <template x-for="(misi, index) in misis" :key="index">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2 relative transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-[#0B2A59] text-white text-xs font-bold flex items-center justify-center leading-4"
                                      x-text="String(index + 1).padStart(2, '0')"></span>
                                <span class="text-xs font-bold text-slate-700 leading-4" x-text="'Butir Misi ' + (index + 1)"></span>
                            </div>
                            <button type="button" 
                                    x-show="misis.length > 1"
                                    @click="removeMisi(index)"
                                    class="inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-medium transition-colors leading-4">
                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <textarea :name="'misi_items[]'" rows="2" required x-model="misis[index]"
                                  placeholder="Tuliskan pernyataan butir misi..."
                                  class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5 bg-white"></textarea>
                    </div>
                </template>
            </div>

            <!-- Tombol Tambah di Bawah List -->
            <div class="pt-2 flex justify-start">
                <button type="button" @click="addMisi()"
                        class="inline-flex items-center gap-2 h-10 px-4 rounded-xl border border-dashed border-slate-300 hover:border-[#0B2A59] text-xs font-semibold text-slate-700 hover:text-[#0B2A59] bg-white transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Butir Misi Baru</span>
                </button>
            </div>
        </div>

        <!-- Bagian 4: Tujuan Strategis & Sasaran Mutu (Dinamis) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6"
             x-data="{
                tujuans: {{ json_encode(old('tujuan_items', $tujuanList)) }},
                addTujuan() {
                    this.tujuans.push({ title: '', desc: '' });
                },
                removeTujuan(index) {
                    if (this.tujuans.length > 1) {
                        this.tujuans.splice(index, 1);
                    }
                }
             }">
            <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 4</span>
                    <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Tujuan Strategis & Sasaran Mutu</h2>
                    <p class="text-xs text-slate-500 mt-0.5 leading-4">Indikator capaian strategis luaran riset dan dampak kelembagaan. Jumlah sasaran dapat ditambah atau dikurangi secara dinamis (minimal 1 butir).</p>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" @click="addTujuan()"
                            class="inline-flex items-center gap-2 h-10 px-4 rounded-xl bg-blue-50 text-[#0B2A59] hover:bg-blue-100 border border-blue-200 text-xs font-semibold transition-colors leading-4">
                        <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Butir Sasaran</span>
                    </button>
                </div>
            </div>

            <div>
                <label for="tujuan_lead" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                    Pengantar Sasaran Strategis
                </label>
                <textarea id="tujuan_lead" name="tujuan_lead" rows="2"
                          class="w-full p-3.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] leading-5">{{ old('tujuan_lead', $settings['tujuan_lead'] ?? '') }}</textarea>
            </div>

            <!-- List Dinamis Sasaran Tujuan -->
            <div class="space-y-4 pt-2">
                <template x-for="(tujuan, index) in tujuans" :key="index">
                    <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-4 relative transition-all">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-yellow-500 text-slate-900 text-xs font-extrabold flex items-center justify-center leading-4"
                                      x-text="index + 1"></span>
                                <span class="text-xs font-bold text-slate-800 leading-4" x-text="'Sasaran / Tujuan Mutu ' + (index + 1)"></span>
                            </div>
                            <button type="button" 
                                    x-show="tujuans.length > 1"
                                    @click="removeTujuan(index)"
                                    class="inline-flex items-center gap-1.5 h-8 px-2.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-medium transition-colors leading-4">
                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                                    Judul Sasaran Mutu <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" :name="'tujuan_items[' + index + '][title]'" required x-model="tujuan.title"
                                       placeholder="Contoh: Publikasi Internasional Bereputasi"
                                       class="w-full h-10 px-3.5 border border-slate-300 rounded-lg text-xs leading-4 bg-white focus:ring-2 focus:ring-[#0B2A59]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                                    Uraian Sasaran & Target Capaian <span class="text-rose-500">*</span>
                                </label>
                                <textarea :name="'tujuan_items[' + index + '][desc]'" rows="3" required x-model="tujuan.desc"
                                          placeholder="Uraikan target capaian kuantitatif maupun kualitatif..."
                                          class="w-full p-3.5 border border-slate-300 rounded-lg text-xs leading-5 bg-white focus:ring-2 focus:ring-[#0B2A59]"></textarea>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Tombol Tambah di Bawah List -->
            <div class="pt-2 flex justify-start">
                <button type="button" @click="addTujuan()"
                        class="inline-flex items-center gap-2 h-10 px-4 rounded-xl border border-dashed border-slate-300 hover:border-[#0B2A59] text-xs font-semibold text-slate-700 hover:text-[#0B2A59] bg-white transition-colors leading-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Butir Sasaran Baru</span>
                </button>
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
