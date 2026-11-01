@extends('layouts.admin')

@section('title', 'Manajemen Usulan Proposal')
@section('breadcrumb', 'Manajemen Usulan / Daftar Proposal & Penugasan Reviewer')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Manajemen Usulan Proposal & Penugasan Reviewer</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Verifikasi berkas administrasi proposal yang masuk dan tetapkan reviewer untuk penilaian substansi.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 leading-4">
                Total {{ $proposals->total() }} Usulan Terdata
            </span>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.proposals.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Jenis Usulan</label>
                <select name="jenis" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua">Semua Jenis</option>
                    <option value="penelitian" {{ request('jenis') == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                    <option value="pengabdian" {{ request('jenis') == 'pengabdian' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Status Seleksi</label>
                <select name="status" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draf</option>
                    <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                    <option value="sedang_direview" {{ request('status') == 'sedang_direview' ? 'selected' : '' }}>Sedang Dinilai</option>
                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima (Lolos)</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Kode / Judul</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['jenis', 'status', 'search']))
                        <a href="{{ route('admin.proposals.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Usulan Proposal -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Kode & Judul Usulan</th>
                        <th class="py-3.5 px-4">Pengusul & Prodi</th>
                        <th class="py-3.5 px-4">Tahun / Anggaran</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Reviewer Ditugaskan</th>
                        <th class="py-3.5 px-4 text-right">Aksi & Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($proposals as $prop)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-xs">
                                <span class="font-bold text-[#0B2A59] block">{{ $prop->kode_usulan }}</span>
                                <div class="font-medium text-slate-900 leading-5 mt-0.5">{{ $prop->judul }}</div>
                                <span class="inline-block mt-1 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                                    Jenis: {{ $prop->jenis }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800">{{ $prop->ketua->name }}</div>
                                <div class="text-[11px] text-slate-400">Prodi: {{ $prop->prodi->kode_prodi }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-700">TA {{ $prop->tahun_anggaran }}</div>
                                <div class="text-slate-600 font-medium">Rp {{ number_format($prop->total_anggaran, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                                    {{ $prop->status === 'diterima' ? 'bg-emerald-100 text-emerald-800' : ($prop->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ str_replace('_', ' ', $prop->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($prop->reviews->isEmpty())
                                    <form method="POST" action="{{ route('admin.proposals.assign-reviewer', $prop) }}" class="flex items-center gap-1">
                                        @csrf
                                        <select name="reviewer_id" required class="h-8 border-slate-300 rounded text-[11px] leading-3 py-1">
                                            <option value="">Pilih Reviewer...</option>
                                            @foreach($reviewers as $rev)
                                                <option value="{{ $rev->id }}">{{ $rev->name }} ({{ $rev->prodi->kode_prodi ?? '-' }})</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="h-8 px-2 bg-[#0B2A59] text-white text-[11px] font-semibold rounded hover:bg-blue-900 leading-3">Tugaskan</button>
                                    </form>
                                @else
                                    <div class="space-y-1">
                                        @foreach($prop->reviews as $rev)
                                            <div class="text-[11px] text-slate-800 font-medium flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span>{{ $rev->reviewer->name }}</span>
                                                <span class="text-[10px] text-slate-500">({{ $rev->status_review }})</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form method="POST" action="{{ route('admin.proposals.update-status', $prop) }}" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="h-8 border-slate-300 rounded text-[11px] leading-3 py-1">
                                        <option value="diajukan" {{ $prop->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                        <option value="verifikasi_administrasi" {{ $prop->status == 'verifikasi_administrasi' ? 'selected' : '' }}>Lolos Berkas</option>
                                        <option value="sedang_direview" {{ $prop->status == 'sedang_direview' ? 'selected' : '' }}>Sedang Dinilai</option>
                                        <option value="revisi" {{ $prop->status == 'revisi' ? 'selected' : '' }}>Revisi</option>
                                        <option value="diterima" {{ $prop->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="ditolak" {{ $prop->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <button type="submit" class="h-8 px-2 bg-slate-800 text-white text-[11px] font-semibold rounded hover:bg-slate-700 leading-3">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada usulan proposal yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($proposals->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
