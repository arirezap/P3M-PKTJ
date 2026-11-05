@extends('layouts.public')

@section('title', 'Profil Peneliti & Dosen - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori profil dosen dan peneliti aktif P3M Politeknik Keselamatan Transportasi Jalan Tegal.')

@section('content')
<main class="flex-1">

    <!-- Breadcrumb & Hero Header -->
    <section class="bg-gradient-to-b from-slate-50 via-white to-slate-50 border-b border-slate-200 py-10 sm:py-12 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 leading-4 flex-wrap">
                <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-slate-400">Profil</span>
                <span>/</span>
                <span class="font-semibold text-[#0B2A59]">Profil Peneliti</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#0B2A59] text-xs font-semibold tracking-wide leading-4">
                        <span class="w-2 h-2 rounded-full bg-[#0B2A59]"></span>
                        <span>Basis Data Kepakaran Riset Terapan & Publikasi</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-10">Direktori Dosen &amp; Peneliti PKTJ</h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-6 max-w-2xl">
                        Daftar dosen dan peneliti aktif di lingkungan Politeknik Keselamatan Transportasi Jalan beserta profil kepakaran, rekapitulasi riset terapan, dan publikasi ilmiah luaran HKI.
                    </p>
                </div>

                <!-- 3 Kartu Statistik Ringkas -->
                <div class="grid grid-cols-3 gap-3 sm:gap-4 flex-shrink-0">
                    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-center">
                        <div class="text-xl sm:text-2xl font-bold text-[#0B2A59] leading-7">{{ $totalPeneliti }}</div>
                        <div class="text-xs font-medium text-slate-500 mt-1 leading-4">Peneliti Aktif</div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-center">
                        <div class="text-xl sm:text-2xl font-bold text-amber-600 leading-7">{{ $totalRiset }}</div>
                        <div class="text-xs font-medium text-slate-500 mt-1 leading-4">Kegiatan Riset</div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-center">
                        <div class="text-xl sm:text-2xl font-bold text-emerald-600 leading-7">{{ $totalPublikasi }}</div>
                        <div class="text-xs font-medium text-slate-500 mt-1 leading-4">Publikasi & HKI</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Bilah Filter & Pencarian -->
    <section class="bg-white border-b border-slate-200 sticky top-20 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" action="{{ route('profil.peneliti') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                
                <!-- Tab Filter Program Studi (3 Prodi) -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs">
                    <a href="{{ route('profil.peneliti', array_merge(request()->except(['prodi', 'page']), ['prodi' => 'semua'])) }}"
                       class="h-10 px-4 inline-flex items-center justify-center rounded-lg font-semibold transition-colors whitespace-nowrap leading-4 {{ !request('prodi') || request('prodi') == 'semua' ? 'bg-[#0B2A59] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Semua Prodi
                    </a>
                    @foreach($prodis as $pr)
                        <a href="{{ route('profil.peneliti', array_merge(request()->except(['prodi', 'page']), ['prodi' => strtolower($pr->kode_prodi)])) }}"
                           class="h-10 px-4 inline-flex items-center justify-center rounded-lg font-semibold transition-colors whitespace-nowrap leading-4 {{ strtolower(request('prodi')) == strtolower($pr->kode_prodi) ? 'bg-[#0B2A59] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $pr->kode_prodi }}
                        </a>
                    @endforeach
                </div>

                <!-- Input Pencarian Instan -->
                <div class="flex items-center gap-2 max-w-md w-full">
                    @if(request('prodi'))
                        <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                    @endif
                    <div class="relative w-full">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama dosen, NIDN, atau fokus keahlian..." 
                               class="w-full h-10 pl-9 pr-3 text-xs border border-slate-300 rounded-lg focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit" class="h-10 px-4 bg-[#0B2A59] text-white text-xs font-semibold rounded-lg hover:bg-blue-900 transition-colors whitespace-nowrap leading-4">
                        Cari
                    </button>
                    @if(request()->hasAny(['prodi', 'q']))
                        <a href="{{ route('profil.peneliti') }}" class="h-10 px-4 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4 whitespace-nowrap">
                            Atur Ulang
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </section>

    <!-- Daftar Kartu Peneliti (Grid 4px Multiples) -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($peneliti->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($peneliti as $dosen)
                        <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                            <div class="space-y-4">
                                
                                <!-- Foto & Afiliasi -->
                                <div class="flex items-start gap-4">
                                    <a href="{{ route('profil.peneliti.show', $dosen) }}" class="block flex-shrink-0 group">
                                        @if($dosen->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($dosen->avatar))
                                            <img src="{{ asset('storage/' . $dosen->avatar) }}" alt="{{ $dosen->name }}" 
                                                 class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-100 shadow-sm group-hover:opacity-90 transition-opacity">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#0B2A59] to-blue-900 text-white font-bold text-xl flex items-center justify-center shadow-sm group-hover:opacity-90 transition-opacity">
                                                {{ strtoupper(substr($dosen->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>

                                    <div class="flex-1 min-w-0">
                                        @if($dosen->prodi)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold tracking-wider uppercase leading-4
                                                {{ $dosen->prodi->kode_prodi === 'RSTJ' ? 'bg-blue-100 text-blue-800' : ($dosen->prodi->kode_prodi === 'TRO' ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800') }}">
                                                {{ $dosen->prodi->jenjang }} {{ $dosen->prodi->kode_prodi }}
                                            </span>
                                        @endif
                                        <h2 class="text-sm font-bold text-slate-900 mt-1 leading-5 line-clamp-2">
                                            <a href="{{ route('profil.peneliti.show', $dosen) }}" class="text-[#0B2A59] hover:text-blue-800 hover:underline transition-colors">
                                                {{ $dosen->name }}
                                            </a>
                                        </h2>
                                        <p class="text-xs text-slate-500 mt-1 leading-4">
                                            NIDN/NIP: <span class="font-medium text-slate-700">{{ $dosen->nidn_nip ?? '-' }}</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Bidang Keahlian / Fokus Riset -->
                                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                                    <div class="text-xs uppercase font-bold text-slate-400 tracking-wider leading-4">Fokus Riset & Kepakaran</div>
                                    <p class="text-xs font-medium text-slate-700 leading-4 line-clamp-2">
                                        {{ $dosen->keahlian ?? 'Riset Keselamatan Transportasi Terapan' }}
                                    </p>
                                </div>

                                <!-- Metrik Luaran & Tautan Akademik -->
                                <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                                    <div class="flex items-center gap-3 text-slate-600">
                                        <span class="font-semibold text-[#0B2A59]">{{ $dosen->researches->count() }} <span class="text-slate-400 font-normal">Riset</span></span>
                                        <span>&bull;</span>
                                        <span class="font-semibold text-emerald-700">{{ $dosen->outputs->count() }} <span class="text-slate-400 font-normal">Publikasi/HKI</span></span>
                                    </div>

                                    <!-- Badge Tautan Eksternal SINTA / Scopus -->
                                    <div class="flex items-center gap-2">
                                        @if($dosen->sinta_id)
                                            <span class="px-2 py-1 bg-orange-50 border border-orange-200 text-orange-800 text-xs font-bold rounded" title="SINTA ID: {{ $dosen->sinta_id }}">
                                                SINTA
                                            </span>
                                        @endif
                                        @if($dosen->scopus_id)
                                            <span class="px-2 py-1 bg-cyan-50 border border-cyan-200 text-cyan-800 text-xs font-bold rounded" title="Scopus ID: {{ $dosen->scopus_id }}">
                                                Scopus
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- Tombol Aksi Buka Halaman Portofolio Lengkap -->
                            <div class="pt-5 mt-4 border-t border-slate-100">
                                <a href="{{ route('profil.peneliti.show', $dosen) }}"
                                   class="w-full h-11 px-4 inline-flex items-center justify-center gap-2 rounded-xl text-xs font-semibold text-[#0B2A59] bg-blue-50/80 hover:bg-[#0B2A59] hover:text-white transition-all duration-150 active:scale-[0.99] leading-4 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Lihat Rekap Riset dan Publikasi</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $peneliti->links() }}
                </div>
            @else
                <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center max-w-lg mx-auto space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 leading-6">Tidak Ditemukan Data Peneliti</h3>
                    <p class="text-xs text-slate-500 leading-5">
                        Tidak ada data dosen atau peneliti yang sesuai dengan kriteria filter atau pencarian Anda. Silakan coba kata kunci lain.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('profil.peneliti') }}" class="inline-flex items-center justify-center h-10 px-5 text-xs font-semibold text-white bg-[#0B2A59] rounded-xl hover:bg-blue-900 leading-4">
                            Tampilkan Semua Peneliti
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

</main>
@endsection
