# Documentación del Proyecto Linkiu

**Última actualización:** 21 de Noviembre de 2025  
**Versión Laravel:** 12.x

---

## Flujo de Desarrollo con Ramas

- Todo desarrollo y pruebas iniciales se hacen en **local**.
- Los cambios se suben primero a la rama **`staging`**.
- QA y pruebas manuales se ejecutan en **`staging`**.
- Solo tras aprobación de QA, se hace merge a **`production`**.
- **Está prohibido hacer commits directos en `production`**.

---

## Frontend (Blade + Vite + Alpine)

- Mantener consistencia de estilos con **Tailwind** (no CSS inline).
- **Alpine.js** es obligatorio para toda interactividad.
- **Preline UI** se usa para componentes UI (modals, dropdowns, tabs, etc.).
- Componentes Blade del DesignSystem en `app/Features/DesignSystem/Components/`.

---

## Seguridad

- Nunca dejar `dd()`, `dump()` ni `console.log` en commits.
- Logs y archivos de prueba no llegan a `production`.
- Todo input debe sanitizarse/validarse antes de usarse.
- Variables sensibles siempre en `.env` y documentadas en `.env.example`.
- Validación siempre en **FormRequests** (nunca en controllers).
- Multi-tenancy: Todas las queries deben filtrar por `tenant_id` (usar trait `BelongsToTenant`).

---

## Estándares de Commits

Formato **Conventional Commits**:

- `feat:` nueva funcionalidad
- `fix:` corrección de bug
- `chore:` mantenimiento o dependencias
- `refactor:` cambio interno sin modificar funcionalidad
- `test:` pruebas
- `docs:` documentación

**Ejemplo:**
```
feat: optimizar dashboard con mejoras de performance -63%

- Eliminar query duplicada no utilizada (-60ms)
- Combinar queries de revenue y today (-35ms)
- Optimizar eager loading de orders (-30ms)
```

---

## Arquitectura del Proyecto

### Estructura Feature-based

```
app/
├── Features/          # Features modulares
│   ├── SuperLinkiu/   # Feature Super Admin
│   ├── TenantAdmin/   # Feature Admin Tiendas
│   ├── Tenant/        # Feature Frontend Público
│   └── DesignSystem/  # Componentes UI reutilizables
├── Shared/            # Código compartido entre features
│   ├── Models/        # Models base
│   ├── Services/       # Services compartidos
│   ├── Middleware/    # Middleware compartido
│   └── Traits/        # Traits reutilizables
└── Services/           # Services globales
```

### Patrones

- **Controllers delgados**: Solo orquestan, delegan lógica a Services.
- **Services gruesos**: Contienen toda la lógica de negocio.
- **FormRequests**: SIEMPRE para validación.
- **Policies**: Para autorización.
- **Traits**: Para comportamiento compartido (`BelongsToTenant` para multi-tenancy).

---

## Multi-tenancy

- **Trait obligatorio**: `BelongsToTenant` en todos los Models que pertenecen a un tenant.
- **Global Scope**: `TenantScope` se aplica automáticamente.
- **Middleware**: `TenantIdentificationMiddleware` identifica el tenant desde la URL.
- **Storage**: Segregado por tenant en `/storage/app/public/stores/{store_id}/`.

---

## Testing

- **Feature tests** para flujos críticos.
- Tests ubicados en `tests/Feature/`.
- Ejecutar con: `composer test` o `php artisan test`.

---

## Performance

- **Cache**: Usar `Cache::remember()` para queries pesadas (TTL recomendado: 5 min).
- **Eager loading**: Siempre usar `->with()` para evitar N+1 queries.
- **Índices**: Agregar índices compuestos para queries frecuentes.
- **Lazy-load**: Componentes pesados deben cargarse de forma asíncrona cuando sea posible.

---

## Dependencias Principales

### Backend
- Laravel 12.x
- SendGrid (emails)
- DomPDF (PDFs)
- Laravel Excel (exportación)
- Intervention Image (optimización imágenes)
- SimpleSoftwareIO QR (códigos QR)
- Pusher (notificaciones tiempo real)

### Frontend
- Alpine.js (interactividad)
- Preline UI (componentes)
- Tailwind CSS (estilos)
- ApexCharts (gráficos)
- Dropzone (upload archivos)
- Lucide Icons (iconografía)

---

## Comandos Útiles

```bash
# Desarrollo
composer dev              # Servidor + queue + logs + vite
npm run dev              # Vite watch

# Testing
composer test            # Ejecutar tests
php artisan test          # Ejecutar tests (alternativa)

# Cache
php artisan cache:clear   # Limpiar cache
php artisan view:clear    # Limpiar vistas
php artisan config:clear  # Limpiar config

# Migraciones
php artisan migrate       # Aplicar migraciones
php artisan migrate:rollback  # Revertir última migración
```

---

## Convenciones de Naming

- **Controllers**: Singular + sufijo `Controller` (ej: `DashboardController`)
- **Models**: Singular (ej: `Order`, `Product`)
- **Services**: Singular + sufijo `Service` (ej: `ProductImageService`)
- **Variables PHP**: camelCase (ej: `$orderNumber`)
- **Variables BD**: snake_case (ej: `order_number`)
- **Rutas**: kebab-case, español cuando es público
- **Métodos**: camelCase, español (ej: `procesarImagen()`)

---

## Código Prohibido

1. ❌ Dejar `dd()`, `dump()`, `console.log()` en commits
2. ❌ Código comentado en commits
3. ❌ Lógica de negocio en Controllers
4. ❌ Queries sin `tenant_id` en multi-tenant
5. ❌ CSS inline o `<style>` en Blade (solo Tailwind)

---

## Errores Frecuentes

1. ⚠️ Olvidar trait `BelongsToTenant` en Models
2. ⚠️ No hacer eager loading (N+1 queries)
3. ⚠️ No validar en FormRequests (validar en Controller)
4. ⚠️ No cachear queries pesadas
5. ⚠️ No documentar funciones públicas

---

## Code Review Checklist

1. ✅ Multi-tenant correcto (trait `BelongsToTenant`)
2. ✅ Sin N+1 (queries con `->with()`)
3. ✅ Validación en FormRequest
4. ✅ Documentación PHPDoc en funciones públicas
5. ✅ Sin código de debug (`dd()`, `dump()`, `console.log()`)

---

**Fin de la Documentación**

