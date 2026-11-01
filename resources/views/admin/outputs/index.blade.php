@extends('layouts.admin')

@section('title', 'CMS Luaran Riset (Publikasi, HKI, Produk/Jasa)')
@section('breadcrumb', 'CMS Portal Publik / Luaran Penelitian')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul & Tombol Aksi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Data Luaran Penelitian (Publikasi, HKI, Produk/Jasa)</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola diseminasi hasil riset dosen & taruna PKTJ: lisensi terbuka, kemanfaatan roadmap, mitra kerjasama, dan realisasi dana.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.outputs.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Tambah Data Luaran</span>
            </a>
        </div>
    </div>

    <!-- 4 Kartu Metrik Ringkasan Luaran -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Total Luaran</span>
                <span class="text-2xl font-bold text-[#0B2A59] mt-1 block leading-8">{{ $counts['total'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0B2A59] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Publikasi Ilmiah</span>
                <span class="text-2xl font-bold text-blue-600 mt-1 block leading-8">{{ $counts['publikasi'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Hak Kekayaan Intelektual</span>
                <span class="text-2xl font-bold text-amber-600 mt-1 block leading-8">{{ $counts['hki'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block leading-4">Produk & Jasa Terapan</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block leading-8">{{ $counts['produk'] }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.outputs.index') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Pilar Kategori</label>
                <select name="kategori" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Kategori</option>
                    <option value="publikasi" {{ request('kategori') == 'publikasi' ? 'selected' : '' }}>Publikasi Ilmiah</option>
                    <option value="hki" {{ request('kategori') == 'hki' ? 'selected' : '' }}>Hak Kekayaan Intelektual</option>
                    <option value="produk" {{ request('kategori') == 'produk' ? 'selected' : '' }}>Produk & Jasa Teknologi</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Program Studi</label>
                <select name="prodi_id" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="">Semua Prodi</option>
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
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Judul / Inventor / Mitra</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['kategori', 'prodi_id', 'tahun', 'search']))
                        <a href="{{ route('admin.outputs.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Luaran -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs leading-5">
                <thead class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5">Kategori & Judul Luaran</th>
                        <th class="px-5 py-3.5">Program Studi</th>
                        <th class="px-5 py-3.5">Penulis / Inventor</th>
                        <th class="px-5 py-3.5">Lisensi & Roadmap</th>
                        <th class="px-5 py-3.5">Mitra & Realisasi Dana</th>
                        <th class="px-5 py-3.5">Bukti Berkas</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($outputs as $output)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-4 max-w-xs sm:max-w-md">
                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                    @if($output->kategori === 'publikasi')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800">Publikasi</span>
                                    @elseif($output->kategori === 'hki')
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800">HKI</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">Produk/Jasa</span>
                                    @endif

                                    <span class="text-slate-400 text-[11px] font-semibold">Tahun {{ $output->tahun }}</span>

                                    @if($output->tingkat_kesiapan_terapan)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[10px]">{{ $output->tingkat_kesiapan_terapan }}</span>
                                    @endif
                                </div>
                                <span class="font-bold text-slate-900 block leading-5">{{ $output->judul }}</span>
                                
                                @if($output->nama_jurnal_penerbit)
                                    <p class="text-[11px] text-slate-500 mt-0.5 font-medium leading-4">{{ $output->nama_jurnal_penerbit }}</p>
                                @endif
                                @if($output->nomor_registrasi_hki)
                                    <p class="text-[11px] text-amber-700 font-semibold mt-0.5 leading-4">No. Registrasi: {{ $output->nomor_registrasi_hki }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-[#0B2A59]/10 text-[#0B2A59] font-bold text-[11px]">
                                    {{ $output->prodi->kode_prodi ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-700 font-medium">
                                {{ $output->author_inventor }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded leading-4">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        <span>{{ $output->lisensi ?? 'Lisensi Standar' }}</span>
                                    </span>
                                    <p class="text-[11px] text-slate-500 leading-4">{{ $output->fase_roadmap ?? 'Peta Jalan Riset' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-slate-800 font-semibold block leading-4">{{ $output->mitra_kerjasama ?? 'Mandiri / PKTJ' }}</span>
                                <span class="text-[11px] text-slate-500 block mt-0.5 leading-4">
                                    {{ $output->sumber_dana ?? 'DIPA PKTJ' }} • Rp {{ number_format($output->realisasi_dana ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if($output->berkas_luaran)
                                        <a href="{{ asset('storage/' . $output->berkas_luaran) }}" target="_blank"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold text-[11px] leading-4" title="Lihat Berkas Dokumen PDF">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>PDF</span>
                                        </a>
                                    @endif

                                    @if($output->link_dokumen)
                                        <a href="{{ $output->link_dokumen }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold text-[11px] leading-4" title="Buka Tautan Luar (DOI/SINTA/DJKI)">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            <span>URL</span>
                                        </a>
                                    @endif

                                    @if(!$output->berkas_luaran && !$output->link_dokumen)
                                        <span class="text-[11px] text-slate-400 italic">Belum ada</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.outputs.edit', $output) }}" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.outputs.destroy', $output) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data luaran penelitian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="font-semibold text-slate-700">Belum ada data luaran penelitian.</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "+ Tambah Data Luaran" untuk menambahkan publikasi, HKI, atau produk terapan baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($outputs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $outputs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
