# Fase 8: Refactorizar Vistas y Eliminar Componentes

**Fecha:** $(Get-Date -Format "yyyy-MM-dd")  
**Estado:** 📋 Pendiente - Listado de componentes creado

---

## 📋 Lista de Componentes a Refactorizar

### 1. Sidebar

- [x] Esta en la carpeta correcta ✅
  - Tenant Admin: `app/Shared/Views/Components/admin/tenant-sidebar.blade.php` ✅
  - Super Admin: `app/Shared/Views/Components/admin/sidebar.blade.php` ✅
- [x] Implementacion: tenant admin - super admin ✅
  - Tenant Admin: Usa `x-sidebar-content-push` del DesignSystem ✅
  - Super Admin: Ahora usa `x-sidebar-content-push` del DesignSystem ✅
  - Item "Componentes" movido de TenantAdmin a SuperAdmin ✅
- [x] Codigo ordenado ✅
  - Código refactorizado en servicio `SidebarBuilderService` ✅
  - Métodos separados por sección ✅
- [x] Colores tailwind ✅
  - Componente usa clases Tailwind estándar ✅
  - Colores personalizados eliminados ✅
- [x] Tipografia tailwind ✅
  - Usa clases tipográficas del DesignSystem (`body-small`, `caption`) ✅
- [x] Respetando estandares del componente ✅
  - Usa componente `x-sidebar-content-push` del DesignSystem ✅
  - Estructura de datos consistente ✅
- [x] Se eliminaron duplicados ✅
  - Código HTML/Alpine.js duplicado eliminado del SuperAdmin ✅
  - Clases CSS personalizadas (`item-sidebar`, `title-group-sidebar`) ya no se usan ✅
- [x] Iconos Lucide ✅
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>` ✅
  - Iconos manejados por componente `x-sidebar-content-push` del DesignSystem ✅
  - Todos los iconos usan Lucide (no iconify-icon ni x-solar) ✅
- [x] Estado: implementado ✅

**Nota:** El item de "componentes" del sidebar de tenant admin se moverá a super admin.

---

### 2. Navbar

- [x] Esta en la carpeta correcta ✅
  - Tenant Admin: `app/Shared/Views/Components/admin/tenant-navbar.blade.php` ✅
  - Super Admin: `app/Shared/Views/Components/admin/navbar.blade.php` ✅
- [x] Implementacion: tenant admin - super admin ✅
  - Tenant Admin: Tiene sistema de posicionamiento dinámico ✅
  - Super Admin: Ahora tiene sistema de posicionamiento dinámico ✅
  - Ambos se adaptan al sidebar (abierto/minificado/cerrado) ✅
- [x] Codigo ordenado ✅
  - Código refactorizado y organizado ✅
  - Helper function para obtener icono de página ✅
  - Scripts organizados en @push('scripts') ✅
- [x] Colores tailwind ✅
  - Usa clases Tailwind estándar (`bg-white`, `text-gray-600`, `border-gray-200`, etc.) ✅
  - Colores personalizados eliminados ✅
- [x] Tipografia tailwind ✅
  - Usa clases tipográficas estándar (`text-sm`, `font-medium`, `text-gray-700`) ✅
  - Breadcrumbs con iconos de Lucide ✅
- [x] Respetando estandares del componente ✅
  - Estructura similar a tenant-navbar ✅
  - Sistema de posicionamiento dinámico implementado ✅
  - Badges usando componente `x-badge-positioned` ✅
- [x] Se eliminaron duplicados ✅
  - Clases CSS personalizadas (`user-name-navbar`, `main-wrapper`) eliminadas ✅
  - Código JavaScript mejorado y organizado ✅
  - Estructura consistente entre tenant y super admin ✅
- [x] Iconos Lucide ✅
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>` ✅
  - Todos los iconos en breadcrumbs y notificaciones usan Lucide ✅
  - No se usan iconify-icon ni x-solar ✅
- [x] Estado: implementado ✅

---

### 3. Footer

- [x] Esta en la carpeta correcta ✅
  - Compartido: `app/Shared/Views/Components/admin/footer.blade.php` ✅
  - Usado en: Tenant Admin y Super Admin ✅
- [x] Implementacion: tenant admin - super admin ✅
  - Mismo componente compartido ✅
  - Se adapta al sidebar (posicionamiento dinámico en layouts) ✅
  - Footer fijo con posicionamiento adaptativo ✅
- [x] Codigo ordenado ✅
  - Código limpio y organizado ✅
  - Scripts en @push('scripts') ✅
  - Estructura clara y semántica ✅
- [x] Colores tailwind ✅
  - Usa clases Tailwind estándar (`bg-white`, `text-gray-600`, `border-gray-200`, `hover:text-blue-600`) ✅
  - Colores personalizados eliminados ✅
- [x] Tipografia tailwind ✅
  - Usa clases tipográficas estándar (`text-sm`, `text-xs`) ✅
  - Usa componente `x-badge-indicator` del DesignSystem ✅
- [x] Respetando estandares del componente ✅
  - Usa componente `x-badge-indicator` del DesignSystem ✅
  - Estructura responsive con flexbox ✅
  - Transiciones suaves con `transition-colors` ✅
- [x] Se eliminaron duplicados ✅
  - Componente único compartido (no hay duplicados) ✅
  - No hay clases CSS personalizadas ✅
