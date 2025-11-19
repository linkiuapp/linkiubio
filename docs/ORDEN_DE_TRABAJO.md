# Orden de Trabajo: Refactorización TenantAdmin por Verticales

**Fecha de creación:** 2024  
**Estado:** 🔄 En Progreso - Ver `PENDIENTES_REFACTORING.md` para detalles de lo que falta  
**Rama de trabajo:** Trabajar directamente en `staging` (después de pruebas en local)

---

## 📋 Resumen del Plan

Este documento detalla el orden de ejecución paso a paso para la refactorización del módulo TenantAdmin, organizando el código por verticales de negocio.

**Tiempo total estimado:** 13-19 horas  
**Tiempo restante:** 6-10 horas (Fase 7: 2-4h, Fase 8: 4-6h)  
**Enfoque:** Fase por fase, con testing después de cada fase

---

## 🎯 Distribución de Funcionalidades por Vertical

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

**Nota:** Carrito y Checkout son funcionalidades específicas de Restaurant y Hotel, pero están implementadas en el módulo Tenant (frontend), no en TenantAdmin (backend).

---

## ⚠️ Reglas de Trabajo

1. **Una fase a la vez** - No avanzar a la siguiente hasta completar y probar la actual
2. **Testing obligatorio** - Ejecutar tests después de cada fase
3. **Commits pequeños** - Un commit por fase o sub-fase
4. **Rollback fácil** - Cada fase debe poder revertirse independientemente

---

## 🚀 Fases de Trabajo

### Fase 0: Preparación Base (1-2 horas)

**Objetivo:** Crear la infraestructura necesaria sin afectar código existente

#### Tareas:

1. **Verificar que estamos en staging:**
   ```bash
   git checkout staging
   git pull origin staging
   ```
   **Nota:** Todo el trabajo se hace primero en local, luego se sube a staging para pruebas.

2. **Crear archivo de configuración `config/verticals.php`:**
   - Mapeo vertical → features
   - Configuración de sidebar por vertical
   - Features específicos de cada vertical

3. **Auditar componentes Blade:**
   - Identificar componentes usados vs no usados
   - Documentar componentes duplicados
   - Listar componentes específicos de TenantAdmin

4. **Ejecutar tests actuales:**
   ```bash
   php artisan test
   ```
   - Documentar cobertura actual
   - Anotar tests que fallan (si los hay)

**✅ Criterio de éxito:**
- [x] Estamos en staging (o local para pruebas)
- [x] `config/verticals.php` creado y validado ✅ **COMPLETADO**
- [x] Auditoría de componentes completada ✅ **COMPLETADO**
- [x] Tests pasando (baseline establecido) ✅ **COMPLETADO**
- [x] Sin cambios en código existente ✅ **COMPLETADO**

---

### Fase 1: Sistema de Categorías de Negocios (2-3 horas)

**Objetivo:** Implementar sistema de verticales en categorías de negocio

#### Tareas:

1. **Migration:**
   ```bash
   php artisan make:migration add_vertical_to_business_categories_table
   ```
   - Agregar campo `vertical` (nullable primero)
   - Agregar índice para búsquedas rápidas

2. **Actualizar Model:**
   - Agregar `vertical` al `fillable` en `BusinessCategory`
   - Agregar cast si es necesario
   - Agregar scope para filtrar por vertical

3. **Actualizar Controller:**
   - Agregar campo `vertical` al formulario de creación/edición
   - Implementar asignación automática de features según vertical
   - Mantener compatibilidad temporal con categorías sin vertical

4. **Crear comando de migración:**
   ```bash
   php artisan make:command BusinessCategoriesSuggestVerticals
   ```
   - Analizar features actuales
   - Sugerir vertical según mapeo
   - Generar reporte

5. **Crear panel de revisión:**
   - Nueva ruta: `/superlinkiu/business-categories/migrate-verticals`
   - Vista con lista de categorías sin vertical
   - Formulario para asignar vertical masivamente

6. **Testing:**
   - Crear nueva categoría con vertical
   - Verificar asignación automática de features
   - Verificar que sidebar se habilita correctamente

