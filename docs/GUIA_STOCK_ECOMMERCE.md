# 📦 Guía: Sistema de Stock para Ecommerce

> **Objetivo:** Controlar inventario real y evitar sobreventa  
> **Tiempo:** 5 semanas  
> **Complejidad:** Media

---

## 🎯 ¿Qué vamos a lograr?

1. ✅ Controlar cantidad exacta de cada producto
2. ✅ Stock diferente para cada variante (Talla M Roja = 10, Talla L Azul = 5)
3. ✅ Reservar stock cuando cliente agrega al carrito
4. ✅ Evitar sobreventa (stock real vs stock reservado)
5. ✅ Alertas de "stock bajo" y productos "agotados"
6. ✅ Historial completo de movimientos (auditoría)

---

## 🧩 Conceptos Clave

### **1. Producto Simple**
- 1 producto = 1 cantidad total
- Ejemplo: "Gorra Nike" = 50 unidades

### **2. Producto Variable**
- Cada combinación = cantidad independiente
- Ejemplo: "Camiseta"
  - Talla S = 20 unidades
  - Talla M = 35 unidades
  - Talla L = 15 unidades
  - Talla XL = 0 unidades (AGOTADO)

### **3. Stock Reservado vs Disponible**
```
Stock Real:       100 unidades (bodega física)
Stock Reservado:   15 unidades (en carritos de clientes)
Stock Disponible:  85 unidades (para vender)
```

### **4. ¿Qué pasa cuando se agota?**
❌ **NO desaparece**  
✅ Se muestra con badge "Agotado"  
✅ Botón deshabilitado  
✅ Opción "Notifícame cuando esté disponible"

---

## 🗄️ Base de Datos (3 cambios)

### **1. Tabla `products` (actualizar)**
Agregar 4 campos nuevos:
- `track_stock`: ¿Controla inventario? (true/false)
- `stock_type`: Tipo de stock ('unlimited' o 'limited')
- `stock_quantity`: Cantidad (solo productos simples)
- `stock_alert_threshold`: Umbral de alerta (default: 5)

### **2. Tabla `product_variant_stocks` (crear nueva)**
Guarda stock de cada combinación de opciones:
- `product_id`: ¿De qué producto?
- `variable_combination`: {"1": 5, "2": 8} (variable_id => option_id)
- `sku`: SKU único de esta variante
- `stock_quantity`: Cantidad real en bodega
- `reserved_quantity`: Cantidad en carritos (reservada)
- `available_quantity`: CALCULADO (stock - reservado)
- `is_active`: ¿Está activa?

**Ejemplo:**
```
Producto: Zapatos (ID 15)
Variable Talla (ID 1) → Opción 38 (ID 5)
Variable Color (ID 2) → Opción Negro (ID 8)

Fila en tabla:
- product_id: 15
- variable_combination: {"1": 5, "2": 8}
- sku: "ZAP-001-38-NEG"
- stock_quantity: 10
- reserved_quantity: 2
- available_quantity: 8 (automático)
```

### **3. Tabla `stock_movements` (crear nueva)**
Historial de todos los movimientos:
- `product_id` + `variant_stock_id`
- `type`: entrada, salida, venta, devolución, reserva, liberación
- `quantity`: +50 (entrada), -2 (salida)
- `quantity_before` y `quantity_after`
- `reference_type` + `reference_id`: Order #123, Ajuste manual, etc.
- `created_by`: Usuario que hizo el movimiento

---

## 🧠 Lógica de Negocio (StockService)

### **Métodos principales:**

**1. `checkAvailability()`**
- Verifica si hay stock suficiente
- Retorna: `['available' => true/false, 'quantity' => X]`

**2. `reserve()`**
- Al agregar al carrito
- Incrementa `reserved_quantity`
- NO toca `stock_quantity`

**3. `release()`**
- Al eliminar del carrito o cancelar
- Decrementa `reserved_quantity`

**4. `decrementStock()`**
- Al confirmar venta
- Decrementa `stock_quantity`
- Decrementa `reserved_quantity` (libera la reserva)

---

## 🔄 Flujo Completo

### **Cliente agrega al carrito:**
```
1. Verificar disponibilidad (¿hay stock?)
2. Reservar (incrementar reserved_quantity)
3. Agregar al carrito
4. Mostrar toast de éxito
```

### **Cliente elimina del carrito:**
```
1. Liberar reserva (decrementar reserved_quantity)
2. Eliminar del carrito
```

