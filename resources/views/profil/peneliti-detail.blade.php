@extends('layouts.public')

@section('title', $dosen->name . ' - Profil Peneliti P3M PKTJ')
@section('meta_description', 'Profil kepakaran, data kegiatan penelitian terapan, dan publikasi ilmiah luaran HKI oleh ' . $dosen->name . ' di lingkungan Politeknik Keselamatan Transportasi Jalan.')

@section('content')
<main class="flex-1 bg-slate-50 py-10 sm:py-12 lg:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Navigasi Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 leading-4 flex-wrap">
            <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-slate-400">Profil</span>
            <span>/</span>
            <a href="{{ route('profil.peneliti') }}" class="hover:text-[#0B2A59] transition-colors">Profil Peneliti</a>
            <span>/</span>
            <span class="font-semibold text-[#0B2A59] truncate max-w-xs sm:max-w-md">{{ $dosen->name }}</span>
        </nav>

        <!-- Kartu Identitas Utama Peneliti -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-8">
                
                <!-- Sisi Kiri: Foto, Nama & Afiliasi -->
                <div class="flex flex-col sm:flex-row items-start gap-6 flex-1 min-w-0">
                    @if($dosen->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($dosen->avatar))
                        <img src="{{ asset('storage/' . $dosen->avatar) }}" alt="{{ $dosen->name }}" 
                             class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover border-2 border-slate-100 shadow-sm flex-shrink-0">
                    @else
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-br from-[#0B2A59] to-blue-900 text-white font-bold text-3xl sm:text-4xl flex items-center justify-center shadow-sm flex-shrink-0">
                            {{ strtoupper(substr($dosen->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="space-y-3 flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($dosen->prodi)
                                <span class="inline-flex items-center px-3 py-1 rounded text-xs font-bold tracking-wider uppercase leading-4
                                    {{ $dosen->prodi->kode_prodi === 'RSTJ' ? 'bg-blue-100 text-blue-800' : ($dosen->prodi->kode_prodi === 'TRO' ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800') }}">
                                    Program Studi {{ $dosen->prodi->jenjang }} {{ $dosen->prodi->nama_prodi }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-medium leading-4">
                                Status: Aktif
                            </span>
                        </div>

                        <div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-7 sm:leading-9">
                                {{ $dosen->name }}
                            </h1>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-5">
                                NIDN/NIP: <span class="font-semibold text-slate-800">{{ $dosen->nidn_nip ?? '-' }}</span>
                                @if($dosen->email)
                                    <span class="mx-2 text-slate-300">•</span>
                                    <span>{{ $dosen->email }}</span>
                                @endif
                            </p>
                        </div>

                        <!-- Fokus Riset & Kepakaran -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-4 block">Bidang Kepakaran & Fokus Riset Terapan</span>
                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-5">
                                {{ $dosen->keahlian ?? 'Riset Terapan Bidang Keselamatan dan Rekayasa Transportasi Darat' }}
                            </p>
                        </div>

                        <!-- Tautan Profil Eksternal Akademik -->
                        <div class="flex items-center gap-2 pt-1 flex-wrap text-xs">
                            @if($dosen->sinta_id)
                                <span class="inline-flex items-center gap-2 px-3 py-2 bg-orange-50 border border-orange-200 text-orange-900 text-xs font-bold rounded-lg leading-4">
                                    <span>SINTA ID:</span>
                                    <span class="font-mono">{{ $dosen->sinta_id }}</span>
                                </span>
                            @endif

                            @if($dosen->scopus_id)
                                <span class="inline-flex items-center gap-2 px-3 py-2 bg-cyan-50 border border-cyan-200 text-cyan-900 text-xs font-bold rounded-lg leading-4">
                                    <span>Scopus ID:</span>
                                    <span class="font-mono">{{ $dosen->scopus_id }}</span>
                                </span>
                            @endif

                            @if($dosen->google_scholar)
                                <a href="{{ $dosen->google_scholar }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-3 py-2 bg-blue-50 border border-blue-200 text-[#0B2A59] hover:bg-blue-100 text-xs font-semibold rounded-lg transition-colors leading-4">
                                    <span>Google Scholar</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Sisi Kanan: Kartu Ringkasan Metrik & Tombol Aksi -->
                <div class="flex flex-col sm:flex-row lg:flex-col gap-4 flex-shrink-0 justify-between lg:w-64 border-t lg:border-t-0 lg:border-l border-slate-100 pt-6 lg:pt-0 lg:pl-8">
                    <div class="space-y-3 w-full">
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-[#0B2A59] leading-8">{{ $researches->count() }}</div>
                            <div class="text-xs font-medium text-slate-500 mt-1 leading-4">Kegiatan Riset Terapan</div>
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-700 leading-8">{{ $outputs->count() }}</div>
                            <div class="text-xs font-medium text-slate-500 mt-1 leading-4">Publikasi Ilmiah & HKI</div>
                        </div>
                    </div>

                    <a href="{{ route('profil.peneliti') }}" 
                       class="h-11 px-4 inline-flex items-center justify-center gap-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4 shadow-sm">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Direktori</span>
                    </a>
                </div>

            </div>
        </section>

        <!-- Bagian 1: Data Kegiatan Penelitian Terapan -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#0B2A59]"></span>
                        <h2 class="text-lg sm:text-xl font-bold text-[#0B2A59] tracking-tight leading-7">
                            Data Kegiatan Penelitian
                        </h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 leading-4">
                        Daftar riwayat riset terapan yang diketuai atau dilaksanakan oleh peneliti bersangkutan.
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 self-start sm:self-auto border border-blue-100">
                    {{ $researches->count() }} Kegiatan
                </span>
            </div>

            @if($researches->isNotEmpty())
                <div class="divide-y divide-slate-100">
                    @foreach($researches as $riset)
                        <article class="py-5 first:pt-0 last:pb-0 space-y-3">
                            <div class="flex items-center justify-between gap-4 flex-wrap">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-2 py-1 rounded bg-[#0B2A59] text-white text-xs font-bold leading-4">
                                        Tahun {{ $riset->tahun }}
                                    </span>
                                    <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-medium leading-4">
                                        {{ $riset->skema ?? 'Penelitian Terapan' }}
                                    </span>
                                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-800 text-xs font-medium leading-4">
                                        Sumber Dana: {{ $riset->sumber_dana ?? 'DIPA PKTJ' }}
                                    </span>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider leading-4
                                    {{ $riset->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $riset->status ?? 'Selesai' }}
                                </span>
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-6">
                                {{ $riset->judul }}
                            </h3>

                            @if($riset->abstrak)
                                <p class="text-xs text-slate-600 leading-5 line-clamp-3">
                                    {{ $riset->abstrak }}
                                </p>
                            @endif

                            @if($riset->anggota)
                                <div class="text-xs text-slate-500 pt-1 leading-4">
                                    <span class="font-semibold text-slate-700">Anggota Peneliti:</span> {{ $riset->anggota }}
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="py-12 px-4 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 space-y-2">
                    <p class="text-xs font-medium text-slate-500 leading-4">
                        Belum ada data riwayat kegiatan penelitian terapan yang tercatat pada sistem.
                    </p>
                </div>
            @endif
        </section>

        <!-- Bagian 2: Data Publikasi Ilmiah & Luaran HKI -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 lg:p-10 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <h2 class="text-lg sm:text-xl font-bold text-[#0B2A59] tracking-tight leading-7">
                            Data Publikasi Ilmiah &amp; Luaran HKI
                        </h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 leading-4">
                        Daftar publikasi artikel jurnal, paten invensi, hak cipta, dan luaran terapan lainnya.
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold leading-4 self-start sm:self-auto border border-emerald-100">
                    {{ $outputs->count() }} Luaran
                </span>
            </div>

            @if($outputs->isNotEmpty())
                <div class="divide-y divide-slate-100">
                    @foreach($outputs as $luaran)
                        <article class="py-5 first:pt-0 last:pb-0 space-y-3">
                            <div class="flex items-center justify-between gap-4 flex-wrap">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider
                                        {{ strtolower($luaran->kategori) === 'jurnal internasional' ? 'bg-indigo-100 text-indigo-800' : (strtolower($luaran->kategori) === 'hki' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                        {{ $luaran->kategori }}
                                    </span>
                                    <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-semibold leading-4">
                                        Tahun {{ $luaran->tahun }}
                                    </span>
                                    @if($luaran->tingkat_kesiapan_terapan)
                                        <span class="px-2 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4">
                                            {{ $luaran->tingkat_kesiapan_terapan }}
                                        </span>
                                    @endif
                                </div>

                                @if($luaran->link_dokumen)
                                    <a href="{{ $luaran->link_dokumen }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-[#0B2A59] hover:underline leading-4">
                                        <span>Buka Dokumen</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-6">
                                {{ $luaran->judul }}
                            </h3>

                            <div class="flex items-center gap-3 text-xs text-slate-600 flex-wrap">
                                @if($luaran->nama_jurnal_penerbit)
                                    <span>Penerbit / Jurnal: <strong class="text-slate-800 font-medium italic">{{ $luaran->nama_jurnal_penerbit }}</strong></span>
                                @endif
                                @if($luaran->nomor_registrasi_hki)
                                    <span>•</span>
                                    <span>No. Registrasi: <strong class="text-slate-800 font-medium">{{ $luaran->nomor_registrasi_hki }}</strong></span>
                                @endif
                                @if($luaran->lisensi)
                                    <span>•</span>
                                    <span>Lisensi: <span class="text-slate-700">{{ $luaran->lisensi }}</span></span>
                                @endif
                            </div>

                            @if($luaran->deskripsi_kemanfaatan)
                                <p class="text-xs text-slate-500 leading-5">
                                    {{ $luaran->deskripsi_kemanfaatan }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="py-12 px-4 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 space-y-2">
                    <p class="text-xs font-medium text-slate-500 leading-4">
                        Belum ada data publikasi ilmiah atau perolehan HKI yang terdaftar untuk peneliti ini.
                    </p>
                </div>
            @endif
        </section>

    </div>
</main>
@endsection

