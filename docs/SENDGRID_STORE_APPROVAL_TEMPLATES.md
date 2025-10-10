# 📧 Plantillas de Email SendGrid - Sistema de Aprobación de Tiendas

Este documento detalla las **4 plantillas de email** que deben crearse en SendGrid para el sistema de aprobación de tiendas.

---

## 🎯 Resumen de Plantillas

| Plantilla | Cuándo se envía | A quién |
|-----------|----------------|---------|
| **store_pending_review** | Al crear una tienda que requiere revisión manual | Tenant Admin |
| **store_approved** | Cuando un SuperAdmin aprueba una tienda | Tenant Admin |
| **store_rejected** | Cuando un SuperAdmin rechaza una tienda | Tenant Admin |
| **new_store_request** | Al crear una solicitud de tienda pendiente | SuperAdmin |

---

## 📋 Instrucciones Generales

### Paso 1: Acceder a SendGrid
1. Ir a https://sendgrid.com
2. Iniciar sesión con tu cuenta
3. Ir a **Email API** → **Dynamic Templates**

### Paso 2: Crear una nueva plantilla
1. Clic en **Create a Dynamic Template**
2. Dale un nombre descriptivo (ej: "Linkiu - Solicitud en Revisión")
3. Clic en **Create**
4. Clic en **Add Version** → **Blank Template** → **Code Editor**

### Paso 3: Diseñar la plantilla
- Usa el editor visual o código HTML
- Incluye las variables usando `{{variable_name}}`
- Guarda y obtén el **Template ID** (ej: `d-abc123xyz`)

### Paso 4: Configurar en Linkiu
1. Ir a **SuperAdmin** → **Configuración de Email**
2. Pegar el **Template ID** en el campo correspondiente
3. **Importante**: Verificar que las variables coincidan

---

## 1️⃣ Plantilla: `store_pending_review`

### 📌 Descripción
Se envía al **Tenant Admin** cuando su solicitud de tienda está en revisión manual.

### 📧 Template ID a configurar en
- Campo: `template_store_pending_review`
- Ruta: SuperAdmin → Configuración Email

### 🔑 Variables Disponibles

```handlebars
{{admin_name}}                    // Nombre del administrador
{{store_name}}                    // Nombre de la tienda
{{business_type}}                 // Tipo de negocio (ej: "Restaurante de comida rápida")
{{business_document_type}}        // Tipo de documento (NIT/CC/CE/RUT)
{{business_document_number}}      // Número de documento
{{estimated_time}}                // Tiempo estimado de revisión (ej: "6 horas")
{{support_email}}                 // Email de soporte (soporte@linkiu.bio)
```

### 📝 Ejemplo de contenido

**Asunto:** ⏳ Tu solicitud de tienda está en revisión

**Cuerpo:**
```html
<h2>Hola {{admin_name}},</h2>

<p>Tu solicitud de tienda <strong>{{store_name}}</strong> ha sido recibida y está siendo revisada por nuestro equipo.</p>

<div style="background-color: #fef3c7; padding: 15px; border-radius: 8px; margin: 20px 0;">
  <h3>📋 Información de tu solicitud</h3>
  <ul>
    <li><strong>Nombre de la tienda:</strong> {{store_name}}</li>
    <li><strong>Tipo de negocio:</strong> {{business_type}}</li>
    <li><strong>Documento fiscal:</strong> {{business_document_type}} - {{business_document_number}}</li>
  </ul>
</div>

<p>⏱️ <strong>Tiempo estimado de revisión:</strong> {{estimated_time}}</p>

<p>Recibirás un correo electrónico cuando tu tienda sea aprobada o si necesitamos más información.</p>

<hr>

<p><small>¿Tienes dudas? Contáctanos en <a href="mailto:{{support_email}}">{{support_email}}</a></small></p>
```

---

## 2️⃣ Plantilla: `store_approved`

### 📌 Descripción
Se envía al **Tenant Admin** cuando su tienda es aprobada manualmente.

### 📧 Template ID a configurar en
- Campo: `template_store_approved`
- Ruta: SuperAdmin → Configuración Email

