/**
 * Datepicker initialization using Litepicker
 * Better UX for date and time selection in reservations
 * 
 * Lazy loading: Litepicker solo se carga cuando hay inputs de fecha en la página
 */

let litepickerLoaded = false;
let LitepickerModule = null;

/**
 * Cargar Litepicker dinámicamente solo cuando sea necesario
 */
async function loadLitepicker() {
    if (litepickerLoaded && LitepickerModule) {
        return LitepickerModule;
    }

    try {
        const litepickerModule = await import('litepicker');
        // Litepicker v2 exporta como default
        const Litepicker = litepickerModule.default;
        
        if (!Litepicker) {
            return null;
        }
        
        LitepickerModule = Litepicker;
        litepickerLoaded = true;
        
        return LitepickerModule;
    } catch (error) {
        return null;
    }
}

/**
 * Inicializar datepicker para reservaciones (solo fecha)
 */
export async function initReservationDatepicker(selector, options = {}) {
    const LitePicker = await loadLitepicker();
    if (!LitePicker) {
        return null;
    }

    const defaultOptions = {
        format: 'YYYY-MM-DD', // Formato ISO: 2025-11-04
        minDate: new Date(), // Fecha mínima: hoy
        autoApply: true,
        singleMode: true,
        // Forzar formato ISO explícitamente
        transform: function(date) {
            // Asegurar que la fecha se guarde en formato YYYY-MM-DD
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        dropdowns: {
            minYear: new Date().getFullYear(),
            maxYear: new Date().getFullYear() + 1,
            months: true,
            years: true
        },
        lang: 'es-ES',
        // Hacer el calendario más compacto
        showTooltip: false,
        position: 'auto'
    };

    const litepickerOptions = { ...defaultOptions, ...options };

    // Si el selector es un string, convertirlo a elemento
    const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
    
    if (!element) {
        return null;
    }

    // Destruir instancia anterior si existe
    if (element._litepicker) {
        element._litepicker.destroy();
    }

    // Asegurar que el elemento sea un input type="text"
    if (element.type === 'date') {
        element.type = 'text';
    }
    
    // Asegurar que no tenga atributos que interfieran
    element.removeAttribute('readonly');
    element.removeAttribute('disabled');

    try {
        const picker = new LitePicker({
            element: element,
            ...litepickerOptions
        });
        
        // Verificar que se creó correctamente
        if (!picker) {
            return null;
        }

        // Guardar referencia en el elemento
        element._litepicker = picker;

        return picker;
    } catch (error) {
        return null;
    }
}

/**
 * Inicializar timepicker para horas
 * Usamos un selector personalizado en formato 24 horas
 */
export async function initReservationTimepicker(selector, options = {}) {
    const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
    
    if (!element) {
        return null;
    }

    // Asegurar que sea tipo text para usar nuestro selector personalizado
    if (element.type === 'time') {
        element.type = 'text';
    }

    // Cargar y usar el timepicker personalizado
    const { initCustomTimepicker } = await import('./timepicker.js');
    return initCustomTimepicker(element);
}

/**
 * Inicializar datepicker con fechas deshabilitadas
 */
export async function initDatepickerWithDisabledDates(selector, disabledDates = []) {
    const LitePicker = await loadLitepicker();
    if (!LitePicker) {
        return null;
    }

    const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
    
    if (!element) {
        return null;
    }

    // Destruir instancia anterior si existe
    if (element._litepicker) {
        element._litepicker.destroy();
    }

    const picker = new LitePicker({
        element: element,
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        autoApply: true,
        singleMode: true,
        lang: 'es-ES',
        // Deshabilitar fechas específicas usando lockDays
        lockDays: disabledDates.map(date => {
            // Si es un número (día de la semana), usar disableWeekdays
            if (typeof date === 'number') {
                return date;
            }
            // Si es una fecha, convertirla a formato compatible
            return new Date(date);
        })
    });

    element._litepicker = picker;

    return picker;
}

// Función para inicializar todos los datepickers
async function initializeAllDatepickers() {
    // Verificar si hay datepickers en la página antes de inicializar
    const hasDatepickers = document.querySelectorAll('.reservation-datepicker, .reservation-timepicker, .slot-timepicker').length > 0;
    
    if (!hasDatepickers) {
        return false; // Salir temprano si no hay datepickers - no carga Litepicker
    }

    try {
        // Cargar Litepicker solo cuando sea necesario
        await loadLitepicker();

        // Inicializar todos los datepickers con clase 'reservation-datepicker'
        const dateInputs = document.querySelectorAll('.reservation-datepicker');
        for (const input of dateInputs) {
            if (!input._litepicker) {
                await initReservationDatepicker(input);
            }
        }

        // Inicializar todos los timepickers con clase 'reservation-timepicker'
        const timeInputs = document.querySelectorAll('.reservation-timepicker');
        for (const input of timeInputs) {
            if (!input._timepickerInitialized) {
                await initReservationTimepicker(input);
                input._timepickerInitialized = true;
            }
        }
        
        // Inicializar timepickers de slots de horarios
        const slotTimeInputs = document.querySelectorAll('.slot-timepicker');
        for (const input of slotTimeInputs) {
            if (!input._timepickerInitialized) {
                await initReservationTimepicker(input);
                input._timepickerInitialized = true;
            }
        }
        
        return true;
    } catch (error) {
        return false;
    }
}

// Auto-inicializar datepickers cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', async () => {
        await initializeAllDatepickers();
    });
} else {
    // DOM ya está listo, inicializar inmediatamente
    initializeAllDatepickers();
}

// También intentar después de que Alpine esté listo (por si hay componentes dinámicos)
if (window.Alpine) {
    document.addEventListener('alpine:init', async () => {
        setTimeout(async () => {
            await initializeAllDatepickers();
        }, 300);
    });
}

// Observer para inicializar datepickers dinámicos creados por Alpine
const datepickerObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) { // Element node
                // Buscar datepickers dentro del nodo agregado
                const dateInputs = node.querySelectorAll ? node.querySelectorAll('.reservation-datepicker') : [];
                dateInputs.forEach(async (input) => {
                    if (!input._litepicker) {
                        await initReservationDatepicker(input);
                    }
                });

                const timeInputs = node.querySelectorAll ? node.querySelectorAll('.slot-timepicker, .reservation-timepicker') : [];
                timeInputs.forEach(async (input) => {
                    if (!input._timepickerInitialized) {
                        await initReservationTimepicker(input);
                        input._timepickerInitialized = true;
                    }
                });
            }
        });
    });
});

// Iniciar observer cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        datepickerObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
} else {
    datepickerObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
}

// Hacer funciones disponibles globalmente
window.initReservationDatepicker = initReservationDatepicker;
window.initReservationTimepicker = initReservationTimepicker;
window.loadLitepicker = loadLitepicker;
window.initializeAllDatepickers = initializeAllDatepickers;
