/**
 * Tour: Crear Reserva de Habitación
 * 
 * Guía al usuario paso a paso para crear su primera reserva de habitación.
 */

export function tourCrearReservaHabitacion() {
    return {
        steps: [
            {
                popover: {
                    title: 'Crear reserva de habitación 🏨',
                    description: 'Las reservas te permiten gestionar las habitaciones de tu hotel. ¡Vamos a crear una!',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="customer-name"]',
                popover: {
                    title: '1. Nombre del huésped',
                    description: 'Ingresa el nombre completo del huésped que realizará la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="customer-phone"]',
                popover: {
                    title: '2. Teléfono/WhatsApp',
                    description: 'Agrega el número de contacto del huésped para confirmar la reserva.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="check-in-date"]',
                popover: {
                    title: '3. Fecha de entrada',
                    description: 'Selecciona la fecha en que el huésped hará check-in.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="check-out-date"]',
                popover: {
                    title: '4. Fecha de salida',
                    description: 'Selecciona la fecha en que el huésped hará check-out.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="guests-number"]',
                popover: {
                    title: '5. Número de huéspedes',
                    description: 'Indica cuántas personas se hospedarán. Esto afecta la disponibilidad y precio.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-selection"]',
                popover: {
                    title: '6. Seleccionar habitación',
                    description: 'Elige la habitación disponible que mejor se adapte a las fechas y número de huéspedes.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Confirma la reserva! ✨',
                    description: 'Haz clic aquí para crear la reserva. El huésped recibirá una confirmación.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

