/**
 * Tour: Gestionar Pedido
 * 
 * Guía para gestionar el primer pedido.
 */

export function tourGestionarPedido() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Felicidades, tu primer pedido! 🎊',
                    description: 'Te mostraremos cómo gestionar pedidos de manera eficiente.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="order-status"]',
                popover: {
                    title: '1. Estado del pedido',
                    description: 'Aquí ves el estado actual. Puedes cambiarlo según avanza el proceso.',
                    side: 'right',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="order-details"]',
                popover: {
                    title: '2. Detalles del pedido',
                    description: 'Revisa los productos, cantidades y el total del pedido.',
                    side: 'left',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="customer-info"]',
                popover: {
                    title: '3. Datos del cliente',
                    description: 'Aquí encuentras el nombre, teléfono y dirección de entrega.',
                    side: 'left',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="payment-proof"]',
                popover: {
                    title: '4. Comprobante de pago',
                    description: 'Si el cliente subió comprobante, puedes verlo y validarlo aquí.',
                    side: 'left',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="change-status-button"]',
                popover: {
                    title: '5. Cambiar estado',
                    description: 'Actualiza el estado: Confirmado → Preparando → Enviado → Entregado.',
                    side: 'top',
                    align: 'center',
                }
            },
        ],
    };
}