### 🔑 Variables Disponibles

```handlebars
{{admin_name}}        // Nombre del administrador
{{store_name}}        // Nombre de la tienda
{{admin_email}}       // Email del administrador
{{password}}          // Contraseña (si fue generada automáticamente)
{{login_url}}         // URL de inicio de sesión del panel
{{store_url}}         // URL pública de la tienda
{{plan_name}}         // Nombre del plan (ej: "Explorer")
{{support_email}}     // Email de soporte
```

### 📝 Ejemplo de contenido

**Asunto:** ✅ ¡Tu tienda ha sido aprobada!

**Cuerpo:**
```html
<h2>¡Felicidades {{admin_name}}! 🎉</h2>

<p>Tu tienda <strong>{{store_name}}</strong> ha sido aprobada y está lista para empezar a vender.</p>

<div style="background-color: #d1fae5; padding: 20px; border-radius: 8px; margin: 20px 0;">
  <h3>🔐 Credenciales de acceso</h3>
  <ul>
    <li><strong>Email:</strong> {{admin_email}}</li>
    <li><strong>Contraseña:</strong> {{password}}</li>
  </ul>
  
  <p><a href="{{login_url}}" style="background-color: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 10px;">Acceder al Panel de Administración</a></p>
</div>

<div style="background-color: #e0e7ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
  <h3>🏪 Información de tu tienda</h3>
  <ul>
    <li><strong>URL de tu tienda:</strong> <a href="{{store_url}}">{{store_url}}</a></li>
    <li><strong>Plan activo:</strong> {{plan_name}}</li>
  </ul>
</div>

<h3>📚 Próximos pasos</h3>
<ol>
  <li>Inicia sesión en el panel de administración</li>
  <li>Configura los métodos de pago</li>
  <li>Agrega tus primeros productos</li>
  <li>Personaliza el diseño de tu tienda</li>
</ol>

<hr>

<p><small>¿Necesitas ayuda? Contáctanos en <a href="mailto:{{support_email}}">{{support_email}}</a></small></p>
```

---

## 3️⃣ Plantilla: `store_rejected`

### 📌 Descripción
Se envía al **Tenant Admin** cuando su solicitud es rechazada.

### 📧 Template ID a configurar en
- Campo: `template_store_rejected`
- Ruta: SuperAdmin → Configuración Email

### 🔑 Variables Disponibles

```handlebars
{{admin_name}}           // Nombre del administrador
{{store_name}}           // Nombre de la tienda
{{rejection_reason}}     // Motivo del rechazo (etiqueta legible)
{{rejection_message}}    // Mensaje personalizado del equipo
{{can_reapply_date}}     // Fecha desde la cual puede re-aplicar (ej: "25/10/2025")
{{appeal_email}}         // Email para apelaciones
```

### 📝 Ejemplo de contenido

**Asunto:** ❌ Tu solicitud de tienda ha sido rechazada

**Cuerpo:**
```html
<h2>Hola {{admin_name}},</h2>

<p>Lamentablemente, tu solicitud de tienda <strong>{{store_name}}</strong> no ha sido aprobada.</p>

<div style="background-color: #fee2e2; padding: 15px; border-radius: 8px; margin: 20px 0;">
  <h3>📋 Motivo del rechazo</h3>
  <p><strong>{{rejection_reason}}</strong></p>
  
  {{#if rejection_message}}
  <p style="margin-top: 10px;">{{rejection_message}}</p>
  {{/if}}
</div>

<h3>🔄 ¿Qué puedes hacer?</h3>

<ul>
  <li><strong>Re-aplicar:</strong> Puedes volver a aplicar a partir del <strong>{{can_reapply_date}}</strong></li>
  <li><strong>Apelar la decisión:</strong> Si crees que hubo un error, contáctanos en <a href="mailto:{{appeal_email}}">{{appeal_email}}</a></li>
  <li><strong>Corregir la información:</strong> Revisa los datos de tu documento fiscal y tipo de negocio</li>
</ul>

<hr>

<p><small>Estamos aquí para ayudarte. Escríbenos a <a href="mailto:{{appeal_email}}">{{appeal_email}}</a></small></p>
```