- [x] Iconos Lucide ✅
  - Usa formato estándar `<i data-lucide="arrow-up-right" class="w-3 h-3"></i>` ✅
  - Todos los iconos usan Lucide ✅
  - Script de inicialización incluido ✅
- [x] Estado: implementado ✅

---

### 4. Dashboard

**Nombre de la vista:** Dashboard

**Numero de componentes:** 4 componentes creados

**Componentes identificados:**
- StatCard - Cards de estadísticas
- QuickActionButton - Botones de acción rápida
- OrdersTableWidget - Tabla única de pedidos con badges
- AnnouncementCarousel - Carousel de anuncios

- [x] Componentes en la vista correcta ✅
  - Tenant Admin: `app/Features/TenantAdmin/Views/Core/dashboard.blade.php` ✅
  - Componentes: `app/Features/DesignSystem/Components/Dashboard/` ✅
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts integrados en componentes con @push('scripts') ✅
- [x] Implementacion: tenant admin - super admin ✅
  - Tenant Admin: Refactorizado usando componentes ✅
  - Super Admin: Pendiente
- [x] Codigo ordenado ✅
  - Código refactorizado y organizado ✅
  - Componentes reutilizables creados ✅
- [x] Colores tailwind ✅
  - Usa clases Tailwind estándar ✅
  - Colores personalizados eliminados ✅
- [x] Tipografia tailwind ✅
  - Usa clases tipográficas del DesignSystem (`body-small`, `h3`, `caption`) ✅
- [x] Respetando estandares del componente ✅
  - Usa componentes del DesignSystem ✅
  - Estructura consistente ✅
- [x] Se eliminaron duplicados ✅
  - Código HTML/Alpine.js duplicado eliminado ✅
  - Componentes reutilizables creados ✅
- [x] Iconos Lucide ✅
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>` ✅
  - Todos los iconos usan Lucide (no x-lucide-* ni x-solar-*) ✅
- [x] Todo en español ✅
  - Textos, etiquetas y mensajes en español ✅
  - "Delivery" cambiado a "Domicilio" ✅
  - Todos los textos de la tabla en español ✅
- [x] Estado: Tenant Admin implementado ✅ | Super Admin implementado ✅

---

### 5. Pedidos (CRUD)

**Nombre de la vista:** Pedidos

**Vistas identificadas:**
- `index.blade.php` - Lista de pedidos ✅
- `create.blade.php` - Crear pedido
- `edit.blade.php` - Editar pedido
- `show.blade.php` - Ver detalle de pedido

**Componentes identificados:**
- `OrdersStatsWidget` ✅
- `OrdersFiltersWidget` ✅
- `OrdersTable` ✅
- `ModalMasterKey` ✅
- (Por identificar para create/edit/show)

#### 5.1. Index (Lista de pedidos) ✅

- [x] Trabajar vista por vista del crud
- [x] Componentes en la vista correcta
- [x] No deben haber componentes en las vistas
- [x] Su .js ubicado en la carpeta correcta
- [x] Implementacion: tenant admin
- [x] Codigo ordenado
- [x] Colores tailwind
- [x] Tipografia tailwind
- [x] Respetando estandares del componente
- [x] Se eliminaron duplicados
- [x] Iconos Lucide
- [x] No usar SweetAlert
- [x] Actualización silenciosa de datos
- [x] Todo en español
- [x] UX y Accesibilidad
- [x] Estado: ✅ Completado

#### 5.2. Create (Crear pedido) ✅

- [x] Trabajar vista por vista del crud
- [x] Componentes en la vista correcta
  - Tenant Admin: `app/Features/TenantAdmin/Views/Core/orders/create.blade.php` ✅
  - Componentes: `app/Features/DesignSystem/Components/Orders/` (no se requieren componentes adicionales)
- [x] No deben haber componentes en las vistas
  - Solo se usan componentes del DesignSystem (ToastNotification)
  - No hay código HTML/Alpine.js duplicado en las vistas
  - Los selects e inputs son HTML nativo dentro de formularios
- [x] Su .js ubicado en la carpeta correcta
  - Scripts organizados en @push('scripts') dentro de la vista
- [x] Implementacion: tenant admin
  - Tenant Admin: ✅ Refactorizado
- [x] Codigo ordenado
  - Código refactorizado y organizado
  - Alpine.js bien estructurado
- [x] Colores tailwind
  - Usa clases Tailwind estándar (gray-*, blue-*, green-*, red-*, yellow-*)
  - Colores personalizados eliminados (text-black-*, bg-accent-*, etc.)
- [x] Tipografia tailwind
  - Usa clases tipográficas estándar de Tailwind
- [x] Respetando estandares del componente
  - Usa componentes del DesignSystem (ToastNotification)
  - Estructura consistente
- [x] Se eliminaron duplicados
  - Código HTML/Alpine.js organizado
  - No hay componentes duplicados en el código
- [x] Iconos Lucide
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>`
  - Todos los iconos usan Lucide (arrow-left, store, truck, package, alert-triangle, x-circle, plus-circle, trash-2, shopping-bag, check-circle)
  - Iconos contextuales según el tipo de dato (tipo de entrega)
- [x] No usar SweetAlert
  - Usa `window.showToast` para notificaciones
  - No usa Swal.fire en ningún lugar
- [x] Todo en español
  - Textos, etiquetas y mensajes en español
