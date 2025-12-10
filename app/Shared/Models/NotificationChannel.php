<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'channel',
        'enabled',
        'sent_at',
        'delivered_at',
        'metadata',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(PlatformAnnouncement::class);
    }
}

