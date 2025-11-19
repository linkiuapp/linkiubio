# Prompt para Cursor: Análisis y Refactorización de TenantAdmin

Analiza la estructura actual de carpetas y archivos en `app/Features/TenantAdmin/` y compara con la siguiente estructura objetivo para organizar controladores, servicios y vistas según verticales de negocio (ecommerce, restaurant, dropshipping, hotel).

## ESTRUCTURA OBJETIVO:

```
app/Features/TenantAdmin/
├── Controllers/
│   ├── Core/                          # Compartido por TODOS los nichos
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── SettingsController.php
│   │   ├── BillingController.php
│   │   └── AnalyticsController.php
│   │
│   └── Verticals/                     # Específico por nicho
│       ├── Ecommerce/
│       │   ├── ProductController.php
│       │   ├── OrderController.php
│       │   ├── InventoryController.php
│       │   └── ShippingController.php
│       │
│       ├── Restaurant/
│       │   ├── MenuController.php
│       │   ├── TableController.php
│       │   ├── ReservationController.php
│       │   └── KitchenController.php
│       │
│       ├── Dropshipping/
│       │   ├── SupplierController.php
│       │   ├── ProductSyncController.php
│       │   └── AutomationController.php
│       │
│       └── Hotel/
│           ├── RoomController.php
│           ├── BookingController.php
│           └── HousekeepingController.php
│
├── Services/
│   ├── Core/                          # Servicios compartidos
│   │   ├── DashboardService.php
│   │   └── AnalyticsService.php
│   │
│   └── Verticals/                     # Servicios por nicho
│       ├── Ecommerce/
│       │   ├── ProductService.php
│       │   └── OrderService.php
│       ├── Restaurant/
│       │   ├── MenuService.php
│       │   └── ReservationService.php
│       ├── Dropshipping/
│       │   └── SupplierService.php
│       └── Hotel/
│           └── BookingService.php
│
├── Views/
│   ├── layouts/
│   │   └── app.blade.php              # Layout base con sidebar dinámico
│   │
│   ├── core/                          # Vistas compartidas
│   │   ├── dashboard/
│   │   ├── users/
│   │   ├── settings/
│   │   └── billing/
│   │
│   └── verticals/                     # Vistas por nicho
│       ├── ecommerce/
│       │   ├── products/
│       │   ├── orders/
│       │   └── inventory/
│       │
│       ├── restaurant/
│       │   ├── menu/
│       │   ├── tables/
│       │   └── reservations/
│       │
│       ├── dropshipping/
│       │   ├── suppliers/
│       │   └── products/
│       │
│       └── hotel/
│           ├── rooms/
│           └── bookings/
│
├── Routes/
│   └── web.php                        # Rutas dinámicas por vertical
│
├── Policies/
│   ├── Core/
│   └── Verticals/
│
└── TenantAdminServiceProvider.php
```

## TU TAREA:

### 1. ANALIZAR ESTRUCTURA ACTUAL:
   - Lista todos los controladores, servicios y vistas actuales en TenantAdmin
   - Identifica qué archivos son "Core" (compartidos por todos los verticales)
   - Identifica qué archivos son específicos de verticales (ecommerce, restaurant, hotel, dropshipping)
   - Detecta archivos que no encajan en ninguna categoría
   - Identifica archivos que podrían ser ambiguos (usados por algunos pero no todos los verticales)

### 2. ANALIZAR FUNCIONALIDADES COMPARTIDAS:
   
   Para cada controlador/servicio actual, determina:
   
   **a) ¿Es usado por todos los verticales?**
   - Si SÍ → Candidato a Core
   - Si NO → Candidato a Vertical-specific
   - Si ALGUNOS → Requiere análisis adicional
   
   **b) Funcionalidades que actualmente se duplican:**
   - Lista funcionalidades que se repiten en diferentes controladores
   - Ejemplo: "Gestión de pedidos" puede estar en Ecommerce, Restaurant y Hotel
   - Sugiere si deben:
     - Centralizarse en Core con adaptaciones
     - Mantenerse separadas por tener lógica muy diferente
     - Usar herencia o traits para compartir lógica común
   
   **c) Funcionalidades que podrían compartirse:**
   - Identifica patrones comunes entre verticales
   - Ejemplo: Todos manejan "items" (productos, platos, habitaciones)
   - Sugiere abstracciones posibles

