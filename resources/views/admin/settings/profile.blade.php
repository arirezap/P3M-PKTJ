@extends('layouts.admin')

@section('title', 'Pengaturan Beranda & Video Profil')

@section('content')
<div class="space-y-6" 
     x-data="{
         videoUrl: '{{ old('video_profile_url', $settings['video_profile_url'] ?? '') }}',
         get embedUrl() {
             let url = this.videoUrl.trim();
             if (!url) {
                 return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ?rel=0';
             }
             if (url.includes('youtube-nocookie.com/embed/') || url.includes('youtube.com/embed/')) {
                 return url.split('?')[0] + '?rel=0';
             }
             let match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/i);
             if (match && match[1]) {
                 return 'https://www.youtube-nocookie.com/embed/' + match[1] + '?rel=0';
             }
             if (url.length === 11 && !url.includes('/')) {
                 return 'https://www.youtube-nocookie.com/embed/' + url + '?rel=0';
             }
             return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ?rel=0';
         }
     }">

    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="text-xs text-slate-500 mb-1 flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0B2A59] transition-colors">Dasbor</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Pengaturan Beranda & Video</span>
            </nav>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0B2A59] tracking-tight leading-7 sm:leading-8">
                Pengaturan Beranda & Video Profil
            </h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Kelola tautan video YouTube, judul, serta teks narasi kelembagaan yang tampil pada halaman depan portal P3M PKTJ.
            </p>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Kesalahan Validasi -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm space-y-1">
            <div class="font-bold">Terdapat kesalahan pengisian:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Video Profil Hero Beranda -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Hero Banner Media</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Pengaturan Pemutar Video Profil</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Video profil akan langsung disematkan pada Banner Utama (Hero) halaman Beranda dengan rasio responsif 16:9.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Form Input Video (7 Kolom) -->
                <div class="lg:col-span-7 space-y-4">
                    <div>
                        <label for="video_profile_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                            Tautan Video YouTube <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="video_profile_url" 
                               name="video_profile_url" 
                               x-model="videoUrl"
                               class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all"
                               placeholder="Contoh: https://www.youtube.com/watch?v=5F_fNlPGBdQ atau https://youtu.be/5F_fNlPGBdQ"
                               required>
                        <p class="text-[11px] text-slate-400 mt-1.5 leading-4">
                            Mendukung tautan standar YouTube, tautan pendek (youtu.be), maupun URL embed.
                        </p>
                    </div>

                    <div>
                        <label for="video_profile_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                            Judul Video Profil <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="video_profile_title" 
                               name="video_profile_title" 
                               value="{{ old('video_profile_title', $settings['video_profile_title'] ?? '') }}"
                               class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all"
                               placeholder="Contoh: Video Profil P3M PKTJ Tegal"
                               required>
                    </div>

                    <div>
                        <label for="video_profile_desc" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                            Keterangan Ringkas Video
                        </label>
                        <textarea id="video_profile_desc" 
                                  name="video_profile_desc" 
                                  rows="3"
                                  class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                                  placeholder="Tuliskan keterangan singkat mengenai muatan video...">{{ old('video_profile_desc', $settings['video_profile_desc'] ?? '') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="video_profile_active" 
                                   value="1" 
                                   class="w-4 h-4 rounded border-slate-300 text-[#0B2A59] focus:ring-[#0B2A59]"
                                   {{ (!empty($settings['video_profile_active']) && $settings['video_profile_active'] == '1') ? 'checked' : '' }}>
                            <span class="text-xs font-semibold text-slate-700 leading-4">Aktifkan dan Tampilkan Video di Beranda</span>
                        </label>
                    </div>
                </div>

                <!-- Live Preview Video Player (5 Kolom) -->
                <div class="lg:col-span-5 bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 leading-4">Pratinjau Pemutar Video</span>
                        <span class="text-[10px] font-semibold uppercase tracking-wider bg-blue-100 text-[#0B2A59] px-2 py-0.5 rounded leading-3">Live Preview</span>
                    </div>

                    <!-- 16:9 Aspect Ratio Preview Container -->
                    <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-900 border border-slate-300 shadow-inner">
                        <iframe :src="embedUrl" 
                                class="w-full h-full" 
                                title="Pratinjau Video Profil" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>

                    <p class="text-[11px] text-slate-500 leading-4">
                        Pratinjau di atas merender langsung tampilan video saat diakses pengunjung portal publik.
                    </p>
                </div>

            </div>
        </div>

        <!-- Bagian 2: Teks Informasi Tentang P3M PKTJ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Konten Profil Lembaga</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Narasi Tentang P3M PKTJ</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Teks deskripsi kelembagaan dan visi misi yang tampil pada seksi Tentang P3M.
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="about_lead" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Paragraf Pengantar Lembaga
                    </label>
                    <textarea id="about_lead" 
                              name="about_lead" 
                              rows="3"
                              class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                              placeholder="Deskripsi peran unit P3M di bawah BPSDMP Kemenhub...">{{ old('about_lead', $settings['about_lead'] ?? '') }}</textarea>
                </div>

                <div>
                    <label for="about_vision_mission" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Visi & Komitmen Riset Vokasi
                    </label>
                    <textarea id="about_vision_mission" 
                              name="about_vision_mission" 
                              rows="4"
                              class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                              placeholder="Uraian komitmen riset keselamatan jalan...">{{ old('about_vision_mission', $settings['about_vision_mission'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Bagian 3: 3 Poin Fasilitas & Capaian Riset Lapangan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Sorotan Fasilitas</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">3 Poin Fasilitas & Capaian Unggulan</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Kartu informasi fasilitas laboratorium dan riset koridor yang menyertai video profil.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Poin 1 -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">Sorotan 1</div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Judul</label>
                        <input type="text" 
                               name="facility_1_title" 
                               value="{{ old('facility_1_title', $settings['facility_1_title'] ?? '') }}"
                               class="w-full px-3 h-10 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Deskripsi</label>
                        <textarea name="facility_1_desc" 
                                  rows="3" 
                                  class="w-full p-3 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] leading-4">{{ old('facility_1_desc', $settings['facility_1_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Poin 2 -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">Sorotan 2</div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Judul</label>
                        <input type="text" 
                               name="facility_2_title" 
                               value="{{ old('facility_2_title', $settings['facility_2_title'] ?? '') }}"
                               class="w-full px-3 h-10 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Deskripsi</label>
                        <textarea name="facility_2_desc" 
                                  rows="3" 
                                  class="w-full p-3 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] leading-4">{{ old('facility_2_desc', $settings['facility_2_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Poin 3 -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-xs font-bold text-[#0B2A59] uppercase tracking-wider leading-4">Sorotan 3</div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Judul</label>
                        <input type="text" 
                               name="facility_3_title" 
                               value="{{ old('facility_3_title', $settings['facility_3_title'] ?? '') }}"
                               class="w-full px-3 h-10 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 leading-3">Deskripsi</label>
                        <textarea name="facility_3_desc" 
                                  rows="3" 
                                  class="w-full p-3 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] leading-4">{{ old('facility_3_desc', $settings['facility_3_desc'] ?? '') }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
            <button type="submit" 
                    class="inline-flex items-center gap-2 h-12 px-6 rounded-xl font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] leading-5 text-xs sm:text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Simpan Pengaturan Beranda & Video</span>
            </button>
        </div>

    </form>
</div>
@endsection