**✅ Criterio de éxito:**
- [x] Migration ejecutada ✅ **COMPLETADO**
- [x] Model actualizado ✅ **COMPLETADO**
- [x] Controller actualizado ✅ **COMPLETADO**
- [x] Comando de sugerencia funcionando ✅ **COMPLETADO**
- [x] Panel de revisión funcionando ✅ **COMPLETADO**
- [x] Todas las categorías tienen vertical asignado ✅ **COMPLETADO**
- [x] Features asignados automáticamente ✅ **COMPLETADO**
- [x] Sidebar funciona según vertical ✅ **COMPLETADO**
- [x] Tests pasando ✅ **COMPLETADO**

---

### Fase 2: Refactorización del Sidebar (3-4 horas)

**Objetivo:** Organizar sidebar en nueva estructura, con componentes reutilizables y JS organizado

#### Tareas:

1. **Crear nueva estructura de carpetas:**
   ```
   app/Shared/Views/Components/Sidebar/
   ├── Core/
   │   ├── SidebarBase.blade.php          # Componente base reutilizable
   │   ├── SidebarItem.blade.php          # Item individual del sidebar
   │   ├── SidebarSection.blade.php       # Sección del sidebar
   │   └── SidebarFooter.blade.php        # Footer del sidebar
   ├── TenantAdmin/
   │   ├── TenantSidebar.blade.php        # Sidebar específico TenantAdmin
   │   └── TenantSidebarOnboarding.blade.php
   └── SuperAdmin/
       └── AdminSidebar.blade.php         # Sidebar específico SuperAdmin
   ```

2. **Refactorizar componentes del sidebar:**
   - Extraer lógica común a `SidebarBase`
   - Crear componentes reutilizables (`SidebarItem`, `SidebarSection`)
   - Separar lógica específica de TenantAdmin y SuperAdmin
   - Usar componentes solo si aplican según vertical

3. **Organizar JavaScript del sidebar:**
   ```
   resources/js/
   ├── sidebar/
   │   ├── sidebar-base.js               # Funcionalidad base
   │   ├── sidebar-tenant-admin.js       # Funcionalidad específica TenantAdmin
   │   ├── sidebar-super-admin.js        # Funcionalidad específica SuperAdmin
   │   └── sidebar-store.js              # Alpine store para estado del sidebar
   └── sidebar.js                        # Entry point (importa según contexto)
   ```

4. **Implementar lógica condicional:**
   - Sidebar de TenantAdmin: Mostrar items según vertical de la tienda
   - Sidebar de SuperAdmin: Mostrar items según permisos
   - Usar `featureEnabled()` para mostrar/ocultar items

5. **Actualizar vistas que usan sidebar:**
   - `app/Shared/Views/Components/layouts/tenant-admin.blade.php`
   - `app/Shared/Views/Components/layouts/admin.blade.php`
   - Actualizar imports de componentes

6. **Testing exhaustivo:**
   ```bash
   # Probar en diferentes contextos:
   # 1. TenantAdmin con vertical restaurant
   # 2. TenantAdmin con vertical hotel
   # 3. TenantAdmin con vertical ecommerce
   # 4. SuperAdmin
   ```
   - Verificar que sidebar se muestra correctamente
   - Verificar que items se muestran según vertical
   - Verificar que JS funciona correctamente
   - Verificar que no hay errores en consola
   - Verificar responsive (mobile/desktop)
   - Verificar persistencia de estado (minificado/expandido)

**✅ Criterio de éxito:**
- [x] Nueva estructura de carpetas creada ✅ **COMPLETADO**
- [x] Componentes refactorizados y reutilizables ✅ **COMPLETADO**
- [x] JavaScript organizado y modular ✅ **COMPLETADO**
- [x] Sidebar funciona en TenantAdmin (todos los verticales) ✅ **COMPLETADO**
- [x] Sidebar funciona en SuperAdmin ✅ **COMPLETADO**
- [x] Items se muestran solo si aplican ✅ **COMPLETADO**
- [x] No hay errores en consola ✅ **COMPLETADO**
- [x] Responsive funciona correctamente ✅ **COMPLETADO**
- [x] Estado del sidebar persiste correctamente ✅ **COMPLETADO**
- [x] Tests pasando (si hay tests del sidebar) ✅ **COMPLETADO**

**⚠️ IMPORTANTE:** No avanzar a la siguiente fase hasta que el sidebar esté completamente funcional y probado.

---

### Fase 3: Ordenar Carpetas - Core (3-4 horas)

**Objetivo:** Mover controladores y servicios Core a nueva estructura

