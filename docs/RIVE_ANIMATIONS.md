# Integración de Animaciones Rive.app

## Descripción

Guía para integrar animaciones exportadas desde [Rive.app](https://rive.app) en el proyecto. Rive.app exporta animaciones en formato `.riv`.

## Instalación

La librería `@rive-app/canvas` ya está instalada. Si necesitas reinstalarla:

```bash
npm install @rive-app/canvas --save
```

## Uso Básico

### 1. Exportar animación desde Rive.app

1. Crea tu animación en Rive.app
2. Exporta como **Rive (.riv)**
3. Guarda el archivo `.riv` en `public/animations/` (o la carpeta que prefieras)

### 2. Usar el componente Blade

```blade
<x-rive-animation 
    src="{{ asset('animations/mi-animacion.riv') }}"
    width="300"
    height="300"
/>
```

## Props del Componente

| Prop | Tipo | Default | Descripción |
|------|------|---------|-------------|
| `src` | string | **requerido** | Ruta al archivo .riv de la animación |
| `width` | number | 200 | Ancho de la animación en píxeles |
| `height` | number | 200 | Alto de la animación en píxeles |
| `autoplay` | boolean | true | Si debe iniciar automáticamente |
| `stateMachine` | string | null | Nombre de la state machine a usar |
| `artboard` | string | null | Nombre del artboard a usar |
| `class` | string | '' | Clases CSS adicionales |
| `id` | string | null | ID único (se genera automáticamente si no se especifica) |

## Ejemplos

### Animación básica

```blade
<x-rive-animation 
    src="{{ asset('animations/loading.riv') }}"
/>
```

### Animación personalizada

```blade
<x-rive-animation 
    src="{{ asset('animations/success.riv') }}"
    width="150"
    height="150"
    :autoplay="true"
    class="mx-auto"
/>
```

### Animación con State Machine

```blade
<x-rive-animation 
    src="{{ asset('animations/button.riv') }}"
    state-machine="ButtonStateMachine"
    width="200"
    height="200"
/>
```

### Animación con Artboard específico

```blade
<x-rive-animation 
    src="{{ asset('animations/hero.riv') }}"
    artboard="HeroAnimation"
    width="500"
    height="500"
/>
```

### Animación con control manual

```blade
<x-rive-animation 
    id="my-animation"
    src="{{ asset('animations/interactive.riv') }}"
    :autoplay="false"
/>

<script>
    // Esperar a que la animación esté lista
    document.getElementById('my-animation').addEventListener('rive-animation-ready', (e) => {
        const rive = e.detail.rive;
        
        // Controlar la animación
        rive.play();
        // rive.pause();
        // rive.reset();
    });
</script>
```

### Animación interactiva con Alpine.js

```blade
<div x-data="{ isPlaying: false }">
    <button @click="isPlaying = !isPlaying">
        <span x-text="isPlaying ? 'Pausar' : 'Reproducir'"></span>
    </button>
    
    <x-rive-animation 
        id="alpine-animation"
        src="{{ asset('animations/play-pause.riv') }}"
        state-machine="PlayPauseStateMachine"
        :autoplay="false"
    />
    
    <script>
        document.getElementById('alpine-animation').addEventListener('rive-animation-ready', (e) => {
            const rive = e.detail.rive;
            const inputs = rive.stateMachineInputs('PlayPauseStateMachine');
            
            // Escuchar cambios de Alpine
            Alpine.effect(() => {
                const playing = Alpine.$data(document.querySelector('[x-data]')).isPlaying;
                if (inputs && inputs.length > 0) {
                    inputs[0].value = playing;
                }
            });
        });
    </script>
</div>
```

## Estructura de Carpetas Recomendada

```
public/
  animations/
    loading.riv
    success.riv
    error.riv
    button.riv
    hero.riv
    ...
```

## Control Programático

Una vez que la animación está lista, puedes controlarla:

```javascript
const canvas = document.getElementById('my-animation');
const rive = canvas.riveInstance;

// Reproducir
rive.play();

// Pausar
rive.pause();

// Resetear
rive.reset();

// Obtener inputs de state machine
const inputs = rive.stateMachineInputs('StateMachineName');
if (inputs && inputs.length > 0) {
    inputs[0].value = true; // Cambiar valor del input
}

// Obtener artboards
const artboards = rive.artboards;
```

## Eventos Disponibles

El componente dispara eventos personalizados:

- `rive-animation-ready`: Se dispara cuando la animación está lista
- `rive-animation-loaded`: Se dispara cuando la animación se ha cargado completamente

```javascript
canvas.addEventListener('rive-animation-ready', (e) => {
    const rive = e.detail.rive;
    // La animación está lista para usar
});

canvas.addEventListener('rive-animation-loaded', (e) => {
    // La animación se cargó completamente
});
```

## State Machines

Rive permite crear state machines para controlar animaciones interactivas. Para usarlas:

1. Crea una state machine en Rive.app
2. Nombra los inputs (boolean, number, trigger)
3. Usa el nombre de la state machine en el prop `state-machine`
4. Controla los inputs programáticamente

```blade
<x-rive-animation 
    id="button-animation"
    src="{{ asset('animations/button.riv') }}"
    state-machine="ButtonStateMachine"
/>

<script>
    const canvas = document.getElementById('button-animation');
    canvas.addEventListener('rive-animation-ready', (e) => {
        const rive = e.detail.rive;
        const inputs = rive.stateMachineInputs('ButtonStateMachine');
        
        // Controlar inputs
        canvas.addEventListener('mouseenter', () => {
            inputs.find(i => i.name === 'Hover')?.fire();
        });
        
        canvas.addEventListener('click', () => {
            inputs.find(i => i.name === 'Click')?.fire();
        });
    });
</script>
```

## Mejores Prácticas

1. **Optimiza tus animaciones**: Rive permite exportar versiones optimizadas
2. **Usa tamaños apropiados**: No uses animaciones más grandes de lo necesario
3. **Considera el rendimiento**: Las animaciones complejas pueden afectar el rendimiento en móviles
4. **Lazy loading**: Para animaciones que no están visibles inicialmente, considera cargarlas solo cuando sean necesarias
5. **Preload críticas**: Para animaciones importantes (como loading), considera pre-cargarlas
6. **State Machines**: Usa state machines para animaciones interactivas en lugar de controlar frames manualmente

## Troubleshooting

### La animación no aparece

1. Verifica que la ruta al archivo .riv sea correcta
2. Abre la consola del navegador para ver errores
3. Verifica que el archivo .riv sea válido

### La animación es muy lenta

1. Reduce la complejidad de la animación en Rive.app
2. Reduce el número de objetos y efectos
3. Optimiza los assets (imágenes, etc.)

### La animación no se reproduce

1. Verifica que `autoplay` esté en `true` o llama a `rive.play()` manualmente
2. Verifica que la librería Rive se haya cargado correctamente
3. Revisa la consola del navegador para errores

### State Machine no funciona

1. Verifica que el nombre de la state machine sea correcto
2. Asegúrate de que la state machine esté exportada en el archivo .riv
3. Verifica que los nombres de los inputs coincidan exactamente

## Recursos

- [Rive.app](https://rive.app) - Crear animaciones
- [Rive Documentation](https://rive.app/community/doc) - Documentación oficial
- [Rive Web Runtime](https://github.com/rive-app/rive-wasm) - Repositorio del runtime
- [Rive Examples](https://rive.app/community/join-web) - Ejemplos y comunidad

