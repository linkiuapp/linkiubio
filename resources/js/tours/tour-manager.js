/**
 * Tour Manager - Sistema de tours guiados con Driver.js
 * 
 * Gestiona todos los tours de la aplicación y controla
 * cuándo deben mostrarse según el estado del usuario.
 */

import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';

// Importar tours individuales - E-commerce
import { tourDashboardBienvenida } from './ecommerce/dashboard-bienvenida';
import { tourGestionarCategorias } from './ecommerce/gestionar-categorias';
import { tourCrearCategoria } from './ecommerce/crear-categoria';
import { tourGestionarVariables } from './ecommerce/gestionar-variables';
import { tourCrearVariable } from './ecommerce/crear-variable';
import { tourGestionarProductos } from './ecommerce/gestionar-productos';
import { tourCrearProducto } from './ecommerce/crear-producto';
import { tourCrearMetodoPago } from './ecommerce/crear-metodo-pago';
import { tourConfigurarEnvios } from './ecommerce/configurar-envios';
import { tourDisenoTienda } from './ecommerce/diseno-tienda';
import { tourCrearCupon } from './ecommerce/crear-cupon';
import { tourGestionarPedido } from './ecommerce/gestionar-pedido';
import { tourCrearSlider } from './ecommerce/crear-slider';
import { tourCrearSede } from './ecommerce/crear-sede';
import { tourCrearCuentaBancaria } from './ecommerce/crear-cuenta-bancaria';
import { tourGestionarInventario } from './ecommerce/gestionar-inventario';
import { tourNotificacionesWhatsapp } from './ecommerce/notificaciones-whatsapp';
import { tourGestionarMetodosPago } from './ecommerce/gestionar-metodos-pago';
import { tourGestionarSedes } from './ecommerce/gestionar-sedes';
import { tourGestionarCupones } from './ecommerce/gestionar-cupones';
import { tourGestionarSliders } from './ecommerce/gestionar-sliders';

// Importar tours individuales - Restaurant
import { tourCrearReservaMesa } from './restaurant/crear-reserva-mesa';
import { tourGestionarMesas } from './restaurant/gestionar-mesas';
import { tourGestionarConsumoLocal } from './restaurant/gestionar-consumo-local';

// Importar tours individuales - Hotel
import { tourCrearTipoHabitacion } from './hotel/crear-tipo-habitacion';
import { tourGestionarHabitaciones } from './hotel/gestionar-habitaciones';
import { tourCrearReservaHabitacion } from './hotel/crear-reserva-habitacion';

// Registro de tours
const TOURS = {
    // E-commerce
    'dashboard_bienvenida': tourDashboardBienvenida,
    'gestionar_categorias': tourGestionarCategorias,
    'crear_categoria': tourCrearCategoria,
    'gestionar_variables': tourGestionarVariables,
    'crear_variable': tourCrearVariable,
    'gestionar_productos': tourGestionarProductos,
    'crear_producto': tourCrearProducto,
    'crear_metodo_pago': tourCrearMetodoPago,
    'configurar_envios': tourConfigurarEnvios,
    'diseño_tienda': tourDisenoTienda,
    'crear_cupon': tourCrearCupon,
    'gestionar_pedido': tourGestionarPedido,
    'crear_slider': tourCrearSlider,
    'crear_variable': tourCrearVariable,
    'crear_sede': tourCrearSede,
    'crear_cuenta_bancaria': tourCrearCuentaBancaria,
    'gestionar_inventario': tourGestionarInventario,
    'notificaciones_whatsapp': tourNotificacionesWhatsapp,
    'gestionar_metodos_pago': tourGestionarMetodosPago,
    'gestionar_sedes': tourGestionarSedes,
    'gestionar_cupones': tourGestionarCupones,
    'gestionar_sliders': tourGestionarSliders,
    
    // Restaurant
    'crear_reserva_mesa': tourCrearReservaMesa,
    'gestionar_mesas': tourGestionarMesas,
    'gestionar_consumo_local': tourGestionarConsumoLocal,
    
    // Hotel
    'crear_tipo_habitacion': tourCrearTipoHabitacion,
    'gestionar_habitaciones': tourGestionarHabitaciones,
    'crear_reserva_habitacion': tourCrearReservaHabitacion,
};

/**
 * Orden de tours para ecommerce
 * Define la secuencia en que deben mostrarse los tours
 */
