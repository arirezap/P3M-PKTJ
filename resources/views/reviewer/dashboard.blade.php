@extends('layouts.dashboard')

@section('title', 'Portal Penilaian Reviewer')
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-8">
    
    <!-- Profil Reviewer & Sambutan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-bold text-xl flex-shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-700 leading-4">Reviewer Riset & Pengabdian PKTJ</span>
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">{{ $user->name }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 leading-4">
                    <span>NIDN: <strong class="text-slate-700">{{ $user->nidn_nip ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>Bidang Kepakaran: <strong class="text-slate-700">{{ $user->keahlian ?? '-' }}</strong></span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 leading-4">
                SK Penugasan Reviewer Aktif
            </span>
        </div>
    </div>

    <!-- Ringkasan Statistik Penugasan Reviewer -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Total Penugasan Menilai</span>
            <div class="text-3xl font-extrabold text-[#0B2A59] leading-8">{{ $stats['total_penugasan'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Usulan Ditugaskan Admin</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Menunggu Penilaian</span>
            <div class="text-3xl font-extrabold text-amber-600 leading-8">{{ $stats['menunggu'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Perlu Evaluasi Rubrik</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Penilaian Selesai</span>
            <div class="text-3xl font-extrabold text-emerald-600 leading-8">{{ $stats['selesai'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Rekomendasi Terkirim</div>
        </div>

    </div>

    <!-- Daftar Penugasan Usulan yang Perlu Dinilai -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm space-y-4 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-[#0B2A59] leading-6">Daftar Usulan Proposal yang Ditugaskan</h2>
                <p class="text-xs text-slate-500 leading-4">Evaluasi kesesuaian metodologi, urgensi keselamatan transportasi, kelayakan anggaran, dan target luaran.</p>
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="p-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="font-medium text-slate-600">Saat ini belum ada usulan proposal yang ditugaskan kepada Anda.</div>
                <p>Penugasan proposal baru akan muncul otomatis ketika Admin P3M menetapkan reviewer.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                            <th class="py-3 px-4">Kode Usulan</th>
                            <th class="py-3 px-4">Judul Usulan</th>
                            <th class="py-3 px-4">Ketua Pengusul</th>
                            <th class="py-3 px-4">Prodi</th>
                            <th class="py-3 px-4">Status Review</th>
                            <th class="py-3 px-4">Skor Akhir</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($reviews as $rev)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-bold text-[#0B2A59]">{{ $rev->proposal->kode_usulan }}</td>
                                <td class="py-3 px-4 font-medium text-slate-900 max-w-xs">{{ $rev->proposal->judul }}</td>
                                <td class="py-3 px-4">{{ $rev->proposal->ketua->name }}</td>
                                <td class="py-3 px-4">{{ $rev->proposal->prodi->kode_prodi }}</td>
                                <td class="py-3 px-4">
                                    @if($rev->status_review === 'selesai')
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-800">
                                    {{ $rev->total_skor ? number_format($rev->total_skor, 1) : '-' }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($rev->status_review === 'selesai')
                                        <a href="{{ route('reviewer.reviews.show', $rev) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg text-xs transition-colors">
                                            <span>Lihat Hasil Nilai</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('reviewer.reviews.show', $rev) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0B2A59] hover:bg-blue-900 text-white font-semibold rounded-lg text-xs shadow-sm transition-colors">
                                            <span>Buka Lembar Penilaian</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    @endif
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