### **Cliente confirma compra:**
```
1. Crear orden
2. Decrementar stock real (stock_quantity)
3. Liberar reserva (reserved_quantity)
4. Registrar movimiento tipo "venta"
```

### **Cliente cancela/devuelve:**
```
1. Incrementar stock (stock_quantity)
2. Registrar movimiento tipo "devolución"
```

---

## 🎨 Interfaz de Usuario

### **Admin: Formulario de Producto**

**Toggle principal:**
```
[ ] Controlar inventario de este producto
```

**Si está activo:**
```
Tipo de inventario:
( ) Ilimitado  → Siempre disponible
( ) Limitado   → Control de cantidad

Si limitado:
├─ [_____] Cantidad en stock (solo productos simples)
└─ [_____] Alerta cuando queden menos de: [5]
```

**Productos Variables:**
```
Tabla de Variantes:
┌─────────────────┬──────────┬──────────┬────────────┬────────┐
│ Combinación     │ Stock    │ Reservado│ Disponible │ Estado │
├─────────────────┼──────────┼──────────┼────────────┼────────┤
│ 38 + Negro      │    10    │    2     │     8      │   ✅   │
│ 38 + Blanco     │     5    │    1     │     4      │   ⚠️   │
│ 38 + Rojo       │     0    │    0     │     0      │   ❌   │
│ 39 + Negro      │    15    │    3     │    12      │   ✅   │
└─────────────────┴──────────┴──────────┴────────────┴────────┘

[Editar] en cada fila para cambiar cantidad
```

---

### **Admin: Dashboard de Inventario**

**4 Cards de Estadísticas:**
```
┌──────────────┬──────────────┬──────────────┬──────────────┐
│ Total        │ En Stock     │ Stock Bajo   │ Agotados     │
│ 150          │ 120          │ 15           │ 15           │
│ productos    │ ✅           │ ⚠️           │ ❌           │
└──────────────┴──────────────┴──────────────┴──────────────┘
```

**Alertas de Stock Bajo:**
```
⚠️ Productos con Stock Bajo (15)
┌─────────────────────────────────────────────────┐
│ [IMG] Camiseta Básica                           │
│       SKU: CAM-001                              │
│       5 unidades (Umbral: 10)                   │
│                          [Actualizar Stock] →  │
└─────────────────────────────────────────────────┘
```

**Movimientos Recientes:**
```
┌────────────┬──────────────┬──────┬──────────┐
│ Fecha/Hora │ Producto     │ Tipo │ Cantidad │
├────────────┼──────────────┼──────┼──────────┤
│ 10:30 AM   │ Gorra Nike   │ Venta│   -2     │
│ 09:15 AM   │ Zapatos      │Entrada│  +50    │
│ 08:45 AM   │ Camiseta     │Reserva│   -1    │
└────────────┴──────────────┴──────┴──────────┘
```

---

### **Storefront: Listado de Productos**

**Producto Disponible:**
```
┌────────────────────────┐
│ [Imagen del producto]  │
│                        │
│ Camiseta Básica        │
│ $30.000                │
│                        │
│ [Agregar al carrito]   │
└────────────────────────┘
```

**Producto Stock Bajo:**
```
┌────────────────────────┐
│ [Imagen del producto]  │
│ [⚠️ Últimas 3 unidades!]│
│                        │
│ Zapatos Deportivos     │
│ $120.000               │
│                        │
│ [Agregar al carrito]   │
└────────────────────────┘
```

**Producto Agotado:**
```
┌────────────────────────┐
│ [Imagen con opacidad]  │
│ [❌ Agotado]           │
│                        │
│ Gorra Nike             │
│ $45.000                │
│                        │
│ [  Agotado  ] (disabled)│
│ [🔔 Notifícame]        │
└────────────────────────┘
```

---

### **Storefront: Producto Variable**

**Selección de Opciones:**
```
Talla:
[  S  ] [  M  ] [  L  ] [ XL ]
 (10)    (15)    (5)   Agotado
                        disabled

Color:
[Negro] [Blanco] [ Rojo ]
  ✅      ✅      Agotado
                  disabled

Stock disponible: 5 unidades

[Agregar al carrito]
```

---

## 📅 Plan de Implementación (5 Semanas)

### **Semana 1: Base de Datos** 🗄️
**Objetivo:** Estructura lista y funcionando

**Tareas:**
1. Crear migration para actualizar `products`
2. Crear migration para `product_variant_stocks`
3. Crear migration para `stock_movements`
4. Crear modelos Eloquent (Product, ProductVariantStock, StockMovement)
5. Definir relaciones entre modelos
6. Correr migrations en local
7. Tests unitarios de modelos

