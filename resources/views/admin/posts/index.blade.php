@extends('layouts.admin')

@section('title', 'CMS Berita & Pengumuman')
@section('breadcrumb', 'CMS Portal Publik / Berita & Pengumuman')

@section('content')
<div class="space-y-6">
    
    <!-- Header Modul & Tombol Tambah -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Kelola Berita, Agenda & Pengumuman</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Terbitkan informasi kegiatan riset, pelatihan, dan pengumuman call for proposals di portal utama.</p>
        </div>
        <div>
            <a href="{{ route('admin.posts.create') }}" 
               class="inline-flex items-center justify-center h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Buat Publikasi Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Kategori</label>
                <select name="kategori" onchange="this.form.submit()" class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita Kegiatan</option>
                    <option value="agenda" {{ request('kategori') == 'agenda' ? 'selected' : '' }}>Agenda Diseminasi</option>
                    <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman P3M</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Judul / Ringkasan</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian..." class="w-full h-10 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-4 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->hasAny(['kategori', 'search']))
                        <a href="{{ route('admin.posts.index') }}" class="h-10 px-3 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Publikasi -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-4">Judul Publikasi</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Tanggal Terbit</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Penulis</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 max-w-sm">
                                <div class="font-bold text-slate-900 leading-5 line-clamp-1">{{ $post->judul }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $post->ringkasan }}</div>
                                @if($post->is_pinned)
                                    <span class="inline-block mt-1 text-[10px] font-bold text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded border border-yellow-200">Disematkan</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                                    {{ $post->kategori === 'pengumuman' ? 'bg-amber-100 text-amber-800' : ($post->kategori === 'agenda' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                    {{ $post->kategori }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $post->tanggal_publikasi ? $post->tanggal_publikasi->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $post->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $post->author->name ?? 'Admin' }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-[#0B2A59] hover:underline font-semibold">Ubah</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus publikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada publikasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
