<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'assigned_by', 'assigned_to_division',
        'assigned_to_user', 'berita_id', 'artikel_id', 'status', 'deadline', 'notes',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'assigned_to_division');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user');
    }

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }

    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }
}
