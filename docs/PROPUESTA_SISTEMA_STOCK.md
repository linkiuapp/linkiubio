# 📦 Propuesta: Sistema de Gestión de Stock/Inventario - Linkiu

## 🔍 Análisis del Sistema Actual

### **Estado Actual:**
✅ **Existe campo:** `option_quantities` (JSON) en tabla `products`  
❌ **NO implementado:** Sistema completo de stock  
❌ **NO existe:** Stock para productos simples  
❌ **NO existe:** Gestión de inventario (altas/bajas)  
❌ **NO existe:** Alertas de stock bajo  
❌ **NO existe:** Validación de disponibilidad en checkout  

### **Estructura Actual de Productos:**

```
Product
├── type: 'simple' | 'variable'
├── price: decimal
├── sku: string (único)
├── option_quantities: JSON (sin uso activo)
└── Relaciones:
    ├── ProductVariableAssignment (variables asignadas)
    │   ├── ProductVariable (ej: Talla, Color)
    │   │   └── VariableOption[] (ej: S, M, L)
    │   └── selected_options: array (IDs de opciones habilitadas)
    └── ProductVariant (combinaciones específicas - no en uso)
```

---

## 🎯 Necesidad de Stock por Vertical

### **1. Ecommerce** 🛒
**¿Necesita stock?** ✅ **SÍ - CRÍTICO**

**Razones:**
- Venta de productos físicos
- Inventario real limitado
- Evitar sobreventa
- Control de existencias
- Reposición de productos

**Tipo de stock:**
- ✅ Stock simple (productos simples)
- ✅ Stock por variante (productos variables: talla M roja, talla L azul)
- ✅ Alertas de stock bajo
- ✅ Productos "agotados"
- ✅ Gestión de entradas/salidas

**Prioridad:** 🔴 **ALTA**

---

### **2. Restaurant** 🍽️
**¿Necesita stock?** ⚠️ **OPCIONAL - ÚTIL**

**Razones:**
- Platos del día con cantidad limitada
- Ingredientes disponibles
- Evitar ofrecer platos agotados
- Control de desperdicio

**Tipo de stock:**
- ✅ Stock simple por plato (cantidad diaria)
- ⚠️ Stock por variante (menos común)
- ❌ Gestión compleja de inventario
- ✅ Reset diario/semanal automático

**Prioridad:** 🟡 **MEDIA**

---

### **3. Hotel** 🏨
**¿Necesita stock?** ❌ **NO**

**Razones:**
- Las habitaciones se manejan con sistema de reservas (ya implementado)
- El room service usa productos del restaurante
- NO es inventario tradicional

**Tipo de stock:**
- ❌ NO aplica para habitaciones
- ⚠️ Podría usar stock de restaurant para room service

**Prioridad:** ⚪ **NO APLICA**

---

### **4. Dropshipping** 📦
**¿Necesita stock?** ⚠️ **DEPENDE**

**Razones:**
- El proveedor maneja el stock real
- Podría sincronizarse con API del proveedor
- Sin stock local físico

**Tipo de stock:**
- ⚠️ Stock sincronizado (futuro)
- ⚠️ Indicador "disponible en proveedor"
- ⚠️ Stock virtual (para limitar ventas)

**Prioridad:** 🟡 **MEDIA - FASE 2**

---

## 🏗️ Propuesta de Implementación

### **Fase 1: Stock Básico (Ecommerce)** 🎯

#### **1.1. Migración de Base de Datos**

