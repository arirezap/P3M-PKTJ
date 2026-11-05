<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda publik P3M PKTJ sesuai spesifikasi Kebutuhan Website P3M rev.pdf (Hal. 1):
     * 1. Tentang P3M PKTJ
     * 2. Video profil
     * 3. Berita terkini
     */
    public function index(): View
    {
        // 1. Ambil publikasi pos yang berstatus published
        $publishedPosts = Post::where('status', 'published')
            ->orderBy('is_pinned', 'desc')
            ->latest('tanggal_publikasi')
            ->take(9)
            ->get();

        $postsData = $publishedPosts->map(function ($p) {
            return [
                'id' => $p->id,
                'judul' => $p->judul,
                'kategori' => $p->kategori,
                'tanggal' => $p->tanggal_publikasi ? $p->tanggal_publikasi->translatedFormat('d F Y') : '-',
                'ringkasan' => $p->ringkasan,
                'konten' => $p->konten,
                'gambar_sampul' => $p->gambar_sampul ? asset('storage/'.$p->gambar_sampul) : null,
            ];
        })->values();

        // 2. Ambil data pengaturan beranda dan video profil dari CMS
        $settingsData = Setting::where('group', 'homepage')->pluck('value', 'key')->toArray();
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

        $settings = array_merge($defaultSettings, $settingsData);
        $videoEmbedUrl = Setting::getYoutubeEmbedUrl($settings['video_profile_url'] ?? null);

        // Kompatibilitas variabel
        $posts = $publishedPosts;
        $beritaList = $publishedPosts;
        $pengumumanList = collect();

        return view('welcome', compact(
            'posts',
            'beritaList',
            'pengumumanList',
            'publishedPosts',
            'postsData',
            'settings',
            'videoEmbedUrl'
        ));
    }
}
