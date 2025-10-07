<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Models\Store;
use Illuminate\Support\Facades\Storage;

class StoreDesign extends Model
{
    protected $fillable = [
        'store_id',
        'logo_url',      // ✅ Ahora guarda path relativo, accessor convierte a URL
        'logo_webp_url', // ✅ Ahora guarda path relativo, accessor convierte a URL
        'favicon_url',   // ✅ Ahora guarda path relativo, accessor convierte a URL
        'header_background_color',
        'header_text_color',
        'header_description_color',
    ];

    protected $casts = [
        // 'is_published' => 'boolean', // REMOVIDO: Los cambios son inmediatos
    ];

    /**
     * Get the store that owns the design.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the design history records.
     */
    public function history()
    {
        return $this->hasMany(StoreDesignHistory::class);
    }

    /**
     * Get the background style for the header.
     */
    public function getBackgroundStyleAttribute()
    {
        return $this->header_background_color ?? '#FFFFFF';
    }

    /**
     * ✅ Accessor para logo_url - Convierte path relativo a URL completa (S3 o local)
     */
    public function getLogoUrlAttribute(): ?string
    {
        $path = $this->attributes['logo_url'] ?? null;
        
        if (empty($path)) {
            return null;
        }
        
        // Si ya es una URL completa (datos antiguos), devolverla tal cual
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        // Si es un path relativo, convertir a URL con Storage::url()
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            \Log::error('Error generando URL de logo de tienda', [
                'store_id' => $this->store_id,
                'logo_path' => $path,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * ✅ Accessor para logo_webp_url - Convierte path relativo a URL completa (S3 o local)
     */
    public function getLogoWebpUrlAttribute(): ?string
    {
        $path = $this->attributes['logo_webp_url'] ?? null;
        
        if (empty($path)) {
            return null;
        }
        
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            \Log::error('Error generando URL de logo WebP de tienda', [
                'store_id' => $this->store_id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * ✅ Accessor para favicon_url - Convierte path relativo a URL completa (S3 o local)
     */
    public function getFaviconUrlAttribute(): ?string
    {
        $path = $this->attributes['favicon_url'] ?? null;
        
        if (empty($path)) {
            return null;
        }
        
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            \Log::error('Error generando URL de favicon de tienda', [
                'store_id' => $this->store_id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
} 