# Plan de Refactorización: TenantAdmin por Verticales

**Fecha:** 2024  
**Estado:** 🔄 En Progreso - Fases 0-6 completadas, Fase 7 en progreso - Ver `FASE7_VALIDACION.md` para detalles

---

## 📋 Resumen Ejecutivo

### Situación Actual
- **29 controladores** en una sola carpeta
- **7 servicios** sin organización clara
- Funcionalidades mezcladas sin separación por vertical

### Objetivo
Reorganizar la estructura en:
- **Core:** Funcionalidades compartidas por TODOS los verticales
- **Verticals:** Funcionalidades específicas de cada vertical (Restaurant, Hotel, Dropshipping)

---

## 🎯 Funcionalidades por Categoría

### ✅ COMPARTIDAS (Core) - 18 funcionalidades
- Dashboard
- Pedidos
- Categorías
- Variables
- Productos
- Métodos de pago
- Sedes
- Notificaciones de WhatsApp
- Diseño de tienda
- Cupones
- Sliders
- Soporte y tickets
- Anuncios de Linkiu
- Mi cuenta
- Clave maestra
- Perfil del negocio
- Facturación

### 🟢 ECOMMERCE - Sin funcionalidades adicionales
- Aún no tiene adicionales (solo usa funcionalidades Core compartidas)

### 🟡 RESTAURANT - 4 funcionalidades específicas
- Reserva de mesas
- Consumo en el local
- Carrito
- Checkout

### 🔴 HOTEL - 6 funcionalidades específicas
- Reserva de mesas
- Consumo en el local
- Carrito
- Checkout
- Reservas de hotel
- Servicio habitación

### 🟢 DROPSHIPPING - Pendiente implementación
- Se van a comenzar a crear
- **NO usa Carrito ni Checkout** - Sistema relist (similar a Shopify)

---

## 📁 Estructura Objetivo

```
app/Features/TenantAdmin/
├── Controllers/
│   ├── Core/                          # 20 controladores compartidos
│   │   ├── DashboardController.php
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   ├── CategoryController.php
│   │   ├── VariableController.php
│   │   ├── CouponController.php
│   │   ├── SliderController.php
│   │   ├── PaymentMethodController.php
│   │   ├── LocationController.php
│   │   ├── StoreDesignController.php
│   │   ├── TicketController.php
│   │   ├── AnnouncementController.php
│   │   ├── ProfileController.php
│   │   ├── MasterKeyController.php
│   │   ├── BusinessProfileController.php
│   │   ├── BillingController.php
│   │   ├── InvoiceController.php
│   │   ├── AuthController.php
│   │   ├── PreviewController.php
│   │   ├── PasswordResetController.php
│   │   ├── ShippingMethodController.php
│   │   └── SimpleShippingController.php
│   │
│   └── Verticals/
│       ├── Ecommerce/
│       │   └── README.md (Solo usa Core, sin controllers adicionales)
│       │
│       ├── Restaurant/
│       │   ├── TableReservationController.php
│       │   ├── TableController.php
│       │   └── DineInSettingController.php
│       │
│       ├── Hotel/
│       │   ├── HotelReservationController.php
│       │   ├── RoomController.php
│       │   └── RoomTypeController.php
│       │
│       └── Dropshipping/
│           └── (Pendiente implementación)
│
├── Services/
│   ├── Core/                          # 7 servicios compartidos
│   │   ├── LocationService.php
│   │   ├── PaymentMethodService.php
│   │   ├── BankAccountService.php
│   │   ├── ProductImageService.php
│   │   ├── ProductVariantService.php
│   │   ├── SliderImageService.php
│   │   └── StoreDesignImageService.php
│   │
│   └── Verticals/
│       ├── Restaurant/
│       └── Hotel/
│
└── Views/
    ├── core/                          # Vistas compartidas
    └── verticals/                      # Vistas específicas
        ├── restaurant/
        ├── hotel/
        └── dropshipping/
```

