@extends('layouts.dashboard')

@section('title', 'Portal Usulan Dosen')
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-8">
    
    <!-- Profil Peneliti & Sambutan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-2xl bg-[#0B2A59] text-white flex items-center justify-center font-bold text-xl flex-shrink-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Dosen / Peneliti PKTJ</span>
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">{{ $user->name }}</h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 leading-4">
                    <span>NIDN: <strong class="text-slate-700">{{ $user->nidn_nip ?? '-' }}</strong></span>
                    <span>•</span>
                    <span>Prodi: <strong class="text-slate-700">{{ $user->prodi ? $user->prodi->nama_prodi . ' (' . $user->prodi->kode_prodi . ')' : '-' }}</strong></span>
                    @if($user->sinta_id)
                        <span>•</span>
                        <span class="text-blue-700 font-semibold">SINTA ID: {{ $user->sinta_id }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('dosen.proposals.create') }}" class="inline-flex items-center justify-center h-12 px-6 rounded-xl text-sm font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm hover:shadow active:scale-[0.98] focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] leading-5 whitespace-nowrap">
                <span>+ Buat Usulan Proposal Baru</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik Usulan Dosen -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Total Pengajuan Usulan</span>
            <div class="text-3xl font-extrabold text-[#0B2A59] leading-8">{{ $stats['total_usulan'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Seluruh Riwayat Proposal</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Draf Usulan</span>
            <div class="text-3xl font-extrabold text-amber-600 leading-8">{{ $stats['draft'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Belum Dikirimkan</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Sedang Dinilai / Diproses</span>
            <div class="text-3xl font-extrabold text-blue-700 leading-8">{{ $stats['diajukan'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Verifikasi & Reviewer</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-1">
            <span class="text-xs font-semibold text-slate-500 leading-4">Usulan Didanai / Lolos</span>
            <div class="text-3xl font-extrabold text-emerald-600 leading-8">{{ $stats['diterima'] }}</div>
            <div class="text-xs text-slate-500 leading-4">Siap Pelaksanaan & Kontrak</div>
        </div>

    </div>

    <!-- Daftar Usulan Proposal Aktif -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm space-y-4 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-[#0B2A59] leading-6">Daftar Usulan Penelitian & Pengabdian Masyarakat</h2>
                <p class="text-xs text-slate-500 leading-4">Pantau tahapan seleksi, catatan reviewer, dan rincian anggaran biaya usulan Anda.</p>
            </div>
        </div>

        @if($proposals->isEmpty())
            <div class="p-8 text-center text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl space-y-3">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="font-medium text-slate-600">Belum ada usulan proposal yang dibuat.</div>
                <p>Klik tombol "+ Buat Usulan Proposal Baru" di atas untuk memulai pengajuan riset atau pengabdian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                            <th class="py-3 px-4">Kode Usulan</th>
                            <th class="py-3 px-4">Judul Usulan</th>
                            <th class="py-3 px-4">Jenis</th>
                            <th class="py-3 px-4">Tahun</th>
                            <th class="py-3 px-4">Anggaran (RAB)</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($proposals as $prop)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-[#0B2A59] whitespace-nowrap">{{ $prop->kode_usulan }}</td>
                                <td class="py-3.5 px-4 font-medium text-slate-900 max-w-xs">
                                    <div class="line-clamp-2 leading-4">{{ $prop->judul }}</div>
                                    <div class="text-[11px] text-slate-500 mt-1 leading-3">{{ $prop->skema }}</div>
                                </td>
                                <td class="py-3.5 px-4 capitalize whitespace-nowrap">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $prop->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59]' : 'bg-yellow-50 text-yellow-800' }}">
                                        {{ $prop->jenis }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">{{ $prop->tahun_anggaran }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800 whitespace-nowrap">Rp {{ number_format($prop->total_anggaran, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @php
                                        $badgeClasses = match($prop->status) {
                                            'draft' => 'bg-slate-100 text-slate-700 border-slate-200',
                                            'diajukan' => 'bg-blue-50 text-blue-800 border-blue-200',
                                            'verifikasi_administrasi' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                                            'sedang_direview' => 'bg-amber-50 text-amber-800 border-amber-200',
                                            'revisi' => 'bg-rose-50 text-rose-800 border-rose-200',
                                            'diterima' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                            'ditolak' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                                        };
                                        $statusLabels = [
                                            'draft' => 'Draf Usulan',
                                            'diajukan' => 'Diajukan',
                                            'verifikasi_administrasi' => 'Lolos Berkas',
                                            'sedang_direview' => 'Sedang Dinilai',
                                            'revisi' => 'Revisi Diperlukan',
                                            'diterima' => 'Diterima / Didanai',
                                            'ditolak' => 'Belum Lolos',
                                        ];
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-semibold border {{ $badgeClasses }} leading-3">
                                        {{ $statusLabels[$prop->status] ?? ucfirst($prop->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('dosen.proposals.show', $prop) }}" class="inline-flex items-center gap-1 text-[#0B2A59] hover:underline font-semibold leading-4">
                                        <span>Buka Usulan</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
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
