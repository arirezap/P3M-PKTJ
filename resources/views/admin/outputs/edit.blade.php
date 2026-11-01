@extends('layouts.admin')

@section('title', 'Ubah Data Luaran Penelitian')
@section('breadcrumb', 'CMS Portal Publik / Luaran Penelitian / Ubah Data')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header Formulir -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Formulir Ubah Data Luaran Penelitian</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Perbarui informasi publikasi ilmiah, HKI, produk terapan, lisensi terbuka, atau berkas bukti pendukung.</p>
        </div>
        <a href="{{ route('admin.outputs.index') }}" 
           class="inline-flex items-center gap-1.5 h-10 px-4 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold leading-4">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Kotak Formulir -->
    <form action="{{ route('admin.outputs.update', $output) }}" method="POST" enctype="multipart/form-data" 
          x-data="{ kategori: '{{ old('kategori', $output->kategori) }}' }"
          class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- 1. Pemilihan Pilar Kategori Luaran -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 leading-4">
                Pilar Kategori Luaran <span class="text-rose-500">*</span>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label :class="kategori === 'publikasi' ? 'border-[#0B2A59] bg-blue-50/50 text-[#0B2A59] ring-2 ring-[#0B2A59]/20' : 'border-slate-200 hover:bg-slate-50 text-slate-700'"
                       class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all">
                    <input type="radio" name="kategori" value="publikasi" x-model="kategori" class="text-[#0B2A59] focus:ring-[#0B2A59]">
                    <div>
                        <span class="block text-xs font-bold leading-4">1. Publikasi Ilmiah</span>
                        <span class="text-[11px] text-slate-500 block leading-3 mt-0.5">Jurnal SINTA/Scopus, Prosiding</span>
                    </div>
                </label>

                <label :class="kategori === 'hki' ? 'border-amber-500 bg-amber-50/50 text-amber-900 ring-2 ring-amber-500/20' : 'border-slate-200 hover:bg-slate-50 text-slate-700'"
                       class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all">
                    <input type="radio" name="kategori" value="hki" x-model="kategori" class="text-amber-600 focus:ring-amber-500">
                    <div>
                        <span class="block text-xs font-bold leading-4">2. Hak Kekayaan Intelektual</span>
                        <span class="text-[11px] text-slate-500 block leading-3 mt-0.5">Paten, Hak Cipta, Desain</span>
                    </div>
                </label>

                <label :class="kategori === 'produk' ? 'border-emerald-600 bg-emerald-50/50 text-emerald-900 ring-2 ring-emerald-600/20' : 'border-slate-200 hover:bg-slate-50 text-slate-700'"
                       class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all">
                    <input type="radio" name="kategori" value="produk" x-model="kategori" class="text-emerald-600 focus:ring-emerald-500">
                    <div>
                        <span class="block text-xs font-bold leading-4">3. Produk / Jasa Teknologi</span>
                        <span class="text-[11px] text-slate-500 block leading-3 mt-0.5">Prototipe TKT, Sistem, Kebijakan</span>
                    </div>
                </label>
            </div>
            @error('kategori')
                <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-slate-100 pt-6 space-y-6">
            
            <!-- Judul Luaran -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                    Judul Luaran Penelitian <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul', $output->judul) }}" required placeholder="Contoh: Purwarupa Speed Limiter Cerdas untuk Kendaraan Angkutan Barang..."
                       class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] @error('judul') border-rose-400 @enderror">
                @error('judul')
                    <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                @enderror
            </div>

            <!-- Program Studi & Dosen Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Program Studi PKTJ <span class="text-rose-500">*</span>
                    </label>
                    <select name="prodi_id" required class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        <option value="">Pilih Program Studi</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('prodi_id', $output->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                        <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tahun Realisasi / Terbit <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="tahun" value="{{ old('tahun', $output->tahun) }}" min="2020" max="2035" required
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    @error('tahun')
                        <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Penulis / Inventor & Akun Dosen -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Penulis / Inventor / Tim Pengembang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="author_inventor" value="{{ old('author_inventor', $output->author_inventor) }}" required placeholder="Contoh: Dr. Ir. Hendro Wibowo, M.T."
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                    @error('author_inventor')
                        <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tautkan ke Akun Dosen (Opsional)
                    </label>
                    <select name="user_id" class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        <option value="">-- Bukan Peneliti Terdaftar / Kolaboratif --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $output->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->nidn_nip ?? 'NIDN/NIP' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bidang Spesifik Berdasarkan Kategori Luaran -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-4">
                <!-- Bidang Khusus Publikasi -->
                <div x-show="kategori === 'publikasi'">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nama Jurnal / Prosiding Konferensi / Penerbit
                    </label>
                    <input type="text" name="nama_jurnal_penerbit" value="{{ old('nama_jurnal_penerbit', $output->nama_jurnal_penerbit) }}" placeholder="Contoh: Indonesian Road Safety Journal Vol. 4 No. 2"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 bg-white focus:ring-2 focus:ring-[#0B2A59]">
                </div>

                <!-- Bidang Khusus HKI -->
                <div x-show="kategori === 'hki'" x-cloak>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nomor Registrasi / Nomor Sertifikat DJKI Kemenkumham
                    </label>
                    <input type="text" name="nomor_registrasi_hki" value="{{ old('nomor_registrasi_hki', $output->nomor_registrasi_hki) }}" placeholder="Contoh: IDS000004921 atau EC00202518290"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 bg-white focus:ring-2 focus:ring-[#0B2A59]">
                </div>

                <!-- Tingkat Kesiapan Terapan (TKT) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tingkat Kesiapterapan Teknologi (TKT)
                    </label>
                    <select name="tingkat_kesiapan_terapan" class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 bg-white focus:ring-2 focus:ring-[#0B2A59]">
                        <option value="">Pilih Skala TKT (1 - 9)</option>
                        @for($i = 1; $i <= 9; $i++)
                            <option value="TKT {{ $i }}" {{ old('tingkat_kesiapan_terapan', $output->tingkat_kesiapan_terapan) == "TKT $i" ? 'selected' : '' }}>
                                TKT {{ $i }} @if($i <= 3) (Prinsip Dasar / Formulasi Konsep) @elseif($i <= 6) (Validasi Model / Prototipe Lapangan) @else (Sistem Teruji / Operasional Nyata) @endif
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Indikator Akreditasi: Lisensi Terbuka & Keselarasan Roadmap -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Lisensi Terbuka (Open License / Access)
                    </label>
                    <input type="text" name="lisensi" value="{{ old('lisensi', $output->lisensi) }}" placeholder="Contoh: CC BY 4.0, Open Access, MIT License, GPL v3, dsb."
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Fase Roadmap Penelitian Keselamatan PKTJ
                    </label>
                    <select name="fase_roadmap" class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59]">
                        <option value="">Pilih Fase Peta Jalan Riset</option>
                        <option value="Fase 1 - Riset Dasar & Titik Rawan" {{ old('fase_roadmap', $output->fase_roadmap) == 'Fase 1 - Riset Dasar & Titik Rawan' ? 'selected' : '' }}>Fase 1 - Riset Dasar & Titik Rawan (2026-2027)</option>
                        <option value="Fase 2 - Inovasi Rekayasa Cerdas" {{ old('fase_roadmap', $output->fase_roadmap) == 'Fase 2 - Inovasi Rekayasa Cerdas' ? 'selected' : '' }}>Fase 2 - Inovasi Rekayasa Cerdas (2028-2029)</option>
                        <option value="Fase 3 - Hilirisasi & Kemitraan Industri" {{ old('fase_roadmap', $output->fase_roadmap) == 'Fase 3 - Hilirisasi & Kemitraan Industri' ? 'selected' : '' }}>Fase 3 - Hilirisasi & Kemitraan Industri (2030-2031)</option>
                    </select>
                </div>
            </div>

            <!-- Mitra Kerjasama & Realisasi Sumber Dana -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Instansi / Mitra Kerjasama
                    </label>
                    <input type="text" name="mitra_kerjasama" value="{{ old('mitra_kerjasama', $output->mitra_kerjasama) }}" placeholder="Contoh: PT Astra Daihatsu / KNKT / Dishub"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59]">
                </div>

                <div class="sm:col-span-1">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Sumber Dana Riset
                    </label>
                    <select name="sumber_dana" class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59]">
                        <option value="DIPA PKTJ" {{ old('sumber_dana', $output->sumber_dana) == 'DIPA PKTJ' ? 'selected' : '' }}>DIPA PKTJ / Kemenhub</option>
                        <option value="Kemdiktisaintek" {{ old('sumber_dana', $output->sumber_dana) == 'Kemdiktisaintek' ? 'selected' : '' }}>Kemdiktisaintek / Nasional</option>
                        <option value="Mitra Industri" {{ old('sumber_dana', $output->sumber_dana) == 'Mitra Industri' ? 'selected' : '' }}>Mitra Industri / Eksternal</option>
                        <option value="Mandiri" {{ old('sumber_dana', $output->sumber_dana) == 'Mandiri' ? 'selected' : '' }}>Mandiri / Swadana</option>
                    </select>
                </div>

                <div class="sm:col-span-1">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Realisasi Dana R&D (Rp)
                    </label>
                    <input type="number" name="realisasi_dana" value="{{ old('realisasi_dana', $output->realisasi_dana) }}" min="0" step="1000"
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59]">
                </div>
            </div>

            <!-- Tautan URL Eksternal & Unggah Berkas Dokumen PDF -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tautan URL Dokumen (DOI / SINTA / DJKI)
                    </label>
                    <input type="url" name="link_dokumen" value="{{ old('link_dokumen', $output->link_dokumen) }}" placeholder="https://doi.org/10.xxxx atau https://pdki-indonesia..."
                           class="w-full h-11 border-slate-300 rounded-xl text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] @error('link_dokumen') border-rose-400 @enderror">
                    @error('link_dokumen')
                        <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Unggah Bukti Berkas PDF (Maks. 10 MB)
                    </label>
                    <input type="file" name="berkas_luaran" accept="application/pdf"
                           class="w-full h-11 border border-slate-300 rounded-xl text-xs leading-4 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
                    
                    @if($output->berkas_luaran)
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[11px] text-slate-500">Berkas saat ini:</span>
                            <a href="{{ asset('storage/' . $output->berkas_luaran) }}" target="_blank" class="text-[11px] text-blue-600 font-semibold hover:underline flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Lihat Berkas PDF</span>
                            </a>
                        </div>
                    @endif
                    @error('berkas_luaran')
                        <p class="text-xs text-rose-500 mt-1 leading-4">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi Kemanfaatan & Keberlanjutan -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                    Deskripsi Keberlanjutan & Kemanfaatan Hasil Riset
                </label>
                <textarea name="deskripsi_kemanfaatan" rows="3" placeholder="Jelaskan dampak nyata luaran riset ini dalam mendukung keselamatan transportasi jalan..."
                          class="w-full border-slate-300 rounded-xl text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('deskripsi_kemanfaatan', $output->deskripsi_kemanfaatan) }}</textarea>
            </div>

        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.outputs.index') }}" class="h-11 px-5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 font-semibold text-xs leading-4 inline-flex items-center">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white font-semibold text-xs leading-4 shadow-sm active:scale-[0.98] transition-all">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
