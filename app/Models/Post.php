<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'konten',
        'gambar_sampul',
        'user_id',
        'status',
        'tanggal_publikasi',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'date',
            'is_pinned' => 'boolean',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
