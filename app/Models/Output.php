<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'judul',
        'prodi_id',
        'user_id',
        'author_inventor',
        'tahun',
        'nama_jurnal_penerbit',
        'nomor_registrasi_hki',
        'tingkat_kesiapan_terapan',
        'lisensi',
        'fase_roadmap',
        'deskripsi_kemanfaatan',
        'mitra_kerjasama',
        'sumber_dana',
        'realisasi_dana',
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
}
