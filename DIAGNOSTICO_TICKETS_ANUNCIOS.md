# 🔍 DIAGNÓSTICO EXHAUSTIVO - TICKETS Y ANUNCIOS

## 📋 RESUMEN EJECUTIVO

**Fecha de revisión:** 16 de Octubre, 2025  
**Módulos analizados:**
- Sistema de Tickets (SuperLinkiu ↔ TenantAdmin)
- Sistema de Anuncios (SuperLinkiu → TenantAdmin)
- Notificaciones en tiempo real (Pusher/WebSockets)
- Integración de emails (SendGrid)

---

## 🔴 PROBLEMAS CRÍTICOS ENCONTRADOS

### 1. **TICKETS: Atributo `is_from_store` NO EXISTE** ❌

**Ubicación:**  
- `app/Events/TicketResponseAdded.php` líneas 33, 69, 70
- `app/Events/NewTicketResponse.php` líneas 29, 65, 66

**Problema:**  
El evento intenta acceder a `$response->is_from_store` pero este atributo no existe en el modelo `TicketResponse.php`.

**Código actual (INCORRECTO):**
```php
// app/Events/TicketResponseAdded.php línea 33
$this->isForSupport = $this->response->is_from_store;
```

**Impacto:**  
- ❌ **Error fatal** al disparar el evento
- ❌ **Notificaciones Pusher NO funcionan** para tickets
- ❌ **Emails NO se envían** correctamente
- ❌ Los eventos fallan silenciosamente en producción

**Solución requerida:**  
Agregar el accessor `getIsFromStoreAttribute()` al modelo `TicketResponse`:

```php
public function getIsFromStoreAttribute(): bool
{
    // Una respuesta es de la tienda si el usuario es store_admin
    return $this->user && $this->user->role === 'store_admin';
}
```

**Alternativa:**  
Modificar los eventos para usar la relación existente:
```php
$this->isForSupport = $this->response->user && $this->response->user->role === 'store_admin';
```

---

### 2. **TICKETS: Evento `NewTicketResponse` DUPLICADO** ⚠️

**Ubicación:**  
- `app/Events/NewTicketResponse.php`
- `app/Events/TicketResponseAdded.php`

**Problema:**  
Existen DOS eventos para el mismo propósito (nueva respuesta en ticket), causando confusión y posible duplicación de notificaciones.

**Análisis:**
- `NewTicketResponse.php`: 59 líneas, incompleto (método `broadcastWith()` truncado)
- `TicketResponseAdded.php`: 80 líneas, completo y funcional
- Solo se usa `TicketResponseAdded` en los controladores

**Solución requerida:**  
- Eliminar `NewTicketResponse.php` (no se usa)
- Mantener solo `TicketResponseAdded.php`

---

### 3. **TICKETS: Inconsistencia en Broadcasting de Eventos** ⚠️

**Ubicación:**  
- `app/Events/TicketResponseAdded.php` líneas 39-48

**Problema:**  
La lógica de canales está invertida respecto a la audiencia:

```php
if ($this->isForSupport) {
    // Si es del admin de tienda, notificar a SuperAdmin
    return new Channel('support.tickets');
} else {
    // Si es de soporte, notificar al admin de la tienda específica
    return new Channel('store.' . $this->ticket->store_id . '.tickets');
}
```

**Detalle:**
- Si `isForSupport = true` → La respuesta ES DE la tienda → Notificar A SuperAdmin ✅ (correcto)
- Si `isForSupport = false` → La respuesta ES DE SuperAdmin → Notificar A la tienda ✅ (correcto)