- [x] UX y Accesibilidad
  - Feedback visual claro (estados hover, active, disabled)
  - Mensajes de error y éxito visibles (toast notifications)
  - Loading states en acciones asíncronas (disabled states)
  - Confirmaciones para acciones destructivas (validación antes de submit)
  - Navegación intuitiva (botón de regreso con icono)
  - Responsive design (grid adaptativo)
  - Contraste de colores adecuado (WCAG AA mínimo)
  - Labels y placeholders descriptivos
  - Estados vacíos informativos (empty state con icono y mensaje)
  - Accesibilidad básica (labels, placeholders, titles)
  - Evitar tanto scroll (formulario organizado en secciones)
  - Espaciados consistentes en formularios y filtros
  - Botones de acción destacados visualmente (bg-gray-900 para crear pedido)
  - Textos linkeables en color azul para identificación clara
- [x] Estado: ✅ Completado

#### 5.3. Edit (Editar pedido) ✅

- [x] Trabajar vista por vista del crud
- [x] Componentes en la vista correcta
  - Tenant Admin: `app/Features/TenantAdmin/Views/Core/orders/edit.blade.php` ✅
- [x] No deben haber componentes en las vistas
  - Solo se usan componentes del DesignSystem cuando es necesario
  - Los selects e inputs son HTML nativo
- [x] Su .js ubicado en la carpeta correcta
  - Scripts organizados en @push('scripts') dentro de la vista
- [x] Implementacion: tenant admin
  - Tenant Admin: ✅ Refactorizado
- [x] Codigo ordenado
  - Código refactorizado y organizado
  - Alpine.js bien estructurado
- [x] Colores tailwind
  - Usa clases Tailwind estándar (gray-*, blue-*, red-*, green-*, yellow-*)
  - Colores personalizados eliminados
- [x] Tipografia tailwind
  - Usa clases tipográficas estándar de Tailwind
- [x] Respetando estandares del componente
  - Estructura consistente
- [x] Se eliminaron duplicados
  - Código HTML/Alpine.js organizado
- [x] Iconos Lucide
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>`
  - Todos los iconos usan Lucide (arrow-left, alert-triangle, file-text, info, package, x-circle, check-circle)
- [x] No usar SweetAlert
  - Usa AlertBordered para validaciones
  - No usa Swal.fire
- [x] Todo en español
  - Textos, etiquetas y mensajes en español
- [x] UX y Accesibilidad
  - Validación client-side antes de submit
  - Mensajes de error claros
  - Campos condicionales según tipo de entrega
  - Navegación intuitiva (botón de regreso)
  - Responsive design
- [x] Estado: ✅ Completado

#### 5.4. Show (Ver detalle de pedido) ✅

- [x] Trabajar vista por vista del crud
- [x] Componentes en la vista correcta
  - Tenant Admin: `app/Features/TenantAdmin/Views/Core/orders/show.blade.php` ✅
  - Componente POS: `app/Features/DesignSystem/Components/Orders/OrderReceiptPOS.blade.php` ✅
- [x] No deben haber componentes en las vistas
  - Solo se usa componente OrderReceiptPOS para generar PDF
  - Modales implementados con HTML nativo y Alpine.js
- [x] Su .js ubicado en la carpeta correcta
  - Scripts organizados en @push('scripts') dentro de la vista
- [x] Implementacion: tenant admin
  - Tenant Admin: ✅ Refactorizado
- [x] Codigo ordenado
  - Código refactorizado y organizado
  - Alpine.js bien estructurado
- [x] Colores tailwind
  - Usa clases Tailwind estándar (gray-*, blue-*, green-*, red-*, yellow-*)
  - Colores personalizados eliminados
- [x] Tipografia tailwind
  - Usa clases tipográficas estándar de Tailwind
- [x] Respetando estandares del componente
  - Usa componentes del DesignSystem (AlertBordered, BadgeSoft)
  - Estructura consistente
- [x] Se eliminaron duplicados
  - Código HTML/Alpine.js organizado
  - Componente POS aislado
- [x] Iconos Lucide
  - Usa formato estándar `<i data-lucide="icon-name" class="w-X h-X"></i>`
  - Todos los iconos usan Lucide (arrow-left, message-circle, package, check-circle, truck, store, credit-card, wallet, dollar-sign, file-text, alert-triangle, refresh-cw, edit, copy, printer, x-circle, x, file-text)
- [x] No usar SweetAlert
  - Usa AlertBordered para mensajes de error
  - Modales implementados con HTML nativo y Alpine.js
  - No usa Swal.fire
- [x] Todo en español
  - Textos, etiquetas y mensajes en español
  - Componente POS completamente en español
- [x] UX y Accesibilidad
  - Modales con animaciones suaves
  - Actualización de estado sin recargar página
  - Botones con tooltips
  - Links en color azul para identificación
  - Imágenes con fallback a iconos Lucide
  - Estilos de impresión mejorados
  - Generación de PDF funcional
- [x] Estado: ✅ Completado

---

### 6. Categorías (CRUD)

**Nombre de la vista:** Categorías

**Vistas identificadas:**
- `index.blade.php` - Lista de categorías
- `create.blade.php` - Crear categoría
- `edit.blade.php` - Editar categoría
- `show.blade.php` - Ver detalle de categoría

**Componentes identificados:**
- `CategoriesTable` - Componente del DesignSystem para tabla de categorías ✅
- (Por identificar otros componentes según necesidad)

#### 6.1. Index (Lista de categorías)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
  - Componente: `app/Features/DesignSystem/Components/Categories/CategoriesTable.blade.php` ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-categories-table>` del DesignSystem
  - ✅ NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts del componente en `@push('scripts')` dentro del componente
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
- [x] No usar SweetAlert ✅
- [x] Actualización silenciosa de datos ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
  - [x] Textos linkeables en color azul
