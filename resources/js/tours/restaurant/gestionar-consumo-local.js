/**
 * Tour: Gestionar Consumo en Local
 * 
 * Guía al usuario sobre cómo gestionar el consumo en local de su restaurante.
 */

export function tourGestionarConsumoLocal() {
    return {
        steps: [
            {
                popover: {
                    title: 'Consumo en local 🍽️',
                    description: 'Aquí puedes gestionar los pedidos que los clientes hacen directamente en tu restaurante.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="live-view"]',
                popover: {
                    title: '1. Vista en vivo',
                    description: 'Ve todos los pedidos activos en tiempo real. Podrás ver qué mesas tienen pedidos pendientes.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="tables-list"]',
                popover: {
                    title: '2. Lista de mesas',
                    description: 'Aquí verás todas tus mesas. Las mesas con pedidos activos aparecerán destacadas.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="table-status"]',
                popover: {
                    title: '3. Estado de las mesas',
                    description: 'Cada mesa muestra su estado: Disponible, Ocupada, o con Pedido Pendiente.',
                    side: 'left',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="settings-button"]',
                popover: {
                    title: '4. Configuración',
                    description: 'Configura horarios, tiempos de preparación y otras opciones para el consumo en local.',
                    side: 'left',
                    align: 'start',
                }
            },
        ],
    };
}

