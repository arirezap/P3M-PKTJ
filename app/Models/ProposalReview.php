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
        'total_skor',
        'catatan_reviewer',
        'rekomendasi',
        'status_review',
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