- [x] Estado: ✅ Completado

#### 6.2. Create (Crear categoría)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
  - Componentes usados: `x-alert-soft`, `x-input-with-icon`, `x-ds-text-input`, `x-textarea-with-label`, `x-select-basic`, `x-switch-basic`, `x-button-base`, `x-button-icon` ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Todos los inputs, textarea, select y botones usan componentes del DesignSystem
  - ✅ Solo el selector de iconos usa HTML nativo (radio buttons con Alpine.js para búsqueda)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - Reemplazados `brandPrimary` y `brandWhite` por `blue-50`, `blue-300`, `blue-600`
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `search`, `plus`
- [x] No usar SweetAlert ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Cancelar" rojo y outlined (`color="error"`)
    - Botón "Crear Categoría" dark (`color="dark"`)
- [x] Estado: ✅ Completado

#### 6.3. Edit (Editar categoría)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
  - Componentes usados: `x-ds.text-input`, `x-textarea-with-label`, `x-select-basic`, `x-switch-basic`, `x-button-base`, `x-button-icon`, `x-alert-soft`, `x-input-with-icon` ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Todos los inputs, textarea, select y botones usan componentes del DesignSystem
  - ✅ Solo el selector de iconos usa HTML nativo (radio buttons con Alpine.js para búsqueda)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - Reemplazados `brandPrimary` y `brandWhite` por `blue-50`, `blue-300`
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `search`, `save`, `x`, `alert-triangle`, `loader`, `x-circle`
- [x] No usar SweetAlert ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Cancelar" rojo y outlined (`color="error"`)
    - Botón "Eliminar" rojo y outlined (`color="error"`)
    - Botón "Guardar Cambios" dark (`color="dark"`)
- [x] Estado: ✅ Completado

#### 6.4. Show (Ver detalle de categoría)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
  - Componentes usados: `x-badge-soft`, `x-button-icon` ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa componentes del DesignSystem donde corresponde
  - ✅ Solo elementos simples (iconos, enlaces) usan HTML nativo
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `external-link`, `package`, `folder`, `calendar`, `eye`, `edit`
- [x] No usar SweetAlert ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
  - [x] Textos linkeables en color azul
- [x] Estado: ✅ Completado

---

## 7. Variables (CRUD)

### Checklist General

- [ ] Trabajar vista por vista del crud
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
  - ❌ NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [ ] Su .js ubicado en la carpeta correcta
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
- [ ] Tipografia tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
- [ ] No usar SweetAlert
- [ ] Actualización silenciosa de datos
- [ ] Todo en español
- [ ] UX y Accesibilidad
  - [ ] Navegación intuitiva (botones de regreso)
  - [ ] Evitar tanto scroll
  - [ ] Feedback visual claro (estados hover, active, disabled)
  - [ ] Mensajes de error y éxito visibles
  - [ ] Loading states en acciones asíncronas
  - [ ] Confirmaciones para acciones destructivas
  - [ ] Responsive design
  - [ ] Contraste de colores adecuado
  - [ ] Labels y placeholders descriptivos
  - [ ] Estados vacíos informativos
  - [ ] Accesibilidad básica (labels, placeholders, titles)
  - [ ] Espaciados consistentes
  - [ ] Botones de acción destacados visualmente
  - [ ] Textos linkeables en color azul
  - [ ] Tooltips en botones de acción

