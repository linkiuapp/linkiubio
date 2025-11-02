<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessFeature extends Model
{
    protected $fillable = [
        'key',
        'name',
        'area',
        'description',
        'is_default',
        'sort_order'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Relación: Features pertenecen a muchas categorías
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            BusinessCategory::class,
            'business_category_feature',
            'business_feature_id',
            'business_category_id'
        )->withTimestamps();
    }

    /**
     * Scope: Solo features por defecto (base para todas las categorías)
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope: Features por área
     */
    public function scopeByArea($query, string $area)
    {
        return $query->where('area', $area);
    }

    /**
     * Scope: Ordenados por sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}


