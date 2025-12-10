/**
 * Tour: Gestionar Métodos de Pago
 * 
 * Guía al usuario para gestionar sus métodos de pago.
 */

export function tourGestionarMetodosPago() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a métodos de pago! 💵',
                    description: 'Configura los métodos adecuado segun tu negocio lo necesite.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="bank-transfer-section"]',
                popover: {
                    title: 'Transferencia Bancaria 📲',
                    description: 'Permite recibir pagos mediante transferencias a cuentas bancarias. Los clientes realizan la transferencia y pueden subir el comprobante. Puede estar disponible para recogida en tienda y entrega a domicilio.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="cash-section"]',
                popover: {
                    title: 'Efectivo 💸',
                    description: 'Permite pagos en efectivo al momento de la recogida o entrega. Puede configurarse para aceptar cambio y está disponible para recogida en tienda y entrega a domicilio.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="cash-on-delivery-section"]',
                popover: {
                    title: 'Contraentrega 🚚📦',
                    description: 'Permite que el cliente pague cuando recibe el producto en su domicilio. Solo disponible para entrega a domicilio, no para recogida en tienda.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="card-terminal-section"]',
                popover: {
                    title: 'Datáfono 💳',
                    description: 'Permite pagos con tarjeta de crédito o débito usando un datáfono físico. Generalmente solo disponible para recogida en tienda, ya que requiere el dispositivo en el punto de venta.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="bank-accounts-button"]',
                popover: {
                    title: 'Crear cuentas Bancarias 🏢',
                    description: 'Permite agregar cuentas bancarias a un método de pago de transferencia bancaria. Cada cuenta incluye banco, tipo de cuenta (ahorros, corriente, Nequi, Daviplata, Bre-b), número de cuenta, titular y documento. Puedes tener múltiples cuentas activas según tu plan.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sidebar-locations"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya conoces cómo se manejan los métodos de pago.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}

