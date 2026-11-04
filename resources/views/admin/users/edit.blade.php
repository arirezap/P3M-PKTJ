@extends('layouts.admin')

@section('title', 'Sunting Profil Peneliti & Akun')
@section('breadcrumb', 'Manajemen Pengguna / Sunting Profil Peneliti')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Tombol Kembali -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-[#0B2A59] transition-colors leading-4">
                    &larr; Kembali ke Daftar Pengguna
                </a>
            </div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Sunting Profil Peneliti &amp; Dosen</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Perbarui data profil akademik, afiliasi program studi, kepakaran riset, serta metrik publikasi SINTA & Scopus.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm flex-shrink-0">
            @else
                <div class="w-12 h-12 rounded-xl bg-[#0B2A59] text-white font-bold text-sm flex items-center justify-center shadow-sm flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <span class="block text-xs font-bold text-slate-900 leading-4">{{ $user->name }}</span>
                <div class="flex flex-wrap gap-1 mt-1">
                    @foreach($user->getRolesList() as $r)
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $r === 'admin' ? 'bg-purple-100 text-purple-800' : ($r === 'reviewer' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ $r === 'peneliti' ? 'Peneliti' : ucfirst($r) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi Validasi -->
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs space-y-1">
            <div class="font-bold">Mohon periksa kembali formulir berikut:</div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir Pembaruan Profil Peneliti -->
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Identitas Akademik Dasar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-3 leading-5">
                1. Identitas Akademik & Afiliasi
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nama Lengkap Beserta Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="Contoh: Dr. Ir. Hendro Wibowo, M.T.">
                </div>

                <div>
                    <label for="nidn_nip" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        NIDN atau NIP
                    </label>
                    <input type="text" id="nidn_nip" name="nidn_nip" value="{{ old('nidn_nip', $user->nidn_nip) }}"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="Nomor Induk Dosen Nasional">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="nama@pktj.ac.id">
                </div>

                <div>
                    <label for="prodi_id" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Program Studi PKTJ
                    </label>
                    <select id="prodi_id" name="prodi_id" class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4">
                        <option value="">-- Tanpa Afiliasi Prodi Khusus --</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}" {{ old('prodi_id', $user->prodi_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->jenjang }} {{ $p->nama_prodi }} ({{ $p->kode_prodi }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Peran Sistem / Multi-Peran (Dapat Memilih Lebih dari Satu) <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex flex-wrap items-center gap-6 p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="peneliti" {{ in_array('peneliti', old('roles', $user->getRolesList()), true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="text-xs font-semibold text-slate-800">Peneliti / Dosen</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="reviewer" {{ in_array('reviewer', old('roles', $user->getRolesList()), true) ? 'checked' : '' }} class="w-4 h-4 text-amber-600 border-slate-300 rounded focus:ring-amber-500">
                            <span class="text-xs font-semibold text-slate-800">Reviewer / Penilai</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="roles[]" value="admin" {{ in_array('admin', old('roles', $user->getRolesList()), true) ? 'checked' : '' }} class="w-4 h-4 text-purple-700 border-slate-300 rounded focus:ring-purple-600">
                            <span class="text-xs font-semibold text-slate-800">Administrator P3M</span>
                        </label>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1 leading-4">Satu pengguna dapat memegang beberapa peran sekaligus (contoh: Dosen Peneliti yang juga ditugaskan sebagai Reviewer atau Admin).</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="no_telp" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="Contoh: 081234567890">
                </div>
            </div>
        </div>

        <!-- Bagian 2: Kepakaran Riset & Profil Akademik (SINTA, Scopus, Google Scholar) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-3 leading-5">
                2. Kepakaran Riset & Tautan Metrik Ilmiah
            </h2>

            <div class="space-y-4">
                <div>
                    <label for="keahlian" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Bidang Keahlian / Fokus Riset Utama
                    </label>
                    <input type="text" id="keahlian" name="keahlian" value="{{ old('keahlian', $user->keahlian) }}"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="Contoh: Keselamatan Kendaraan, Otomasi & Sistem Pengereman Cerdas">
                    <p class="text-[11px] text-slate-400 mt-1 leading-4">Fokus keilmuan ini akan ditampilkan pada kartu profil peneliti di portal publik.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="sinta_id" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                            SINTA Author ID
                        </label>
                        <input type="text" id="sinta_id" name="sinta_id" value="{{ old('sinta_id', $user->sinta_id) }}"
                               class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                               placeholder="Contoh: 6012345">
                    </div>

                    <div>
                        <label for="scopus_id" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                            Scopus Author ID
                        </label>
                        <input type="text" id="scopus_id" name="scopus_id" value="{{ old('scopus_id', $user->scopus_id) }}"
                               class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                               placeholder="Contoh: 57219876543">
                    </div>

                    <div>
                        <label for="google_scholar" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                            Google Scholar URL
                        </label>
                        <input type="text" id="google_scholar" name="google_scholar" value="{{ old('google_scholar', $user->google_scholar) }}"
                               class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                               placeholder="https://scholar.google.com/citations?user=...">
                    </div>
                </div>

                <div>
                    <label for="avatar" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Unggah Foto Profil Dosen (Avatar)
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/png,image/jpeg,image/webp"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0B2A59] hover:file:bg-blue-100">
                    <p class="text-[11px] text-slate-400 mt-1 leading-4">Format: JPG, JPEG, PNG, atau WEBP. Ukuran berkas maksimal 2 MB.</p>
                </div>
            </div>
        </div>

        <!-- Bagian 3: Keamanan & Status Keaktifan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-3 leading-5">
                3. Keamanan Akun & Status Publikasi
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Ubah Kata Sandi (Opsional)
                    </label>
                    <input type="password" id="password" name="password"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-4"
                           placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                </div>

                <div class="flex items-center pt-6">
                    <label class="relative flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', $user->status_aktif) ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                        <span class="text-xs font-semibold text-slate-700 leading-4">
                            Aktifkan status akun & tampilkan di Direktori Peneliti Publik
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan & Batal -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.users.index') }}" class="h-11 px-5 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50 flex items-center leading-4 transition-colors">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-150 leading-4">
                Simpan Perubahan Profil
            </button>
        </div>
    </form>

    <!-- Ringkasan Data Portofolio Riset & Publikasi Dosen -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-3 leading-5">
            4. Ringkasan Rekapitulasi Portofolio Akademik
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Riset Terhubung -->
            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/70 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 leading-4">Riset Terapan Terhubung</span>
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-blue-100 text-[#0B2A59]">
                        {{ $user->researches->count() }} Kegiatan
                    </span>
                </div>
                @if($user->researches->isNotEmpty())
                    <ul class="text-xs text-slate-600 divide-y divide-slate-100 mt-2">
                        @foreach($user->researches->take(3) as $r)
                            <li class="py-1.5 leading-4">
                                <span class="font-semibold text-slate-800">{{ $r->tahun }}</span> - {{ Str::limit($r->judul, 70) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada riset yang terhubung langsung ke akun ini.</p>
                @endif
                <div class="pt-2">
                    <a href="{{ route('admin.researches.index') }}" class="text-[11px] font-semibold text-[#0B2A59] hover:underline leading-4">
                        Kelola di Data Riset per Prodi &rarr;
                    </a>
                </div>
            </div>

            <!-- Publikasi & HKI -->
            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/70 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 leading-4">Publikasi & HKI Terdaftar</span>
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                        {{ $user->outputs->count() }} Luaran
                    </span>
                </div>
                @if($user->outputs->isNotEmpty())
                    <ul class="text-xs text-slate-600 divide-y divide-slate-100 mt-2">
                        @foreach($user->outputs->take(3) as $o)
                            <li class="py-1.5 leading-4">
                                <span class="font-semibold text-slate-800 uppercase text-[10px]">[{{ $o->kategori }}]</span> {{ Str::limit($o->judul, 65) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada luaran publikasi atau HKI yang terdaftar.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