**Estado:** ✅ Lógica CORRECTA (después de corregir el problema #1)

---

### 4. **ANUNCIOS: Falta Template de Email en SendGrid** ⚠️

**Ubicación:**  
- `app/Features/SuperLinkiu/Controllers/AnnouncementController.php` línea 112
- `app/Models/EmailConfiguration.php`

**Problema:**  
El sistema dispara el evento `NewAnnouncement` pero NO hay un template de email configurado para enviar notificaciones por correo cuando se crea un anuncio.

**Código actual:**
```php
// Crear anuncio
$announcement = PlatformAnnouncement::create($validated);

// 🔔 Disparar evento de nuevo anuncio para notificar a todos los admins de tiendas
if ($announcement->is_active) {
    event(new \App\Events\NewAnnouncement($announcement));
}
```

**Estado actual:**
- ✅ Evento Pusher funciona (notificación en tiempo real)
- ❌ NO hay email automático

**¿Es necesario?**  
Depende de la estrategia de producto:
- Si anuncios son **críticos** → SÍ, enviar email
- Si anuncios son **informativos** → NO, solo notificación Pusher

**Recomendación:**  
- Para anuncios tipo `critical` o prioridad >= 8 → Enviar email
- Para otros tipos → Solo Pusher

---

### 5. **NOTIFICACIONES: JavaScript listener de tickets usa campo incorrecto** ❌

**Ubicación:**  
- `resources/js/notifications.js` líneas 181-206

**Problema:**  
El listener de JavaScript espera un campo `response_preview` pero el evento envía `message`:

**Evento (PHP):**
```php
'message' => \Str::limit($this->response->message, 100),
```

**Listener (JS):**
```javascript
`${data.response_preview}<br>` +  // ❌ Campo NO existe
```

**Impacto:**  
- Las notificaciones en tiempo real muestran `undefined` en lugar del mensaje
- El toast se ve vacío o roto

**Solución:**  
Cambiar el listener para usar el campo correcto:
```javascript
`${data.message}<br>` +  // ✅ Campo correcto
```

---

## ✅ COMPONENTES QUE FUNCIONAN CORRECTAMENTE

### 1. **CRUD de Tickets - SuperLinkiu** ✅

**Funcionalidades verificadas:**
- ✅ Crear ticket (`store()`)
- ✅ Ver lista con filtros (`index()`)
- ✅ Ver detalle (`show()`)
- ✅ Editar ticket (`update()`)
- ✅ Eliminar ticket (`destroy()`)
- ✅ Agregar respuesta (`addResponse()`)
- ✅ Cambiar estado AJAX (`updateStatus()`)
- ✅ Asignar ticket AJAX (`assign()`)
- ✅ Cambiar prioridad AJAX (`updatePriority()`)

**Emails implementados:**
- ✅ `sendTicketCreatedNotification()` - Al crear ticket
- ✅ `sendTicketResponseNotification()` - Al responder (si es público)
- ✅ `sendTicketUpdateNotification()` - Al cambiar estado/prioridad

**Template SendGrid:**
- ✅ `template_ticket_response` - Configurado en `EmailConfiguration`
- Variables: `ticket_number`, `ticket_title`, `response_content`, `responder_name`, `ticket_url`

---

### 2. **CRUD de Tickets - TenantAdmin** ✅

**Funcionalidades verificadas:**
- ✅ Crear ticket (`store()`)
- ✅ Ver lista con filtros (`index()`)
- ✅ Ver detalle (`show()`)
- ✅ Agregar respuesta (`addResponse()`)
- ✅ Cambiar estado AJAX (`updateStatus()`)
- ✅ Manejo de attachments (archivos adjuntos)
- ✅ Metadata automática (browser, IP, plan)

**Emails:**
- ⚠️ TenantAdmin NO envía emails directamente
- ✅ SuperAdmin recibe notificación cuando TenantAdmin responde

---

### 3. **CRUD de Anuncios - SuperLinkiu** ✅

**Funcionalidades verificadas:**
- ✅ Crear anuncio (`store()`)
- ✅ Ver lista con filtros (`index()`)
- ✅ Ver detalle con estadísticas de lectura (`show()`)
- ✅ Editar anuncio (`edit()`, `update()`)
- ✅ Eliminar anuncio (`destroy()`)
- ✅ Toggle activo/inactivo AJAX (`toggleActive()`)
- ✅ Duplicar anuncio (`duplicate()`)
- ✅ Upload de banner (628x200px)
- ✅ Targeting por planes y tiendas específicas

**Broadcasting:**
- ✅ Dispara `NewAnnouncement` al crear si `is_active = true`
- ✅ Canal: `platform.announcements` (público)

---

### 4. **CRUD de Anuncios - TenantAdmin** ✅

**Funcionalidades verificadas:**
- ✅ Ver lista con filtros (`index()`)
- ✅ Ver detalle (`show()`)
- ✅ Marcar como leído automático al ver detalle
- ✅ Marcar como leído manualmente (`markAsRead()`)
- ✅ Marcar todos como leídos (`markAllAsRead()`)
- ✅ Endpoint AJAX para contador de no leídos (`getUnreadCount()`)
- ✅ Endpoint AJAX para anuncios recientes (`getRecentAnnouncements()`)

**Filtrado correcto:**
- ✅ Solo muestra anuncios activos
- ✅ Filtra por plan de la tienda
- ✅ Filtra por tiendas específicas (si aplica)
- ✅ Respeta fecha de publicación y expiración

---

### 5. **Sistema de Broadcasting (Pusher)** ✅ (con correcciones)

**Canales configurados:**
- ✅ `platform.announcements` - Público, para todos los admins
- ✅ `support.tickets` - Público, para SuperAdmin
- ✅ `store.{storeId}.tickets` - Público, para cada tienda
- ✅ `store.{storeId}.orders` - Público, para nuevos pedidos

**Eventos:**
- ✅ `NewAnnouncement` → `new.announcement`
- ✅ `TicketResponseAdded` → `ticket.response`
- ✅ `NewOrderCreated` → `new.order`
- ✅ `OrderStatusChanged` → `status.changed`

**Estado:**  
✅ Canales públicos (no requieren autenticación)  
✅ `routes/channels.php` comentado correctamente

---

### 6. **JavaScript Notifications** ✅ (con correcciones menores)

**Listeners configurados:**
- ✅ `setupStoreRequestsListener()` - Solicitudes de tiendas
- ✅ `setupNewOrderListener()` - Nuevos pedidos
- ✅ `setupOrderStatusListener()` - Cambios de estado
- ✅ `setupTicketResponseListener()` - Respuestas de tickets ⚠️ (campo incorrecto)
- ✅ `setupAnnouncementsListener()` - Nuevos anuncios

**Features:**
- ✅ Notificaciones de escritorio (Desktop Notifications)
- ✅ Toast in-app con colores por tipo
- ✅ Sonido de notificación
- ✅ Auto-inicialización cuando DOM está listo
- ✅ Detección automática de contexto (SuperAdmin/TenantAdmin/Cliente)

---

## 🔧 CORRECCIONES NECESARIAS

### Prioridad ALTA (🔴 Bloqueante)

1. **Agregar accessor `is_from_store` a TicketResponse**
   ```php
   // app/Shared/Models/TicketResponse.php
   public function getIsFromStoreAttribute(): bool
   {
       return $this->user && $this->user->role === 'store_admin';
   }
   ```

2. **Corregir listener de JavaScript**
   ```javascript
   // resources/js/notifications.js línea 188
   `${data.message}<br>` + // Cambiar response_preview por message
   ```

### Prioridad MEDIA (⚠️ Recomendado)

3. **Eliminar evento duplicado**
   - Borrar: `app/Events/NewTicketResponse.php`

4. **Agregar template de email para anuncios críticos** (opcional)
   - Crear template en SendGrid
   - Configurar en `EmailConfiguration`
   - Enviar solo si `type = 'critical'` o `priority >= 8`

### Prioridad BAJA (📝 Mejora)

5. **Documentar sistema de tickets en README**
6. **Agregar tests automatizados para eventos Pusher**

---

## 🔔 NOTIFICACIONES EN TIEMPO REAL VERIFICADAS

### SuperLinkiu - Navbar (`app/Shared/Views/Components/admin/navbar.blade.php`)

✅ **Badge de Tickets Abiertos:**
- Icono: `<x-solar-ticker-star-outline>`
- Badge ID: `tickets-badge`
- Contador: Tickets con status `open` o `in_progress`
- Link: `/superlinkiu/tickets`

✅ **Badge de Mensajes Nuevos:**
- Icono: `<x-solar-chat-round-dots-outline>`
- Badge ID: `messages-badge`
- Contador: Respuestas de store_admins en últimos 7 días
- Link: `/superlinkiu/tickets`

✅ **JavaScript configurado:**
- Función: `updateNotificationBadges(data)`
- Actualiza ambos badges en tiempo real
- WebSocket listener: `setupWebSocket()`

### SuperLinkiu - Sidebar (`app/Shared/Views/Components/admin/sidebar.blade.php`)

✅ **Submenu de Tickets:**
- "Tickets abiertos" con badge naranja
- Contador dinámico: Solo status `open`

✅ **Submenu de Anuncios:**
- "Anuncios de Linkiu" con badge rosa
- Contador dinámico: Anuncios activos

### TenantAdmin - Tickets (`app/Features/TenantAdmin/Views/tickets/index.blade.php`)

✅ **Badge de respuestas nuevas:**
- Badge inline en cada ticket
- Muestra: `{{ $ticket->new_support_responses_count }} nueva(s)`
- Atributo: `$ticket->has_new_support_responses`
- Color: bg-primary-200

### TenantAdmin - Anuncios (`app/Features/TenantAdmin/Views/announcements/index.blade.php`)

✅ **Estadísticas en cards:**
- Total de anuncios
- Sin leer (warning-300)
- Banners activos
- Críticos

✅ **AJAX Endpoint:**
- `getUnreadCount()` - Contador de no leídos
- `getRecentAnnouncements()` - Últimos 5 anuncios sin leer

---

## 📊 MATRIZ DE FUNCIONALIDAD

| Funcionalidad | SuperLinkiu | TenantAdmin | Estado |
|---------------|-------------|-------------|---------|
| **TICKETS** |
| Crear | ✅ | ✅ | OK |
| Ver lista | ✅ | ✅ | OK |
| Ver detalle | ✅ | ✅ | OK |
| Editar | ✅ | ❌ | OK (solo SuperAdmin) |
| Eliminar | ✅ | ❌ | OK (solo SuperAdmin) |
| Responder | ✅ | ✅ | OK |
| Cambiar estado | ✅ | ✅ | OK |
| Asignar | ✅ | ❌ | OK (solo SuperAdmin) |
| Attachments | ✅ | ✅ | OK |
| Email notificación | ✅ | ✅ | ⚠️ (con correcciones) |
| Pusher notificación | ⚠️ | ⚠️ | ❌ (roto, requiere corrección #1) |
| **ANUNCIOS** |
| Crear | ✅ | ❌ | OK (solo SuperAdmin) |
| Ver lista | ✅ | ✅ | OK |
| Ver detalle | ✅ | ✅ | OK |
| Editar | ✅ | ❌ | OK (solo SuperAdmin) |
| Eliminar | ✅ | ❌ | OK (solo SuperAdmin) |
| Marcar leído | ❌ | ✅ | OK |
| Upload banner | ✅ | ❌ | OK |
| Duplicar | ✅ | ❌ | OK |
| Email notificación | ❌ | ❌ | ⚠️ (no implementado, opcional) |
| Pusher notificación | ✅ | ✅ | OK |

---

## 🎯 PLAN DE ACCIÓN

### Paso 1: Correcciones Críticas (30 min)
1. Agregar accessor `is_from_store` a `TicketResponse.php`
2. Corregir campo en `notifications.js`
3. Probar flujo completo de tickets

### Paso 2: Limpieza de Código (15 min)
4. Eliminar `NewTicketResponse.php`
5. Actualizar referencias si existen

### Paso 3: Pruebas (30 min)
6. Crear ticket desde TenantAdmin → Verificar notificación Pusher en SuperAdmin
7. Responder desde SuperAdmin → Verificar notificación Pusher en TenantAdmin
8. Crear anuncio → Verificar notificación Pusher en TenantAdmin
9. Verificar emails en SendGrid

### Paso 4: Documentación (15 min)
10. Actualizar `DOCUMENTACION_COMPLETA_LINKIU.md` con hallazgos
11. Documentar flujo de notificaciones

---

## 📋 TEMPLATES SENDGRID VERIFICADOS

### ✅ Configurados:
- `template_ticket_response` - Nueva respuesta en ticket
- `template_ticket_resolved` - Ticket resuelto
- `template_ticket_assigned` - Ticket asignado

### ❌ Faltan (opcionales):
- Template para anuncios críticos
- Template para ticket creado por TenantAdmin (notificar a SuperAdmin)

---

## 🔒 SEGURIDAD

✅ Todos los endpoints validan correctamente:
- Autenticación requerida
- Roles verificados (SuperAdmin vs StoreAdmin)
- Ownership de tickets verificado (store_id)
- Attachments con validación de tamaño y tipo

---

## ⚡ RENDIMIENTO

✅ Optimizaciones encontradas:
- Cache de estadísticas de tickets (60 segundos)
- Eager loading de relaciones
- Paginación en listados
- Índices en base de datos

---

**Fin del diagnóstico**

