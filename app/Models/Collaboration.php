<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mitra',
        'judul_kerjasama',
        'jenis_kegiatan',
        'kategori_mitra',
        'prodi_id',
        'nomor_mou_pks',
        'tahun',
        'status_kerjasama',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'file_dokumen',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori_mitra) {
            'pemerintah' => 'Instansi Pemerintah',
            'bumn' => 'BUMN / BUMD Transportasi',
            'industri' => 'Industri & Bengkel Mitra',
            'perguruan_tinggi' => 'Perguruan Tinggi',
            default => 'Komunitas & Desa Binaan',
        };
    }

    public function scopePenelitian(Builder $query): Builder
    {
        return $query->whereIn('jenis_kegiatan', ['penelitian', 'keduanya']);
    }

    public function scopePengabdian(Builder $query): Builder
    {
        return $query->whereIn('jenis_kegiatan', ['pengabdian', 'keduanya']);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['tahun'] ?? null, function ($q, $tahun) {
                if ($tahun !== 'all' && !empty($tahun)) {
                    $q->where('tahun', $tahun);
                }
            })
            ->when($filters['kategori'] ?? null, function ($q, $kategori) {
                if ($kategori !== 'all' && !empty($kategori)) {
                    $q->where('kategori_mitra', $kategori);
                }
            })
            ->when($filters['prodi'] ?? null, function ($q, $prodi) {
                if ($prodi !== 'all' && !empty($prodi)) {
                    $q->where('prodi_id', $prodi);
                }
            })
            ->when($filters['status'] ?? null, function ($q, $status) {
                if ($status !== 'all' && !empty($status)) {
                    $q->where('status_kerjasama', $status);
                }
            })
            ->when($filters['q'] ?? null, function ($q, $keyword) {
                $q->where(function ($sub) use ($keyword) {
                    $sub->where('nama_mitra', 'like', "%{$keyword}%")
                        ->orWhere('judul_kerjasama', 'like', "%{$keyword}%")
                        ->orWhere('nomor_mou_pks', 'like', "%{$keyword}%")
                        ->orWhere('deskripsi', 'like', "%{$keyword}%");
                });
            });
    }
}
