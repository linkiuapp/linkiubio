/**
 * Tour: Diseño de Tienda
 * 
 * Guía para personalizar la apariencia de la tienda.
 */

export function tourDisenoTienda() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a diseño de tienda! 🎉',
                    description: 'Desde aquí puedes personalizar tu tienda para hacerla más atractiva.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="name-store"]',
                popover: {
                    title: 'Nombre de la tienda 🏷️',
                    description: 'Nombre que aparece en el encabezado de la tienda. Admite letras, números, guiones y acentos. Máximo 40 caracteres. Se actualiza en tiempo real en la vista previa.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="description-store"]',
                popover: {
                    title: 'Descripción breve 🗒️',
                    description: 'Texto breve que aparece debajo del nombre en el encabezado. Máximo 50 caracteres. Admite letras, números, guiones, acentos y algunos signos de puntuación. Se actualiza en tiempo real en la vista previa.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="background-color"]',
                popover: {
                    title: 'Color de fondo 🎨',
                    description: 'Color de fondo del encabezado. Formato hexadecimal (#RRGGBB). Ejemplo: #FFFFFF (blanco), #000000 (negro), #FF5733 (naranja). Se actualiza en tiempo real en la vista previa.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="text-color"]',
                popover: {
                    title: 'Color del nombre 🎨',
                    description: 'Color del texto del nombre de la tienda. Formato hexadecimal (#RRGGBB). Ejemplo: #000000 (negro), #FFFFFF (blanco), #333333 (gris oscuro). Se actualiza en tiempo real en la vista previa.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="description-color"]',
                popover: {
                    title: 'Color de la descripción 🎨',
                    description: 'Color del texto de la descripción breve. Formato hexadecimal (#RRGGBB). Ejemplo: #666666 (gris), #999999 (gris claro), #333333 (gris oscuro). Se actualiza en tiempo real en la vista previa.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="preview-header"]',
                popover: {
                    title: 'Vista previa 👀',
                    description: 'Muestra cómo se verá el encabezado de la tienda con los cambios aplicados. Se actualiza en tiempo real al modificar nombre, descripción o colores. Permite verificar el diseño antes de publicar.',
                    side: 'left',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="logo-upload"]',
                popover: {
                    title: 'Logo 🛡️',
                    description: 'Logo de la tienda que aparece en el encabezado. Formatos: PNG, JPG o WebP. Tamaño máximo: 2MB. Se muestra en la vista previa y se guarda automáticamente al subirlo.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="favicon-upload"]',
                popover: {
                    title: 'Favicon 🌐',
                    description: 'Icono que aparece en la pestaña del navegador. Formatos: PNG, ICO o SVG. Tamaño máximo: 1MB. Se actualiza automáticamente al subirlo.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="publish-button"]',
                popover: {
                    title: 'Publicar cambios 🚀',
                    description: 'Botón para publicar los cambios en la tienda. Al hacer clic, se abre un modal de confirmación. Los cambios se aplican inmediatamente y son visibles en la tienda pública.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-coupons"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya personalizamos tu tienda, ahora vamos a atraer clientes creando cupones.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}