```sql
-- Agregar campos de stock a tabla products
ALTER TABLE products ADD COLUMN stock_type ENUM('unlimited', 'limited') DEFAULT 'unlimited' AFTER type;
ALTER TABLE products ADD COLUMN stock_quantity INT UNSIGNED DEFAULT NULL AFTER stock_type;
ALTER TABLE products ADD COLUMN stock_alert_threshold INT UNSIGNED DEFAULT 5 AFTER stock_quantity;
ALTER TABLE products ADD COLUMN track_stock BOOLEAN DEFAULT FALSE AFTER stock_alert_threshold;

-- Crear tabla para stock por variante (productos variables)
CREATE TABLE product_variant_stock (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    variable_combination JSON NOT NULL COMMENT 'Combinación de variable_id y option_id',
    sku VARCHAR(255) UNIQUE NOT NULL,
    stock_quantity INT UNSIGNED DEFAULT 0,
    reserved_quantity INT UNSIGNED DEFAULT 0 COMMENT 'Cantidad reservada en carritos/pedidos pendientes',
    available_quantity INT GENERATED ALWAYS AS (stock_quantity - reserved_quantity) STORED,
    stock_alert_threshold INT UNSIGNED DEFAULT 5,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_active (product_id, is_active),
    INDEX idx_sku (sku),
    INDEX idx_available (available_quantity)
);

-- Crear tabla de movimientos de stock (auditoría)
CREATE TABLE stock_movements (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    variant_stock_id BIGINT UNSIGNED NULL COMMENT 'NULL para productos simples',
    type ENUM('entry', 'exit', 'adjustment', 'sale', 'return', 'reservation', 'release') NOT NULL,
    quantity INT NOT NULL COMMENT 'Positivo para entradas, negativo para salidas',
    quantity_before INT NOT NULL,
    quantity_after INT NOT NULL,
    reference_type VARCHAR(100) NULL COMMENT 'Order, Adjustment, etc.',
    reference_id BIGINT UNSIGNED NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NULL COMMENT 'Usuario que hizo el movimiento',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_stock_id) REFERENCES product_variant_stock(id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_variant (variant_stock_id),
    INDEX idx_type (type),
    INDEX idx_created_at (created_at)
);
```

#### **1.2. Modelos Eloquent**

**ProductVariantStock.php:**
```php
namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantStock extends Model
{
    protected $fillable = [
        'product_id',
        'variable_combination',
        'sku',
        'stock_quantity',
        'reserved_quantity',
        'stock_alert_threshold',
        'is_active',
    ];

    protected $casts = [
        'variable_combination' => 'array',
        'stock_quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'stock_alert_threshold' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['available_quantity', 'is_low_stock', 'is_out_of_stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'variant_stock_id');
    }

    // Accessors
    public function getAvailableQuantityAttribute()
    {
        return max(0, $this->stock_quantity - $this->reserved_quantity);
    }

    public function getIsLowStockAttribute()
    {
        return $this->available_quantity > 0 && $this->available_quantity <= $this->stock_alert_threshold;
    }

    public function getIsOutOfStockAttribute()
    {
        return $this->available_quantity <= 0;
    }

    // Métodos de negocio
    public function canReserve($quantity): bool
    {
        return $this->available_quantity >= $quantity;
    }

    public function reserve($quantity): bool
    {
        if (!$this->canReserve($quantity)) {
            return false;
        }
        
        $this->increment('reserved_quantity', $quantity);
        return true;
    }

    public function release($quantity): void
    {
        $this->decrement('reserved_quantity', min($quantity, $this->reserved_quantity));
    }

    public function decrementStock($quantity, $releaseReservation = true): void
    {
        if ($releaseReservation) {
            $this->release($quantity);
        }
        $this->decrement('stock_quantity', $quantity);
    }
}
```

**StockMovement.php:**
```php
namespace App\Features\TenantAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    const TYPE_ENTRY = 'entry';
    const TYPE_EXIT = 'exit';
    const TYPE_ADJUSTMENT = 'adjustment';
    const TYPE_SALE = 'sale';
    const TYPE_RETURN = 'return';
    const TYPE_RESERVATION = 'reservation';
    const TYPE_RELEASE = 'release';

    protected $fillable = [
        'product_id',
        'variant_stock_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantStock()
    {
        return $this->belongsTo(ProductVariantStock::class, 'variant_stock_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Shared\Models\User::class, 'created_by');
    }
}
```

