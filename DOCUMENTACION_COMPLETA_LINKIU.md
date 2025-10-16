# 📘 DOCUMENTACIÓN COMPLETA - PROYECTO LINKIU

> **Documento de Referencia Vivo**  
> Última actualización: Octubre 2025  
> Versión: 1.0

---

## 📋 TABLA DE CONTENIDOS

1. [Stack Tecnológico](#1-stack-tecnológico)
2. [Arquitectura del Proyecto](#2-arquitectura-del-proyecto)
3. [Roles y Funcionalidades](#3-roles-y-funcionalidades)
4. [Flujos Críticos](#4-flujos-críticos)
5. [Sistema de Diseño (Tailwind)](#5-sistema-de-diseño-tailwind)
6. [Dependencias Externas](#6-dependencias-externas)
7. [Base de Datos](#7-base-de-datos)
8. [Hosting y Deployment (Laravel Cloud)](#8-hosting-y-deployment-laravel-cloud)
9. [Seguridad y Middlewares](#9-seguridad-y-middlewares)
10. [Sistema de Notificaciones](#10-sistema-de-notificaciones)
11. [Flujo de Trabajo con Ramas](#11-flujo-de-trabajo-con-ramas)
12. [Comandos Útiles](#12-comandos-útiles)

---

## 1. 🛠️ STACK TECNOLÓGICO

### Backend
```yaml
PHP: 8.2+
Framework: Laravel 12.0
Base de Datos: MySQL (MyISAM engine)
Zona Horaria: America/Bogota
Autenticación: Laravel Sanctum 4.0
```

### Frontend
```yaml
JavaScript: ES6+ con Vite 5.0.0
Framework Reactivo: Alpine.js 3.13.0
Estilos: Tailwind CSS 3.3.0
Bundler: Vite 5.0.0
Tiempo Real: Pusher JS 8.4.0
HTTP Client: Axios 1.6.1
```

### Librerías PHP Principales
```yaml
sendgrid/sendgrid: 8.1          # Emails transaccionales
barryvdh/laravel-dompdf: 3.1    # Generación de PDFs
maatwebsite/excel: 3.1          # Exportación Excel
pusher/pusher-php-server: 7.2  # WebSockets servidor
league/flysystem-aws-s3-v3: 3.0 # AWS S3 storage
```

### Iconos
```yaml
Solar Icons: codeat3/blade-solar-icons 1.2
Lucide Icons: mallardduck/blade-lucide-icons 1.23
```

---

## 2. 📁 ARQUITECTURA DEL PROYECTO

### Patrón: **Feature-Based Architecture + Shared Resources**

```
app/
├── Features/                          # Módulos de funcionalidad autocontenidos
│   ├── SuperLinkiu/                  # Panel SuperAdmin
│   │   ├── Controllers/              # 15 controladores
│   │   ├── Routes/web.php            # Rutas /superlinkiu/*
│   │   ├── Services/                 # 8 servicios de negocio
│   │   ├── Views/                    # Vistas Blade del módulo
│   │   ├── Exports/                  # StoresExport (Excel)
│   │   ├── Requests/                 # Form Requests
│   │   └── SuperLinkiuServiceProvider.php
│   │
│   ├── TenantAdmin/                  # Panel Admin de Tienda
│   │   ├── Controllers/              # 21 controladores
│   │   ├── Models/                   # 20 modelos específicos
│   │   ├── Routes/web.php            # Rutas /{store}/admin/*
│   │   ├── Services/                 # 7 servicios
│   │   ├── Policies/                 # Políticas de autorización
│   │   ├── Events/                   # StorePlanChanged
│   │   ├── Listeners/                # HandleBankAccountsOnPlanChange
│   │   └── TenantAdminServiceProvider.php
│   │
│   └── Tenant/                       # Frontend Público (Clientes)
│       ├── Controllers/              # StorefrontController, OrderController
│       ├── Routes/web.php            # Rutas /{store}/*
│       ├── Views/                    # checkout/, storefront/
│       └── TenantServiceProvider.php
│
├── Shared/                           # Recursos compartidos entre features
│   ├── Models/                       # 23 modelos centrales
│   │   ├── Store.php                 # Modelo principal de tiendas
│   │   ├── User.php                  # super_admin, store_admin
│   │   ├── Order.php                 # Sistema de pedidos
│   │   ├── Plan.php                  # Planes de suscripción
│   │   ├── Ticket.php                # Sistema de soporte
│   │   ├── Invoice.php               # Facturación
│   │   ├── Subscription.php          # Suscripciones
│   │   └── ...
│   ├── Middleware/                   # 5 middlewares
│   ├── Services/                     # TenantService, CacheService
│   ├── Views/                        # Layouts admin compartidos
│   ├── Observers/                    # StoreObserver
│   ├── Scopes/                       # Query scopes
│   └── Traits/                       # Traits reutilizables
│
├── Services/                         # Servicios globales
│   ├── SendGridEmailService.php      # Integración SendGrid
│   ├── BillingAutomationService.php  # Automatización de facturación
│   ├── PlanUsageService.php          # Límites de planes
│   ├── RUTValidationService.php      # Validación fiscal
│   └── SystemDebugService.php        # Debug de producción
│
├── Core/Providers/                   # Providers del core
│   ├── RouteServiceProvider.php      # Enrutamiento dinámico
│   ├── EventServiceProvider.php      # Registro de eventos
│   ├── AuthServiceProvider.php       # Políticas y gates
│   └── ComponentsServiceProvider.php # Componentes Blade
│
├── Http/
│   ├── Controllers/                  # 4 controladores generales
│   ├── Middleware/                   # DebugAuthMiddleware
│   └── Kernel.php
│
├── Jobs/                             # Jobs asíncronos
│   ├── SendEmailJob.php
│   └── SendTestEmailJob.php
│
├── Events/                           # Eventos del sistema
│   ├── NewOrderCreated.php
│   ├── OrderStatusChanged.php
│   ├── TicketResponseAdded.php
│   └── ...
│
├── Console/Commands/                 # 34 comandos Artisan
│
└── Models/                           # Modelos auxiliares
    ├── EmailConfiguration.php
    └── StoreDraft.php
```

### Recursos Frontend

```
resources/
├── js/
│   ├── app.js                        # Entry point principal
│   ├── cart.js                       # Sistema de carrito
│   ├── notifications.js              # Notificaciones Pusher
│   ├── tickets.js                    # Sistema de tickets
│   ├── navbar.js                     # Navegación
│   ├── sidebar.js                    # Sidebar
│   ├── store.js                      # Gestión de tiendas
│   ├── envios.js                     # Sistema de envíos
│   └── components/                   # 26 componentes JS
│       ├── wizard-navigation.js
│       ├── wizard-step.js
│       ├── wizard-state-manager.js
│       ├── validation-engine.js
│       ├── location-autocomplete.js
│       ├── draft-recovery-modal.js
│       └── ...
│
├── css/
│   ├── app.css                       # Estilos principales
│   ├── wizard.css                    # Estilos del wizard
│   └── ...
│
└── views/
    ├── welcome.blade.php             # Landing principal
    ├── components/
    │   ├── pagination.blade.php
    │   └── cart-float.blade.php
    └── vendor/pagination/            # Paginación personalizada
```

### Base de Datos

```
database/
├── migrations/                       # 76 migraciones
│   ├── 2023_07_20_000001_create_stores_table.php
│   ├── 2024_03_20_000001_create_plans_table.php
│   ├── 2025_01_22_000001_create_orders_table.php
│   ├── 2025_07_12_045242_create_tickets_table.php
│   ├── 2025_07_23_002236_create_subscriptions_table.php
│   ├── 2025_09_15_200131_create_simple_shipping_table.php
│   ├── 2025_10_06_170321_create_email_configurations_table.php
│   └── ...
│
└── seeders/                          # 13 seeders
    ├── PlansSeeder.php
    ├── SuperAdminSeeder.php
    ├── StoreAdminSeeder.php
    ├── CategoryIconsSeeder.php
    ├── PaymentMethodSeeder.php
    └── ...
```

---

## 3. 🎯 ROLES Y FUNCIONALIDADES

### A. SuperLinkiu (Panel SuperAdmin)

**URL Base**: `/superlinkiu/*`  
**Rol Requerido**: `super_admin`  
**Namespace**: `App\Features\SuperLinkiu`

#### Controladores Principales:

| Controlador | Responsabilidad |
|------------|----------------|
| **AuthController** | Login/Logout super_admin |
| **DashboardController** | Métricas generales de la plataforma |
| **StoreController** | CRUD de tiendas + Wizard de creación |
| **StoreApprovalController** | Aprobación/Rechazo de solicitudes |
| **PlanController** | CRUD de planes de suscripción |
| **InvoiceController** | Generación y gestión de facturas |
| **TicketController** | Sistema de soporte técnico |
| **AnnouncementController** | Comunicados a tiendas |
| **BusinessCategoryController** | Categorías de negocio |
| **CategoryIconController** | Iconos para categorías |
| **EmailConfigurationController** | Configuración SendGrid |
| **BillingSettingController** | Logo y datos fiscales plataforma |
| **ProfileController** | Perfil del super_admin |
| **AnalyticsController** | Dashboard analítico |

#### Servicios Clave:

```php
StoreService                  // Lógica de negocio de tiendas
StoreValidationService        // Validación de datos de tiendas
FiscalValidationService       // Validación RUT/NIT
LocationService               // Autocompletado ubicaciones
StoreTemplateService          // Plantillas de diseño
ValidationCacheService        // Caché de validaciones
ErrorMonitoringService        // Monitoreo de errores
PerformanceMonitoringService  // Métricas de rendimiento
```

#### Funcionalidades:

1. **Gestión de Tiendas**
   - Crear tiendas con Wizard multi-paso (7 pasos)
   - Aprobación automática vs manual
   - CRUD completo (ver, editar, eliminar)
   - Exportación a Excel
   - Sistema de borradores (drafts)
   - Cambio de estado (activa/inactiva/suspendida)
   - Badge de verificación

2. **Sistema de Aprobación**
   - Ver solicitudes pendientes
   - Aprobar con generación de credenciales
   - Rechazar con motivo y mensaje
   - Asignar categoría de negocio
   - Notas administrativas

3. **Planes de Suscripción**
   - CRUD de planes
   - Configuración de límites:
     - max_products, max_categories, max_variables
     - max_slider, max_active_coupons
     - max_sedes, max_delivery_zones
     - max_bank_accounts, max_admins
     - analytics_retention_days
   - Precios por período (mensual, trimestral, semestral)

4. **Facturación**
   - Generación manual de facturas
   - Marcar como pagada
   - Cancelar factura
   - Ver estadísticas

5. **Tickets de Soporte**
   - Ver todos los tickets de todas las tiendas
   - Responder con imágenes adjuntas
   - Cambiar estado (open, in_progress, resolved, closed)
   - Cambiar prioridad (low, medium, high, urgent)
   - Asignar a un admin

6. **Anuncios Globales**
   - CRUD de anuncios
   - Tipos: banner, notification, emergency
   - Filtrado por plan (todos, explorer, creator, master, pro)
   - Activar/Desactivar
   - Duplicar anuncios

7. **Configuración de Emails (SendGrid)**
   - Configurar API Key
   - Validar templates
   - Enviar emails de prueba
   - Configurar remitentes por categoría:
     - store_management (tiendas@linkiu.email)
     - tickets (soporte@linkiu.email)
     - billing (facturas@linkiu.email)

---

### B. TenantAdmin (Panel Admin de Tienda)

**URL Base**: `/{store}/admin/*`  
**Rol Requerido**: `store_admin`  
**Namespace**: `App\Features\TenantAdmin`

#### Controladores Principales:

| Controlador | Responsabilidad |
|------------|----------------|
| **AuthController** | Login/Logout store_admin |
| **DashboardController** | Métricas de la tienda |
| **ProfileController** | Cambio de contraseña del admin |
| **BusinessProfileController** | Datos de la tienda, políticas, SEO |
| **StoreDesignController** | Logo, colores, favicon |
| **CategoryController** | Categorías de productos |
| **VariableController** | Variables (tallas, colores, etc.) |
| **ProductController** | CRUD de productos con variantes |
| **SliderController** | Banners promocionales |
| **PaymentMethodController** | Métodos de pago |
| **BankAccountController** | Cuentas bancarias |
| **SimpleShippingController** | Zonas y costos de envío |
| **CouponController** | Cupones de descuento |
| **OrderController** | Gestión de pedidos |
| **LocationController** | Sedes/ubicaciones físicas |
| **TicketController** | Soporte técnico |
| **AnnouncementController** | Ver anuncios de la plataforma |
| **BillingController** | Cambio de plan, facturación |
| **InvoiceController** | Ver y descargar facturas |

#### Servicios Clave:

```php
ProductVariantService      // Generación automática de variantes
BankAccountService        // Gestión de cuentas bancarias
ProductImageService       // Manejo de imágenes de productos
SliderImageService        // Imágenes de sliders
StoreDesignImageService   // Logo y favicon
PaymentMethodService      // Configuración de pagos
LocationService           // Gestión de sedes
```

#### Funcionalidades:

1. **Perfil de Negocio**
   - Actualizar datos del dueño
   - Configurar datos de la tienda
   - Información fiscal (RUT/NIT)
   - SEO (meta title, description, keywords)
   - Políticas (privacidad, envíos, devoluciones)
   - Descripción "Sobre nosotros"

2. **Diseño de Tienda**
   - Subir logo (PNG, JPG, SVG)
   - Subir favicon
   - Configurar colores:
     - header_background_color
     - header_text_color
     - header_short_description_color
   - Historial de cambios de diseño
   - Sistema de publicación (draft → published)

3. **Catálogo de Productos**
   - **Categorías**:
     - CRUD con iconos (Solar o Lucide)
     - Orden manual (drag & drop)
     - Activar/Desactivar
   - **Variables**:
     - Crear variables (ej: Talla, Color)
     - Opciones de variables (ej: S, M, L, XL)
     - Duplicar variables
   - **Productos**:
     - CRUD completo
     - Múltiples imágenes
     - Imagen principal
     - Variantes automáticas
     - Stock y precios por variante
     - Categorías múltiples
     - Activar/Desactivar
     - Duplicar producto

4. **Sliders Promocionales**
   - CRUD de banners
   - Imagen, título, subtítulo, CTA
   - Enlace externo o interno
   - Orden manual
   - Activar/Desactivar

5. **Métodos de Pago**
   - Predefinidos (Transferencia, Contra entrega, Efectivo)
   - Personalizados
   - Configurar cuentas bancarias:
     - Banco, tipo de cuenta, número, titular
     - Múltiples cuentas por método
   - Establecer método por defecto
   - Orden de visualización

6. **Sistema de Envíos (Simple Shipping)**
   - Habilitar/Deshabilitar envíos
   - Opción "Recoger en tienda" (gratis)
   - Zonas de envío:
     - Nombre de la zona
     - Costo fijo
     - Tiempo estimado
     - Departamentos y ciudades incluidas
   - Orden de zonas

7. **Cupones de Descuento**
   - CRUD de cupones
   - Tipos: porcentaje o monto fijo
   - Código único
   - Fecha de inicio y fin
   - Uso mínimo de compra
   - Número de usos (ilimitado o limitado)
   - Aplicable a:
     - Todos los productos
     - Categorías específicas
     - Productos específicos
   - Activar/Desactivar
   - Duplicar cupón

8. **Gestión de Pedidos**
   - Ver todos los pedidos
   - Filtros: estado, método de pago, tipo de envío
   - Búsqueda por número, cliente, teléfono
   - Cambiar estado del pedido
   - Ver detalles completos
   - Descargar comprobante de pago
   - Estadísticas rápidas (pendientes, completados, etc.)

9. **Ubicaciones/Sedes**
   - CRUD de sedes físicas
   - Datos: nombre, dirección, teléfono, email
   - Horarios de atención por día
   - Enlaces de redes sociales
   - WhatsApp con tracking de clics
   - Sede principal
   - Activar/Desactivar

10. **Tickets de Soporte**
    - Crear tickets
    - Categorías (técnico, facturación, general)
    - Adjuntar imágenes
    - Ver respuestas del soporte
    - Responder a tickets

11. **Facturación y Planes**
    - Ver plan actual
    - Ver próxima fecha de cobro
    - Solicitar cambio de plan
    - Ver historial de facturas
    - Descargar facturas en PDF
    - Cambiar ciclo de pago (mensual, trimestral, semestral)

---

### C. Tenant (Frontend Público)

**URL Base**: `/{store}/*`  
**Acceso**: Público (clientes)  
**Namespace**: `App\Features\Tenant`

#### Controladores:

```php
StorefrontController  // Páginas públicas de la tienda
OrderController       // Carrito y checkout
```

#### Páginas:

1. **Home** (`/{store}`)
   - Hero con slider
   - Productos destacados
   - Categorías
   - Información de la tienda

2. **Catálogo** (`/{store}/catalogo`)
   - Listado de productos
   - Búsqueda en tiempo real
   - Filtros por categoría
   - Paginación

3. **Producto** (`/{store}/producto/{slug}`)
   - Imágenes del producto
   - Descripción detallada
   - Selección de variantes
   - Agregar al carrito
   - Productos relacionados

4. **Categorías** (`/{store}/categorias`, `/{store}/categoria/{slug}`)
   - Ver categorías disponibles
   - Productos por categoría

5. **Carrito** (`/{store}/carrito`)
   - Ver productos agregados
   - Actualizar cantidades
   - Eliminar productos
   - Ver subtotal
   - Aplicar cupón
   - Proceder al checkout

6. **Checkout** (`/{store}/checkout`)
   - Datos del cliente
   - Seleccionar método de envío
   - Calcular costo de envío
   - Seleccionar método de pago
   - Subir comprobante (si es transferencia)
   - Confirmar pedido
   - Página de éxito/error

7. **Contacto** (`/{store}/contacto`)
   - Ver sedes físicas
   - Horarios
   - Mapa (futuro)
   - Formulario de contacto (futuro)

8. **Promociones** (`/{store}/promociones`)
   - Cupones activos
   - Productos con descuento

#### Sistema de Carrito:

```javascript
// Funciones principales
cart.addToCart(product, variant, quantity)
cart.updateCartItem(variantId, quantity)
cart.removeFromCart(variantId)
cart.clearCart()
cart.applyCoupon(code)
cart.getShippingCost(department, city, deliveryType)
```

- **Almacenamiento**: Sesión PHP
- **Persistencia**: Entre páginas
- **Cálculos**: Subtotal, descuento, envío, total
- **Validaciones**: Stock disponible, cupón válido

---

## 4. 🔄 FLUJOS CRÍTICOS

### A. Flujo de Creación de Tienda (Wizard)

**Ruta**: `/superlinkiu/stores/create-wizard`

#### Paso 1: Template y Plan
```
- Seleccionar plantilla de diseño (visual)
- Seleccionar plan:
  * Explorer (Gratis)
  * Creator ($50.000/mes)
  * Master ($100.000/mes)
  * Pro ($200.000/mes)
- Seleccionar ciclo de pago (mensual, trimestral, semestral)
```

#### Paso 2: Información del Dueño
```
- Nombre completo
- Email (validación en tiempo real)
- Teléfono
- Tipo de documento (CC, CE, Pasaporte)
- Número de documento
```

#### Paso 3: Información Fiscal
```
- Tipo de negocio: Persona Natural / Jurídica
- Tipo de documento fiscal: RUT / NIT / CC / CE
- Número de documento fiscal (validación RUT)
- Nombre o razón social
- Categoría de negocio (dropdown)
```

#### Paso 4: Configuración de Tienda
```
- Nombre de la tienda
- Slug (URL única) - validación en tiempo real
- País, Departamento, Ciudad (autocompletado)
- Dirección física
- Teléfono de la tienda
- Email de la tienda
```

#### Paso 5: Revisión y Confirmación
```
- Ver resumen de todos los datos
- Editar cualquier paso
- Toggle: "Crear y aprobar directamente"
- Botón: "Crear Tienda"
```

#### Sistema de Aprobación:

```php
if (toggle_aprobacion_directa) {
    crear_tienda();
    generar_credenciales();
    estado = 'approved';
    enviar_email('store_approved');
} elseif (validacion_rut_exitosa && categoria_no_requiere_revision) {
    crear_tienda();
    generar_credenciales();
    estado = 'approved';
    enviar_email('store_approved');
} else {
    crear_tienda();
    estado = 'pending_approval';
    enviar_email('store_pending_review');      // Al admin de tienda
    enviar_email('new_store_request');         // A super_admins
}
```

#### Emails Enviados (SendGrid):

1. **store_pending_review**
   - Para: Tenant Admin
   - Cuándo: Tienda requiere revisión manual
   - Variables: admin_name, store_name, business_type, estimated_time

2. **store_approved**
   - Para: Tenant Admin
   - Cuándo: Tienda aprobada (auto o manual)
   - Variables: admin_name, store_name, admin_email, password, login_url, store_url

3. **new_store_request**
   - Para: Todos los SuperAdmins
   - Cuándo: Nueva solicitud pendiente
   - Variables: store_name, business_type, admin_name, created_at, review_url

4. **store_rejected**
   - Para: Tenant Admin
   - Cuándo: Solicitud rechazada
   - Variables: admin_name, store_name, rejection_reason, rejection_message

---

### B. Flujo de Checkout (Cliente)

**Ruta**: `/{store}/checkout`

#### 1. Carrito Lleno
```
Cliente ha agregado productos al carrito
Puede aplicar cupón de descuento
```

#### 2. Datos del Cliente
```html
<form>
  <input name="customer_name" required>
  <input name="customer_phone" required>
  <select name="department" required> (autocompletado)
  <select name="city" required> (filtrado por departamento)
  <textarea name="customer_address" required>
</form>
```

#### 3. Método de Envío
```javascript
if (delivery_type === 'domicilio') {
    // Calcular costo según zona
    shipping_cost = getShippingCost(department, city);
} else if (delivery_type === 'pickup') {
    // Recoger en tienda (gratis)
    shipping_cost = 0;
}
```

#### 4. Método de Pago
```
Opciones:
- Transferencia Bancaria (requiere comprobante)
- Pago Contra Entrega
- Efectivo

Si es transferencia:
  - Mostrar cuentas bancarias disponibles
  - Permitir subir comprobante de pago
```

#### 5. Resumen y Confirmación
```
Subtotal:    $100.000
Descuento:   -$10.000  (Cupón: BIENVENIDO10)
Envío:       $5.000
---
Total:       $95.000

[Botón: Confirmar Pedido]
```

#### 6. Creación del Pedido
```php
$order = Order::create([
    'order_number' => 'TIE2510001',  // Auto-generado
    'status' => 'pending',
    'customer_name' => $request->customer_name,
    'customer_phone' => $request->customer_phone,
    'customer_address' => $request->customer_address,
    'department' => $request->department,
    'city' => $request->city,
    'delivery_type' => $request->delivery_type,
    'shipping_cost' => $shipping_cost,
    'payment_method' => $request->payment_method,
    'payment_proof_path' => $proof_path,  // Si aplica
    'subtotal' => $cart->subtotal,
    'coupon_discount' => $cart->discount,
    'total' => $total,
    'store_id' => $store->id,
]);

foreach ($cart->items as $item) {
    OrderItem::create([
        'order_id' => $order->id,
        'product_variant_id' => $item->variant_id,
        'quantity' => $item->quantity,
        'unit_price' => $item->price,
        'item_total' => $item->price * $item->quantity,
    ]);
}

// Limpiar carrito
$cart->clear();

// Notificación en tiempo real (Pusher)
broadcast(new NewOrderCreated($order));
```

#### 7. Página de Éxito
```
¡Pedido Confirmado!

Número de Pedido: TIE2510001
Estado: Pendiente

Te enviaremos una notificación cuando el pedido sea confirmado.
```

---

### C. Flujo de Tickets (Soporte)

#### Desde TenantAdmin:

**1. Crear Ticket**
```
Ruta: /{store}/admin/tickets/create

- Título del ticket
- Categoría (técnico, facturación, general)
- Descripción detallada
- Adjuntar imágenes (opcional)
- Estado inicial: 'open'
```

**2. SuperAdmin Recibe Notificación**
```
Pusher Canal: superlinkiu-notifications
Evento: ticket.created

SuperAdmin ve:
- Badge con contador de tickets abiertos
- Notificación en tiempo real
```

**3. SuperAdmin Responde**
```
Ruta: /superlinkiu/tickets/{ticket}/add-response

- Escribe respuesta
- Adjunta imágenes (opcional)
- Estado del ticket: 'in_progress'
```

**4. TenantAdmin Recibe Notificación**
```
Pusher Canal: store.{slug}.notifications
Evento: ticket.response.added

TenantAdmin ve:
- Badge con contador de mensajes nuevos
- Notificación en tiempo real
```

**5. TenantAdmin Lee Respuesta**
```
- Campo last_viewed_by_store actualizado
- Badge de mensajes nuevos se decrementa
```

**6. SuperAdmin Cierra Ticket**
```
Estado: 'resolved' o 'closed'
Email de notificación (futuro)
```

#### Contadores en Tiempo Real:

```javascript
// SuperLinkiu
{
  open_tickets: 5,        // tickets abiertos + in_progress
  new_messages: 3         // respuestas nuevas de store_admin
}

// TenantAdmin
{
  open_tickets: 2,        // tickets de esta tienda
  new_messages: 1         // respuestas nuevas de super_admin
}
```

---

### D. Flujo de Facturación

#### 1. Generación Automática (Cron Job - futuro)
```php
// Ejecutar diariamente
foreach (Subscription::needsInvoicing() as $subscription) {
    Invoice::generate($subscription);
    Mail::send('invoice_generated');
}
```

#### 2. Generación Manual (SuperAdmin)
```
Ruta: /superlinkiu/invoices/create

- Seleccionar tienda
- Período (mes/trimestre/semestre)
- Monto (calculado por plan)
- Fecha de vencimiento
- Generar factura
```

#### 3. Marcado como Pagada
```
Ruta: /superlinkiu/invoices/{invoice}/mark-as-paid

- Actualizar estado: 'paid'
- Registrar fecha de pago
- Método de pago
- Enviar email: 'payment_confirmed'
```

#### 4. Facturas Vencidas
```php
// Ejecutar diariamente
foreach (Invoice::overdue() as $invoice) {
    $invoice->update(['status' => 'overdue']);
    Mail::send('invoice_overdue');
}
```

#### 5. Vista de Factura (TenantAdmin)
```
Ruta: /{store}/admin/billing

- Ver facturas: pendientes, pagadas, vencidas
- Descargar PDF
- Ver detalles del plan actual
- Solicitar cambio de plan
```

---

## 5. 🎨 SISTEMA DE DISEÑO (TAILWIND)

### Configuración Completa

**Archivo**: `tailwind.config.js`

#### Escaneo de Archivos:
```javascript
content: [
  './resources/**/*.blade.php',
  './resources/**/*.js',
  './resources/**/*.vue',
  './app/Features/**/*.blade.php',  // Feature-based
  './app/Shared/**/*.blade.php',     // Shared resources
]
```

#### Tipografía

**Fuente**: Inter (sans-serif)

**Escalas de Tamaño (USAR ESTAS):**

```javascript
// Tipografía nueva (RECOMENDADA)
'h1': '72px',          // line-height: 120%
'h2': '64px',          // line-height: 120%
'h3': '56px',          // line-height: 120%
'h4': '48px',          // line-height: 120%
'h5': '40px',          // line-height: 120%
'h6': '32px',          // line-height: 120%
'h7': '24px',          // line-height: 120%
'body-large': '20px',  // line-height: 120%
'body-regular': '16px',// line-height: 120%
'body-small': '14px',  // line-height: 120%
'caption': '12px',     // line-height: 120%
'small': '10px',       // line-height: 120%
```

**Uso en HTML:**
```html
<h1 class="text-h1 font-bold">Título Principal</h1>
<h2 class="text-h2 font-semibold">Subtítulo</h2>
<p class="text-body-regular font-regular">Párrafo normal</p>
<span class="text-caption font-light">Texto pequeño</span>
```

**Pesos Tipográficos (USAR ESTOS):**

```javascript
// Pesos tipográficos nuevos (RECOMENDADOS)
'light': '300',      // font-light
'regular': '400',    // font-regular
'medium': '600',     // font-medium
'bold': '700',       // font-bold
'extrabold': '800',  // font-extrabold
```

---

### Paleta de Colores (USAR ESTAS)

#### 🔴 Error (Rojo nuevo)
```javascript
error: {
  50: '#fdeaec',   // Más claro
  75: '#f8a9b3',
  100: '#f58693',
  200: '#f05265',
  300: '#ed2e45',  // Principal
  400: '#a62030',
  500: '#911c2a',  // Más oscuro
}
```

**Uso:**
```html
<div class="bg-error-300 text-white">Error principal</div>
<p class="text-error-300">Texto de error</p>
<button class="bg-error-400 hover:bg-error-500">Botón error</button>
```

---

#### 🔵 Info (Azul nuevo)
```javascript
info: {
  50: '#e6e6ff',   // Más claro
  75: '#9696ff',
  100: '#6b6bfe',
  200: '#2b2bfe',
  300: '#0000fe',  // Principal
  400: '#0000b2',
  500: '#00009b',  // Más oscuro
}
```

**Uso:**
```html
<div class="bg-info-300 text-white">Información importante</div>
<div class="border border-info-300">Borde azul</div>
<span class="text-info-400">Texto azul</span>
```

---

#### 🟢 Success (Verde nuevo)
```javascript
success: {
  50: '#e6f9f1',   // Más claro
  75: '#96e8c4',
  100: '#6bdfab',
  200: '#2bd187',
  300: '#00c76f',  // Principal
  400: '#008b4e',
  500: '#007944',  // Más oscuro
}
```

**Uso:**
```html
<div class="bg-success-300 text-white">¡Éxito!</div>
<button class="bg-success-400 hover:bg-success-500">Confirmar</button>
<p class="text-success-300">Operación exitosa</p>
```

---

#### 🟡 Warning (Amarillo nuevo)
```javascript
warning: {
  50: '#fff7e7',   // Más claro
  75: '#ffdd9c',
  100: '#ffcf73',
  200: '#ffbb36',
  300: '#ffad0d',  // Principal
  400: '#b37909',
  500: '#9c6a08',  // Más oscuro
}
```

**Uso:**
```html
<div class="bg-warning-300 text-black-300">Advertencia</div>
<div class="border-l-4 border-warning-300 bg-warning-50 p-4">
  Mensaje de advertencia
</div>
```

---

#### ⚫ Black (Negro nuevo - Textos)
```javascript
black: {
  50: '#e8e8e9',   // Más claro
  75: '#a2a2a3',
  100: '#7b7b7d',
  200: '#434344',
  300: '#1c1c1e',  // Principal (textos)
  400: '#141415',
  500: '#111112',  // Más oscuro
}
```

**Uso:**
```html
<p class="text-black-300">Texto principal</p>
<h1 class="text-black-400 font-bold">Título oscuro</h1>
<span class="text-black-100">Texto secundario</span>
```

---

#### ⚪ Disabled (Grises nuevos)
```javascript
disabled: {
  50: '#fdfdfd',   // Casi blanco
  75: '#f8f8f8',
  100: '#f6f6f6',
  200: '#f2f2f2',
  300: '#efefef',  // Principal
  400: '#a7a7a7',  // Texto deshabilitado
  500: '#929292',  // Más oscuro
}
```

**Uso:**
```html
<button disabled class="bg-disabled-300 text-disabled-400 cursor-not-allowed">
  Deshabilitado
</button>
<input disabled class="bg-disabled-100 text-disabled-400">
```

---

#### 💜 Accent (Blanco nuevo - Acentos)
```javascript
accent: {
  50: '#fdfdff',   // Más claro
  75: '#f6f5fd',
  100: '#f2f1fd',
  200: '#eceafc',
  300: '#e8e6fb',  // Principal
  400: '#a2a1b0',
  500: '#8e8c99',  // Más oscuro
}
```

**Uso:**
```html
<div class="bg-accent-300">Fondo suave</div>
<div class="bg-accent-50 border border-accent-200">Tarjeta</div>
```

---

### Colores Existentes (Primary y Secondary)

#### 🟣 Primary (Rosa/Magenta)
```javascript
primary: {
  50: '#fbe9f6',
  300: '#da27a7',  // Principal
  500: '#851866',
}
```

#### 🔵 Secondary (Azul Oscuro)
```javascript
secondary: {
  50: '#e6e8ed',
  300: '#001b48',  // Principal
  500: '#00102c',
}
```

---

### Ejemplos de Uso Combinado

#### Botones:
```html
<!-- Primario -->
<button class="bg-primary-300 hover:bg-primary-400 text-white font-medium px-4 py-2 rounded">
  Acción Principal
</button>

<!-- Éxito -->
<button class="bg-success-300 hover:bg-success-400 text-white font-medium px-4 py-2 rounded">
  Guardar
</button>

<!-- Error -->
<button class="bg-error-300 hover:bg-error-400 text-white font-medium px-4 py-2 rounded">
  Eliminar
</button>

<!-- Deshabilitado -->
<button disabled class="bg-disabled-300 text-disabled-400 cursor-not-allowed px-4 py-2 rounded">
  No disponible
</button>
```

#### Alertas:
```html
<!-- Success -->
<div class="bg-success-50 border-l-4 border-success-300 text-success-500 p-4 rounded">
  <p class="font-medium">¡Operación exitosa!</p>
  <p class="text-body-small">Los cambios se guardaron correctamente.</p>
</div>

<!-- Error -->
<div class="bg-error-50 border-l-4 border-error-300 text-error-500 p-4 rounded">
  <p class="font-medium">Error al procesar</p>
  <p class="text-body-small">Por favor, intenta de nuevo.</p>
</div>

<!-- Warning -->
<div class="bg-warning-50 border-l-4 border-warning-300 text-warning-500 p-4 rounded">
  <p class="font-medium">Atención</p>
  <p class="text-body-small">Esta acción no se puede deshacer.</p>
</div>

<!-- Info -->
<div class="bg-info-50 border-l-4 border-info-300 text-info-500 p-4 rounded">
  <p class="font-medium">Información</p>
  <p class="text-body-small">Recuerda verificar los datos antes de continuar.</p>
</div>
```

#### Badges:
```html
<span class="bg-success-100 text-success-500 px-2 py-1 rounded-full text-caption">
  Activo
</span>

<span class="bg-error-100 text-error-500 px-2 py-1 rounded-full text-caption">
  Inactivo
</span>

<span class="bg-warning-100 text-warning-500 px-2 py-1 rounded-full text-caption">
  Pendiente
</span>

<span class="bg-info-100 text-info-500 px-2 py-1 rounded-full text-caption">
  Nuevo
</span>
```

#### Inputs:
```html
<!-- Normal -->
<input class="border border-disabled-300 focus:border-primary-300 px-4 py-2 rounded">

<!-- Error -->
<input class="border border-error-300 focus:border-error-400 px-4 py-2 rounded">

<!-- Success -->
<input class="border border-success-300 focus:border-success-400 px-4 py-2 rounded">

<!-- Disabled -->
<input disabled class="bg-disabled-100 border border-disabled-300 text-disabled-400 px-4 py-2 rounded">
```

---

### Dark Mode

```javascript
darkMode: 'class'  // Activar con clase 'dark' en elemento padre
```

**Uso:**
```html
<html class="dark">
  <div class="bg-white dark:bg-black-500 text-black-300 dark:text-white">
    Contenido
  </div>
</html>
```

---

## 6. 📦 DEPENDENCIAS EXTERNAS

### A. SendGrid (Emails Transaccionales)

**Versión**: 8.1  
**Documentación**: https://sendgrid.com/docs/

#### Configuración:

```env
SENDGRID_API_KEY=SG.xxxxxxxxxxxxx
```

#### Templates Configurados:

| Template | ID | Uso |
|----------|-----|-----|
| store_pending_review | d-abc123 | Solicitud en revisión |
| store_approved | d-def456 | Tienda aprobada |
| store_rejected | d-ghi789 | Solicitud rechazada |
| new_store_request | d-jkl012 | Nueva solicitud (super_admins) |

#### Remitentes por Categoría:

```php
'store_management' => 'tiendas@linkiu.email',
'tickets' => 'soporte@linkiu.email',
'billing' => 'facturas@linkiu.email',
```

#### Uso en Código:

```php
use App\Services\SendGridEmailService;

$emailService = new SendGridEmailService();

$result = $emailService->sendWithTemplate(
    templateId: 'd-abc123',
    to: 'admin@tienda.com',
    variables: [
        'admin_name' => 'Juan Pérez',
        'store_name' => 'Mi Tienda',
    ],
    toName: 'Juan Pérez',
    category: 'store_management'
);
```

---

### B. Pusher (WebSockets / Tiempo Real)

**Versión**: 7.2 (PHP), 8.4.0 (JS)  
**Documentación**: https://pusher.com/docs/

#### Configuración:

```env
PUSHER_APP_ID=1234567
PUSHER_APP_KEY=xxxxxxxxxxxxx
PUSHER_APP_SECRET=xxxxxxxxxxxxx
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

#### Canales Públicos:

```javascript
// SuperLinkiu (super_admin)
'superlinkiu-notifications'

// TenantAdmin (store_admin)
'store.{slug}.notifications'
```

#### Eventos:

```javascript
'ticket.response.added'
'order.created'
'order.status.changed'
'announcement.created'
```

#### Uso en Frontend:

```javascript
// app.js
window.Echo.channel('superlinkiu-notifications')
  .listen('.ticket.response.added', (e) => {
    console.log('Nueva respuesta:', e);
    updateNotificationBadge();
  });
```

#### Uso en Backend:

```php
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketResponseAdded implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new Channel('superlinkiu-notifications');
    }

    public function broadcastAs()
    {
        return 'ticket.response.added';
    }
}

// Disparar evento
broadcast(new TicketResponseAdded($ticket));
```

---

### C. AWS S3 (Almacenamiento)

**Versión**: league/flysystem-aws-s3-v3 3.0  
**Documentación**: https://flysystem.thephpleague.com/docs/adapter/aws-s3/

#### Configuración:

```env
AWS_ACCESS_KEY_ID=xxxxxxxxxxxxx
AWS_SECRET_ACCESS_KEY=xxxxxxxxxxxxx
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=linkiu-production
AWS_USE_PATH_STYLE_ENDPOINT=false
```

#### Uso:

```php
use Illuminate\Support\Facades\Storage;

// Subir archivo
Storage::disk('s3')->put('logos/store-123.png', $file);

// Obtener URL
$url = Storage::disk('s3')->url('logos/store-123.png');

// Eliminar archivo
Storage::disk('s3')->delete('logos/store-123.png');
```

---

### D. Otros Servicios

#### dompdf (Generación de PDFs)

```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice]);
return $pdf->download("factura-{$invoice->invoice_number}.pdf");
```

#### Excel (Exportación)

```php
use Maatwebsite\Excel\Facades\Excel;
use App\Features\SuperLinkiu\Exports\StoresExport;

return Excel::download(new StoresExport, 'tiendas.xlsx');
```

---

## 7. 💾 BASE DE DATOS

### Modelos Principales y Relaciones

#### Store (Tienda)
```php
// Relaciones
belongsTo: Plan, BusinessCategory, User (approvedBy)
hasMany: 
  - admins (Users)
  - products, categories, variables, sliders
  - orders, orderItems
  - tickets, ticketResponses
  - locations, locationSchedules
  - bankAccounts, paymentMethods
  - coupons, couponUsageLogs
  - invoices, subscriptions
hasOne: 
  - design (StoreDesign)
  - policies (StorePolicy)
  - simpleShipping (SimpleShipping)

// Campos importantes
- slug (URL única)
- status (active, inactive, suspended)
- verified (badge de verificación)
- approval_status (pending, approved, rejected)
- business_category_id
- plan_id
```

#### User (Usuario)
```php
// Roles
roles: 'super_admin', 'store_admin'

// Relaciones
belongsTo: Store
hasMany: storeDrafts, tickets

// Campos importantes
- name, email, password
- role
- store_id
- last_login_at
- avatar_path
```

#### Order (Pedido)
```php
// Estados
STATUS_PENDING
STATUS_CONFIRMED
STATUS_PREPARING
STATUS_READY_FOR_PICKUP
STATUS_SHIPPED
STATUS_OUT_FOR_DELIVERY
STATUS_DELIVERED
STATUS_CANCELLED

// Relaciones
belongsTo: Store, Coupon
hasMany: items (OrderItem), statusHistory

// Campos importantes
- order_number (auto-generado: TIE2510001)
- status
- customer_name, customer_phone, customer_address
- department, city
- delivery_type (domicilio, pickup)
- shipping_cost
- payment_method, payment_proof_path
- subtotal, coupon_discount, total
```

#### Product (Producto)
```php
// Relaciones
belongsTo: Store, mainImage
hasMany: 
  - images (ProductImage)
  - variants (ProductVariant)
  - categories (many-to-many)
  - variableAssignments

// Campos importantes
- name, slug, description
- base_price
- stock
- is_active
- main_image_id
```

#### Ticket (Ticket de Soporte)
```php
// Estados
'open', 'in_progress', 'resolved', 'closed'

// Prioridades
'low', 'medium', 'high', 'urgent'

// Relaciones
belongsTo: Store, category (TicketCategory)
hasMany: responses (TicketResponse)

// Campos importantes
- title, description
- status, priority
- attachments (JSON)
- last_viewed_by_store
- last_viewed_by_admin
```

#### Plan (Plan de Suscripción)
```php
// Relaciones
hasMany: stores, planExtensions

// Límites configurables
- max_products
- max_categories
- max_variables
- max_slider
- max_active_coupons
- max_sedes
- max_delivery_zones
- max_bank_accounts
- max_admins
- analytics_retention_days
- support_level ('basic', 'priority', 'vip')

// Precios
- price (mensual base)
- prices (JSON: monthly, quarterly, semester)
```

---

### Migraciones Importantes

| Migración | Descripción |
|-----------|-------------|
| create_stores_table | Tabla principal de tiendas |
| create_plans_table | Planes de suscripción |
| create_subscriptions_table | Relación Store-Plan |
| create_orders_table | Pedidos |
| create_products_table | Productos con variantes |
| create_tickets_table | Sistema de soporte |
| create_invoices_table | Facturación |
| create_simple_shipping_table | Sistema de envíos |
| create_email_configurations_table | Config SendGrid |
| add_approval_fields_to_stores_table | Sistema de aprobación |

---

### Seeders

```bash
php artisan db:seed --class=SuperAdminSeeder    # Crear super_admin
php artisan db:seed --class=PlansSeeder         # Crear planes
php artisan db:seed --class=CategoryIconsSeeder # Iconos de categorías
```

---

## 8. ☁️ HOSTING Y DEPLOYMENT (LARAVEL CLOUD)

### ¿Qué es Laravel Cloud?

**Laravel Cloud** es la plataforma oficial de hosting para aplicaciones Laravel, desarrollada por el equipo de Laravel. Fue lanzada en 2024 y está diseñada para simplificar el deployment y la gestión de aplicaciones Laravel en producción.

### Características Principales

#### 1. **Deployment Automático**
- Integración nativa con GitHub/GitLab
- Deploy automático al hacer push a la rama principal
- Builds optimizados con caché inteligente
- Rollback instantáneo a versiones anteriores

#### 2. **Infraestructura Optimizada**
- Servidores optimizados para Laravel
- PHP 8.2+ preconfigurado
- MySQL, PostgreSQL, Redis disponibles
- Escalado automático según tráfico
- CDN global incluido

#### 3. **Base de Datos Gestionada**
- Backups automáticos diarios
- Restauración point-in-time
- Réplicas de lectura (read replicas)
- Monitoring de performance

#### 4. **Queue Workers**
- Workers configurables para colas
- Supervisord preconfigurado
- Escalado automático de workers
- Logs centralizados

#### 5. **Scheduled Tasks**
- Cron jobs integrados
- Configuración desde la interfaz
- Logs de ejecución
- Notificaciones de fallos

#### 6. **SSL/TLS Automático**
- Certificados Let's Encrypt automáticos
- Renovación automática
- HTTP/2 habilitado
- Dominios personalizados

#### 7. **Monitoreo y Logs**
- Dashboard con métricas en tiempo real
- Logs centralizados
- Alertas configurables
- Performance insights

#### 8. **Colaboración en Equipo**
- Múltiples ambientes (staging, production)
- Control de acceso por rol
- Variables de entorno por ambiente
- Activity log

---

### Configuración del Proyecto en Laravel Cloud

#### Estructura de Ambientes

```
Liniu Final
├── Production         # Rama: main/master
├── Staging           # Rama: staging
└── Development       # Rama: develop (local)
```

#### Variables de Entorno (Production)

```env
# Aplicación
APP_NAME="Linkiu.bio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://linkiu.com.co

# Base de Datos (gestionada por Laravel Cloud)
DB_CONNECTION=mysql
DB_HOST=<auto-configurado>
DB_DATABASE=linkiu_production
DB_USERNAME=<auto-configurado>
DB_PASSWORD=<auto-configurado>

# SendGrid
SENDGRID_API_KEY=${SENDGRID_KEY_PROD}

# Pusher
PUSHER_APP_ID=${PUSHER_ID_PROD}
PUSHER_APP_KEY=${PUSHER_KEY_PROD}
PUSHER_APP_SECRET=${PUSHER_SECRET_PROD}
PUSHER_APP_CLUSTER=mt1

# AWS S3
AWS_ACCESS_KEY_ID=${AWS_KEY_PROD}
AWS_SECRET_ACCESS_KEY=${AWS_SECRET_PROD}
AWS_BUCKET=linkiu-production

# Queue
QUEUE_CONNECTION=redis
```

---

### Deployment Workflow

#### 1. **Desarrollo Local**
```bash
git checkout develop
# Hacer cambios
git add .
git commit -m "Feature: Nueva funcionalidad"
git push origin develop
```

#### 2. **Testing en Staging**
```bash
git checkout staging
git merge develop
git push origin staging

# Laravel Cloud detecta el push y despliega automáticamente
# URL: https://staging.linkiu.com.co
```

**Usuario dice**: "Listo para Staging"
→ Se hace merge de `develop` a `staging`

#### 3. **Deploy a Production**
```bash
git checkout main
git merge staging
git push origin main

# Laravel Cloud despliega a producción
# URL: https://linkiu.com.co
```

**Usuario dice**: "Listo para Production"
→ Se hace merge de `staging` a `main`

---

### Build Script (Laravel Cloud)

```bash
# Archivo: .cloud/build.sh (auto-generado)

# Instalar dependencias PHP
composer install --no-dev --optimize-autoloader

# Instalar dependencias Node
npm ci

# Compilar assets
npm run build

# Optimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
php artisan migrate --force

# Limpiar caché de aplicación
php artisan cache:clear
```

---

### Queue Workers

**Configuración en Laravel Cloud:**

```yaml
workers:
  - name: default
    connection: redis
    queue: default
    processes: 3
    tries: 3
    timeout: 60
    
  - name: emails
    connection: redis
    queue: emails
    processes: 2
    tries: 3
    timeout: 90
```

---

### Scheduled Tasks (Cron)

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // Facturación automática
    $schedule->command('invoices:generate-monthly')
             ->monthlyOn(1, '00:00');
    
    // Actualizar facturas vencidas
    $schedule->command('invoices:update-overdue')
             ->daily();
    
    // Limpiar borradores antiguos
    $schedule->command('drafts:cleanup')
             ->daily();
    
    // Backup de base de datos (gestionado por Laravel Cloud)
    // No es necesario configurar manualmente
}
```

---

### Monitoreo y Alertas

**Dashboard de Laravel Cloud incluye:**

- ✅ Request rate (peticiones por minuto)
- ✅ Response times (P50, P95, P99)
- ✅ Error rates (4xx, 5xx)
- ✅ Queue depths (trabajos pendientes)
- ✅ Memory usage
- ✅ CPU usage
- ✅ Database queries (slow query log)

**Alertas configuradas:**

```yaml
alerts:
  - name: High Error Rate
    condition: error_rate > 5%
    notification: email, slack
    
  - name: Slow Response Times
    condition: p95_response > 2000ms
    notification: email
    
  - name: Queue Backlog
    condition: queue_depth > 1000
    notification: slack
```

---

### Rollback de Emergencia

```bash
# Desde Laravel Cloud Dashboard
1. Ir a "Deployments"
2. Seleccionar versión anterior estable
3. Clic en "Rollback to this version"
4. Confirmar

# Rollback instantáneo (< 30 segundos)
```

---

### Dominios Personalizados

**Configuración en Laravel Cloud:**

```
Production: linkiu.com.co → CNAME: xyz.laravel.cloud
Staging: staging.linkiu.com.co → CNAME: abc.laravel.cloud
```

**DNS Records:**
```
Type    Name                    Value
CNAME   @                       xyz.laravel.cloud
CNAME   staging                 abc.laravel.cloud
CNAME   www                     xyz.laravel.cloud
```

---

### Costos Estimados (Laravel Cloud)

```
Plan Base:           $19/mes
  - 1 aplicación
  - SSL incluido
  - Backups automáticos
  - 100GB storage
  - 1TB bandwidth

Recursos Adicionales:
  - Database replica:  +$10/mes
  - Extra worker:      +$5/mes
  - S3 storage:        Por uso (AWS pricing)
```

---

## 9. 🔐 SEGURIDAD Y MIDDLEWARES

### Middlewares Principales

#### 1. SuperAdminMiddleware
```php
namespace App\Shared\Middleware;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('superlinkiu.login');
        }

        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
```

**Uso:**
```php
Route::middleware(['auth', 'super.admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

---

#### 2. StoreAdminMiddleware
```php
namespace App\Shared\Middleware;

class StoreAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            $storeSlug = $request->segment(1);
            return redirect()->route('tenant.admin.login', $storeSlug);
        }

        if (auth()->user()->role !== 'store_admin') {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
```

---

#### 3. TenantIdentificationMiddleware
```php
namespace App\Shared\Middleware;

class TenantIdentificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $storeSlug = $request->route('store');
        
        if ($storeSlug) {
            $store = Store::where('slug', $storeSlug)
                ->withCount(['products', 'categories', 'variables', 'sliders'])
                ->with('plan')
                ->first();
            
            if (!$store) {
                abort(404, 'Tienda no encontrada');
            }
            
            // Establecer tenant actual
            $this->tenantService->setTenant($store);
            
            // Reemplazar slug con modelo
            $request->route()->setParameter('store', $store);
            
            // Compartir con vistas
            view()->share('currentStore', $store);
        }
        
        return $next($request);
    }
}
```

---

#### 4. CheckStoreApprovalStatus
```php
class CheckStoreApprovalStatus
{
    public function handle($request, Closure $next)
    {
        $store = $request->route('store');
        
        if ($store->approval_status === 'pending') {
            return view('tenant::stores.pending-approval', compact('store'));
        }
        
        if ($store->approval_status === 'rejected') {
            return view('tenant::stores.rejected', compact('store'));
        }
        
        return $next($request);
    }
}
```

---

### Rate Limiting

```php
// routes/web.php
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')  // 5 intentos por minuto
    ->name('login.submit');
```

---

### CSRF Protection

```php
// Automático en formularios
<form method="POST" action="/superlinkiu/stores">
    @csrf
    <!-- campos -->
</form>

// En JavaScript (Axios)
axios.defaults.headers.common['X-CSRF-TOKEN'] = 
    document.querySelector('meta[name="csrf-token"]').content;
```

---

### Autenticación

```php
// Login
if (Auth::attempt($credentials)) {
    $user->updateLastLogin();
    return redirect()->intended('/dashboard');
}

// Logout
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
```

---

## 10. 🔔 SISTEMA DE NOTIFICACIONES

### Pusher - Tiempo Real

#### Configuración Frontend

```javascript
// app.js
window.Pusher = Pusher;
window.pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    maxReconnectionAttempts: 3
});

// Echo-like object para compatibilidad
window.Echo = {
    channel: function(channelName) {
        const channel = window.pusher.subscribe(channelName);
        return {
            listen: function(eventName, callback) {
                const cleanEventName = eventName.startsWith('.') 
                    ? eventName.substring(1) 
                    : eventName;
                channel.bind(cleanEventName, callback);
                return this;
            }
        };
    }
};
```

---

#### Suscripción a Canales

**SuperLinkiu:**
```javascript
// notifications.js
window.Echo.channel('superlinkiu-notifications')
    .listen('.ticket.response.added', (e) => {
        console.log('Nueva respuesta en ticket:', e.ticket);
        updateTicketBadge();
        showNotification('Nueva respuesta de soporte');
    })
    .listen('.order.created', (e) => {
        console.log('Nuevo pedido:', e.order);
        updateOrderBadge();
    });
```

**TenantAdmin:**
```javascript
const storeSlug = document.querySelector('[data-store-slug]').dataset.storeSlug;

window.Echo.channel(`store.${storeSlug}.notifications`)
    .listen('.ticket.response.added', (e) => {
        console.log('Respuesta del soporte:', e.ticket);
        updateTicketBadge();
        showNotification('Nueva respuesta del soporte técnico');
    })
    .listen('.order.created', (e) => {
        console.log('Nuevo pedido:', e.order);
        playOrderSound();
        updateOrderBadge();
    });
```

---

#### Disparar Eventos desde Backend

```php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketResponseAdded implements ShouldBroadcast
{
    public $ticket;
    public $response;

    public function __construct($ticket, $response)
    {
        $this->ticket = $ticket;
        $this->response = $response;
    }

    public function broadcastOn()
    {
        if ($this->response->user->role === 'super_admin') {
            // Notificar a la tienda
            return new Channel("store.{$this->ticket->store->slug}.notifications");
        } else {
            // Notificar a super_admins
            return new Channel('superlinkiu-notifications');
        }
    }

    public function broadcastAs()
    {
        return 'ticket.response.added';
    }

    public function broadcastWith()
    {
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'title' => $this->ticket->title,
            ],
            'response' => [
                'content' => $this->response->content,
                'user' => $this->response->user->name,
            ],
        ];
    }
}

// Uso
broadcast(new TicketResponseAdded($ticket, $response));
```

---

### Contadores de Notificaciones

#### API Endpoints

**SuperLinkiu:**
```php
// routes/web.php
Route::get('/api/superlinkiu/notifications', function () {
    return response()->json([
        'open_tickets' => Ticket::whereIn('status', ['open', 'in_progress'])->count(),
        'new_messages' => Ticket::with('responses.user')
            ->get()
            ->sum(function($ticket) {
                return $ticket->new_store_responses_count;
            }),
    ]);
})->middleware(['web', 'auth']);
```

**TenantAdmin:**
```php
Route::get('/api/tenant/{store}/notifications', function ($storeSlug) {
    $store = Store::where('slug', $storeSlug)->firstOrFail();
    
    return response()->json([
        'open_tickets' => $store->tickets()->whereIn('status', ['open', 'in_progress'])->count(),
        'new_messages' => $store->unread_support_responses_count,
    ]);
})->middleware(['web', 'auth']);
```

---

#### Actualización en Frontend

```javascript
// notifications.js
function updateNotificationBadges() {
    fetch('/api/superlinkiu/notifications')
        .then(r => r.json())
        .then(data => {
            document.querySelector('#ticket-badge').textContent = data.open_tickets;
            document.querySelector('#message-badge').textContent = data.new_messages;
        });
}

// Actualizar cada 30 segundos
setInterval(updateNotificationBadges, 30000);

// Actualizar al recibir evento de Pusher
window.Echo.channel('superlinkiu-notifications')
    .listen('.ticket.response.added', () => {
        updateNotificationBadges();
    });
```

---

## 11. 🚀 FLUJO DE TRABAJO CON RAMAS

### Entornos y Ramas

```
┌─────────────┐
│   LOCAL     │  Branch: develop
│  (Laragon)  │  URL: http://localhost
└─────┬───────┘
      │ "Listo para Staging"
      ↓
┌─────────────┐
│   STAGING   │  Branch: staging
│ (L. Cloud)  │  URL: https://staging.linkiu.com.co
└─────┬───────┘
      │ "Listo para Production"
      ↓
┌─────────────┐
│ PRODUCTION  │  Branch: main
│ (L. Cloud)  │  URL: https://linkiu.com.co
└─────────────┘
```

---

### Flujo Detallado

#### 1. Desarrollo Local

```bash
# Trabajar en rama develop
git checkout develop

# Crear feature branch (opcional)
git checkout -b feature/nueva-funcionalidad

# Hacer cambios
# ... editar archivos ...

# Commit
git add .
git commit -m "Feature: Agregar sistema de cupones"

# Merge a develop (si estás en feature branch)
git checkout develop
git merge feature/nueva-funcionalidad

# Push a develop
git push origin develop
```

**Pruebas locales:**
```bash
php artisan serve
npm run dev
php artisan test
```

---

#### 2. Paso a Staging

**Usuario dice: "Listo para Staging"**

```bash
# Cambiar a rama staging
git checkout staging

# Merge desde develop
git merge develop

# Resolver conflictos si los hay
# ... resolver conflictos ...
git add .
git commit -m "Merge develop into staging"

# Push a staging
git push origin staging

# Laravel Cloud detecta el push y despliega automáticamente
```

**Verificaciones en Staging:**
- ✅ Funcionalidad nueva funciona correctamente
- ✅ No hay errores en logs
- ✅ Performance es aceptable
- ✅ Usuarios de prueba pueden usar el sistema
- ✅ Diseño se ve correcto en diferentes dispositivos

---

#### 3. Paso a Production

**Usuario dice: "Listo para Production"**

```bash
# Cambiar a rama main
git checkout main

# Merge desde staging
git merge staging

# Push a main
git push origin main

# Laravel Cloud despliega a producción
```

**Verificaciones Post-Deploy:**
- ✅ Funcionalidad desplegada funciona
- ✅ No hay errores críticos
- ✅ Usuarios pueden acceder normalmente
- ✅ Monitoring muestra métricas normales

---

### Rollback de Emergencia

**Si algo sale mal en Production:**

```bash
# Opción 1: Rollback en Laravel Cloud (RECOMENDADO)
1. Dashboard de Laravel Cloud
2. Deployments > Seleccionar versión anterior
3. Rollback

# Opción 2: Revert del commit
git revert HEAD
git push origin main
```

---

### Git Tags para Versiones

```bash
# Crear tag después de deploy exitoso
git tag -a v1.2.0 -m "Release v1.2.0: Sistema de cupones"
git push origin v1.2.0

# Ver tags
git tag -l

# Checkout a versión específica
git checkout v1.2.0
```

---

### Comandos Git Útiles

```bash
# Ver estado
git status

# Ver historial
git log --oneline --graph --all

# Ver diferencias
git diff staging..main

# Descartar cambios locales
git restore .

# Ver ramas
git branch -a

# Eliminar rama local
git branch -d feature/vieja-funcionalidad

# Actualizar desde remoto
git pull origin develop
```

---

## 12. 🛠️ COMANDOS ÚTILES

### Artisan (Laravel)

```bash
# Servidor de desarrollo
php artisan serve

# Ejecutar migraciones
php artisan migrate
php artisan migrate:fresh --seed  # Resetear DB

# Crear modelos
php artisan make:model Product -mfs  # Con migration, factory, seeder

# Crear controladores
php artisan make:controller ProductController --resource

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Queue workers
php artisan queue:work
php artisan queue:listen --tries=3
php artisan queue:restart

# Ver rutas
php artisan route:list
php artisan route:list --path=superlinkiu

# Tinker (REPL)
php artisan tinker
```

---

### Composer

```bash
# Instalar dependencias
composer install
composer install --no-dev  # Sin dependencias de desarrollo

# Actualizar dependencias
composer update

# Agregar paquete
composer require sendgrid/sendgrid

# Autoload
composer dump-autoload
```

---

### NPM (Node)

```bash
# Instalar dependencias
npm install

# Desarrollo (watch mode)
npm run dev

# Build para producción
npm run build

# Ver dependencias desactualizadas
npm outdated

# Actualizar dependencias
npm update
```

---

### Base de Datos

```bash
# Crear backup
mysqldump -u root -p linkiu_db > backup.sql

# Restaurar backup
mysql -u root -p linkiu_db < backup.sql

# Conectar a MySQL
mysql -u root -p

# Ver tablas
SHOW TABLES;

# Describir tabla
DESCRIBE stores;
```

---

### Laravel Cloud CLI (Futuro)

```bash
# Login
cloud login

# Ver aplicaciones
cloud apps

# Ver deployments
cloud deployments linkiu

# Logs en tiempo real
cloud logs linkiu --tail

# Ejecutar comando en servidor
cloud ssh linkiu
cloud command linkiu "php artisan migrate"

# Ver variables de entorno
cloud env linkiu
```

---

## 📝 NOTAS FINALES

### Documentos de Referencia

1. **docs/GESTION_TIENDAS.md** - Guía para operadores del sistema
2. **docs/SENDGRID_STORE_APPROVAL_TEMPLATES.md** - Configuración de templates de email
3. **tests/EMAIL_TEST_DOCUMENTATION.md** - Pruebas de sistema de emails

---

### Contactos de Soporte

```
Técnico:           soporte@linkiu.email
Facturación:       facturas@linkiu.email
Gestión de Tiendas: tiendas@linkiu.email
```

---

### Palabras Clave del Flujo

🔑 **"Listo para Staging"** → Mover cambios de Local a Staging  
🔑 **"Listo para Production"** → Mover cambios de Staging a Production

---

**Fecha de creación**: Octubre 2025  
**Última actualización**: Octubre 2025  
**Versión**: 1.0  
**Proyecto**: LINKIU  
**Hosting**: Laravel Cloud

