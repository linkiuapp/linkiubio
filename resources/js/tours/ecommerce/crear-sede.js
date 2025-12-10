/**
 * Tour: Crear Sede
 * 
 * Guía al usuario paso a paso para crear su primera sede/ubicación.
 */

export function tourCrearSede() {
    return {
        steps: [
            {
                popover: {
                    title: '¡Crea tu primera sede! 🎉',
                    description: 'Te guiaré para crear tu primera sede.',
                    side: 'center',
                    align: 'center',
                }
            },
            {
                element: '[data-tour="sede-name"]',
                popover: {
                    title: 'Nombre de la sede 🏡',
                    description: 'Identifica la sede. Ejemplos: "Sede Centro", "Sede Norte", "Sucursal Principal".',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-manager"]',
                popover: {
                    title: 'Encargado/Responsable 👩‍💻',
                    description: 'Nombre de la persona a cargo de la sede. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-description"]',
                popover: {
                    title: 'Descripción 📄',
                    description: 'Breve descripción de la sede. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-main"]',
                popover: {
                    title: 'Sede principal 🏬',
                    description: 'Marca esta sede como principal. Solo puede haber una por tienda. Se usa como referencia por defecto.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-phone"]',
                popover: {
                    title: 'Teléfono ☎️',
                    description: 'Teléfono de contacto de la sede. Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-whatsapp"]',
                popover: {
                    title: 'WhatsApp 📲',
                    description: 'Número de WhatsApp de la sede. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-department"]',
                popover: {
                    title: 'Departamento 📍',
                    description: 'Departamento donde está ubicada la sede. Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-city"]',
                popover: {
                    title: 'Ciudad 🏙️',
                    description: 'Ciudad donde está ubicada la sede. Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-address"]',
                popover: {
                    title: 'Dirección 📢',
                    description: 'Dirección completa de la sede. Requerido.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-whatsapp-message"]',
                popover: {
                    title: 'Mensaje de WhatsApp 🗨️',
                    description: 'Mensaje predefinido que se envía cuando un cliente hace clic en el botón de WhatsApp de esta sede. Opcional.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-schedules"]',
                popover: {
                    title: 'Horarios de atención 🕓',
                    description: 'Define los horarios de atención por día. Incluye: Presets rápidos: "Lunes a Viernes 9am-6pm", "Todos los días 8am-10pm", "24 horas", etc. Horario principal: apertura y cierre del día. Horario adicional: segundo bloque (ej. mañana y tarde). Marcar día como cerrado. Copiar horario de un día a otro.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sede-social"]',
                popover: {
                    title: 'Redes sociales 📣',
                    description: 'Enlaces a las redes sociales de la sede (Facebook, Instagram, Twitter, etc.). Opcional.',
                    side: 'top',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="save-sede"]',
                popover: {
                    title: 'Guardar sede 💾',
                    description: 'Ya sabes cómo crear una sede, ahora haz clic en el botón de guardar para guardar la sede.',
                    side: 'bottom',
                    align: 'start',
                }
            },
            {
                element: '[data-tour="sidebar-whatsapp-notifications"]',
                popover: {
                    title: '¡Felicidades! 🎊',
                    description: 'Ya sabes cómo crear una sede, ahora vamos a asignar un número para que recibas notificaciones de tus pedidos.',
                    side: 'right',
                    align: 'start',
                }
            },
        ],
    };
}
