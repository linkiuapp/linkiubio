<?php

namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Shared\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'type',
        'sku',
        'main_image_id',
        'is_active',
        'allow_sharing',
        'store_id',
        'option_quantities',
        // Campos de stock
        'controla_stock',
        'tipo_stock',
        'cantidad_stock',
        'umbral_alerta_stock',
        // Campos de precio promocional
        'precio_promocional',
        'promocion_activa',
        'promocion_fecha_inicio',
        'promocion_fecha_fin',
        // Campos de producto bajo pedido
        'is_made_to_order',
        'preparation_days',
        'requires_deposit',
        'deposit_type',
        'deposit_value',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'allow_sharing' => 'boolean',
        'option_quantities' => 'array',
        // Casts de stock
        'controla_stock' => 'boolean',
        'cantidad_stock' => 'integer',
        'umbral_alerta_stock' => 'integer',
        // Casts de precio promocional
        'precio_promocional' => 'decimal:2',
        'promocion_activa' => 'boolean',
        'promocion_fecha_inicio' => 'date',
        'promocion_fecha_fin' => 'date',
        // Casts de bajo pedido
        'is_made_to_order' => 'boolean',
        'preparation_days' => 'integer',
        'requires_deposit' => 'boolean',
        'deposit_value' => 'decimal:2',
    ];

    /**
     * Atributos que siempre se incluyen en JSON
     */
    protected $appends = [
        'main_image_url',
        'image_url'  // Para retrocompatibilidad
    ];

    // Constantes para tipos de productos
    const TYPE_SIMPLE = 'simple';
    const TYPE_VARIABLE = 'variable';

    const TYPES = [
        self::TYPE_SIMPLE => 'Producto Simple',
        self::TYPE_VARIABLE => 'Producto Variable',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generar slug y SKU al crear
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name, $product->store_id);
            }
            
            if (empty($product->sku)) {
                $product->sku = static::generateUniqueSku($product->store_id);
            }
        });

        // Regenerar slug si cambia el nombre
        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->store_id, $product->id);
            }
        });
    }

    /**
     * Relación con la tienda
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relación con las imágenes
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Relación con la imagen principal
     */
    public function mainImage(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'main_image_id');
    }

    /**
     * Relación con las categorías (muchos a muchos)
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Features\TenantAdmin\Models\Category::class,
            'product_categories',
            'product_id',
            'category_id'
        )->withTimestamps();
    }

    /**
     * Relación con las variantes
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relación con las variantes activas
     */
    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    /**
     * Relación con las asignaciones de variables
     */
    public function variableAssignments(): HasMany
    {
        return $this->hasMany(ProductVariableAssignment::class)->orderBy('display_order');
    }

    /**
     * Variables activas del producto (sistema manual)
     */
    public function variables()
    {
        return $this->belongsToMany(ProductVariable::class, 'product_variable', 'product_id', 'variable_id')
            ->wherePivot('is_active', true)
            ->withPivot('is_active', 'custom_label')
            ->orderBy('name');
    }

    /**
     * Relación con las variables asignadas (con datos de la asignación)
     */
    public function assignedVariables()
    {
        return $this->hasManyThrough(
            ProductVariable::class,
            ProductVariableAssignment::class,
            'product_id',
            'id',
            'id',
            'variable_id'
        )->with('activeOptions');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSimple($query)
    {
        return $query->where('type', self::TYPE_SIMPLE);
    }

    public function scopeVariable($query)
    {
        return $query->where('type', self::TYPE_VARIABLE);
    }

    public function scopeByStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Métodos de ayuda
     */
    public function isSimple(): bool
    {
        return $this->type === self::TYPE_SIMPLE;
    }

    public function isVariable(): bool
    {
        return $this->type === self::TYPE_VARIABLE;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Obtener el precio formateado
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Verificar si la promoción está vigente
     */
    public function tienePromocionActiva(): bool
    {
        if (!$this->promocion_activa || !$this->precio_promocional) {
            return false;
        }

        $hoy = now()->startOfDay();

        // Si hay fecha de inicio, verificar que ya pasó
        if ($this->promocion_fecha_inicio && $hoy->lt($this->promocion_fecha_inicio)) {
            return false;
        }

        // Si hay fecha de fin, verificar que no ha pasado
        if ($this->promocion_fecha_fin && $hoy->gt($this->promocion_fecha_fin)) {
            return false;
        }

        return true;
    }

    /**
     * Obtener el precio final (promocional si aplica, normal si no)
     */
    public function getPrecioFinalAttribute(): float
    {
        if ($this->tienePromocionActiva()) {
            return (float) $this->precio_promocional;
        }
        return (float) $this->price;
    }

    /**
     * Obtener el precio final formateado
     */
    public function getFormattedPrecioFinalAttribute(): string
    {
        return '$' . number_format($this->precio_final, 0, ',', '.');
    }

    /**
     * Obtener porcentaje de descuento
     */
    public function getPorcentajeDescuentoAttribute(): int
    {
        if (!$this->tienePromocionActiva() || $this->price <= 0) {
            return 0;
        }
        return (int) round((($this->price - $this->precio_promocional) / $this->price) * 100);
    }

    /**
     * Obtener URL del producto
     */
    public function getUrlAttribute(): string
    {
        return route('tenant.admin.products.show', [
            'store' => $this->store->slug,
            'product' => $this->id
        ]);
    }

    /**
     * Obtener imagen principal o placeholder
     */
    public function getMainImageUrlAttribute(): string
    {
        // Prioridad 1: Imagen principal configurada
        if ($this->mainImage && $this->mainImage->image_path) {
            return Storage::disk('public')->url($this->mainImage->image_path);
        }
        
        // Prioridad 2: Primera imagen disponible (usar relación eager-loaded si está disponible)
        $firstImage = $this->relationLoaded('images') 
            ? $this->images->first() 
            : $this->images()->first();
        if ($firstImage && $firstImage->image_path) {
            return Storage::disk('public')->url($firstImage->image_path);
        }
        
        return asset('assets/images/placeholder-product.svg');
    }

    /**
     * Obtener thumbnail de imagen principal
     */
    public function getMainImageThumbnailAttribute(): string
    {
        // Prioridad 1: Thumbnail de imagen principal configurada
        if ($this->mainImage && $this->mainImage->thumbnail_path) {
            return Storage::disk('public')->url($this->mainImage->thumbnail_path);
        }
        
        // Prioridad 2: Thumbnail de primera imagen disponible (usar relación eager-loaded si está disponible)
        $firstImage = $this->relationLoaded('images') 
            ? $this->images->first() 
            : $this->images()->first();
        if ($firstImage && $firstImage->thumbnail_path) {
            return Storage::disk('public')->url($firstImage->thumbnail_path);
        }
        
        // Prioridad 3: Imagen original si no hay thumbnail
        if ($firstImage && $firstImage->image_path) {
            return Storage::disk('public')->url($firstImage->image_path);
        }
        
        return asset('assets/images/placeholder-product.svg');
    }

    /**
     * Alias para retrocompatibilidad con frontend
     */
    public function getImageUrlAttribute(): string
    {
        return $this->getMainImageUrlAttribute();
    }

    /**
     * Generar slug único
     */
    public static function generateUniqueSlug(string $name, int $storeId, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('store_id', $storeId)->where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            
            $query = static::where('store_id', $storeId)->where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Generar SKU único
     */
    public static function generateUniqueSku(int $storeId): string
    {
        $store = Store::find($storeId);
        $storePrefix = strtoupper(substr($store->slug, 0, 3));
        
        do {
            $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $sku = $storePrefix . '-' . $randomNumber;
        } while (static::where('sku', $sku)->exists());

        return $sku;
    }

    /**
     * Duplicar producto
     */
    public function duplicate(): static
    {
        $newProduct = $this->replicate();
        $newProduct->name = $this->name . ' - Copia';
        $newProduct->slug = null; // Se generará automáticamente
        $newProduct->sku = null; // Se generará automáticamente
        $newProduct->main_image_id = null; // Se asignará después
        $newProduct->save();

        // Duplicar relaciones con categorías
        $newProduct->categories()->attach($this->categories->pluck('id'));

        // Duplicar imágenes (solo referencias)
        $imageMapping = [];
        foreach ($this->images as $image) {
            $newImage = $image->replicate();
            $newImage->product_id = $newProduct->id;
            $newImage->save();
            
            $imageMapping[$image->id] = $newImage->id;
        }

        // Asignar imagen principal si existe
        if ($this->main_image_id && isset($imageMapping[$this->main_image_id])) {
            $newProduct->main_image_id = $imageMapping[$this->main_image_id];
            $newProduct->save();
        }

        // Duplicar variantes si es producto variable
        if ($this->isVariable()) {
            foreach ($this->variants as $variant) {
                $newVariant = $variant->replicate();
                $newVariant->product_id = $newProduct->id;
                $newVariant->sku = null; // Se generará automáticamente en ProductVariant
                $newVariant->save();
            }
        }

        return $newProduct;
    }

    /**
     * ========================================
     * RELACIONES Y MÉTODOS DE STOCK
     * ========================================
     */

    /**
     * Relación con movimientos de stock
     */
    public function movimientosStock()
    {
        return $this->hasMany(MovimientoStock::class, 'product_id');
    }

    /**
     * ¿Controla inventario?
     */
    public function controlaStock(): bool
    {
        return $this->controla_stock === true;
    }

    /**
     * ¿Tiene stock ilimitado?
     */
    public function tieneStockIlimitado(): bool
    {
        return $this->tipo_stock === 'ilimitado';
    }

    /**
     * Obtener stock disponible
     */
    public function getStockDisponibleAttribute(): int
    {
        // Sin control de stock = ilimitado
        if (!$this->controlaStock()) {
            return PHP_INT_MAX;
        }

        // Stock ilimitado
        if ($this->tieneStockIlimitado()) {
            return PHP_INT_MAX;
        }

        // Producto simple
        if ($this->isSimple()) {
            return $this->cantidad_stock ?? 0;
        }

        // Producto variable: sumar stock de todas las variantes activas
        return $this->variants()
            ->where('is_active', true)
            ->sum('stock');
    }

    /**
     * ¿Tiene stock disponible?
     */
    public function tieneStock(int $cantidad = 1): bool
    {
        return $this->stock_disponible >= $cantidad;
    }

    /**
     * ¿Está agotado?
     */
    public function estaAgotado(): bool
    {
        return $this->stock_disponible <= 0;
    }

    /**
     * ¿Tiene stock bajo?
     */
    public function tieneStockBajo(): bool
    {
        if (!$this->controlaStock() || $this->tieneStockIlimitado()) {
            return false;
        }

        $disponible = $this->stock_disponible;
        return $disponible > 0 && $disponible <= $this->umbral_alerta_stock;
    }

    /**
     * ========================================
     * MÉTODOS DE PRODUCTO BAJO PEDIDO
     * ========================================
     */

    /**
     * ¿Es producto bajo pedido?
     */
    public function isMadeToOrder(): bool
    {
        return $this->is_made_to_order === true;
    }

    /**
     * Scope para productos bajo pedido
     */
    public function scopeMadeToOrder($query)
    {
        return $query->where('is_made_to_order', true);
    }

    /**
     * Obtener días de preparación
     */
    public function getPreparationDaysLabel(): string
    {
        if (!$this->is_made_to_order || !$this->preparation_days) {
            return '';
        }

        $days = $this->preparation_days;
        return $days === 1 ? '1 día' : "{$days} días";
    }

    /**
     * ¿Requiere anticipo/depósito?
     */
    public function requiresDeposit(): bool
    {
        return $this->is_made_to_order && $this->requires_deposit === true;
    }

    /**
     * Calcular monto del anticipo para un precio dado
     */
    public function calculateDeposit(float $price): float
    {
        if (!$this->requiresDeposit()) {
            return 0;
        }

        if ($this->deposit_type === 'percentage') {
            return round(($price * $this->deposit_value) / 100, 2);
        }

        // Tipo fijo
        return min($this->deposit_value, $price); // No puede ser mayor al precio
    }

    /**
     * Obtener monto del anticipo basado en el precio del producto
     */
    public function getDepositAmountAttribute(): float
    {
        return $this->calculateDeposit($this->precio_final);
    }

    /**
     * Obtener monto del anticipo formateado
     */
    public function getFormattedDepositAmountAttribute(): string
    {
        return '$' . number_format($this->deposit_amount, 0, ',', '.');
    }

    /**
     * Obtener descripción del anticipo
     */
    public function getDepositDescriptionAttribute(): string
    {
        if (!$this->requiresDeposit()) {
            return '';
        }

        if ($this->deposit_type === 'percentage') {
            return "Anticipo del {$this->deposit_value}%";
        }

        return "Anticipo de " . $this->formatted_deposit_amount;
    }

    /**
     * Calcular monto restante después del anticipo
     */
    public function calculateRemainingAmount(float $price): float
    {
        return $price - $this->calculateDeposit($price);
    }

    /**
     * ¿Producto disponible para compra?
     * Los productos bajo pedido siempre están disponibles (no dependen de stock)
     */
    public function isAvailable(int $quantity = 1): bool
    {
        // Si es bajo pedido, siempre disponible
        if ($this->isMadeToOrder()) {
            return $this->is_active;
        }

        // Producto normal, verificar stock
        return $this->is_active && $this->tieneStock($quantity);
    }

    /**
     * Obtener información completa de bajo pedido para mostrar en frontend
     */
    public function getMadeToOrderInfoAttribute(): ?array
    {
        if (!$this->isMadeToOrder()) {
            return null;
        }

        return [
            'is_made_to_order' => true,
            'preparation_days' => $this->preparation_days,
            'preparation_label' => $this->getPreparationDaysLabel(),
            'requires_deposit' => $this->requiresDeposit(),
            'deposit_type' => $this->deposit_type,
            'deposit_value' => $this->deposit_value,
            'deposit_amount' => $this->deposit_amount,
            'deposit_description' => $this->deposit_description,
        ];
    }
}
