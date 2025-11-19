# Propuesta de Reorganización: Dashboard

**Fecha:** 2024-12-29  
**Estado:** 📋 Propuesta

---

## 📊 Análisis Actual

### Tenant Admin Dashboard
- **Ubicación:** `app/Features/TenantAdmin/Views/Core/dashboard.blade.php`
- **Estructura:** Grid complejo (6 columnas x 7 filas)
- **Componentes identificados:**
  - Cards de estadísticas (6 cards: Total, Pendientes, Confirmados, Preparando, Enviados, Entregados)
  - Botones de acción rápida (Crear Slider, Agregar Producto, Crear Pedido, Crear Cupón, Crear Reserva Restaurante, Crear Reserva Hotel)
  - Banner de anuncios (carousel con Alpine.js)
  - Listas de pedidos por tipo (Delivery, Habitación, Consumo Local)
  - Banner de estado de aprobación
- **Iconos:** Mezcla de `x-lucide-*` y `x-solar-*`
- **Scripts:** Alpine.js inline en `@push('scripts')`

### Super Admin Dashboard
- **Ubicación:** `app/Features/SuperLinkiu/Views/dashboard.blade.php`
- **Estructura:** Grid simple con widgets
- **Componentes identificados:**
  - Cards de estadísticas (4 cards: Total Tiendas, Tiendas Activas, Verificadas, Ingresos del Mes)
  - Widget de solicitudes pendientes (con badges de prioridad)
  - Alertas de monitoreo
  - Gráficos (Chart.js: Crecimiento Mensual, Distribución por Plan)
  - Tabla de últimas tiendas creadas
- **Iconos:** Solo `x-solar-*`
- **Scripts:** Chart.js inline en `@push('scripts')`

---

## 🎯 Propuesta de Reorganización

### 1. Crear Componentes Reutilizables

#### A. Componente: `StatCard`
**Propósito:** Cards de estadísticas reutilizables

**Ubicación:** `app/Features/DesignSystem/Components/Dashboard/StatCard.blade.php`

**Props:**
- `title` - Título del card
- `value` - Valor principal
- `icon` - Nombre del icono Lucide
- `color` - Color del tema (primary, success, warning, etc.)
- `description` (opcional) - Descripción adicional
- `badge` (opcional) - Badge adicional

**Ejemplo de uso:**
```blade
<x-stat-card 
    title="Total"
    :value="$stats['total']"
    icon="shopping-cart"
    color="primary"
/>
```

#### B. Componente: `QuickActionButton`
**Propósito:** Botones de acción rápida

**Ubicación:** `app/Features/DesignSystem/Components/Dashboard/QuickActionButton.blade.php`

**Props:**
- `href` - URL de destino
- `label` - Texto del botón
- `icon` - Nombre del icono Lucide
- `color` - Color del tema

#### C. Componente: `OrdersTableWidget`
**Propósito:** Tabla única de pedidos con badges de tipo

**Ubicación:** `app/Features/DesignSystem/Components/Dashboard/OrdersTableWidget.blade.php`

**Props:**
- `title` - Título de la sección
- `orders` - Array de todos los pedidos (mezclados)
- `viewAllUrl` - URL para ver todos
- `maxItems` (opcional) - Límite de items a mostrar (default: 10)

**Características:**
- Tabla única con todos los pedidos
- Badge que indica el tipo/origen (Delivery, Habitación, Consumo Local)
- Ordenados por fecha (más recientes primero)
- Filtros opcionales por tipo (si se requiere)

#### D. Componente: `AnnouncementCarousel`
**Propósito:** Carousel de anuncios

**Ubicación:** `app/Features/DesignSystem/Components/Dashboard/AnnouncementCarousel.blade.php`

**Props:**
- `banners` - Array de banners
- `apiUrl` - URL de la API para cargar banners

#### E. Componente: `ChartWidget`
**Propósito:** Widget de gráficos reutilizable

**Ubicación:** `app/Features/DesignSystem/Components/Dashboard/ChartWidget.blade.php`

