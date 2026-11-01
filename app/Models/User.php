<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nidn_nip',
        'prodi_id',
        'no_telp',
        'avatar',
        'sinta_id',
        'google_scholar',
        'scopus_id',
        'keahlian',
        'status_aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status_aktif' => 'boolean',
        ];
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function researches(): HasMany
    {
        return $this->hasMany(Research::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(Output::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProposalReview::class, 'reviewer_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    public function isReviewer(): bool
    {
        return $this->role === 'reviewer';
    }
}
