{{--
    Componente: Rive Animation
    Componente para mostrar animaciones exportadas desde Rive.app (formato .riv)
    
    Props:
    - src: Ruta al archivo .riv de la animación (requerido)
    - width: Ancho de la animación (default: 200)
    - height: Alto de la animación (default: 200)
    - autoplay: Si debe iniciar automáticamente (default: true)
    - stateMachine: Nombre de la state machine a usar (opcional)
    - artboard: Nombre del artboard a usar (opcional)
    - class: Clases CSS adicionales
    - id: ID único para el contenedor (opcional, se genera automáticamente)
--}}

@props([
    'src' => null,
    'width' => 200,
    'height' => 200,
    'autoplay' => true,
    'stateMachine' => null,
    'artboard' => null,
    'class' => '',
    'id' => null,
])

@php
    if (!$src) {
        throw new \Exception('Rive Animation: El prop "src" es requerido. Debe ser la ruta al archivo .riv de la animación.');
    }
    
    $uniqueId = $id ?? 'rive-animation-' . uniqid();
@endphp

<canvas 
    id="{{ $uniqueId }}"
    class="rive-animation-canvas {{ $class }}"
    width="{{ $width }}"
    height="{{ $height }}"
    style="width: {{ $width }}px; height: {{ $height }}px;"
    data-src="{{ $src }}"
    data-autoplay="{{ $autoplay ? 'true' : 'false' }}"
    @if($stateMachine) data-state-machine="{{ $stateMachine }}" @endif
    @if($artboard) data-artboard="{{ $artboard }}" @endif
></canvas>

@push('scripts')
<script>
    (function() {
        'use strict';
        
        // Cargar Rive solo cuando sea necesario
        let riveLoaded = false;
        let riveLoadPromise = null;
        
        function loadRive() {
            if (riveLoaded) {
                return Promise.resolve();
            }
            
            if (riveLoadPromise) {
                return riveLoadPromise;
            }
            
            riveLoadPromise = new Promise((resolve, reject) => {
                if (typeof rive !== 'undefined') {
                    riveLoaded = true;
                    resolve();
                    return;
                }
                
                // Cargar desde CDN si no está disponible
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/@rive-app/canvas@2.4.0/rive.js';
                script.onload = () => {
                    riveLoaded = true;
                    resolve();
                };
                script.onerror = reject;
                document.head.appendChild(script);
            });
            
            return riveLoadPromise;
        }
        
        function initRiveAnimation(canvas) {
            const src = canvas.dataset.src;
            const autoplay = canvas.dataset.autoplay === 'true';
            const stateMachine = canvas.dataset.stateMachine || null;
            const artboard = canvas.dataset.artboard || null;
            
            if (!src) {
                console.error('Rive Animation: No se especificó la ruta de la animación');
                return;
            }
            
            loadRive().then(() => {
                if (typeof rive === 'undefined') {
                    console.error('Rive Animation: No se pudo cargar la librería Rive');
                    return;
                }
                
                // Configuración de la animación
                const config = {
                    src: src,
                    canvas: canvas,
                    autoplay: autoplay,
                };
                
                // Agregar state machine si se especifica
                if (stateMachine) {
                    config.stateMachines = [stateMachine];
                }
                
                // Agregar artboard si se especifica
                if (artboard) {
                    config.artboard = artboard;
                }
                
                // Cargar y renderizar la animación
                const riveInstance = new rive.Rive(config);
                
                // Guardar referencia para control externo
                canvas.riveInstance = riveInstance;
                
                // Eventos útiles
                riveInstance.on('rive', (event) => {
                    canvas.dispatchEvent(new CustomEvent('rive-animation-ready', {
                        detail: { rive: riveInstance }
                    }));
                });
                
                riveInstance.on('load', () => {
                    canvas.dispatchEvent(new CustomEvent('rive-animation-loaded', {
                        detail: { rive: riveInstance }
                    }));
                });
            }).catch(error => {
                console.error('Rive Animation: Error al cargar la animación', error);
            });
        }
        
        // Inicializar cuando el DOM esté listo
        function initAllAnimations() {
            document.querySelectorAll('.rive-animation-canvas').forEach(canvas => {
                if (!canvas.riveInstance) {
                    initRiveAnimation(canvas);
                }
            });
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAllAnimations);
        } else {
            initAllAnimations();
        }
        
        // Inicializar animaciones agregadas dinámicamente
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // Element node
                        if (node.classList && node.classList.contains('rive-animation-canvas')) {
                            initRiveAnimation(node);
                        }
                        // También buscar dentro del nodo
                        const canvases = node.querySelectorAll && node.querySelectorAll('.rive-animation-canvas');
                        if (canvases) {
                            canvases.forEach(initRiveAnimation);
                        }
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    })();
</script>
@endpush

