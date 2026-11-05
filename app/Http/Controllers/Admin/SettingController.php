<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
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
            'visi_badge' => 'Arah Haluan Riset & Pengabdian PKTJ 2026 - 2031',
            'page_title' => 'Visi, Misi & Tujuan P3M',
            'page_lead' => 'Visi, Misi, dan Tujuan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.',
            'visi_title' => 'Visi P3M Politeknik Keselamatan Transportasi Jalan',
            'visi_statement' => 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.',
            'visi_subtext' => 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.',
            'tujuan_lead' => 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.',
        ];

        $merged = array_merge($defaultSettings, $settings);

        // Resolusi butir Misi dinamis
        $misiList = [];
        if (! empty($settings['misi_items'])) {
            $decoded = json_decode($settings['misi_items'], true);
            if (is_array($decoded) && count($decoded) > 0) {
                $misiList = array_values(array_filter($decoded, fn ($v) => ! is_null($v) && trim($v) !== ''));
            }
        }
        if (empty($misiList)) {
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($settings["misi_{$i}"])) {
                    $misiList[] = $settings["misi_{$i}"];
                }
            }
        }
        if (empty($misiList)) {
            $misiList = [
                'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.',
                'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
                'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.',
                'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.',
                'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.',
            ];
        }

        // Resolusi butir Tujuan dinamis
        $tujuanList = [];
        if (! empty($settings['tujuan_items'])) {
            $decoded = json_decode($settings['tujuan_items'], true);
            if (is_array($decoded) && count($decoded) > 0) {
                $tujuanList = array_values(array_filter($decoded, function ($item) {
                    return is_array($item) && (! empty(trim($item['title'] ?? '')) || ! empty(trim($item['desc'] ?? '')));
                }));
            }
        }
        if (empty($tujuanList)) {
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($settings["tujuan_{$i}_title"])) {
                    $tujuanList[] = [
                        'title' => $settings["tujuan_{$i}_title"],
                        'desc' => $settings["tujuan_{$i}_desc"] ?? '',
                    ];
                }
            }
        }
        if (empty($tujuanList)) {
            $tujuanList = [
                [
                    'title' => 'Reduksi Fatalitas Kecelakaan',
                    'desc' => 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.',
                ],
                [
                    'title' => 'Kemandirian Riset Vokasi',
                    'desc' => 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.',
                ],
                [
                    'title' => 'Penguatan HKI & Jurnal Ilmiah',
                    'desc' => 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.',
                ],
                [
                    'title' => 'Pemberdayaan Masyarakat Pantura',
                    'desc' => 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.',
                ],
            ];
        }

        return view('admin.settings.visi-misi', [
            'settings' => $merged,
            'misiList' => $misiList,
            'tujuanList' => $tujuanList,
        ]);
    }

    /**
     * Memperbarui pengaturan Visi, Misi & Tujuan P3M PKTJ.
     */
    public function updateVisiMisi(Request $request): RedirectResponse
    {
        // Normalisasi input dinamis dari form jika dikirim
        if ($request->has('misi_items')) {
            $misiItems = array_values(array_filter((array) $request->input('misi_items'), fn ($v) => ! is_null($v) && trim($v) !== ''));
            $request->merge(['misi_items' => $misiItems]);
        }
        if ($request->has('tujuan_items')) {
            $tujuanItems = array_values(array_filter((array) $request->input('tujuan_items'), function ($item) {
                return is_array($item) && (! empty(trim($item['title'] ?? '')) || ! empty(trim($item['desc'] ?? '')));
            }));
            $request->merge(['tujuan_items' => $tujuanItems]);
        }

        $rules = [
            'visi_badge' => 'nullable|string|max:255',
            'page_title' => 'required|string|max:255',
            'page_lead' => 'required|string',
            'visi_title' => 'required|string|max:255',
            'visi_statement' => 'required|string',
            'visi_subtext' => 'nullable|string',
            'tujuan_lead' => 'nullable|string',
        ];

        if ($request->has('misi_items')) {
            $rules['misi_items'] = 'required|array|min:1';
            $rules['misi_items.*'] = 'required|string';
        } else {
            $rules['misi_1'] = 'required|string';
            $rules['misi_2'] = 'nullable|string';
            $rules['misi_3'] = 'nullable|string';
            $rules['misi_4'] = 'nullable|string';
            $rules['misi_5'] = 'nullable|string';
        }

        if ($request->has('tujuan_items')) {
            $rules['tujuan_items'] = 'required|array|min:1';
            $rules['tujuan_items.*.title'] = 'required|string|max:255';
            $rules['tujuan_items.*.desc'] = 'required|string';
        } else {
            $rules['tujuan_1_title'] = 'required|string|max:255';
            $rules['tujuan_1_desc'] = 'required|string';
            $rules['tujuan_2_title'] = 'nullable|string|max:255';
            $rules['tujuan_2_desc'] = 'nullable|string';
            $rules['tujuan_3_title'] = 'nullable|string|max:255';
            $rules['tujuan_3_desc'] = 'nullable|string';
            $rules['tujuan_4_title'] = 'nullable|string|max:255';
            $rules['tujuan_4_desc'] = 'nullable|string';
        }

        $messages = [
            'page_title.required' => 'Judul halaman Visi, Misi & Tujuan wajib diisi.',
            'page_lead.required' => 'Deskripsi pengantar halaman Visi, Misi & Tujuan wajib diisi.',
            'visi_title.required' => 'Judul visi wajib diisi.',
            'visi_statement.required' => 'Pernyataan visi wajib diisi.',
            'misi_items.min' => 'Minimal harus ada 1 butir misi yang tersimpan.',
            'misi_items.*.required' => 'Setiap butir misi tidak boleh kosong.',
            'tujuan_items.min' => 'Minimal harus ada 1 butir sasaran / tujuan yang tersimpan.',
            'tujuan_items.*.title.required' => 'Judul setiap butir sasaran / tujuan wajib diisi.',
            'tujuan_items.*.desc.required' => 'Deskripsi setiap butir sasaran / tujuan wajib diisi.',
        ];

        $validated = $request->validate($rules, $messages);

        // Simpan kunci teks umum
        $simpleKeys = ['visi_badge', 'page_title', 'page_lead', 'visi_title', 'visi_statement', 'visi_subtext', 'tujuan_lead'];
        foreach ($simpleKeys as $k) {
            if (array_key_exists($k, $validated)) {
                Setting::set($k, $validated[$k], 'visi_misi');
            }
        }

        // Simpan butir Misi (JSON terstruktur & sinkronisasi kompatibilitas)
        if (isset($validated['misi_items'])) {
            $misiValues = array_values($validated['misi_items']);
            Setting::set('misi_items', json_encode($misiValues), 'visi_misi');
            for ($i = 1; $i <= 5; $i++) {
                Setting::set("misi_{$i}", $misiValues[$i - 1] ?? '', 'visi_misi');
            }
        } else {
            $legacyMisi = [];
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($validated["misi_{$i}"])) {
                    $legacyMisi[] = $validated["misi_{$i}"];
                    Setting::set("misi_{$i}", $validated["misi_{$i}"], 'visi_misi');
                }
            }
            if (! empty($legacyMisi)) {
                Setting::set('misi_items', json_encode($legacyMisi), 'visi_misi');
            }
        }

        // Simpan butir Tujuan (JSON terstruktur & sinkronisasi kompatibilitas)
        if (isset($validated['tujuan_items'])) {
            $tujuanValues = array_values($validated['tujuan_items']);
            Setting::set('tujuan_items', json_encode($tujuanValues), 'visi_misi');
            for ($i = 1; $i <= 4; $i++) {
                Setting::set("tujuan_{$i}_title", $tujuanValues[$i - 1]['title'] ?? '', 'visi_misi');
                Setting::set("tujuan_{$i}_desc", $tujuanValues[$i - 1]['desc'] ?? '', 'visi_misi');
            }
        } else {
            $legacyTujuan = [];
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($validated["tujuan_{$i}_title"])) {
                    $legacyTujuan[] = [
                        'title' => $validated["tujuan_{$i}_title"],
                        'desc' => $validated["tujuan_{$i}_desc"] ?? '',
                    ];
                    Setting::set("tujuan_{$i}_title", $validated["tujuan_{$i}_title"], 'visi_misi');
                    Setting::set("tujuan_{$i}_desc", $validated["tujuan_{$i}_desc"] ?? '', 'visi_misi');
                }
            }
            if (! empty($legacyTujuan)) {
                Setting::set('tujuan_items', json_encode($legacyTujuan), 'visi_misi');
            }
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

    /**
     * Menampilkan formulir pengaturan konten dan berkas PDF Rencana Strategis (Renstra).
     */
    public function editRenstra(): View
    {
        $settings = Setting::where('group', 'renstra')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'renstra_badge' => 'Arah Kebijakan Kelembagaan 2026 - 2031',
            'renstra_title' => 'Rencana Strategis Penelitian & Pengabdian kepada Masyarakat',
            'renstra_lead' => 'Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.',
            'renstra_custom_html' => '',
        ];

        $merged = array_merge($defaultSettings, $settings);

        $renstraPenelitian = Document::where('kategori', 'renstra_penelitian')
            ->orWhere(function ($q) {
                $q->where('kategori', 'renstra')
                    ->where('judul', 'like', '%penelitian%');
            })
            ->latest()
            ->first();

        $renstraPengabdian = Document::where('kategori', 'renstra_pengabdian')
            ->orWhere(function ($q) {
                $q->where('kategori', 'renstra')
                    ->where('judul', 'like', '%pengabdian%');
            })
            ->latest()
            ->first();

        return view('admin.settings.renstra', [
            'settings' => $merged,
            'renstraPenelitian' => $renstraPenelitian,
            'renstraPengabdian' => $renstraPengabdian,
        ]);
    }

    /**
     * Memperbarui pengaturan konten narasi dan berkas PDF Rencana Strategis.
     */
    public function updateRenstra(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'renstra_badge' => 'nullable|string|max:255',
            'renstra_title' => 'required|string|max:500',
            'renstra_lead' => 'required|string',
            'renstra_custom_html' => 'nullable|string',
            'file_renstra_penelitian' => 'nullable|file|mimes:pdf|max:20480',
            'file_renstra_pengabdian' => 'nullable|file|mimes:pdf|max:20480',
        ], [
            'renstra_title.required' => 'Judul halaman Rencana Strategis wajib diisi.',
            'renstra_lead.required' => 'Deskripsi pengantar Rencana Strategis wajib diisi.',
            'file_renstra_penelitian.mimes' => 'Berkas Renstra Penelitian harus berupa file PDF.',
            'file_renstra_penelitian.max' => 'Ukuran berkas Renstra Penelitian maksimal 20 MB.',
            'file_renstra_pengabdian.mimes' => 'Berkas Renstra Pengabdian harus berupa file PDF.',
            'file_renstra_pengabdian.max' => 'Ukuran berkas Renstra Pengabdian maksimal 20 MB.',
        ]);

        // Simpan setting teks & HTML
        Setting::set('renstra_badge', $validated['renstra_badge'] ?? '', 'renstra');
        Setting::set('renstra_title', $validated['renstra_title'], 'renstra');
        Setting::set('renstra_lead', $validated['renstra_lead'], 'renstra');
        Setting::set('renstra_custom_html', $validated['renstra_custom_html'] ?? '', 'renstra');

        // Unggah berkas baru Renstra Penelitian jika diunggah
        if ($request->hasFile('file_renstra_penelitian')) {
            $file = $request->file('file_renstra_penelitian');
            $path = $file->store('documents', 'public');
            $size = round($file->getSize() / 1024 / 1024, 1).' MB';

            $doc = Document::where('kategori', 'renstra_penelitian')->first();
            if ($doc) {
                $doc->update([
                    'file_path' => $path,
                    'file_size' => $size,
                ]);
            } else {
                Document::create([
                    'judul' => 'Dokumen Rencana Strategis Penelitian 2026-2031',
                    'kategori' => 'renstra_penelitian',
                    'deskripsi' => 'Arah kebijakan dan target indikator kinerja riset keselamatan transportasi darat PKTJ.',
                    'file_path' => $path,
                    'file_size' => $size,
                    'tahun' => '2026 - 2031',
                    'user_id' => auth()->id(),
                ]);
            }
        }

        // Unggah berkas baru Renstra Pengabdian jika diunggah
        if ($request->hasFile('file_renstra_pengabdian')) {
            $file = $request->file('file_renstra_pengabdian');
            $path = $file->store('documents', 'public');
            $size = round($file->getSize() / 1024 / 1024, 1).' MB';

            $doc = Document::where('kategori', 'renstra_pengabdian')->first();
            if ($doc) {
                $doc->update([
                    'file_path' => $path,
                    'file_size' => $size,
                ]);
            } else {
                Document::create([
                    'judul' => 'Dokumen Rencana Strategis Pengabdian Kepada Masyarakat',
                    'kategori' => 'renstra_pengabdian',
                    'deskripsi' => 'Pedoman tata kelola dan target capaian program pengabdian kepada masyarakat PKTJ.',
                    'file_path' => $path,
                    'file_size' => $size,
                    'tahun' => '2026 - 2031',
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('admin.settings.renstra')
            ->with('success', 'Pengaturan Rencana Strategis dan berkas dokumen berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman CMS pengaturan narasi dan berkas PDF Roadmap Penelitian.
     */
    public function editRoadmap(): View
    {
        $settings = Setting::where('group', 'roadmap')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'roadmap_badge' => 'Peta Jalan Riset Terapan PKTJ',
            'roadmap_title' => 'Roadmap Penelitian',
            'roadmap_lead' => 'Dokumen Roadmap Penelitian Politeknik Keselamatan Transportasi Jalan.',
            'roadmap_custom_html' => '',
        ];

        $merged = array_merge($defaultSettings, $settings);

        $roadmapDokumen = Document::where('kategori', 'roadmap')
            ->orWhere(function ($q) {
                $q->where('judul', 'like', '%roadmap%');
            })
            ->latest()
            ->first();

        return view('admin.settings.roadmap', [
            'settings' => $merged,
            'roadmapDokumen' => $roadmapDokumen,
        ]);
    }

    /**
     * Memperbarui pengaturan konten narasi dan berkas PDF Roadmap Penelitian.
     */
    public function updateRoadmap(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'roadmap_badge' => 'nullable|string|max:255',
            'roadmap_title' => 'required|string|max:500',
            'roadmap_lead' => 'required|string',
            'roadmap_custom_html' => 'nullable|string',
            'file_roadmap' => 'nullable|file|mimes:pdf|max:20480',
        ], [
            'roadmap_title.required' => 'Judul halaman Roadmap Penelitian wajib diisi.',
            'roadmap_lead.required' => 'Deskripsi pengantar Roadmap Penelitian wajib diisi.',
            'file_roadmap.mimes' => 'Berkas Roadmap Penelitian harus berupa file PDF.',
            'file_roadmap.max' => 'Ukuran berkas Roadmap Penelitian maksimal 20 MB.',
        ]);

        // Simpan setting teks & HTML
        Setting::set('roadmap_badge', $validated['roadmap_badge'] ?? '', 'roadmap');
        Setting::set('roadmap_title', $validated['roadmap_title'], 'roadmap');
        Setting::set('roadmap_lead', $validated['roadmap_lead'], 'roadmap');
        Setting::set('roadmap_custom_html', $validated['roadmap_custom_html'] ?? '', 'roadmap');

        // Unggah berkas baru Roadmap jika diunggah
        if ($request->hasFile('file_roadmap')) {
            $file = $request->file('file_roadmap');
            $path = $file->store('documents', 'public');
            $size = round($file->getSize() / 1024 / 1024, 1).' MB';

            $doc = Document::where('kategori', 'roadmap')
                ->orWhere(function ($q) {
                    $q->where('judul', 'like', '%roadmap%');
                })
                ->first();

            if ($doc) {
                $doc->update([
                    'file_path' => $path,
                    'file_size' => $size,
                ]);
            } else {
                Document::create([
                    'judul' => 'Roadmap Penelitian Keselamatan Transportasi Terpadu',
                    'kategori' => 'roadmap',
                    'deskripsi' => 'Peta jalan penelitian terpadu Politeknik Keselamatan Transportasi Jalan.',
                    'file_path' => $path,
                    'file_size' => $size,
                    'tahun' => '2026 - 2031',
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('admin.settings.roadmap')
            ->with('success', 'Pengaturan Roadmap Penelitian dan berkas dokumen berhasil diperbarui.');
    }
}