**Actualizar Product.php:**
```php
// Agregar a Product model

protected $fillable = [
    // ... existentes
    'stock_type',
    'stock_quantity',
    'stock_alert_threshold',
    'track_stock',
];

protected $casts = [
    // ... existentes
    'track_stock' => 'boolean',
    'stock_quantity' => 'integer',
    'stock_alert_threshold' => 'integer',
];

// Relaciones
public function variantStocks()
{
    return $this->hasMany(ProductVariantStock::class);
}

public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}

// Métodos de stock
public function tracksStock(): bool
{
    return $this->track_stock;
}

public function hasUnlimitedStock(): bool
{
    return $this->stock_type === 'unlimited';
}

public function getAvailableStockAttribute()
{
    if ($this->hasUnlimitedStock()) {
        return PHP_INT_MAX;
    }
    
    if ($this->isSimple()) {
        return $this->stock_quantity ?? 0;
    }
    
    // Para productos variables, sumar stock de todas las variantes
    return $this->variantStocks()
        ->where('is_active', true)
        ->sum('available_quantity');
}

public function isInStock($quantity = 1): bool
{
    if ($this->hasUnlimitedStock()) {
        return true;
    }
    
    return $this->available_stock >= $quantity;
}

public function isLowStock(): bool
{
    if ($this->hasUnlimitedStock()) {
        return false;
    }
    
    $available = $this->available_stock;
    return $available > 0 && $available <= $this->stock_alert_threshold;
}

public function isOutOfStock(): bool
{
    if ($this->hasUnlimitedStock()) {
        return false;
    }
    
    return $this->available_stock <= 0;
}
```

#### **1.3. Servicio de Stock**