---

## 📊 Archivos a Mover

### Core (21 controladores + 7 servicios)
Todos los controladores compartidos se mueven a `Controllers/Core/`:
- Dashboard, Order, Product, Category, Variable, Coupon, Slider, PaymentMethod, BankAccount, Location, StoreDesign, Ticket, Announcement, Profile, MasterKey, BusinessProfile, Billing, Invoice, Auth, Preview, PasswordReset, ShippingMethod, SimpleShipping

Todos los servicios compartidos se mueven a `Services/Core/`:
- LocationService, PaymentMethodService, BankAccountService, ProductImageService, ProductVariantService, SliderImageService, StoreDesignImageService

### Restaurant (3 controladores)
- `TableReservationController.php` → `Controllers/Verticals/Restaurant/`
- `TableController.php` → `Controllers/Verticals/Restaurant/`
- `DineInSettingController.php` → `Controllers/Verticals/Restaurant/`

### Hotel (3 controladores)
- `HotelReservationController.php` → `Controllers/Verticals/Hotel/`
- `RoomController.php` → `Controllers/Verticals/Hotel/`
- `RoomTypeController.php` → `Controllers/Verticals/Hotel/`

---

## 🔄 Cambios de Namespace

### Antes → Después

**Core:**
```php
// Antes
App\Features\TenantAdmin\Controllers\DashboardController
App\Features\TenantAdmin\Controllers\OrderController
App\Features\TenantAdmin\Controllers\ProductController

// Después
App\Features\TenantAdmin\Controllers\Core\DashboardController
App\Features\TenantAdmin\Controllers\Core\OrderController
App\Features\TenantAdmin\Controllers\Core\ProductController
```

**Restaurant:**
```php
// Antes
App\Features\TenantAdmin\Controllers\TableReservationController

// Después
App\Features\TenantAdmin\Controllers\Verticals\Restaurant\TableReservationController
```

**Hotel:**
```php
// Antes
App\Features\TenantAdmin\Controllers\HotelReservationController

// Después
App\Features\TenantAdmin\Controllers\Verticals\Hotel\HotelReservationController
```

---

## 📝 Archivos a Actualizar

### 1. Rutas (`Routes/web.php`)
- Actualizar todos los imports de controladores (28 líneas)
- Cambiar namespaces de Core y Verticals

### 2. Controladores que importan servicios
- `ProductController.php` → Actualizar import de `ProductImageService`
- `SliderController.php` → Actualizar import de `SliderImageService`
- `LocationController.php` → Actualizar import de `LocationService`
- `PaymentMethodController.php` → Actualizar import de `PaymentMethodService`
- `BankAccountController.php` → Actualizar import de `BankAccountService`
- `StoreDesignController.php` → Actualizar import de `StoreDesignImageService`

### 3. Tests
- `tests/Feature/TenantAdmin/SliderInternalLinksTest.php` → Actualizar import de `SliderController`

**Total:** ~16 archivos a actualizar

---

## ⚠️ Notas Importantes

### 1. Categorías de Negocios (BusinessCategory)

**¿Cómo funcionan?**
- Las categorías de negocios son **fijas** y se crean desde SuperLinkiu (`app/Features/SuperLinkiu/Controllers/BusinessCategoryController.php`)
- Cada categoría tiene una relación many-to-many con `BusinessFeature` (tabla `business_category_feature`)
- Determinan qué features están disponibles para cada tipo de negocio
- Tienen un campo `requires_manual_approval` que define si las tiendas necesitan aprobación manual

**Mejora propuesta:**
- ✅ **Agregar campo `vertical` (obligatorio)** en `BusinessCategory`
- ✅ **Asignación automática de features** según el vertical seleccionado
- ✅ **Los iconos siguen siendo independientes** - Se asignan manualmente por categoría de negocio

**Cambios técnicos:**

