/**
 * Tour: Crear Variable
 * 
 * Guía al usuario paso a paso para crear su primera variable de producto.
 */

export function tourCrearVariable() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Crea tu primera variable! 🎉',
                    description: 'Te guiaré para crear tu primera variable',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="consumo"]',
                popover: {
                    title: 'Tu consumo 🚨',
                    description: 'Aquí podrás ver cuántas variables has creado y cuántas te quedan. La disponibilidad puede variar según tu plan.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="variable-name"]',
                popover: {
                    title: 'Nombre de tu variable 🖋️',
                    description: 'Escribe un nombre claro. Ejemplos: "Talla", "Color", "Material", "Tamaño", "Porción".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="variable-type"]',
                popover: {
                    title: 'Tipo de variable 📌',
                    description: 'Selecciona cómo los clientes elegirán esta opción, te explicaré una a una.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="variable-type"]',
                popover: {
                    title: 'Selección única ☝️',
                    description: 'Qué es: El cliente elige una opción de una lista. Ejemplo: Talla (S, M, L, XL), Color (Rojo, Azul, Verde), Tamaño (Pequeño, Mediano, Grande). Uso: Permite crear variantes con stock y precio por combinación.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="variable-type"]',
                popover: {
                    title: 'Selección múltiple✌️',
                    description: 'Qué es: El cliente puede elegir varias opciones a la vez. Ejemplo: Extras (Queso extra, Papas, Bebida), Accesorios (Funda, Cable, Estuche), Servicios adicionales (Instalación, Garantía extendida). Uso: Solo para opciones simples donde el stock no depende de combinaciones.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="variable-type"]',
                popover: {
                    title: 'Texto libre💬',
                    description: 'Qué es: El cliente escribe texto personalizado. Ejemplo: Mensaje personalizado, Nombre a grabar, Instrucciones especiales, Dirección de entrega personalizada. Uso: Para personalización o información adicional del pedido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="variable-type"]',
                popover: {
                    title: 'Numérico #️⃣',
                    description: 'Qué es: El cliente ingresa un número dentro de un rango. Ejemplo: Cantidad de personas, Metros cuadrados, Peso en kg, Cantidad de días. Uso: Para valores numéricos con límites mínimos y máximos',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda tu tu variable! ✔️',
                    description: 'Al hacer clic en crear variable, se guardará tu variable exitosamente.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-products"]',
                popover: {
                    title: '¡Felicidades! 🎉',
                    description: 'Ya sabes cómo crear una variable, ahora vamos a conocer cómo crear un producto.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

