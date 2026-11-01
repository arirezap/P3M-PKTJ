<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityService extends Model
{
    use HasFactory;

    protected $table = 'community_services';

    protected $fillable = [
        'judul',
        'ringkasan',
        'prodi_id',
        'ketua_pelaksana',
        'anggota',
        'tahun',
        'skema',
        'mitra',
        'lokasi_kegiatan',
        'sumber_dana',
        'anggaran',
        'berkas_laporan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'anggaran' => 'decimal:2',
        ];
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}