### 3. GENERAR PLAN DE REFACTORIZACIÓN:

Crea un documento `REFACTORING_PLAN.md` con:

#### Sección A: ESTRUCTURA ACTUAL
```
- Árbol de carpetas actual completo
- Conteo de archivos por tipo (Controllers, Services, Views)
- Lista de archivos por categoría
```

#### Sección B: ANÁLISIS DE FUNCIONALIDADES COMPARTIDAS

Tabla:
| Funcionalidad | Verticales que la usan | Estado Actual | Recomendación | Razón |
|---------------|------------------------|---------------|---------------|-------|
| Gestión de usuarios | Todos | Centralizada | ✅ Mantener en Core | Es genérica |
| Gestión de pedidos | E-commerce, Restaurant, Hotel | Distribuida | 🔄 Evaluar abstracción | Lógica similar pero no idéntica |
| Gestión de productos | E-commerce, Dropshipping | Distribuida | ✅ Mantener separada | Lógica muy diferente |
| ... | ... | ... | ... | ... |

**Leyenda:**
- ✅ Mantener como está
- 🔄 Requiere refactorización
- ⚠️ Posible problema
- 💡 Oportunidad de mejora

#### Sección C: ARCHIVOS A MOVER

Tabla:
| Archivo Actual | Ubicación Nueva | Categoría | Impacto | Dependencias Afectadas | Prioridad |
|----------------|-----------------|-----------|---------|------------------------|-----------|
| ProductController.php | Controllers/Verticals/Ecommerce/ | Vertical-Specific | Medio | 5 archivos | Alta |
| ... | ... | ... | ... | ... | ... |

**Niveles de Impacto:**
- **Bajo:** Pocas dependencias, cambio simple
- **Medio:** Varias dependencias, requiere actualizar imports
- **Alto:** Muchas dependencias, podría afectar funcionalidad

#### Sección D: ARCHIVOS A CREAR

Lista de archivos nuevos necesarios:
```
Controladores nuevos:
- Controllers/Verticals/Dropshipping/SupplierController.php (pendiente de implementación)
- Controllers/Verticals/Hotel/HousekeepingController.php (pendiente de implementación)

Servicios nuevos:
- Services/Core/SharedLogicService.php (para lógica común entre verticales)

Vistas nuevas:
- Views/verticals/dropshipping/ (estructura completa)
```

#### Sección E: SUGERENCIAS DE ABSTRACCIONES

Para cada patrón identificado:

**Ejemplo 1: Gestión de Items**
```
Contexto: Todos los verticales manejan "items" (productos, platos, habitaciones)

Propuesta:
- Crear Trait: ItemManagementTrait
- Ubicación: app/Features/TenantAdmin/Traits/
- Métodos comunes: index(), create(), store(), edit(), update(), destroy()
- Cada vertical implementa: getItemModel(), getItemValidationRules()

Verticales que se benefician: Todos

Ventajas:
- Reduce duplicación de código
- Mantiene consistencia en la interfaz
- Facilita agregar nuevos verticales

Desventajas:
- Requiere refactorización de controladores existentes
- Puede aumentar complejidad inicial

Recomendación: ✅ IMPLEMENTAR (beneficio > costo)
```

#### Sección F: NAMESPACE CHANGES

Lista completa de cambios de namespace:
```php
// === CONTROLADORES ===

// Antes
App\Features\TenantAdmin\Controllers\ProductController

// Después  
App\Features\TenantAdmin\Controllers\Verticals\Ecommerce\ProductController

---

// Antes
App\Features\TenantAdmin\Controllers\DashboardController

// Después
App\Features\TenantAdmin\Controllers\Core\DashboardController

// === SERVICIOS ===

// Antes
App\Features\TenantAdmin\Services\ProductService

// Después
App\Features\TenantAdmin\Services\Verticals\Ecommerce\ProductService

// ... (lista completa)
```

