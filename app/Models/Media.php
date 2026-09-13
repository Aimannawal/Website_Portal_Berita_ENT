<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'order',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    // helper buat generate url publik dari storage
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
