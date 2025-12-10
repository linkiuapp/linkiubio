<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'subject',
        'content',
        'whatsapp_template',
        'banner_html',
        'banner_background_color',
        'banner_text_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Type constants
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_FEATURE = 'feature';
    const TYPE_PROMOTION = 'promotion';
    const TYPE_PAYMENT_REMINDER = 'payment_reminder';

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }
}

