<?php

namespace App\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BusinessCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
        'requires_manual_approval',
        'order',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_manual_approval' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generar slug al crear
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Actualizar slug si cambia el nombre
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Relación con tiendas
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'business_category_id');
    }

    /**
     * Relación: Categorías tienen múltiples iconos
     */
    public function icons()
    {
        return $this->belongsToMany(
            CategoryIcon::class,
            'business_category_icon',
            'business_category_id',
            'category_icon_id'
        )
        ->withPivot('sort_order')
        ->withTimestamps()
        ->orderBy('business_category_icon.sort_order');
    }

    /**
     * Relación con el usuario que creó la categoría
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Solo categorías activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Categorías con auto-aprobación
     */
    public function scopeAutoApprove($query)
    {
        return $query->where('requires_manual_approval', false);
    }

    /**
     * Scope: Categorías que requieren revisión manual
     */
    public function scopeManualReview($query)
    {
        return $query->where('requires_manual_approval', true);
    }

    /**
     * Scope: Ordenadas por orden de visualización
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Verificar si esta categoría permite auto-aprobación
     */
    public function allowsAutoApproval(): bool
    {
        return $this->is_active && !$this->requires_manual_approval;
    }

    /**
     * Obtener contador de tiendas por estado
     */
    public function getStoresCountByStatus(string $status): int
    {
        return $this->stores()->where('approval_status', $status)->count();
    }
}

