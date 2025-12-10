/**
 * Tour: Crear Cuenta Bancaria
 * 
 * Guía al usuario paso a paso para agregar una cuenta bancaria a un método de pago.
 */

export function tourCrearCuentaBancaria() {
    return {
        steps: [
            {
                popover: {
                    title: 'Agregar cuenta bancaria 💳',
                    description: 'Agrega los datos de tu cuenta bancaria para recibir transferencias de tus clientes.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="bank-name"]',
                popover: {
                    title: '1. Nombre del banco',
                    description: 'Escribe el nombre de tu banco. Ejemplos: "Bancolombia", "Davivienda", "Banco de Bogotá".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="account-type"]',
                popover: {
                    title: '2. Tipo de cuenta',
                    description: 'Selecciona el tipo de cuenta: Ahorros o Corriente.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="account-number"]',
                popover: {
                    title: '3. Número de cuenta',
                    description: 'Ingresa el número de cuenta completo. Solo números, letras y @ (10-20 caracteres).',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="account-holder"]',
                popover: {
                    title: '4. Titular de la cuenta',
                    description: 'Escribe el nombre completo del titular de la cuenta tal como aparece en el banco.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-button"]',
                popover: {
                    title: '¡Guarda la cuenta! ✨',
                    description: 'Haz clic aquí para agregar la cuenta bancaria. Los clientes verán estos datos al pagar.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

