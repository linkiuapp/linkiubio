# Plantillas WhatsApp Linkiu

Este documento contiene todas las plantillas de WhatsApp que deben ser registradas en SendPulse para el sistema Linkiu. 

**Versión:** v2 (con formato mejorado y mensaje de contacto)

---

## 📋 Instrucciones Generales

### Formato de Variables
- Las variables dinámicas se representan con **negrita** usando formato markdown: `*{{1}}*`, `*{{2}}*`, etc.
- WhatsApp renderizará automáticamente el texto entre asteriscos como **negrita**

### Mensaje de Contacto
- Todas las plantillas incluyen al final un mensaje casual y amigable con el número de WhatsApp del negocio usando una variable dinámica
- Formato variable según el contexto: `¿Alguna duda? Escríbenos a *{{N}}*` o `¿Algo? Escríbenos a *{{N}}*` donde `{{N}}` es la última variable de cada plantilla

### Tono y Estilo
- Tono casual y amigable, conversacional y cercano
- Lenguaje natural y menos formal
- Uso moderado de emojis para dar calidez
- Mensajes más directos y menos estructurados

### Nombres de Plantillas
- Todas las plantillas usan sufijo `_v2` para diferenciarlas de las versiones anteriores
- Ejemplo: `order_placed_notification_es` → `order_placed_notification_es_v2`

### Categoría
- Todas las plantillas deben registrarse como **UTILITY** (notificaciones transaccionales)

### Idioma
- Todas las plantillas están en **Español (es)**

---

# 📑 ÍNDICE DE PLANTILLAS

Este documento contiene **14 plantillas** organizadas en 3 secciones:

## 📦 PLANTILLAS DE NOTIFICACIÓN DE PEDIDOS (4 plantillas)
1. **Pedido Creado (Cliente)** - `order_placed_notification_es_v2` - 3 variables
2. **Cambio de Estado de Pedido (Cliente)** - `order_status_es_v2` - 3 variables
3. **Nuevo Pedido (Admin)** - `order_registration_notification_es` - 3 variables
4. **Comprobante de Pago Subido (Admin)** - `payment_proof_received_notification_es` - 2 variables

## 🍽️ PLANTILLAS DE NOTIFICACIÓN DE RESERVAS DE MESAS (5 plantillas)
5. **Reserva Solicitada (Cliente)** - `reservation_requested_es_v3` - 5 variables
6. **Reserva Confirmada (Cliente)** - `reservation_confirmed_es_v3` - 6 variables
7. **Recordatorio de Reserva (Cliente)** - `reservation_reminder_client_es_v3` - 5 variables
8. **Reserva Cancelada (Cliente)** - `reservation_client_es` - 4 variables
9. **Nueva Reserva (Admin)** - `reservation_admin_es` - 5 variables

## 🏨 PLANTILLAS DE NOTIFICACIÓN DE RESERVAS DE HOTEL (5 plantillas)
10. **Reserva de Hotel Solicitada (Cliente)** - `hotel_reservation_requested_es_v2` - 7 variables
11. **Reserva de Hotel Confirmada (Cliente)** - `hotel_reservation_confirmed_es_v2` - 7 variables
12. **Recordatorio de Check-in (Cliente)** - `hotel_checkin_reminder_es_v2` - 6 variables
13. **Reserva de Hotel Cancelada (Cliente)** - `hotel_reservation_client_es` - 4 variables
14. **Nueva Reserva de Hotel (Admin)** - `hotel_reservation_registration_notification_es` - 6 variables

**Total: 14 plantillas | 70 variables**

---

# 📦 PLANTILLAS DE NOTIFICACIÓN DE PEDIDOS

## 1. Pedido Creado (Cliente)

**Nombre de la plantilla:** `order_placed_notification_es_v2`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 3

**Contenido:**
```
¡Hola! 👋

Hemos recibido tu pedido.

📦 *{{1}}*
🏪 *{{2}}*

Te notificaremos cuando sea confirmado.

Si tienes alguna consulta, escríbenos a *{{3}}*
```