#### 7.1. Index (Lista de variables)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
  - Componente: `app/Features/DesignSystem/Components/Variables/VariablesTable.blade.php` ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-variables-table>` del DesignSystem
  - ✅ NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts del componente en `@push('scripts')` dentro del componente
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
  - Eliminado `components/table-view.blade.php`
- [x] Iconos Lucide ✅
  - `palette`, `ruler`, `circle`, `check-square`, `type`, `calculator`, `settings`, `eye`, `pencil`, `trash-2`, `plus-circle`
- [x] No usar SweetAlert ✅
- [x] Actualización silenciosa de datos ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Nueva Variable" dark (`color="dark"`)
  - [x] Textos linkeables en color azul
  - [x] Tooltips en botones de acción
- [x] Estado: ✅ Completado

#### 7.2. Create (Crear variable)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-ds.text-input>` para inputs de texto y número
  - ✅ Usa `<x-select-basic>` para el select de tipo
  - ✅ Usa `<x-switch-basic>` para switches
  - ✅ Usa `<x-button-icon>` y `<x-button-base>` para botones
  - ✅ Usa `<x-card-base>` para las cards de opciones
  - ✅ Usa `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - ⚠️ Inputs dinámicos dentro de Alpine.js mantienen HTML nativo (necesario para x-model)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-800, blue-500, red-500, etc.)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `plus-circle`, `trash-2`, `check`
- [x] No usar SweetAlert ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
    - ✅ Botón "Volver" usa patrón estándar: `<a><i data-lucide="arrow-left"></i></a>`
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Crear Variable" dark (`color="dark"`)
    - Botón "Agregar Opción" dark (`color="dark"`)
    - Botón "Cancelar" error outlined (`color="error"`)
- [x] Estado: ✅ Completado

#### 7.3. Edit (Editar variable)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-ds.text-input>` para inputs de texto y número
  - ✅ Usa `<x-select-basic>` para el select de tipo
  - ✅ Usa `<x-switch-basic>` para switches
  - ✅ Usa `<x-button-icon>` y `<x-button-base>` para botones
  - ✅ Usa `<x-card-base>` para las cards de opciones
  - ✅ Usa `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - ⚠️ Inputs dinámicos dentro de Alpine.js mantienen HTML nativo (necesario para x-model)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-800, blue-500, red-500, etc.)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `plus-circle`, `trash-2`, `check`, `x`, `alert-triangle`, `loader`
- [x] No usar SweetAlert ✅
  - ✅ Modal de eliminación usa HTML nativo con Alpine.js
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
    - ✅ Botón "Volver" usa patrón estándar: `<a><i data-lucide="arrow-left"></i></a>`
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Actualizar Variable" dark (`color="dark"`)
    - Botón "Agregar Opción" dark (`color="dark"`)
    - Botón "Cancelar" error outlined (`color="error"`)
    - Botón "Eliminar" error solid (`color="error"`)
- [x] Estado: ✅ Completado

#### 7.4. Show (Ver detalle de variable)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-button-icon>` para botones de acción
  - ✅ Usa `<x-badge-soft>` para badges de estado
  - ✅ Usa `<x-card-base>` para las cards de opciones
  - ✅ Usa `<x-empty-state>` para estados vacíos
  - ✅ NO hay inputs/selects/textarea nativos (solo visualización)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista para inicializar iconos Lucide
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-800, blue-600, green-600, red-600, etc.)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `palette`, `ruler`, `circle`, `check-square`, `type`, `calculator`, `settings`, `edit`, `list`, `package`, `calendar`
  - ✅ Inicialización de iconos en `@push('scripts')`
- [x] No usar SweetAlert ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
    - ✅ Botón "Volver" usa patrón estándar: `<a><i data-lucide="arrow-left"></i></a>`
  - [x] Feedback visual claro (badges de estado, colores para precios)
  - [x] Información organizada en secciones claras
  - [x] Responsive design (grid adaptativo)
  - [x] Contraste de colores adecuado
  - [x] Labels y textos descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Editar" dark (`color="dark"`)
- [x] Estado: ✅ Completado

---

## 8. Productos (CRUD)

### Checklist General

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
- [x] Su .js ubicado en la carpeta correcta ✅
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
- [x] No usar SweetAlert ✅
- [x] Actualización silenciosa de datos ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
  - [x] Textos linkeables en color azul
  - [x] Tooltips en botones de acción

#### 8.1. Index (Lista de productos)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-button-icon>` para botones de acción
  - ✅ Usa `<x-select-basic>` para filtros
  - ✅ Usa `<x-input-with-icon>` para búsqueda
  - ✅ Usa `<x-badge-soft>` para badges de estado y categorías
  - ✅ Usa `<x-switch-basic>` para toggles
  - ✅ Usa `<x-tooltip-top>` para tooltips
  - ✅ Modal de eliminación usa HTML nativo con Alpine.js
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-*, blue-*, red-*, green-*, etc.)
  - ✅ Eliminadas clases personalizadas (accent-*, black-*, btn-primary, etc.)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `plus-circle`, `search`, `check-circle`, `x-circle`, `trash-2`, `package`, `eye`, `pencil`, `x`, `alert-triangle`, `loader`
  - ✅ Eliminados iconos Solar (`x-solar-*`)
- [x] No usar SweetAlert ✅
  - ✅ Modal de eliminación usa HTML nativo con Alpine.js
  - ✅ Toggles usan actualización silenciosa
  - ✅ Errores se muestran con `window.showToast()`
- [x] Actualización silenciosa de datos ✅
  - ✅ Toggle de estado actualiza badge sin recargar página
  - ✅ Toggle de compartir actualiza silenciosamente
  - ✅ Eliminación actualiza tabla sin recargar página
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles (toast notifications)
  - [x] Loading states en acciones asíncronas (spinner en modal de eliminación)
  - [x] Confirmaciones para acciones destructivas (modal de eliminación)
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos (empty state con SVG)
  - [x] Accesibilidad básica (labels, placeholders, titles, aria-labels)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Nuevo Producto" dark (`color="dark"`)
  - [x] Textos linkeables en color azul (enlaces de acciones)
  - [x] Tooltips en botones de acción
- [x] Estado: ✅ Completado

#### 8.2. Create (Crear producto)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-ds.text-input>` para inputs de texto
  - ✅ Usa `<x-select-basic>` para selects
  - ✅ Usa `<x-switch-basic>` para toggles
  - ✅ Usa `<x-button-icon>` para botones de acción
  - ✅ Usa `<x-card-base>` para cards
  - ✅ Usa `<x-alert-soft>` y `<x-alert-bordered>` para alertas
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-*, blue-*, red-*, etc.)
  - ✅ Eliminadas clases personalizadas (accent-*, black-*, primary-*, error-*)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `cloud-upload`, `x-circle`, `plus-circle`, `settings`, `info`, `check`, `x`
  - ✅ Eliminados iconos Solar (`x-solar-*`)
