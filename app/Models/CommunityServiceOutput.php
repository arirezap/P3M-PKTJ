<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityServiceOutput extends Model
{
    use HasFactory;

    protected $table = 'community_service_outputs';

    protected $fillable = [
        'kategori',
        'judul',
        'community_service_id',
        'prodi_id',
        'user_id',
        'pelaksana',
        'tahun',
        'mitra_sasaran',
        'lokasi',
        'deskripsi_manfaat',
        'indikator_keberhasilan',
        'tingkat_kepuasan_mitra',
        'link_dokumen',
        'berkas_luaran',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function communityService(): BelongsTo
    {
        return $this->belongsTo(CommunityService::class);
    }
}
