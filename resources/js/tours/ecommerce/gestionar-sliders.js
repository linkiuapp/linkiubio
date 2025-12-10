/**
 * Tour: Gestionar Sliders
 * 
 * Guía al usuario para gestionar sus sliders.
 */

export function tourGestionarSliders() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a slider! 🎉',
                    description: 'Desde aquí puedes gestionar todas tus slider, ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="slider-button"]',
                popover: {
                    title: 'Ahora creemos un slider 🎬',
                    description: 'Nuestro siguiente paso es crear un slider, da clic en el botón, crear slider.',
                    side: 'bottom',
                    align: 'start',
                }
            },
        ],
    };
}