const ECOMMERCE_TOUR_ORDER = [
    'dashboard_bienvenida',    // 1. Bienvenida
    'diseño_tienda',           // 2. Diseño de tienda
    'gestionar_categorias',    // 3. Gestionar categorías
    'crear_categoria',         // 4. Crear categoría
    'gestionar_variables',     // 5. Gestionar variables
    'crear_variable',          // 6. Crear variable
    'gestionar_productos',     // 7. Gestionar productos
    'crear_producto',          // 8. Crear producto
    'gestionar_inventario',    // 9. Inventarios
    'configurar_envios',       // 10. Gestión de envíos
    'gestionar_metodos_pago',  // 11. Gestionar métodos de pago
    'crear_metodo_pago',       // 12. Crear método de pago
    'gestionar_sedes',         // 13. Gestionar sedes
    'gestionar_cupones',       // 14. Gestionar cupones
    'gestionar_sliders',       // 15. Gestionar sliders
    'crear_sede',              // 10. Sedes
    'notificaciones_whatsapp', // 11. Notificaciones por WhatsApp
    'crear_cupon',             // 12. Cupones
    'crear_slider',            // 13. Slider
];

/**
 * Configuración base para todos los tours
 */
const BASE_CONFIG = {
    showProgress: true,
    progressText: '{{current}} de {{total}}',
    nextBtnText: 'Siguiente →',
    prevBtnText: '← Anterior',
    doneBtnText: '¡Entendido!',
    allowClose: true,
    // Configuración del overlay - solo el backdrop debe estar oscuro
    overlayColor: 'rgba(0, 0, 0, 0.75)',
    overlayOpacity: 0.75,
    // Configuración del elemento destacado
    stagePadding: 10,
    stageRadius: 8,
    // Permitir interacción con el elemento destacado (no deshabilitarlo)
    disableActiveInteraction: false,
    // Configuración del popover
    popoverClass: 'linkiu-tour-popover',
    popoverOffset: 10,
    // Animaciones y navegación
    animate: true,
    smoothScroll: true,
    allowKeyboardControl: true,
    // Comportamiento del overlay al hacer clic
    overlayClickBehavior: 'close',
};

/**
 * Verificar si un tour ya fue completado o saltado
 */
function isTourCompleted(tourName) {
    return localStorage.getItem(`tour_${tourName}_completed`) === 'true';
}

/**
 * Marcar tour como completado
 */
function markTourCompleted(tourName) {
    localStorage.setItem(`tour_${tourName}_completed`, 'true');
}

/**
 * Resetear un tour específico (para poder verlo de nuevo)
 */
function resetTour(tourName) {
    localStorage.removeItem(`tour_${tourName}_completed`);
}

/**
 * Resetear todos los tours
 */
function resetAllTours() {
    Object.keys(TOURS).forEach(tourName => {
        localStorage.removeItem(`tour_${tourName}_completed`);
    });
}

/**
 * Iniciar un tour específico
 */
