<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'user_id',
        'nama',
        'peran',
        'kategori_anggota',
        'asal_instansi',
        'negara',
        'nidn_nim',
        'tugas',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
