@extends('layouts.public')

@section('title', 'Profil Peneliti & Dosen - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Direktori profil dosen dan peneliti aktif P3M Politeknik Keselamatan Transportasi Jalan Tegal.')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedUser: null,
    openDetail(user) {
        this.selectedUser = user;
        this.detailModalOpen = true;
    }
}">
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
                            <div class="text-[11px] sm:text-xs font-medium text-slate-500 mt-0.5 leading-4">Peneliti Aktif</div>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-bold text-amber-600 leading-7">{{ $totalRiset }}</div>
                            <div class="text-[11px] sm:text-xs font-medium text-slate-500 mt-0.5 leading-4">Kegiatan Riset</div>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-center">
                            <div class="text-xl sm:text-2xl font-bold text-emerald-600 leading-7">{{ $totalPublikasi }}</div>
                            <div class="text-[11px] sm:text-xs font-medium text-slate-500 mt-0.5 leading-4">Publikasi & HKI</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bilah Filter & Pencarian -->
        <section class="bg-white border-b border-slate-200 sticky top-20 z-30 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <form method="GET" action="{{ route('profil.peneliti') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    
                    <!-- Tab Filter Program Studi (3 Prodi) -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs">
                        <a href="{{ route('profil.peneliti', array_merge(request()->except(['prodi', 'page']), ['prodi' => 'semua'])) }}"
                           class="px-3.5 py-2 rounded-lg font-semibold transition-colors whitespace-nowrap leading-4 {{ !request('prodi') || request('prodi') == 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            Semua Prodi
                        </a>
                        @foreach($prodis as $pr)
                            <a href="{{ route('profil.peneliti', array_merge(request()->except(['prodi', 'page']), ['prodi' => strtolower($pr->kode_prodi)])) }}"
                               class="px-3.5 py-2 rounded-lg font-semibold transition-colors whitespace-nowrap leading-4 {{ strtolower(request('prodi')) == strtolower($pr->kode_prodi) ? 'bg-[#0B2A59] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
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
                            <a href="{{ route('profil.peneliti') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4 whitespace-nowrap">
                                Reset
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
                            @php
                                $dosenPayload = [
                                    'id' => $dosen->id,
                                    'name' => $dosen->name,
                                    'nidn' => $dosen->nidn_nip ?? '-',
                                    'email' => $dosen->email,
                                    'role' => $dosen->role,
                                    'prodi_code' => $dosen->prodi?->kode_prodi ?? '-',
                                    'prodi_name' => $dosen->prodi ? ($dosen->prodi->jenjang . ' ' . $dosen->prodi->nama_prodi) : '-',
                                    'keahlian' => $dosen->keahlian ?? 'Riset Keselamatan Transportasi Terapan',
                                    'avatar_url' => ($dosen->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($dosen->avatar)) ? asset('storage/' . $dosen->avatar) : null,
                                    'initial' => strtoupper(substr($dosen->name, 0, 1)),
                                    'sinta_id' => $dosen->sinta_id,
                                    'scopus_id' => $dosen->scopus_id,
                                    'google_scholar' => $dosen->google_scholar,
                                    'researches' => $dosen->researches->map(fn($r) => [
                                        'judul' => $r->judul,
                                        'tahun' => $r->tahun,
                                        'skema' => $r->skema ?? 'Penelitian Terapan',
                                        'sumber_dana' => $r->sumber_dana,
                                        'status' => $r->status,
                                    ]),
                                    'outputs' => $dosen->outputs->map(fn($o) => [
                                        'kategori' => $o->kategori,
                                        'judul' => $o->judul,
                                        'tahun' => $o->tahun,
                                        'nama_jurnal_penerbit' => $o->nama_jurnal_penerbit,
                                        'nomor_registrasi_hki' => $o->nomor_registrasi_hki,
                                        'tkt' => $o->tingkat_kesiapan_terapan,
                                        'link' => $o->link_dokumen,
                                    ]),
                                ];
                            @endphp

                            <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                                <div class="space-y-4">
                                    
                                    <!-- Foto & Afiliasi -->
                                    <div class="flex items-start gap-4">
                                        @if($dosen->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($dosen->avatar))
                                            <img src="{{ asset('storage/' . $dosen->avatar) }}" alt="{{ $dosen->name }}" 
                                                 class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#0B2A59] to-blue-900 text-white font-bold text-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                                {{ strtoupper(substr($dosen->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="flex-1 min-w-0">
                                            @if($dosen->prodi)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase leading-4
                                                    {{ $dosen->prodi->kode_prodi === 'RSTJ' ? 'bg-blue-100 text-blue-800' : ($dosen->prodi->kode_prodi === 'TRO' ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800') }}">
                                                    {{ $dosen->prodi->jenjang }} {{ $dosen->prodi->kode_prodi }}
                                                </span>
                                            @endif
                                            <h2 class="text-sm font-bold text-slate-900 mt-1 leading-5 line-clamp-2">
                                                {{ $dosen->name }}
                                            </h2>
                                            <p class="text-xs text-slate-500 mt-0.5 leading-4">
                                                NIDN/NIP: <span class="font-medium text-slate-700">{{ $dosen->nidn_nip ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Bidang Keahlian / Fokus Riset -->
                                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider leading-3">Fokus Riset & Kepakaran</div>
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
                                        <div class="flex items-center gap-1.5">
                                            @if($dosen->sinta_id)
                                                <span class="px-2 py-0.5 bg-orange-50 border border-orange-200 text-orange-800 text-[10px] font-bold rounded" title="SINTA ID: {{ $dosen->sinta_id }}">
                                                    SINTA
                                                </span>
                                            @endif
                                            @if($dosen->scopus_id)
                                                <span class="px-2 py-0.5 bg-cyan-50 border border-cyan-200 text-cyan-800 text-[10px] font-bold rounded" title="Scopus ID: {{ $dosen->scopus_id }}">
                                                    Scopus
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <!-- Tombol Aksi Buka Modal Portofolio -->
                                <div class="pt-5 mt-4 border-t border-slate-100">
                                    <button @click="openPortfolio({{ json_encode($dosenPayload) }})" type="button"
                                            class="w-full h-11 px-4 inline-flex items-center justify-center gap-2 rounded-xl text-xs font-semibold text-[#0B2A59] bg-blue-50/80 hover:bg-blue-100 hover:text-blue-900 transition-all duration-150 active:scale-[0.99] leading-4">
                                        <svg class="w-4 h-4 text-[#0B2A59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Lihat Rekap Riset & Publikasi</span>
                                    </button>
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

    <!-- Modal Portofolio Peneliti (Alpine.js) -->
    <div x-show="modalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog" aria-modal="true">
        
        <!-- Backdrop Gelap -->
        <div x-show="modalOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="modalOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <!-- Panel Modal Konten -->
        <div x-show="modalOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="relative bg-white border border-slate-200 rounded-2xl shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden z-10">
            
            <!-- Header Modal -->
            <div class="p-6 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200 flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    <template x-if="activeDosen?.avatar_url">
                        <img :src="activeDosen.avatar_url" :alt="activeDosen.name" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-200 shadow-sm flex-shrink-0">
                    </template>
                    <template x-if="!activeDosen?.avatar_url">
                        <div class="w-16 h-16 rounded-2xl bg-[#0B2A59] text-white font-bold text-xl flex items-center justify-center shadow-sm flex-shrink-0" x-text="activeDosen?.initial"></div>
                    </template>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-[#0B2A59]" x-text="activeDosen?.prodi_name"></span>
                            <span class="text-xs text-slate-400">NIDN: <strong class="text-slate-700 font-semibold" x-text="activeDosen?.nidn"></strong></span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mt-1 leading-6" x-text="activeDosen?.name"></h3>
                        <p class="text-xs text-slate-600 mt-0.5 leading-4" x-text="activeDosen?.keahlian"></p>
                    </div>
                </div>

                <button @click="modalOpen = false" type="button" class="w-9 h-9 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Tautan Profil Eksternal SINTA, Scopus, Google Scholar -->
            <div class="px-6 py-3 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between gap-4 text-xs flex-wrap">
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Profil Akademik:</span>
                    <template x-if="activeDosen?.sinta_id">
                        <span class="px-2.5 py-1 bg-orange-100 text-orange-800 rounded font-bold text-[11px]">
                            SINTA ID: <span x-text="activeDosen.sinta_id"></span>
                        </span>
                    </template>
                    <template x-if="activeDosen?.scopus_id">
                        <span class="px-2.5 py-1 bg-cyan-100 text-cyan-800 rounded font-bold text-[11px]">
                            Scopus ID: <span x-text="activeDosen.scopus_id"></span>
                        </span>
                    </template>
                </div>
                <template x-if="activeDosen?.google_scholar">
                    <a :href="activeDosen.google_scholar" target="_blank" rel="noopener noreferrer" 
                       class="text-xs font-semibold text-[#0B2A59] hover:underline flex items-center gap-1">
                        <span>Google Scholar</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </template>
            </div>

            <!-- Navigasi Tab Modal: Riset vs Publikasi -->
            <div class="flex border-b border-slate-200 bg-white px-6">
                <button @click="activeTab = 'riset'" type="button"
                        class="py-3 px-4 text-xs font-semibold border-b-2 transition-colors leading-4"
                        :class="activeTab === 'riset' ? 'border-[#0B2A59] text-[#0B2A59]' : 'border-transparent text-slate-500 hover:text-slate-800'">
                    Rekapitulasi Riset Terapan (<span x-text="activeDosen?.researches?.length || 0"></span>)
                </button>
                <button @click="activeTab = 'publikasi'" type="button"
                        class="py-3 px-4 text-xs font-semibold border-b-2 transition-colors leading-4"
                        :class="activeTab === 'publikasi' ? 'border-[#0B2A59] text-[#0B2A59]' : 'border-transparent text-slate-500 hover:text-slate-800'">
                    Publikasi Ilmiah & HKI (<span x-text="activeDosen?.outputs?.length || 0"></span>)
                </button>
            </div>

            <!-- Isi Konten Modal Berdasarkan Tab -->
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                
                <!-- Tab Riset Terapan -->
                <div x-show="activeTab === 'riset'" class="space-y-3">
                    <template x-if="activeDosen?.researches && activeDosen.researches.length > 0">
                        <div class="divide-y divide-slate-100">
                            <template x-for="(riset, idx) in activeDosen.researches" :key="idx">
                                <div class="py-3 first:pt-0 space-y-1.5">
                                    <div class="flex items-center justify-between gap-2 text-xs">
                                        <span class="font-bold text-[#0B2A59]" x-text="riset.tahun"></span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                              :class="riset.status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'"
                                              x-text="riset.status"></span>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-900 leading-5" x-text="riset.judul"></h4>
                                    <div class="flex items-center gap-3 text-[11px] text-slate-500 flex-wrap">
                                        <span>Skema: <strong class="text-slate-700 font-medium" x-text="riset.skema"></strong></span>
                                        <span>&bull;</span>
                                        <span>Sumber Dana: <strong class="text-slate-700 font-medium" x-text="riset.sumber_dana"></strong></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="!activeDosen?.researches || activeDosen.researches.length === 0">
                        <div class="p-8 text-center text-slate-400 text-xs italic">
                            Belum ada riwayat penelitian terapan yang tercatat pada sistem SIM P3M.
                        </div>
                    </template>
                </div>

                <!-- Tab Publikasi Ilmiah & HKI -->
                <div x-show="activeTab === 'publikasi'" class="space-y-3">
                    <template x-if="activeDosen?.outputs && activeDosen.outputs.length > 0">
                        <div class="divide-y divide-slate-100">
                            <template x-for="(luaran, idx) in activeDosen.outputs" :key="idx">
                                <div class="py-3 first:pt-0 space-y-1.5">
                                    <div class="flex items-center justify-between gap-2 text-xs">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-800" x-text="luaran.kategori"></span>
                                        <span class="font-semibold text-slate-500" x-text="luaran.tahun"></span>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-900 leading-5" x-text="luaran.judul"></h4>
                                    <div class="text-[11px] text-slate-600 flex items-center gap-3 flex-wrap">
                                        <template x-if="luaran.nama_jurnal_penerbit">
                                            <span class="italic text-slate-700" x-text="luaran.nama_jurnal_penerbit"></span>
                                        </template>
                                        <template x-if="luaran.nomor_registrasi_hki">
                                            <span class="font-medium text-slate-700">No. Registrasi: <strong x-text="luaran.nomor_registrasi_hki"></strong></span>
                                        </template>
                                        <template x-if="luaran.tkt">
                                            <span class="px-1.5 py-0.5 bg-blue-50 text-[#0B2A59] font-bold rounded text-[10px]" x-text="luaran.tkt"></span>
                                        </template>
                                        <template x-if="luaran.link">
                                            <a :href="luaran.link" target="_blank" rel="noopener noreferrer" class="text-[#0B2A59] font-semibold hover:underline flex items-center gap-0.5">
                                                <span>Tautan Artikel</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="!activeDosen?.outputs || activeDosen.outputs.length === 0">
                        <div class="p-8 text-center text-slate-400 text-xs italic">
                            Belum ada riwayat publikasi ilmiah atau HKI yang terdaftar untuk peneliti ini.
                        </div>
                    </template>
                </div>

            </div>

            <!-- Footer Modal -->
            <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button @click="modalOpen = false" type="button" class="h-10 px-5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-100 transition-colors leading-4">
                    Tutup Portofolio
                </button>
            </div>

        </div>
    </div>

    <!-- Footer Standar Institusi PKTJ -->
</div>
@endsection