1. **Migration:**
```php
Schema::table('business_categories', function (Blueprint $table) {
    $table->enum('vertical', ['ecommerce', 'restaurant', 'hotel', 'dropshipping'])
          ->after('description')
          ->comment('Vertical principal de la categoría');
});
```

2. **Mapeo Vertical → Features** (`config/verticals.php`):
```php
return [
    'ecommerce' => [
        'features' => [
            'dashboard', 'orders', 'products', 'categories', 'variables',
            'shipping', 'payments', 'branches', 'coupons', 'slider',
            'account', 'master_key', 'business_profile', 'store_design',
            'billing', 'ads', 'tickets', 'notificaciones_whatsapp'
        ]
    ],
    'restaurant' => [
        'features' => [
            // Features base + específicos
            'dashboard', 'orders', 'products', 'categories', 'variables',
            'payments', 'branches', 'coupons', 'slider',
            'account', 'master_key', 'business_profile', 'store_design',
            'billing', 'ads', 'tickets', 'notificaciones_whatsapp',
            'reservas_mesas', 'consumo_local'
        ]
    ],
    'hotel' => [
        'features' => [
            // Features base + específicos
            'dashboard', 'orders', 'products', 'categories', 'variables',
            'payments', 'branches', 'coupons', 'slider',
            'account', 'master_key', 'business_profile', 'store_design',
            'billing', 'ads', 'tickets', 'notificaciones_whatsapp',
            'reservas_hotel', 'consumo_hotel', 'reservas_mesas', 'consumo_local'
        ]
    ],
    'dropshipping' => [
        'features' => [
            'dashboard', 'orders', 'products', 'categories', 'variables',
            'shipping', 'payments', 'branches', 'coupons', 'slider',
            'account', 'master_key', 'business_profile', 'store_design',
            'billing', 'ads', 'tickets', 'notificaciones_whatsapp'
        ]
    ]
];
```

3. **Lógica en BusinessCategoryController:**
```php
// Al crear/actualizar categoría:
if ($request->has('vertical')) {
    // Asignar features automáticamente según vertical
    $verticalFeatures = config("verticals.{$request->vertical}.features");
    $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');
    $category->features()->sync($featureIds);
}
```

**Ventajas:**
- ✅ Simplifica la creación de categorías (solo seleccionar vertical)
- ✅ Evita errores (no se olvidan features)
- ✅ El sidebar se habilita automáticamente según el vertical
- ✅ Los iconos siguen siendo independientes (flexibilidad)

**¿Cómo afecta la refactorización?**
- ✅ **NO se mueven** - Pertenecen al módulo SuperLinkiu, no a TenantAdmin
- ✅ **Mejora el sistema** - Asignación automática de features según vertical
- ✅ **Sigue funcionando igual** - El sistema de features sigue funcionando mediante `FeatureResolver`
- ✅ **Alineación automática** - Las categorías se alinean automáticamente con los verticales

**Estructura:**
```
SuperLinkiu/
├── Controllers/
│   └── BusinessCategoryController.php  # Gestión de categorías (MEJORADO)
└── Models/ (Shared)
    └── BusinessCategory.php            # Modelo (con campo vertical)
    └── BusinessFeature.php             # Modelo de features

config/
└── verticals.php                       # NUEVO: Mapeo vertical → features
```

**Conclusión:** Esta mejora complementa la refactorización, haciendo que el sistema de categorías sea más intuitivo y automático, mientras que la refactorización organiza mejor el código de TenantAdmin según los verticales.

---

### 2. Componentes Blade

**Situación actual:**
- **Componentes en TenantAdmin:** `app/Features/TenantAdmin/Views/components/` (3 archivos)
  - `color-picker.blade.php` - Usado en store-design
  - `header-preview.blade.php` - Pendiente verificar uso
  - `image-uploader.blade.php` - Pendiente verificar uso

