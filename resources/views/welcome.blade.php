@extends('layouts.public')

@section('title', 'P3M PKTJ - Pusat Penelitian dan Pengabdian kepada Masyarakat')
@section('meta_description', 'Portal Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal. Riset unggulan keselamatan transportasi jalan dan pengabdian vokasi.')

@section('content')
<div x-data="{ 
    isReaderOpen: false, 
    currentPost: null, 
    postsList: {{ Js::from($postsData) }},
    openReaderById(id) { 
        const found = this.postsList.find(p => p.id === id);
        if (found) {
            this.currentPost = found; 
            this.isReaderOpen = true; 
            document.body.classList.add('overflow-hidden'); 
        }
    }, 
    closeReader() { 
        this.isReaderOpen = false; 
        this.currentPost = null; 
        document.body.classList.remove('overflow-hidden'); 
    } 
}"
@keydown.escape.window="closeReader()">

    <main class="flex-1">

        <!-- 1. Seksi Utama Berdampingan: Tentang P3M PKTJ & Video Profil (Sesuai Kebutuhan Halaman 1) -->
        <section id="beranda" 
                 x-data="{ heroLoaded: false }" 
                 x-init="setTimeout(() => heroLoaded = true, 50)" 
                 class="relative bg-white py-12 sm:py-16 lg:py-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Kolom Kiri: Tentang P3M PKTJ (7 Kolom) -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- Headline & Identitas Kelembagaan -->
                        <div class="space-y-4 transition-all duration-300 ease-out transform"
                             :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                                <span>{!! $settings['hero_badge'] ?? 'Pusat Penelitian & Pengabdian kepada Masyarakat PKTJ' !!}</span>
                            </div>
                            <h1 class="text-3xl sm:text-4xl lg:text-[40px] xl:text-[44px] font-extrabold text-slate-900 tracking-tight leading-[40px] sm:leading-[48px] lg:leading-[50px] xl:leading-[54px]">
                                {!! $settings['hero_title'] ?? 'Riset Unggulan & Pengabdian Berbasis Keselamatan Transportasi Jalan' !!}
                            </h1>
                            <div class="w-20 h-1 bg-yellow-500 rounded"></div>
                        </div>

                        <!-- Narasi Tentang P3M PKTJ -->
                        <div class="space-y-3 transition-all duration-300 delay-100 ease-out transform"
                             :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                            <h2 class="text-lg sm:text-xl font-bold text-[#0B2A59] leading-6 sm:leading-7">
                                {!! $settings['about_title'] ?? 'Tentang Pusat Penelitian dan Pengabdian kepada Masyarakat' !!}
                            </h2>
                            <p class="text-sm sm:text-base text-slate-600 leading-6 sm:leading-7">
                                {{ $settings['about_lead'] ?? 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana akademik di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.' }}
                            </p>
                            <p class="text-xs sm:text-sm text-slate-600 leading-5 sm:leading-6">
                                {{ $settings['about_vision_mission'] ?? 'P3M PKTJ bertugas mengoordinasikan, memfasilitasi, dan mendiseminasikan hasil penelitian terapan dan pengabdian masyarakat dosen dan taruna demi meningkatkan keselamatan transportasi darat nasional.' }}
                            </p>
                            <!-- Kepatuhan 3 Program Studi di Lingkungan PKTJ (Ringkas & Proporsional) -->
                            <div class="pt-2 flex flex-wrap items-center gap-2 text-xs">
                                <span class="text-slate-500 font-medium">3 Program Studi PKTJ:</span>
                                <span class="px-3 py-1 rounded bg-slate-100 text-[#0B2A59] font-bold">D4 RSTJ</span>
                                <span class="px-3 py-1 rounded bg-slate-100 text-[#0B2A59] font-bold">D4 TRO</span>
                                <span class="px-3 py-1 rounded bg-slate-100 text-[#0B2A59] font-bold">D3 TO</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi Cepat (Ramah Sentuh >= 44px) -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2 transition-all duration-300 delay-200 ease-out transform"
                             :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                            <a href="#berita-terkini" class="inline-flex items-center justify-center h-12 px-6 rounded-lg text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow active:scale-[0.98] focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] leading-5 whitespace-nowrap">
                                Lihat Berita Terkini
                            </a>
                        </div>

                    </div>

                    <!-- Kolom Kanan: Video Profil P3M PKTJ (5 Kolom - Responsive 16:9) -->
                    <div id="video-profil" 
                         class="lg:col-span-5 transition-all duration-300 delay-150 ease-out transform"
                         :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'">
                        
                        <div class="bg-[#0B2A59] rounded-2xl p-4 sm:p-5 shadow-xl border-2 border-slate-200 space-y-3">
                            <div class="flex items-center justify-between text-white">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                                    <span class="text-xs font-bold uppercase tracking-wider leading-4">Video Profil P3M</span>
                                </div>
                                <span class="text-[10px] font-semibold bg-yellow-400 text-[#0B2A59] px-2 py-1 rounded leading-3">PKTJ Tegal</span>
                            </div>

                            <!-- Frame Video 16:9 Rasio Asli -->
                            <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-950 border border-slate-700 shadow-inner">
                                <iframe src="{{ $videoEmbedUrl }}" 
                                        class="w-full h-full" 
                                        title="{{ $settings['video_profile_title'] ?? 'Video Profil P3M PKTJ Tegal' }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        loading="lazy">
                                </iframe>
                            </div>

                            <div class="pt-1">
                                <h2 class="text-sm font-bold text-white leading-5">
                                    {{ $settings['video_profile_title'] ?? 'Video Profil P3M PKTJ Tegal' }}
                                </h2>
                                <p class="text-xs text-slate-300 leading-4 mt-1 line-clamp-2">
                                    {{ $settings['video_profile_desc'] ?? 'Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi' }}
                                </p>
                            </div>

                            <!-- Tombol Fungsional Pemutar Video (Tonton di YouTube & Salin Tautan) -->
                            <div class="pt-2 border-t border-blue-900/60 flex items-center justify-between text-xs" x-data="{ copied: false }">
                                <a href="{{ $settings['video_profile_url'] ?? 'https://www.youtube.com/watch?v=5F_fNlPGBdQ' }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="inline-flex items-center gap-2 text-yellow-400 hover:text-yellow-300 font-semibold transition-colors py-1">
                                    <span>Buka di YouTube</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                                <button type="button" 
                                        @click="navigator.clipboard.writeText('{{ $settings['video_profile_url'] ?? 'https://www.youtube.com/watch?v=5F_fNlPGBdQ' }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                        class="inline-flex items-center gap-1 text-slate-300 hover:text-white transition-colors py-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="copied ? 'Tautan Tersalin' : 'Salin Tautan'">Salin Tautan</span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- 2. Seksi Berita Terkini (Sesuai Kebutuhan Halaman 1: Grid Kartu Bersih & Minimalis) -->
        <section id="berita-terkini" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-200 pb-4">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">
                            {{ $settings['news_badge'] ?? 'Informasi & Diseminasi Riset' }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">
                            {{ $settings['news_title'] ?? 'Berita Terkini dan Agenda P3M PKTJ' }}
                        </h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md leading-5">
                        {{ $settings['news_desc'] ?? 'Publikasi Berita Terkini, jadwal seleksi proposal, dan warta diseminasi riset terapan sivitas akademika PKTJ.' }}
                    </p>
                </div>

                @if($publishedPosts->isNotEmpty())
                    <!-- Grid Kartu Berita Terpadu (1 Kolom Mobile, 2 Kolom Tablet, 3 Kolom Desktop) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                        @foreach($publishedPosts as $itemBerita)
                            <article class="bg-white border border-slate-200 hover:border-slate-300 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                                <div class="space-y-3">
                                    <!-- Gambar Sampul atau Wadah Placeholder -->
                                    <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200">
                                        @if($itemBerita->gambar_sampul)
                                            <img src="{{ asset('storage/' . $itemBerita->gambar_sampul) }}" 
                                                 alt="{{ $itemBerita->judul }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                                <span class="text-[11px] font-medium text-slate-400 mt-1">P3M PKTJ</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Metadata: Kategori & Tanggal -->
                                    <div class="flex items-center gap-2 text-xs text-slate-500 leading-4 pt-1">
                                        <span class="px-2 py-1 rounded bg-blue-50 text-[#0B2A59] font-bold uppercase text-[10px] tracking-wider border border-blue-100">
                                            {{ $itemBerita->kategori }}
                                        </span>
                                        <span>&bull;</span>
                                        <span>{{ $itemBerita->tanggal_publikasi ? $itemBerita->tanggal_publikasi->translatedFormat('d F Y') : '-' }}</span>
                                    </div>

                                    <!-- Judul Berita -->
                                    <h3 class="text-base font-bold text-slate-900 group-hover:text-[#0B2A59] transition-colors leading-6 line-clamp-2">
                                        {{ $itemBerita->judul }}
                                    </h3>

                                    <!-- Ringkasan Teks -->
                                    <p class="text-xs text-slate-600 leading-5 line-clamp-3">
                                        {{ $itemBerita->ringkasan ?? Str::limit(strip_tags($itemBerita->konten), 120) }}
                                    </p>
                                </div>

                                <!-- Tombol Baca Selengkapnya -->
                                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                    <button type="button" 
                                            @click="openReaderById({{ $itemBerita->id }})"
                                            class="inline-flex items-center gap-2 text-xs font-bold text-[#0B2A59] hover:text-blue-900 hover:underline leading-4 group-hover:translate-x-0.5 transition-all">
                                        <span>Baca Selengkapnya</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <!-- Tampilan Kartu Saat Basis Data Kosong (Empty State) -->
                    <div class="p-12 text-center text-xs text-slate-400 border border-dashed border-slate-300 rounded-2xl bg-white space-y-2">
                        <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-slate-500 font-medium">Belum ada berita kegiatan yang dipublikasikan.</p>
                        <p class="text-slate-400 text-[11px]">Warta dan pengumuman terbaru akan ditampilkan pada seksi ini setelah diterbitkan.</p>
                    </div>
                @endif

            </div>
        </section>

    </main>

    <!-- Modal Interaktif Pembaca Berita & Pengumuman P3M (Alpine.js Responsive Modal Reader) -->
    <div x-show="isReaderOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" 
         aria-modal="true"
         aria-labelledby="modal-post-title">
        
        <!-- Backdrop Blur -->
        <div x-show="isReaderOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm"
             @click="closeReader()">
        </div>

        <!-- Jendela Dialog Modal -->
        <div class="min-h-full flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div x-show="isReaderOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col overflow-hidden border border-slate-200"
                 @click.stop="">
                
                <!-- Header Modal -->
                <div class="p-4 sm:p-6 border-b border-slate-200 flex items-center justify-between bg-slate-50 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded bg-[#0B2A59] text-white font-bold text-xs uppercase tracking-wider" x-text="currentPost ? currentPost.kategori : 'Berita'">Berita</span>
                        <span class="text-xs text-slate-500 font-medium" x-text="currentPost ? currentPost.tanggal : '-'">-</span>
                    </div>
                    <button type="button" 
                            @click="closeReader()" 
                            class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-200 transition-colors"
                            aria-label="Tutup jendela baca">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Konten Pembaca Modal (Scrollable) -->
                <div class="p-6 sm:p-8 overflow-y-auto space-y-6 flex-1 text-slate-800">
                    <template x-if="currentPost">
                        <div class="space-y-6">
                            <template x-if="currentPost.gambar_sampul">
                                <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img :src="currentPost.gambar_sampul" :alt="currentPost.judul" class="w-full h-full object-cover">
                                </div>
                            </template>
                            
                            <h2 id="modal-post-title" class="text-xl sm:text-2xl font-extrabold text-[#0B2A59] tracking-tight leading-7 sm:leading-8" x-text="currentPost.judul"></h2>
                            
                            <div class="prose prose-sm max-w-none text-slate-600 space-y-4 leading-6 sm:leading-7" x-html="currentPost.konten"></div>
                        </div>
                    </template>
                </div>

                <!-- Footer Modal -->
                <div class="p-4 sm:p-6 border-t border-slate-200 bg-slate-50 flex items-center justify-between flex-shrink-0 text-xs">
                    <span class="text-slate-500 font-medium">Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ</span>
                    <button type="button" 
                            @click="closeReader()" 
                            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
