<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Menampilkan formulir pengaturan profil, narasi, dan video beranda publik.
     */
    public function editProfile(): View
    {
        $settings = Setting::where('group', 'homepage')->pluck('value', 'key')->toArray();

        // Nilai bawaan jika belum dikonfigurasi di basis data
        $defaultSettings = [
            'hero_badge' => 'Pusat Penelitian & Pengabdian kepada Masyarakat PKTJ',
            'hero_title' => 'Riset Unggulan & Pengabdian Berbasis Keselamatan Transportasi Jalan',
            'about_title' => 'Tentang Pusat Penelitian dan Pengabdian kepada Masyarakat',
            'about_lead' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana akademik di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.',
            'about_vision_mission' => 'P3M PKTJ bertugas mengoordinasikan, memfasilitasi, dan mendiseminasikan hasil penelitian terapan dan pengabdian masyarakat dosen dan taruna pada 3 Program Studi di lingkungan PKTJ (D4 RSTJ, D4 TRO, dan D3 TO) demi meningkatkan keselamatan transportasi darat nasional.',
            'video_profile_url' => 'https://www.youtube.com/watch?v=5F_fNlPGBdQ',
            'video_profile_title' => 'Video Profil P3M PKTJ Tegal',
            'video_profile_desc' => 'Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi',
            'video_profile_active' => '1',
            'news_badge' => 'Informasi & Diseminasi Riset',
            'news_title' => 'Berita Terkini dan Agenda P3M PKTJ',
            'news_desc' => 'Publikasi Berita Terkini, jadwal seleksi proposal, dan warta diseminasi riset terapan sivitas akademika PKTJ.',
        ];

        $merged = array_merge($defaultSettings, $settings);
        $currentEmbedUrl = Setting::getYoutubeEmbedUrl($merged['video_profile_url']);

        return view('admin.settings.profile', [
            'settings' => $merged,
            'currentEmbedUrl' => $currentEmbedUrl,
        ]);
    }

    /**
     * Memperbarui pengaturan judul, narasi, dan video beranda publik.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:500',
            'about_title' => 'required|string|max:255',
            'about_lead' => 'nullable|string',
            'about_vision_mission' => 'nullable|string',
            'video_profile_url' => 'nullable|string|max:500',
            'video_profile_title' => 'required|string|max:255',
            'video_profile_desc' => 'nullable|string|max:500',
            'video_profile_active' => 'nullable|in:0,1',
            'news_badge' => 'nullable|string|max:255',
            'news_title' => 'required|string|max:255',
            'news_desc' => 'nullable|string|max:500',
            // Kompatibilitas atribut lama (jika dikirim)
            'facility_1_title' => 'nullable|string|max:255',
            'facility_1_desc' => 'nullable|string|max:500',
            'facility_2_title' => 'nullable|string|max:255',
            'facility_2_desc' => 'nullable|string|max:500',
            'facility_3_title' => 'nullable|string|max:255',
            'facility_3_desc' => 'nullable|string|max:500',
        ], [
            'hero_title.required' => 'Judul utama beranda wajib diisi.',
            'about_title.required' => 'Judul seksi Tentang P3M wajib diisi.',
            'video_profile_title.required' => 'Judul video profil wajib diisi.',
            'news_title.required' => 'Judul seksi Berita Terkini wajib diisi.',
        ]);

        // Atur nilai default toggle video
        $validated['video_profile_active'] = $request->has('video_profile_active') ? '1' : '0';

        foreach ($validated as $key => $val) {
            Setting::set($key, $val, 'homepage');
        }

        return redirect()->route('admin.settings.profile')
            ->with('success', 'Pengaturan Beranda & Video Profil berhasil disimpan dan diperbarui.');
    }

    /**
     * Menampilkan formulir pengaturan Visi, Misi & Tujuan P3M PKTJ.
     */
    public function editVisiMisi(): View
    {
        $settings = Setting::where('group', 'visi_misi')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'visi_title' => 'Visi P3M Politeknik Keselamatan Transportasi Jalan',
            'visi_statement' => 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.',
            'visi_subtext' => 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.',
            'misi_1' => 'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.',
            'misi_2' => 'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
            'misi_3' => 'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.',
            'misi_4' => 'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.',
            'misi_5' => 'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.',
            'tujuan_lead' => 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.',
            'tujuan_1_title' => 'Reduksi Fatalitas Kecelakaan',
            'tujuan_1_desc' => 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.',
            'tujuan_2_title' => 'Kemandirian Riset Vokasi',
            'tujuan_2_desc' => 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.',
            'tujuan_3_title' => 'Penguatan HKI & Jurnal Ilmiah',
            'tujuan_3_desc' => 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.',
            'tujuan_4_title' => 'Pemberdayaan Masyarakat Pantura',
            'tujuan_4_desc' => 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.',
        ];

        $merged = array_merge($defaultSettings, $settings);

        return view('admin.settings.visi-misi', [
            'settings' => $merged,
        ]);
    }

    /**
     * Memperbarui pengaturan Visi, Misi & Tujuan P3M PKTJ.
     */
    public function updateVisiMisi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'visi_title' => 'required|string|max:255',
            'visi_statement' => 'required|string',
            'visi_subtext' => 'nullable|string',
            'misi_1' => 'required|string',
            'misi_2' => 'required|string',
            'misi_3' => 'required|string',
            'misi_4' => 'nullable|string',
            'misi_5' => 'nullable|string',
            'tujuan_lead' => 'nullable|string',
            'tujuan_1_title' => 'required|string|max:255',
            'tujuan_1_desc' => 'required|string',
            'tujuan_2_title' => 'required|string|max:255',
            'tujuan_2_desc' => 'required|string',
            'tujuan_3_title' => 'nullable|string|max:255',
            'tujuan_3_desc' => 'nullable|string',
            'tujuan_4_title' => 'nullable|string|max:255',
            'tujuan_4_desc' => 'nullable|string',
        ], [
            'visi_title.required' => 'Judul visi wajib diisi.',
            'visi_statement.required' => 'Pernyataan visi wajib diisi.',
            'misi_1.required' => 'Butir misi pertama wajib diisi.',
            'misi_2.required' => 'Butir misi kedua wajib diisi.',
            'misi_3.required' => 'Butir misi ketiga wajib diisi.',
            'tujuan_1_title.required' => 'Judul tujuan 1 wajib diisi.',
            'tujuan_1_desc.required' => 'Deskripsi tujuan 1 wajib diisi.',
            'tujuan_2_title.required' => 'Judul tujuan 2 wajib diisi.',
            'tujuan_2_desc.required' => 'Deskripsi tujuan 2 wajib diisi.',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val, 'visi_misi');
        }

        return redirect()->route('admin.settings.visi-misi')
            ->with('success', 'Pengaturan Visi, Misi & Tujuan berhasil disimpan dan diperbarui.');
    }

    /**
     * Menampilkan formulir pengaturan Header (Navbar) dan Footer publik.
     */
    public function editHeaderFooter(): View
    {
        $settings = Setting::getNavigationSettings();

        return view('admin.settings.header-footer', [
            'settings' => $settings,
        ]);
    }

    /**
     * Memperbarui pengaturan Header (Navbar) dan Footer publik.
     */
    public function updateHeaderFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Top Mini Bar & Brand
            'top_bar_kemenhub' => 'required|string|max:255',
            'top_bar_bpsdm' => 'required|string|max:255',
            'top_bar_campus_info' => 'required|string|max:255',
            'top_bar_tagline' => 'required|string|max:255',
            'brand_title' => 'required|string|max:255',
            'brand_subtitle_1' => 'required|string|max:255',
            'brand_subtitle_2' => 'required|string|max:255',

            // Header Menus & Action
            'menu_beranda_label' => 'required|string|max:100',
            'menu_profil_label' => 'required|string|max:100',
            'menu_riset_label' => 'required|string|max:100',
            'menu_pengabdian_label' => 'required|string|max:100',
            'menu_layanan_label' => 'required|string|max:100',
            'navbar_jurnal_label' => 'required|string|max:100',
            'navbar_jurnal_url' => 'required|url|max:500',
            'navbar_custom_link_label' => 'nullable|string|max:100',
            'navbar_custom_link_url' => 'nullable|url|max:500',
            'navbar_login_button' => 'required|string|max:100',

            // Footer Profil & Kontak
            'footer_brand_title' => 'required|string|max:255',
            'footer_brand_subtitle' => 'required|string|max:255',
            'footer_about_text' => 'required|string',
            'footer_address' => 'required|string|max:255',
            'footer_email' => 'required|string|email|max:255',
            'footer_phone' => 'nullable|string|max:100',
            'footer_nav_title' => 'required|string|max:100',

            // Footer Tautan Terkait
            'footer_links_title' => 'required|string|max:100',
            'footer_link_1_label' => 'required|string|max:100',
            'footer_link_1_url' => 'required|url|max:500',
            'footer_link_2_label' => 'required|string|max:100',
            'footer_link_2_url' => 'required|url|max:500',
            'footer_link_3_label' => 'required|string|max:100',
            'footer_link_3_url' => 'required|url|max:500',
            'footer_link_4_label' => 'required|string|max:100',
            'footer_link_4_url' => 'required|url|max:500',
            'footer_link_5_label' => 'nullable|string|max:100',
            'footer_link_5_url' => 'nullable|url|max:500',

            // Footer Hak Cipta
            'footer_copyright_text' => 'required|string|max:255',
            'footer_copyright_sub' => 'nullable|string|max:255',
        ], [
            'top_bar_kemenhub.required' => 'Nama kementerian pada bilah atas wajib diisi.',
            'top_bar_bpsdm.required' => 'Nama badan naungan pada bilah atas wajib diisi.',
            'brand_title.required' => 'Nama singkatan lembaga (brand) wajib diisi.',
            'menu_beranda_label.required' => 'Label menu Beranda wajib diisi.',
            'menu_profil_label.required' => 'Label menu Profil wajib diisi.',
            'menu_riset_label.required' => 'Label menu Riset wajib diisi.',
            'menu_pengabdian_label.required' => 'Label menu Pengabdian wajib diisi.',
            'menu_layanan_label.required' => 'Label menu Layanan wajib diisi.',
            'navbar_jurnal_label.required' => 'Label menu Jurnal wajib diisi.',
            'navbar_jurnal_url.required' => 'Tautan URL Jurnal wajib diisi.',
            'navbar_jurnal_url.url' => 'Format URL Jurnal harus valid (dimulai dengan http:// atau https://).',
            'navbar_login_button.required' => 'Teks tombol masuk SIM wajib diisi.',
            'footer_brand_title.required' => 'Judul identitas footer wajib diisi.',
            'footer_about_text.required' => 'Ringkasan profil lembaga di footer wajib diisi.',
            'footer_address.required' => 'Alamat kantor di footer wajib diisi.',
            'footer_email.required' => 'Email pelayanan di footer wajib diisi.',
            'footer_email.email' => 'Format email pelayanan tidak valid.',
            'footer_link_1_url.url' => 'Format URL tautan 1 tidak valid.',
            'footer_link_2_url.url' => 'Format URL tautan 2 tidak valid.',
            'footer_link_3_url.url' => 'Format URL tautan 3 tidak valid.',
            'footer_link_4_url.url' => 'Format URL tautan 4 tidak valid.',
            'footer_copyright_text.required' => 'Teks hak cipta footer wajib diisi.',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val, 'navigation');
        }

        return redirect()->route('admin.settings.header-footer')
            ->with('success', 'Pengaturan Header Menu & Footer berhasil disimpan dan diperbarui.');
    }
}
