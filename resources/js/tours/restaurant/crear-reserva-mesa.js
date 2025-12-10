/**
 * Tour: Crear Reserva de Mesa
 * 
 * Guía al usuario paso a paso para crear su primera reserva de mesa.
 */

export function tourCrearReservaMesa() {
    return {
        steps: [
            {
                popover: {
                    title: 'Crear reserva de mesa 🍽️',
                    description: 'Las reservas te permiten gestionar las mesas de tu restaurante. ¡Vamos a crear una!',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="customer-name"]',
                popover: {
                    title: '1. Nombre del cliente',
                    description: 'Ingresa el nombre completo del cliente que realizará la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="customer-phone"]',
                popover: {
                    title: '2. Teléfono/WhatsApp',
                    description: 'Agrega el número de contacto del cliente para confirmar la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="party-size"]',
                popover: {
                    title: '3. Número de personas',
                    description: 'Indica cuántas personas asistirán. Esto te ayudará a asignar la mesa adecuada.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="reservation-date"]',
                popover: {
                    title: '4. Fecha de la reserva',
                    description: 'Selecciona la fecha en que el cliente desea hacer la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="reservation-time"]',
                popover: {
                    title: '5. Hora de la reserva',
                    description: 'Selecciona la hora en que el cliente desea hacer la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="table-selection"]',
                popover: {
                    title: '6. Seleccionar mesa',
                    description: 'Elige la mesa disponible que mejor se adapte al número de personas.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Confirma la reserva! ✨',
                    description: 'Haz clic aquí para crear la reserva. El cliente recibirá una confirmación.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

