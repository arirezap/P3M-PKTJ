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
        'penulis_korespondensi',
        'anggota_dosen',
        'anggota_taruna',
        'tahun',
        'nama_jurnal_penerbit',
        'indeksasi_nasional',
        'indeksasi_internasional',
        'kategori_kpi',
        'tanggal_publikasi',
        'status_publikasi',
        'nomor_registrasi_hki',
        'isbn',
        'tempat_terbit',
        'jumlah_halaman',
        'jenis_ciptaan',
        'pemegang_hki',
        'tanggal_permohonan',
        'tanggal_diumumkan',
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
