<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'category_id', 'created_by', 'title', 'slug',
        'excerpt', 'content', 'thumbnail', 'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // multi user penulis lewat pivot penulis_berita
    public function penulis(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'penulis_berita', 'berita_id', 'user_id')
            ->withPivot('role_in_content')
            ->withTimestamps();
    }

    // multi image lewat polymorphic media
    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('order');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'berita_id');
    }

    // filter kategori & status (dipakai di query publik)
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeCategory($query, string $slug)
    {
        return $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
    }
}
