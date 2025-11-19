# Solución de Errores en Laravel Cloud

## Errores Identificados

1. **`Unable to locate class or view [design-system::alerts.AlertBordered] for component [alert-bordered]`**
2. **`Unable to locate class or view [design-system::badges.BadgeIndicator] for component [badge-indicator]`**
3. **`View [core.auth.login] not found`**
4. **Redirects después del login no funcionan correctamente** (corregido en código)

## Causa

Estos errores ocurren por dos problemas principales:

1. **Case-sensitivity en Linux:** Las carpetas tienen mayúsculas (`Alerts`, `Core`) pero los componentes/vistas estaban registrados con minúsculas (`alerts`, `core`). En Linux (Laravel Cloud) las rutas son case-sensitive.

2. **Conversión de puntos a minúsculas:** Laravel convierte los puntos (`.`) en nombres de vista a barras (`/`), pero también convierte a minúsculas. Por ejemplo, `core.auth.login` se convierte a `core/auth/login` (minúscula), pero la carpeta es `Core` (mayúscula).

## Solución

**⚠️ IMPORTANTE:** El orden de los comandos es crítico. Ejecutar en este orden exacto:

```bash
# 1. Limpiar TODO el cache primero (esto es lo más importante)
php artisan optimize:clear

# 2. Limpiar cache de componentes específicamente
php artisan view:clear

# 3. Regenerar autoloader de Composer (puede ayudar con componentes)
composer dump-autoload

# 4. Ahora sí, reconstruir cache (en este orden)
php artisan config:cache
php artisan route:cache

# 5. NO ejecutar view:cache todavía si hay errores de componentes
# Primero verificar que los componentes funcionan sin cache
# Si todo funciona, entonces:
php artisan view:cache
```

**Nota:** Si `view:cache` falla con errores de componentes, significa que hay vistas que usan componentes no registrados. En ese caso:
1. NO ejecutar `view:cache` todavía
2. Ejecutar `php artisan view:diagnose-namespaces` para diagnosticar
3. Verificar que todos los componentes estén registrados en `ComponentsServiceProvider`
4. Solo después de corregir los componentes, ejecutar `view:cache`

## Verificación

Después de ejecutar los comandos, verificar que:

1. El componente `AlertBordered` se puede usar: `<x-alert-bordered>`
2. La vista de login se encuentra: `tenant-admin::core.auth.login`

## Comando Rápido (Sin view:cache si hay errores)

```bash
# Limpiar todo y reconstruir (sin view:cache si falla)
php artisan optimize:clear && composer dump-autoload && php artisan config:cache && php artisan route:cache
```

**⚠️ NO ejecutar `view:cache` si hay errores de componentes.** Laravel funcionará sin cache de vistas, solo será un poco más lento. Es mejor tener la aplicación funcionando sin cache de vistas que tenerla rota con cache.

## Si el Problema Persiste

1. **Verificar que los archivos existen:**
   - `app/Features/DesignSystem/Components/Alerts/AlertBordered.blade.php`
   - `app/Features/TenantAdmin/Views/Core/auth/login.blade.php`

2. **Verificar que los Service Providers están registrados:**
   - `bootstrap/providers.php` debe incluir `App\Core\Providers\ComponentsServiceProvider::class`
   - `bootstrap/providers.php` debe incluir `App\Features\TenantAdmin\TenantAdminServiceProvider::class`

3. **Ejecutar comando de diagnóstico (nuevo):**
   ```bash
   php artisan view:diagnose-namespaces
   ```
   Este comando mostrará todos los namespaces registrados y verificará si la vista se encuentra correctamente.

4. **Verificar permisos de archivos:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

5. **Reiniciar workers/queues si están activos:**
   ```bash
   php artisan queue:restart
   ```

6. **Si los archivos existen pero Laravel no los encuentra:**
   - Ejecutar `composer dump-autoload` para regenerar el autoloader
   - Verificar que el `TenantAdminServiceProvider` se está ejecutando correctamente
   - Revisar logs de Laravel para ver si hay errores al cargar el ServiceProvider
   - Ejecutar `php artisan view:test-resolution` para probar diferentes formatos de nombres de vista

7. **Solución aplicada (CORREGIDA):**
   ✅ **Todos los controladores actualizados** para usar `tenant-admin::Core/` (con barras y mayúscula) en lugar de `tenant-admin::core.` (con puntos y minúscula).
   
   **Razón:** Laravel convierte puntos a barras pero también a minúsculas. Usar barras directamente respeta las mayúsculas de las carpetas.
   
   **Ejemplo:**
   ```php
   // ❌ Antes (no funciona en Linux)
   return view('tenant-admin::core.auth.login', compact('store'));
   
   // ✅ Ahora (funciona correctamente)
   return view('tenant-admin::Core/auth/login', compact('store'));
   ```

## Notas

- Estos comandos deben ejecutarse después de cada deploy en producción
- Laravel Cloud puede tener un script de deploy que ejecuta estos comandos automáticamente
- Si el problema persiste, puede ser necesario hacer un `composer dump-autoload` también

