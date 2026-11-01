@extends('layouts.admin')

@section('title', 'CMS Dokumen & SOP')
@section('breadcrumb', 'CMS Portal Publik / Dokumen & SOP')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul & Tombol Tambah -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Kelola Dokumen Regulasi, Renstra & SOP</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Unggah dan kelola dokumen panduan yang dapat diunduh civitas akademika di pusat unduhan portal publik.</p>
        </div>
        <div>
            <a href="{{ route('admin.documents.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Unggah Dokumen Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.documents.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Kategori Dokumen</label>
                <select name="kategori" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="pedoman_penelitian" {{ request('kategori') == 'pedoman_penelitian' ? 'selected' : '' }}>Pedoman Penelitian & SDM</option>
                    <option value="pedoman_pengabdian" {{ request('kategori') == 'pedoman_pengabdian' ? 'selected' : '' }}>Pedoman Pengabdian & Kepakaran</option>
                    <option value="proses_pengabdian" {{ request('kategori') == 'proses_pengabdian' ? 'selected' : '' }}>Proses Pengabdian kepada Masyarakat</option>
                    <option value="panduan_sistem" {{ request('kategori') == 'panduan_sistem' ? 'selected' : '' }}>Buku Panduan SIM P3M</option>
                    <option value="renstra_penelitian" {{ request('kategori') == 'renstra_penelitian' ? 'selected' : '' }}>Renstra Penelitian (2026-2031)</option>
                    <option value="renstra_pengabdian" {{ request('kategori') == 'renstra_pengabdian' ? 'selected' : '' }}>Renstra Pengabdian kepada Masyarakat</option>
                    <option value="renstra" {{ request('kategori') == 'renstra' ? 'selected' : '' }}>Rencana Strategis (Renstra) Umum</option>
                    <option value="roadmap" {{ request('kategori') == 'roadmap' ? 'selected' : '' }}>Roadmap Penelitian</option>
                    <option value="sop_penelitian" {{ request('kategori') == 'sop_penelitian' ? 'selected' : '' }}>SOP Penelitian</option>
                    <option value="sop_pengabdian" {{ request('kategori') == 'sop_pengabdian' ? 'selected' : '' }}>SOP Pengabdian</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Judul Dokumen</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci judul berkas..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['kategori', 'search']))
                        <a href="{{ route('admin.documents.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Dokumen -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Nama Dokumen</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Tahun</th>
                        <th class="py-3.5 px-4">Ukuran File</th>
                        <th class="py-3.5 px-4">Berkas</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-sm">
                                <div class="font-bold text-slate-900 leading-5">{{ $doc->judul }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $doc->deskripsi ?? 'Tanpa keterangan' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badgeClass = match($doc->kategori) {
                                        'pedoman_penelitian' => 'bg-indigo-100 text-indigo-800',
                                        'pedoman_pengabdian' => 'bg-emerald-100 text-emerald-800',
                                        'proses_pengabdian' => 'bg-teal-100 text-teal-800',
                                        'panduan_sistem', 'panduan' => 'bg-blue-100 text-blue-800',
                                        'sop_penelitian', 'sop_pengabdian' => 'bg-amber-100 text-amber-800',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                    $kategoriLabel = match($doc->kategori) {
                                        'pedoman_penelitian' => 'Pedoman Penelitian & SDM',
                                        'pedoman_pengabdian' => 'Pedoman PkM & Kepakaran',
                                        'proses_pengabdian' => 'Proses PkM',
                                        'panduan_sistem', 'panduan' => 'Panduan SIM P3M',
                                        'sop_penelitian' => 'SOP Penelitian',
                                        'sop_pengabdian' => 'SOP Pengabdian',
                                        'renstra_penelitian' => 'Renstra Penelitian',
                                        'renstra_pengabdian' => 'Renstra Pengabdian',
                                        'renstra' => 'Renstra P3M',
                                        'roadmap' => 'Roadmap Riset',
                                        default => ucwords(str_replace('_', ' ', $doc->kategori)),
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $kategoriLabel }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $doc->tahun ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-slate-500 font-medium">{{ $doc->file_size ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-[#0B2A59] hover:underline font-semibold">
                                    <span>Unduh File</span>
                                    <span>↗</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('admin.documents.edit', $doc) }}" class="text-[#0B2A59] hover:underline font-semibold">Ubah</a>
                                <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas dokumen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada berkas dokumen yang diunggah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $documents->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