#### Sección G: RUTAS A ACTUALIZAR

```php
// Archivo: app/Features/TenantAdmin/Routes/web.php

Rutas que necesitan actualización:

1. Productos (Ecommerce):
   Antes: use App\Features\TenantAdmin\Controllers\ProductController;
   Después: use App\Features\TenantAdmin\Controllers\Verticals\Ecommerce\ProductController;
   Líneas afectadas: 45-67

2. Dashboard:
   Antes: use App\Features\TenantAdmin\Controllers\DashboardController;
   Después: use App\Features\TenantAdmin\Controllers\Core\DashboardController;
   Líneas afectadas: 12-15

... (lista completa con números de línea)
```

#### Sección H: IMPORTS A ACTUALIZAR

```
Archivos que importan controladores/servicios movidos:

1. app/Features/TenantAdmin/Controllers/OrderController.php
   - Importa: ProductService
   - Línea: 8
   - Nuevo import: use App\Features\TenantAdmin\Services\Verticals\Ecommerce\ProductService;

2. tests/Feature/TenantAdmin/ProductTest.php
   - Importa: ProductController
   - Línea: 12
   - Nuevo import: use App\Features\TenantAdmin\Controllers\Verticals\Ecommerce\ProductController;

... (lista exhaustiva)

Total de archivos a actualizar: XX
Total de líneas afectadas: XXX
```

#### Sección I: POSIBLES CONFLICTOS Y PROBLEMAS

Identifica:

**1. Archivos con nombres duplicados:**
```
⚠️ CONFLICTO DETECTADO:
- OrderController.php existe en lógica de Ecommerce
- OrderController.php existe en lógica de Restaurant

Solución propuesta:
- Renombrar a EcommerceOrderController y RestaurantOrderController
- O mantener en carpetas separadas con namespaces distintos (RECOMENDADO)
```

**2. Dependencias circulares:**
```
⚠️ DEPENDENCIA CIRCULAR:
- ProductService depende de InventoryService
- InventoryService depende de ProductService

Solución propuesta:
- Extraer lógica compartida a SharedInventoryLogic
- Inyectar como dependencia en ambos
```

**3. Referencias hardcoded:**
```
⚠️ HARDCODED REFERENCE:
Archivo: app/Helpers/helpers.php
Línea: 245
Código: return app('App\Features\TenantAdmin\Controllers\ProductController');

Impacto: ALTO - Se romperá después del cambio de namespace

Solución:
- Usar Service Container con bind()
- O actualizar referencia al nuevo namespace
```

**4. Tests que pueden fallar:**
```
⚠️ TESTS AFECTADOS:
- tests/Feature/TenantAdmin/ProductTest.php
- tests/Unit/Services/ProductServiceTest.php
- tests/Integration/EcommerceFlowTest.php

Total: 15 archivos de test necesitan actualización
```

#### Sección J: FUNCIONALIDADES QUE COMPARTEN MÚLTIPLES VERTICALES

Tabla detallada:

| Funcionalidad | Ecommerce | Restaurant | Dropshipping | Hotel | Recomendación |
|---------------|-----------|------------|--------------|-------|---------------|
| Analytics básico | ✅ | ✅ | ✅ | ✅ | Core - AbstractAnalyticsService |
| Gestión de pedidos | ✅ | ✅ | ✅ | ✅ | Core con trait - OrderManagementTrait |
| Gestión de inventario | ✅ | ✅ | ⚠️ | ❌ | Shared entre E-commerce y Restaurant |
| Cupones/Descuentos | ✅ | ✅ | ✅ | ⚠️ | Core - CouponService |
| Notificaciones | ✅ | ✅ | ✅ | ✅ | Core - Ya implementado ✅ |
| Reportes | ✅ | ✅ | ✅ | ✅ | Core - ReportService |
| Gestión de clientes | ✅ | ✅ | ✅ | ✅ | Core - CustomerService |
| Gestión de proveedores | ⚠️ | ✅ | ✅ | ⚠️ | Vertical-specific (lógica diferente) |
| Reservas | ❌ | ✅ | ❌ | ✅ | Shared entre Restaurant y Hotel |
| Catálogo de productos | ✅ | ⚠️ | ✅ | ❌ | Shared entre E-commerce y Dropshipping |

