# Reglas y Condiciones - Design System

## 📋 Reglas Obligatorias

### 1. **Solo íconos Lucide**
```html
<i data-lucide="star" class="w-5 h-5"></i>
```

### 2. **Solo se usan componentes de** `DesignSystem/Components/`
- Todos los componentes deben estar centralizados en esta carpeta
- No crear componentes inline ni duplicados
- Seguir la estructura modular establecida

### 3. **Cada función debe estar organizada y nombrada correctamente**
- **`index`**: Listado principal
- **`create`**: Formulario de creación
- **`show`**: Vista detalle/lectura
- **`edit`**: Formulario de edición
- **`page`**: Páginas específicas (landing, about, etc.)

### 4. **Indentación y formateo**
- **Indentación**: 4 espacios (no tabs)
- **Líneas**: Menores a 100 caracteres cuando sea posible
- **Líneas en blanco**: Para separar bloques lógicos (header, grid, footer de sección)
- **Lógica**: No lógica de negocio en Blade; solo control de flujo mínimo


### 5. **Comentarios** (clave para entender varias cards/sidebars)

#### Usar comentarios Blade `{{-- ... --}}`

**Encabezados de sección:**
```blade
{{-- SECTION: <Nombre descriptivo> --}}
```

**Región plegable:**
```blade
{{-- region: <Nombre> --}}
...contenido...
{{-- endregion --}}
```

**Bloques repetidos (cards, items de sidebar):**
```blade
{{-- ITEM: <tipo>#<index> | id:<id> | title:<título> --}}
```

**Para componentes:**
```blade
{{-- COMPONENT: <x-nombre> | props:{...} --}}
```

**Para listas:**
```blade
{{-- LIST: <nombre> | count:{{ $items->count() }} --}}
```

### 6. **Idioma: Español**
- Todas las etiquetas en español
- `aria-labels` en español
- Textos visibles en español
- Mensajes de error/validación en español

### 7. **Tailwind: Orden de clases**
```
layout → spacing → tipografía → color → estado
```

### 8. **Blade: Buenas prácticas**
- **Evitar lógica compleja** en las vistas
- **Usar `@forelse`** para listas que pueden estar vacías
- **Strings escapados** por defecto (`{{ }}` en lugar de `{!! !!}`)
- **Usar `@isset`, `@empty`** para verificaciones
- **Extraer lógica** a controladores o servicios

### 9. **Flujo obligatorio al tocar CRUDs**
- Antes de modificar vistas `index`, `create`, `show` o `edit`, revisa este archivo (`reglas-y-condiciones.md`) y el inventario de componentes en `auditoria-componentes-crud.md`.
- Escribe un plan breve (lista) con las secciones que vas a tocar y cómo validarás la funcionalidad.
- Refactoriza en bloques pequeños (inputs, alertas, tablas, modales) y corre pruebas manuales tras cada bloque.
- Comprueba que la lógica existente (validaciones, Alpine, fetch, uploads, eventos) siga funcionando antes de avanzar.

---


### **Iconografía (Lucide)**
- Solo íconos de Lucide Icons
- Tamaños estándar: `w-3 h-3`, `w-4 h-4`, `w-5 h-5`, `w-6 h-6`
- Siempre con clase de color coherente con el contexto

## 🧰 Prompt sugerido para trabajar vistas CRUD
Usa este prompt en Cursor/ChatGPT antes de intervenir una vista (`index`, `create`, `show`, `edit`):

```
Quiero refactorizar la vista <RUTA_BLADE> del CRUD <NOMBRE>. Sigue estas reglas:
- Consulta `reglas-y-condiciones/reglas-y-condiciones.md` y `auditoria-componentes-crud.md` antes de proponer cambios.
- Propón un plan en viñetas (inputs, alertas, tablas, Alpine, etc.) y espera confirmación antes de editar.
- Usa exclusivamente componentes de `DesignSystem` y respeta la paleta definida para `x-badge-soft`.
- Asegura que la lógica actual (validaciones, Alpine, fetch, uploads) se mantenga y detalla cómo la validarás.
- Tras cada bloque terminado, indica pruebas manuales realizadas y si detectas algo nuevo añádelo a la auditoría.
```

## ⚠️ Prohibiciones

1. **NO usar** íconos que no sean Lucide
2. **NO crear** componentes fuera de `DesignSystem/Components/`
3. **NO usar** `console.log` en producción
4. **NO mezclar** sistemas de diseño (solo Preline UI + nuestros colores)
5. **NO usar** CSS inline (excepto casos muy específicos)
6. **NO duplicar** código de componentes
7. **NO usar emojis** en código, comentarios o interfaces
8. **NO dejar** `console.log` después de terminar desarrollo
9. **NO crear archivos** innecesarios sin propósito específico

---
