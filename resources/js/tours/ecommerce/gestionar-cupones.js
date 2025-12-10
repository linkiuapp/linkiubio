/**
 * Tour: Gestionar Cupones
 * 
 * Guía al usuario para gestionar sus cupones.
 */

export function tourGestionarCupones() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a cupones! 🎊',
                    description: 'Desde aquí puedes gestionar todos tus cupones, ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="coupon-button"]',
                popover: {
                    title: 'Ahora creemos un cupón 🤩',
                    description: 'Nuestro siguiente paso es crear un cupón, da clic en el botón crear cupón.',
                    side: 'bottom',
                    align: 'start',
                }
            },
        ],
    };
}

