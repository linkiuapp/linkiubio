// Clipboard Helpers basados en Preline UI
// Funciones helper para inicializar Clipboard.js

import ClipboardJS from 'clipboard';

// Track de elementos ya inicializados para evitar duplicados
const initializedElements = new WeakSet();

// Inicializar todos los elementos con clase .js-clipboard-example
function initClipboard() {
    const clipboardElements = document.querySelectorAll('.js-clipboard-example');
    
    clipboardElements.forEach(element => {
        // Evitar inicializar el mismo elemento múltiples veces
        if (initializedElements.has(element)) {
            return;
        }
        
        // Marcar como inicializado
        initializedElements.add(element);
        
        const clipboard = new ClipboardJS(element);
        
        clipboard.on('success', function(e) {
            // Obtener el texto de éxito
            const successText = element.getAttribute('data-clipboard-success-text') || 'Copied';
            
            // Ocultar icono por defecto y mostrar icono de éxito
            const defaultIcon = element.querySelector('.js-clipboard-default');
            const successIcon = element.querySelector('.js-clipboard-success');
            
            if (defaultIcon) {
                defaultIcon.classList.add('hidden');
            }
            
            if (successIcon) {
                successIcon.classList.remove('hidden');
            }
            
            // Si hay tooltip, mostrarlo
            const tooltip = element.querySelector('.hs-tooltip-content');
            if (tooltip) {
                tooltip.classList.remove('opacity-0', 'invisible', 'hidden');
                tooltip.classList.add('opacity-100', 'visible');
            }
            
            // Restaurar después de 2 segundos
            setTimeout(() => {
                if (defaultIcon) {
                    defaultIcon.classList.remove('hidden');
                }
                if (successIcon) {
                    successIcon.classList.add('hidden');
                }
                if (tooltip) {
                    tooltip.classList.remove('opacity-100', 'visible');
                    tooltip.classList.add('opacity-0', 'invisible', 'hidden');
                }
            }, 2000);
            
            e.clearSelection();
        });
        
        clipboard.on('error', function(e) {
            console.error('Error al copiar al portapapeles:', e);
        });
    });
}

// Flag para evitar múltiples inicializaciones
let clipboardInitialized = false;

// Inicializar cuando el DOM esté listo (solo una vez)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (!clipboardInitialized) {
            initClipboard();
            clipboardInitialized = true;
        }
    }, { once: true });
} else {
    if (!clipboardInitialized) {
        initClipboard();
        clipboardInitialized = true;
    }
}

// También inicializar después de cargas dinámicas de Alpine (solo una vez)
let alpineInitDone = false;
document.addEventListener('alpine:init', () => {
    if (!alpineInitDone) {
        setTimeout(() => {
            initClipboard();
            alpineInitDone = true;
        }, 100);
    }
}, { once: true });

export { initClipboard };