- [x] No usar SweetAlert ✅
  - ✅ Eliminado SweetAlert del submit
  - ✅ Validación nativa del formulario
- [x] Actualización silenciosa de datos ✅
  - ✅ Drag & drop de imágenes con preview dinámico
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botón de regreso con Lucide)
  - [x] Evitar tanto scroll (secciones organizadas en cards)
  - [x] Feedback visual claro (drag & drop con estados hover)
  - [x] Mensajes de error visibles (alert-bordered)
  - [x] Loading states (preview de imágenes)
  - [x] Responsive design (grids adaptativos)
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Crear Producto" dark (`color="dark"`)
  - [x] Textos linkeables en color azul (enlaces de categorías y variables)
- [x] Estado: ✅ Completado

#### 8.3. Edit (Editar producto)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-ds.text-input>` para inputs de texto
  - ✅ Usa `<x-select-basic>` para selects
  - ✅ Usa `<x-switch-basic>` para toggles
  - ✅ Usa `<x-button-icon>` y `<x-button-base>` para botones
  - ✅ Usa `<x-card-base>` para cards
  - ✅ Usa `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - ⚠️ Sección "Variables del Producto" usa Tailwind puro (por decisión del usuario)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js y vanilla JS
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-*, blue-*, red-*, etc.)
  - ✅ Eliminadas clases personalizadas (accent-*, black-*, primary-*, error-*)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `cloud-upload`, `x-circle`, `plus-circle`, `trash-2`, `check`, `x`, `image`, `package`
  - ✅ Eliminados iconos Solar (`x-solar-*`)
- [x] No usar SweetAlert ✅
  - ✅ Eliminado SweetAlert del submit
  - ✅ Validación nativa del formulario
- [x] Actualización silenciosa de datos ✅
  - ✅ Drag & drop de imágenes con preview dinámico
  - ✅ Gestión de cantidades por opción de variables
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botón de regreso con Lucide)
  - [x] Evitar tanto scroll (secciones organizadas en cards)
  - [x] Feedback visual claro (drag & drop con estados hover)
  - [x] Mensajes de error visibles (alert-bordered)
  - [x] Loading states (preview de imágenes)
  - [x] Responsive design (grids adaptativos)
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Actualizar Producto" dark (`color="dark"`)
    - Botón "Cancelar" error outlined (`color="error"`)
  - [x] Textos linkeables en color azul (enlaces de categorías y variables)
- [x] Estado: ✅ Completado

#### 8.4. Show (Ver detalle de producto)

- [x] Trabajar vista por vista del crud ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - ✅ Usa `<x-card-base>` para todas las cards
  - ✅ Usa `<x-badge-soft>` para badges de estado, tipo y categorías
  - ✅ Usa `<x-button-icon>` para botones de acción
  - ✅ Usa `<x-modal-scale>` para modales de confirmación
  - ✅ Usa `<x-modal-master-key>` para master key
  - ✅ Modal de imagen usa Alpine.js personalizado
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - ✅ Colores estándar de Tailwind (gray-*, blue-*, red-*, green-*, etc.)
  - ✅ Eliminadas clases personalizadas (accent-*, black-*, primary-*, success-*, error-*)
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - `arrow-left`, `pencil`, `pause-circle`, `play-circle`, `trash-2`, `eye`, `x`, `check`, `package`, `radio`, `check-square`, `type`, `hash`, `settings`
  - ✅ Eliminados iconos Solar (`x-solar-*`)
- [x] No usar SweetAlert ✅
  - ✅ Modales de confirmación usan HTML nativo con Alpine.js
  - ✅ Master key usa componente del DesignSystem
  - ✅ Notificaciones usan `window.showToast()`
- [x] Actualización silenciosa de datos ✅
  - ✅ Toggle de estado actualiza sin recargar página
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botón de regreso con Lucide)
  - [x] Evitar tanto scroll (secciones organizadas en cards)
  - [x] Feedback visual claro (modales con animaciones)
  - [x] Mensajes de error y éxito visibles (toast notifications)
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas (modales)
  - [x] Responsive design (grid adaptativo)
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles, aria-labels)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botones de acciones usan `block="true"` para ancho completo
  - [x] Textos linkeables en color azul
  - [x] Vista previa de imágenes funcional
  - [x] Información organizada en cards (Información del Producto, Imágenes, Variables)
- [x] Estado: ✅ Completado

---

## 9. Gestión de Envíos (Configuración)

**Nombre de la vista:** Configuración de Envíos

**Vistas identificadas:**
- `index.blade.php` - Configuración de métodos de envío (Simple Shipping)

**Componentes identificados:**
- (Por identificar componentes según necesidad)

### Checklist General

- [x] Trabajar vista por vista ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
- [x] Su .js ubicado en la carpeta correcta ✅
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
- [x] Tipografia tailwind ✅
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
- [x] No usar SweetAlert ✅
- [x] Actualización silenciosa de datos ✅
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles
  - [x] Loading states en acciones asíncronas
  - [x] Confirmaciones para acciones destructivas
  - [x] Responsive design
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos
  - [x] Accesibilidad básica (labels, placeholders, titles)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
  - [x] Textos linkeables en color azul
  - [x] Tooltips en botones de acción

#### 9.1. Index (Configuración de Envíos)

- [x] Trabajar vista por vista ✅
- [x] Componentes en la vista correcta ✅
- [x] Siempre usar componentes del DesignSystem ✅
  - [x] Usar `<x-card-base>` para cards de secciones
  - [x] Usar `<x-switch-basic>` para toggles
  - [x] Usar `<x-button-icon>` y `<x-button-base>` para botones
  - [x] Usar `<x-ds.text-input>` para inputs de texto y número
  - [x] Usar `<x-select-basic>` para selects
  - [x] Usar `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - [x] Usar `<x-badge-soft>` para badges de estado
  - [x] Usar `<x-modal-master-key>` para verificación de master key
  - [x] NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [x] Su .js ubicado en la carpeta correcta ✅
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js
- [x] Implementacion: tenant admin ✅
- [x] Codigo ordenado ✅
- [x] Colores tailwind ✅
  - [x] Reemplazar clases personalizadas (accent-*, black-*, primary-*, btn-primary, etc.)
  - [x] Usar colores estándar de Tailwind (gray-*, blue-*, red-*, green-*, yellow-*, etc.)
