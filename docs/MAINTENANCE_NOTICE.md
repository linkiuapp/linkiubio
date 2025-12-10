# Notificación de Mantenimiento

## Descripción

Componente de notificación que se muestra en la parte superior de las vistas de **tenant** (tienda pública) y **tenant-admin** (panel de administración) para informar a los usuarios sobre posibles intermitencias durante mantenimientos.

## Ubicación

- **Componente:** `resources/views/components/maintenance-notice.blade.php`
- **Layouts donde se muestra:**
  - `app/Shared/Views/Components/layouts/tenant-admin.blade.php`
  - `resources/views/frontend/layouts/app.blade.php`

## Activación/Desactivación

### Opción 1: Variable de Entorno (Recomendado)

Agregar en `.env`:

```env
# Notificación de Mantenimiento
# true = activada, false = desactivada
MAINTENANCE_NOTICE_ENABLED=true
```

### Opción 2: Mensaje Personalizado

Si necesitas un mensaje personalizado, puedes pasarlo como prop:

```blade
<x-maintenance-notice 
    :enabled="true" 
    message="Mensaje personalizado de mantenimiento"
/>
```

## Características

- ✅ **Se puede cerrar:** Los usuarios pueden cerrar la notificación
- ✅ **Persistencia:** Una vez cerrada, no se muestra de nuevo por 24 horas (usando localStorage)
- ✅ **Responsive:** Se adapta a diferentes tamaños de pantalla
- ✅ **No intrusivo:** Aparece en la parte superior sin bloquear el contenido
- ✅ **Accesible:** Incluye atributos ARIA para lectores de pantalla

## Diseño

### Variant: Tenant (Tienda Pública)
- **Posición:** Fixed en la parte superior (top-0)
- **Ancho:** 480px (centrado)
- **Z-index:** 9999
- **Estilo:** Barra horizontal con fondo amarillo

### Variant: Admin (Panel de Administración)
- **Posición:** Fixed en la parte inferior (bottom-4)
- **Estilo:** Popup centrado con fondo blanco y borde amarillo
- **Z-index:** 999
- **Ancho máximo:** max-w-md (448px)

### Características Comunes
- **Color:** Amarillo/Warning (bg-warning-200)
- **Icono:** Alert Triangle (Lucide)
- **Animación:** Transición suave al aparecer/desaparecer

## Uso para Producción

### Antes del Deploy

1. **Activar la notificación:**
   ```env
   MAINTENANCE_NOTICE_ENABLED=true
   ```

2. **Opcional - Personalizar mensaje:**
   Editar el componente o pasar un mensaje personalizado.

### Después del Mantenimiento

1. **Desactivar la notificación:**
   ```env
   MAINTENANCE_NOTICE_ENABLED=false
   ```

2. **O limpiar localStorage (si es necesario):**
   Los usuarios pueden cerrar la notificación y no se mostrará por 24 horas. Si necesitas forzar que se muestre de nuevo, los usuarios pueden limpiar su localStorage o esperar 24 horas.

## Ejemplo de Uso

### Activar para mantenimiento programado:

```env
# .env
MAINTENANCE_NOTICE_ENABLED=true
```

### Mensaje personalizado en el componente:

```blade
<x-maintenance-notice 
    :enabled="true"
    message="Mantenimiento programado el 15 de enero de 2025 de 2:00 AM a 4:00 AM. Durante este tiempo, la plataforma puede experimentar intermitencias."
/>
```

## Notas Técnicas

- El componente usa **Alpine.js** para la interactividad
- Usa **localStorage** para recordar si el usuario cerró la notificación
- Los iconos se inicializan automáticamente con **Lucide Icons**
- **Detección automática:** El componente detecta automáticamente si está en tenant o admin basándose en las rutas
- **Variants:** Se puede forzar un variant específico con la prop `variant="tenant"` o `variant="admin"`

### Z-index por Variant:
- **Tenant:** z-index 9999 (por encima de la mayoría de elementos)
- **Admin:** z-index 999 (debajo de modales y elementos críticos)

## Troubleshooting

### La notificación no aparece:

1. Verificar que `MAINTENANCE_NOTICE_ENABLED=true` en `.env`
2. Limpiar caché de configuración: `php artisan config:clear`
3. Verificar que el componente esté incluido en los layouts

### La notificación aparece siempre:

1. Verificar que `MAINTENANCE_NOTICE_ENABLED=false` en `.env`
2. Limpiar localStorage del navegador
3. Limpiar caché de configuración: `php artisan config:clear`

