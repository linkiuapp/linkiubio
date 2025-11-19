# Pendientes de Refactorización: TenantAdmin por Verticales

**Fecha:** 2024  
**Estado:** 📋 Pendiente de Implementación  
**Basado en:** `REFACTORING_PLAN.md` y `ORDEN_DE_TRABAJO.md`

---

## ✅ Lo que YA está implementado

### Fase 0: Preparación Base ✅
- [x] `config/verticals.php` creado y configurado
- [x] Tests ejecutados (baseline establecido)

### Fase 1: Sistema de Categorías de Negocios ✅
- [x] Migration con campo `vertical` en `business_categories`
- [x] Model actualizado
- [x] Controller actualizado con asignación automática de features

### Fase 2: Refactorización del Sidebar ✅
- [x] Sidebar refactorizado con componentes reutilizables
- [x] JavaScript organizado y modular
- [x] Lógica condicional según vertical implementada

### Fase 3: Ordenar Carpetas - Core (Controladores) ✅
- [x] Estructura `Controllers/Core/` creada
- [x] 21 controladores Core movidos a `Controllers/Core/`
- [x] Namespaces actualizados
- [x] Imports en rutas actualizados

### Fase 4: Ordenar Carpetas - Verticals (Controladores) ✅
- [x] Estructura `Controllers/Verticals/Restaurant/` creada
- [x] Estructura `Controllers/Verticals/Hotel/` creada
- [x] 3 controladores Restaurant movidos
- [x] 3 controladores Hotel movidos
- [x] Namespaces actualizados
- [x] Imports en rutas actualizados

### Fase 5: Organizar Componentes (Parcial) ✅
- [x] DesignSystem disponible en todos los ambientes (no solo local)
- [x] Componente `header-preview.blade.php` movido a `Views/components/Core/`

---

## ❌ Lo que FALTA implementar

### 1. Servicios Core (Pendiente - Fase 3 incompleta)

**Situación actual:**
- Los servicios están en `app/Features/TenantAdmin/Services/` directamente
- Existe carpeta `Services/Core/` pero está vacía

**Servicios a mover (7 archivos):**
```
app/Features/TenantAdmin/Services/
├── BankAccountService.php          → Services/Core/
├── LocationService.php             → Services/Core/
├── PaymentMethodService.php        → Services/Core/
├── ProductImageService.php         → Services/Core/
├── ProductVariantService.php       → Services/Core/
├── SliderImageService.php          → Services/Core/
└── StoreDesignImageService.php     → Services/Core/
```

**Tareas:**
1. Mover los 7 servicios a `Services/Core/`
2. Actualizar namespaces de `App\Features\TenantAdmin\Services` a `App\Features\TenantAdmin\Services\Core`
3. Actualizar imports en controladores que usan estos servicios:
   - `ProductController.php` → `ProductImageService`, `ProductVariantService`
   - `SliderController.php` → `SliderImageService`
   - `LocationController.php` → `LocationService`
   - `PaymentMethodController.php` → `PaymentMethodService`
   - `BankAccountController.php` → `BankAccountService`
   - `StoreDesignController.php` → `StoreDesignImageService`
4. Ejecutar tests para verificar que todo funciona

**Tiempo estimado:** 1-2 horas

---

### 2. Organización de Vistas (Pendiente - Nueva fase)

**Situación actual:**
- Las vistas están en estructura plana: `app/Features/TenantAdmin/Views/`
- No hay separación entre vistas Core y vistas de verticales

**Estructura objetivo:**
```
app/Features/TenantAdmin/Views/
├── core/                          # Vistas compartidas por todos los verticales
│   ├── announcements/
│   ├── auth/
│   ├── bank-accounts/
│   ├── billing/
│   ├── business-profile/
│   ├── categories/
│   ├── coupons/
│   ├── dashboard.blade.php
│   ├── locations/
│   ├── master-key/
│   ├── orders/
│   ├── payment-methods/
│   ├── profile/
│   ├── products/
│   ├── shipping-methods/
│   ├── simple-shipping/
│   ├── sliders/
│   ├── store-design/
│   ├── tickets/
│   ├── variables/
│   └── whatsapp-notifications/
│
└── verticals/                      # Vistas específicas por vertical
    ├── restaurant/
    │   ├── reservations/          # Reservas de mesas
    │   └── dine-in/                # Consumo en local
    │
    └── hotel/
        ├── reservations/           # Reservas de hotel
        ├── room-types/             # Tipos de habitación
        ├── rooms/                  # Habitaciones
        └── settings.blade.php     # Configuración de hotel
```

**Vistas a mover:**

