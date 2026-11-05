@extends('layouts.public')

@section('title', 'Rencana Strategis (Renstra) - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat PKTJ Tegal.')

@section('content')
<main class="flex-1">

    <!-- Breadcrumb Navigasi -->
    <nav aria-label="Breadcrumb" class="bg-slate-50 border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <li>
                    <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                </li>
                <li class="text-slate-400">/</li>
                <li>
                    <span class="text-slate-600">Profil</span>
                </li>
                <li class="text-slate-400">/</li>
                <li class="font-bold text-[#0B2A59]" aria-current="page">Rencana Strategis</li>
            </ol>
        </div>
    </nav>

    <!-- Header & Pengantar Halaman -->
    <section class="py-10 sm:py-12 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="max-w-3xl space-y-3">
                    @if(!empty($settings['renstra_badge']))
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                            <span>{{ $settings['renstra_badge'] }}</span>
                        </div>
                    @endif

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-8 sm:leading-9 lg:leading-10">
                        {{ $settings['renstra_title'] ?? 'Rencana Strategis Penelitian & Pengabdian kepada Masyarakat' }}
                    </h1>

                    <div class="w-20 h-1 bg-yellow-500 rounded"></div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-5 sm:leading-6">
                        {{ $settings['renstra_lead'] ?? 'Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.' }}
                    </p>
                </div>


            </div>

            @if(!empty($settings['renstra_custom_html']))
                <div class="pt-4 border-t border-slate-100 text-xs sm:text-sm text-slate-700 leading-6">
                    {!! $settings['renstra_custom_html'] !!}
                </div>
            @endif

        </div>
    </section>

    <!-- Konten Utama: Tab Interaktif Embed PDF Dokumen Renstra -->
    <section class="py-8 sm:py-12 bg-slate-50 min-h-[800px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="{ activeTab: 'penelitian' }">

            <!-- Navigasi Tab Interaktif (Penelitian vs Pengabdian) -->
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-200">
                <button type="button"
                        @click="activeTab = 'penelitian'"
                        :class="activeTab === 'penelitian' 
                            ? 'border-[#0B2A59] text-[#0B2A59] font-bold bg-white shadow-sm' 
                            : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100 bg-transparent'"
                        class="h-12 px-5 py-3 border-b-2 text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 rounded-t-xl leading-5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Dokumen Rencana Strategis Penelitian 2026-2031</span>
                </button>

                <button type="button"
                        @click="activeTab = 'pengabdian'"
                        :class="activeTab === 'pengabdian' 
                            ? 'border-[#0B2A59] text-[#0B2A59] font-bold bg-white shadow-sm' 
                            : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100 bg-transparent'"
                        class="h-12 px-5 py-3 border-b-2 text-xs sm:text-sm font-semibold transition-all flex items-center gap-2 rounded-t-xl leading-5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Dokumen Rencana Strategis Pengabdian Kepada Masyarakat</span>
                </button>
            </div>

            <!-- Tab 1: Dokumen Renstra Penelitian 2026-2031 -->
            <div x-show="activeTab === 'penelitian'" x-cloak class="space-y-4">
                
                <!-- Bar Aksi Dokumen Penelitian -->
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-800 leading-5">
                            {{ $renstraPenelitian->judul ?? 'Dokumen Rencana Strategis Penelitian 2026-2031' }}
                        </h2>
                    </div>

                    @if($renstraPenelitian)
                        <div class="flex-shrink-0">
                            <a href="{{ route('documents.download', $renstraPenelitian) }}"
                               class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl bg-[#0B2A59] hover:bg-blue-900 active:scale-[0.98] text-white text-xs font-semibold shadow-sm transition-all leading-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Berkas PDF</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Wadah Embed PDF Langsung -->
                @if($renstraPenelitian && Storage::disk('public')->exists($renstraPenelitian->file_path))
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-2">
                        <iframe src="{{ asset('storage/' . $renstraPenelitian->file_path) }}" 
                                class="w-full h-[768px] rounded-xl border border-slate-100 bg-slate-100" 
                                title="{{ $renstraPenelitian->judul }}"
                                loading="lazy">
                            <div class="p-8 text-center text-xs text-slate-500 space-y-2">
                                <p>Peramban Anda tidak mendukung penampil PDF langsung.</p>
                                <a href="{{ route('documents.download', $renstraPenelitian) }}" class="inline-flex items-center gap-1 font-bold text-[#0B2A59] underline">
                                    Unduh Berkas PDF {{ $renstraPenelitian->judul }}
                                </a>
                            </div>
                        </iframe>
                    </div>
                @else
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-3 shadow-sm">
                        <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-sm font-bold text-slate-700 leading-5">Dokumen Renstra Penelitian 2026-2031 Belum Diunggah</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-4">
                            Berkas digital sedang dalam pemutakhiran kelembagaan atau belum diunggah oleh Pengelola P3M.
                        </p>
                    </div>
                @endif

            </div>

            <!-- Tab 2: Dokumen Renstra Pengabdian Kepada Masyarakat -->
            <div x-show="activeTab === 'pengabdian'" x-cloak class="space-y-4">
                
                <!-- Bar Aksi Dokumen Pengabdian -->
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-800 leading-5">
                            {{ $renstraPengabdian->judul ?? 'Dokumen Rencana Strategis Pengabdian Kepada Masyarakat' }}
                        </h2>
                    </div>

                    @if($renstraPengabdian)
                        <div class="flex-shrink-0">
                            <a href="{{ route('documents.download', $renstraPengabdian) }}"
                               class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl bg-[#0B2A59] hover:bg-blue-900 active:scale-[0.98] text-white text-xs font-semibold shadow-sm transition-all leading-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Berkas PDF</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Wadah Embed PDF Langsung -->
                @if($renstraPengabdian && Storage::disk('public')->exists($renstraPengabdian->file_path))
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-2">
                        <iframe src="{{ asset('storage/' . $renstraPengabdian->file_path) }}" 
                                class="w-full h-[768px] rounded-xl border border-slate-100 bg-slate-100" 
                                title="{{ $renstraPengabdian->judul }}"
                                loading="lazy">
                            <div class="p-8 text-center text-xs text-slate-500 space-y-2">
                                <p>Peramban Anda tidak mendukung penampil PDF langsung.</p>
                                <a href="{{ route('documents.download', $renstraPengabdian) }}" class="inline-flex items-center gap-1 font-bold text-[#0B2A59] underline">
                                    Unduh Berkas PDF {{ $renstraPengabdian->judul }}
                                </a>
                            </div>
                        </iframe>
                    </div>
                @else
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-3 shadow-sm">
                        <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-sm font-bold text-slate-700 leading-5">Dokumen Renstra Pengabdian Belum Diunggah</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-4">
                            Berkas digital sedang dalam pemutakhiran kelembagaan atau belum diunggah oleh Pengelola P3M.
                        </p>
                    </div>
                @endif

            </div>

        </div>
    </section>

</main>
@endsection
