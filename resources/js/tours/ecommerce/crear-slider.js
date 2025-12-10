/**
 * Tour: Crear Slider
 * 
 * Guía para crear sliders promocionales.
 */

export function tourCrearSlider() {
    return {
        steps: [
            {
                
                popover: {
                    title: '¡Crea tu primer slider! 🎉',
                    description: 'Te guiaré para crear tu primer slider.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="slider-name"]',
                popover: {
                    title: 'Nombre 😎',
                    description: 'Nombre descriptivo del slider. Ejemplos: "Promoción Navidad 2024", "Ofertas de Verano", "Black Friday". Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-description"]',
                popover: {
                    title: 'Descripción 💭',
                    description: 'Texto descriptivo del slider. Opcional. Ejemplo: "Descuentos especiales en toda la tienda".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-image"]',
                popover: {
                    title: 'Imagen 🖼️',
                    description: 'Imagen del slider. Debe ser exactamente 420x200px. Formatos: JPG, PNG, WebP. Tamaño máximo: 2 MB. Requerido. Se valida que las dimensiones sean exactas.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-link-type"]',
                popover: {
                    title: 'Tipo de enlace 📎',
                    description: 'Define el tipo de enlace al hacer clic en el slider:\n\nSin enlace: El slider no es clicable.\n\nEnlace interno: Enlace a una categoría o producto de tu tienda (ej: /categoria/ropa, /producto/camiseta).\n\nEnlace externo: Enlace a una URL externa (ej: https://instagram.com/mitienda).',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-url"]',
                popover: {
                    title: 'URL/Enlace 🔗',
                    description: 'Campo para ingresar la URL según el tipo seleccionado:\n\nEnlace interno: Busca categorías y productos escribiendo al menos 3 caracteres. Muestra sugerencias con autocompletado.\n\nEnlace externo: Ingresa una URL completa (debe comenzar con http:// o https://)\n\nSin enlace: Campo deshabilitado.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-schedule-toggle"]',
                popover: {
                    title: 'Programar slider ⏰',
                    description: 'Toggle para activar la programación del slider. Si está activado, puedes configurar cuándo se mostrará. Si está desactivado, el slider se mostrará siempre.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-permanent-toggle"]',
                popover: {
                    title: 'Slider permanente ⚡',
                    description: 'Toggle que aparece cuando "Programar slider" está activado. Si está activado, el slider no tiene fecha de fin y se mostrará desde la fecha de inicio indefinidamente. Si está desactivado, puedes configurar fecha de fin.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-start-date"]',
                popover: {
                    title: 'Fecha inicio 📆',
                    description: 'Fecha desde la cual el slider comenzará a mostrarse. Solo visible cuando "Programar slider" está activado y "Slider permanente" está desactivado. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-end-date"]',
                popover: {
                    title: 'Fecha fin 🗓️',
                    description: 'Fecha hasta la cual el slider se mostrará. Solo visible cuando "Programar slider" está activado y "Slider permanente" está desactivado. Debe ser posterior a la fecha de inicio. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-start-time"]',
                popover: {
                    title: 'Hora inicio ⌚',
                    description: 'Hora del día desde la cual el slider comenzará a mostrarse. Solo visible cuando "Programar slider" está activado. Opcional. Ejemplo: 09:00 a.m.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-end-time"]',
                popover: {
                    title: 'Hora fin ⌚',
                    description: 'Hora del día hasta la cual el slider se mostrará. Solo visible cuando "Programar slider" está activado. Debe ser posterior a la hora de inicio. Opcional. Ejemplo: 18:00.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="slider-days"]',
                popover: {
                    title: 'Días de la semana 📆',
                    description: 'Selecciona los días de la semana en los que el slider se mostrará. Solo visible cuando "Programar slider" está activado. Opcional. Puedes seleccionar múltiples días (L, M, X, J, V, S, D)',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: 'Crear Slider 🥳',
                    description: 'Botón para guardar y crear el slider con la configuración establecida. Al hacer clic, se valida la información y se crea el slider.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: '¡Listo! Completaste todos los pasos. Ahora disfruta al máximo tu Linkiu.\n\nTe deseamos muchos éxitos y que tu negocio siga creciendo sin límites.',
                    side: 'center',
                    align: 'center',
                }
            },
        ],
    };
}
