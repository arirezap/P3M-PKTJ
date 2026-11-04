@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna')
@section('breadcrumb', 'Manajemen Pengguna / Akun Dosen & Reviewer')

@section('content')
<div class="space-y-6" x-data="{ userModalOpen: false }">
    
    <!-- Header Modul & Tombol Tambah -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Manajemen Akun Dosen & Reviewer</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Kelola data profil akademik, NIDN, program studi, dan penetapan multi-peran pengguna (Admin, Reviewer, Peneliti).</p>
        </div>
        <div>
            <button @click="userModalOpen = true" type="button" 
                    class="inline-flex items-center justify-center h-12 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-150 shadow-sm active:scale-[0.98] leading-4">
                <span>+ Daftarkan Akun Baru</span>
            </button>
        </div>
    </div>

    <!-- Sub Menu Filter Peran Pengguna (Sesuai Kebutuhan SIM P3M Admin View) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm">
        <nav class="flex space-x-2 overflow-x-auto text-xs font-semibold">
            <a href="{{ route('admin.users.index', array_merge(request()->except('role', 'page'), ['role' => 'semua'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap {{ $selectedRole === 'semua' ? 'bg-[#0B2A59] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Semua Pengguna</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedRole === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $stats['total'] }}
                </span>
            </a>
            <a href="{{ route('admin.users.index', array_merge(request()->except('role', 'page'), ['role' => 'admin'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap {{ $selectedRole === 'admin' ? 'bg-purple-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Admin</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedRole === 'admin' ? 'bg-white/20 text-white' : 'bg-purple-100 text-purple-800' }}">
                    {{ $stats['admin'] }}
                </span>
            </a>
            <a href="{{ route('admin.users.index', array_merge(request()->except('role', 'page'), ['role' => 'reviewer'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap {{ $selectedRole === 'reviewer' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Reviewer</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedRole === 'reviewer' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }}">
                    {{ $stats['reviewer'] }}
                </span>
            </a>
            <a href="{{ route('admin.users.index', array_merge(request()->except('role', 'page'), ['role' => 'peneliti'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap {{ $selectedRole === 'peneliti' ? 'bg-blue-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <span>Peneliti</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedRole === 'peneliti' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-800' }}">
                    {{ $stats['peneliti'] }}
                </span>
            </a>
        </nav>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <input type="hidden" name="role" value="{{ $selectedRole }}">
            <div class="sm:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Cari Nama Pengguna / Email / NIDN</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama dosen, email, atau NIDN/NIP..." class="w-full h-10 px-3 border-slate-300 rounded-lg text-xs leading-4">
                    <button type="submit" class="h-10 px-6 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 leading-4">Cari</button>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.users.index', ['role' => $selectedRole]) }}" class="h-10 px-4 border border-slate-300 text-slate-600 text-xs font-medium rounded-lg hover:bg-slate-50 flex items-center leading-4">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-4 px-4">Nama Lengkap &amp; NIDN</th>
                        <th class="py-4 px-4">Email</th>
                        <th class="py-4 px-4 min-w-[280px]">Penetapan Peran (Multi-Peran)</th>
                        <th class="py-4 px-4">Program Studi</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $usr)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($usr->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($usr->avatar))
                                        <img src="{{ asset('storage/' . $usr->avatar) }}" alt="{{ $usr->name }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 flex-shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-[#0B2A59]/10 text-[#0B2A59] font-bold text-xs flex items-center justify-center flex-shrink-0">
                                            {{ strtoupper(substr($usr->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 leading-5">{{ $usr->name }}</div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">NIDN/NIP: {{ $usr->nidn_nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-medium">{{ $usr->email }}</td>
                            <td class="py-4 px-4">
                                <form method="POST" action="{{ route('admin.users.update-roles', $usr) }}" class="space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                            <input type="checkbox" name="roles[]" value="admin" {{ $usr->hasRole('admin') ? 'checked' : '' }} class="w-4 h-4 text-purple-700 rounded border-slate-300 focus:ring-purple-600">
                                            <span class="text-xs font-semibold text-purple-900">Admin</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                            <input type="checkbox" name="roles[]" value="reviewer" {{ $usr->hasRole('reviewer') ? 'checked' : '' }} class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                                            <span class="text-xs font-semibold text-amber-900">Reviewer</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                            <input type="checkbox" name="roles[]" value="peneliti" {{ $usr->hasRole('peneliti') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                            <span class="text-xs font-semibold text-blue-900">Peneliti</span>
                                        </label>
                                        <button type="submit" class="h-8 px-3 bg-slate-800 hover:bg-[#0B2A59] text-white rounded-lg text-xs font-semibold transition-colors shadow-xs">
                                            Simpan Peran
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1">
                                        @foreach($usr->getRolesList() as $r)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider 
                                                {{ $r === 'admin' ? 'bg-purple-100 text-purple-800 border border-purple-200' : ($r === 'reviewer' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-blue-800 border border-blue-200') }}">
                                                {{ $r === 'peneliti' ? 'Peneliti' : ucfirst($r) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </form>
                            </td>
                            <td class="py-4 px-4 text-slate-700 font-medium">
                                {{ $usr->prodi ? $usr->prodi->kode_prodi : '-' }}
                            </td>
                            <td class="py-4 px-4">
                                @if($usr->status_aktif)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users.edit', $usr) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#0B2A59] hover:text-blue-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span>Sunting</span>
                                    </a>
                                    <span class="text-slate-300">|</span>
                                    @if($usr->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $usr) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-semibold {{ $usr->status_aktif ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800' }} transition-colors">
                                                {{ $usr->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-400 italic">Akun Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada akun pengguna yang ditemukan pada kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Akun Baru -->
    <div x-show="userModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="userModalOpen = false"></div>
        <div class="relative bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-[#0B2A59] leading-6">Daftarkan Akun Pengguna Baru</h3>
                <button @click="userModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Dr. Ir. Budi Santoso, M.T." class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Email Pengguna <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required placeholder="nama@pktj.ac.id" class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Kata Sandi Awal <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">Peran Pengguna (Dapat Memilih Lebih dari Satu) <span class="text-rose-500">*</span></label>
                    <div class="flex flex-wrap items-center gap-4 p-3 rounded-xl border border-slate-200 bg-slate-50/50">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="peneliti" checked class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                            <span class="text-xs font-medium text-slate-700">Peneliti</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="reviewer" class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                            <span class="text-xs font-medium text-slate-700">Reviewer</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="admin" class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                            <span class="text-xs font-medium text-slate-700">Admin</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Program Studi PKTJ</label>
                    <select name="prodi_id" class="w-full h-10 border-slate-300 rounded-xl text-xs">
                        <option value="">Non-Prodi / Umum</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">NIDN / NIP</label>
                        <input type="text" name="nidn_nip" placeholder="10 digit NIDN" class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">No. Kontak / WhatsApp</label>
                        <input type="text" name="no_telp" placeholder="0812xxxxxxxx" class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Bidang Fokus / Kepakaran</label>
                    <input type="text" name="keahlian" placeholder="Contoh: Keselamatan Transportasi, Otomasi Kendaraan..." class="w-full h-10 px-3 border-slate-300 rounded-xl text-xs">
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="userModalOpen = false" class="h-10 px-4 border border-slate-300 text-xs font-semibold text-slate-700 rounded-xl hover:bg-slate-50">Batal</button>
                    <button type="submit" class="h-10 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl shadow-sm">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
