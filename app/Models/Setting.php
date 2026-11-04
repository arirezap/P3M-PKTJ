<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Mengambil nilai setting berdasarkan kunci.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Menyimpan atau memperbarui nilai setting.
     */
    public static function set(string $key, ?string $value, string $group = 'general'): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    /**
     * Mengubah URL YouTube berbagai format menjadi URL Embed YouTube Privacy-Enhanced.
     * Menggunakan parameter autoplay bisu (mute=1) secara bawaan agar video berputar visualnya tanpa distraksi audio.
     */
    public static function getYoutubeEmbedUrl(?string $url, bool $autoplayMuted = true): string
    {
        $queryParam = $autoplayMuted ? '?autoplay=1&mute=1&playsinline=1&rel=0' : '?rel=0';

        if (empty($url)) {
            return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ' . $queryParam;
        }

        $trimmed = trim($url);

        // Jika sudah berbentuk embed URL
        if (str_contains($trimmed, 'youtube-nocookie.com/embed/') || str_contains($trimmed, 'youtube.com/embed/')) {
            $parts = explode('?', $trimmed);
            return $parts[0] . $queryParam;
        }

        $videoId = null;

        // Format: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $trimmed, $matches)) {
            $videoId = $matches[1];
        } elseif (strlen($trimmed) === 11 && !str_contains($trimmed, '/')) {
            // Jika admin memasukkan langsung 11 karakter ID video
            $videoId = $trimmed;
        }

        if ($videoId) {
            return "https://www.youtube-nocookie.com/embed/{$videoId}" . $queryParam;
        }

        return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ' . $queryParam;
    }

    /**
     * Mengambil kumpulan pengaturan navigasi, header, dan footer lengkap dengan nilai bawaan.
     */
    public static function getNavigationSettings(): array
    {
        $defaults = [
            // Top Mini Bar
            'top_bar_kemenhub' => 'Kementerian Perhubungan Republik Indonesia',
            'top_bar_bpsdm' => 'BPSDM Perhubungan',
            'top_bar_campus_info' => 'Kampus PKTJ Tegal: Jl. Semeru No. 3',
            'top_bar_tagline' => 'Portal P3M PKTJ',

            // Brand Lembaga
            'brand_title' => 'P3M PKTJ',
            'brand_subtitle_1' => 'Pusat Penelitian & Pengabdian kepada Masyarakat',
            'brand_subtitle_2' => 'Politeknik Keselamatan Transportasi Jalan',

            // Menu Header
            'menu_beranda_label' => 'Beranda',
            'menu_profil_label' => 'Profil',
            'menu_riset_label' => 'Riset',
            'menu_pengabdian_label' => 'Pengabdian',
            'menu_layanan_label' => 'Layanan',
            'navbar_jurnal_label' => 'Jurnal',
            'navbar_jurnal_url' => 'https://ktj.pktj.ac.id/',
            'navbar_custom_link_label' => '',
            'navbar_custom_link_url' => '',
            'navbar_login_button' => 'Login SIM P3M',

            // Footer Profil & Kontak
            'footer_brand_title' => 'P3M PKTJ',
            'footer_brand_subtitle' => 'Politeknik Keselamatan Transportasi Jalan',
            'footer_about_text' => 'Lembaga pengelola penelitian vokasi keselamatan transportasi, publikasi ilmiah bereputasi, Hak Kekayaan Intelektual (HKI), dan pengabdian kepada masyarakat di bawah Badan Pengembangan SDM Perhubungan, Kementerian Perhubungan Republik Indonesia.',
            'footer_address' => 'Jl. Semeru No. 3, Tegal, Jawa Tengah 52125',
            'footer_email' => 'p3m@pktj.ac.id',
            'footer_phone' => '(0283) 351508 / 0812-3456-7890',
            'footer_nav_title' => 'Navigasi Utama',

            // Footer Tautan Terkait
            'footer_links_title' => 'Tautan Terkait',
            'footer_link_1_label' => 'Website PKTJ Tegal',
            'footer_link_1_url' => 'https://pktj.ac.id',
            'footer_link_2_label' => 'Kementerian Perhubungan RI',
            'footer_link_2_url' => 'https://dephub.go.id',
            'footer_link_3_label' => 'Jurnal Ilmiah PKTJ',
            'footer_link_3_url' => 'https://ktj.pktj.ac.id/',
            'footer_link_4_label' => 'SINTA Kemdiktisaintek',
            'footer_link_4_url' => 'https://sinta.kemdikbud.go.id',
            'footer_link_5_label' => '',
            'footer_link_5_url' => '',

            // Footer Copyright
            'footer_copyright_text' => '© ' . date('Y') . ' P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.',
            'footer_copyright_sub' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ Tegal',
        ];

        try {
            $saved = static::where('group', 'navigation')->pluck('value', 'key')->toArray();
            return array_merge($defaults, $saved);
        } catch (\Throwable $e) {
            return $defaults;
        }
    }
}
