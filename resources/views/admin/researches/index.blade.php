@extends('layouts.admin')

@section('title', 'CMS Data Riset per Prodi')
@section('breadcrumb', 'CMS Portal Publik / Data Riset')

@section('content')
<div class="space-y-6" x-data="{ importModalOpen: false }">
    
    <!-- Header Modul & Tombol Aksi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Data Rekapitulasi Riset per Program Studi</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola data kegiatan penelitian dosen PKTJ (D4 RSTJ, D4 TRO, D3 TO) yang tampil pada tabel & grafik publik.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button @click="importModalOpen = true" type="button"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all leading-4">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Impor Data CSV</span>
            </button>
            <a href="{{ route('admin.researches.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Tambah Data Riset</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.researches.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Program Studi</label>
                <select name="prodi_id" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua">Semua Prodi</option>
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
                    <option value="semua">Semua Tahun</option>
                    @foreach($tahunList as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Judul / Peneliti</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['prodi_id', 'tahun', 'search']))
                        <a href="{{ route('admin.researches.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Riset -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Judul Penelitian</th>
                        <th class="py-3.5 px-4">Prodi</th>
                        <th class="py-3.5 px-4">Ketua Peneliti</th>
                        <th class="py-3.5 px-4">Tahun</th>
                        <th class="py-3.5 px-4">Sumber Dana</th>
                        <th class="py-3.5 px-4">Anggaran</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($researches as $res)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-xs font-medium text-slate-900 leading-5">
                                {{ $res->judul }}
                                <div class="text-[11px] text-slate-400 mt-0.5">Skema: {{ $res->skema ?? 'Penelitian Terapan' }}</div>
                                @if($res->berkas_laporan)
                                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 mt-1 leading-3">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Berkas PDF</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0B2A59] border border-blue-200">
                                    {{ $res->prodi->kode_prodi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium">{{ $res->ketua_peneliti }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-semibold">{{ $res->tahun }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $res->sumber_dana }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">Rp {{ number_format($res->anggaran, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('admin.researches.edit', $res) }}" class="text-[#0B2A59] hover:underline font-semibold">Ubah</a>
                                <form method="POST" action="{{ route('admin.researches.destroy', $res) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data riset ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                Belum ada data riset yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($researches->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $researches->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Impor CSV Massal -->
    <div x-show="importModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="importModalOpen = false"></div>
        <div class="relative bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-[#0B2A59] leading-6">Impor Data Riset dari File CSV</h3>
                <button @click="importModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-xs text-slate-500 leading-5">
                Gunakan format kolom CSV: <br>
                <code class="bg-slate-100 px-2 py-0.5 rounded text-[11px] text-slate-800">Judul, KodeProdi, Ketua, Anggota, Tahun, Skema, SumberDana, Anggaran, Status</code>
                <br>Contoh KodeProdi: <strong>RSTJ</strong>, <strong>TRO</strong>, <strong>TO</strong>.
            </p>
            <form method="POST" action="{{ route('admin.researches.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Pilih Berkas CSV</label>
                    <input type="file" name="file_csv" required accept=".csv,.txt" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-[#0B2A59] hover:file:bg-slate-200">
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="importModalOpen = false" class="h-10 px-4 border border-slate-300 text-xs font-semibold text-slate-700 rounded-xl hover:bg-slate-50">Batal</button>
                    <button type="submit" class="h-10 px-5 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl shadow-sm">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
