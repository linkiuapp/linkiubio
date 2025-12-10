/**
 * Tour: Crear Método de Pago
 * 
 * Guía para configurar métodos de pago.
 */

export function tourCrearMetodoPago() {
    return {
        steps: [
            {
                popover: {
                    title: 'Configurar métodos de pago 💳',
                    description: 'Define cómo te pagarán tus clientes. Puedes tener varios métodos activos.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="payment-type"]',
                popover: {
                    title: '1. Tipo de pago',
                    description: 'Selecciona el tipo: Transferencia, Nequi, Daviplata, Efectivo, etc.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="payment-name"]',
                popover: {
                    title: '2. Nombre del método',
                    description: 'Dale un nombre descriptivo. Ejemplo: "Transferencia Bancolombia".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="payment-details"]',
                popover: {
                    title: '3. Datos de la cuenta',
                    description: 'Ingresa los datos de tu cuenta: número, nombre del titular, etc.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="payment-instructions"]',
                popover: {
                    title: '4. Instrucciones (opcional)',
                    description: 'Agrega instrucciones para tus clientes. Ejemplo: "Enviar comprobante al WhatsApp".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda el método! ✅',
                    description: 'Tus clientes verán esta opción al momento de pagar.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

