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
        'roles',
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
            'roles' => 'array',
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

    /**
     * Mendapatkan daftar peran pengguna yang dinormalisasi.
     *
     * @return array<string>
     */
    public function getRolesList(): array
    {
        $roles = is_array($this->roles) ? $this->roles : [];
        if (empty($roles) && !empty($this->role)) {
            $roles = [$this->role === 'dosen' ? 'peneliti' : $this->role];
        }

        // Normalisasi agar 'dosen' dan 'peneliti' seragam
        $normalized = array_map(function ($r) {
            return $r === 'dosen' ? 'peneliti' : $r;
        }, $roles);

        return array_values(array_unique($normalized));
    }

    /**
     * Memeriksa apakah pengguna memiliki peran tertentu.
     */
    public function hasRole(string $role): bool
    {
        $roleToCheck = ($role === 'dosen') ? 'peneliti' : strtolower($role);
        $userRoles = $this->getRolesList();

        if (in_array($roleToCheck, $userRoles, true)) {
            return true;
        }

        // Kompatibilitas mundur dengan kolom role tunggal
        if ($this->role === 'admin' && $roleToCheck === 'admin') return true;
        if ($this->role === 'reviewer' && $roleToCheck === 'reviewer') return true;
        if (($this->role === 'dosen' || $this->role === 'peneliti') && ($roleToCheck === 'peneliti' || $roleToCheck === 'dosen')) return true;

        return false;
    }

    /**
     * Memeriksa apakah pengguna memiliki setidaknya satu peran dari daftar peran yang diberikan.
     *
     * @param array<string> $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $r) {
            if ($this->hasRole($r)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Memeriksa apakah pengguna memiliki lebih dari satu peran aktif.
     */
    public function isMultiRole(): bool
    {
        return count($this->getRolesList()) > 1;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isDosen(): bool
    {
        return $this->hasRole('peneliti') || $this->hasRole('dosen');
    }

    public function isPeneliti(): bool
    {
        return $this->isDosen();
    }

    public function isReviewer(): bool
    {
        return $this->hasRole('reviewer');
    }
}