**StockService.php:**
```php
namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\ProductVariantStock;
use App\Features\TenantAdmin\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Verificar disponibilidad de producto
     */
    public function checkAvailability(Product $product, array $selectedOptions = [], int $quantity = 1): array
    {
        if (!$product->tracksStock() || $product->hasUnlimitedStock()) {
            return ['available' => true, 'quantity' => PHP_INT_MAX];
        }

        if ($product->isSimple()) {
            $available = $product->stock_quantity ?? 0;
            return [
                'available' => $available >= $quantity,
                'quantity' => $available,
            ];
        }

        // Producto variable
        $variantStock = $this->findVariantStock($product, $selectedOptions);
        if (!$variantStock) {
            return ['available' => false, 'quantity' => 0, 'error' => 'Variante no encontrada'];
        }

        return [
            'available' => $variantStock->available_quantity >= $quantity,
            'quantity' => $variantStock->available_quantity,
        ];
    }

    /**
     * Reservar stock (al agregar al carrito)
     */
    public function reserve(Product $product, array $selectedOptions = [], int $quantity = 1): bool
    {
        if (!$product->tracksStock() || $product->hasUnlimitedStock()) {
            return true;
        }

        return DB::transaction(function () use ($product, $selectedOptions, $quantity) {
            if ($product->isSimple()) {
                // Stock simple
                if ($product->stock_quantity < $quantity) {
                    return false;
                }
                
                $before = $product->stock_quantity;
                $product->increment('reserved_quantity', $quantity);
                
                $this->createMovement(
                    $product,
                    null,
                    StockMovement::TYPE_RESERVATION,
                    -$quantity,
                    $before,
                    $before // No cambia el stock, solo reserva
                );
                
                return true;
            }

            // Producto variable
            $variantStock = $this->findVariantStock($product, $selectedOptions);
            if (!$variantStock) {
                return false;
            }

            if (!$variantStock->reserve($quantity)) {
                return false;
            }

            $this->createMovement(
                $product,
                $variantStock,
                StockMovement::TYPE_RESERVATION,
                -$quantity,
                $variantStock->stock_quantity,
                $variantStock->stock_quantity
            );

            return true;
        });
    }

    /**
     * Liberar reserva (al eliminar del carrito o cancelar pedido)
     */
    public function releaseReservation(Product $product, array $selectedOptions = [], int $quantity = 1): void
    {
        if (!$product->tracksStock() || $product->hasUnlimitedStock()) {
            return;
        }

        DB::transaction(function () use ($product, $selectedOptions, $quantity) {
            if ($product->isSimple()) {
                $before = $product->stock_quantity;
                $product->decrement('reserved_quantity', min($quantity, $product->reserved_quantity ?? 0));
                
                $this->createMovement(
                    $product,
                    null,
                    StockMovement::TYPE_RELEASE,
                    $quantity,
                    $before,
                    $before
                );
                
                return;
            }

            $variantStock = $this->findVariantStock($product, $selectedOptions);
            if ($variantStock) {
                $before = $variantStock->stock_quantity;
                $variantStock->release($quantity);
                
                $this->createMovement(
                    $product,
                    $variantStock,
                    StockMovement::TYPE_RELEASE,
                    $quantity,
                    $before,
                    $before
                );
            }
        });
    }

    /**
     * Decrementar stock (al confirmar venta)
     */
    public function decrementStock(Product $product, array $selectedOptions = [], int $quantity = 1, $orderId = null): bool
    {
        if (!$product->tracksStock() || $product->hasUnlimitedStock()) {
            return true;
        }

        return DB::transaction(function () use ($product, $selectedOptions, $quantity, $orderId) {
            if ($product->isSimple()) {
                $before = $product->stock_quantity;
                $product->decrement('stock_quantity', $quantity);
                
                $this->createMovement(
                    $product,
                    null,
                    StockMovement::TYPE_SALE,
                    -$quantity,
                    $before,
                    $product->stock_quantity,
                    'Order',
                    $orderId
                );
                
                return true;
            }

            $variantStock = $this->findVariantStock($product, $selectedOptions);
            if (!$variantStock) {
                return false;
            }

            $before = $variantStock->stock_quantity;
            $variantStock->decrementStock($quantity, true);

            $this->createMovement(
                $product,
                $variantStock,
                StockMovement::TYPE_SALE,
                -$quantity,
                $before,
                $variantStock->stock_quantity,
                'Order',
                $orderId
            );

            return true;
        });
    }

    /**
     * Incrementar stock (entrada de inventario)
     */
    public function incrementStock(Product $product, array $selectedOptions = [], int $quantity, string $notes = null): void
    {
        DB::transaction(function () use ($product, $selectedOptions, $quantity, $notes) {
            if ($product->isSimple()) {
                $before = $product->stock_quantity;
                $product->increment('stock_quantity', $quantity);
                
                $this->createMovement(
                    $product,
                    null,
                    StockMovement::TYPE_ENTRY,
                    $quantity,
                    $before,
                    $product->stock_quantity,
                    null,
                    null,
                    $notes
                );
                
                return;
            }

            $variantStock = $this->findVariantStock($product, $selectedOptions);
            if ($variantStock) {
                $before = $variantStock->stock_quantity;
                $variantStock->increment('stock_quantity', $quantity);
                
                $this->createMovement(
                    $product,
                    $variantStock,
                    StockMovement::TYPE_ENTRY,
                    $quantity,
                    $before,
                    $variantStock->stock_quantity,
                    null,
                    null,
                    $notes
                );
            }
        });
    }

    /**
     * Buscar stock de variante específica
     */
    protected function findVariantStock(Product $product, array $selectedOptions): ?ProductVariantStock
    {
        return ProductVariantStock::where('product_id', $product->id)
            ->where('is_active', true)
            ->get()
            ->first(function ($stock) use ($selectedOptions) {
                return $this->matchesVariantCombination($stock->variable_combination, $selectedOptions);
            });
    }

    /**
     * Verificar si combinación de opciones coincide
     */
    protected function matchesVariantCombination(array $stored, array $selected): bool
    {
        foreach ($stored as $variableId => $optionId) {
            if (!isset($selected[$variableId]) || $selected[$variableId] != $optionId) {
                return false;
            }
        }
        return true;
    }

    /**
     * Crear movimiento de stock
     */
    protected function createMovement(
        Product $product,
        ?ProductVariantStock $variantStock,
        string $type,
        int $quantity,
        int $quantityBefore,
        int $quantityAfter,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null
    ): void {
        StockMovement::create([
            'product_id' => $product->id,
            'variant_stock_id' => $variantStock?->id,
            'type' => $type,
            'quantity' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Obtener productos con stock bajo
     */
    public function getLowStockProducts($storeId, $limit = 50)
    {
        return Product::where('store_id', $storeId)
            ->where('track_stock', true)
            ->where('stock_type', 'limited')
            ->where(function ($query) {
                $query->whereRaw('stock_quantity <= stock_alert_threshold')
                    ->where('stock_quantity', '>', 0);
            })
            ->with('mainImage')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtener productos agotados
     */
    public function getOutOfStockProducts($storeId, $limit = 50)
    {
        return Product::where('store_id', $storeId)
            ->where('track_stock', true)
            ->where('stock_type', 'limited')
            ->where('stock_quantity', '<=', 0)
            ->with('mainImage')
            ->limit($limit)
            ->get();
    }
}
```

