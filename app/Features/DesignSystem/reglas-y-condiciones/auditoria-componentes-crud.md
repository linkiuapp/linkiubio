# Auditoría de componentes CRUD

## Reglas pendientes
1. _(pendiente)_
2. _(pendiente)_
3. _(pendiente)_
4. _(pendiente)_
5. _(pendiente)_

## Inventario de componentes

### Alertas
- `x-alert-bordered`
  - `categories/index`
  - `variables/create`
  - `variables/edit`
  - `coupons/index`
  - `sliders/index`
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`
  - `store-design/index`
- `x-alert-soft`
  - `categories/create`
  - `categories/edit`
  - `variables/create`
  - `variables/edit`
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`
- `x-alert-bordered` (warning)
  - `sliders/index`
  - `sliders/show`

### Botones y acciones
- `x-button-icon`
  - `categories/index`
  - `categories/create`
  - `categories/edit`
  - `categories/show`
  - `variables/index`
  - `variables/create`
  - `variables/edit`
  - `variables/show`
  - `coupons/index`
  - `coupons/create`
  - `coupons/edit`
  - `coupons/show`
  - `sliders/index`
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`
  - `store-design/index`
- `x-button-base`
  - `categories/create`
  - `categories/edit`
  - `variables/create`
  - `variables/edit`
  - `variables/show`
  - `coupons/create`
  - `coupons/edit`
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`
- `x-button-base` (outline/error)
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`

### Formularios y campos
- `x-input-with-icon`
  - `categories/create`
  - `coupons/index`
  - `sliders/create`
  - `sliders/edit`
- `x-input-with-label`
  - `coupons/create`
  - `coupons/edit`
  - `sliders/create`
  - `sliders/edit`
  - `store-design/index`
- `x-textarea-with-label`
  - `coupons/create`
  - `coupons/edit`
  - `store-design/index`
- `x-select-basic`
  - `categories/index`
  - `categories/create`
  - `categories/edit`
  - `variables/index`
  - `coupons/index`
  - `sliders/index`
- `x-select-with-label`
  - `coupons/create`
  - `coupons/edit`
- `x-card-base`
  - `variables/create`
  - `variables/edit`
  - `variables/show`
  - `sliders/create`
  - `sliders/edit`
  - `sliders/show`
  - `store-design/index`
- `x-badge-soft`
  - `categories/show`
  - `variables/show`
  - `coupons/show`
  - `sliders/show`
- `x-empty-state`
  - `variables/show`
  - `sliders/show`

### Switches, radios y checkboxes
- `x-switch-basic`
  - `categories/create`
  - `categories/edit`
  - `variables/create`
  - `variables/edit`
  - `coupons/create`
  - `coupons/edit`
  - `sliders/create`
  - `sliders/edit`
- `x-radio-basic`
  - `sliders/create`
  - `sliders/edit`
- `x-checkbox-with-description`
  - `coupons/create`
  - `coupons/edit`

### Subidas, colores y previews
- `x-file-upload-with-validation`
  - `sliders/create`
  - `sliders/edit`
  - `store-design/index`
- `x-color-picker-basic`
  - `store-design/index`
- `x-tenant-admin::header-preview`
  - `store-design/index`

## Observaciones de consistencia
- Los formularios de creación y edición de categorías y variables siguen usando `<input>` y `<textarea>` manuales, mientras que cupones, sliders y store design emplean componentes `x-input-with-label` y `x-textarea-with-label`. Unificar estas vistas facilitaría el mantenimiento y la validación visual.
- Las vistas `index` de categorías, variables, cupones y sliders comparten el patrón de `x-alert-bordered`, `x-button-icon` y filtros con `x-select-basic`, lo cual ya mantiene consistencia.
- Store design integra componentes exclusivos (`x-color-picker-basic`, `x-tenant-admin::header-preview`) no presentes en otros CRUD; documentar su uso evita reemplazos accidentales por componentes genéricos.
- Sliders es el único CRUD que mezcla `x-alert-bordered` de tipo `warning` en su tabla de resultados. Si otros módulos requieren estados parciales, replicar este patrón ayudaría a mantener coherencia visual.
- Las vistas `show` de categorías y cupones muestran `x-badge-soft` para resaltar atributos; en variables y sliders también se usan, pero con variantes de color. Conviene alinear la paleta según las guías del Design System para estados similares.
