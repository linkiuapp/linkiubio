# Ajuste: Stock en Productos Variables

**Fecha:** 1 de diciembre de 2025  
**Estado:** ✅ Implementado

## Problema Identificado

Al crear un producto variable con stock limitado, se presentaba una **inconsistencia**:

```
Producto Variable:
├── cantidad_stock: 5 (campo del producto)
└── Variables con opciones:
    ├── Talla A: 2 unidades
    ├── Talla B: 2 unidades
    └── Talla C: 2 unidades
    Total: 6 unidades ❌ (no coincide con 5)
```

### Explicación

El usuario ingresaba:
- **Campo `cantidad_stock` del producto:** 5 unidades
- **Opciones de variables:**
  - Opción A: 2 unidades
  - Opción B: 2 unidades
  - Opción C: 2 unidades
- **Total de variantes:** 6 unidades

Esto generaba confusión sobre cuál era el stock real del producto.

---

## Solución Implementada

### Regla Nueva

**Para productos SIMPLES:**
- El stock se maneja en el campo `cantidad_stock` del producto.

**Para productos VARIABLES:**
- El campo `cantidad_stock` del producto se **ignora**.
- El stock se maneja **exclusivamente** en la tabla `stock_variantes_producto`.
- Cada opción seleccionada genera un registro con su propia cantidad.

---

## Cambios Realizados

### 1. UI en Formularios

#### `edit.blade.php`
- **Productos Simples:** Muestra campo `cantidad_stock` y `umbral_alerta_stock`.
- **Productos Variables:** Oculta esos campos y muestra un mensaje informativo:

```
Stock por Variantes
Este producto tiene variables asignadas. El stock se maneja individualmente 
por cada opción seleccionada (ej: Talla S = 10 unidades, Talla M = 5 unidades).
Configura el stock de cada opción en la sección "Variables" más abajo.
```

#### `create.blade.php`
- **Productos Simples:** Muestra campos de stock.
- **Productos Variables:** Muestra mensaje indicando que deben guardar primero el producto y luego editar para asignar variables con sus cantidades.

### 2. Backend (`ProductController.php`)

**Nuevo método:** `syncStockVariantes()`

```php
protected function syncStockVariantes(Product $product, array $optionQuantities)
{
    // Limpiar registros existentes
    $product->stocksVariantes()->delete();
    
    // Crear registros para cada opción con cantidad
    foreach ($optionQuantities as $variableId => $options) {
        foreach ($options as $optionId => $cantidad) {
            if ($cantidad > 0) {
                StockVarianteProducto::create([
                    'product_id' => $product->id,
                    'combinacion_variables' => [
                        (string)$variableId => (string)$optionId
                    ],
                    'sku' => $product->sku . '-V' . $variableId . '-O' . $optionId,
                    'cantidad_stock' => $cantidad,
                    'cantidad_reservada' => 0,
                    'umbral_alerta_stock' => $product->umbral_alerta_stock ?? 5,
                ]);
            }
        }
    }
}
```

**Llamada automática:** Este método se ejecuta al final de `syncProductVariables()` si el producto tiene `controla_stock = true` y `tipo_stock = 'limitado'`.

### 3. Sincronización Automática

Ahora, cuando se guarda un producto variable con cantidades por opción:

1. Se guardan las cantidades en `product.option_quantities` (JSON, para referencia).
2. **Automáticamente** se crean/actualizan registros en `stock_variantes_producto`.
3. Cada opción tiene su propio registro de stock independiente.

---

## Flujo de Usuario (Corregido)

### Crear Producto Variable con Stock

1. **Crear producto** con tipo "Variable" y stock "Limitado".
2. **Guardar** (sin asignar variables aún).
3. **Editar** el producto.
4. En "Variables", seleccionar las opciones y **asignar cantidad a cada una**:
   - Talla A: 2
   - Talla B: 2
   - Talla C: 2
5. **Guardar**.
6. ✅ Se crean automáticamente 3 registros en `stock_variantes_producto`:
   - `{variable_id: option_id_A}` → 2 unidades
   - `{variable_id: option_id_B}` → 2 unidades
   - `{variable_id: option_id_C}` → 2 unidades

**Stock total:** Suma de todas las variantes = 6 unidades

---

## Beneficios

✅ **Elimina la confusión** entre stock del producto y stock de opciones.  
✅ **Consistencia:** Un solo lugar para el stock de productos variables.  
✅ **Automático:** No requiere pasos manuales adicionales.  
✅ **Claro:** La UI explica cómo funciona.

---

## Testing

### Caso de Prueba 1: Producto Simple
- Crear producto simple con stock 10.
- ✅ El stock se guarda en `products.cantidad_stock`.
- ✅ NO se crean registros en `stock_variantes_producto`.

### Caso de Prueba 2: Producto Variable
- Crear producto variable con 3 opciones (A=2, B=2, C=2).
- ✅ Se crean 3 registros en `stock_variantes_producto`.
- ✅ El campo `products.cantidad_stock` se ignora.

### Caso de Prueba 3: Editar Variantes
- Editar producto variable, cambiar cantidad de A a 5.
- ✅ Se actualiza el registro correspondiente.
- Agregar nueva opción D con cantidad 3.
- ✅ Se crea nuevo registro.
- Eliminar opción C.
- ✅ Se elimina el registro correspondiente.

---

## Archivos Modificados

```
app/Features/TenantAdmin/Controllers/Core/ProductController.php
app/Features/TenantAdmin/Views/Core/products/edit.blade.php
app/Features/TenantAdmin/Views/Core/products/create.blade.php
```

---

## Ajuste Adicional: Dashboard de Inventario

### Problema
El dashboard de inventario mostraba "sin stock" para productos variables porque los métodos del `StockService` solo miraban el campo `cantidad_stock` del producto (que es 0 para variables).

### Solución
Actualicé 3 métodos en `StockService`:

1. **`obtenerProductosStockBajo()`**
2. **`obtenerProductosAgotados()`**
3. **`obtenerEstadisticas()`**

Agregué un nuevo método helper:

```php
protected function obtenerStockTotal(Product $producto): int
{
    // Producto simple: usar cantidad_stock
    if ($producto->type === 'simple') {
        return $producto->cantidad_stock ?? 0;
    }

    // Producto variable: sumar stock de todas las variantes
    return $producto->stocksVariantes->sum('cantidad_stock');
}
```

Ahora todos los métodos usan `obtenerStockTotal()` para calcular el stock correcto según el tipo de producto.

---

## Pendiente

- [ ] Implementar toasts (bottom-center) para acciones de stock.
- [ ] Exportar a staging.


