/**
 * Tour: Gestionar Sedes
 * 
 * Guía al usuario para gestionar sus sedes.
 */

export function tourGestionarSedes() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a sedes! 🎉',
                    description: 'Desde aquí puedes gestionar todas tus sedes, ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="location-button"]',
                popover: {
                    title: 'Ahora creemos una sede 📍',
                    description: 'Nuestro siguiente paso es crear una sede, da clic en el botón crear sede.',
                    side: 'bottom',
                    align: 'start',
                }
            },
        ],
    };
}