**Leyenda:**
- ✅ Usa esta funcionalidad completamente
- ⚠️ Usa parcialmente o con adaptaciones
- ❌ No usa esta funcionalidad

**Recomendaciones específicas:**

1. **Analytics:** Crear `Core/AbstractAnalyticsService` con métodos comunes y cada vertical extiende con métricas específicas

2. **Gestión de pedidos:** Implementar `OrderManagementTrait` en Core con métodos base, cada vertical puede sobrescribir métodos específicos

3. **Reservas:** Crear `Shared/ReservationService` que tanto Restaurant como Hotel pueden usar, con configuración específica por vertical

4. **Catálogo:** Evaluar si crear abstracción o mantener separado (lógica de Dropshipping es muy diferente a Ecommerce)

#### Sección K: ORDEN DE EJECUCIÓN RECOMENDADO

**Fase 1 - Preparación (Sin riesgo):**
1. Crear estructura de carpetas nueva (vacía)
2. Crear archivos de configuración (`config/verticals.php`)
3. Crear traits y abstracciones sugeridas
4. Ejecutar tests actuales y documentar cobertura

**Fase 2 - Migración de Core (Bajo riesgo):**
1. Mover controladores Core (Dashboard, Users, Settings, Billing)
2. Actualizar namespaces en Core
3. Actualizar rutas de Core
4. Ejecutar tests y verificar

**Fase 3 - Migración de Ecommerce (Medio riesgo):**
1. Mover controladores de Ecommerce (es el vertical más completo)
2. Actualizar servicios de Ecommerce
3. Actualizar vistas de Ecommerce
4. Actualizar rutas
5. Ejecutar tests específicos de Ecommerce

**Fase 4 - Migración de Restaurant (Medio riesgo):**
1. Similar a Fase 3 pero con Restaurant
2. Implementar abstracciones compartidas con Ecommerce si aplica

**Fase 5 - Migración de Hotel (Bajo-Medio riesgo):**
1. Similar a fases anteriores
2. Implementar abstracciones compartidas con Restaurant

**Fase 6 - Implementación de Dropshipping (Bajo riesgo):**
1. Crear estructura desde cero siguiendo el patrón
2. Implementar controladores y servicios nuevos

**Fase 7 - Validación Final:**
1. Ejecutar suite completa de tests
2. Validar funcionalidad en ambiente de staging
3. Documentar cambios
4. Actualizar documentación técnica

**Estimación de tiempo por fase:**
- Fase 1: 2-4 horas
- Fase 2: 4-6 horas
- Fase 3: 8-12 horas
- Fase 4: 6-8 horas
- Fase 5: 6-8 horas
- Fase 6: 8-12 horas
- Fase 7: 4-6 horas

**Total estimado: 38-56 horas de trabajo**

#### Sección L: PRIORIZACIÓN DE CAMBIOS

**🔴 CRÍTICO (Hacer primero):**
- Crear estructura de carpetas
- Mover Core (funcionalidad usada por todos)
- Actualizar rutas principales
- Validar que nada se rompe

**🟡 IMPORTANTE (Hacer después):**
- Mover verticales existentes (Ecommerce, Restaurant, Hotel)
- Implementar abstracciones sugeridas
- Actualizar tests

**🟢 OPCIONAL (Hacer cuando haya tiempo):**
- Implementar Dropshipping completo
- Optimizaciones adicionales
- Refactorización de código duplicado

#### Sección M: CHECKLIST DE VALIDACIÓN

Después de cada fase, verificar:

```
Fase completada: ___________

□ Todos los archivos movidos correctamente
□ Namespaces actualizados
□ Imports actualizados en archivos dependientes
□ Rutas funcionando correctamente
□ Tests pasando (ejecutar: php artisan test)
□ No hay errores en logs
□ Funcionalidad verificada manualmente en browser
□ Documentación actualizada
□ Commit realizado con mensaje descriptivo

Problemas encontrados:
_________________________________
_________________________________

Soluciones aplicadas:
_________________________________
_________________________________
```

