<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'kategori_belanja',
        'uraian',
        'volume',
        'satuan',
        'harga_satuan',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'volume' => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'total_harga' => 'decimal:2',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
