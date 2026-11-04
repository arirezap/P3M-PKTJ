<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalFinalReport extends Model
{
    use HasFactory;

    protected $table = 'proposal_final_reports';

    protected $fillable = [
        'proposal_id',
        'user_id',
        'file_laporan_akhir',
        'file_revisi_laporan',
        'ringkasan_hasil',
        'perubahan_anggota',
        'total_realisasi_anggaran',
        'rincian_realisasi',
        'file_bukti_spj',
        'capaian_luaran',
        'status_laporan',
        'total_skor_laporan',
        'catatan_reviewer',
        'file_catatan_revisi',
        'konfirmasi_hasil',
        'tanggal_penyerahan',
    ];

    protected function casts(): array
    {
        return [
            'total_realisasi_anggaran' => 'decimal:2',
            'rincian_realisasi' => 'array',
            'capaian_luaran' => 'array',
            'total_skor_laporan' => 'decimal:2',
            'tanggal_penyerahan' => 'datetime',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