---

### **Fase 2: UI y Funcionalidades** 🎨

#### **2.1. Vista de Productos - Admin**

**En `create.blade.php` y `edit.blade.php`:**

```html
<!-- Sección de Stock -->
<div x-data="{ trackStock: {{ $product->track_stock ? 'true' : 'false' }}, stockType: '{{ $product->stock_type ?? 'unlimited' }}' }">
    <div class="bg-brandWhite-50 rounded-lg p-6 border border-brandWhite-300">
        <h3 class="h3 text-brandNeutral-400 mb-4">📦 Gestión de Inventario</h3>
        
        <!-- Toggle: Controlar stock -->
        <div class="flex items-center gap-3 mb-4">
            <input 
                type="checkbox" 
                name="track_stock" 
                id="track_stock"
                x-model="trackStock"
                class="w-5 h-5 rounded border-gray-300"
            >
            <label for="track_stock" class="body-lg text-brandNeutral-400">
                Controlar inventario de este producto
            </label>
        </div>

        <!-- Opciones de stock (solo si track_stock está activo) -->
        <div x-show="trackStock" x-transition class="space-y-4 ml-8">
            <!-- Tipo de stock -->
            <div>
                <label class="body-lg font-semibold text-brandNeutral-400 mb-2 block">
                    Tipo de inventario
                </label>
                
                <div class="space-y-2">
                    <label class="flex items-center gap-2">
                        <input 
                            type="radio" 
                            name="stock_type" 
                            value="unlimited"
                            x-model="stockType"
                            class="w-4 h-4"
                        >
                        <span class="body-lg">Ilimitado (siempre disponible)</span>
                    </label>
                    
                    <label class="flex items-center gap-2">
                        <input 
                            type="radio" 
                            name="stock_type" 
                            value="limited"
                            x-model="stockType"
                            class="w-4 h-4"
                        >
                        <span class="body-lg">Limitado (controlar cantidad)</span>
                    </label>
                </div>
            </div>

            <!-- Campos de stock limitado -->
            <div x-show="stockType === 'limited'" x-transition class="space-y-4 pt-4 border-t">
                <!-- Cantidad en stock (solo para productos simples) -->
                @if($product->isSimple() || !$product->exists)
                <div>
                    <label for="stock_quantity" class="body-lg font-semibold text-brandNeutral-400 mb-2 block">
                        Cantidad en stock
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        id="stock_quantity"
                        value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-brandWhite-300 rounded-lg"
                        placeholder="0"
                    >
                </div>
                @endif

                <!-- Umbral de alerta -->
                <div>
                    <label for="stock_alert_threshold" class="body-lg font-semibold text-brandNeutral-400 mb-2 block">
                        Alerta de stock bajo
                    </label>
                    <input 
                        type="number" 
                        name="stock_alert_threshold" 
                        id="stock_alert_threshold"
                        value="{{ old('stock_alert_threshold', $product->stock_alert_threshold ?? 5) }}"
                        min="1"
                        class="w-full px-4 py-2 border border-brandWhite-300 rounded-lg"
                        placeholder="5"
                    >
                    <p class="caption text-brandNeutral-300 mt-1">
                        Recibirás una alerta cuando el stock llegue a esta cantidad
                    </p>
                </div>

                @if($product->exists && $product->isVariable())
                <div class="bg-brandInfo-50 border border-brandInfo-200 rounded-lg p-4">
                    <p class="body-lg text-brandInfo-400">
                        ℹ️ Este es un producto variable. Configura el stock individual para cada variante en la sección "Gestión de Variantes" más abajo.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
```