- [x] Tipografia tailwind ✅
  - [x] Reemplazar clases personalizadas (text-body-large, text-caption, etc.)
  - [x] Usar clases tipográficas estándar de Tailwind
- [x] Respetando estandares del componente ✅
- [x] Se eliminaron duplicados ✅
- [x] Iconos Lucide ✅
  - [x] Reemplazar iconos Solar (`x-solar-*`) con Lucide
  - [x] Iconos usados: `truck`, `map-pin`, `package`, `store`, `save`, `circle-plus`, `trash-2`, `pencil`, `x`, `check`, `alert-triangle`, `alert-circle`, `rocket`, `x-circle`
- [x] No usar SweetAlert ✅
  - [x] Reemplazar `Swal.fire()` con modales del DesignSystem o `window.showToast()`
- [x] Actualización silenciosa de datos ✅
  - [x] Toggles y campos actualizan sin recargar página
  - [x] Zonas de envío se gestionan dinámicamente con Alpine.js
- [x] Todo en español ✅
- [x] UX y Accesibilidad ✅
  - [x] Navegación intuitiva (botones de regreso)
  - [x] Evitar tanto scroll (secciones organizadas en cards)
  - [x] Feedback visual claro (estados hover, active, disabled)
  - [x] Mensajes de error y éxito visibles (alert-bordered o toast)
  - [x] Loading states en acciones asíncronas (spinner en botón guardar)
  - [x] Confirmaciones para acciones destructivas (eliminar zonas)
  - [x] Responsive design (grid adaptativo)
  - [x] Contraste de colores adecuado
  - [x] Labels y placeholders descriptivos
  - [x] Estados vacíos informativos (cuando no hay zonas)
  - [x] Accesibilidad básica (labels, placeholders, titles, aria-labels)
  - [x] Espaciados consistentes
  - [x] Botones de acción destacados visualmente
    - Botón "Guardar Todo" dark (`color="dark"`)
  - [x] Textos linkeables en color azul
  - [x] Tooltips en botones de acción
- [x] Estado: ✅ Completado

---

## 10. Métodos de Pago (CRUD)

**Nombre de la vista:** Métodos de Pago

**Vistas identificadas:**
- `index.blade.php` - Lista de métodos de pago
- `create.blade.php` - Crear método de pago
- `edit.blade.php` - Editar método de pago
- `show.blade.php` - Ver detalle de método de pago

**Componentes identificados:**
- (Por identificar componentes según necesidad)

### Checklist General

- [ ] Trabajar vista por vista
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
- [ ] Su .js ubicado en la carpeta correcta
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
- [ ] Tipografia tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
- [ ] No usar SweetAlert
- [ ] Actualización silenciosa de datos
- [ ] Todo en español
- [ ] UX y Accesibilidad
  - [ ] Navegación intuitiva (botones de regreso)
  - [ ] Evitar tanto scroll
  - [ ] Feedback visual claro (estados hover, active, disabled)
  - [ ] Mensajes de error y éxito visibles
  - [ ] Loading states en acciones asíncronas
  - [ ] Confirmaciones para acciones destructivas
  - [ ] Responsive design
  - [ ] Contraste de colores adecuado
  - [ ] Labels y placeholders descriptivos
  - [ ] Estados vacíos informativos
  - [ ] Accesibilidad básica (labels, placeholders, titles)
  - [ ] Espaciados consistentes
  - [ ] Botones de acción destacados visualmente
  - [ ] Textos linkeables en color azul
  - [ ] Tooltips en botones de acción

#### 10.1. Index (Lista de métodos de pago)

