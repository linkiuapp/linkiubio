/**
 * Tour: Crear Tipo de Habitación
 * 
 * Guía al usuario paso a paso para crear su primer tipo de habitación.
 */

export function tourCrearTipoHabitacion() {
    return {
        steps: [
            {
                popover: {
                    title: 'Crear tipo de habitación 🏨',
                    description: 'Los tipos de habitación definen las características y precios de tus habitaciones. ¡Vamos a crear uno!',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="room-type-name"]',
                popover: {
                    title: '1. Nombre del tipo',
                    description: 'Escribe un nombre descriptivo. Ejemplos: "Suite Presidencial", "Habitación Estándar", "Habitación Deluxe".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-capacity"]',
                popover: {
                    title: '2. Capacidad',
                    description: 'Define cuántas personas caben en este tipo de habitación. Esto afectará la disponibilidad.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-price"]',
                popover: {
                    title: '3. Precio por noche',
                    description: 'Establece el precio base por noche. También puedes configurar precios por persona adicional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-images"]',
                popover: {
                    title: '4. Imágenes',
                    description: 'Agrega fotos atractivas de este tipo de habitación. Los clientes las verán al reservar.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda el tipo de habitación! ✨',
                    description: 'Haz clic aquí para crear el tipo. Después podrás crear habitaciones individuales de este tipo.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