**Estado:** ✅ **COMPLETADO** - Controladores y servicios movidos

#### Tareas:

1. ✅ **Crear estructura de carpetas:** ✅ **COMPLETADO**
   ```
   app/Features/TenantAdmin/
   ├── Controllers/
   │   └── Core/                    ✅ Creado
   ├── Services/
   │   └── Core/                    ✅ Creado (vacío)
   └── Views/
       └── core/                    ⚠️ Pendiente
   ```

2. ✅ **Mover controladores Core (21 archivos):** ✅ **COMPLETADO**
   - DashboardController ✅
   - OrderController ✅
   - ProductController ✅
   - CategoryController ✅
   - VariableController ✅
   - CouponController ✅
   - SliderController ✅
   - PaymentMethodController ✅
   - LocationController ✅
   - StoreDesignController ✅
   - TicketController ✅
   - AnnouncementController ✅
   - ProfileController ✅
   - MasterKeyController ✅
   - BusinessProfileController ✅
   - BillingController ✅
   - InvoiceController ✅
   - AuthController ✅
   - PreviewController ✅
   - PasswordResetController ✅
   - ShippingMethodController ✅
   - SimpleShippingController ✅
   - BankAccountController ✅

3. ✅ **Mover servicios Core (7 archivos):** ✅ **COMPLETADO**
   - LocationService
   - PaymentMethodService
   - BankAccountService
   - ProductImageService
   - ProductVariantService
   - SliderImageService
   - StoreDesignImageService

4. ✅ **Actualizar namespaces:** ✅ **COMPLETADO**
   - En cada archivo movido, cambiar namespace:
     ```php
     // Antes
     namespace App\Features\TenantAdmin\Controllers;
     
     // Después
     namespace App\Features\TenantAdmin\Controllers\Core;
     ```

5. ✅ **Actualizar imports en rutas:** ✅ **COMPLETADO**
   - `app/Features/TenantAdmin/Routes/web.php`
   - Actualizar todos los `use` statements

6. ✅ **Actualizar imports en controladores:** ✅ **COMPLETADO**
   - Controladores que importan servicios movidos
   - Actualizar paths de servicios

7. ✅ **Testing:** ✅ **COMPLETADO** (parcialmente)
   ```bash
   php artisan test
   php artisan route:list  # Verificar que rutas funcionan
   ```

**✅ Criterio de éxito:**
- [x] Estructura de carpetas creada ✅
- [x] Todos los controladores Core movidos ✅
- [x] Todos los servicios Core movidos ✅ **COMPLETADO**
- [x] Namespaces actualizados ✅
- [x] Imports en rutas actualizados ✅
- [x] Imports en controladores actualizados ✅ **COMPLETADO**
- [x] Rutas funcionando correctamente ✅
- [x] Tests pasando ✅

---

### Fase 4: Ordenar Carpetas - Verticals (3-4 horas)

**Objetivo:** Mover controladores específicos de verticales

**Estado:** ✅ **COMPLETADO** - Controladores movidos, vistas pendientes

#### Tareas:

1. ✅ **Crear estructura de carpetas:** ✅ **COMPLETADO**
   ```
   app/Features/TenantAdmin/
   ├── Controllers/
   │   └── Verticals/
   │       ├── Restaurant/         ✅ Creado
   │       ├── Hotel/              ✅ Creado
   │       ├── Ecommerce/          ✅ Creado (con README.md)
   │       └── Dropshipping/       ✅ Creado (vacío)
   └── Views/
       └── verticals/              ⚠️ Pendiente
           ├── restaurant/
           └── hotel/
   ```

2. ✅ **Mover controladores Restaurant (3 archivos):** ✅ **COMPLETADO**
   - TableReservationController ✅
   - TableController ✅
   - DineInSettingController ✅
   
   **Pasos:**
   - ✅ Mover archivos a `Controllers/Verticals/Restaurant/`
   - ✅ Actualizar namespaces a `App\Features\TenantAdmin\Controllers\Verticals\Restaurant`
   - ✅ Actualizar imports en rutas
   - ✅ Ejecutar tests

3. ✅ **Mover controladores Hotel (3 archivos):** ✅ **COMPLETADO**
   - HotelReservationController ✅
   - RoomController ✅
   - RoomTypeController ✅
   
   **Pasos:**
   - ✅ Mover archivos a `Controllers/Verticals/Hotel/`
   - ✅ Actualizar namespaces a `App\Features\TenantAdmin\Controllers\Verticals\Hotel`
   - ✅ Actualizar imports en rutas
   - ✅ Ejecutar tests

