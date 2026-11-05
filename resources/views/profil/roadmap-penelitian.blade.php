@extends('layouts.public')

@section('title', ($settings['roadmap_title'] ?? 'Roadmap Penelitian') . ' - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Dokumen Roadmap Penelitian Keselamatan Transportasi PKTJ Tegal.')

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
                <li class="font-bold text-[#0B2A59]" aria-current="page">Roadmap Penelitian</li>
            </ol>
        </div>
    </nav>

    <!-- Header & Pengantar Halaman -->
    <section class="py-10 sm:py-12 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="max-w-3xl space-y-3">
                    @if(!empty($settings['roadmap_badge']))
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                            <span>{{ $settings['roadmap_badge'] }}</span>
                        </div>
                    @endif

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-8 sm:leading-9 lg:leading-10">
                        {{ $settings['roadmap_title'] ?? 'Roadmap Penelitian' }}
                    </h1>

                    <div class="w-20 h-1 bg-yellow-500 rounded"></div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-5 sm:leading-6">
                        {{ $settings['roadmap_lead'] ?? 'Dokumen Roadmap Penelitian Politeknik Keselamatan Transportasi Jalan.' }}
                    </p>
                </div>
            </div>

            @if(!empty($settings['roadmap_custom_html']))
                <div class="pt-4 border-t border-slate-100 text-xs sm:text-sm text-slate-700 leading-6">
                    {!! $settings['roadmap_custom_html'] !!}
                </div>
            @endif

        </div>
    </section>

    <!-- Konten Utama: Penampil PDF Dokumen Roadmap Penelitian Langsung -->
    <section class="py-8 sm:py-12 bg-slate-50 min-h-[800px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            <!-- Bar Aksi Dokumen Roadmap -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-800 leading-5">
                        {{ $roadmapDokumen->judul ?? 'Dokumen Roadmap Penelitian PKTJ' }}
                    </h2>
                </div>

                @if($roadmapDokumen)
                    <div class="flex-shrink-0">
                        <a href="{{ route('documents.download', $roadmapDokumen) }}"
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
            @if($roadmapDokumen && Storage::disk('public')->exists($roadmapDokumen->file_path))
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-2">
                    <iframe src="{{ asset('storage/' . $roadmapDokumen->file_path) }}" 
                            class="w-full h-[768px] rounded-xl border border-slate-100 bg-slate-100" 
                            title="{{ $roadmapDokumen->judul }}"
                            loading="lazy">
                        <div class="p-8 text-center text-xs text-slate-500 space-y-2">
                            <p>Peramban Anda tidak mendukung penampil PDF langsung.</p>
                            <a href="{{ route('documents.download', $roadmapDokumen) }}" class="inline-flex items-center gap-1 font-bold text-[#0B2A59] underline">
                                Unduh Berkas PDF {{ $roadmapDokumen->judul }}
                            </a>
                        </div>
                    </iframe>
                </div>
            @else
                <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-3 shadow-sm">
                    <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-sm font-bold text-slate-700 leading-5">Dokumen Roadmap Penelitian Belum Diunggah</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto leading-4">
                        Berkas digital sedang dalam pemutakhiran kelembagaan atau belum diunggah oleh Pengelola P3M.
                    </p>
                </div>
            @endif

        </div>
    </section>

</main>
@endsection
