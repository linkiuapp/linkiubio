/**
 * Tour: Crear Producto
 * 
 * Guía completa para crear el primer producto.
 */

export function tourCrearProducto() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Crea tu primer producto! 🥁',
                    description: 'Te guiaré para crear tu primer producto.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="consumo"]',
                popover: {
                    title: 'Tu consumo 👑',
                    description: 'Aquí podrás ver cuántos productos has creado y cuántos te quedan, esto puede variar según tu plan.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="product-name"]',
                popover: {
                    title: 'Nombre de tu producto📝',
                    description: 'Escribe un nombre descriptivo. Ejemplo: "Camiseta Básica" "Hamburguesa doble carne" "Zapatos sport".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-sku"]',
                popover: {
                    title: 'Código sku 🔠',
                    description: 'Ideal para identificar tu producto, si no tienes, tranquilo, se generará automáticamente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-description"]',
                popover: {
                    title: 'Descripción del producto📑',
                    description: 'Describe tu producto con detalle. Incluye materiales, medidas, cuidados, etc. Una buena descripción vende más.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="kiubot-button"]',
                popover: {
                    title: 'Botón de KiuBot 🤖',
                    description: 'Si no tienes creatividad para crear una descripción, escribe una descripción de base y dile a KiuBot que le ponga creatividad.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-price"]',
                popover: {
                    title: 'Precio del producto💲',
                    description: 'Ponle precio a tu producto, sin comas o puntos solo dale un precio.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-type"]',
                popover: {
                    title: 'Tipo de producto 🧦',
                    description: 'Debes escoger adecuadamente el tipo de producto, de esto depende el precio e inventario; Simple: 1 producto = 1 precio = 1 stock, Variable: 1 producto = múltiples variantes = cada variante con su precio y stock.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-type"]',
                popover: {
                    title: 'Tipo de producto simple 🏷️',
                    description: 'Qué es: Producto sin variantes. Un solo precio y un solo stock (si se controla). Ejemplo: Libro, Bebida, Entrada a evento, Producto único sin opciones. Uso: Para productos que no cambian según opciones. El stock y precio son únicos.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-type"]',
                popover: {
                    title: 'Tipo de producto variable 🔖',
                    description: 'Qué es: Producto con variantes según combinaciones de variables. Cada variante puede tener precio y stock propios. Ejemplo: Camiseta (Talla S/M/L + Color Rojo/Azul), Habitación (Tipo + Vista), Combo (Plato + Bebida + Postre). Uso: Para productos con opciones que generan variantes. Permite controlar stock y precio por combinación (ej: Talla M Roja = 10 unidades, $50.000).',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-promotional-price"]',
                popover: {
                    title: 'Precio promocional 🥳',
                    description: 'Establece un precio de oferta menor al precio original. Puedes activarlo con fechas de inicio y fin, o indefinidamente mientras el toggle esté activo; Oferta de temporada: "Black Friday - 30% descuento del 20 al 30 de noviembre"',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-stock"]',
                popover: {
                    title: 'Gestión de Inventario 🧮',
                    description: 'Controla la cantidad disponible de productos para evitar sobreventa. Puede ser ilimitado (siempre disponible) o limitado (cantidad específica). Para productos variables, el stock se gestiona por variante.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-images"]',
                popover: {
                    title: 'Imágenes del producto 📸',
                    description: 'Subes las imágenes que pertenezcan a tu producto, recomendaciones: trata de que sean cuadradas, legibles visualmente y que muestran detalles del producto (Máximo 5 imágenes).',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="product-categories"]',
                popover: {
                    title: 'Categoría del producto 📦',
                    description: 'Aquí podrás seleccionar las categorías a las que pertenece tu producto, puede pertenecer a 1 o más de una categoría si para ti es necesario.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda tu producto! 💾',
                    description: 'Al hacer clic en crear producto, tu producto se guardará exitosamente.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-inventory"]',
                popover: {
                    title: '¡Felicidades! 🎉',
                    description: 'Ya sabes cómo crear un producto, ahora vamos a conocer cómo se manejan tus inventarios.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

