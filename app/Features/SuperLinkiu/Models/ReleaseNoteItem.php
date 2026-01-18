<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReleaseNoteItem extends Model
{
    protected $fillable = [
        'release_note_id',
        'type',
        'description',
        'link',
        'notify_tenants',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
        'notify_tenants' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function releaseNote(): BelongsTo
    {
        return $this->belongsTo(ReleaseNote::class, 'release_note_id');
    }

    // ==================== ACCESSORS ====================

    public function getTypeLabelAttribute(): string
    {
        return ReleaseNote::getItemTypeLabel($this->type);
    }
}
