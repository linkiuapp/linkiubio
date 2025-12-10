/**
 * Tour: Dashboard Bienvenida
 * 
 * Primer tour que ve el usuario al entrar a su panel.
 * Muestra las secciones principales del dashboard.
 */

export function tourDashboardBienvenida() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Bienvenido a Linkiu! 🎉',
                    description: 'Este es tu dashboard, conoce cada una de las secciones para que empieces a vender con tu Linkiu.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar"]',
                popover: {
                    title: 'Menú lateral 📢',
                    description: 'Encuentra aquí todas las funciones de tu Linkiu y así podrás disfrutarlo al máximo.',
                    side: 'right',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="navbar"]',
                popover: {
                    title: 'Este es tu menú superior 🚨',
                    description: 'Aquí encuentras tu badge de verificado, el estado de tu tienda, un botón para verla, iconos que te indican, los nuevos pedidos, nuevos tickets y nuevos anuncios.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="stats-cards"]',
                popover: {
                    title: 'Sección de estadísticas 📊',
                    description: 'Conoce el total de tus pedidos, los que están pendientes, confirmados, en preparación, enviados y entregados.',
                    side: 'bottom',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="kiubot-section"]',
                popover: {
                    title: 'Conoce a KiuBot 🤖',
                    description: 'Soy KiuBot, tu asistente digital que te ayudará a resolver dudas, a mejorar tus ventas, crear estrategias y campañas para tus redes sociales.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="recent-orders"]',
                popover: {
                    title: 'Sección de pedidos 🛎️',
                    description: 'Encuentra aquí de manera rápida y sencilla los pedidos más recientes que hacen a tu tienda.',
                    side: 'top',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sidebar-categories"]',
                popover: {
                    title: '¡Felicidades! 🥳',
                    description: 'Ya conociste tu dashboard, ahora vamos a saber cómo crear una categoría',
                    side: 'right',
                    align: 'center',
                }
            },
        ],
    };
}