**Core (compartidas):**
- `announcements/` → `core/announcements/`
- `auth/` → `core/auth/`
- `bank-accounts/` → `core/bank-accounts/`
- `billing/` → `core/billing/`
- `business-profile/` → `core/business-profile/`
- `categories/` → `core/categories/`
- `coupons/` → `core/coupons/`
- `dashboard.blade.php` → `core/dashboard.blade.php`
- `locations/` → `core/locations/`
- `master-key/` → `core/master-key/`
- `orders/` → `core/orders/`
- `payment-methods/` → `core/payment-methods/`
- `profile/` → `core/profile/`
- `products/` → `core/products/`
- `shipping-methods/` → `core/shipping-methods/`
- `simple-shipping/` → `core/simple-shipping/`
- `sliders/` → `core/sliders/`
- `store-design/` → `core/store-design/`
- `tickets/` → `core/tickets/`
- `variables/` → `core/variables/`
- `whatsapp-notifications/` → `core/whatsapp-notifications/`

**Restaurant:**
- `reservations/` → `verticals/restaurant/reservations/` (Reserva de mesas)
- `dine-in/` → `verticals/restaurant/dine-in/` (Consumo en el local)
- Nota: Carrito y Checkout son funcionalidades específicas de Restaurant pero están en el módulo Tenant (frontend), no en TenantAdmin

**Hotel:**
- `hotel/reservations/` → `verticals/hotel/reservations/` (Reservas de hotel)
- `hotel/room-types/` → `verticals/hotel/room-types/` (Tipos de habitación)
- `hotel/rooms/` → `verticals/hotel/rooms/` (Habitaciones)
- `hotel/settings.blade.php` → `verticals/hotel/settings.blade.php` (Configuración)
- Nota: Carrito, Checkout, Reserva de mesas y Consumo en local son funcionalidades específicas de Hotel pero están en el módulo Tenant (frontend), no en TenantAdmin

**Tareas:**
1. Crear estructura de carpetas `Views/core/` y `Views/verticals/`
2. Mover todas las vistas Core a `Views/core/`
3. Mover vistas de Restaurant a `Views/verticals/restaurant/`
4. Mover vistas de Hotel a `Views/verticals/hotel/`
5. Actualizar paths en controladores:
   - Cambiar `return view('tenant-admin::categories.index')` a `return view('tenant-admin::core.categories.index')`
   - Cambiar `return view('tenant-admin::reservations.index')` a `return view('tenant-admin::verticals.restaurant.reservations.index')`
   - Cambiar `return view('tenant-admin::hotel.reservations.index')` a `return view('tenant-admin::verticals.hotel.reservations.index')`
6. Verificar que todas las vistas funcionan correctamente
7. Ejecutar tests

**Tiempo estimado:** 3-4 horas

**⚠️ IMPORTANTE:** Esta es una tarea grande que requiere actualizar muchos controladores. Se recomienda hacerlo en sub-fases:
- Sub-fase 2.1: Mover vistas Core (2 horas)
- Sub-fase 2.2: Mover vistas Restaurant (30 min)
- Sub-fase 2.3: Mover vistas Hotel (30 min)

---

### 3. Validación Final (Pendiente - Fase 7)

**Tareas:**
1. Ejecutar suite completa de tests:
   ```bash
   php artisan test
   php artisan test --coverage  # Si está configurado
   ```
2. Validar funcionalidad en staging:
   - Crear tienda de cada vertical (ecommerce, restaurant, hotel)
   - Verificar sidebar según vertical
   - Verificar funcionalidades específicas de cada vertical
   - Verificar funcionalidades Core compartidas
3. Checklist de validación:
   - [ ] Sidebar funciona en todos los verticales
   - [ ] Controladores Core funcionan
   - [ ] Controladores Restaurant funcionan
   - [ ] Controladores Hotel funcionan
   - [ ] Servicios Core funcionan
   - [ ] Vistas Core funcionan
   - [ ] Vistas Restaurant funcionan
   - [ ] Vistas Hotel funcionan
   - [ ] Componentes funcionan correctamente
   - [ ] No hay errores en logs
   - [ ] No hay errores en consola del navegador
   - [ ] Responsive funciona correctamente
   - [ ] Performance aceptable (no hay regresiones)
4. Documentar cambios:
   - Actualizar `REFACTORING_PLAN.md` con estado final
   - Documentar decisiones tomadas
   - Documentar problemas encontrados y soluciones
5. Preparar merge:
   ```bash
   git add .
   git commit -m "feat: refactor TenantAdmin por verticales - Completado"
   git push origin staging
   ```

**Tiempo estimado:** 2-4 horas

---

### 4. Refactorizar Vistas y Eliminar Componentes (Pendiente - Fase 8) - ÚLTIMA FASE

**Objetivo:** Trabajar cada vista para que no requiera componentes específicos de TenantAdmin, usando solo DesignSystem

**Estado:** ❌ **PENDIENTE** - Se ejecutará después de organizar todo

**⚠️ IMPORTANTE:** Esta fase se ejecuta DESPUÉS de organizar todas las vistas y validar que todo funciona.

**Situación actual:**
- Solo existe `Views/components/Core/header-preview.blade.php`
- Algunos componentes pueden estar duplicados con DesignSystem
- Vistas pueden estar usando componentes específicos de TenantAdmin

