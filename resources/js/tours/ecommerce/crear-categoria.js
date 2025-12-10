/**
 * Tour: Crear Categoría
 * 
 * Guía al usuario paso a paso para crear su primera categoría.
 */

export function tourCrearCategoria() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Vamos a crear una categoría! 🤝',
                    description: 'Te guiaré para crear tu primera categoría.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="consumo"]',
                popover: {
                    title: 'Tu consumo 🚨',
                    description: 'Aquí podrás ver cuántas categorías has creado y cuántas te quedan disponibles, esto puede variar según tu plan.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="icon-selector"]',
                popover: {
                    title: 'Selecciona un icono 🖼️',
                    description: 'Elige un ícono acorde a tu categoría. Si no encuentras el que necesitas, puedes solicitarlo por WhatsApp y lo tendrás en pocos minutos.',
                    side: 'right',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="category-name"]',
                popover: {
                    title: 'Nombre de tu categoría💭',
                    description: 'Aquí puedes asignar un nombre a tu categoría. Te recomiendo usar nombres cortos para que sea más fácil encontrarla.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slug-input"]',
                popover: {
                    title: 'URL de tu categoría📎',
                    description: 'La URL con la que podrás identificar tu categoría. Ejemplo: linkiu.bio/tu-tienda/tucategoria. Se genera automáticamente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="category-description"]',
                popover: {
                    title: 'Démosle vida a tu categoría 🪄',
                    description: 'Describe tu categoría.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda tu categoría! 💾',
                    description: 'Al hacer clic en crear categoría, tu categoría se guardará exitosamente.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-variables"]',
                popover: {
                    title: '¡Felicidades! 🎉',
                    description: 'Ya sabes cómo crear una categoría, ahora vamos a conocer cómo crear una variable.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