#### Sección N: PLAN DE ROLLBACK

Si algo sale mal:

**Rollback Inmediato (Emergency):**
```bash
# Revertir último commit
git reset --hard HEAD~1

# O revertir a commit específico
git reset --hard <commit-hash>

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**Rollback Parcial:**
- Mantener cambios de Core
- Revertir solo vertical problemático
- Documentar issue y continuar con otros verticales

## 4. CRITERIOS DE EVALUACIÓN:

**Un controlador/servicio es CORE si:**
- ✅ Es usado por TODOS los verticales sin excepción
- ✅ Maneja funcionalidad genérica (dashboard, usuarios, configuración, billing)
- ✅ No tiene lógica específica de ningún vertical
- ✅ Podría aplicarse a cualquier nuevo vertical futuro

**Un controlador/servicio es VERTICAL-SPECIFIC si:**
- ✅ Solo es usado por un vertical específico
- ✅ Tiene lógica de negocio única de ese vertical
- ✅ Usa modelos o conceptos exclusivos del vertical
- ✅ Ejemplos: ProductController (ecommerce), MenuController (restaurant), RoomController (hotel)

**Un controlador/servicio es SHARED (entre algunos verticales) si:**
- ✅ Es usado por 2-3 verticales pero no todos
- ✅ Tiene lógica similar pero con pequeñas variaciones
- ✅ Podría beneficiarse de abstracción o herencia
- ✅ Ejemplo: ReservationController (restaurant + hotel)

## 5. NO EJECUTAR CAMBIOS AÚN:

⚠️ **IMPORTANTE:**
- ✋ Solo genera el plan de refactorización
- ✋ NO muevas archivos todavía
- ✋ NO modifiques código todavía
- ✋ NO actualices namespaces todavía
- ✅ ESPERA aprobación del desarrollador antes de proceder
- ✅ Primero revisaremos el plan juntos
- ✅ Luego ejecutaremos fase por fase con validación

## 6. FORMATO DE SALIDA:

- 📄 Genera el archivo `REFACTORING_PLAN.md` en la raíz del proyecto
- ✅ Usa markdown con tablas y listas claras
- 📊 Incluye estimación de tiempo para cada fase
- 🎯 Prioriza los cambios (crítico/importante/opcional)
- 🔍 Sé exhaustivo en el análisis
- 🧪 Considera el impacto en tests existentes
- ⚠️ Identifica archivos que podrían ser problemáticos
- 📋 Sugiere un orden de ejecución seguro
- 💡 Propón mejoras adicionales que encuentres

## 7. PREGUNTAS PARA DESARROLLADOR:

Al final del documento, incluye una sección con preguntas que necesitas que el desarrollador responda antes de proceder:

```markdown
## PREGUNTAS PARA EL DESARROLLADOR

Antes de ejecutar la refactorización, necesito que respondas:

1. ¿Hay algún controlador/servicio que DEBE mantenerse en su ubicación actual por alguna razón específica?

2. De las abstracciones sugeridas, ¿cuáles prefieres implementar ahora y cuáles dejar para después?

3. Para los conflictos de nombres identificados, ¿prefieres renombrar o usar namespaces distintos?

4. ¿Hay algún vertical adicional planificado que deba considerarse en esta estructura?

5. ¿Prefieres hacer la migración completa de una vez o fase por fase con validaciones intermedias?

6. ¿Hay algún deadline o restricción de tiempo que deba considerar?

7. ¿Alguna funcionalidad está siendo usada activamente en producción que requiera cuidado especial?
```

---

## IMPORTANTE FINAL:

Este es un análisis para tomar decisiones informadas. Una vez que revises el plan:
1. Aprobarás las fases a ejecutar
2. Decidirás el orden
3. Validarás cada fase antes de continuar
4. Podrás hacer ajustes según lo que vayamos encontrando

**No hay prisa. Mejor hacerlo bien que hacerlo rápido.**