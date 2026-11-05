<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researches';

    protected $fillable = [
        'kode_penelitian',
        'judul',
        'abstrak',
        'prodi_id',
        'user_id',
        'ketua_peneliti',
        'anggota',
        'tahun',
        'skema',
        'sumber_dana',
        'anggaran',
        'berkas_laporan',
        'target_luaran',
        'status',
        'relevansi_prodi',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
