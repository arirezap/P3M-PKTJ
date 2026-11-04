@extends('layouts.dashboard')

@section('title', 'Portal Penilaian Reviewer')
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-8">
    
    <!-- Profil Reviewer & Sambutan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-2xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-sm">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-700 leading-4">Reviewer Riset & Pengabdian PKTJ</span>
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">{{ $user->name }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 leading-4">
                    <span>NIDN/NIP: <strong class="text-slate-700">{{ $user->nidn_nip ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>Bidang Kepakaran: <strong class="text-slate-700">{{ $user->keahlian ?? 'Transportasi Terapan' }}</strong></span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 leading-4 min-h-[44px]">
                SK Penugasan Reviewer Aktif
            </span>
        </div>
    </div>

    <!-- Ringkasan Statistik Penugasan Reviewer (4 Kartu) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Total Penugasan Menilai</span>
            <div class="text-3xl font-extrabold text-[#0B2A59] leading-8">{{ $stats['total_penugasan'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Usulan Ditugaskan Admin</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Menunggu Review Usulan</span>
            <div class="text-3xl font-extrabold text-amber-600 leading-8">{{ $stats['menunggu'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Proposal Belum Dinilai</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Antrean Penilaian Monev</span>
            <div class="text-3xl font-extrabold text-blue-600 leading-8">{{ $stats['monev_antrean'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Laporan Kemajuan Masuk</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Antrean Laporan Akhir</span>
            <div class="text-3xl font-extrabold text-emerald-600 leading-8">{{ $stats['laporan_antrean'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Dokumen Akhir Masuk</div>
        </div>

    </div>

    <!-- Daftar Penugasan Usulan yang Perlu Dinilai -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm space-y-4 p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-[#0B2A59] leading-6">Daftar Penugasan Telaah Usulan & Laporan</h2>
                <p class="text-xs text-slate-500 leading-4">Evaluasi proposal usulan baru, instrumen monev kemajuan, serta naskah laporan akhir kegiatan.</p>
            </div>

            <!-- Tab Filter: Semua, Penelitian, Pengabdian (PDF Hal. 15) -->
            <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200 text-xs font-medium self-start md:self-auto">
                <a href="{{ route('reviewer.dashboard', ['tab' => 'semua']) }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg transition-all min-h-[44px] {{ ($tab ?? 'semua') === 'semua' ? 'bg-[#0B2A59] text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Semua Penugasan
                </a>
                <a href="{{ route('reviewer.dashboard', ['tab' => 'penelitian']) }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg transition-all min-h-[44px] {{ ($tab ?? '') === 'penelitian' ? 'bg-[#0B2A59] text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Penelitian
                </a>
                <a href="{{ route('reviewer.dashboard', ['tab' => 'pengabdian']) }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg transition-all min-h-[44px] {{ ($tab ?? '') === 'pengabdian' ? 'bg-[#0B2A59] text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    Pengabdian kepada Masyarakat
                </a>
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="p-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="font-medium text-slate-600">Tidak ada penugasan usulan untuk kategori ini.</div>
                <p>Penugasan usulan baru akan muncul otomatis ketika Admin P3M menetapkan reviewer.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                            <th class="py-3 px-4">Kode Usulan</th>
                            <th class="py-3 px-4">Judul Usulan & Skema</th>
                            <th class="py-3 px-4">Ketua Pengusul</th>
                            <th class="py-3 px-4">Prodi</th>
                            <th class="py-3 px-4">Status Review</th>
                            <th class="py-3 px-4">Tahap Monev</th>
                            <th class="py-3 px-4">Laporan Akhir</th>
                            <th class="py-3 px-4 text-right">Aksi Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($reviews as $rev)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-bold text-[#0B2A59] whitespace-nowrap">{{ $rev->proposal->kode_usulan }}</td>
                                <td class="py-3 px-4 max-w-xs">
                                    <div class="font-medium text-slate-900 line-clamp-2 leading-5">{{ $rev->proposal->judul }}</div>
                                    <span class="text-[11px] text-slate-400 capitalize">{{ $rev->proposal->jenis }} • {{ $rev->proposal->skema }}</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">{{ $rev->proposal->ketua->name }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                        {{ $rev->proposal->prodi->kode_prodi }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($rev->status_review === 'selesai')
                                        <div class="space-y-0.5">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                Nilai: {{ number_format($rev->total_skor, 2) }}
                                            </span>
                                            <div class="text-[10px] text-slate-500 capitalize">{{ $rev->rekomendasi }}</div>
                                        </div>
                                    @elseif($rev->disetujui_review_at)
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-800 border border-blue-200">
                                            Sedang Menilai
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 text-amber-800 border border-amber-200">
                                            Menunggu Persetujuan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($rev->proposal->monev)
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $rev->proposal->monev->status_monev === 'dinilai' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-blue-50 text-blue-800 border border-blue-200' }}">
                                            {{ $rev->proposal->monev->status_monev }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($rev->proposal->finalReport)
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $rev->proposal->finalReport->status_laporan === 'diterima' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                            {{ $rev->proposal->finalReport->status_laporan }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('reviewer.reviews.show', $rev) }}" 
                                           class="inline-flex items-center justify-center gap-1 px-3 py-2 min-h-[44px] {{ $rev->status_review === 'selesai' ? 'bg-slate-100 hover:bg-slate-200 text-slate-700' : 'bg-[#0B2A59] hover:bg-blue-900 text-white' }} font-semibold rounded-xl text-xs transition-colors">
                                            <span>{{ $rev->status_review === 'selesai' ? 'Detail Usulan' : ($rev->disetujui_review_at ? 'Nilai Usulan' : 'Buka Penugasan') }}</span>
                                        </a>

                                        @if($rev->proposal->monev)
                                            <a href="{{ route('reviewer.reviews.monev.show', $rev) }}" 
                                               class="inline-flex items-center justify-center px-3 py-2 min-h-[44px] bg-blue-100 hover:bg-blue-200 text-[#0B2A59] font-semibold rounded-xl text-xs transition-colors" title="Evaluasi Monev">
                                                <span>Monev</span>
                                            </a>
                                        @endif

                                        @if($rev->proposal->finalReport)
                                            <a href="{{ route('reviewer.reviews.final-report.show', $rev) }}" 
                                               class="inline-flex items-center justify-center px-3 py-2 min-h-[44px] bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-semibold rounded-xl text-xs transition-colors" title="Evaluasi Laporan Akhir">
                                                <span>Laporan</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
