@extends('layouts.admin')

@section('title', 'Pengaturan Beranda & Video Profil')

@section('content')
<div class="space-y-6" 
     x-data="{
         videoUrl: '{{ old('video_profile_url', $settings['video_profile_url'] ?? '') }}',
         get embedUrl() {
             let url = this.videoUrl.trim();
             let queryParam = '?autoplay=1&mute=1&playsinline=1&rel=0';
             if (!url) {
                 return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ' + queryParam;
             }
             if (url.includes('youtube-nocookie.com/embed/') || url.includes('youtube.com/embed/')) {
                 return url.split('?')[0] + queryParam;
             }
             let match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/i);
             if (match && match[1]) {
                 return 'https://www.youtube-nocookie.com/embed/' + match[1] + queryParam;
             }
             if (url.length === 11 && !url.includes('/')) {
                 return 'https://www.youtube-nocookie.com/embed/' + url + queryParam;
             }
             return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ' + queryParam;
         }
     }">

    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="text-xs text-slate-500 mb-1 flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0B2A59] transition-colors">Dasbor</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Pengaturan Beranda</span>
            </nav>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0B2A59] tracking-tight leading-7 sm:leading-8">
                Pengaturan Konten Beranda & Video Profil
            </h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Kelola seluruh teks judul, narasi Tentang P3M PKTJ, pemutar video profil, dan teks seksi Berita Terkini pada halaman portal depan.
            </p>
        </div>
    </div>

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

        <!-- Bagian 1: Judul Utama & Narasi Tentang P3M PKTJ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pengantar Beranda</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Judul Utama & Narasi Tentang P3M PKTJ</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Konfigurasi teks judul utama (Hero) dan uraian profil kelembagaan yang tampil pada sisi kiri halaman Beranda.
                </p>
            </div>

            <div class="space-y-5">
                <!-- Lencana Hero -->
                <div>
                    <label for="hero_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Lencana Atas (Badge Hero)
                    </label>
                    <input type="text" 
                           id="hero_badge" 
                           name="hero_badge" 
                           value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                           class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all"
                           placeholder="Contoh: Pusat Penelitian & Pengabdian kepada Masyarakat PKTJ">
                </div>

                <!-- Judul Utama Hero -->
                <div>
                    <label for="hero_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Judul Utama Beranda (Headline) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="hero_title" 
                           name="hero_title" 
                           value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                           class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all font-semibold"
                           placeholder="Contoh: Riset Unggulan & Pengabdian Berbasis Keselamatan Transportasi Jalan"
                           required>
                </div>

                <!-- Judul Seksi Tentang P3M -->
                <div>
                    <label for="about_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Judul Seksi Tentang P3M <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="about_title" 
                           name="about_title" 
                           value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                           class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all"
                           placeholder="Contoh: Tentang Pusat Penelitian dan Pengabdian kepada Masyarakat"
                           required>
                </div>

                <!-- Paragraf Pengantar Lembaga -->
                <div>
                    <label for="about_lead" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Paragraf Pengantar Lembaga
                    </label>
                    <textarea id="about_lead" 
                              name="about_lead" 
                              rows="3"
                              class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                              placeholder="Deskripsi peran kelembagaan P3M di bawah BPSDMP Kemenhub...">{{ old('about_lead', $settings['about_lead'] ?? '') }}</textarea>
                </div>

                <!-- Paragraf Visi, Misi & 3 Prodi -->
                <div>
                    <label for="about_vision_mission" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Uraian Tugas Pokok & Keterlibatan 3 Program Studi
                    </label>
                    <textarea id="about_vision_mission" 
                              name="about_vision_mission" 
                              rows="3"
                              class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                              placeholder="Tugas P3M dalam mendiseminasikan riset dan pengabdian 3 prodi PKTJ...">{{ old('about_vision_mission', $settings['about_vision_mission'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Pemutar Video Profil P3M PKTJ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Media Beranda</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Pengaturan Pemutar Video Profil</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Video profil disematkan pada sisi kanan berdampingan dengan narasi Tentang P3M PKTJ (rasio 16:9 responsif).
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
                               placeholder="Contoh: https://www.youtube.com/watch?v=5F_fNlPGBdQ"
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
                                  rows="2"
                                  class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                                  placeholder="Keterangan singkat mengenai muatan video...">{{ old('video_profile_desc', $settings['video_profile_desc'] ?? '') }}</textarea>
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

        <!-- Bagian 3: Teks Pengantar Seksi Berita Terkini -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Seksi Berita</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Pengantar Seksi Berita Terkini</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Konfigurasi lencana, judul, dan subjudul yang tampil pada bagian Berita Terkini di halaman Beranda.
                </p>
            </div>

            <div class="space-y-5">
                <div>
                    <label for="news_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Lencana Seksi Berita
                    </label>
                    <input type="text" 
                           id="news_badge" 
                           name="news_badge" 
                           value="{{ old('news_badge', $settings['news_badge'] ?? '') }}"
                           class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all"
                           placeholder="Contoh: Informasi & Diseminasi Riset">
                </div>

                <div>
                    <label for="news_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Judul Utama Seksi Berita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="news_title" 
                           name="news_title" 
                           value="{{ old('news_title', $settings['news_title'] ?? '') }}"
                           class="w-full px-4 h-11 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all font-semibold"
                           placeholder="Contoh: Berita Terkini dan Agenda P3M PKTJ"
                           required>
                </div>

                <div>
                    <label for="news_desc" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 leading-4">
                        Subjudul / Keterangan Berita
                    </label>
                    <textarea id="news_desc" 
                              name="news_desc" 
                              rows="2"
                              class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-transparent transition-all leading-5"
                              placeholder="Deskripsi singkat mengenai publikasi berita...">{{ old('news_desc', $settings['news_desc'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan (Tinggi 48px, Ramah Sentuh) -->
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] leading-5 text-xs sm:text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Simpan Pengaturan Beranda</span>
            </button>
        </div>

    </form>
</div>
@endsection
