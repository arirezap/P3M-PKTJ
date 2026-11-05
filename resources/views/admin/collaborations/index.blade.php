@extends('layouts.admin')

@section('title', 'CMS Kerjasama Riset & Kemitraan')
@section('breadcrumb', 'CMS Portal Publik / Kerjasama Riset')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul & Tombol Aksi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Data Kerjasama Bidang Penelitian</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola direktori kemitraan penelitian P3M PKTJ dengan kementerian, pemerintah daerah, BUMN, industri manufaktur, dan perguruan tinggi.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.collaborations.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Tambah Data Kerjasama</span>
            </a>
        </div>
    </div>


    <!-- 4 Kartu Metrik Ringkasan Kerjasama (Strict 4px Spatial Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Total Kerjasama</span>
                <span class="text-2xl font-bold text-[#0B2A59] mt-1 block leading-8">{{ $counts['total'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0B2A59] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Kerjasama Aktif</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block leading-8">{{ $counts['aktif'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Mitra Industri & BUMN</span>
                <span class="text-2xl font-bold text-amber-600 mt-1 block leading-8">{{ $counts['industri'] + $counts['bumn'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Selesai / Terarsip</span>
                <span class="text-2xl font-bold text-slate-600 mt-1 block leading-8">{{ $counts['selesai'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.collaborations.index') }}" class="grid grid-cols-1 sm:grid-cols-7 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Jenis Kegiatan</label>
                <select name="jenis_kegiatan" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Kegiatan</option>
                    <option value="penelitian" {{ request('jenis_kegiatan') == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                    <option value="pengabdian" {{ request('jenis_kegiatan') == 'pengabdian' ? 'selected' : '' }}>Pengabdian (PkM)</option>
                    <option value="keduanya" {{ request('jenis_kegiatan') == 'keduanya' ? 'selected' : '' }}>Riset & PkM</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Kategori Mitra</label>
                <select name="kategori_mitra" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Kategori</option>
                    <option value="pemerintah" {{ request('kategori_mitra') == 'pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                    <option value="bumn" {{ request('kategori_mitra') == 'bumn' ? 'selected' : '' }}>BUMN / BUMD</option>
                    <option value="industri" {{ request('kategori_mitra') == 'industri' ? 'selected' : '' }}>Industri Otomotif</option>
                    <option value="perguruan_tinggi" {{ request('kategori_mitra') == 'perguruan_tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                    <option value="lainnya" {{ request('kategori_mitra') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Program Studi</label>
                <select name="prodi_id" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Prodi (3 Prodi)</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ request('prodi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Tahun</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Status</label>
                <select name="status_kerjasama" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status_kerjasama') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status_kerjasama') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Mitra / Topik / No. MoU</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['jenis_kegiatan', 'kategori_mitra', 'prodi_id', 'tahun', 'status_kerjasama', 'search']))
                        <a href="{{ route('admin.collaborations.index') }}" class="h-10 px-3 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg hover:bg-slate-200 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Kerjasama -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Mitra & Topik Kerjasama</th>
                        <th class="py-3 px-4">Kegiatan & Prodi</th>
                        <th class="py-3 px-4">Legalitas Perjanjian</th>
                        <th class="py-3 px-4">Tahun & Status</th>
                        <th class="py-3 px-4 text-center">Dokumen</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($collaborations as $index => $collab)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-500">
                                {{ $collaborations->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 max-w-sm space-y-1">
                                <div class="font-bold text-[#0B2A59] text-sm leading-5">
                                    {{ $collab->nama_mitra }}
                                </div>
                                @if($collab->judul_kerjasama)
                                    <div class="text-xs font-semibold text-slate-800 leading-4">
                                        {{ $collab->judul_kerjasama }}
                                    </div>
                                @endif
                                @if($collab->deskripsi)
                                    <div class="text-[11px] text-slate-500 leading-4 line-clamp-2">
                                        {{ $collab->deskripsi }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 space-y-1.5">
                                <div class="flex items-center gap-1 flex-wrap">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                        @if($collab->kategori_mitra === 'pemerintah') bg-blue-100 text-blue-900
                                        @elseif($collab->kategori_mitra === 'bumn') bg-amber-100 text-amber-900
                                        @elseif($collab->kategori_mitra === 'industri') bg-emerald-100 text-emerald-900
                                        @else bg-purple-100 text-purple-900 @endif">
                                        {{ $collab->kategori_label }}
                                    </span>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold
                                        @if($collab->jenis_kegiatan === 'pengabdian') bg-emerald-50 text-emerald-700 border border-emerald-200
                                        @elseif($collab->jenis_kegiatan === 'keduanya') bg-indigo-50 text-indigo-700 border border-indigo-200
                                        @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                                        {{ $collab->jenis_kegiatan === 'pengabdian' ? 'Pengabdian' : ($collab->jenis_kegiatan === 'keduanya' ? 'Riset & PkM' : 'Penelitian') }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-slate-600 font-medium">
                                    {{ $collab->prodi ? $collab->prodi->kode_prodi : 'Institusi / Lintas Prodi' }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs space-y-1">
                                <div class="font-bold text-slate-800">{{ $collab->nomor_mou_pks ?? '-' }}</div>
                                @if($collab->tanggal_mulai && $collab->tanggal_berakhir)
                                    <div class="text-[11px] text-slate-500 leading-3">
                                        {{ $collab->tanggal_mulai->format('d/m/Y') }} - {{ $collab->tanggal_berakhir->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 space-y-1">
                                <div class="font-bold text-slate-800">Tahun {{ $collab->tahun }}</div>
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $collab->status_kerjasama === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $collab->status_kerjasama === 'aktif' ? 'Aktif' : 'Selesai' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($collab->file_dokumen)
                                    <a href="{{ asset('storage/' . $collab->file_dokumen) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-[#0B2A59] font-bold hover:underline" title="Lihat Berkas PDF">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span>PDF</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.collaborations.edit', $collab->id) }}" 
                                       class="h-8 px-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-semibold inline-flex items-center transition-colors"
                                       title="Edit Data">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.collaborations.destroy', $collab->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kerjasama ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="h-8 px-2.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-semibold inline-flex items-center transition-colors" title="Hapus Data">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 text-xs">
                                Belum ada data kerjasama penelitian yang terdaftar sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($collaborations->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $collaborations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
