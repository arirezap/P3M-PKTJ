@extends('layouts.admin')

@section('title', 'Pengaturan Header & Footer')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="text-xs text-slate-500 mb-1 flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0B2A59] transition-colors">Dasbor</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Pengaturan Navigasi</span>
            </nav>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0B2A59] tracking-tight leading-7 sm:leading-8">
                Pengaturan Header Menu & Footer
            </h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Kelola seluruh teks bilah atas, identitas lembaga, menu navigasi, tombol sistem, profil footer, kontak pelayanan dinas, dan tautan eksternal.
            </p>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Kesalahan Validasi -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm space-y-1">
            <div class="font-bold">Terdapat kesalahan pengisian data:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.header-footer.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Bilah Atas & Identitas Lembaga (Top Bar & Brand) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bilah Atas & Identitas</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Bilah Atas & Identitas Lembaga</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Informasi nama kementerian, badan pembina, alamat kampus, serta nama lembaga pada bilah paling atas dan logo navigasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kementerian -->
                <div class="space-y-2">
                    <label for="top_bar_kemenhub" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Kementerian (Bilah Atas Kiri) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="top_bar_kemenhub" id="top_bar_kemenhub" 
                           value="{{ old('top_bar_kemenhub', $settings['top_bar_kemenhub'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Teks kementerian pada bagian paling atas portal.</p>
                </div>

                <!-- Nama Badan Pembina -->
                <div class="space-y-2">
                    <label for="top_bar_bpsdm" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Badan Pembina (Bilah Atas Kiri) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="top_bar_bpsdm" id="top_bar_bpsdm" 
                           value="{{ old('top_bar_bpsdm', $settings['top_bar_bpsdm'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Teks badan naungan institusi.</p>
                </div>

                <!-- Info Kampus -->
                <div class="space-y-2">
                    <label for="top_bar_campus_info" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Keterangan Kampus (Bilah Atas Kanan) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="top_bar_campus_info" id="top_bar_campus_info" 
                           value="{{ old('top_bar_campus_info', $settings['top_bar_campus_info'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Keterangan lokasi kampus atau alamat singkat.</p>
                </div>

                <!-- Tagline Bilah Atas -->
                <div class="space-y-2">
                    <label for="top_bar_tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Semboyan / Tagline Bilah Atas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="top_bar_tagline" id="top_bar_tagline" 
                           value="{{ old('top_bar_tagline', $settings['top_bar_tagline'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Teks aksen kuning di sisi kanan bilah atas.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Nama Lembaga -->
                <div class="space-y-2">
                    <label for="brand_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Singkat Lembaga <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="brand_title" id="brand_title" 
                           value="{{ old('brand_title', $settings['brand_title'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Judul utama di samping logo (contoh: P3M PKTJ).</p>
                </div>

                <!-- Subjudul 1 -->
                <div class="space-y-2">
                    <label for="brand_subtitle_1" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Subjudul Nama Unit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="brand_subtitle_1" id="brand_subtitle_1" 
                           value="{{ old('brand_subtitle_1', $settings['brand_subtitle_1'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Kepanjangan unit (tampil pada layar monitor besar).</p>
                </div>

                <!-- Subjudul 2 -->
                <div class="space-y-2">
                    <label for="brand_subtitle_2" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Subjudul Nama Kampus <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="brand_subtitle_2" id="brand_subtitle_2" 
                           value="{{ old('brand_subtitle_2', $settings['brand_subtitle_2'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Nama lengkap kampus (tampil pada layar laptop).</p>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Label Menu Navigasi & Tautan Aksi -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Menu & Tautan Header</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Label Menu Navigasi & Tombol Masuk</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Kustomisasi teks label navigasi, tautan portal jurnal ilmiah, menu tautan tambahan, serta teks tombol masuk SIM P3M.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Menu 1: Beranda -->
                <div class="space-y-2">
                    <label for="menu_beranda_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Menu 1 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="menu_beranda_label" id="menu_beranda_label" 
                           value="{{ old('menu_beranda_label', $settings['menu_beranda_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Beranda</p>
                </div>

                <!-- Menu 2: Profil -->
                <div class="space-y-2">
                    <label for="menu_profil_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Menu 2 (Dropdown) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="menu_profil_label" id="menu_profil_label" 
                           value="{{ old('menu_profil_label', $settings['menu_profil_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Profil</p>
                </div>

                <!-- Menu 3: Riset -->
                <div class="space-y-2">
                    <label for="menu_riset_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Menu 3 (Dropdown) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="menu_riset_label" id="menu_riset_label" 
                           value="{{ old('menu_riset_label', $settings['menu_riset_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Riset</p>
                </div>

                <!-- Menu 4: Pengabdian -->
                <div class="space-y-2">
                    <label for="menu_pengabdian_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Menu 4 (Dropdown) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="menu_pengabdian_label" id="menu_pengabdian_label" 
                           value="{{ old('menu_pengabdian_label', $settings['menu_pengabdian_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Pengabdian</p>
                </div>

                <!-- Menu 5: Layanan -->
                <div class="space-y-2">
                    <label for="menu_layanan_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Menu 5 (Dropdown) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="menu_layanan_label" id="menu_layanan_label" 
                           value="{{ old('menu_layanan_label', $settings['menu_layanan_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Layanan</p>
                </div>
            </div>

            <!-- Tautan Jurnal & Tombol Aksi -->
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Label Jurnal -->
                <div class="space-y-2">
                    <label for="navbar_jurnal_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Label Menu Jurnal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="navbar_jurnal_label" id="navbar_jurnal_label" 
                           value="{{ old('navbar_jurnal_label', $settings['navbar_jurnal_label'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Nama tautan menu jurnal di navbar (contoh: Jurnal).</p>
                </div>

                <!-- URL Jurnal -->
                <div class="space-y-2 md:col-span-2">
                    <label for="navbar_jurnal_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Tautan URL Jurnal Ilmiah <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="navbar_jurnal_url" id="navbar_jurnal_url" 
                           value="{{ old('navbar_jurnal_url', $settings['navbar_jurnal_url'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Alamat web portal OJS jurnal (contoh: https://ktj.pktj.ac.id/).</p>
                </div>
            </div>

            <!-- Menu Kustom Tambahan & Tombol Masuk SIM -->
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Label Menu Tambahan -->
                <div class="space-y-2">
                    <label for="navbar_custom_link_label" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Label Menu Tambahan (Opsional)
                    </label>
                    <input type="text" name="navbar_custom_link_label" id="navbar_custom_link_label" 
                           value="{{ old('navbar_custom_link_label', $settings['navbar_custom_link_label'] ?? '') }}"
                           placeholder="Contoh: Helpdesk"
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Kosongkan jika tidak ingin menambahkan menu ekstra.</p>
                </div>

                <!-- URL Menu Tambahan -->
                <div class="space-y-2">
                    <label for="navbar_custom_link_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        URL Menu Tambahan (Opsional)
                    </label>
                    <input type="url" name="navbar_custom_link_url" id="navbar_custom_link_url" 
                           value="{{ old('navbar_custom_link_url', $settings['navbar_custom_link_url'] ?? '') }}"
                           placeholder="https://..."
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Tautan tujuan ketika menu ekstra diklik.</p>
                </div>

                <!-- Teks Tombol Masuk SIM -->
                <div class="space-y-2">
                    <label for="navbar_login_button" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Teks Tombol Masuk SIM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="navbar_login_button" id="navbar_login_button" 
                           value="{{ old('navbar_login_button', $settings['navbar_login_button'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Teks tombol masuk pada status tamu (default: Login SIM P3M).</p>
                </div>
            </div>
        </div>

        <!-- Bagian 3: Profil Footer, Alamat & Kontak Pelayanan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Profil & Kontak Footer</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Profil Lembaga & Kontak Pelayanan Dinas</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Informasi profil lembaga, alamat kantor dinas, alamat surel pelayanan, dan nomor telepon kontak pada kolom kiri footer.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Footer -->
                <div class="space-y-2">
                    <label for="footer_brand_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Judul Identitas Footer <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="footer_brand_title" id="footer_brand_title" 
                           value="{{ old('footer_brand_title', $settings['footer_brand_title'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: P3M PKTJ</p>
                </div>

                <!-- Subjudul Footer -->
                <div class="space-y-2">
                    <label for="footer_brand_subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Subjudul Identitas Footer <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="footer_brand_subtitle" id="footer_brand_subtitle" 
                           value="{{ old('footer_brand_subtitle', $settings['footer_brand_subtitle'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Politeknik Keselamatan Transportasi Jalan</p>
                </div>
            </div>

            <!-- Ringkasan Profil Lembaga -->
            <div class="space-y-2">
                <label for="footer_about_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Ringkasan Profil Lembaga (Tentang Singkat di Footer) <span class="text-red-500">*</span>
                </label>
                <textarea name="footer_about_text" id="footer_about_text" rows="3" required
                          class="w-full p-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all leading-relaxed">{{ old('footer_about_text', $settings['footer_about_text'] ?? '') }}</textarea>
                <p class="text-[11px] text-slate-500">Uraian ringkas peran kelembagaan P3M PKTJ bagi pengunjung portal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-slate-100">
                <!-- Alamat Kantor -->
                <div class="space-y-2">
                    <label for="footer_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Alamat Kantor Dinas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="footer_address" id="footer_address" 
                           value="{{ old('footer_address', $settings['footer_address'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Alamat lengkap kampus PKTJ.</p>
                </div>

                <!-- Email Pelayanan -->
                <div class="space-y-2">
                    <label for="footer_email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Surel / Email Kedinasan <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="footer_email" id="footer_email" 
                           value="{{ old('footer_email', $settings['footer_email'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Alamat email korespondensi dinas (contoh: p3m@pktj.ac.id).</p>
                </div>

                <!-- Telepon / Hotline -->
                <div class="space-y-2">
                    <label for="footer_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nomor Telepon / Kontak
                    </label>
                    <input type="text" name="footer_phone" id="footer_phone" 
                           value="{{ old('footer_phone', $settings['footer_phone'] ?? '') }}"
                           placeholder="(0283) 351508 / 0812-3456-7890"
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Nomor telepon kantor atau narahubung P3M.</p>
                </div>
            </div>

            <!-- Judul Kolom Navigasi -->
            <div class="pt-4 border-t border-slate-100">
                <div class="space-y-2 max-w-sm">
                    <label for="footer_nav_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Judul Kolom Navigasi Footer <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="footer_nav_title" id="footer_nav_title" 
                           value="{{ old('footer_nav_title', $settings['footer_nav_title'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Default: Navigasi Utama</p>
                </div>
            </div>
        </div>

        <!-- Bagian 4: Tautan Terkait Eksternal & Hak Cipta -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Tautan Terkait & Hak Cipta</span>
                <h2 class="text-lg font-bold text-slate-900 mt-1 leading-6">Tautan Terkait Eksternal & Hak Cipta</h2>
                <p class="text-xs text-slate-500 leading-4 mt-0.5">
                    Konfigurasi daftar pranala luar institusional dan penulisan hak cipta di baris paling bawah footer.
                </p>
            </div>

            <div class="space-y-2 max-w-sm">
                <label for="footer_links_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Judul Kolom Tautan Terkait <span class="text-red-500">*</span>
                </label>
                <input type="text" name="footer_links_title" id="footer_links_title" 
                       value="{{ old('footer_links_title', $settings['footer_links_title'] ?? '') }}"
                       required
                       class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                <p class="text-[11px] text-slate-500">Default: Tautan Terkait</p>
            </div>

            <!-- Daftar 5 Tautan Terkait -->
            <div class="space-y-4 pt-2">
                <!-- Tautan 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="space-y-1">
                        <label for="footer_link_1_label" class="block text-xs font-semibold text-slate-700">Label Tautan 1 <span class="text-red-500">*</span></label>
                        <input type="text" name="footer_link_1_label" id="footer_link_1_label" 
                               value="{{ old('footer_link_1_label', $settings['footer_link_1_label'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                    <div class="space-y-1">
                        <label for="footer_link_1_url" class="block text-xs font-semibold text-slate-700">URL Tautan 1 <span class="text-red-500">*</span></label>
                        <input type="url" name="footer_link_1_url" id="footer_link_1_url" 
                               value="{{ old('footer_link_1_url', $settings['footer_link_1_url'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                </div>

                <!-- Tautan 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="space-y-1">
                        <label for="footer_link_2_label" class="block text-xs font-semibold text-slate-700">Label Tautan 2 <span class="text-red-500">*</span></label>
                        <input type="text" name="footer_link_2_label" id="footer_link_2_label" 
                               value="{{ old('footer_link_2_label', $settings['footer_link_2_label'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                    <div class="space-y-1">
                        <label for="footer_link_2_url" class="block text-xs font-semibold text-slate-700">URL Tautan 2 <span class="text-red-500">*</span></label>
                        <input type="url" name="footer_link_2_url" id="footer_link_2_url" 
                               value="{{ old('footer_link_2_url', $settings['footer_link_2_url'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                </div>

                <!-- Tautan 3 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="space-y-1">
                        <label for="footer_link_3_label" class="block text-xs font-semibold text-slate-700">Label Tautan 3 <span class="text-red-500">*</span></label>
                        <input type="text" name="footer_link_3_label" id="footer_link_3_label" 
                               value="{{ old('footer_link_3_label', $settings['footer_link_3_label'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                    <div class="space-y-1">
                        <label for="footer_link_3_url" class="block text-xs font-semibold text-slate-700">URL Tautan 3 <span class="text-red-500">*</span></label>
                        <input type="url" name="footer_link_3_url" id="footer_link_3_url" 
                               value="{{ old('footer_link_3_url', $settings['footer_link_3_url'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                </div>

                <!-- Tautan 4 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="space-y-1">
                        <label for="footer_link_4_label" class="block text-xs font-semibold text-slate-700">Label Tautan 4 <span class="text-red-500">*</span></label>
                        <input type="text" name="footer_link_4_label" id="footer_link_4_label" 
                               value="{{ old('footer_link_4_label', $settings['footer_link_4_label'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                    <div class="space-y-1">
                        <label for="footer_link_4_url" class="block text-xs font-semibold text-slate-700">URL Tautan 4 <span class="text-red-500">*</span></label>
                        <input type="url" name="footer_link_4_url" id="footer_link_4_url" 
                               value="{{ old('footer_link_4_url', $settings['footer_link_4_url'] ?? '') }}"
                               required
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                </div>

                <!-- Tautan 5 (Opsional) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="space-y-1">
                        <label for="footer_link_5_label" class="block text-xs font-semibold text-slate-700">Label Tautan 5 (Opsional)</label>
                        <input type="text" name="footer_link_5_label" id="footer_link_5_label" 
                               value="{{ old('footer_link_5_label', $settings['footer_link_5_label'] ?? '') }}"
                               placeholder="Contoh: Portal BPSDMP"
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                    <div class="space-y-1">
                        <label for="footer_link_5_url" class="block text-xs font-semibold text-slate-700">URL Tautan 5 (Opsional)</label>
                        <input type="url" name="footer_link_5_url" id="footer_link_5_url" 
                               value="{{ old('footer_link_5_url', $settings['footer_link_5_url'] ?? '') }}"
                               placeholder="https://..."
                               class="w-full h-10 px-3 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] bg-white">
                    </div>
                </div>
            </div>

            <!-- Teks Hak Cipta -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div class="space-y-2">
                    <label for="footer_copyright_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Teks Hak Cipta Utama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="footer_copyright_text" id="footer_copyright_text" 
                           value="{{ old('footer_copyright_text', $settings['footer_copyright_text'] ?? '') }}"
                           required
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Teks hak cipta pada bagian bawah kiri footer.</p>
                </div>

                <div class="space-y-2">
                    <label for="footer_copyright_sub" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Subteks Pelengkap Hak Cipta
                    </label>
                    <input type="text" name="footer_copyright_sub" id="footer_copyright_sub" 
                           value="{{ old('footer_copyright_sub', $settings['footer_copyright_sub'] ?? '') }}"
                           class="w-full h-11 px-4 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-all">
                    <p class="text-[11px] text-slate-500">Keterangan unit pada bagian bawah kanan footer.</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 h-11 px-8 rounded-xl font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] active:scale-[0.99] text-xs sm:text-sm">
                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Simpan Pengaturan Header & Footer</span>
            </button>
        </div>
    </form>
</div>
@endsection

