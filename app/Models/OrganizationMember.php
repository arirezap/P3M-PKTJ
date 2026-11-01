<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip_nidn',
        'jabatan',
        'urutan',
        'foto',
        'deskripsi_tugas',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Scope untuk mengambil hanya pengurus yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan nomor urut hierarki.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan', 'asc')->orderBy('id', 'asc');
    }
}
