/**
 * Tour: Gestionar Productos
 * 
 * Guía al usuario para gestionar sus productos.
 */

export function tourGestionarProductos() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a productos! 🤗',
                    description: 'Desde aquí puedes gestionar todos tus productos, ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="product-button"]',
                popover: {
                    title: 'Ahora creemos un producto 🛍️',
                    description: 'Nuestro siguiente paso es crear un producto, da clic en el botón crear producto.',
                    side: 'bottom',
                    align: 'center',
                }
            },
        ],
    };
}

