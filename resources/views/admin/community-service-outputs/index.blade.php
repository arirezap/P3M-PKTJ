@extends('layouts.admin')

@section('title', 'CMS Luaran Pengabdian kepada Masyarakat')
@section('breadcrumb', 'CMS Portal Publik / Luaran Pengabdian')

@section('content')
<div class="space-y-6" x-data="{ importModalOpen: false }">
    
    <!-- Header Modul & Tombol Aksi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Data Hasil Analisis Luaran Pengabdian (PkM)</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola luaran PkM: artikel publikasi pengabdian, teknologi tepat guna (TTG), modul SOP mitra, HKI, dan dampak desa binaan.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button @click="importModalOpen = true" type="button"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all leading-4">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Impor Data CSV</span>
            </button>
            <a href="{{ route('admin.community-service-outputs.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Tambah Data Luaran</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.community-service-outputs.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Kategori Luaran</label>
                <select name="kategori" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua">Semua Kategori</option>
                    <option value="publikasi" {{ request('kategori') == 'publikasi' ? 'selected' : '' }}>Publikasi Pengabdian</option>
                    <option value="ttg" {{ request('kategori') == 'ttg' ? 'selected' : '' }}>Teknologi Tepat Guna (TTG)</option>
                    <option value="modul" {{ request('kategori') == 'modul' ? 'selected' : '' }}>Modul / Panduan Mitra</option>
                    <option value="hki" {{ request('kategori') == 'hki' ? 'selected' : '' }}>Hak Cipta / HKI</option>
                    <option value="desa_binaan" {{ request('kategori') == 'desa_binaan' ? 'selected' : '' }}>Dampak Desa Binaan</option>
                </select>
            </div>
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
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Kata Kunci</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul, pelaksana, mitra..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-[#0B2A59] text-white text-xs font-semibold rounded-lg hover:bg-blue-900 leading-4">Cari</button>
                    @if(request()->hasAny(['kategori', 'prodi_id', 'tahun', 'search']))
                        <a href="{{ route('admin.community-service-outputs.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Luaran PkM -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Judul Luaran & Sasaran</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Prodi</th>
                        <th class="py-3.5 px-4">Tim Pelaksana</th>
                        <th class="py-3.5 px-4">Tahun</th>
                        <th class="py-3.5 px-4">Capaian & Kepuasan</th>
                        <th class="py-3.5 px-4 text-center">Berkas</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($outputs as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-xs font-medium text-slate-900 leading-5">
                                <div class="font-semibold text-slate-900">{{ $item->judul }}</div>
                                @if($item->mitra_sasaran || $item->lokasi)
                                    <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1">
                                        <span>Mitra: {{ $item->mitra_sasaran ?? '-' }} ({{ $item->lokasi ?? '-' }})</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @php
                                    $kategoriLabels = [
                                        'publikasi' => 'Publikasi PkM',
                                        'ttg' => 'Teknologi TTG',
                                        'modul' => 'Modul / SOP',
                                        'hki' => 'Hak Cipta / HKI',
                                        'desa_binaan' => 'Desa Binaan',
                                    ];
                                    $badgeClasses = [
                                        'publikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'ttg' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'modul' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'hki' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'desa_binaan' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    ];
                                @endphp
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $badgeClasses[$item->kategori] ?? 'bg-slate-50 text-slate-700' }}">
                                    {{ $kategoriLabels[$item->kategori] ?? ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ $item->prodi->kode_prodi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">{{ $item->pelaksana }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-semibold">{{ $item->tahun }}</td>
                            <td class="py-3.5 px-4">
                                @if($item->indikator_keberhasilan)
                                    <div class="font-medium text-slate-800 text-[11px] max-w-[200px] truncate" title="{{ $item->indikator_keberhasilan }}">{{ $item->indikator_keberhasilan }}</div>
                                @endif
                                @if($item->tingkat_kepuasan_mitra)
                                    <span class="inline-block mt-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                                        {{ $item->tingkat_kepuasan_mitra }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($item->berkas_luaran)
                                    <a href="{{ route('pengabdian.luaran.unduh', $item) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>PDF</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.community-service-outputs.edit', $item) }}" class="text-[#0B2A59] hover:underline font-semibold">Ubah</a>
                                <form method="POST" action="{{ route('admin.community-service-outputs.destroy', $item) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data luaran pengabdian ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                Belum ada data luaran pengabdian masyarakat yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($outputs->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $outputs->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Impor CSV Massal Luaran PkM -->
    <div x-show="importModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="importModalOpen = false"></div>
        <div class="relative bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-[#0B2A59] leading-6">Impor Data Luaran dari File CSV</h3>
                <button @click="importModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-xs text-slate-500 leading-5">
                Gunakan format kolom CSV: <br>
                <code class="bg-slate-100 px-2 py-0.5 rounded text-[11px] text-slate-800 break-all">Kategori, Judul, KodeProdi, Pelaksana, Tahun, Mitra, Lokasi, Manfaat, Indikator, Kepuasan, LinkDokumen</code>
                <br>Contoh Kategori: <strong>publikasi</strong>, <strong>ttg</strong>, <strong>modul</strong>, <strong>hki</strong>, <strong>desa_binaan</strong>.
            </p>
            <form method="POST" action="{{ route('admin.community-service-outputs.import') }}" enctype="multipart/form-data" class="space-y-4">
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
