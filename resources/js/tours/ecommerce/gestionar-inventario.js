/**
 * Tour: Gestión de Inventario
 * 
 * Guía para entender y gestionar el inventario de productos.
 */

export function tourGestionarInventario() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido al inventario! ⏳',
                    description: 'Aquí puedes ver y controlar el stock de todos tus productos en tiempo real.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="stats-cards"]',
                popover: {
                    title: 'Estadísticas de inventario 📈',
                    description: 'Aquí verás un resumen: total de productos, unidades disponibles, stock bajo y productos agotados.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="stock-bajo"]',
                popover: {
                    title: 'Productos con stock bajo 📉',
                    description: 'Los productos que están por agotarse aparecen aquí. Te recomendamos reponerlos pronto.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="productos-agotados"]',
                popover: {
                    title: 'Productos agotados 🚫',
                    description: 'Productos sin stock. Actualiza el inventario desde la edición de cada producto.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="movimientos-recientes"]',
                popover: {
                    title: 'Movimientos recientes 🚦',
                    description: 'Aquí podrás ir viendo el listado de movimientos recientes de tus productos.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="ver-productos"]',
                popover: {
                    title: 'Gestionar productos ✍️',
                    description: 'Haz clic aquí para ir a la lista de productos y editar el stock de cada uno.',
                    side: 'left',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-simple-shipping"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya conoces cómo se manejan los movimientos de tu inventario, ahora vamos a conocer cómo se manejan los envíos.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

