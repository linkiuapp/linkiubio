<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Shared\Models\Store;

class Ticker extends Model
{
    protected $fillable = [
        'store_id',
        'text',
        'emoji',
        'is_active',
        'sort_order',
        'background_color',
        'text_color',
        'scroll_speed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Constantes para velocidad de desplazamiento
    const SCROLL_SPEED_SLOW = 'slow';
    const SCROLL_SPEED_MEDIUM = 'medium';
    const SCROLL_SPEED_FAST = 'fast';

    const SCROLL_SPEEDS = [
        self::SCROLL_SPEED_SLOW => 'Lento',
        self::SCROLL_SPEED_MEDIUM => 'Medio',
        self::SCROLL_SPEED_FAST => 'Rápido',
    ];

    /**
     * Get the store that owns the ticker.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Scope para obtener tickers activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para obtener tickers de una tienda
     */
    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Scope para ordenar por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}