**Tareas:**

1. **Auditar componentes específicos de TenantAdmin:**
   ```bash
   # Buscar uso de componentes
   grep -r "color-picker\|image-uploader\|header-preview" app/Features/TenantAdmin/Views/
   ```
   - Identificar qué componentes se usan realmente
   - Verificar si pueden reemplazarse por DesignSystem
   - Documentar componentes que deben mantenerse (si los hay)

2. **Refactorizar vistas una por una:**
   - Reemplazar componentes específicos por componentes del DesignSystem
   - Eliminar dependencias de componentes personalizados
   - Usar solo componentes estándar del DesignSystem
   - Verificar que el diseño se mantiene igual o mejor

3. **Eliminar componentes no usados:**
   - Eliminar componentes que ya no se usan
   - Limpiar estructura de carpetas de componentes
   - Verificar que no hay referencias rotas

4. **Testing exhaustivo:**
   ```bash
   # Probar cada vista refactorizada
   # Verificar que no hay errores
   # Verificar que el diseño se mantiene
   ```

**✅ Criterio de éxito:**
- [ ] Todas las vistas refactorizadas
- [ ] Componentes específicos eliminados o migrados a DesignSystem
- [ ] No hay dependencias de componentes personalizados
- [ ] Todas las vistas funcionan correctamente
- [ ] Diseño se mantiene igual o mejor
- [ ] Tests pasando

**Tiempo estimado:** 4-6 horas

**Nota:** Esta fase se ejecutará después de completar todas las fases anteriores y validar que todo funciona correctamente.

---

## 📊 Resumen de Pendientes

| Tarea | Estado | Tiempo Estimado | Prioridad | Fase |
|-------|--------|-----------------|-----------|------|
| Servicios Core | ❌ Pendiente | 1-2 horas | **ALTA** ⚠️ | Fase 5 |
| Organización de Vistas | ❌ Pendiente | 3-4 horas | **ALTA** ⚠️ | Fase 6 |
| Validación Final | ❌ Pendiente | 2-4 horas | Alta | Fase 7 |
| Refactorizar Vistas/Componentes | ❌ Pendiente | 4-6 horas | Media (al final) | Fase 8 |

**Total estimado:** 10-16 horas

---

## 🚀 Plan de Ejecución Recomendado

### Orden sugerido (actualizado):

1. **Fase 5: Servicios Core** (1-2 horas) - **PRIMERA PRIORIDAD**
   - Más rápido y menos riesgo
   - Impacta directamente a controladores ya movidos
   - Bloquea actualización de imports en controladores
   - Facilita el trabajo posterior

2. **Fase 6: Organización de Vistas** (3-4 horas) - **SEGUNDA PRIORIDAD**
   - Tarea más grande pero necesaria
   - Completar la estructura objetivo
   - Hacer en sub-fases para facilitar testing:
     - Sub-fase 6.1: Mover vistas Core (2 horas)
     - Sub-fase 6.2: Mover vistas Restaurant (30 min)
     - Sub-fase 6.3: Mover vistas Hotel (30 min)

3. **Fase 7: Validación Final** (2-4 horas)
   - Testing exhaustivo
   - Documentación
   - Preparación para merge

4. **Fase 8: Refactorizar Vistas y Eliminar Componentes** (4-6 horas) - **ÚLTIMA FASE**
   - ⚠️ **IMPORTANTE:** Se ejecuta DESPUÉS de organizar todo
   - Trabajar cada vista para usar solo DesignSystem
   - Eliminar componentes específicos de TenantAdmin
   - Código más limpio y mantenible

---

## ⚠️ Notas Importantes

### Sobre la organización de vistas

- **Impacto:** Esta tarea requiere actualizar muchos controladores (todos los que retornan vistas)
- **Riesgo:** Medio - Puede romper vistas si no se actualizan correctamente los paths
- **Recomendación:** Hacer en sub-fases y probar después de cada sub-fase

### Sobre los servicios

- **Impacto:** Bajo - Solo afecta imports en controladores
- **Riesgo:** Bajo - Los controladores ya están organizados, solo falta mover servicios
- **Recomendación:** Hacer primero porque es rápido y necesario

### Sobre componentes

- **Impacto:** Bajo - Solo afecta componentes específicos de TenantAdmin
- **Riesgo:** Bajo - Mayormente auditoría y limpieza
- **Recomendación:** Hacer después de vistas para tener contexto completo

---

## ✅ Checklist de Validación

Después de cada tarea:

- [ ] Archivos movidos correctamente
- [ ] Namespaces/paths actualizados
- [ ] Imports actualizados
- [ ] Tests pasando (`php artisan test`)
- [ ] Sin errores en logs
- [ ] Funcionalidad verificada manualmente
- [ ] Commit realizado con mensaje descriptivo

---

**Fecha de creación:** 2024  
**Versión:** 1.0