4. ✅ **Testing:** ✅ **COMPLETADO**
   ```bash
   php artisan test
   # Probar funcionalidades específicas de cada vertical
   ```

**✅ Criterio de éxito:**
- [x] Estructura de carpetas creada ✅
- [x] Controladores Restaurant movidos ✅
- [x] Controladores Hotel movidos ✅
- [x] Namespaces actualizados ✅
- [x] Imports en rutas actualizados ✅
- [x] Funcionalidades de Restaurant funcionando ✅
- [x] Funcionalidades de Hotel funcionando ✅
- [x] Tests pasando ✅

**⚠️ Nota:** Las vistas de verticales aún están pendientes de organizar (ver Fase 6).

---

### Fase 5: Mover Servicios Core (1-2 horas) - PRIORIDAD ALTA

**Objetivo:** Completar la Fase 3 moviendo servicios Core a nueva estructura

**Estado:** ✅ **COMPLETADO** - Servicios movidos e imports actualizados

#### Tareas:

1. **Mover servicios Core (7 archivos):**
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

2. **Actualizar namespaces:**
   - En cada archivo movido, cambiar namespace:
     ```php
     // Antes
     namespace App\Features\TenantAdmin\Services;
     
     // Después
     namespace App\Features\TenantAdmin\Services\Core;
     ```

3. **Actualizar imports en controladores:**
   - `ProductController.php` → Actualizar import de `ProductImageService` y `ProductVariantService`
   - `SliderController.php` → Actualizar import de `SliderImageService`
   - `LocationController.php` → Actualizar import de `LocationService`
   - `PaymentMethodController.php` → Actualizar import de `PaymentMethodService`
   - `BankAccountController.php` → Actualizar import de `BankAccountService`
   - `StoreDesignController.php` → Actualizar import de `StoreDesignImageService`

4. **Testing:**
   ```bash
   php artisan test
   php artisan route:list  # Verificar que rutas funcionan
   ```

**✅ Criterio de éxito:**
- [x] Todos los servicios Core movidos ✅ **COMPLETADO**
- [x] Namespaces actualizados ✅ **COMPLETADO**
- [x] Imports en controladores actualizados ✅ **COMPLETADO**
- [x] Rutas funcionando correctamente ✅ **COMPLETADO**
- [x] Tests pasando ✅ **COMPLETADO**

**⚠️ IMPORTANTE:** Esta fase debe completarse antes de avanzar a organizar vistas.

---

### Fase 6: Organizar Vistas (3-4 horas) - PRIORIDAD ALTA

**Objetivo:** Organizar vistas en estructura Core y Verticals

**Estado:** ❌ **PENDIENTE**

#### Tareas:

1. **Crear estructura de carpetas:**
   ```
   app/Features/TenantAdmin/Views/
   ├── core/                          # Vistas compartidas
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
   └── verticals/                      # Vistas específicas
       ├── restaurant/
       │   ├── reservations/          # Reserva de mesas
       │   └── dine-in/                # Consumo en local
       └── hotel/
           ├── reservations/           # Reservas de hotel
           ├── room-types/             # Tipos de habitación
           ├── rooms/                  # Habitaciones
           └── settings.blade.php     # Configuración
   ```

2. **Mover vistas Core (18 carpetas/archivos):**
   - Mover todas las vistas compartidas a `Views/core/`
   - Actualizar paths en controladores Core

3. **Mover vistas Restaurant:**
   - `reservations/` → `verticals/restaurant/reservations/`
   - `dine-in/` → `verticals/restaurant/dine-in/`
   - Actualizar paths en controladores Restaurant

4. **Mover vistas Hotel:**
   - `hotel/reservations/` → `verticals/hotel/reservations/`
   - `hotel/room-types/` → `verticals/hotel/room-types/`
   - `hotel/rooms/` → `verticals/hotel/rooms/`
   - `hotel/settings.blade.php` → `verticals/hotel/settings.blade.php`
   - Actualizar paths en controladores Hotel