#### **2.2. Dashboard de Stock**

**Nueva vista:** `app/Features/TenantAdmin/Views/Inventory/dashboard.blade.php`

```html
<div class="space-y-6">
    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total productos -->
        <div class="bg-brandWhite-50 rounded-lg p-6 border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-brandNeutral-300">Total Productos</p>
                    <h3 class="h2 text-brandNeutral-400">{{ $stats['total'] }}</h3>
                </div>
                <i data-lucide="package" class="w-12 h-12 text-brandPrimary-300"></i>
            </div>
        </div>

        <!-- En stock -->
        <div class="bg-brandSuccess-50 rounded-lg p-6 border border-brandSuccess-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-brandSuccess-400">En Stock</p>
                    <h3 class="h2 text-brandSuccess-400">{{ $stats['in_stock'] }}</h3>
                </div>
                <i data-lucide="check-circle" class="w-12 h-12 text-brandSuccess-400"></i>
            </div>
        </div>

        <!-- Stock bajo -->
        <div class="bg-brandWarning-50 rounded-lg p-6 border border-brandWarning-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-brandWarning-400">Stock Bajo</p>
                    <h3 class="h2 text-brandWarning-400">{{ $stats['low_stock'] }}</h3>
                </div>
                <i data-lucide="alert-triangle" class="w-12 h-12 text-brandWarning-400"></i>
            </div>
        </div>

        <!-- Agotados -->
        <div class="bg-brandError-50 rounded-lg p-6 border border-brandError-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-brandError-400">Agotados</p>
                    <h3 class="h2 text-brandError-400">{{ $stats['out_of_stock'] }}</h3>
                </div>
                <i data-lucide="x-circle" class="w-12 h-12 text-brandError-400"></i>
            </div>
        </div>
    </div>

    <!-- Productos con stock bajo -->
    <div class="bg-brandWhite-50 rounded-lg p-6 border">
        <h3 class="h3 text-brandNeutral-400 mb-4">⚠️ Productos con Stock Bajo</h3>
        
        @if($lowStockProducts->isEmpty())
            <p class="body-lg text-brandNeutral-300">✅ No hay productos con stock bajo</p>
        @else
            <div class="space-y-3">
                @foreach($lowStockProducts as $product)
                <div class="flex items-center justify-between p-4 bg-brandWarning-50 rounded-lg border border-brandWarning-200">
                    <div class="flex items-center gap-4">
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded object-cover">
                        <div>
                            <h4 class="body-lg-bold text-brandNeutral-400">{{ $product->name }}</h4>
                            <p class="caption text-brandNeutral-300">SKU: {{ $product->sku }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="body-lg-bold text-brandWarning-400">{{ $product->stock_quantity }} unidades</p>
                        <a href="{{ route('tenant.admin.products.edit', ['store' => $store->slug, 'product' => $product->id]) }}" 
                           class="caption text-brandPrimary-300 hover:underline">
                            Actualizar stock →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
```

