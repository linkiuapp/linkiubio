# Solución de Errores en Laravel Cloud

## Errores Identificados

1. **`Unable to locate class or view [design-system::alerts.AlertBordered] for component [alert-bordered]`**
2. **`Unable to locate class or view [design-system::badges.BadgeIndicator] for component [badge-indicator]`**
3. **`View [core.auth.login] not found`**
4. **Redirects después del login no funcionan correctamente** (corregido en código)
3. **Redirects después del login no funcionan correctamente** (corregido)

## Causa

Estos errores ocurren porque el cache de componentes y vistas en Laravel Cloud está desactualizado después de los cambios recientes.

## Solución

Ejecutar los siguientes comandos en Laravel Cloud (SSH o terminal):

```bash
# Limpiar cache de configuración
php artisan config:clear

# Limpiar cache de rutas
php artisan route:clear

# Limpiar cache de vistas
php artisan view:clear

# Limpiar todo el cache (incluye componentes, config, rutas, vistas)
php artisan optimize:clear

# Optimizar para producción (después de limpiar)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Verificación

Después de ejecutar los comandos, verificar que:

1. El componente `AlertBordered` se puede usar: `<x-alert-bordered>`
2. La vista de login se encuentra: `tenant-admin::core.auth.login`

## Comando Rápido (Todo en uno)

```bash
php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

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

## Notas

- Estos comandos deben ejecutarse después de cada deploy en producción
- Laravel Cloud puede tener un script de deploy que ejecuta estos comandos automáticamente
- Si el problema persiste, puede ser necesario hacer un `composer dump-autoload` también

