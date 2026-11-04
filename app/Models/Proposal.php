<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_usulan',
        'jenis',
        'judul',
        'abstrak',
        'kata_kunci',
        'bidang_fokus',
        'lama_kegiatan_tahun',
        'topik_kegiatan',
        'lokasi_kegiatan',
        'prodi_id',
        'user_id',
        'tahun_anggaran',
        'skema',
        'sumber_dana',
        'total_anggaran',
        'bank_nama',
        'bank_rekening',
        'bank_pemilik',
        'file_proposal',
        'file_revisi',
        'nama_mitra',
        'kontribusi_mitra',
        'dana_mitra',
        'dana_tambahan',
        'file_mitra',
        'nama_berkas_proposal',
        'luaran_target',
        'jadwal_kegiatan',
        'persetujuan_konfirmasi',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'total_anggaran' => 'decimal:2',
            'dana_mitra' => 'decimal:2',
            'dana_tambahan' => 'decimal:2',
            'luaran_target' => 'array',
            'jadwal_kegiatan' => 'array',
            'persetujuan_konfirmasi' => 'boolean',
        ];
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(ProposalMember::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(ProposalBudget::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProposalReview::class);
    }

    public function monev(): HasOne
    {
        return $this->hasOne(ProposalMonev::class);
    }

    public function finalReport(): HasOne
    {
        return $this->hasOne(ProposalFinalReport::class);
    }

    public function scopePenelitian($query)
    {
        return $query->where('jenis', 'penelitian');
    }

    public function scopePengabdian($query)
    {
        return $query->where('jenis', 'pengabdian');
    }

    public function isArchived(): bool
    {
        return $this->status === 'archive';
    }

    public function canBeArchived(): bool
    {
        return in_array($this->status, ['diterima', 'pelaksanaan', 'laporan_akhir']);
    }
}