- **Componentes compartidos:** `app/Shared/Views/Components/` (Layouts y admin)
  - Layouts: `AdminLayout`, `TenantAdminLayout`
  - Componentes admin: sidebar, navbar, footer, etc.

- **Componentes Design System:** `app/Features/DesignSystem/Components/` (solo en local)
  - Muchos componentes registrados pero solo visibles en desarrollo

**Problema identificado:**
- Algunos componentes pueden no estar en uso
- Componentes regados sin organización clara
- Falta documentación sobre qué componentes se usan realmente

**Recomendación:**
1. **Auditar componentes** antes de refactorizar:
   ```bash
   # Buscar uso de componentes
   grep -r "color-picker\|header-preview\|image-uploader" app/Features/TenantAdmin/Views/
   ```

2. **Organizar componentes después de refactorización:**
   ```
   Views/
   ├── components/              # Componentes compartidos de TenantAdmin
   │   ├── core/               # Componentes Core
   │   └── verticals/          # Componentes específicos por vertical
   │       ├── restaurant/
   │       └── hotel/
   ```

3. **Eliminar componentes no usados** después de verificar

**Acción:** Agregar auditoría de componentes como parte de la Fase 1 (Preparación)

---

### 3. Dropshipping
- **NO usa Carrito ni Checkout**
- Funciona como sistema relist (similar a Shopify)
- Los productos se muestran directamente sin proceso tradicional de carrito/checkout

### 4. Carrito y Checkout
- Ecommerce, Restaurant y Hotel: ✅ Usan carrito y checkout
- Dropshipping: ❌ NO usa carrito ni checkout

---

## 🚀 Plan de Ejecución (Orden Recomendado)

### ⚠️ ORDEN DE TRABAJO RECOMENDADO

**¿Por qué este orden?**
1. **Primero categorías de negocio** → Define la estructura conceptual y guía la organización
2. **Luego ordenar carpetas** → Usa la estructura definida para organizar el código
3. **Finalmente componentes** → Limpia y organiza componentes según la nueva estructura

**Ventajas:**
- ✅ Menos riesgo: Categorías primero no rompe código existente
- ✅ Guía clara: Sabes qué va dónde antes de mover archivos
- ✅ Rollback fácil: Cada fase es independiente
- ✅ Testing incremental: Puedes probar cada fase por separado

---

### Fase 0: Preparación Base (1-2 horas)
**Objetivo:** Crear la infraestructura necesaria sin afectar código existente

1. Crear archivo de configuración `config/verticals.php` con mapeo vertical → features
2. **Auditar componentes Blade** - Identificar cuáles se usan realmente
3. Ejecutar tests actuales y documentar cobertura
4. Crear rama de trabajo: `git checkout -b refactor/tenant-admin-verticals`

**✅ Criterio de éxito:** Tests pasando, configuración creada, sin cambios en código existente

---

### Fase 1: Sistema de Categorías de Negocios (2-3 horas)
**Objetivo:** Implementar sistema de verticales en categorías de negocio

1. **Migration:**
   - Agregar campo `vertical` (nullable primero) a `business_categories`
   - Crear script de migración de datos existentes (asignar vertical según features actuales)

2. **Lógica:**
   - Actualizar `BusinessCategory` model (agregar `vertical` al fillable)
   - Actualizar `BusinessCategoryController`:
     - Agregar campo `vertical` al formulario
     - Implementar asignación automática de features según vertical
     - Mantener compatibilidad con categorías sin vertical (temporal)

3. **Migración de datos (RECOMENDADO: Opción C - Híbrido):**
   - **Script automático inteligente:**
     - Analiza features actuales de cada categoría
     - Sugiere vertical según mapeo de features
     - Detecta categorías ambiguas (múltiples verticales posibles)
   - **Panel de revisión en SuperLinkiu:**
     - Lista todas las categorías sin vertical
     - Muestra sugerencia del script
     - Permite confirmar o cambiar manualmente
     - Validación: No permite guardar sin vertical
   - **Ventajas:**
     - ✅ Rápido: Script hace el trabajo pesado
     - ✅ Seguro: Admin tiene control final
     - ✅ Inteligente: Detecta casos ambiguos
     - ✅ Escalable: Funciona con pocas o muchas categorías

