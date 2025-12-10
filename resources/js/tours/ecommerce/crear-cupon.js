/**
 * Tour: Crear Cupón
 * 
 * Guía para crear cupones de descuento.
 */

export function tourCrearCupon() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Crea tu primer cupón! 🎟️',
                    description: 'Te guiaré para crear tu primer cupón.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="coupon-name"]',
                popover: {
                    title: 'Nombre del cupón🔥',
                    description: 'Nombre descriptivo del cupón. Ejemplos: "Descuento de bienvenida", "Black Friday 2024", "Descuento verano". Máximo 120 caracteres. Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-code"]',
                popover: {
                    title: 'Código del cupón 🔢',
                    description: 'Código que los clientes ingresan para aplicar el cupón. Ejemplos: "BIENVENIDA20", "VERANO2024", "BLACKFRIDAY". Se convierte automáticamente a mayúsculas. Opcional; si no se proporciona, el sistema genera uno automáticamente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-description"]',
                popover: {
                    title: 'Descripción 🫡',
                    description: 'Texto que explica el beneficio del cupón. Opcional. Se muestra a los clientes en la tienda.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-apply-to"]',
                popover: {
                    title: 'Aplicar a 🎯',
                    description: 'Define el alcance del cupón: Global: Se aplica a todos los productos del carrito. Categorías específicas: Solo a productos de categorías seleccionadas. Productos específicos: Solo a productos seleccionados.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-type"]',
                popover: {
                    title: 'Tipo de descuento ➗',
                    description: 'Define cómo se calcula el descuento: Porcentaje: Descuento porcentual (ej: 20% = $20.000 de descuento en compra de $100.000) Valor fijo: Descuento en pesos (ej: $10.000 de descuento).',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-value"]',
                popover: {
                    title: 'Valor del descuento 💰',
                    description: 'Monto del descuento según el tipo: Si es porcentaje: valor entre 0 y 100 (ej: 20 = 20%) Si es valor fijo: monto en pesos (ej: 10000 = $10.000)',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-max-discount"]',
                popover: {
                    title: 'Descuento máximo ⚠️',
                    description: 'Límite máximo del descuento cuando el tipo es porcentaje. Ejemplo: si el descuento es 50% y el máximo es $50.000, en una compra de $200.000 el descuento será $50.000, no $100.000. Solo visible cuando el tipo de descuento es porcentaje. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-min-purchase"]',
                popover: {
                    title: 'Compra mínima 🪙',
                    description: 'Monto mínimo de compra para aplicar el cupón. Ejemplo: si es $30.000, el cupón solo se aplica si el subtotal es igual o mayor. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-applicability-section"]',
                popover: {
                    title: 'Selección de categorías o productos ✅',
                    description: 'Esta sección aparece cuando "Aplicar a" es "Categorías específicas" o "Productos específicos". Si seleccionas "Categorías específicas", aquí podrás seleccionar las categorías donde el cupón será válido. Si seleccionas "Productos específicos", aquí podrás seleccionar los productos donde el cupón será válido. Requerido si el tipo no es "Global".',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-max-uses"]',
                popover: {
                    title: 'Límite total de usos ⚠️',
                    description: 'Número máximo de veces que el cupón puede ser usado en total. Ejemplo: si es 100, después de 100 usos el cupón se desactiva automáticamente. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-uses-per-customer"]',
                popover: {
                    title: 'Usos por cliente ⚠️',
                    description: 'Número máximo de veces que un mismo cliente puede usar el cupón. Ejemplo: si es 1, cada cliente solo puede usarlo una vez. Opcional',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-start-date"]',
                popover: {
                    title: 'Fecha de inicio 🎟️',
                    description: 'Fecha y hora desde la cual el cupón estará disponible. Si no se especifica, estará disponible inmediatamente. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-end-date"]',
                popover: {
                    title: 'Fecha de fin 🎟️',
                    description: 'Fecha y hora hasta la cual el cupón estará disponible. Si no se especifica, no expira. Debe ser posterior a la fecha de inicio. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-time-restrictions"]',
                popover: {
                    title: 'Restricciones horarias ⏱️',
                    description: 'Permite limitar el uso del cupón a días y horarios específicos: Días permitidos: Selecciona los días de la semana (domingo a sábado) Hora de inicio: Hora desde la cual el cupón es válido (ej. 09:00) Hora de fin: Hora hasta la cual el cupón es válido (ej. 18:00) Ejemplo: cupón válido solo los viernes y sábados de 6 PM a 10 PM. Opcional.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-public"]',
                popover: {
                    title: 'Cupón público 🎖️',
                    description: 'Toggle para hacer el cupón visible en la tienda pública. Sí está activado, los clientes pueden verlo en la página de promociones. Si está desactivado, solo se puede usar con el código.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="coupon-automatic"]',
                popover: {
                    title: 'Aplicación automática ✨',
                    description: 'Toggle para que el sistema aplique el cupón automáticamente sin que el cliente ingrese código. Útil para promociones generales. Si está activado, el cupón se aplica automáticamente cuando se cumplen las condiciones.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: 'Crear cupón 🔊',
                    description: 'Botón para guardar y crear el cupón con la configuración establecida. Al hacer clic, se valida la información y se crea el cupón. Si está activado "Activar al guardar", quedará disponible inmediatamente.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-slider"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya sabes cómo crear un cupón, ahora vamos a darle vida a nuestro home público.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}
