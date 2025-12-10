# Larastan - Análisis Estático para Laravel

## ¿Qué es Larastan?

**Larastan** es una extensión de PHPStan diseñada específicamente para aplicaciones Laravel. Proporciona análisis estático de código que identifica errores y problemas potenciales **sin necesidad de ejecutar el código**.

### Beneficios

✅ **Detecta errores antes de ejecutar** - Encuentra bugs en tiempo de desarrollo  
✅ **Entiende la "magia" de Laravel** - Reconoce Eloquent, Facades, métodos mágicos  
✅ **Mejora la calidad del código** - Fuerza mejores prácticas y tipado  
✅ **Previene bugs en producción** - Detecta problemas antes del deploy  
✅ **Integración con CI/CD** - Puede ejecutarse en pipelines de integración continua  

---

## Instalación

Larastan ya está instalado en el proyecto:

```bash
composer require --dev larastan/larastan
```

---

## Configuración

El archivo de configuración está en `phpstan.neon` en la raíz del proyecto.

### Niveles de Análisis

Larastan tiene 10 niveles (0-9):

- **Nivel 0**: Mínimo - Solo errores básicos
- **Nivel 5**: Recomendado para empezar - Buen balance
- **Nivel 9**: Máximo - Detecta todo tipo de problemas

**Configuración actual:** Nivel 5

Para cambiar el nivel, edita `phpstan.neon`:
```neon
parameters:
    level: 5  # Cambiar aquí
```

---

## Uso

### Ejecutar Análisis

```bash
# Opción 1: Usando el script de Composer
composer analyse

# Opción 2: Directamente
./vendor/bin/phpstan analyse

# Opción 3: Con más memoria (si es necesario)
./vendor/bin/phpstan analyse --memory-limit=2G
```

### Analizar un directorio específico

```bash
./vendor/bin/phpstan analyse app/Features/TenantAdmin
```

### Generar Baseline (para proyectos grandes)

Si tienes muchos errores iniciales, puedes generar un baseline que ignore los errores existentes y solo reporte los nuevos:

```bash
composer analyse:baseline
```

Esto crea un archivo `phpstan-baseline.neon` que registra todos los errores actuales. Larastan solo reportará errores nuevos después de esto.

### Limpiar caché

```bash
composer analyse:clear
```

---

## Comandos Disponibles

| Comando | Descripción |
|---------|-------------|
| `composer analyse` | Ejecutar análisis estático |
| `composer analyse:baseline` | Generar baseline de errores |
| `composer analyse:clear` | Limpiar caché de resultados |

---

## Integración en el Flujo de Desarrollo

### Pre-commit Hook (Opcional)

Puedes agregar Larastan como hook de pre-commit para verificar el código antes de cada commit:

```bash
# En .git/hooks/pre-commit
#!/bin/sh
composer analyse
```

### CI/CD Pipeline

Ejemplo para GitHub Actions:

```yaml
name: Static Analysis

on: [push, pull_request]

jobs:
  larastan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: php-actions/composer@v6
      - name: Run Larastan
        run: composer analyse
```

---

## Errores Comunes y Soluciones

### 1. "Call to an undefined method"

**Problema:** Larastan no reconoce métodos de Eloquent o Facades.

**Solución:** Agregar anotaciones PHPDoc:

```php
/**
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 */
class Order extends Model
{
    // ...
}
```

### 2. "Property does not exist"

**Problema:** Propiedades dinámicas de Eloquent.

**Solución:** Usar `@property` en PHPDoc:

```php
/**
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 */
class Product extends Model
{
    // ...
}
```

### 3. Muchos errores iniciales

**Solución:** Generar baseline:

```bash
composer analyse:baseline
```

Esto crea `phpstan-baseline.neon` que ignora errores existentes.

---

## Mejores Prácticas

1. **Empezar con nivel bajo** - Comienza con nivel 3-5 y sube gradualmente
2. **Usar baseline** - Para proyectos grandes, genera baseline primero
3. **PHPDoc completo** - Documenta tipos en métodos y propiedades
4. **Corregir gradualmente** - No intentes corregir todos los errores de una vez
5. **Integrar en CI/CD** - Ejecuta análisis en cada PR

---

## Recursos

- [Documentación oficial de Larastan](https://github.com/larastan/larastan)
- [Documentación de PHPStan](https://phpstan.org/)
- [Niveles de análisis](https://phpstan.org/user-guide/rule-levels)

---

## Estado Actual del Proyecto

**Análisis inicial:** 849 errores encontrados (nivel 5)  
**Baseline generado:** ✅ 846 errores en baseline  
**Errores restantes:** 3 errores (no incluibles en baseline)

### ✅ Baseline Activo

El baseline está configurado y funcionando. Los errores existentes están ignorados y solo se reportarán **nuevos errores** introducidos después de la generación del baseline.

**Para verificar:**
```bash
composer analyse
# Debería mostrar: [OK] No errors (si no hay errores nuevos)
```

### Próximos Pasos

1. ✅ **Baseline generado** - Errores existentes ignorados
2. **Corregir gradualmente** - Enfocarse en errores críticos primero
3. **Subir nivel gradualmente** - Una vez corregidos los errores del nivel actual, subir a nivel 6, luego 7, etc.
4. **Re-generar baseline** cuando se corrijan errores:
   ```bash
   composer analyse:baseline
   ```

---

## Notas

- Larastan solo analiza código PHP, no Blade templates
- Requiere PHP 8.1+ y Laravel 8+
- El análisis puede ser lento en proyectos grandes (usa baseline)
- Los errores se reportan en formato legible con ubicación exacta del problema
- **Tipos de errores comunes encontrados:**
  - Propiedades no definidas en Models (agregar `@property` en PHPDoc)
  - Llamadas a `env()` fuera de config (usar `config()` en su lugar)
  - Tipos de retorno incorrectos (float vs int)
  - Comparaciones siempre falsas/verdaderas en match/if

