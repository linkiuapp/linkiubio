<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ReleaseNote extends Model
{
    protected $fillable = [
        'version',
        'release_date',
        'is_current',
        'order',
        'is_active',
        'notify_tenants',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'notify_tenants' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function items(): HasMany
    {
        return $this->hasMany(ReleaseNoteItem::class, 'release_note_id')->orderBy('order');
    }

    // ==================== SCOPES ====================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'desc')->orderBy('release_date', 'desc');
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('is_current', true);
    }

    // ==================== MÉTODOS ====================

    /**
     * Marcar esta versión como actual y desmarcar las demás
     */
    public function markAsCurrent(): void
    {
        static::where('is_current', true)->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }

    /**
     * Obtener el label del tipo de item
     */
    public static function getItemTypeLabel(string $type): string
    {
        return match($type) {
            'new' => 'Nuevo',
            'fix' => 'Corrección',
            'improvement' => 'Mejora',
            'deprecated' => 'Deprecado',
            default => $type,
        };
    }
}
