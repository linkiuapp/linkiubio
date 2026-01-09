<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubServiceType extends Model
{
    protected $table = 'sub_service_types';

    protected $fillable = [
        'name',
        'category',
        'description',
        'default_price',
        'currency',
        'period_prices',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
        'period_prices' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    const CATEGORY_DOMAIN = 'domain';
    const CATEGORY_HOSTING = 'hosting';
    const CATEGORY_EMAIL = 'email';
    const CATEGORY_SSL = 'ssl';
    const CATEGORY_OTHER = 'other';

    // ==================== RELACIONES ====================

    public function subscriptions(): HasMany
    {
        return $this->hasMany(SubSubscription::class, 'service_type_id');
    }

    // ==================== ACCESSORS ====================

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            self::CATEGORY_DOMAIN => 'Dominio',
            self::CATEGORY_HOSTING => 'Hosting',
            self::CATEGORY_EMAIL => 'Email',
            self::CATEGORY_SSL => 'SSL',
            self::CATEGORY_OTHER => 'Otro',
            default => $this->category ?? 'Sin categoría',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            self::CATEGORY_DOMAIN => 'globe',
            self::CATEGORY_HOSTING => 'server',
            self::CATEGORY_EMAIL => 'mail',
            self::CATEGORY_SSL => 'shield-check',
            default => 'box',
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->default_price, 0, ',', '.');
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, ?string $category)
    {
        if (!$category) return $query;
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ==================== MÉTODOS ====================

    public function getPriceForPeriod(string $period): ?float
    {
        $prices = $this->period_prices ?? [];
        return $prices[$period] ?? $this->default_price;
    }

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_DOMAIN => 'Dominio',
            self::CATEGORY_HOSTING => 'Hosting',
            self::CATEGORY_EMAIL => 'Email',
            self::CATEGORY_SSL => 'SSL',
            self::CATEGORY_OTHER => 'Otro',
        ];
    }
}
