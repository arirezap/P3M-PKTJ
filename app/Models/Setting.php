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
     */
    public static function getYoutubeEmbedUrl(?string $url): string
    {
        if (empty($url)) {
            return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ?rel=0';
        }

        $trimmed = trim($url);

        // Jika sudah berbentuk embed URL
        if (str_contains($trimmed, 'youtube-nocookie.com/embed/') || str_contains($trimmed, 'youtube.com/embed/')) {
            $parts = explode('?', $trimmed);
            return $parts[0] . '?rel=0';
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
            return "https://www.youtube-nocookie.com/embed/{$videoId}?rel=0";
        }

        return 'https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ?rel=0';
    }
}