4. **Testing:**
   - Crear nueva categoría con vertical
   - Verificar asignación automática de features
   - Verificar que sidebar se habilita correctamente

**✅ Criterio de éxito:** Todas las categorías tienen vertical, features asignados automáticamente, sidebar funciona

**Detalles técnicos del sistema híbrido:**

1. **Comando Artisan para análisis:**
```bash
php artisan business-categories:suggest-verticals
```
   - Analiza todas las categorías sin vertical
   - Compara features actuales con mapeo de `config/verticals.php`
   - Genera reporte con sugerencias
   - Guarda sugerencias en tabla temporal o cache

2. **Lógica de detección:**
```php
// Ejemplo de lógica
$categoryFeatures = $category->features->pluck('key');
$suggestions = [];

foreach (config('verticals') as $vertical => $config) {
    $matchScore = count(array_intersect($categoryFeatures, $config['features']));
    if ($matchScore > 0) {
        $suggestions[$vertical] = $matchScore;
    }
}

// Ordenar por score (mayor coincidencia primero)
// Si hay empate o score muy bajo → marcar como "ambiguo"
```

3. **Panel de revisión en SuperLinkiu:**
   - Nueva ruta: `/superlinkiu/business-categories/migrate-verticals`
   - Vista que muestra:
     - Categorías sin vertical (con sugerencia)
     - Categorías ambiguas (requieren decisión manual)
     - Categorías con sugerencia clara (confirmación rápida)
   - Formulario masivo: Seleccionar múltiples y asignar vertical
   - Validación: No permite guardar sin vertical asignado

4. **Ventajas del enfoque:**
   - ✅ **Rápido:** Si hay 5 categorías, el script sugiere y confirmas en 2 minutos
   - ✅ **Seguro:** Si hay 50 categorías, el script ayuda pero tú controlas
   - ✅ **Inteligente:** Detecta casos donde necesitas decidir manualmente
   - ✅ **Auditable:** Guarda log de quién asignó qué vertical y cuándo

---

### Fase 2: Ordenar Carpetas - Core (3-4 horas)
**Objetivo:** Mover controladores y servicios Core a nueva estructura

1. Crear estructura de carpetas nueva:
   ```
   Controllers/Core/
   Services/Core/
   ```

2. ✅ Mover 21 controladores Core a `Controllers/Core/` - **COMPLETADO**
3. ❌ Mover 7 servicios Core a `Services/Core/` - **PENDIENTE** (ver `PENDIENTES_REFACTORING.md`)
4. ✅ Actualizar namespaces en archivos movidos - **COMPLETADO**
5. ✅ Actualizar imports en rutas (`Routes/web.php`) - **COMPLETADO**
6. ❌ Actualizar imports en controladores que usan servicios - **PENDIENTE** (depende de mover servicios)
7. ✅ Ejecutar tests - **COMPLETADO** (parcialmente)

**✅ Criterio de éxito:** Todos los controladores Core movidos ✅, rutas funcionando ✅, tests pasando ✅
**⚠️ Pendiente:** Servicios Core y actualización de imports en controladores

---

### Fase 3: Ordenar Carpetas - Verticals (3-4 horas)
**Objetivo:** Mover controladores específicos de verticales

1. Crear estructura de carpetas:
   ```
   Controllers/Verticals/Restaurant/
   Controllers/Verticals/Hotel/
   ```

2. **Restaurant (2-3 horas):**
   - Mover 3 controladores a `Controllers/Verticals/Restaurant/`
   - Actualizar namespaces
   - Actualizar imports en rutas
   - Ejecutar tests

