# Plantillas WhatsApp para Sistema de Reservaciones

Este documento contiene las 5 plantillas de WhatsApp que deben ser registradas en SendPulse para el sistema de reservaciones de mesas.

## Formato de Plantillas

Las plantillas de WhatsApp deben seguir el formato oficial de WhatsApp Business API. Cada variable dinámica se representa como `{{1}}`, `{{2}}`, etc.

---

## 1. Reserva Solicitada (Cliente)

**Nombre de la plantilla:** `reservation_requested_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 4

**Contenido:**
```
¡Hola! 👋

Hemos recibido tu solicitud de reserva.

📋 Código: {{1}}
🏪 Tienda: {{2}}
📅 Fecha: {{3}}
🕐 Hora: {{4}}

Te contactaremos pronto para confirmar tu reserva.

¡Gracias por elegirnos!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia de la reserva (ej: RES-2024-001234)
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha (formato: DD/MM/YYYY)
- `{{4}}` = Hora (formato: HH:MM)

---

## 2. Reserva Confirmada (Cliente)

**Nombre de la plantilla:** `reservation_confirmed_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
¡Reserva Confirmada! ✅

Tu reserva ha sido confirmada exitosamente.

📋 Código: {{1}}
🏪 Tienda: {{2}}
📅 Fecha: {{3}}
🕐 Hora: {{4}}
🪑 Mesa: {{5}}

¡Te esperamos!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha
- `{{4}}` = Hora
- `{{5}}` = Información de la mesa (ej: "Mesa 5" o "Mesa por asignar")

---

## 3. Recordatorio de Reserva (Cliente)

**Nombre de la plantilla:** `reservation_reminder_client_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 4

**Contenido:**
```
⏰ Recordatorio de Reserva

Solo queríamos recordarte tu reserva de mañana:

📋 Código: {{1}}
🏪 Tienda: {{2}}
📅 Fecha: {{3}}
🕐 Hora: {{4}}

¡Te esperamos!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Fecha
- `{{4}}` = Hora

---

## 4. Reserva Cancelada (Cliente)

**Nombre de la plantilla:** `reservation_cancelled_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 3

**Contenido:**
```
Lamentamos informarte que tu reserva ha sido cancelada.

📋 Código: {{1}}
🏪 Tienda: {{2}}

Si tienes alguna pregunta, contáctanos por WhatsApp: {{3}}

Gracias por tu comprensión.
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre de la tienda
- `{{3}}` = Número de WhatsApp de la tienda (formato: 3001234567)

---

## 5. Nueva Reserva (Admin)

**Nombre de la plantilla:** `admin_new_reservation_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
🔔 Nueva Reserva Recibida

Se ha solicitado una nueva reserva:

📋 Código: {{1}}
👤 Cliente: {{2}}
📅 Fecha: {{3}}
🕐 Hora: {{4}}
👥 Personas: {{5}}

Revisa el panel de administración para confirmarla.
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del cliente
- `{{3}}` = Fecha
- `{{4}}` = Hora
- `{{5}}` = Número de personas (ej: "2 personas" o "1 persona")

---

## Instrucciones para Registrar en SendPulse

1. **Iniciar sesión** en SendPulse: https://sendpulse.com/
2. **Ir a WhatsApp** → **Plantillas**
3. **Crear nueva plantilla** para cada una de las 5 plantillas anteriores
4. **Configurar:**
   - Nombre: El nombre exacto indicado arriba
   - Idioma: Español (es)
   - Categoría: UTILITY (para notificaciones)
   - Contenido: Copiar y pegar el texto de cada plantilla
   - Variables: Agregar las variables `{{1}}`, `{{2}}`, etc. en el orden indicado
5. **Enviar para aprobación** (WhatsApp revisará y aprobará las plantillas)

---

## Notas Importantes

- ⚠️ Las plantillas deben ser aprobadas por WhatsApp antes de poder usarse (puede tardar 24-48 horas)
- ✅ Todas las plantillas usan categoría UTILITY (permitida para notificaciones transaccionales)
- 📝 Los nombres de las plantillas deben ser exactamente como se indican (case-sensitive)
- 🔢 El orden de las variables debe coincidir con el orden en el código

---

## Integración en el Código

Una vez aprobadas las plantillas en SendPulse, el código las utilizará automáticamente a través del servicio `WhatsAppNotificationService` en los siguientes momentos:

1. **Reserva Solicitada:** Cuando el cliente crea una reserva desde el frontend
2. **Reserva Confirmada:** Cuando el admin confirma una reserva
3. **Recordatorio:** 24 horas antes de la reserva (vía Job programado)
4. **Reserva Cancelada:** Cuando el admin o sistema cancela una reserva
5. **Nueva Reserva (Admin):** Cuando se crea una nueva reserva

---

# Plantillas WhatsApp para Sistema de Reservas de Hotel

Este documento contiene las 5 plantillas adicionales de WhatsApp que deben ser registradas en SendPulse para el sistema de reservas de hotel (REQ-003).

---