---

## 4️⃣ Plantilla: `new_store_request`

### 📌 Descripción
Se envía a todos los **SuperAdmins** cuando hay una nueva solicitud de tienda pendiente.

### 📧 Template ID a configurar en
- Campo: `template_new_store_request_superadmin`
- Ruta: SuperAdmin → Configuración Email

### 🔑 Variables Disponibles

```handlebars
{{store_name}}                    // Nombre de la tienda
{{business_type}}                 // Tipo de negocio
{{business_document_type}}        // Tipo de documento (NIT/CC/CE/RUT)
{{business_document_number}}      // Número de documento
{{admin_name}}                    // Nombre del administrador solicitante
{{admin_email}}                   // Email del administrador
{{created_at}}                    // Fecha/hora de la solicitud (ej: "10/10/2025 14:30")
{{review_url}}                    // URL directa para revisar la solicitud
```

### 📝 Ejemplo de contenido

**Asunto:** 🔔 Nueva solicitud de tienda pendiente de revisión

**Cuerpo:**
```html
<h2>Nueva Solicitud de Tienda 🏪</h2>

<p>Hay una nueva solicitud de tienda esperando revisión.</p>

<div style="background-color: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0;">
  <h3>📋 Detalles de la solicitud</h3>
  <ul>
    <li><strong>Nombre de la tienda:</strong> {{store_name}}</li>
    <li><strong>Tipo de negocio:</strong> {{business_type}}</li>
    <li><strong>Documento:</strong> {{business_document_type}} - {{business_document_number}}</li>
    <li><strong>Administrador:</strong> {{admin_name}} ({{admin_email}})</li>
    <li><strong>Fecha de solicitud:</strong> {{created_at}}</li>
  </ul>
  
  <p style="margin-top: 15px;">
    <a href="{{review_url}}" style="background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
      Revisar Solicitud
    </a>
  </p>
</div>

<p><strong>⏱️ Recuerda:</strong> El tiempo objetivo de revisión es de <strong>6 horas</strong>.</p>

<hr>

<p><small>Este es un correo automático del sistema de aprobación de tiendas.</small></p>
```

---

## ✅ Checklist de Configuración

Después de crear las 4 plantillas en SendGrid:

- [ ] Copiar el Template ID de cada una
- [ ] Ir a **SuperAdmin** → **Configuración de Email** en Linkiu
- [ ] Pegar cada Template ID en su campo correspondiente:
  - `template_store_pending_review`
  - `template_store_approved`
  - `template_store_rejected`
  - `template_new_store_request_superadmin`
- [ ] Guardar cambios
- [ ] **Probar** cada plantilla creando una tienda de prueba

---

## 🧪 Cómo Probar

### Test 1: `store_pending_review`
1. Ir a SuperAdmin → Crear Tienda (Wizard)
2. Seleccionar una categoría con **Revisión Manual**
3. Completar el formulario
4. Verificar que el admin reciba el email

### Test 2: `store_approved`
1. Ir a SuperAdmin → Solicitudes de Tiendas
2. Seleccionar una tienda pendiente
3. Clic en **Aprobar**
4. Verificar que el admin reciba el email

### Test 3: `store_rejected`
1. Ir a SuperAdmin → Solicitudes de Tiendas
2. Seleccionar una tienda pendiente
3. Clic en **Rechazar**
4. Verificar que el admin reciba el email

### Test 4: `new_store_request`
1. Crear una tienda que requiera revisión manual
2. Verificar que **todos los SuperAdmins** reciban el email

---

## 🆘 Soporte

Si tienes problemas configurando las plantillas:
- Verifica que el Template ID esté copiado correctamente
- Asegúrate de que las variables estén entre `{{}}` (handlebars)
- Revisa los logs en `storage/logs/laravel.log`
- Contacta al equipo técnico

---

**📝 Nota:** Las plantillas de SendGrid permiten HTML, CSS inline, y lógica con Handlebars (`{{#if}}`, `{{#each}}`, etc.)

**🎨 Tip de diseño:** Usa el editor visual de SendGrid para crear diseños más bonitos con drag & drop.

