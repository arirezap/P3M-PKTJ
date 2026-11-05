<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalMonev extends Model
{
    use HasFactory;

    protected $table = 'proposal_monevs';

    protected $fillable = [
        'proposal_id',
        'user_id',
        'capaian_penelitian',
        'publikasi_ilmiah',
        'pemakalah_ilmiah',
        'hki',
        'teknologi_tepat_guna',
        'produk_purwarupa',
        'buku_ajar',
        'kegiatan_terlaksana',
        'kesesuaian_waktu',
        'kesesuaian_metode',
        'kesesuaian_personalia',
        'kesesuaian_anggaran',
        'kesesuaian_sarpras',
        'kesesuaian_target',
        'file_bukti_luaran',
        'status_monev',
        'total_skor_monev',
        'catatan_reviewer',
        'konfirmasi_hasil',
        'tanggal_monev',
    ];

    protected function casts(): array
    {
        return [
            'total_skor_monev' => 'decimal:2',
            'tanggal_monev' => 'datetime',
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
