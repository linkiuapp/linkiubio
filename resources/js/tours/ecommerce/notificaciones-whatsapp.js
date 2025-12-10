/**
 * Tour: Notificaciones WhatsApp
 * 
 * Guía para configurar las notificaciones automáticas por WhatsApp.
 */

export function tourNotificacionesWhatsapp() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a notificaciones de Whatsapp! 🎉',
                    description: 'Desde aquí podrás poner el número al que quieres que te lleguen las notificaciones de tus pedidos.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="owner-phone-input"]',
                popover: {
                    title: 'Número de WhatsApp 📲',
                    description: 'Configura el número de WhatsApp donde recibirás notificaciones automáticas sobre pedidos, reservas y pagos. Debe ser un número de 10 dígitos (ejemplo: 3001234567). Este número se usa para enviarte alertas cuando hay actividad en tu tienda.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sidebar-store-design"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya sabes configurar el número para las notificaciones de los pedidos que hagan tus clientes.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}