## 1. Reserva de Hotel Solicitada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_requested_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
¡Hola! 👋

Hemos recibido tu solicitud de reserva de habitación.

📋 Código: {{1}}
🏨 Hotel: {{2}}
🛏️ Tipo de Habitación: {{3}}
📅 Check-in: {{4}}
📅 Check-out: {{5}}
🌙 Estadía: {{6}}

Te contactaremos pronto para confirmar tu reserva.

¡Gracias por elegirnos!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia de la reserva (ej: HTL-20241102-ABCD)
- `{{2}}` = Nombre del hotel/tienda
- `{{3}}` = Tipo de habitación (ej: "Suite Premium")
- `{{4}}` = Fecha de check-in (formato: DD/MM/YYYY)
- `{{5}}` = Fecha de check-out (formato: DD/MM/YYYY)
- `{{6}}` = Noches (ej: "2 noches" o "1 noche")

---

## 2. Reserva de Hotel Confirmada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_confirmed_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
¡Reserva Confirmada! ✅

Tu reserva de habitación ha sido confirmada exitosamente.

📋 Código: {{1}}
🏨 Hotel: {{2}}
🚪 Habitación: {{3}}
🛏️ Tipo: {{4}}
📅 Check-in: {{5}}
📅 Check-out: {{6}}

¡Te esperamos para disfrutar de tu estadía!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Información de la habitación (ej: "Habitación #101" o "Habitación por asignar")
- `{{4}}` = Tipo de habitación
- `{{5}}` = Fecha de check-in
- `{{6}}` = Fecha de check-out

---

## 3. Recordatorio de Check-in (Cliente)

**Nombre de la plantilla:** `hotel_checkin_reminder_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 5

**Contenido:**
```
⏰ Recordatorio de Check-in

Solo queríamos recordarte tu reserva:

📋 Código: {{1}}
🏨 Hotel: {{2}}
🚪 Habitación: {{3}}
📅 Check-in: {{4}}
🕐 Hora: {{5}}

¡Te esperamos!
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Información de la habitación
- `{{4}}` = Fecha de check-in
- `{{5}}` = Hora de check-in (ej: "3:00 PM")

---

## 4. Reserva de Hotel Cancelada (Cliente)

**Nombre de la plantilla:** `hotel_reservation_cancelled_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 3

**Contenido:**
```
Lamentamos informarte que tu reserva de habitación ha sido cancelada.

📋 Código: {{1}}
🏨 Hotel: {{2}}

Si tienes alguna pregunta, contáctanos por WhatsApp: {{3}}

Gracias por tu comprensión.
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del hotel
- `{{3}}` = Número de WhatsApp del hotel (formato: 3001234567)

---

## 5. Nueva Reserva de Hotel (Admin)

**Nombre de la plantilla:** `admin_new_hotel_reservation_es`  
**Idioma:** Español (es)  
**Categoría:** UTILITY  
**Variables:** 6

**Contenido:**
```
🔔 Nueva Reserva de Hotel Recibida

Se ha solicitado una nueva reserva de habitación:

📋 Código: {{1}}
👤 Huésped: {{2}}
🛏️ Tipo de Habitación: {{3}}
📅 Check-in: {{4}}
📅 Check-out: {{5}}
💰 Total: {{6}}

Revisa el panel de administración para confirmarla.
```

**Parámetros en código:**
- `{{1}}` = Código de referencia
- `{{2}}` = Nombre del huésped
- `{{3}}` = Tipo de habitación
- `{{4}}` = Fecha de check-in
- `{{5}}` = Fecha de check-out
- `{{6}}` = Total (ej: "$150.000" o "$500.000")

---

## Instrucciones para Registrar en SendPulse (Hoteles)

1. **Iniciar sesión** en SendPulse: https://sendpulse.com/
2. **Ir a WhatsApp** → **Plantillas**
3. **Crear nueva plantilla** para cada una de las 5 plantillas de hotel anteriores
4. **Configurar:**
   - Nombre: El nombre exacto indicado arriba
   - Idioma: Español (es)
   - Categoría: UTILITY (para notificaciones)
   - Contenido: Copiar y pegar el texto de cada plantilla
   - Variables: Agregar las variables `{{1}}`, `{{2}}`, etc. en el orden indicado
5. **Enviar para aprobación** (WhatsApp revisará y aprobará las plantillas)

---

## Integración en el Código (Hoteles)

Una vez aprobadas las plantillas en SendPulse, el código las utilizará automáticamente a través del servicio `WhatsAppNotificationService` en los siguientes momentos:

1. **Reserva Solicitada:** Cuando el cliente crea una reserva de hotel desde el frontend
2. **Reserva Confirmada:** Cuando el admin confirma una reserva y asigna habitación
3. **Recordatorio Check-in:** Horas antes del check-in (vía Job programado: `hotel-reservations:send-checkin-reminders`)
4. **Reserva Cancelada:** Cuando el admin o sistema cancela una reserva
5. **Nueva Reserva (Admin):** Cuando se crea una nueva reserva de hotel