**Props:**
- `title` - Título del gráfico
- `type` - Tipo de gráfico (line, bar, doughnut, etc.)
- `data` - Datos del gráfico
- `options` (opcional) - Opciones personalizadas

---

### 2. Reorganizar Scripts JavaScript

#### A. Mover scripts a archivos separados

**Tenant Admin Dashboard:**
- `resources/js/tenant-admin/dashboard/orders-widget.js` - Lógica de OrdersListWidget
- `resources/js/tenant-admin/dashboard/announcement-carousel.js` - Lógica de AnnouncementCarousel

**Super Admin Dashboard:**
- `resources/js/super-admin/dashboard/charts.js` - Lógica de gráficos Chart.js

---

### 3. Estandarizar Iconos

**Cambios necesarios:**
- Convertir todos los `x-lucide-*` y `x-solar-*` a formato `<i data-lucide="icon-name" class="w-X h-X"></i>`
- Usar solo iconos de Lucide (eliminar x-solar)

---

### 4. Estructura Propuesta

#### Tenant Admin Dashboard
```
dashboard.blade.php
├── Banner de Estado de Aprobación (si aplica)
├── Grid de StatCards (6 cards)
├── Grid de QuickActionButtons (6 botones)
├── AnnouncementCarousel
└── OrdersTableWidget (tabla única con todos los pedidos)
    └── Badges indicando tipo: Delivery, Habitación, Consumo Local
```

#### Super Admin Dashboard
```
dashboard.blade.php
├── Grid de StatCards (4 cards)
├── Widget de Solicitudes Pendientes
├── Alertas de Monitoreo
├── Grid de ChartWidgets (2 gráficos)
└── Tabla de Últimas Tiendas
```

---

## 📋 Checklist de Implementación

### Tenant Admin Dashboard
- [x] Crear componente `StatCard` ✅
- [x] Crear componente `QuickActionButton` ✅
- [x] Crear componente `OrdersTableWidget` (tabla única con badges de tipo) ✅
- [x] Crear componente `AnnouncementCarousel` ✅
- [x] Mover scripts a archivos JS separados ✅ (integrados en componentes)
- [x] Convertir iconos a formato Lucide estándar ✅
- [x] Refactorizar vista usando componentes ✅
  - **Cambio importante:** Unificar pedidos en una sola tabla con badges de tipo ✅
- [ ] Verificar responsive design (pendiente pruebas)
- [ ] Probar funcionalidad completa (pendiente pruebas)

### Super Admin Dashboard
- [ ] Crear componente `StatCard` (reutilizar)
- [ ] Crear componente `ChartWidget`
- [ ] Crear componente `PendingRequestsWidget`
- [ ] Mover scripts Chart.js a archivo separado
- [ ] Convertir iconos a formato Lucide estándar
- [ ] Refactorizar vista usando componentes
- [ ] Verificar responsive design
- [ ] Probar funcionalidad completa

---

## 🎨 Consideraciones de Diseño

### Colores Tailwind
- Usar clases estándar del sistema de colores
- Mantener consistencia con DesignSystem

### Tipografía Tailwind
- Usar clases tipográficas del DesignSystem (`heading-2`, `body-base`, `caption`, etc.)

### Responsive
- Grid adaptativo con breakpoints estándar
- Cards apilables en mobile

---

## 📝 Notas Adicionales

- Los componentes deben ser reutilizables entre Tenant Admin y Super Admin cuando sea posible
- Mantener la funcionalidad existente durante la refactorización
- Los scripts deben estar organizados y documentados
- Considerar performance al cargar gráficos y datos

### 🎨 Mejoras de UX - Tenant Admin Dashboard

**Cambio importante en Orders:**
- **Antes:** 3 widgets separados (Delivery, Habitación, Consumo Local)
- **Ahora:** 1 tabla única con badges que indican el tipo/origen
- **Ventajas:**
  - Mejor UX: ver todos los pedidos en un solo lugar
  - Más eficiente: no tener que revisar múltiples secciones
  - Badges visuales claros para identificar tipo rápidamente
  - Opción de filtros si se requiere en el futuro

---

**Última actualización:** 2024-12-29

