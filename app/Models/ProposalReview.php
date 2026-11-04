<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'reviewer_id',
        'skor_urgensi',
        'skor_metodologi',
        'skor_kelayakan_rab',
        'skor_luaran',
        'detail_nilai',
        'total_skor',
        'catatan_reviewer',
        'file_catatan_revisi',
        'rekomendasi',
        'status_review',
        'disetujui_review_at',
        'batas_waktu_review',
        'persetujuan_komitmen',
        'konfirmasi_hasil',
        'tanggal_review',
    ];

    protected function casts(): array
    {
        return [
            'skor_urgensi' => 'decimal:2',
            'skor_metodologi' => 'decimal:2',
            'skor_kelayakan_rab' => 'decimal:2',
            'skor_luaran' => 'decimal:2',
            'total_skor' => 'decimal:2',
            'detail_nilai' => 'array',
            'persetujuan_komitmen' => 'boolean',
            'disetujui_review_at' => 'datetime',
            'batas_waktu_review' => 'date',
            'tanggal_review' => 'datetime',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