**Entregable:** Base de datos funcionando, modelos con relaciones

---

### **Semana 2: Lógica de Negocio** 🧠
**Objetivo:** StockService completo

**Tareas:**
1. Crear `StockService.php`
2. Implementar método `checkAvailability()`
3. Implementar método `reserve()`
4. Implementar método `release()`
5. Implementar método `decrementStock()`
6. Implementar método `incrementStock()`
7. Método auxiliar `findVariantStock()`
8. Tests unitarios del servicio

**Entregable:** StockService testeado y funcionando

---

### **Semana 3: Integración con Carrito** 🛒
**Objetivo:** Sistema funcionando end-to-end

**Tareas:**
1. Actualizar `OrderController::addToCart()` con validación de stock
2. Actualizar `OrderController::removeFromCart()` con liberación
3. Actualizar `OrderController::store()` con decremento de stock
4. Actualizar `cart.js` para mostrar errores de stock
5. Tests de integración del flujo completo
6. Pruebas manuales en local

**Entregable:** Flujo completo de carrito con stock funcionando

---

### **Semana 4: UI Admin** 👨‍💼
**Objetivo:** Administradores pueden gestionar stock

**Tareas:**
1. Actualizar formulario de productos (create/edit)
   - Toggle "Controlar inventario"
   - Campos de stock para productos simples
   - Tabla de variantes para productos variables
2. Crear Dashboard de Inventario
   - Cards de estadísticas
   - Lista de productos con stock bajo
   - Lista de productos agotados
   - Tabla de movimientos recientes
3. Modal para editar stock de variante
4. Función "Generar variantes automáticamente"
5. Alpine.js para interactividad

**Entregable:** Admin puede ver y gestionar todo el stock

---

### **Semana 5: UX Storefront + Deploy** 🎨
**Objetivo:** Clientes ven stock y sistema en producción

**Tareas:**
1. Actualizar listado de productos
   - Badges "Agotado" y "Stock Bajo"
   - Botón deshabilitado si agotado
   - Botón "Notifícame"
2. Actualizar vista de producto individual
   - Deshabilitar opciones sin stock
   - Mostrar cantidad disponible
   - Mensajes dinámicos
3. Tests E2E completos
4. Optimización de queries (N+1)
5. Documentación de usuario
6. Deploy a staging
7. QA completo
8. Deploy a producción

**Entregable:** Sistema completo en producción

---

## ✅ Checklist Final

### **Base de Datos:**
- [ ] Migration `products` aplicada
- [ ] Migration `product_variant_stocks` aplicada
- [ ] Migration `stock_movements` aplicada
- [ ] Seeder de datos de prueba
- [ ] Índices optimizados

### **Backend:**
- [ ] Modelos con relaciones
- [ ] StockService implementado
- [ ] Integración con OrderController
- [ ] Tests pasando (>80% coverage)

### **Admin:**
- [ ] Formulario de productos actualizado
- [ ] Dashboard de inventario funcional
- [ ] Gestión de variantes funcional
- [ ] Modales y acciones implementadas

### **Storefront:**
- [ ] Badges de stock en listados
- [ ] Vista de producto con validaciones
- [ ] Carrito con verificación de stock
- [ ] UX de productos agotados

### **Testing:**
- [ ] Tests unitarios
- [ ] Tests de integración
- [ ] Tests E2E
- [ ] QA manual en staging

### **Deploy:**
- [ ] Documentación completa
- [ ] Backup de base de datos
- [ ] Plan de rollback
- [ ] Deploy exitoso

---

## 🎯 Métricas de Éxito

- ✅ **0 sobreventa** (crítico)
- ✅ **Validación de stock < 200ms** (performance)
- ✅ **95% usuarios** encuentran info de stock clara (UX)
- ✅ **Reducción 80%** en quejas de disponibilidad

---

## 📝 Glosario Rápido

| Término | Significado |
|---------|-------------|
| **Stock Real** | Cantidad física en bodega |
| **Stock Reservado** | Cantidad en carritos de clientes |
| **Stock Disponible** | Real - Reservado |
| **Variante** | Combinación específica de opciones (Talla M + Rojo) |
| **Umbral** | Límite para alerta de stock bajo |
| **Movimiento** | Registro de entrada/salida de stock |

---

**Fecha:** Diciembre 1, 2025  
**Versión:** 1.0  
**Estado:** ✅ Listo para implementar