**Parámetros en código:**
- `{{1}}` = Número de pedido (ej: #ORD-2024-001234)
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 2. Cambio de Estado de Pedido (Cliente)

**Nombre de la plantilla:** `order_status_es_v2`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 3

**Contenido:**
```
¡Actualización de tu pedido! 📦

Tenemos buenas noticias:

📦 *{{1}}*
🔔 Ahora está: *{{2}}*

¿Necesitas algo? Escríbenos a *{{3}}* 😊
```

**Parámetros en código:**
- `{{1}}` = Número de pedido
- `{{2}}` = Nuevo estado (ej: "Confirmado", "En preparación", "En camino", "Entregado", "Cancelado")
- `{{3}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 3. Nuevo Pedido (Admin)

**Nombre de la plantilla:** `order_registration_notification_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 3

**Contenido:**
```
Registro de pedido

Pedido: *{{1}}*
Cliente: *{{2}}*
Total: *{{3}}*

Acción requerida: Revisar en el panel de administración.
```

**Parámetros en código:**
- `{{1}}` = Número de pedido
- `{{2}}` = Nombre del cliente
- `{{3}}` = Total del pedido (ej: "$150.000")

---

## 4. Comprobante de Pago Subido (Admin)

**Nombre de la plantilla:** `payment_proof_received_notification_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 2

**Contenido:**
```
Comprobante de pago recibido

Pedido: *{{1}}*
Cliente: *{{2}}*

Acción requerida: Verificar en el panel de administración.
```

**Parámetros en código:**
- `{{1}}` = Número de pedido
- `{{2}}` = Nombre del cliente

---

# 🍽️ PLANTILLAS DE NOTIFICACIÓN DE RESERVAS DE MESAS

## 1. Reserva Solicitada (Cliente)

**Nombre de la plantilla:** `reservation_requested_es_v3`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
¡Hola! 👋

Hemos recibido tu solicitud de reserva.

📋 *{{1}}*
🏪 *{{2}}*
📅 *{{3}}*
🕐 *{{4}}*

Te contactaremos pronto para confirmarla.😊

Si tienes alguna consulta, escríbenos a *{{5}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia de la reserva (ej: RES-2024-001234)
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha (formato: DD/MM/YYYY)
- `{{4}}` = Hora (formato: HH:MM)
- `{{5}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 2. Reserva Confirmada (Cliente)

**Nombre de la plantilla:** `reservation_confirmed_es_v3`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
Tu reserva ha sido confirmada ✅

📋 *{{1}}*
🏪 *{{2}}*
📅 *{{3}}*
🕐 *{{4}}*
🪑 *{{5}}*

Te esperamos en la fecha y hora indicadas.

Si tienes alguna consulta, escríbenos a *{{6}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha
- `{{4}}` = Hora
- `{{5}}` = Información de la mesa (ej: "Mesa 5" o "Mesa por asignar")
- `{{6}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 3. Recordatorio de Reserva (Cliente)

**Nombre de la plantilla:** `reservation_reminder_client_es_v3`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
Recordatorio de reserva

Tu reserva es mañana:

📋 *{{1}}*
🏪 *{{2}}*
📅 *{{3}}*
🕐 *{{4}}*

Te esperamos en la fecha y hora indicadas.

Si tienes alguna consulta, escríbenos a *{{5}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha
- `{{4}}` = Hora
- `{{5}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 4. Reserva Cancelada (Cliente)

**Nombre de la plantilla:** `reservation_client_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 4

**Contenido:**
```
Actualización de estado de reserva

Código: *{{1}}*
Tienda: *{{2}}*
Estado: *{{3}}*

Contacto: *{{4}}*😊
```

**Parámetros en código:**
- `{{1}}` = Referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Estado
- `{{4}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 5. Nueva Reserva (Admin)

**Nombre de la plantilla:** `reservation_admin_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
Registro de reserva

Código: *{{1}}*
Cliente: *{{2}}*
Fecha: *{{3}}*
Hora: *{{4}}*
Personas: *{{5}}*

Acción requerida: Revisar en el panel de administración.
```

**Parámetros en código:**
- `{{1}}` = Referencia
- `{{2}}` = Nombre del cliente
- `{{3}}` = Fecha
- `{{4}}` = Hora
- `{{5}}` = Personas

---

# 🏨 PLANTILLAS DE NOTIFICACIÓN DE RESERVAS DE HOTEL

## 1. Reserva de Hotel Solicitada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_requested_es_v2`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 7

**Contenido:**
```
¡Hola! 👋

Hemos recibido tu solicitud de reserva de habitación.

📋 *{{1}}*
🏨 *{{2}}*
🛏️ *{{3}}*
📅 Check-in: *{{4}}*
📅 Check-out: *{{5}}*
🌙 *{{6}}*

Te contactaremos pronto para confirmarla.

Si tienes alguna consulta, escríbenos a *{{7}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia de la reserva (ej: HTL-20241102-ABCD)
- `{{2}}` = Nombre del hotel/tienda
- `{{3}}` = Tipo de habitación (ej: "Suite Premium")
- `{{4}}` = Fecha de check-in (formato: DD/MM/YYYY)
- `{{5}}` = Fecha de check-out (formato: DD/MM/YYYY)
- `{{6}}` = Noches (ej: "2 noches" o "1 noche")
- `{{7}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 2. Reserva de Hotel Confirmada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_confirmed_es_v2`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 7

**Contenido:**
```
Tu reserva de habitación ha sido confirmada ✅

📋 *{{1}}*
🏨 *{{2}}*
🚪 *{{3}}*
🛏️ *{{4}}*
📅 Check-in: *{{5}}*
📅 Check-out: *{{6}}*

Te esperamos en las fechas indicadas.

Si tienes alguna consulta, escríbenos a *{{7}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Información de la habitación (ej: "Habitación #101" o "Habitación por asignar")
- `{{4}}` = Tipo de habitación
- `{{5}}` = Fecha de check-in
- `{{6}}` = Fecha de check-out
- `{{7}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 3. Recordatorio de Check-in (Cliente)

**Nombre de la plantilla:** `hotel_checkin_reminder_es_v2`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
Recordatorio de check-in

Tu check-in es hoy:

📋 *{{1}}*
🏨 *{{2}}*
🚪 *{{3}}*
📅 *{{4}}*
🕐 *{{5}}*

Te esperamos en la fecha y hora indicadas.

Si tienes alguna consulta, escríbenos a *{{6}}*
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Información de la habitación
- `{{4}}` = Fecha de check-in
- `{{5}}` = Hora de check-in (ej: "3:00 PM")
- `{{6}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 4. Reserva de Hotel Cancelada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_client_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 4

**Contenido:**
```
Actualización de estado de reserva

Código: *{{1}}*
Hotel: *{{2}}*
Estado: *{{3}}*

Contacto: *{{4}}*😊
```

**Parámetros en código:**
- `{{1}}` = Referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Estado
- `{{4}}` = Número de WhatsApp del negocio (formato: 3001234567)

---

## 5. Nueva Reserva de Hotel (Admin)

**Nombre de la plantilla:** `hotel_reservation_registration_notification_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
Registro de reserva de habitación

Código: *{{1}}*
Huésped: *{{2}}*
Tipo: *{{3}}*
Check-in: *{{4}}*
Check-out: *{{5}}*
Total: *{{6}}*

Acción requerida: Revisar en el panel de administración.
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del huésped
- `{{3}}` = Tipo de habitación
- `{{4}}` = Fecha de check-in
- `{{5}}` = Fecha de check-out
- `{{6}}` = Total (ej: "$150.000" o "$500.000")

---

# 📝 INSTRUCCIONES PARA REGISTRAR EN SENDPULSE

## Pasos Generales

1. **Iniciar sesión** en SendPulse: https://sendpulse.com/
2. **Ir a WhatsApp** → **Plantillas**
3. **Crear nueva plantilla** para cada una de las 14 plantillas anteriores
4. **Configurar cada plantilla:**
   - **Nombre:** El nombre exacto indicado arriba (ej: `order_placed_notification_es_v2`)
   - **Idioma:** Español (es)
   - **Categoría:** UTILITY (para notificaciones transaccionales)
   - **Contenido:** Copiar y pegar el texto completo de cada plantilla
   - **Variables:** Agregar las variables `{{1}}`, `{{2}}`, etc. en el orden indicado
   - **Formato de negrita:** WhatsApp reconocerá automáticamente el formato `*texto*` como negrita
5. **Enviar para aprobación** (WhatsApp revisará y aprobará las plantillas en 24-72 horas)

## Notas Importantes

- ⚠️ **Las plantillas deben ser aprobadas por WhatsApp antes de poder usarse** (puede tardar 24-72 horas)
- ✅ Todas las plantillas usan categoría **UTILITY** (permitida para notificaciones transaccionales)
- 📝 Los nombres de las plantillas deben ser **exactamente** como se indican (case-sensitive)
- 🔢 El orden de las variables debe coincidir exactamente con el orden en el código
- ✨ El formato `*{{1}}*` se renderizará como **negrita** en WhatsApp

---

# 🔄 PLAN DE MIGRACIÓN

## Fase 1: Creación de Plantillas Nuevas (Sin Interrupción)

1. Crear todas las 14 plantillas nuevas con nombres `_v2` en SendPulse
2. Esperar aprobación de todas las plantillas (24-72 horas)
3. Verificar que todas estén aprobadas antes de continuar

## Fase 2: Actualización del Código

1. Actualizar todos los nombres de plantillas en `app/Services/WhatsAppNotificationService.php`:
   - Cambiar `order_placed_notification_es` → `order_placed_notification_es_v2`
   - Cambiar `order_status_es` → `order_status_es_v2`
   - Cambiar `admin_new_order_notification_es` → `order_registration_notification_es`
   - Cambiar `admin_payment_proof_uploaded_es` → `payment_proof_received_notification_es`
   - Cambiar `reservation_requested_es` → `reservation_requested_es_v3`
   - Cambiar `reservation_confirmed_es` → `reservation_confirmed_es_v3`
   - Cambiar `reservation_reminder_client_es` → `reservation_reminder_client_es_v3`
   - Cambiar `reservation_cancelled_es` → `reservation_client_es`
   - Cambiar `admin_new_reservation_es` → `reservation_admin_es`
   - Cambiar `hotel_reservation_requested_es` → `hotel_reservation_requested_es_v2`
   - Cambiar `hotel_reservation_confirmed_es` → `hotel_reservation_confirmed_es_v2`
   - Cambiar `hotel_checkin_reminder_es` → `hotel_checkin_reminder_es_v2`
   - Cambiar `hotel_reservation_cancelled_es` → `hotel_reservation_client_es`
   - Cambiar `admin_new_hotel_reservation_es` → `hotel_reservation_registration_notification_es`

2. Probar envío de notificaciones con las nuevas plantillas

## Fase 3: Eliminación de Plantillas Antiguas

⚠️ **IMPORTANTE: Consideraciones antes de eliminar plantillas en Meta**

### ¿Es seguro eliminar las plantillas antiguas?

**✅ SÍ, es seguro eliminar las plantillas en Meta, PERO hay condiciones críticas:**

1. **✅ NO hay problema técnico en Meta por eliminar plantillas**
   - Meta permite eliminar plantillas sin restricciones técnicas
   - Las empresas verificadas pueden tener hasta 6,000 plantillas
   - Las empresas no verificadas pueden tener hasta 250 plantillas
   - Eliminar plantillas ayuda a mantener el límite bajo control

2. **⚠️ PROBLEMAS POTENCIALES si se eliminan antes de tiempo:**
   - Si el código aún usa las plantillas antiguas, las notificaciones **fallarán** inmediatamente
   - Si SendPulse tiene flujos automatizados usando esas plantillas, se romperán
   - No hay "período de gracia" - la eliminación es inmediata e irreversible

3. **✅ REQUISITOS ANTES DE ELIMINAR:**
   - [ ] Todas las plantillas `_v2` deben estar **100% aprobadas** por Meta
   - [ ] El código debe estar actualizado usando los nombres `_v2` en **PRODUCCIÓN**
   - [ ] Se deben realizar **pruebas exhaustivas** en producción con las nuevas plantillas
   - [ ] Verificar que **TODAS** las notificaciones funcionan correctamente durante al menos 1 semana
   - [ ] Confirmar que **NO hay flujos automatizados** en SendPulse usando las plantillas antiguas

### Proceso recomendado para eliminación:

1. **Esperar confirmación de producción (1 semana mínimo)**
   - Monitorear logs de WhatsApp durante la primera semana
   - Verificar que no hay errores relacionados con plantillas
   - Confirmar que todas las notificaciones se envían exitosamente

2. **Verificar en SendPulse:**
   - Revisar que no hay flujos automatizados usando nombres de plantillas antiguas
   - Verificar en el dashboard que las nuevas plantillas `_v2` están siendo usadas

3. **Eliminar plantillas antiguas en Meta:**
   - Acceder al **Administrador de WhatsApp** en Meta Business Suite
   - Ir a **Plantillas de Mensajes**
   - Eliminar UNA POR UNA para verificar que no hay dependencias
   - **NO eliminar todas a la vez** - hacerlo gradualmente (ej: 1-2 por día)

4. **Monitoreo post-eliminación:**
   - Vigilar logs durante 48 horas después de cada eliminación
   - Si aparece algún error, **detener** la eliminación inmediatamente
   - Las plantillas antiguas no se pueden recuperar una vez eliminadas

### ⚠️ ADVERTENCIA CRÍTICA:

**NO eliminar plantillas antiguas hasta que:**
- ✅ El código en producción esté usando las nuevas plantillas `_v2`
- ✅ Todas las plantillas `_v2` estén aprobadas por Meta
- ✅ Se haya probado en producción durante al menos 1 semana sin errores
- ✅ Se haya confirmado que SendPulse está usando las nuevas plantillas

**Si se eliminan antes de tiempo:**
- ❌ Las notificaciones WhatsApp dejarán de funcionar inmediatamente
- ❌ Los clientes no recibirán confirmaciones de pedidos/reservas
- ❌ Los admins no recibirán notificaciones de nuevos pedidos/reservas
- ❌ El sistema quedará sin comunicación WhatsApp hasta crear nuevas plantillas (24-72 horas de aprobación)

---

# 📊 RESUMEN DE PLANTILLAS

| Sección | Cantidad | Total Variables |
|---------|----------|----------------|
| Pedidos | 4 | 11 |
| Reservas de Mesas | 5 | 27 |
| Reservas de Hotel | 5 | 32 |
| **TOTAL** | **14** | **70** |

---

# 🔗 INTEGRACIÓN EN EL CÓDIGO

Las plantillas se utilizan automáticamente a través del servicio `WhatsAppNotificationService` en los siguientes momentos:

## Pedidos
1. **Pedido Creado:** Cuando el cliente realiza un pedido
2. **Cambio de Estado:** Cuando el admin cambia el estado de un pedido
3. **Nuevo Pedido (Admin):** Cuando se recibe un nuevo pedido
4. **Comprobante Subido (Admin):** Cuando el cliente sube comprobante de pago

## Reservas de Mesas
1. **Reserva Solicitada:** Cuando el cliente crea una reserva desde el frontend
2. **Reserva Confirmada:** Cuando el admin confirma una reserva
3. **Recordatorio:** 24 horas antes de la reserva (vía Job programado)
4. **Reserva Cancelada:** Cuando el admin o sistema cancela una reserva
5. **Nueva Reserva (Admin):** Cuando se crea una nueva reserva

## Reservas de Hotel
1. **Reserva Solicitada:** Cuando el cliente crea una reserva de hotel desde el frontend
2. **Reserva Confirmada:** Cuando el admin confirma una reserva y asigna habitación
3. **Recordatorio Check-in:** Horas antes del check-in (vía Job programado: `hotel-reservations:send-checkin-reminders`)
4. **Reserva Cancelada:** Cuando el admin o sistema cancela una reserva
5. **Nueva Reserva (Admin):** Cuando se crea una nueva reserva de hotel

