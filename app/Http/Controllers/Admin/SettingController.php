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
     * Menampilkan formulir pengaturan profil dan video beranda publik.
     */
    public function editProfile(): View
    {
        $settings = Setting::where('group', 'homepage')->pluck('value', 'key')->toArray();

        // Nilai fallback jika belum ada di database
        $defaultSettings = [
            'video_profile_url' => 'https://www.youtube.com/watch?v=5F_fNlPGBdQ',
            'video_profile_title' => 'Video Profil P3M PKTJ Tegal',
            'video_profile_desc' => 'Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi',
            'video_profile_active' => '1',
            'about_lead' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.',
            'about_vision_mission' => 'P3M PKTJ berkomitmen mengakselerasi inovasi teknologi terapan yang solutif guna menurunkan angka fatalitas kecelakaan lalu lintas nasional, mengoptimalkan kelaikan operasional kendaraan bermotor, dan mentransfer pengetahuan ilmiah langsung kepada masyarakat, industri transportasi, dan instansi pembina keselamatan.',
            'facility_1_title' => 'Laboratorium Uji Keselamatan',
            'facility_1_desc' => 'Fasilitas uji terstandar untuk simulasi dinamika kendaraan, uji pengereman aktif, dan visualisasi geometri jalan.',
            'facility_2_title' => 'Audit Koridor Pantura Jawa',
            'facility_2_desc' => 'Survei lapangan berkala di koridor pantai utara Jawa Tengah untuk memetakan titik rawan kecelakaan (black spot).',
            'facility_3_title' => 'Aksi Nyata Pengabdian',
            'facility_3_desc' => 'Sosialisasi budaya keselamatan berkendara bagi pelajar, pengemudi angkutan umum, dan bengkel mitra binaan.',
        ];

        $merged = array_merge($defaultSettings, $settings);
        $currentEmbedUrl = Setting::getYoutubeEmbedUrl($merged['video_profile_url']);

        return view('admin.settings.profile', [
            'settings' => $merged,
            'currentEmbedUrl' => $currentEmbedUrl,
        ]);
    }

    /**
     * Memperbarui pengaturan profil dan video beranda publik.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'video_profile_url' => 'nullable|string|max:500',
            'video_profile_title' => 'required|string|max:255',
            'video_profile_desc' => 'nullable|string|max:500',
            'video_profile_active' => 'nullable|in:0,1',
            'about_lead' => 'nullable|string',
            'about_vision_mission' => 'nullable|string',
            'facility_1_title' => 'nullable|string|max:255',
            'facility_1_desc' => 'nullable|string|max:500',
            'facility_2_title' => 'nullable|string|max:255',
            'facility_2_desc' => 'nullable|string|max:500',
            'facility_3_title' => 'nullable|string|max:255',
            'facility_3_desc' => 'nullable|string|max:500',
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
}
