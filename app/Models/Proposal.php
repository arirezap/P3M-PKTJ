<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_usulan',
        'jenis',
        'judul',
        'abstrak',
        'prodi_id',
        'user_id',
        'tahun_anggaran',
        'skema',
        'sumber_dana',
        'total_anggaran',
        'file_proposal',
        'file_revisi',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'total_anggaran' => 'decimal:2',
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
        return in_array($this->status, ['diterima', 'pelaksanaan']);
    }
}