3. **Hotel (2-3 horas):**
   - Mover 3 controladores a `Controllers/Verticals/Hotel/`
   - Actualizar namespaces
   - Actualizar imports en rutas
   - Ejecutar tests

**✅ Criterio de éxito:** Todos los controladores de verticales movidos, rutas funcionando, tests pasando

---

### Fase 4: Organizar Componentes (2-3 horas)
**Objetivo:** Limpiar y organizar componentes según nueva estructura

1. ✅ **Hacer DesignSystem disponible en todos los ambientes:**
   - ✅ Actualizar `ComponentsServiceProvider` (quitar condición `local`) - **COMPLETADO**
   - ✅ Verificar que componentes funcionan en producción - **COMPLETADO**

2. ⚠️ **Organizar componentes específicos:**
   - ✅ Mover componentes específicos a `Views/components/Core/` - **PARCIAL** (solo `header-preview.blade.php`)
   - ❌ Crear estructura para componentes de verticales (si aplica) - **PENDIENTE**
   - ❌ Eliminar componentes duplicados/no usados - **PENDIENTE** (ver `PENDIENTES_REFACTORING.md`)

3. ⚠️ **Actualizar vistas:**
   - ⚠️ Reemplazar componentes duplicados por DesignSystem - **EN PROGRESO**
   - ✅ Actualizar imports de componentes específicos - **PARCIAL**

**✅ Criterio de éxito:** DesignSystem disponible ✅, Componentes organizados ⚠️ (parcial), sin duplicados ❌ (pendiente auditoría)

---

### Fase 5: Validación Final (2-4 horas)
1. Ejecutar suite completa de tests
2. Validar funcionalidad en staging:
   - Crear tienda de cada vertical
   - Verificar sidebar según vertical
   - Verificar funcionalidades específicas
3. Documentar cambios
4. Merge a staging

**Total estimado:** 13-19 horas

---

## ✅ Checklist de Validación

Después de cada fase:

- [ ] Archivos movidos correctamente
- [ ] Namespaces actualizados
- [ ] Imports actualizados en rutas
- [ ] Tests pasando (`php artisan test`)
- [ ] Sin errores en logs
- [ ] Funcionalidad verificada manualmente
- [ ] Commit realizado con mensaje descriptivo

---

## 🔙 Plan de Rollback

### Rollback Inmediato
```bash
git reset --hard HEAD~1
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Rollback Parcial
```bash
# Revertir solo vertical problemático
git checkout HEAD~1 -- app/Features/TenantAdmin/Controllers/Verticals/[Vertical]/
```

---

## ❓ Preguntas Pendientes

1. ¿Hay controladores que DEBEN mantenerse en su ubicación actual?
2. ¿Prefieres migración fase por fase o completa?
3. ¿Hay deadline o restricciones de tiempo?
4. ¿Qué verticales están más activos en producción?
5. **Componentes:** ¿Quieres que audite y elimine componentes no usados durante la refactorización?
6. **Categorías existentes:** ✅ RESUELTO - Opción C (Híbrido): Script automático + Panel de revisión

---

**Fecha de última actualización:** 2024  
**Versión:** 2.1 (Estado actualizado)

---

## 📌 Estado Actual de la Refactorización

**Ver documento detallado:** `docs/PENDIENTES_REFACTORING.md`

### ✅ Completado:
- Fase 0: Preparación Base
- Fase 1: Sistema de Categorías de Negocios
- Fase 2: Refactorización del Sidebar
- Fase 3: Controladores Core movidos
- Fase 4: Controladores Verticals movidos
- Fase 5: DesignSystem disponible en todos los ambientes

### ❌ Pendiente:
- Servicios Core (mover a `Services/Core/`)
- Organización de Vistas (mover a `Views/core/` y `Views/verticals/`)
- Componentes adicionales (auditoría y limpieza)
- Validación Final

**Tiempo estimado restante:** 7-11 horas