5. **Actualizar paths en controladores:**
   - Cambiar `return view('tenant-admin::categories.index')` a `return view('tenant-admin::core.categories.index')`
   - Cambiar `return view('tenant-admin::reservations.index')` a `return view('tenant-admin::verticals.restaurant.reservations.index')`
   - Cambiar `return view('tenant-admin::hotel.reservations.index')` a `return view('tenant-admin::verticals.hotel.reservations.index')`

6. **Testing:**
   ```bash
   php artisan test
   # Probar vistas de cada vertical
   ```

**✅ Criterio de éxito:**
- [x] Estructura de carpetas creada ✅ **COMPLETADO**
- [x] Vistas Core movidas ✅ **COMPLETADO**
- [x] Vistas Restaurant movidas ✅ **COMPLETADO**
- [x] Vistas Hotel movidas ✅ **COMPLETADO**
- [x] Vistas Ecommerce y Dropshipping (carpetas creadas) ✅ **COMPLETADO**
- [x] Paths en controladores actualizados ✅ **COMPLETADO**
- [x] Referencias en vistas Blade actualizadas ✅ **COMPLETADO**
- [x] Todas las vistas funcionan correctamente ✅ **COMPLETADO**
- [x] Tests pasando ✅ **COMPLETADO**

**⚠️ IMPORTANTE:** Esta es una tarea grande. Se recomienda hacer en sub-fases:
- Sub-fase 6.1: Mover vistas Core (2 horas)
- Sub-fase 6.2: Mover vistas Restaurant (30 min)
- Sub-fase 6.3: Mover vistas Hotel (30 min)

---

### Fase 7: Validación Final (2-4 horas)

**Objetivo:** Validar que todo funciona correctamente antes de merge

#### Tareas:

1. **Ejecutar suite completa de tests:**
   ```bash
   php artisan test
   php artisan test --coverage  # Si está configurado
   ```

2. **Validar funcionalidad en staging:**
   - Crear tienda de cada vertical (ecommerce, restaurant, hotel)
   - Verificar sidebar según vertical
   - Verificar funcionalidades específicas de cada vertical:
     - **Restaurant:** Reserva de mesas, Consumo en local, Carrito, Checkout
     - **Hotel:** Reserva de mesas, Consumo en local, Carrito, Checkout, Reservas de hotel, Servicio habitación
   - Verificar funcionalidades Core compartidas (18 funcionalidades)

3. **Checklist de validación:**
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

4. **Documentar cambios:**
   - Actualizar `REFACTORING_PLAN.md` con estado final
   - Documentar decisiones tomadas
   - Documentar problemas encontrados y soluciones

5. **Preparar merge:**
   ```bash
   git add .
   git commit -m "feat: refactor TenantAdmin por verticales - Fase completa"
   git push origin staging
   ```

**✅ Criterio de éxito:**
- [ ] Todos los tests pasando
- [ ] Funcionalidad validada en staging
- [ ] Checklist completo
- [ ] Documentación actualizada
- [ ] Listo para merge a staging

---

## 📝 Notas Importantes

### Sobre el Sidebar (Fase 2)

El sidebar es crítico porque:
- Se usa en TenantAdmin y SuperAdmin
- Debe mostrar items según el vertical de la tienda
- Debe ser reutilizable y mantenible
- Su JavaScript debe estar bien organizado

**No avanzar a Fase 3 hasta que el Sidebar esté completamente funcional y probado.**

### Sobre Commits

- Un commit por fase o sub-fase
- Mensajes descriptivos siguiendo Conventional Commits
- Ejemplo: `feat: refactor sidebar con componentes reutilizables`

### Sobre Testing

- Ejecutar tests después de cada fase
- Probar manualmente funcionalidades críticas
- Verificar que no hay errores en consola
- Verificar que no hay errores en logs

### Sobre Rollback

Si algo falla en una fase:
1. No avanzar a la siguiente fase
2. Revisar logs y errores
3. Corregir problemas
4. Si es necesario, hacer rollback:
   ```bash
   git reset --hard HEAD~1
   ```

---

## ✅ Checklist General

Al finalizar todas las fases:

- [ ] Todas las fases completadas
- [ ] Todos los tests pasando
- [ ] Funcionalidad validada en staging
- [ ] Documentación actualizada
- [ ] Código revisado
- [ ] Listo para merge a staging
- [ ] Listo para QA

---

---

## 📊 Estado Actual de las Fases

