<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategoryIcon extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'display_name',
        'is_active',
        'is_global',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_global' => 'boolean',
    ];

    /**
     * Relación: Iconos pertenecen a múltiples categorías de negocio
     */
    public function businessCategories()
    {
        return $this->belongsToMany(
            BusinessCategory::class,
            'business_category_icon',
            'category_icon_id',
            'business_category_id'
        )
        ->withPivot('sort_order')
        ->withTimestamps()
        ->orderBy('business_category_icon.sort_order');
    }

    /**
     * Scope para obtener solo iconos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para obtener solo iconos globales
     */
    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    /**
     * Obtener la URL completa de la imagen
     * ✅ Follows ESTANDAR_IMAGENES.md - Compatible with Laravel Cloud
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        
        // ✅ Usar Storage::url() para compatibilidad con S3/Laravel Cloud
        // Agregar timestamp de updated_at para forzar recarga cuando se actualiza
        try {
            return Storage::disk('public')->url($this->image_path) . '?v=' . $this->updated_at->timestamp;
        } catch (\Exception $e) {
            \Log::error('Error generando URL de icono de categoría', [
                'icon_id' => $this->id,
                'image_path' => $this->image_path,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
} 