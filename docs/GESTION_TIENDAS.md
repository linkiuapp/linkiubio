# 📦 Gestión de Tiendas

> Guía para Asesores Comerciales y Soporte Técnico

---

## ¿Qué es?

Es el panel principal donde los administradores de Linkiu pueden:
- **Crear** nuevas tiendas para clientes
- **Ver** todas las tiendas registradas en la plataforma
- **Gestionar** el estado de las tiendas (activar, desactivar, suspender)
- **Aprobar o rechazar** solicitudes de nuevas tiendas
- **Exportar** información para reportes

**¿Quién puede usarlo?** Solo administradores de Linkiu (SuperAdmin)

---

## ¿Cómo Funciona?

### Crear una Nueva Tienda

El sistema guía al usuario paso a paso (como un formulario de registro) solicitando:

1. **Datos de la tienda**: Nombre, dirección web única, email, teléfono
2. **Categoría del negocio**: Ropa, electrónica, alimentos, etc.
3. **Documentos**: RUT o DNI del dueño del negocio
4. **Ubicación**: País, región/departamento, ciudad
5. **Plan**: Básico, Profesional, Premium, etc.
6. **Administrador**: Datos de la persona que manejará la tienda
7. **Confirmación**: Revisar que todo esté correcto

### ¿Qué pasa después de crear la tienda?

El sistema decide automáticamente si la tienda puede empezar a funcionar de inmediato o necesita revisión:

**✅ Aprobación Inmediata**
- El documento (RUT/DNI) es válido
- La categoría del negocio no requiere revisión especial
- Se generan las credenciales (usuario y contraseña) al instante
- El cliente puede empezar a usar su tienda inmediatamente

**⏳ Requiere Revisión**
- El documento no puede validarse automáticamente
- La categoría requiere verificación manual (ej: productos regulados)
- Un administrador debe revisar y aprobar antes de activar

**🚀 Aprobación Directa (Casos especiales)**
- Para clientes de confianza o situaciones urgentes
- Se activa con el interruptor "Crear y aprobar directamente"
- Salta todas las validaciones

### Estados de una Tienda

Cada tienda puede estar en uno de estos estados:

- **🟢 Activa**: Funcionando normalmente, clientes pueden comprar
- **⚪ Inactiva**: Pausada temporalmente (puede reactivarse)
- **🔴 Suspendida**: Bloqueada por impago o incumplimiento

Además, las tiendas pueden tener:
- **Badge de verificación ✓**: Indica que es una tienda oficial o confiable

---

## ¿Cómo se Usa?

### 🆕 Crear una Tienda para un Cliente

1. Haz clic en el botón verde **"Nueva Tienda"** (arriba a la derecha)
2. Si es un cliente de confianza, activa el interruptor **"Crear y aprobar directamente"**
3. Completa el formulario paso a paso con los datos del cliente
4. Al finalizar, aparecerá una ventana con las credenciales generadas:
   - Usuario (email)
   - Contraseña temporal
5. **⚠️ IMPORTANTE**: Copia estas credenciales y envíalas al cliente. Solo se muestran una vez.

### 🔍 Buscar una Tienda

**Búsqueda rápida:**
- Escribe en la barra de búsqueda: nombre de la tienda, email, documento o dirección web

**Filtros avanzados:**
1. Haz clic en **"Filtros de Búsqueda"**
2. Selecciona los criterios:
   - **Plan**: ¿Qué plan tiene contratado?
   - **Estado**: ¿Activa, inactiva o suspendida?
   - **Verificación**: ¿Con o sin badge de verificación?
   - **Fechas**: ¿Creadas en qué período?
3. Haz clic en **"Filtrar"**

**Cambiar cómo se ven las tiendas:**
- Vista de lista (☰): Ver todas en una tabla con detalles
- Vista de tarjetas (⊞): Ver con logos e información visual

### ✏️ Editar Información de una Tienda

1. Busca la tienda
2. Haz clic en el botón **"Editar"** (ícono de lápiz)
3. Modifica lo que necesites:
   - Datos de contacto (teléfono, email)
   - Dirección física
   - Plan contratado
   - Descripciones y políticas
4. Haz clic en **"Guardar Cambios"**

**Nota**: No se puede cambiar la dirección web (URL) ni los documentos legales sin ayuda técnica.

### 🎯 Cambiar el Estado de una Tienda

**Para verificar una tienda (badge ✓):**
- Busca la tienda
- Activa el interruptor **"Verified"**
- El cambio es inmediato

**Para desactivar o suspender:**
1. Edita la tienda
2. Cambia el campo **"Estado"**:
   - **Activa**: Todo funciona normal
   - **Inactiva**: Pausada (el cliente puede reactivarla luego)
   - **Suspendida**: Bloqueada (solo admin puede reactivar)
3. Guarda los cambios

### ✅ Aprobar o Rechazar Solicitudes Pendientes

Cuando una tienda necesita revisión manual:

1. Filtra por **"Estado: Pendiente"**
2. Haz clic en la tienda para ver sus detalles
3. Revisa:
   - ¿Los documentos son válidos?
   - ¿La categoría es apropiada?
   - ¿La información es confiable?
4. Decide:
   - **Aprobar**: Se generan credenciales y se notifica al cliente
   - **Rechazar**: Indica el motivo del rechazo

### 👁️ Ver Toda la Información de una Tienda

1. Haz clic en el nombre de la tienda o en **"Ver"**
2. Verás:
   - Datos completos de la tienda
   - Plan contratado y fecha de renovación
   - Administradores que pueden acceder
   - Última vez que estuvo activa
   - Diseño (logo, colores)

### 🗑️ Eliminar una Tienda

**⚠️ Cuidado: Esta acción es muy delicada**

1. Busca la tienda
2. Haz clic en **"Eliminar"** (ícono de basura)
3. Confirma escribiendo el nombre exacto de la tienda
4. Haz clic en **"Eliminar definitivamente"**

**Antes de eliminar, verifica que:**
- No tenga pedidos pendientes
- No tenga facturas sin pagar
- El cliente esté de acuerdo

### 📊 Exportar Información

**Para crear reportes en Excel:**
1. Aplica los filtros que necesites (opcional)
2. Haz clic en **"Exportar Excel"**
3. Se descarga un archivo con todas las tiendas filtradas

**Qué incluye el reporte:**
- Nombre y dirección web de la tienda
- Email y teléfono de contacto
- Plan contratado
- Estado actual
- Si está verificada
- Fecha de creación

### ⚡ Acciones en Grupo (Múltiples Tiendas)

Para hacer cambios a varias tiendas a la vez:

1. Marca las casillas de las tiendas que quieres modificar
2. Aparecerá un menú especial en la parte superior
3. Selecciona la acción:
   - **Activar**: Poner en estado activo
   - **Desactivar**: Poner en estado inactivo
   - **Suspender**: Bloquear las tiendas
   - **Verificar**: Darles el badge ✓
   - **Quitar verificación**: Quitarles el badge
   - **Eliminar**: Borrar varias tiendas
4. Haz clic en **"Aplicar"**
5. Confirma la acción

**⚠️ Ten cuidado**: Los cambios se aplican a TODAS las tiendas seleccionadas y no se pueden deshacer fácilmente.

---

## Casos de Uso Frecuentes

### Caso 1: Cliente Nuevo Quiere Abrir su Tienda
1. Crea la tienda con "Aprobación directa" activada
2. Completa el formulario con sus datos
3. Copia las credenciales que aparecen
4. Envíale las credenciales por WhatsApp o Email

### Caso 2: Cliente Reporta que No Puede Acceder
1. Busca la tienda por nombre o email
2. Verifica que esté en estado **"Activa"**
3. Si está suspendida o inactiva, revisa el motivo
4. Si es necesario, reactívala editando el estado

### Caso 3: Cliente No Pagó su Plan
1. Busca la tienda
2. Edita la tienda
3. Cambia el estado a **"Suspendida"**
4. Agrega una nota explicando el motivo
5. Guarda los cambios

### Caso 4: Generar Reporte Mensual para Gerencia
1. Filtra por fechas: desde el primer día del mes hasta hoy
2. Haz clic en "Exportar Excel"
3. Envía el archivo a gerencia

### Caso 5: Verificar Varias Tiendas a la Vez
1. Filtra las tiendas que cumplan tus criterios
2. Marca todas las casillas
3. Selecciona **"Verificar"** en el menú de acciones
4. Confirma

---

## Preguntas Frecuentes

**¿Cómo recupero las credenciales de una tienda?**  
Las credenciales solo se muestran al crear la tienda. Si se perdieron, hay que resetear la contraseña desde el sistema.

**¿Puedo cambiar la dirección web de una tienda?**  
No directamente. Esto requiere asistencia del equipo técnico.

**¿Qué pasa si elimino una tienda por error?**  
Se puede recuperar contactando al equipo técnico, pero es un proceso complejo. Siempre verifica antes de eliminar.

**¿Cómo sé si una tienda está vendiendo?**  
En la vista de detalles puedes ver la fecha de "Última actividad".

**¿Puedo crear tiendas sin límite?**  
Sí, como SuperAdmin no hay límites en la creación de tiendas.

---

## Consejos Importantes

### ✅ Siempre Haz Esto
- Verifica los documentos antes de aprobar una tienda manualmente
- Copia las credenciales inmediatamente cuando creas una tienda
- Usa los filtros para encontrar tiendas rápido
- Agrega notas cuando hagas cambios importantes (suspensiones, cambios de plan)

### ❌ Nunca Hagas Esto
- No apruebes tiendas sin revisar bien la información
- No elimines tiendas que tengan pedidos activos
- No cambies el plan de una tienda sin avisarle al cliente primero
- No uses las acciones en grupo sin verificar qué tiendas seleccionaste

---

**Manual creado**: Octubre 2025  
**Para**: Equipo Comercial y Soporte Liniu

