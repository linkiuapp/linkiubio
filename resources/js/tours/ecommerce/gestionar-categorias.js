/**
 * Tour: Gestionar Categorías
 * 
 * Guía al usuario para gestionar sus categorías.
 */

export function tourGestionarCategorias() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a categorías! 🎊',
                    description: 'Desde aquí puedes gestionar todas tus categorías; ver, crear, editar y eliminar.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="category-button"]',
                popover: {
                    title: 'Ahora creemos una categoría 🤗',
                    description: 'Nuestro siguiente paso es crear una categoría, da clic en el botón crear categoría.',
                    side: 'bottom',
                    align: 'center',
                }
            },
        ],
    };
}

