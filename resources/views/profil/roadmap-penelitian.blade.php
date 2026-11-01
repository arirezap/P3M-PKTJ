@extends('layouts.public')

@section('title', 'Roadmap Penelitian - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Roadmap Penelitian Keselamatan Transportasi Terpadu PKTJ Tegal.')

@section('content')
<div x-data="{ 
    previewModalOpen: false, 
    selectedDoc: null,
    openPreview(doc) {
        this.selectedDoc = doc;
        this.previewModalOpen = true;
    }
}">
<main class="flex-1">

        <!-- Breadcrumb Bar -->
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

        <!-- Hero Section Roadmap -->
        <section class="py-12 sm:py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                        <span>Peta Jalan Riset Terapan 2026 - 2031</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-9 sm:leading-10">
                        Roadmap Penelitian <span class="text-[#0B2A59]">Keselamatan Transportasi Terpadu</span>
                    </h1>
                    <div class="w-20 h-1 bg-yellow-500 rounded"></div>
                    <p class="text-sm sm:text-base text-slate-600 leading-6 sm:leading-7">
                        Peta jalan penelitian terpadu Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal yang menjadi haluan riset dosen, taruna, dan mitra industri dalam mengakselerasi keselamatan infrastruktur jalan, kelaikan armada, otomasi transportasi cerdas, serta hilirisasi teknologi terapan nasional.
                    </p>
                </div>

                <!-- Highlight Cards / Indikator Roadmap -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 mt-8 border-t border-slate-100">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Jangka Waktu Peta Jalan</span>
                        <div class="text-xl font-bold text-[#0B2A59] leading-7">3 Fase Riset (2026 - 2031)</div>
                        <p class="text-xs text-slate-500 leading-4">Tahapan terstruktur dari riset dasar hingga hilirisasi industri.</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Klaster Keilmuan</span>
                        <div class="text-xl font-bold text-[#0B2A59] leading-7">3 Program Studi PKTJ</div>
                        <p class="text-xs text-slate-500 leading-4">Kolaborasi terpadu D4 RSTJ, D4 TRO, dan D3 TO.</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-yellow-600 leading-4">Sasaran Akhir Luaran</span>
                        <div class="text-xl font-bold text-emerald-700 leading-7">Paten & Regulasi Teknis</div>
                        <p class="text-xs text-slate-500 leading-4">Audit keselamatan, HKI invensi, dan rekomendasi kebijakan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kartu Utama Berkas Dokumen Roadmap Penelitian -->
        <section class="py-16 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Dokumen Peta Jalan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-9">
                        Dokumen Roadmap Penelitian PKTJ
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-5">
                        Dokumen peta jalan yang memuat rincian matriks topik penelitian, target capaian luaran per tahun, dan keterpaduan lintas program studi.
                    </p>
                </div>

                <!-- Showcase Dokumen Roadmap (Lebar Penuh & Kokoh) -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-10 shadow-sm hover:shadow-md transition-all duration-200 space-y-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-[#0B2A59] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="px-2.5 py-0.5 rounded bg-blue-50 text-[#0B2A59] font-bold text-xs leading-4">
                                        Pedoman Riset Terpadu
                                    </span>
                                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mt-1 leading-7 sm:leading-8">
                                        {{ $roadmapDokumen->judul ?? 'Roadmap Penelitian Keselamatan Transportasi Terpadu' }}
                                    </h3>
                                </div>
                            </div>
                            <div class="text-right sm:text-right">
                                <span class="text-xs text-slate-400 block leading-4">Tahun Berlaku:</span>
                                <span class="text-sm font-bold text-[#0B2A59] leading-5">{{ $roadmapDokumen->tahun ?? '2026 - 2031' }}</span>
                            </div>
                        </div>

                        <!-- Deskripsi Dokumen -->
                        <div class="space-y-3">
                            <p class="text-xs sm:text-sm text-slate-600 leading-6">
                                {{ $roadmapDokumen->deskripsi ?? 'Peta jalan penelitian terpadu fokus teknologi keselamatan transportasi darat, pengujian kelaikan armada, audit titik rawan lalu lintas, dan otomasi cerdas sivitas akademika PKTJ Tegal.' }}
                            </p>
                            <p class="text-xs text-slate-500 leading-5">
                                Seluruh usulan proposal penelitian DIPA Kemenhub, penelitian mandiri, maupun riset kemitraan industri wajib mencantumkan kode klaster dan keselarasan dengan tahapan roadmap ini.
                            </p>
                        </div>

                        <!-- 4 Pilar Capaian Roadmap -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs text-slate-600">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Penanganan Titik Rawan Kecelakaan (Black Spot) Pantura Jawa</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Standardisasi Uji Kelaikan & Dinamika Rem Armada Bus/Truk</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Penerapan Intelligent Transportation Systems (ITS) & Sensor Vokasi</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Purwarupa & Konversi Kendaraan Listrik (EV) Berkeselamatan</span>
                            </div>
                        </div>

                        <!-- Footer Kartu: Informasi Berkas & Tombol Aksi -->
                        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4 text-xs text-slate-500 leading-4">
                                <span>Format: <strong class="text-slate-700">Dokumen PDF</strong></span>
                                <span>•</span>
                                <span>Ukuran: <strong class="text-slate-700">{{ $roadmapDokumen->file_size ?? '1.8 MB' }}</strong></span>
                                <span>•</span>
                                <span>Unduhan: <strong class="text-[#0B2A59]">{{ $roadmapDokumen->download_count ?? 0 }} kali</strong></span>
                            </div>

                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                @if($roadmapDokumen)
                                    <button type="button" 
                                            @click="openPreview(
                                                '{{ addslashes($roadmapDokumen->judul) }}',
                                                'Roadmap Penelitian',
                                                '{{ $roadmapDokumen->tahun ?? '2026 - 2031' }}',
                                                '{{ $roadmapDokumen->file_size ?? '1.8 MB' }}',
                                                '{{ addslashes($roadmapDokumen->deskripsi ?? '') }}',
                                                '{{ asset('storage/' . $roadmapDokumen->file_path) }}',
                                                '{{ route('documents.download', $roadmapDokumen) }}'
                                            )"
                                            class="inline-flex items-center justify-center gap-2 h-11 px-5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:border-slate-400 rounded-xl transition-all active:scale-[0.98] leading-4">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Pratinjau Dokumen</span>
                                    </button>

                                    <a href="{{ route('documents.download', $roadmapDokumen) }}" 
                                       class="inline-flex items-center justify-center gap-2 h-11 px-6 text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 rounded-xl transition-all shadow-sm active:scale-[0.98] leading-4">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Unduh Berkas PDF</span>
                                    </a>
                                @else
                                    <div class="text-xs text-slate-400 py-2">
                                        Dokumen sedang dalam proses finalisasi kelembagaan.
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- Visualisasi Peta Jalan Penelitian (Timeline Milestones 3 Fase) -->
        <section class="py-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                
                <div class="max-w-3xl space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Tahapan Riset 2026 - 2031</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8">
                        Visualisasi 3 Fase Peta Jalan Riset PKTJ
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-5">
                        Riset keselamatan transportasi dikembangkan melalui integrasi bertahap dari pemetaan lapangan, rekayasa purwarupa, hingga hilirisasi industri nasional:
                    </p>
                </div>

                <!-- 3 Kotak Fase Berkelanjutan (Timeline Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                    
                    <!-- Fase 1 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-6 transition-all duration-200 shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded bg-blue-100 text-[#0B2A59] font-bold text-xs leading-4">Fase 1</span>
                                <span class="text-xs font-bold text-slate-500 leading-4">2026 – 2027</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 leading-6">
                                Fundamental & Baseline Keselamatan Jalan
                            </h3>
                            <p class="text-xs text-slate-600 leading-5">
                                Fokus pada pemetaan komprehensif data kecelakaan dan karakteristik teknis kendaraan di koridor pantai utara Jawa.
                            </p>
                            
                            <div class="pt-4 border-t border-slate-200/80 space-y-2">
                                <span class="text-[11px] font-bold text-[#0B2A59] uppercase tracking-wider block leading-4">Target Capaian:</span>
                                <ul class="space-y-2 text-xs text-slate-600">
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#0B2A59] mt-1.5 flex-shrink-0"></div>
                                        <span>Audit geometri & identifikasi titik rawan (black spot) Pantura Tegal-Brebes.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#0B2A59] mt-1.5 flex-shrink-0"></div>
                                        <span>Pengukuran efisiensi sistem pengereman armada bus umum trayek jarak jauh.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#0B2A59] mt-1.5 flex-shrink-0"></div>
                                        <span>Penyusunan standar pangkalan data digital investigasi kecelakaan lalu lintas.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 text-[11px] text-slate-500 font-medium">
                            Status: <strong class="text-emerald-700">Tahap Sedang Berjalan</strong>
                        </div>
                    </div>

                    <!-- Fase 2 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-6 transition-all duration-200 shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded bg-yellow-100 text-yellow-900 font-bold text-xs leading-4">Fase 2</span>
                                <span class="text-xs font-bold text-slate-500 leading-4">2028 – 2029</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 leading-6">
                                Inovasi Cerdas & Rekayasa Purwarupa
                            </h3>
                            <p class="text-xs text-slate-600 leading-5">
                                Pengembangan piranti lunak, sensor cerdas, dan purwarupa rekayasa otomotif yang teruji di laboratorium riset PKTJ.
                            </p>
                            
                            <div class="pt-4 border-t border-slate-200/80 space-y-2">
                                <span class="text-[11px] font-bold text-[#0B2A59] uppercase tracking-wider block leading-4">Target Capaian:</span>
                                <ul class="space-y-2 text-xs text-slate-600">
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-yellow-600 mt-1.5 flex-shrink-0"></div>
                                        <span>Purwarupa sensor pemantau kelelahan pengemudi berbasis artificial intelligence.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-yellow-600 mt-1.5 flex-shrink-0"></div>
                                        <span>Konversi armada operasional kampus ke sistem penggerak listrik (EV) mandiri.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-yellow-600 mt-1.5 flex-shrink-0"></div>
                                        <span>Integrasi sistem lampu peringatan cerdas di perlintasan sebidang kereta api.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 text-[11px] text-slate-500 font-medium">
                            Status: <strong class="text-[#0B2A59]">Rencana Pengembangan</strong>
                        </div>
                    </div>

                    <!-- Fase 3 -->
                    <div class="bg-slate-50 border-2 border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 flex flex-col justify-between space-y-6 transition-all duration-200 shadow-sm">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded bg-emerald-100 text-emerald-900 font-bold text-xs leading-4">Fase 3</span>
                                <span class="text-xs font-bold text-slate-500 leading-4">2030 – 2031</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 leading-6">
                                Implementasi Terpadu & Hilirisasi Industri
                            </h3>
                            <p class="text-xs text-slate-600 leading-5">
                                Replikasi skala industri, transfer teknologi paten ke manufaktur angkutan, dan penguatan regulasi keselamatan nasional.
                            </p>
                            
                            <div class="pt-4 border-t border-slate-200/80 space-y-2">
                                <span class="text-[11px] font-bold text-[#0B2A59] uppercase tracking-wider block leading-4">Target Capaian:</span>
                                <ul class="space-y-2 text-xs text-slate-600">
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-700 mt-1.5 flex-shrink-0"></div>
                                        <span>Hilirisasi paten perangkat keselamatan ke industri karoseri dan APM nasional.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-700 mt-1.5 flex-shrink-0"></div>
                                        <span>Penerapan koridor jalan berkeselamatan percontohan bersama Ditjen Hubdat.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-700 mt-1.5 flex-shrink-0"></div>
                                        <span>Pusat rujukan uji kelaikan armada dan audit keselamatan transportasi jalan.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 text-[11px] text-slate-500 font-medium">
                            Status: <strong class="text-slate-600">Target Jangka Panjang</strong>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Klaster Pohon Riset Berdasarkan 3 Program Studi -->
        <section class="py-16 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                
                <div class="max-w-3xl space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pohon Kepakaran</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8">
                        Klaster Riset 3 Program Studi PKTJ
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-5">
                        Setiap usulan penelitian dosen wajib menginduk pada pohon klaster riset salah satu dari tiga program studi di lingkungan PKTJ:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Prodi 1: D4 RSTJ -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 space-y-4 shadow-sm transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D4 RSTJ</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-5">Rekayasa Sistem Transportasi Jalan</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Fokus riset pada aspek prasarana dan lalu lintas darat:
                        </p>
                        <div class="pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 1:</strong>
                                <span>Audit Keselamatan Infrastruktur & Geometri Jalan</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 2:</strong>
                                <span>Mitigasi Titik Rawan Kecelakaan (Black Spot)</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 3:</strong>
                                <span>Intelligent Transportation Systems (ITS) & Pemodelan Arteri</span>
                            </div>
                        </div>
                    </div>

                    <!-- Prodi 2: D4 TRO -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 space-y-4 shadow-sm transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D4 TRO</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-[#0B2A59] font-semibold text-[10px] leading-4">Sarjana Terapan</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-5">Teknologi Rekayasa Otomotif</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Fokus riset pada teknologi dan dinamika armada kendaraan:
                        </p>
                        <div class="pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 1:</strong>
                                <span>Kelaikan Teknis Kendaraan Bermotor & Uji Rem</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 2:</strong>
                                <span>Konversi & Sistem Keselamatan Kendaraan Listrik (EV)</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 3:</strong>
                                <span>Rekayasa Dinamika Rangka Bodi & Simulasi Tabrakan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Prodi 3: D3 TO -->
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-7 space-y-4 shadow-sm transition-all">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-[#0B2A59] leading-5">D3 TO</span>
                            <span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 font-semibold text-[10px] leading-4">Diploma Tiga</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-5">Teknologi Otomotif</h3>
                        <p class="text-xs text-slate-500 leading-5">
                            Fokus riset terapan pemeliharaan dan uji komponen:
                        </p>
                        <div class="pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 1:</strong>
                                <span>Standardisasi Pemeliharaan Teknis Angkutan Jalan</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 2:</strong>
                                <span>Uji Emisi Gas Buang Berkala & Efisiensi Bahan Bakar</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                                <strong class="text-slate-800 block">Klaster 3:</strong>
                                <span>Keselamatan Komponen Mekanikal & Perbengkelan Rakyat</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Dokumen Regulasi & SOP Pendukung Terkait -->
        @if($dokumenPendukung->isNotEmpty())
        <section class="py-12 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Dokumen Regulasi & Panduan Pendukung</h3>
                        <p class="text-xs text-slate-500 leading-4 mt-0.5">Berkas panduan operasional pendamping roadmap penelitian.</p>
                    </div>
                    <a href="{{ route('profil.rencana-strategis') }}" class="text-xs font-semibold text-[#0B2A59] hover:underline leading-4">
                        Lihat Rencana Strategis (Renstra) →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($dokumenPendukung as $doc)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center justify-between gap-4 shadow-sm hover:border-slate-300 transition-all">
                        <div class="space-y-1 min-w-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block leading-3">{{ str_replace('_', ' ', $doc->kategori) }}</span>
                            <div class="text-xs font-bold text-slate-800 truncate leading-4">{{ $doc->judul }}</div>
                            <div class="text-[11px] text-slate-400 leading-3">{{ $doc->tahun }} • {{ $doc->file_size }}</div>
                        </div>
                        <a href="{{ route('documents.download', $doc) }}" 
                           class="flex-shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-slate-200 hover:bg-[#0B2A59] text-slate-600 hover:text-white transition-colors"
                           title="Unduh {{ $doc->judul }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Call to Action ke SIM P3M -->
        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-[#0B2A59] to-blue-900 rounded-2xl p-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-md">
                    <div class="space-y-2 text-center md:text-left">
                        <span class="text-xs font-bold uppercase tracking-wider text-yellow-400 leading-4">Penerimaan Proposal Riset Terbuka</span>
                        <h3 class="text-xl sm:text-2xl font-bold leading-7">Ajukan Usulan Penelitian Sesuai Tema Roadmap</h3>
                        <p class="text-xs sm:text-sm text-blue-100 max-w-xl leading-5">
                            Gunakan kode tema dan klaster roadmap ini saat menyusun proposal dan RAB penelitian DIPA maupun hibah institusi melalui SIM P3M.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center h-12 px-6 text-sm font-semibold text-[#0B2A59] bg-yellow-400 hover:bg-yellow-300 rounded-xl transition-all shadow active:scale-[0.98] leading-5 whitespace-nowrap">
                            Masuk ke SIM P3M
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Modal Pratinjau Dokumen (Alpine.js Interactive Reader) -->
    <div x-show="previewModalOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="previewModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                 @click="previewModalOpen = false"></div>

            <div x-show="previewModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-3xl sm:w-full border border-slate-200">
                
                <!-- Modal Header -->
                <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 block leading-3" x-text="previewDoc.category"></span>
                        <h4 class="text-sm sm:text-base font-bold text-slate-900 mt-0.5 leading-5" id="modal-title" x-text="previewDoc.title"></h4>
                    </div>
                    <button @click="previewModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body: Meta & Preview Viewer -->
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tahun Berlaku:</span>
                            <span class="font-bold text-[#0B2A59]" x-text="previewDoc.year"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Ukuran Berkas:</span>
                            <span class="font-bold text-slate-800" x-text="previewDoc.size"></span>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <span class="text-slate-400 block text-[11px]">Format:</span>
                            <span class="font-bold text-emerald-700">PDF Terstandarisasi</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-slate-700 block mb-1">Keterangan Dokumen:</span>
                        <p class="text-xs text-slate-600 leading-5" x-text="previewDoc.desc"></p>
                    </div>

                    <!-- PDF Viewer Box -->
                    <div class="w-full h-80 bg-slate-100 border border-slate-200 rounded-xl overflow-hidden flex flex-col items-center justify-center p-4 text-center">
                        <svg class="w-12 h-12 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-xs text-slate-600 font-medium mb-1">Pratinjau Ringkas Roadmap Penelitian</p>
                        <p class="text-[11px] text-slate-400 max-w-sm mb-4">Silakan unduh berkas digital untuk melihat matriks tahapan, target indikator luaran, dan rincian klaster keilmuan secara lengkap.</p>
                        <a :href="previewDoc.downloadUrl" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0B2A59] text-white text-xs font-semibold rounded-lg hover:bg-blue-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Berkas Sekarang</span>
                        </a>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 border-t border-slate-200 px-6 py-3 flex justify-end gap-2">
                    <button @click="previewModalOpen = false" type="button" class="h-10 px-4 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 leading-4">
                        Tutup
                    </button>
                    <a :href="previewDoc.downloadUrl" class="inline-flex items-center justify-center h-10 px-4 text-xs font-semibold text-white bg-[#0B2A59] rounded-lg hover:bg-blue-900 leading-4">
                        Unduh Berkas PDF
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Institusi (Kemenhub) -->
</div>
@endsection
