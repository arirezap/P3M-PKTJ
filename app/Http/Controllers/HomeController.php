<?php

namespace App\Http\Controllers;

use App\Models\CommunityService;
use App\Models\Document;
use App\Models\Post;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda publik SIM P3M PKTJ dengan data dinamis.
     */
    public function index(): View
    {
        // 1. Ambil publikasi berita, agenda, dan pengumuman yang berstatus published
        $publishedPosts = Post::where('status', 'published')
            ->orderBy('is_pinned', 'desc')
            ->latest('tanggal_publikasi')
            ->get();

        $beritaList = $publishedPosts->whereIn('kategori', ['berita', 'agenda'])->take(6);
        $pengumumanList = $publishedPosts->where('kategori', 'pengumuman')->take(4);

        $postsData = $publishedPosts->map(function ($p) {
            return [
                'id' => $p->id,
                'judul' => $p->judul,
                'kategori' => $p->kategori,
                'tanggal' => $p->tanggal_publikasi ? $p->tanggal_publikasi->translatedFormat('d F Y') : '-',
                'ringkasan' => $p->ringkasan,
                'konten' => $p->konten,
                'gambar_sampul' => $p->gambar_sampul ? asset('storage/' . $p->gambar_sampul) : null,
            ];
        })->values();

        // 3. Ambil berkas dokumen SOP dan panduan layanan (Renstra & Roadmap memiliki halaman tersendiri di menu Profil)
        $sopDocuments = Document::whereNotIn('kategori', ['renstra', 'roadmap'])->latest()->take(8)->get();
        $documents = $sopDocuments->isNotEmpty() ? $sopDocuments : Document::latest()->take(8)->get();

        // 4. Ambil data master 3 prodi PKTJ
        $prodis = Prodi::all();

        // 5. Ambil data rekapitulasi riset dan pengabdian
        $researches = Research::with('prodi')->latest('tahun')->get();
        $communityServices = CommunityService::with('prodi')->latest('tahun')->get();

        // Siapkan dataset JSON untuk filter interaktif Alpine.js
        $kegiatanList = [];
        $yearsSet = [];

        foreach ($researches as $r) {
            $yearStr = (string) $r->tahun;
            $yearsSet[$yearStr] = true;
            $kegiatanList[] = [
                'id' => 'r-' . $r->id,
                'judul' => $r->judul,
                'prodi' => $r->prodi ? $r->prodi->kode_prodi : 'TRO',
                'tahun' => $yearStr,
                'jenis' => 'penelitian',
                'ketua' => $r->ketua_peneliti,
                'dana' => $r->sumber_dana ?? 'Internal PKTJ',
                'anggaran' => 'Rp ' . number_format($r->anggaran, 0, ',', '.'),
                'status' => $r->status ?? 'Selesai',
            ];
        }

        foreach ($communityServices as $cs) {
            $yearStr = (string) $cs->tahun;
            $yearsSet[$yearStr] = true;
            $kegiatanList[] = [
                'id' => 'cs-' . $cs->id,
                'judul' => $cs->judul,
                'prodi' => $cs->prodi ? $cs->prodi->kode_prodi : 'TRO',
                'tahun' => $yearStr,
                'jenis' => 'pengabdian',
                'ketua' => $cs->ketua_pelaksana,
                'dana' => $cs->sumber_dana ?? 'Internal PKTJ',
                'anggaran' => 'Rp ' . number_format($cs->anggaran, 0, ',', '.'),
                'status' => $cs->status ?? 'Selesai',
            ];
        }

        krsort($yearsSet);
        $availableYears = array_keys($yearsSet);
        if (empty($availableYears)) {
            $availableYears = ['2026', '2025', '2024'];
        }

        // Statistik ringkas kinerja P3M
        $stats = [
            'total_riset' => $researches->count() ?: 128,
            'total_pkm' => $communityServices->count() ?: 84,
            'total_dokumen' => $documents->count() ?: 12,
            'total_prodi' => $prodis->count() ?: 3,
        ];

        // 6. Ambil data pengaturan beranda dan video profil dari CMS
        $settingsData = Setting::where('group', 'homepage')->pluck('value', 'key')->toArray();
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

        $settings = array_merge($defaultSettings, $settingsData);
        $videoEmbedUrl = Setting::getYoutubeEmbedUrl($settings['video_profile_url'] ?? null);

        return view('welcome', compact(
            'beritaList',
            'pengumumanList',
            'postsData',
            'documents',
            'prodis',
            'kegiatanList',
            'availableYears',
            'stats',
            'settings',
            'videoEmbedUrl'
        ));
    }
}
