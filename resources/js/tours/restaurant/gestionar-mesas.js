/**
 * Tour: Gestionar Mesas
 * 
 * Guía al usuario sobre cómo gestionar las mesas de su restaurante.
 */

export function tourGestionarMesas() {
    return {
        steps: [
            {
                popover: {
                    title: 'Gestionar mesas 🪑',
                    description: 'Aquí puedes crear y administrar las mesas de tu restaurante para consumo en local.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="add-table-button"]',
                popover: {
                    title: '1. Crear nueva mesa',
                    description: 'Haz clic aquí para agregar una nueva mesa. Cada mesa tendrá su propio código QR.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="table-number"]',
                popover: {
                    title: '2. Número de mesa',
                    description: 'Asigna un número o nombre identificador a la mesa. Ejemplo: "Mesa 1", "Mesa VIP".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="table-capacity"]',
                popover: {
                    title: '3. Capacidad',
                    description: 'Indica cuántas personas caben en esta mesa. Esto ayuda a asignar reservas correctamente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="table-qr"]',
                popover: {
                    title: '4. Código QR',
                    description: 'Cada mesa tiene un código QR único. Los clientes lo escanean para ver el menú y hacer pedidos.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda la mesa! ✨',
                    description: 'Haz clic aquí para crear la mesa. Después podrás imprimir su código QR.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

