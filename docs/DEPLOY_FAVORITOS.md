# 🚀 Despliegue del Sistema de Favoritos

## 📋 Resumen
Sistema de favoritos para tiendas con vertical **ecommerce** y **dropshipping**. Los favoritos se guardan en localStorage sin necesidad de registro.

---

## 🔧 Pasos para Desplegar en Producción

### 1️⃣ Subir código a producción
```bash
git push origin production
```

### 2️⃣ Ejecutar en el servidor de producción

#### a) Compilar assets
```bash
npm install
npm run build
```

#### b) Crear/actualizar features en la base de datos
```bash
php artisan db:seed --class=BusinessFeatureSeeder
```

#### c) Asignar feature "favoritos" a categorías ecommerce
```bash
php artisan features:assign-to-vertical favoritos ecommerce
```

#### d) (Opcional) Asignar a dropshipping si aplica
```bash
php artisan features:assign-to-vertical favoritos dropshipping
```

#### e) Limpiar cachés
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📖 Uso del Comando

### Sintaxis
```bash
php artisan features:assign-to-vertical {feature} {vertical} [--force]
```

### Parámetros
- **feature**: Key del feature (ej: `favoritos`, `reservas_mesas`)
- **vertical**: Vertical objetivo (`ecommerce`, `restaurant`, `hotel`, `dropshipping`)
- **--force**: (Opcional) Re-asignar incluso si ya lo tiene

### Ejemplos
```bash
# Asignar favoritos a ecommerce
php artisan features:assign-to-vertical favoritos ecommerce

# Asignar reservas_mesas a restaurant
php artisan features:assign-to-vertical reservas_mesas restaurant

# Forzar reasignación
php artisan features:assign-to-vertical favoritos ecommerce --force
```

---

## ✅ Verificación

### Verificar que el feature existe
```bash
php artisan tinker
>>> \App\Shared\Models\BusinessFeature::where('key', 'favoritos')->first()
```

### Verificar categorías con el feature
```bash
php artisan tinker
>>> $feature = \App\Shared\Models\BusinessFeature::where('key', 'favoritos')->first();
>>> $feature->categories()->get(['id', 'name', 'vertical']);
```

### Verificar que una tienda tiene el feature
```bash
php artisan tinker
>>> $store = \App\Shared\Models\Store::first();
>>> featureEnabled($store, 'favoritos');
```

---

## 🎯 Verticales con Favoritos

Según configuración en `config/verticals.php`:
- ✅ **ecommerce** - Tiene favoritos
- ✅ **dropshipping** - Tiene favoritos
- ❌ **restaurant** - NO tiene favoritos (usa reservas)
- ❌ **hotel** - NO tiene favoritos (usa reservas)

---

## 📁 Archivos del Sistema de Favoritos

### Backend
- `app/Features/Tenant/Controllers/FavoritesController.php`
- `app/Features/Tenant/Views/favorites/index.blade.php`
- `app/Features/Tenant/Routes/web.php` (rutas agregadas)
- `app/Console/Commands/AssignFeatureToVertical.php` (comando helper)

### Frontend
- `resources/js/favorites.js` (lógica de favoritos)
- `resources/js/app.js` (inicialización)
- `resources/views/frontend/layouts/app.blade.php` (menú con badge)

### Vistas con botones de favoritos
- `app/Features/Tenant/Views/storefront/home.blade.php`
- `app/Features/Tenant/Views/storefront/catalog.blade.php`
- `app/Features/Tenant/Views/storefront/category.blade.php`

---

## 🐛 Troubleshooting

### El menú no muestra "Favoritos"
1. Verificar que la categoría de la tienda tiene `vertical = 'ecommerce'` o `'dropshipping'`
2. Verificar que el feature está asignado: ejecutar comando de asignación
3. Limpiar caché: `php artisan cache:clear`

### Los botones de favoritos no funcionan
1. Verificar que los assets están compilados: `npm run build`
2. Revisar consola del navegador (F12) para errores de JavaScript
3. Verificar que `favorites.js` se está cargando

### Los favoritos no persisten
- Los favoritos se guardan en localStorage del navegador
- Si el usuario limpia su navegador, se pierden (comportamiento esperado)
- Son específicos por tienda (slug)

---

## 📊 Base de Datos

### Tablas involucradas
- `business_features` - Definición del feature "favoritos"
- `business_category_feature` - Relación categorías ↔ features
- `business_categories` - Categorías con campo `vertical`

### No hay tabla de favoritos
Los favoritos NO se guardan en base de datos, usan **localStorage** del navegador.

---

## 🎨 UI del Sistema

### Estados del botón de favoritos
- **Default**: Fondo rosa claro, icono corazón rojo vacío
- **Hover**: Fondo rojo oscuro, icono blanco
- **Activo**: Fondo rosa claro, icono corazón blanco lleno

### Página de favoritos
- Ruta: `/{store-slug}/favoritos`
- Muestra lista de productos guardados
- Permite agregar al carrito directamente
- Opción "Limpiar todos"

---

## 📝 Notas Importantes

1. ⚠️ **Los favoritos NO requieren autenticación**
2. 💾 **Se guardan en localStorage** (por tienda)
3. 🔄 **Compatible con productos simples y variables**
4. 📱 **Funciona en todas las vistas** (home, catálogo, categorías)
5. ❤️ **Badge contador** en el menú de navegación

---

Documentado: 1 de Diciembre 2025

