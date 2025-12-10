/**
 * Tour: Gestionar Variables
 * 
 * Guía al usuario para gestionar sus variables de producto.
 */

export function tourGestionarVariables() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a variables! 🎊',
                    description: 'Desde aquí puedes gestionar todas tus variables, ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="variable-button"]',
                popover: {
                    title: 'Ahora crearemos una variable💡',
                    description: 'Nuestro siguiente paso es crear una variable, da clic en el botón crear variable.',
                    side: 'bottom',
                    align: 'center',
                }
            },
        ],
    };
}