- [ ] Trabajar vista por vista
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
  - [ ] Usar `<x-card-base>` para cards de métodos de pago
  - [ ] Usar `<x-switch-basic>` para toggles de activación
  - [ ] Usar `<x-button-icon>` y `<x-button-base>` para botones
  - [ ] Usar `<x-badge-soft>` para badges de estado y tipo
  - [ ] Usar `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - [ ] NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [ ] Su .js ubicado en la carpeta correcta
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
  - [ ] Reemplazar clases personalizadas (accent-*, black-*, primary-*, btn-primary, etc.)
  - [ ] Usar colores estándar de Tailwind (gray-*, blue-*, red-*, green-*, yellow-*, etc.)
- [ ] Tipografia tailwind
  - [ ] Reemplazar clases personalizadas (text-body-large, text-caption, etc.)
  - [ ] Usar clases tipográficas estándar de Tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
  - [ ] Reemplazar iconos Solar (`x-solar-*`) con Lucide
  - [ ] Iconos sugeridos: `credit-card`, `wallet`, `banknote`, `dollar-sign`, `check-circle`, `x-circle`, `edit`, `trash-2`, `eye`, `plus-circle`, `settings`, `toggle-left`, `toggle-right`, `star`, `arrow-left`
- [ ] No usar SweetAlert
  - [ ] Reemplazar `Swal.fire()` con modales del DesignSystem o `window.showToast()`
- [ ] Actualización silenciosa de datos
  - [ ] Toggles de activación actualizan sin recargar página
  - [ ] Establecer método predeterminado sin recargar página
- [ ] Todo en español
- [ ] UX y Accesibilidad
  - [ ] Navegación intuitiva (botones de regreso)
  - [ ] Evitar tanto scroll (grid organizado)
  - [ ] Feedback visual claro (estados hover, active, disabled)
  - [ ] Mensajes de error y éxito visibles (alert-bordered o toast)
  - [ ] Loading states en acciones asíncronas
  - [ ] Confirmaciones para acciones destructivas (eliminar método)
  - [ ] Responsive design (grid adaptativo)
  - [ ] Contraste de colores adecuado
  - [ ] Labels y placeholders descriptivos
  - [ ] Estados vacíos informativos (cuando no hay métodos)
  - [ ] Accesibilidad básica (labels, placeholders, titles, aria-labels)
  - [ ] Espaciados consistentes
  - [ ] Botones de acción destacados visualmente
  - [ ] Textos linkeables en color azul
  - [ ] Tooltips en botones de acción
- [ ] Estado: Pendiente

#### 10.2. Create (Crear método de pago)

- [ ] Trabajar vista por vista
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
  - [ ] Usar `<x-card-base>` para cards de secciones
  - [ ] Usar `<x-ds.text-input>` para inputs de texto
  - [ ] Usar `<x-select-basic>` para selects
  - [ ] Usar `<x-switch-basic>` para toggles
  - [ ] Usar `<x-textarea-with-label>` para textareas
  - [ ] Usar `<x-button-base>` y `<x-button-icon>` para botones
  - [ ] Usar `<x-alert-soft>` y `<x-alert-bordered>` para alertas
  - [ ] NO usar HTML puro en las vistas (solo excepciones determinadas por el usuario)
- [ ] Su .js ubicado en la carpeta correcta
  - Scripts en `@push('scripts')` dentro de la vista con Alpine.js
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
- [ ] Tipografia tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
- [ ] No usar SweetAlert
- [ ] Todo en español
- [ ] UX y Accesibilidad
  - [ ] Navegación intuitiva (botones de regreso)
  - [ ] Evitar tanto scroll
  - [ ] Feedback visual claro
  - [ ] Mensajes de error y éxito visibles
  - [ ] Validación en tiempo real
  - [ ] Responsive design
  - [ ] Contraste de colores adecuado
  - [ ] Labels y placeholders descriptivos
  - [ ] Accesibilidad básica
  - [ ] Espaciados consistentes
  - [ ] Botones de acción destacados visualmente
- [ ] Estado: Pendiente

#### 10.3. Edit (Editar método de pago)

- [ ] Trabajar vista por vista
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
- [ ] Su .js ubicado en la carpeta correcta
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
- [ ] Tipografia tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
- [ ] No usar SweetAlert
- [ ] Todo en español
- [ ] UX y Accesibilidad
- [ ] Estado: Pendiente

#### 10.4. Show (Ver detalle de método de pago)

- [ ] Trabajar vista por vista
- [ ] Componentes en la vista correcta
- [ ] Siempre usar componentes del DesignSystem
- [ ] Su .js ubicado en la carpeta correcta
- [ ] Implementacion: tenant admin
- [ ] Codigo ordenado
- [ ] Colores tailwind
- [ ] Tipografia tailwind
- [ ] Respetando estandares del componente
- [ ] Se eliminaron duplicados
- [ ] Iconos Lucide
- [ ] No usar SweetAlert
- [ ] Todo en español
- [ ] UX y Accesibilidad
- [ ] Estado: Pendiente

---

## 📝 Notas Importantes

### Proceso de Trabajo

1. **Armar el listado primero** ✅ (Este documento)
2. **Verificar que cada componente esté en la carpeta correcta**
3. **Implementarlos 1x1 en las respectivas vistas**
4. **Usar componentes de DesignSystem cuando existan**
5. **Eliminar duplicados y código específico de TenantAdmin**

### Cambios Específicos

- **Sidebar:** El item de "componentes" del sidebar de tenant admin se moverá a super admin

### Componentes de DesignSystem Disponibles

Los siguientes componentes ya están disponibles en DesignSystem y deben usarse en lugar de duplicar código:

- `x-alert-bordered` - Alertas
- `x-button-icon` - Botones con iconos
- `x-tenant-admin-layout` - Layout principal
- `x-sidebar-content-push` - Sidebar
- Y otros componentes estándar del DesignSystem

---

**Última actualización:** $(Get-Date -Format "yyyy-MM-dd HH:mm")

