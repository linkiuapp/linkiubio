# 📦 Sistema de Gestión de Stock para Ecommerce - Linkiu

> **Vertical:** Ecommerce 🛒  
> **Prioridad:** 🔴 Crítica  
> **Objetivo:** Controlar inventario real y evitar sobreventa

---

## 📋 Índice

1. [Análisis del Sistema Actual](#análisis-del-sistema-actual)
2. [Casos de Uso](#casos-de-uso)
3. [Diseño de Base de Datos](#diseño-de-base-de-datos)
4. [Lógica de Negocio](#lógica-de-negocio)
5. [UX: Productos Agotados](#ux-productos-agotados)
6. [Interfaz de Usuario](#interfaz-de-usuario)
7. [Plan de Implementación](#plan-de-implementación)

---

## 🔍 Análisis del Sistema Actual

### **Estructura de Productos:**

```
Product (Tabla principal)
├── type: 'simple' | 'variable'
├── price: decimal
├── sku: string (único)
└── option_quantities: JSON ⚠️ (existe pero NO se usa)

ProductVariableAssignment (Variables asignadas)
├── product_id
├── variable_id (ej: Talla, Color)
├── selected_options: array [1, 2, 3] (IDs de opciones habilitadas)
└── is_required: boolean

ProductVariable (Variables globales)
├── name: string (ej: "Talla")
├── type: 'radio' | 'checkbox'
└── store_id

VariableOption (Opciones de cada variable)
├── variable_id
├── name: string (ej: "M", "L", "XL")
├── price_modifier: decimal (ej: +5000)
└── is_active: boolean
```

### **Problema Actual:**
❌ No hay control de stock  
❌ Se puede vender sin límite  
❌ No hay cantidades por variante  
❌ Campo `option_quantities` existe pero no se usa  

---

## 🎯 Casos de Uso

### **Caso 1: Producto Simple**
**Ejemplo:** "Gorra Nike Negra"
- ✅ 1 SKU
- ✅ 1 precio
- ✅ **1 cantidad de stock** (ej: 50 unidades)

```
Producto: Gorra Nike Negra
├── SKU: GOR-001
├── Precio: $45.000
└── Stock: 50 unidades
```

---

### **Caso 2: Producto Variable (1 Variable)**
**Ejemplo:** "Camiseta Básica" con variable **Talla**

```
Producto: Camiseta Básica
├── SKU: CAM-001
├── Precio base: $30.000
└── Variables asignadas:
    └── Talla (Selección única - Radio)
        ├── S  → Stock: 20 unidades | SKU: CAM-001-S
        ├── M  → Stock: 35 unidades | SKU: CAM-001-M
        ├── L  → Stock: 15 unidades | SKU: CAM-001-L
        └── XL → Stock: 0 unidades  | SKU: CAM-001-XL (AGOTADO)
```

**UX:** 
- ✅ Cliente puede seleccionar S, M, L (disponibles)
- ⚠️ XL aparece pero **deshabilitado** con badge "Agotado"
- 📊 Total disponible: 70 unidades (suma de todas las variantes)

---

### **Caso 3: Producto Variable (2 Variables)**
**Ejemplo:** "Zapatos Deportivos" con **Talla** y **Color**

```
Producto: Zapatos Deportivos
├── SKU: ZAP-001
├── Precio base: $120.000
└── Variables asignadas:
    ├── Talla (Selección única)
    │   ├── 38
    │   ├── 39
    │   ├── 40
    │   └── 41
    └── Color (Selección única)
        ├── Negro (+$0)
        ├── Blanco (+$0)
        └── Rojo (+$10.000)
```

**Combinaciones (16 total):**
```
Talla 38 + Negro  → Stock: 5  | SKU: ZAP-001-38-NEG
Talla 38 + Blanco → Stock: 8  | SKU: ZAP-001-38-BLA
Talla 38 + Rojo   → Stock: 0  | SKU: ZAP-001-38-ROJ (AGOTADO)
Talla 39 + Negro  → Stock: 12 | SKU: ZAP-001-39-NEG
Talla 39 + Blanco → Stock: 10 | SKU: ZAP-001-39-BLA
Talla 39 + Rojo   → Stock: 3  | SKU: ZAP-001-39-ROJ
... (y así sucesivamente)
```

**UX Dinámica:**
1. Cliente selecciona **Talla 38**
2. Sistema muestra colores:
   - ✅ Negro (disponible)
   - ✅ Blanco (disponible)
   - ⚠️ Rojo (deshabilitado - "Agotado en esta talla")
3. Cliente selecciona **Negro**
4. Sistema valida: "5 unidades disponibles"

---

## 🗄️ Diseño de Base de Datos

### **1. Actualizar Tabla `products`**

```sql
ALTER TABLE products 
ADD COLUMN track_stock BOOLEAN DEFAULT FALSE COMMENT 'Si controla inventario' AFTER type,
ADD COLUMN stock_type ENUM('unlimited', 'limited') DEFAULT 'unlimited' AFTER track_stock,
ADD COLUMN stock_quantity INT UNSIGNED NULL DEFAULT NULL COMMENT 'Stock para productos SIMPLES' AFTER stock_type,
ADD COLUMN stock_alert_threshold INT UNSIGNED DEFAULT 5 COMMENT 'Umbral de alerta' AFTER stock_quantity,
ADD COLUMN low_stock_notified_at TIMESTAMP NULL COMMENT 'Última vez que se notificó stock bajo' AFTER stock_alert_threshold;

-- Índices para optimización
CREATE INDEX idx_products_stock_tracking ON products(store_id, track_stock, stock_type);
CREATE INDEX idx_products_low_stock ON products(store_id, track_stock, stock_quantity, stock_alert_threshold);
```

**Campos explicados:**
- `track_stock`: TRUE = controla stock, FALSE = sin control
- `stock_type`: 'unlimited' = ilimitado, 'limited' = cantidad limitada
- `stock_quantity`: **SOLO para productos SIMPLES**
- `stock_alert_threshold`: Cuando stock ≤ este valor, se alerta
- `low_stock_notified_at`: Para no spamear notificaciones

---

### **2. Nueva Tabla: `product_variant_stocks`**
**Stock individual para cada combinación de opciones**

```sql
CREATE TABLE product_variant_stocks (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    
    -- Combinación de opciones (JSON)
    -- Ejemplo: {"1": 5, "2": 8} donde 1=variable_id, 5=option_id
    variable_combination JSON NOT NULL COMMENT 'Combinación de variable_id => option_id',
    
    -- SKU único para esta variante
    sku VARCHAR(255) UNIQUE NOT NULL,
    
    -- Cantidades
    stock_quantity INT UNSIGNED DEFAULT 0 COMMENT 'Stock real en bodega',
    reserved_quantity INT UNSIGNED DEFAULT 0 COMMENT 'Cantidad en carritos (reservada)',
    
    -- Stock disponible (calculado automáticamente)
    available_quantity INT GENERATED ALWAYS AS (
        CASE 
            WHEN stock_quantity > reserved_quantity 
            THEN stock_quantity - reserved_quantity 
            ELSE 0 
        END
    ) STORED COMMENT 'Stock real - reservado',
    
    -- Configuración
    stock_alert_threshold INT UNSIGNED DEFAULT 5,
    is_active BOOLEAN DEFAULT TRUE,
    low_stock_notified_at TIMESTAMP NULL,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Relaciones
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    
    -- Índices
    INDEX idx_product_active (product_id, is_active),
    INDEX idx_sku (sku),
    INDEX idx_available (product_id, available_quantity),
    INDEX idx_low_stock (product_id, available_quantity, stock_alert_threshold)
);
```

**Ejemplo de datos:**
```json
// Producto: Zapatos Deportivos (ID: 15)
// Variable Talla (ID: 1) -> Opción 38 (ID: 5)
// Variable Color (ID: 2) -> Opción Negro (ID: 8)

{
  "product_id": 15,
  "variable_combination": {"1": 5, "2": 8},
  "sku": "ZAP-001-38-NEG",
  "stock_quantity": 10,
  "reserved_quantity": 2,  // 2 personas tienen esto en su carrito
  "available_quantity": 8  // Solo 8 disponibles para vender
}
```

---

### **3. Nueva Tabla: `stock_movements`**
**Historial completo de movimientos (auditoría)**

```sql
CREATE TABLE stock_movements (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    variant_stock_id BIGINT UNSIGNED NULL COMMENT 'NULL = producto simple, NOT NULL = variante',
    
    -- Tipo de movimiento
    type ENUM(
        'entry',        -- Entrada de inventario (compra, devolución proveedor)
        'exit',         -- Salida manual (daño, robo, regalo)
        'adjustment',   -- Ajuste de inventario (corrección)
        'sale',         -- Venta confirmada
        'return',       -- Devolución de cliente
        'reservation',  -- Reserva en carrito
        'release'       -- Liberar reserva (eliminar del carrito)
    ) NOT NULL,
    
    -- Cantidades
    quantity INT NOT NULL COMMENT 'Positivo = entrada, Negativo = salida',
    quantity_before INT NOT NULL,
    quantity_after INT NOT NULL,
    
    -- Referencias
    reference_type VARCHAR(100) NULL COMMENT 'Order, Adjustment, Manual, etc.',
    reference_id BIGINT UNSIGNED NULL COMMENT 'ID de la orden, ajuste, etc.',
    notes TEXT NULL,
    
    -- Auditoría
    created_by BIGINT UNSIGNED NULL COMMENT 'Usuario que hizo el movimiento',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Relaciones
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_stock_id) REFERENCES product_variant_stocks(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    
    -- Índices
    INDEX idx_product (product_id),
    INDEX idx_variant (variant_stock_id),
    INDEX idx_type (type),
    INDEX idx_reference (reference_type, reference_id),
    INDEX idx_created_at (created_at)
);
```

**Ejemplo de movimientos:**
```
ID | Producto | Variante | Tipo        | Cantidad | Antes | Después | Referencia
---|----------|----------|-------------|----------|-------|---------|------------
1  | 15       | 42       | entry       | +50      | 0     | 50      | Manual (compra inicial)
2  | 15       | 42       | reservation | -2       | 50    | 50      | Cart (reserva)
3  | 15       | 42       | sale        | -2       | 50    | 48      | Order #123
4  | 15       | 42       | release     | -1       | 48    | 48      | Cart (canceló compra)
5  | 15       | 42       | return      | +1       | 48    | 49      | Order #123 (devolución)
```

---

## 🧠 Lógica de Negocio

### **Servicio: `StockService`**

```php
namespace App\Features\TenantAdmin\Services;

use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\ProductVariantStock;
use App\Features\TenantAdmin\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * ✅ 1. Verificar disponibilidad de producto
     * 
     * @param Product $product
     * @param array $selectedOptions ['variable_id' => 'option_id']
     * @param int $quantity
     * @return array ['available' => bool, 'quantity' => int, 'error' => string|null]
     */
    public function checkAvailability(Product $product, array $selectedOptions = [], int $quantity = 1): array
    {
        // Sin control de stock
        if (!$product->track_stock) {
            return ['available' => true, 'quantity' => PHP_INT_MAX];
        }

        // Stock ilimitado
        if ($product->stock_type === 'unlimited') {
            return ['available' => true, 'quantity' => PHP_INT_MAX];
        }

        // Producto simple
        if ($product->type === 'simple') {
            $available = $product->stock_quantity ?? 0;
            return [
                'available' => $available >= $quantity,
                'quantity' => $available,
            ];
        }

        // Producto variable
        $variantStock = $this->findVariantStock($product->id, $selectedOptions);
        
        if (!$variantStock) {
            return [
                'available' => false, 
                'quantity' => 0, 
                'error' => 'Esta combinación no está disponible'
            ];
        }

        if (!$variantStock->is_active) {
            return [
                'available' => false, 
                'quantity' => 0, 
                'error' => 'Esta variante está inactiva'
            ];
        }

        return [
            'available' => $variantStock->available_quantity >= $quantity,
            'quantity' => $variantStock->available_quantity,
        ];
    }

    /**
     * ✅ 2. Reservar stock (al agregar al carrito)
     * Decrementa available_quantity pero NO stock_quantity
     */
    public function reserve(Product $product, array $selectedOptions, int $quantity): bool
    {
        if (!$product->track_stock || $product->stock_type === 'unlimited') {
            return true;
        }

        return DB::transaction(function () use ($product, $selectedOptions, $quantity) {
            if ($product->type === 'simple') {
                // Reservar en producto simple (necesitaríamos agregar reserved_quantity a products)
                // Por ahora, solo validamos disponibilidad
                return $product->stock_quantity >= $quantity;
            }

            // Producto variable
            $variantStock = $this->findVariantStock($product->id, $selectedOptions);
            
            if (!$variantStock || $variantStock->available_quantity < $quantity) {
                return false;
            }

            // Incrementar cantidad reservada
            $before = $variantStock->reserved_quantity;
            $variantStock->increment('reserved_quantity', $quantity);

            // Registrar movimiento
            $this->createMovement(
                $product->id,
                $variantStock->id,
                StockMovement::TYPE_RESERVATION,
                -$quantity,
                $variantStock->stock_quantity - $before,
                $variantStock->stock_quantity - $variantStock->reserved_quantity
            );

            return true;
        });
    }

    /**
     * ✅ 3. Liberar reserva (eliminar del carrito)
     */
    public function release(Product $product, array $selectedOptions, int $quantity): void
    {
        if (!$product->track_stock || $product->stock_type === 'unlimited') {
            return;
        }

        DB::transaction(function () use ($product, $selectedOptions, $quantity) {
            if ($product->type === 'simple') {
                return; // Por ahora sin reserva en simples
            }

            $variantStock = $this->findVariantStock($product->id, $selectedOptions);
            if (!$variantStock) {
                return;
            }

            // Decrementar cantidad reservada
            $toRelease = min($quantity, $variantStock->reserved_quantity);
            $before = $variantStock->reserved_quantity;
            $variantStock->decrement('reserved_quantity', $toRelease);

            // Registrar movimiento
            $this->createMovement(
                $product->id,
                $variantStock->id,
                StockMovement::TYPE_RELEASE,
                $toRelease,
                $variantStock->stock_quantity - $before,
                $variantStock->stock_quantity - $variantStock->reserved_quantity
            );
        });
    }

    /**
     * ✅ 4. Decrementar stock (venta confirmada)
     */
    public function decrementStock(Product $product, array $selectedOptions, int $quantity, ?int $orderId = null): bool
    {
        if (!$product->track_stock || $product->stock_type === 'unlimited') {
            return true;
        }

        return DB::transaction(function () use ($product, $selectedOptions, $quantity, $orderId) {
            if ($product->type === 'simple') {
                $before = $product->stock_quantity;
                $product->decrement('stock_quantity', $quantity);

                $this->createMovement(
                    $product->id,
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

            // Producto variable
            $variantStock = $this->findVariantStock($product->id, $selectedOptions);
            if (!$variantStock) {
                return false;
            }

            // Liberar reserva y decrementar stock real
            $toRelease = min($quantity, $variantStock->reserved_quantity);
            $variantStock->decrement('reserved_quantity', $toRelease);
            
            $before = $variantStock->stock_quantity;
            $variantStock->decrement('stock_quantity', $quantity);

            $this->createMovement(
                $product->id,
                $variantStock->id,
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
     * 🔍 Buscar variante específica por combinación de opciones
     */
    protected function findVariantStock(int $productId, array $selectedOptions): ?ProductVariantStock
    {
        return ProductVariantStock::where('product_id', $productId)
            ->where('is_active', true)
            ->get()
            ->first(function ($stock) use ($selectedOptions) {
                $combination = $stock->variable_combination;
                
                // Verificar que todas las opciones coincidan
                foreach ($selectedOptions as $varId => $optId) {
                    if (!isset($combination[$varId]) || $combination[$varId] != $optId) {
                        return false;
                    }
                }
                
                return true;
            });
    }

    /**
     * 📝 Crear movimiento de stock
     */
    protected function createMovement(
        int $productId,
        ?int $variantStockId,
        string $type,
        int $quantity,
        int $before,
        int $after,
        ?string $refType = null,
        ?int $refId = null
    ): void {
        StockMovement::create([
            'product_id' => $productId,
            'variant_stock_id' => $variantStockId,
            'type' => $type,
            'quantity' => $quantity,
            'quantity_before' => $before,
            'quantity_after' => $after,
            'reference_type' => $refType,
            'reference_id' => $refId,
            'created_by' => auth()->id(),
        ]);
    }
}
```

---

## 🎨 UX: Productos Agotados

### **Pregunta: ¿Si el producto se agota, desaparece?**

### **❌ NO - Mala UX:**
- Cliente no sabe que el producto existe
- Pierde oportunidad de venta futura
- No puede activar "Notifícame cuando esté disponible"

### **✅ SÍ - Buena UX:**

#### **Opción 1: Mantener visible con badge "Agotado"**
```html
<!-- En listado de productos -->
<div class="product-card {{ $product->isOutOfStock() ? 'opacity-75' : '' }}">
    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}">
    
    @if($product->isOutOfStock())
        <div class="absolute top-2 right-2 bg-brandError-400 text-white px-3 py-1 rounded-full caption-strong">
            Agotado
        </div>
    @elseif($product->isLowStock())
        <div class="absolute top-2 right-2 bg-brandWarning-400 text-white px-3 py-1 rounded-full caption-strong">
            ¡Últimas {{ $product->available_stock }} unidades!
        </div>
    @endif
    
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->formatted_price }}</p>
    
    @if($product->isOutOfStock())
        <button class="btn-secondary" disabled>
            Agotado
        </button>
        <button class="btn-outline text-sm mt-2" @click="notifyMe({{ $product->id }})">
            🔔 Notifícame cuando esté disponible
        </button>
    @else
        <button class="btn-primary">
            Agregar al carrito
        </button>
    @endif
</div>
```

#### **Opción 2: Mover a sección "Agotados Temporalmente"**
```html
<!-- Productos disponibles -->
<section>
    <h2>Productos Disponibles</h2>
    <div class="grid">
        @foreach($availableProducts as $product)
            <!-- Card normal -->
        @endforeach
    </div>
</section>

<!-- Productos agotados (colapsado por defecto) -->
@if($outOfStockProducts->isNotEmpty())
<section x-data="{ open: false }" class="mt-12">
    <button @click="open = !open" class="flex items-center gap-2 text-brandNeutral-300">
        <i :data-lucide="open ? 'chevron-down' : 'chevron-right'"></i>
        <span>Ver productos temporalmente agotados ({{ $outOfStockProducts->count() }})</span>
    </button>
    
    <div x-show="open" x-collapse class="grid mt-4">
        @foreach($outOfStockProducts as $product)
            <!-- Card con estilo de agotado -->
        @endforeach
    </div>
</section>
@endif
```

#### **Opción 3: Productos Variables - Deshabilitar opciones agotadas**
```html
<!-- Selector de Talla -->
<div class="space-y-2">
    <label class="body-lg-bold">Talla</label>
    <div class="flex gap-2">
        @foreach($sizes as $size)
            @php
                $sizeStock = $product->getStockForOption('talla', $size->id);
            @endphp
            
            <button 
                class="px-4 py-2 border rounded-lg transition-colors
                    {{ $sizeStock <= 0 ? 'opacity-50 cursor-not-allowed border-gray-300 text-gray-400' : 'hover:border-brandPrimary-300' }}"
                {{ $sizeStock <= 0 ? 'disabled' : '' }}
                @click="selectedSize = {{ $size->id }}"
                :class="{ 'border-brandPrimary-300 bg-brandPrimary-50': selectedSize === {{ $size->id }} }"
            >
                {{ $size->name }}
                @if($sizeStock <= 0)
                    <span class="block text-xs mt-1">Agotado</span>
                @elseif($sizeStock <= 5)
                    <span class="block text-xs mt-1 text-brandWarning-400">{{ $sizeStock }} left</span>
                @endif
            </button>
        @endforeach
    </div>
</div>
```

---

### **Recomendación UX:**

✅ **Mantener visible** con indicador "Agotado"  
✅ **Deshabilitar botón** de agregar al carrito  
✅ **Mostrar badge** prominente  
✅ **Ofrecer "Notifícame"** para recuperar venta  
✅ **En variables:** Deshabilitar opciones sin stock  
⚠️ **Opcional:** Mover a sección colapsada "Temporalmente agotados"  

---

## 🖥️ Interfaz de Usuario

### **1. Formulario de Producto - Admin**

```html
<!-- En create.blade.php y edit.blade.php -->
<div x-data="stockManager({{ $product->toJson() }})">
    <!-- Toggle Control de Stock -->
    <div class="bg-white rounded-lg p-6 border mb-6">
        <div class="flex items-center gap-3">
            <input 
                type="checkbox" 
                name="track_stock" 
                id="track_stock"
                x-model="trackStock"
                class="w-5 h-5"
            >
            <label for="track_stock" class="body-lg-bold">
                📦 Controlar inventario de este producto
            </label>
        </div>
        <p class="caption text-gray-500 ml-8 mt-1">
            Activa esto para limitar la cantidad disponible y evitar sobreventa
        </p>
    </div>

    <!-- Configuración de Stock (solo si track_stock = true) -->
    <div x-show="trackStock" x-transition class="bg-white rounded-lg p-6 border mb-6">
        <h3 class="h3 mb-4">⚙️ Configuración de Inventario</h3>

        <!-- Tipo de Stock -->
        <div class="mb-6">
            <label class="body-lg-bold mb-2 block">Tipo de inventario</label>
            <div class="space-y-2">
                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input 
                        type="radio" 
                        name="stock_type" 
                        value="unlimited"
                        x-model="stockType"
                    >
                    <div>
                        <span class="body-lg-bold">♾️ Ilimitado</span>
                        <p class="caption text-gray-500">El producto siempre estará disponible</p>
                    </div>
                </label>
                
                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input 
                        type="radio" 
                        name="stock_type" 
                        value="limited"
                        x-model="stockType"
                    >
                    <div>
                        <span class="body-lg-bold">📊 Limitado</span>
                        <p class="caption text-gray-500">Controla la cantidad exacta disponible</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Campos para Stock Limitado -->
        <div x-show="stockType === 'limited'" x-transition class="space-y-4">
            <!-- Stock Actual (solo productos simples) -->
            @if($product->type === 'simple' || !$product->exists)
            <div>
                <label for="stock_quantity" class="body-lg-bold mb-2 block">
                    📦 Cantidad en stock
                </label>
                <input 
                    type="number" 
                    name="stock_quantity" 
                    id="stock_quantity"
                    value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}"
                    min="0"
                    class="w-full px-4 py-3 border rounded-lg"
                    placeholder="0"
                >
                <p class="caption text-gray-500 mt-1">
                    Cantidad actual disponible en tu inventario
                </p>
            </div>
            @endif

            <!-- Umbral de Alerta -->
            <div>
                <label for="stock_alert_threshold" class="body-lg-bold mb-2 block">
                    🔔 Alerta de stock bajo
                </label>
                <input 
                    type="number" 
                    name="stock_alert_threshold" 
                    id="stock_alert_threshold"
                    value="{{ old('stock_alert_threshold', $product->stock_alert_threshold ?? 5) }}"
                    min="1"
                    max="100"
                    class="w-full px-4 py-3 border rounded-lg"
                    placeholder="5"
                >
                <p class="caption text-gray-500 mt-1">
                    Te notificaremos cuando el stock llegue a esta cantidad o menos
                </p>
            </div>

            <!-- Info para productos variables -->
            @if($product->exists && $product->type === 'variable')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="body-lg-bold text-blue-900">Producto con Variables</p>
                        <p class="caption text-blue-700 mt-1">
                            Configura el stock individual para cada combinación de opciones 
                            (ej: Talla M + Color Rojo) en la sección 
                            <a href="#stock-variants" class="underline font-semibold">Gestión de Variantes</a> 
                            más abajo.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Gestión de Stock por Variante (solo productos variables) -->
    @if($product->exists && $product->type === 'variable')
    <div x-show="trackStock && stockType === 'limited'" id="stock-variants" class="bg-white rounded-lg p-6 border mb-6">
        <h3 class="h3 mb-4">📋 Stock por Variante</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 caption-strong">SKU</th>
                        <th class="text-left py-3 px-4 caption-strong">Combinación</th>
                        <th class="text-center py-3 px-4 caption-strong">Stock Actual</th>
                        <th class="text-center py-3 px-4 caption-strong">Reservado</th>
                        <th class="text-center py-3 px-4 caption-strong">Disponible</th>
                        <th class="text-center py-3 px-4 caption-strong">Estado</th>
                        <th class="text-right py-3 px-4 caption-strong">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($product->variantStocks as $variantStock)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <code class="text-sm bg-gray-100 px-2 py-1 rounded">
                                {{ $variantStock->sku }}
                            </code>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-sm">
                                @foreach($variantStock->getFormattedCombination() as $option)
                                <span class="inline-block bg-gray-100 px-2 py-1 rounded mr-1 mb-1">
                                    {{ $option }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="body-lg-bold">{{ $variantStock->stock_quantity }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="caption text-gray-500">{{ $variantStock->reserved_quantity }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="body-lg-bold {{ $variantStock->is_out_of_stock ? 'text-red-600' : ($variantStock->is_low_stock ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ $variantStock->available_quantity }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($variantStock->is_out_of_stock)
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-full caption-strong">
                                    <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    Agotado
                                </span>
                            @elseif($variantStock->is_low_stock)
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full caption-strong">
                                    <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                    Stock Bajo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full caption-strong">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Disponible
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button 
                                @click="editVariantStock({{ $variantStock->id }})"
                                class="text-blue-600 hover:underline text-sm"
                            >
                                Editar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i data-lucide="package-x" class="w-12 h-12 text-gray-400"></i>
                                <p class="body-lg text-gray-500">
                                    No hay variantes configuradas aún
                                </p>
                                <button 
                                    @click="generateVariants()"
                                    class="btn-primary"
                                >
                                    Generar Variantes Automáticamente
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
function stockManager(product) {
    return {
        trackStock: product.track_stock || false,
        stockType: product.stock_type || 'unlimited',
        
        editVariantStock(id) {
            // Abrir modal para editar stock de variante
            Alpine.store('modals').open('edit-variant-stock', { id });
        },
        
        generateVariants() {
            // Generar automáticamente todas las combinaciones
            // de variables asignadas al producto
            if (confirm('¿Generar automáticamente todas las combinaciones de variantes?')) {
                // API call
            }
        }
    };
}
</script>
```

---

### **2. Dashboard de Inventario**

```html
<!-- Nueva ruta: /admin/inventory -->
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="h1">📦 Gestión de Inventario</h1>
            <p class="body-lg text-gray-500 mt-2">
                Controla el stock de tus productos en tiempo real
            </p>
        </div>
        <div class="flex gap-3">
            <button class="btn-outline">
                📥 Importar Stock
            </button>
            <button class="btn-outline">
                📊 Exportar Reporte
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total Productos -->
        <div class="bg-white rounded-lg p-6 border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-gray-500">Total Productos</p>
                    <h3 class="h2 mt-2">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- En Stock -->
        <div class="bg-white rounded-lg p-6 border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-gray-500">En Stock</p>
                    <h3 class="h2 mt-2 text-green-600">{{ $stats['in_stock'] }}</h3>
                    <p class="caption text-gray-500 mt-1">
                        {{ number_format($stats['total_units']) }} unidades
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Stock Bajo -->
        <div class="bg-white rounded-lg p-6 border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-gray-500">Stock Bajo</p>
                    <h3 class="h2 mt-2 text-yellow-600">{{ $stats['low_stock'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
            @if($stats['low_stock'] > 0)
            <a href="#low-stock-section" class="text-sm text-yellow-600 hover:underline mt-2 inline-block">
                Ver productos →
            </a>
            @endif
        </div>

        <!-- Agotados -->
        <div class="bg-white rounded-lg p-6 border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="caption text-gray-500">Agotados</p>
                    <h3 class="h2 mt-2 text-red-600">{{ $stats['out_of_stock'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
            @if($stats['out_of_stock'] > 0)
            <a href="#out-of-stock-section" class="text-sm text-red-600 hover:underline mt-2 inline-block">
                Ver productos →
            </a>
            @endif
        </div>
    </div>

    <!-- Alertas de Stock Bajo -->
    @if($lowStockProducts->isNotEmpty())
    <div id="low-stock-section" class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1"></i>
            <div class="flex-1">
                <h3 class="h3 text-yellow-900 mb-4">
                    ⚠️ Productos con Stock Bajo ({{ $lowStockProducts->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                    <div class="bg-white rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img 
                                src="{{ $product->main_image_url }}" 
                                alt="{{ $product->name }}"
                                class="w-16 h-16 rounded object-cover"
                            >
                            <div>
                                <h4 class="body-lg-bold">{{ $product->name }}</h4>
                                <p class="caption text-gray-500">SKU: {{ $product->sku }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="body-lg-bold text-yellow-600">
                                    {{ $product->available_stock }} unidades
                                </p>
                                <p class="caption text-gray-500">
                                    Umbral: {{ $product->stock_alert_threshold }}
                                </p>
                            </div>
                            <a 
                                href="{{ route('tenant.admin.products.edit', ['store' => $store->slug, 'product' => $product->id]) }}"
                                class="btn-primary text-sm"
                            >
                                Actualizar Stock
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Productos Agotados -->
    @if($outOfStockProducts->isNotEmpty())
    <div id="out-of-stock-section" class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <i data-lucide="x-circle" class="w-6 h-6 text-red-600 flex-shrink-0 mt-1"></i>
            <div class="flex-1">
                <h3 class="h3 text-red-900 mb-4">
                    ❌ Productos Agotados ({{ $outOfStockProducts->count() }})
                </h3>
                <div class="space-y-3">
                    @foreach($outOfStockProducts as $product)
                    <div class="bg-white rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img 
                                src="{{ $product->main_image_url }}" 
                                alt="{{ $product->name }}"
                                class="w-16 h-16 rounded object-cover opacity-50"
                            >
                            <div>
                                <h4 class="body-lg-bold">{{ $product->name }}</h4>
                                <p class="caption text-gray-500">SKU: {{ $product->sku }}</p>
                                <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 bg-red-100 text-red-700 rounded-full caption-strong">
                                    <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    Sin stock
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="caption text-gray-500">
                                    {{ $product->pending_notifications_count ?? 0 }} personas esperando
                                </p>
                            </div>
                            <a 
                                href="{{ route('tenant.admin.products.edit', ['store' => $store->slug, 'product' => $product->id]) }}"
                                class="btn-primary text-sm"
                            >
                                Reabastecer
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Movimientos Recientes -->
    <div class="bg-white rounded-lg p-6 border">
        <h3 class="h3 mb-4">📊 Movimientos Recientes</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 caption-strong">Fecha</th>
                        <th class="text-left py-3 px-4 caption-strong">Producto</th>
                        <th class="text-center py-3 px-4 caption-strong">Tipo</th>
                        <th class="text-center py-3 px-4 caption-strong">Cantidad</th>
                        <th class="text-right py-3 px-4 caption-strong">Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentMovements as $movement)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <p class="caption">{{ $movement->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ $movement->product->main_image_url }}" 
                                    alt="{{ $movement->product->name }}"
                                    class="w-10 h-10 rounded object-cover"
                                >
                                <div>
                                    <p class="body-lg">{{ $movement->product->name }}</p>
                                    <p class="caption text-gray-500">{{ $movement->product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @php
                                $typeConfig = [
                                    'entry' => ['label' => 'Entrada', 'color' => 'green'],
                                    'exit' => ['label' => 'Salida', 'color' => 'red'],
                                    'sale' => ['label' => 'Venta', 'color' => 'blue'],
                                    'return' => ['label' => 'Devolución', 'color' => 'green'],
                                    'adjustment' => ['label' => 'Ajuste', 'color' => 'yellow'],
                                ];
                                $config = $typeConfig[$movement->type] ?? ['label' => $movement->type, 'color' => 'gray'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 rounded-full caption-strong">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="body-lg-bold {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <p class="caption text-gray-500">
                                {{ $movement->creator->name ?? 'Sistema' }}
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
```

---

## 🚀 Plan de Implementación

### **Fase 1: Base de Datos y Modelos (Semana 1)** ✅

**Día 1-2:** Migraciones
- ✅ Actualizar tabla `products`
- ✅ Crear tabla `product_variant_stocks`
- ✅ Crear tabla `stock_movements`

**Día 3-4:** Modelos Eloquent
- ✅ Actualizar modelo `Product`
- ✅ Crear modelo `ProductVariantStock`
- ✅ Crear modelo `StockMovement`
- ✅ Relaciones y scopes

**Día 5:** Testing
- ✅ Tests unitarios de modelos
- ✅ Tests de relaciones

---

### **Fase 2: Lógica de Negocio (Semana 2)** 🧠

**Día 1-3:** StockService
- ✅ `checkAvailability()`
- ✅ `reserve()`
- ✅ `release()`
- ✅ `decrementStock()`
- ✅ `incrementStock()`
- ✅ `findVariantStock()`

**Día 4-5:** Integración con Checkout
- ✅ Actualizar `OrderController::addToCart()`
- ✅ Actualizar `OrderController::removeFromCart()`
- ✅ Actualizar `OrderController::store()`
- ✅ Tests de integración

---

### **Fase 3: UI Admin (Semana 3)** 🎨

**Día 1-2:** Formulario de Productos
- ✅ Toggle "Controlar inventario"
- ✅ Tipo de stock (ilimitado/limitado)
- ✅ Campo stock para productos simples
- ✅ Tabla de variantes para productos variables

**Día 3-4:** Dashboard de Inventario
- ✅ Estadísticas generales
- ✅ Lista de productos con stock bajo
- ✅ Lista de productos agotados
- ✅ Movimientos recientes

**Día 5:** Modales y Acciones
- ✅ Modal para editar stock de variante
- ✅ Generar variantes automáticamente
- ✅ Importar/exportar stock (CSV)

---

### **Fase 4: UX Storefront (Semana 4)** 🛒

**Día 1-2:** Listado de Productos
- ✅ Badge "Agotado"
- ✅ Badge "Últimas X unidades"
- ✅ Botón deshabilitado si agotado
- ✅ Botón "Notifícame"

**Día 3-4:** Vista de Producto Individual
- ✅ Deshabilitar opciones sin stock
- ✅ Mostrar stock disponible por variante
- ✅ Mensajes dinámicos de disponibilidad

**Día 5:** Carrito
- ✅ Validación de stock al agregar
- ✅ Mensajes de error claros
- ✅ Actualización automática si stock cambia

---

### **Fase 5: Testing y Deploy (Semana 5)** ✅

**Día 1-2:** Tests E2E
- ✅ Flujo completo de compra
- ✅ Validación de sobreventa
- ✅ Reservas y liberaciones

**Día 3:** Optimización
- ✅ Índices de base de datos
- ✅ Queries N+1
- ✅ Caché de stock

**Día 4:** Documentación
- ✅ Guía de usuario
- ✅ Documentación técnica

**Día 5:** Deploy a Staging
- ✅ Migrar base de datos
- ✅ Seed de datos de prueba
- ✅ QA completo

---

## ✅ Checklist Pre-Deploy

### **Base de Datos:**
- [ ] Migraciones creadas y probadas
- [ ] Seeders para datos de prueba
- [ ] Índices optimizados
- [ ] Backup de base de datos

### **Backend:**
- [ ] Modelos con relaciones correctas
- [ ] StockService completo y testeado
- [ ] Integración con OrderController
- [ ] Tests unitarios pasando
- [ ] Tests de integración pasando

### **Admin UI:**
- [ ] Formulario de productos con stock
- [ ] Dashboard de inventario
- [ ] Gestión de variantes
- [ ] Modales funcionales

### **Storefront:**
- [ ] Badges de stock en listados
- [ ] Vista de producto con validaciones
- [ ] Carrito con verificación de stock
- [ ] Mensajes de error claros

### **Testing:**
- [ ] Tests E2E completos
- [ ] QA manual en staging
- [ ] Performance testing
- [ ] Validación de UX

### **Documentación:**
- [ ] Guía de usuario (admin)
- [ ] Documentación técnica
- [ ] Changelog actualizado

---

## 📊 Métricas de Éxito

**KPIs:**
- ✅ 0 casos de sobreventa
- ✅ Reducción del 80% en quejas de disponibilidad
- ✅ Tiempo de respuesta < 200ms en validaciones
- ✅ 95% de usuarios encuentran información de stock clara

---

**Fecha:** Diciembre 1, 2025  
**Vertical:** Ecommerce 🛒  
**Estado:** ✅ Propuesta lista para implementación

