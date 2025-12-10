/**
 * Tour: Configurar Envíos
 * 
 * Guía para configurar zonas de envío.
 */

export function tourConfigurarEnvios() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a zonas de envío! 🚚',
                    description: 'Configura las opciones de entrega: recogida en tienda, envío local y envío nacional. Define costos, tiempos de preparación/entrega, envío gratis por monto y zonas con tarifas distintas.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="pickup-section"]',
                popover: {
                    title: 'Recogida en tienda 📦',
                    description: 'Actívala si aplica para ti, permite que los clientes recojan sus pedidos en el punto físico. Configura el tiempo de preparación e instrucciones para el cliente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="local-shipping-section"]',
                popover: {
                    title: 'Envío local 🏍️',
                    description: 'Actívala si aplica para ti, Entregas dentro de la ciudad principal del negocio. Define el costo fijo, tiempo de preparación, envío gratis por monto mínimo e instrucciones.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="national-shipping-section"]',
                popover: {
                    title: 'Envío nacional 🚛',
                    description: 'Actívala si aplica para ti, entregas a nivel nacional mediante zonas. Crea zonas con ciudades, costos y tiempos de entrega. Opción de envío gratis por monto mínimo.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: 'Botón guardar todo 🚧',
                    description: 'Cada vez que hagas un cambio, recuerda guardar todo.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-payments-methods"]',
                popover: {
                    title: '¡Felicidades! 🎉',
                    description: 'Ya conoces cómo se maneja la gestión de envíos.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

