/**
 * Tour: Gestionar Habitaciones
 * 
 * Guía al usuario sobre cómo gestionar las habitaciones de su hotel.
 */

export function tourGestionarHabitaciones() {
    return {
        steps: [
            {
                popover: {
                    title: 'Gestionar habitaciones 🛏️',
                    description: 'Aquí puedes crear y administrar las habitaciones individuales de tu hotel.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="add-room-button"]',
                popover: {
                    title: '1. Crear nueva habitación',
                    description: 'Haz clic aquí para agregar una nueva habitación. Primero debes tener tipos de habitación creados.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-number"]',
                popover: {
                    title: '2. Número de habitación',
                    description: 'Asigna un número o identificador único. Ejemplo: "101", "Suite A", "Habitación 205".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-type"]',
                popover: {
                    title: '3. Tipo de habitación',
                    description: 'Selecciona el tipo de habitación que creaste anteriormente. Esto define precio y características.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="room-status"]',
                popover: {
                    title: '4. Estado de la habitación',
                    description: 'Marca si la habitación está disponible, en mantenimiento o fuera de servicio.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda la habitación! ✨',
                    description: 'Haz clic aquí para crear la habitación. Después aparecerá disponible para reservas.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