| Fase | Estado | Progreso | Prioridad |
|------|--------|----------|-----------|
| Fase 0: Preparación Base | ✅ Completado | 100% | - |
| Fase 1: Sistema de Categorías | ✅ Completado | 100% | - |
| Fase 2: Refactorización del Sidebar | ✅ Completado | 100% | - |
| Fase 3: Ordenar Carpetas - Core | ✅ Completado | 100% | - |
| Fase 4: Ordenar Carpetas - Verticals | ✅ Completado | 100% | - |
| **Fase 5: Mover Servicios Core** | ✅ **COMPLETADO** | 100% | - |
| **Fase 6: Organizar Vistas** | ✅ **COMPLETADO** | 100% | - |
| Fase 7: Validación Final | ❌ Pendiente | 0% | Alta |
| **Fase 8: Refactorizar Vistas/Componentes** | ❌ **PENDIENTE** | 0% | Media (al final) |

**Progreso general:** ~85% completado

**Próximos pasos:**
1. ✅ ~~Completar Fase 5: Mover Servicios Core~~ ✅ **COMPLETADO**
2. ✅ ~~Completar Fase 6: Organizar Vistas~~ ✅ **COMPLETADO**
3. ⏭️ Completar Fase 7: Validación Final
4. ⏭️ Ejecutar Fase 8: Refactorizar Vistas y Eliminar Componentes

---

## 📝 Notas Importantes

### Sobre Carrito y Checkout

- **Carrito y Checkout** son funcionalidades específicas de Restaurant y Hotel
- Están implementadas en el módulo **Tenant (frontend)**, no en TenantAdmin (backend)
- Se configuran mediante features `carrito` y `checkout` en `config/verticals.php`
- Ecommerce también usa carrito/checkout pero no como feature diferenciador

### Sobre Componentes (Fase 8 - Última)

- **Estrategia:** Dejar componentes para el final
- **Razón:** Después de organizar todo, refactorizar cada vista para usar solo DesignSystem
- **Objetivo:** Eliminar dependencias de componentes específicos de TenantAdmin
- **Beneficio:** Código más limpio, mantenible y consistente con el DesignSystem

### Sobre el Sidebar (Fase 2)

El sidebar es crítico porque:
- Se usa en TenantAdmin y SuperAdmin
- Debe mostrar items según el vertical de la tienda
- Debe ser reutilizable y mantenible
- Su JavaScript debe estar bien organizado

**✅ COMPLETADO** - No avanzar a la siguiente fase hasta que el Sidebar esté completamente funcional y probado.

### Sobre Commits

- Un commit por fase o sub-fase
- Mensajes descriptivos siguiendo Conventional Commits
- Ejemplo: `feat: refactor sidebar con componentes reutilizables`

### Sobre Testing

- Ejecutar tests después de cada fase
- Probar manualmente funcionalidades críticas
- Verificar que no hay errores en consola
- Verificar que no hay errores en logs

### Sobre Rollback

Si algo falla en una fase:
1. No avanzar a la siguiente fase
2. Revisar logs y errores
3. Corregir problemas
4. Si es necesario, hacer rollback:
   ```bash
   git reset --hard HEAD~1
   ```

---

### Fase 8: Refactorizar Vistas y Eliminar Componentes (4-6 horas) - ÚLTIMA FASE

**Objetivo:** Trabajar cada vista para que no requiera componentes específicos de TenantAdmin, usando solo DesignSystem

**Estado:** ❌ **PENDIENTE** - Se ejecutará después de organizar todo

**⚠️ IMPORTANTE:** Esta fase se ejecuta DESPUÉS de organizar todas las vistas y validar que todo funciona.

#### Tareas:

1. **Auditar componentes específicos de TenantAdmin:**
   - Identificar qué componentes se usan realmente
   - Verificar si pueden reemplazarse por DesignSystem
   - Documentar componentes que deben mantenerse (si los hay)

2. **Refactorizar vistas una por una:**
   - Reemplazar componentes específicos por componentes del DesignSystem
   - Eliminar dependencias de componentes personalizados
   - Usar solo componentes estándar del DesignSystem

3. **Eliminar componentes no usados:**
   - Eliminar componentes que ya no se usan
   - Limpiar estructura de carpetas de componentes

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

**Nota:** Esta fase se ejecutará después de completar todas las fases anteriores y validar que todo funciona correctamente.

---

**Fecha de última actualización:** 2024  
**Versión:** 2.1 (Reorganizado: Componentes al final)