---

### **Fase 3: Integración con Checkout** 🛒

#### **3.1. Validación en Carrito**

**Actualizar `OrderController.php` → `addToCart`:**

```php
use App\Features\TenantAdmin\Services\StockService;

public function addToCart(Request $request, Store $store)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'selected_options' => 'nullable|array',
    ]);

    $product = Product::findOrFail($validated['product_id']);

    // ✅ VALIDAR STOCK
    $stockService = app(StockService::class);
    $availability = $stockService->checkAvailability(
        $product,
        $validated['selected_options'] ?? [],
        $validated['quantity']
    );

    if (!$availability['available']) {
        return response()->json([
            'success' => false,
            'message' => $availability['error'] ?? 'Producto sin stock suficiente',
            'available_quantity' => $availability['quantity'] ?? 0,
        ], 400);
    }

    // ✅ RESERVAR STOCK
    $reserved = $stockService->reserve(
        $product,
        $validated['selected_options'] ?? [],
        $validated['quantity']
    );

    if (!$reserved) {
        return response()->json([
            'success' => false,
            'message' => 'No se pudo reservar el stock. Intenta de nuevo.',
        ], 400);
    }

    // Agregar al carrito (código existente)
    // ...
}
```

#### **3.2. Liberar Stock al Eliminar del Carrito**

```php
public function removeFromCart(Request $request, Store $store)
{
    // ... código existente ...

    // ✅ LIBERAR RESERVA DE STOCK
    $stockService = app(StockService::class);
    $stockService->releaseReservation(
        $product,
        $cartItem['selected_options'] ?? [],
        $cartItem['quantity']
    );

    // Eliminar del carrito (código existente)
    // ...
}
```

#### **3.3. Confirmar Venta y Decrementar Stock**

```php
public function store(Request $request, Store $store)
{
    // ... validaciones y creación de orden ...

    DB::transaction(function () use ($order, $cart, $stockService) {
        foreach ($cart as $item) {
            // Crear OrderItem (código existente)
            // ...

            // ✅ DECREMENTAR STOCK
            $stockService->decrementStock(
                $item['product'],
                $item['selected_options'] ?? [],
                $item['quantity'],
                $order->id
            );
        }
    });

    // ...
}
```

---

## 📊 Resumen de Fases

### **FASE 1: Base de Stock (Semanas 1-2)** ✅
- ✅ Migraciones de base de datos
- ✅ Modelos Eloquent
- ✅ StockService básico
- ✅ Pruebas unitarias

### **FASE 2: UI y Gestión (Semanas 3-4)** 🎨
- 📝 Formularios de productos con stock
- 📊 Dashboard de inventario
- 📈 Reportes de stock
- 🔔 Alertas de stock bajo

### **FASE 3: Integración (Semana 5)** 🛒
- 🛒 Validación en carrito
- 💳 Integración con checkout
- 🔄 Reserva y liberación automática
- ✅ Pruebas E2E

### **FASE 4: Avanzado (Opcional - Futuro)** 🚀
- 📦 Importación/exportación de stock
- 📱 App móvil para inventario
- 🔄 Sincronización con proveedores (Dropshipping)
- 📊 Análisis predictivo de stock
- 🏪 Stock por sede/ubicación

---

## 🎯 Recomendación

### **Implementar AHORA:**
✅ Fase 1 + Fase 2 + Fase 3 para **Ecommerce**  
✅ Es crítico para evitar sobreventa  
✅ Mejora experiencia del usuario  

### **Implementar DESPUÉS:**
⏳ Stock para **Restaurant** (Fase 1 + Fase 2 simplificadas)  
⏳ Stock sincronizado para **Dropshipping** (requiere API de proveedores)  

### **NO Implementar:**
❌ Stock para **Hotel** (usa sistema de reservas)

---

**¿Procedemos con la implementación?** 🚀