function startTour(tourName, forceStart = false) {
    // Verificar si el tour existe
    if (!TOURS[tourName]) {
        console.warn(`Tour "${tourName}" no encontrado`);
        return null;
    }

    // Verificar si ya fue completado (a menos que se fuerce)
    if (!forceStart && isTourCompleted(tourName)) {
        console.log(`Tour "${tourName}" ya fue completado`);
        return null;
    }

    // Obtener configuración del tour
    const tourConfig = TOURS[tourName]();
    
    // Crear instancia del driver con configuración combinada
    const driverObj = driver({
        ...BASE_CONFIG,
        ...tourConfig,
        // Hook para personalizar el popover después de renderizarse
        onPopoverRender: (popover, { config, state, driver }) => {
            // Si es el último step y tiene onNextClick, cambiar el texto del botón y agregar el handler
            const currentStep = tourConfig.steps[state.activeIndex];
            if (currentStep && currentStep.popover) {
                // Cambiar texto del botón si está definido
                if (currentStep.popover.nextBtnText) {
                    const nextButton = popover.querySelector('[data-driverjs-next-btn]');
                    if (nextButton) {
                        nextButton.textContent = currentStep.popover.nextBtnText;
                    }
                }
                
                // Agregar handler para onNextClick si existe
                if (currentStep.popover.onNextClick && state.activeIndex === tourConfig.steps.length - 1) {
                    const nextButton = popover.querySelector('[data-driverjs-next-btn]');
                    if (nextButton) {
                        // Remover listeners anteriores
                        const newNextButton = nextButton.cloneNode(true);
                        nextButton.parentNode.replaceChild(newNextButton, nextButton);
                        
                        // Agregar nuevo listener
                        newNextButton.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            currentStep.popover.onNextClick();
                            driver.destroy();
                        });
                    }
                }
            }
            
            // Ejecutar callback personalizado del tour si existe
            if (tourConfig.onPopoverRender) {
                tourConfig.onPopoverRender(popover, { config, state, driver });
            }
        },
        // Hook cuando se destaca un elemento
        onHighlighted: (element, step, { config, state, driver }) => {
            // Asegurar que el elemento destacado sea interactivo
            if (element) {
                element.style.pointerEvents = 'auto';
                // Asegurar que los inputs dentro sean visibles
                const inputs = element.querySelectorAll('input, textarea, select, button');
                inputs.forEach(input => {
                    input.style.opacity = '1';
                    input.style.visibility = 'visible';
                });
            }
            
            // Ejecutar callback personalizado del tour si existe
            if (tourConfig.onHighlighted) {
                tourConfig.onHighlighted(element, step, { config, state, driver });
            }
        },
        onDestroyStarted: () => {
            // Marcar como completado cuando termina o se cierra (incluso con X)
            // Esto evita que vuelva a auto-iniciarse, pero el botón flotante seguirá permitiendo iniciarlo manualmente
            // usando forceStart = true
            markTourCompleted(tourName);
            
            // Ejecutar callback personalizado si existe (esto puede incluir redirecciones)
            // Solo si el tour tiene un callback onComplete configurado (indica que se completó correctamente)
            if (tourConfig.onComplete) {
                tourConfig.onComplete();
                // Si el callback redirige, no continuar con el siguiente tour
                return;
            }
            
            // NO auto-iniciar el siguiente tour automáticamente
            // Los tours solo deben iniciarse cuando el usuario los solicita explícitamente
            // o cuando se inician desde el flujo de onboarding (dashboard_bienvenida)
            // Esto evita que aparezcan tours de otras secciones cuando se navega entre páginas
            
            driverObj.destroy();
        },
    });

    // Iniciar el tour
    driverObj.drive();
    
    return driverObj;
}

/**
 * Obtener el siguiente tour en el orden para ecommerce
 */
function getNextTourInOrder(currentTour, vertical = 'ecommerce') {
    if (vertical !== 'ecommerce') {
        return null;
    }
    
    const currentIndex = ECOMMERCE_TOUR_ORDER.indexOf(currentTour);
    if (currentIndex === -1 || currentIndex === ECOMMERCE_TOUR_ORDER.length - 1) {
        return null;
    }
    
    return ECOMMERCE_TOUR_ORDER[currentIndex + 1];
}

/**
 * Auto-iniciar tour si está disponible y no ha sido completado
 */
function autoStartTour(tourName, delay = 500) {
    if (isTourCompleted(tourName)) {
        return null;
    }

    return setTimeout(() => {
        startTour(tourName);
    }, delay);
}

/**
 * Iniciar secuencia de tours para ecommerce en orden
 */
function startEcommerceTourSequence(vertical = 'ecommerce') {
    if (vertical !== 'ecommerce') {
        return;
    }
    
    // Buscar el primer tour disponible que no haya sido completado
    for (const tourName of ECOMMERCE_TOUR_ORDER) {
        if (isTourAvailable(tourName) && !isTourCompleted(tourName)) {
            startTour(tourName, false);
            break;
        }
    }
}

/**
 * Verificar si un tour está disponible para mostrar
 */
function isTourAvailable(tourName) {
    return TOURS.hasOwnProperty(tourName) && !isTourCompleted(tourName);
}

// Exponer funciones globalmente
window.LinkiuTours = {
    start: startTour,
    autoStart: autoStartTour,
    startSequence: startEcommerceTourSequence,
    isCompleted: isTourCompleted,
    isAvailable: isTourAvailable,
    markCompleted: markTourCompleted,
    reset: resetTour,
    resetAll: resetAllTours,
    getNextTour: getNextTourInOrder,
};

// Alias para compatibilidad
window.startTour = startTour;

// Disparar evento cuando el sistema de tours esté listo
if (typeof window !== 'undefined' && window.dispatchEvent) {
    window.dispatchEvent(new CustomEvent('linkiu-tours-ready', {
        detail: { LinkiuTours: window.LinkiuTours }
    }));
    console.log('✅ Sistema de tours listo y evento disparado');
}

export {
    startTour,
    autoStartTour,
    isTourCompleted,
    isTourAvailable,
    markTourCompleted,
    resetTour,
    resetAllTours,
};

