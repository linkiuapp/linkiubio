/**
 * Sistema de Notificaciones en Tiempo Real
 * Maneja notificaciones de pedidos, tickets, anuncios y solicitudes de tiendas
 * 
 * NOTA: Notificaciones de pedidos usan Ably en modo Pusher-compatible (mayor confiabilidad)
 *       Otras notificaciones usan Pusher (migración gradual)
 */

console.log('🔔 notifications.js: Initializing...');

// Variables globales para Ably (solo para pedidos, modo compatible)
let ablyPusher = null;
let ablyEcho = null;

// Auto-inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNotifications);
} else {
    initNotifications();
}

function initNotifications() {
    console.log('🔔 notifications.js: DOM ready, checking for context...');

    // Inicializar Ably Echo para notificaciones de pedidos (si está configurado)
    initializeAblyEcho();

    // Esperar a que Echo esté disponible (funciona con Pusher o Ably)
    if (typeof window.Echo === 'undefined') {
        console.warn('⚠️ Echo not available yet, waiting...');
        setTimeout(initNotifications, 500);
        return;
    }

    console.log('✅ Echo available, setting up notifications...');

    // Pedir permisos para notificaciones de escritorio
    requestNotificationPermission();

    // Detectar contexto y configurar listeners
    const body = document.body;
    
    // SUPER ADMIN: Escuchar solicitudes de tiendas
    if (body.classList.contains('super-admin')) {
        console.log('🔔 SuperAdmin detected, subscribing to store requests...');
        setupStoreRequestsListener();
    }

    // TENANT ADMIN: Escuchar nuevos pedidos
    const storeId = body.dataset.storeId;
    if (storeId) {
        console.log(`🔔 TenantAdmin detected (Store ID: ${storeId}), subscribing to orders...`);
        setupNewOrderListener(storeId);
        setupTicketResponseListener(storeId);
        setupErrorReportResolvedListener(storeId);
    }

    // CLIENTE: Escuchar cambios de estado de pedido
    const orderId = body.dataset.orderId;
    if (orderId) {
        console.log(`🔔 Client detected (Order ID: ${orderId}), subscribing to order status...`);
        setupOrderStatusListener(orderId);
    }

    // TODOS: Escuchar anuncios de la plataforma
    setupAnnouncementsListener();
    
    // TODOS: Escuchar nuevas release notes
    setupReleaseNotesListener();
}

/**
 * 🚀 Inicializar Ably en modo Pusher-compatible para notificaciones de pedidos
 * Esto permite usar pusher-js normal pero conectado a Ably (mayor confiabilidad)
 * 
 * NOTA: Requiere que VITE_ABLY_KEY esté configurado en .env y que el Pusher Protocol
 *       Adapter esté habilitado en el dashboard de Ably
 */
function initializeAblyEcho() {
    try {
        // Verificar si Ably está configurado (variable de entorno de Vite)
        // Vite expone las variables con prefijo VITE_
        const ablyKey = window.VITE_ABLY_KEY || 
                       (typeof import.meta !== 'undefined' && import.meta.env?.VITE_ABLY_KEY) ||
                       null;
        
        if (!ablyKey) {
            console.log('ℹ️ Ably no configurado (VITE_ABLY_KEY no encontrado), usando Pusher para pedidos también');
            return;
        }

        // Extraer la parte pública de la clave (antes del ':')
        const ablyPublicKey = ablyKey.split(':')[0];

        // Verificar que Pusher esté disponible
        if (typeof window.Pusher === 'undefined') {
            console.warn('⚠️ Pusher no disponible, no se puede inicializar Ably en modo compatible');
            return;
        }

        // Crear instancia de Pusher apuntando a Ably (modo compatible)
        // Ably actúa como servidor Pusher cuando el Protocol Adapter está habilitado
        ablyPusher = new window.Pusher(ablyPublicKey, {
            wsHost: 'realtime-pusher.ably.io',
            wsPort: 443,
            wssPort: 443,
            forceTLS: true,
            enabledTransports: ['ws', 'wss'],
            disableStats: true,
            cluster: 'us-east-1-a', // Cluster por defecto de Ably (no crítico en modo compatible)
        });

        // Escuchar eventos de conexión
        ablyPusher.connection.bind('connected', () => {
            console.log('✅ Conectado a Ably (modo Pusher-compatible) para notificaciones de pedidos');
        });

        ablyPusher.connection.bind('error', (err) => {
            // Solo mostrar error si es crítico, de lo contrario solo loguear
            if (err.type === 'PusherError' && err.data) {
                console.warn('⚠️ Error de conexión con Ably (modo Pusher-compatible):', err.data);
                console.log('💡 Verifica que el Pusher Protocol Adapter esté habilitado en el dashboard de Ably');
            } else {
                console.error('❌ Error de conexión con Ably:', err);
            }
        });

        ablyPusher.connection.bind('disconnected', () => {
            console.warn('⚠️ Desconectado de Ably, intentando reconectar...');
        });

        // Crear objeto Echo-like para Ably
        ablyEcho = {
            channel: function(channelName) {
                const channel = ablyPusher.subscribe(channelName);
                return {
                    listen: function(eventName, callback) {
                        const cleanEventName = eventName.startsWith('.') ? eventName.substring(1) : eventName;
                        channel.bind(cleanEventName, callback);
                        return this;
                    }
                };
            }
        };

        console.log('✅ Ably inicializado en modo Pusher-compatible para notificaciones de pedidos');
    } catch (error) {
        console.error('❌ Error inicializando Ably:', error);
        console.log('⚠️ Usando Pusher como fallback para pedidos');
    }
}

/**
 * 🆕 LISTENER: Solicitudes de tiendas (SuperAdmin)
 */
function setupStoreRequestsListener() {
    try {
        window.Echo.channel('platform.store.requests')
            .listen('store.request.created', (data) => {
                console.log('🆕 Nueva solicitud de tienda recibida:', data);

                // Desktop notification
                showDesktopNotification(
                    '🏪 Nueva Solicitud de Tienda',
                    `${data.store_name} (${data.business_type}) solicita aprobación`
                );

                // Toast in-app
                showToast(
                    '🏪 Nueva Solicitud de Tienda',
                    `<strong>${data.store_name}</strong> (${data.business_type})<br>` +
                    `Documento: ${data.document_type} ${data.document_number}<br>` +
                    `Admin: ${data.admin_name} (${data.admin_email})<br>` +
                    `<a href="${data.review_url}" class="text-primary-200 underline">Ver solicitud →</a>`,
                    'info',
                    10000 // 10 segundos
                );

                // Sonido
                playNotificationSound();

                // Actualizar badge (si existe)
                updatePendingBadge();
            });

        console.log('✅ Store requests listener configured');
    } catch (error) {
        console.error('❌ Error setting up store requests listener:', error);
    }
}

/**
 * 📦 LISTENER: Nuevos pedidos (Tenant Admin)
 * Usa Ably para mayor confiabilidad (no perder notificaciones de pedidos)
 */
function setupNewOrderListener(storeId) {
    try {
        // Prioridad 1: Usar Ably si está disponible (mayor confiabilidad)
        if (ablyEcho) {
            console.log('📦 Configurando listener de pedidos con Ably (alta confiabilidad)...');
            ablyEcho.channel(`store.${storeId}.orders`)
                .listen('new.order', (data) => {
                    console.log('📦 Nuevo pedido recibido via Ably:', data);
                    handleNewOrderNotification(data);
                });
            console.log('✅ New order listener configured with Ably for store:', storeId);
            return;
        }

        // Prioridad 2: Fallback a Pusher si Ably no está disponible
        if (typeof window.Echo !== 'undefined') {
            console.log('📦 Configurando listener de pedidos con Pusher (fallback)...');
            window.Echo.channel(`store.${storeId}.orders`)
                .listen('new.order', (data) => {
                    console.log('📦 Nuevo pedido recibido via Pusher:', data);
                    handleNewOrderNotification(data);
                });
            console.log('✅ New order listener configured with Pusher for store:', storeId);
        } else {
            console.warn('⚠️ No hay conexión disponible (ni Ably ni Pusher) para pedidos');
        }
    } catch (error) {
        console.error('❌ Error setting up new order listener:', error);
    }
}

/**
 * 🎯 Manejar notificación de nuevo pedido (común para Ably y Pusher)
 * NOTA: La notificación de escritorio se maneja en orders/index.blade.php (showNewOrderNotification)
 *       para mantener la funcionalidad existente con imagen y onclick handler
 */
function handleNewOrderNotification(data) {
    // Agregar notificación al dropdown
    addNotificationToDropdown({
        type: 'order',
        title: '📦 Nuevo Pedido',
        message: `<strong>Pedido #${data.order_number}</strong><br>Cliente: ${data.customer_name}<br>Total: ${data.formatted_total || '$' + data.total}`,
        url: data.url || data.order_url || '#',
        icon: 'party-popper',
        color: 'red'
    });

    // Sonido
    playNotificationSound();
}

/**
 * 🔔 Agregar notificación al dropdown unificado
 */
function addNotificationToDropdown(notification) {
    console.log('🔔 Agregando notificación al dropdown:', notification);
    
    // Buscar el componente de notificaciones de Alpine.js por ID
    const notificationComponent = document.getElementById('notifications-dropdown-component');
    
    // Si encontramos el componente, agregar directamente
    if (notificationComponent && notificationComponent.__x && notificationComponent.__x.$data) {
        const alpineData = notificationComponent.__x.$data;
        if (typeof alpineData.addNotification === 'function') {
            try {
                alpineData.addNotification(notification);
                console.log('✅ Notificación agregada directamente a Alpine.js');
                return;
            } catch (error) {
                console.warn('⚠️ Error agregando directamente a Alpine:', error);
            }
        } else {
            console.warn('⚠️ addNotification no encontrado en Alpine data. Métodos disponibles:', Object.keys(alpineData));
        }
    } else {
        console.warn('⚠️ Componente de notificaciones no encontrado o Alpine no inicializado');
        // Esperar un poco y reintentar
        setTimeout(() => {
            const retryComponent = document.getElementById('notifications-dropdown-component');
            if (retryComponent && retryComponent.__x && retryComponent.__x.$data) {
                const alpineData = retryComponent.__x.$data;
                if (typeof alpineData.addNotification === 'function') {
                    alpineData.addNotification(notification);
                    console.log('✅ Notificación agregada en reintento');
                    return;
                }
            }
        }, 500);
    }
    
    // Fallback: Disparar evento personalizado
    try {
        const event = new CustomEvent('new-notification', {
            detail: notification,
            bubbles: true,
            cancelable: true
        });
        window.dispatchEvent(event);
        console.log('✅ Evento new-notification disparado (fallback)');
    } catch (error) {
        console.error('❌ Error disparando evento:', error);
    }
}


/**
 * 🔄 LISTENER: Cambio de estado de pedido (Cliente)
 */
function setupOrderStatusListener(orderId) {
    try {
        window.Echo.channel(`order.${orderId}`)
            .listen('status.changed', (data) => {
                console.log('🔄 Estado de pedido actualizado:', data);

                // Actualizar UI si estamos en la página de gracias
                const statusElement = document.getElementById('order-status');
                if (statusElement) {
                    statusElement.textContent = data.status_text;
                    statusElement.className = `px-3 py-1 rounded-full text-sm font-medium ${data.status_class}`;
                }

                // Toast in-app
                showToast(
                    '🔄 Pedido Actualizado',
                    data.message,
                    'info',
                    5000
                );

                // Desktop notification (si la página no está en foco)
                if (document.hidden) {
                    showDesktopNotification(
                        '🔄 Pedido Actualizado',
                        data.message
                    );
                }

                // Sonido suave
                playNotificationSound(0.3);
            });

        console.log('✅ Order status listener configured for order:', orderId);
    } catch (error) {
        console.error('❌ Error setting up order status listener:', error);
    }
}

/**
 * 💬 LISTENER: Respuestas de tickets
 */
function setupTicketResponseListener(storeId) {
    try {
        // Tenant Admin escucha respuestas del SuperAdmin
        window.Echo.channel(`store.${storeId}.tickets`)
            .listen('ticket.response', (data) => {
                console.log('💬 Nueva respuesta de ticket:', data);

                // Desktop notification
                showDesktopNotification(
                    '💬 Nueva Respuesta',
                    `Ticket #${data.ticket_number}: ${data.message}`
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'ticket',
                    title: '💬 Nueva Respuesta en Ticket',
                    message: `<strong>Ticket #${data.ticket_number}</strong><br>${data.message}`,
                    url: data.ticket_url || '#',
                    icon: 'message-square-more',
                    color: 'blue'
                });

                playNotificationSound();
            });

        console.log('✅ Ticket response listener configured for store:', storeId);
    } catch (error) {
        console.error('❌ Error setting up ticket response listener:', error);
    }
}

/**
 * 📢 LISTENER: Anuncios de la plataforma
 */
function setupAnnouncementsListener() {
    try {
        window.Echo.channel('platform.announcements')
            .listen('new.announcement', (data) => {
                console.log('📢 Nuevo anuncio recibido via Pusher:', data);

                // Desktop notification
                showDesktopNotification(
                    '📢 ' + data.title,
                    data.message
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'announcement',
                    title: '📢 ' + data.title,
                    message: data.message,
                    url: data.show_url || '#',
                    icon: 'megaphone',
                    color: 'yellow'
                });

                playNotificationSound();

                // 🚨 NUEVO: Si es popup crítico, disparar modal
                if (data.show_popup && data.type === 'critical') {
                    console.log('🚨 Anuncio crítico con popup - Disparando modal...');
                    
                    // Dispatch custom event para Alpine.js
                    window.dispatchEvent(new CustomEvent('show-announcement-popup', {
                        detail: {
                            id: data.id,
                            title: data.title,
                            content: data.message,
                            type: data.type,
                            type_icon: data.type_icon,
                            type_color: 'error', // critical = error color
                            priority: data.priority,
                            published_at: data.created_at,
                            banner_image_url: null, // Pusher no envía imagen
                            banner_link: null,
                            show_url: window.location.origin + '/admin/' + window.store.slug + '/announcements/' + data.id
                        }
                    }));
                }
            });

        console.log('✅ Announcements listener configured (with popup support)');
    } catch (error) {
        console.error('❌ Error setting up announcements listener:', error);
    }
}

/**
 * 🚀 Escuchar nuevas release notes (actualizaciones)
 */
/**
 * 🐛 Escuchar resolución de reportes de errores (Tenant Admin)
 * Usa canal público como release notes para evitar problemas de autenticación
 */
function setupErrorReportResolvedListener(storeId) {
    try {
        if (!window.Echo) {
            console.warn('⚠️ Echo no disponible para listener de reportes de errores');
            return;
        }

        window.Echo.channel(`store.${storeId}.notifications`)
            .listen('error.report.resolved', (data) => {
                console.log('✅ Reporte de error resuelto:', data);

                // Desktop notification
                showDesktopNotification(
                    '✅ Error Resuelto',
                    data.message
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'error-report-resolved',
                    title: '✅ Error Resuelto',
                    message: data.message,
                    url: data.url || '#',
                    icon: 'check-circle',
                    color: 'green'
                });

                playNotificationSound();
            })
            .listen('icon.request.approved', (data) => {
                console.log('✨ Solicitud de ícono aprobada:', data);

                // Desktop notification
                showDesktopNotification(
                    '✨ Ícono Aprobado',
                    data.message
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'icon-request-approved',
                    title: '✨ Ícono Aprobado',
                    message: data.message,
                    url: data.url || '#',
                    icon: 'sparkles',
                    color: 'purple'
                });

                playNotificationSound();
            })
            .listen('store.verification.changed', (data) => {
                console.log('🏪 Estado de verificación cambió:', data);

                // Desktop notification
                showDesktopNotification(
                    data.title,
                    data.verified 
                        ? '¡Tu tienda ahora está verificada! 🎉' 
                        : 'Estado de verificación actualizado'
                );

                // Agregar notificación al dropdown con mensaje mejorado
                addNotificationToDropdown({
                    type: 'store_verification_changed',
                    title: data.verified ? '✨ ¡Tienda Verificada!' : '📋 Verificación Removida',
                    message: data.verified 
                        ? '¡Genial! Ahora tienes el badge oficial de Linkiu. Tu tienda destacará más en la plataforma 🚀'
                        : 'Tu badge de verificación ha sido removido. Contacta con soporte si tienes dudas.',
                    url: data.url || '#',
                    icon: data.verified ? 'badge-check' : 'shield-alert',
                    color: data.verified ? 'green' : 'orange'
                });

                // Actualizar badge de verificación en tiempo real
                updateVerificationBadge(data.verified);

                // Mostrar modal de felicitaciones/información
                showVerificationModal(data);

                playNotificationSound();
            });

        console.log(`✅ Listeners configurados para store.${storeId}.notifications`);
    } catch (error) {
        console.error('❌ Error al configurar listeners:', error);
    }
}

function setupReleaseNotesListener() {
    try {
        window.Echo.channel('platform.release-notes')
            .listen('new.release-note', (data) => {
                console.log('🚀 Nueva release note recibida via Ably:', data);

                // Desktop notification
                showDesktopNotification(
                    '🚀 ' + data.title,
                    data.message
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'release-note',
                    title: data.title,
                    message: data.message,
                    url: data.url || '#',
                    icon: 'rocket',
                    color: 'blue'
                });

                playNotificationSound();
            })
            .listen('new.release-note-item', (data) => {
                console.log('🔧 Nueva actualización de item recibida via Ably:', data);

                // Desktop notification
                showDesktopNotification(
                    data.type_icon + ' ' + data.title,
                    data.message
                );

                // Agregar notificación al dropdown
                addNotificationToDropdown({
                    type: 'release-note-item',
                    title: (data.type_icon || '🚀') + ' ' + data.title,
                    message: data.message,
                    url: data.url || '#',
                    icon: data.item_type === 'fix' ? 'wrench' : data.item_type === 'new' ? 'sparkles' : 'zap',
                    color: data.item_type === 'fix' ? 'green' : data.item_type === 'new' ? 'purple' : 'blue'
                });

                playNotificationSound();
            });

        console.log('✅ Release notes listener configured (with item support)');
    } catch (error) {
        console.error('❌ Error setting up release notes listener:', error);
    }
}

/**
 * 🔔 Pedir permiso para notificaciones de escritorio
 */
function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then(permission => {
            console.log('🔔 Notification permission:', permission);
        });
    }
}

/**
 * 🖥️ Mostrar notificación de escritorio
 */
function showDesktopNotification(title, body) {
    if ('Notification' in window && Notification.permission === 'granted') {
        try {
            new Notification(title, {
                body: body,
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                tag: 'linkiu-notification',
                requireInteraction: false
            });
        } catch (error) {
            console.error('❌ Error showing desktop notification:', error);
        }
    }
}

/**
 * 🎨 Mostrar toast in-app
 */
function showToast(title, message, type = 'info', duration = 5000) {
    const toastContainer = getOrCreateToastContainer();

    const toast = document.createElement('div');
    toast.className = `toast-notification ${type} animate-slide-in`;
    
    const colors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        error: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    toast.innerHTML = `
        <div class="flex items-start gap-3 p-4 rounded-lg border-2 ${colors[type]} shadow-lg max-w-md">
            <div class="flex-1">
                <h4 class="font-bold text-sm mb-1">${title}</h4>
                <div class="text-xs">${message}</div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
    `;

    toastContainer.appendChild(toast);

    // Auto-remover después del tiempo especificado
    setTimeout(() => {
        toast.classList.add('animate-slide-out');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

/**
 * 📦 Obtener o crear contenedor de toasts
 */
function getOrCreateToastContainer() {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2';
        document.body.appendChild(container);
    }
    return container;
}

/**
 * 🔊 Reproducir sonido de notificación
 */
function playNotificationSound(volume = 0.5) {
    try {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUKXi8LZjHAU2kNXzzn0xBSF1xe/glUELElyx6OyrWBUIQ5zd8sFuJAUuhM/z24k2Bhxqve/mnE4MDU+k4vC2ZBwENY/U8M5/MwUgcsPu4JhEDBFaquLwq1gVB0Kb3PLBbyQFLoTP89yJNgYca77v5Z1ODAxOpd/vtmQcBDWP0/DPgDQFIG/D7t+aRQ0QV6nj8axaFwZAmNryvnAmBSuCzvLaiTQHHWi87+SfTw0LTafg77ViFAU1jtTwz4I0Bh9uxe7fmUYOEFWo4/KsWhgGP5bZ8r52KAUrgs/y24o1Bh1nu+7koE8OCkun4O+2YhQEM47U8dCBMwYeb8Xu35tGDhBTqOL');
        audio.volume = volume;
        audio.play().catch(e => console.log('Could not play notification sound:', e));
    } catch (error) {
        console.log('Notification sound not available');
    }
}

/**
 * 🔢 Actualizar badge de solicitudes pendientes
 */
function updatePendingBadge() {
    const badge = document.getElementById('pending-requests-badge');
    if (badge) {
        const currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
        badge.classList.remove('hidden');
    }
}

/**
 * ✅ Actualizar badge de verificación en tiempo real
 */
function updateVerificationBadge(verified) {
    console.log('🔄 Actualizando badge de verificación:', verified);
    
    const badge = document.getElementById('verification-badge');
    if (!badge) {
        console.warn('⚠️ Badge de verificación no encontrado');
        return;
    }
    
    // Actualizar Alpine.js si está disponible
    const container = document.getElementById('verification-badge-container');
    if (container && container.__x && container.__x.$data) {
        container.__x.$data.verified = verified;
        console.log('✅ Alpine.js actualizado');
    }
    
    // Reconstruir completamente el badge con el nuevo HTML
    const newIcon = verified ? 'badge-check' : 'shield-off';
    const newText = verified ? 'Verificado' : 'No Verificado';
    const newClasses = verified 
        ? 'inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800'
        : 'inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-50 text-gray-500';
    
    badge.className = newClasses;
    badge.id = 'verification-badge'; // Mantener el ID
    badge.innerHTML = `
        <i data-lucide="${newIcon}" class="w-3 h-3"></i>
        <span class="text-xs font-semibold">${newText}</span>
    `;
    
    console.log('✅ Badge HTML reconstruido con icono:', newIcon);
    
    // Reinicializar iconos Lucide - múltiples intentos para asegurar
    const reinitLucide = () => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
            console.log('✅ Iconos Lucide reinicializados');
        } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
            console.log('✅ Iconos Lucide reinicializados (método alternativo)');
        }
    };
    
    // Intentar varias veces para asegurar que se renderiza
    setTimeout(reinitLucide, 50);
    setTimeout(reinitLucide, 150);
    setTimeout(reinitLucide, 300);
    
    console.log(`✅ Badge de verificación actualizado completamente a: ${verified ? 'Verificado' : 'No Verificado'}`);
}

/**
 * 🎉 Mostrar modal de felicitaciones/información por cambio de verificación
 */
window.showVerificationModal = function(data) {
    if (data.verified) {
        // Modal de felicitaciones - tienda verificada
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998] transition-opacity duration-300 opacity-0';
        backdrop.style.backdropFilter = 'blur(4px)';
        
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-[9999] flex items-center justify-center p-4 opacity-0 scale-95 transition-all duration-300';
        modal.innerHTML = `
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-2xl max-w-md w-full p-8 transform text-center border-2 border-green-200">
                <div class="mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-3">🎉 ¡Felicitaciones!</h3>
                    <p class="text-lg text-gray-700 font-medium mb-2">Tu tienda ha sido verificada</p>
                    <p class="text-sm text-gray-600">¡Ahora tienes el badge oficial de Linkiu!</p>
                </div>
                <div class="bg-white/60 rounded-xl p-4 mb-6 backdrop-blur-sm border border-green-200">
                    <div class="flex items-start gap-3 text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                        <div class="text-sm">
                            <p class="text-gray-700 font-medium mb-1">✨ Mayor visibilidad en la plataforma</p>
                            <p class="text-gray-700 font-medium mb-1">🎯 Badge de confianza para tus clientes</p>
                            <p class="text-gray-700 font-medium">🚀 Destacado en búsquedas y recomendaciones</p>
                        </div>
                    </div>
                </div>
                <button class="modal-close w-full px-6 py-3.5 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-base transition-all transform hover:scale-105 shadow-lg">
                    ¡Genial, gracias! 🎊
                </button>
            </div>
        `;
        
        document.body.appendChild(backdrop);
        document.body.appendChild(modal);
        
        // Animar entrada
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('opacity-0', 'scale-95');
        }, 10);
        
        // Cerrar modal
        const closeModal = () => {
            backdrop.classList.add('opacity-0');
            modal.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
                if (modal.parentNode) modal.parentNode.removeChild(modal);
            }, 300);
        };
        
        modal.querySelector('.modal-close').addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
    } else {
        // Modal informativo - verificación removida
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998] transition-opacity duration-300 opacity-0';
        backdrop.style.backdropFilter = 'blur(4px)';
        
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-[9999] flex items-center justify-center p-4 opacity-0 scale-95 transition-all duration-300';
        modal.innerHTML = `
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl shadow-2xl max-w-md w-full p-8 transform text-center border-2 border-orange-200">
                <div class="mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            <path d="m9 12 2 2 4-4"></path>
                            <line x1="9" x2="15" y1="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Verificación Removida</h3>
                    <p class="text-base text-gray-700 font-medium">Tu badge de verificación ha sido removido temporalmente</p>
                </div>
                <div class="bg-white/60 rounded-xl p-4 mb-6 backdrop-blur-sm border border-orange-200">
                    <p class="text-sm text-gray-600 text-left">
                        <strong class="block mb-2">¿Qué significa esto?</strong>
                        Tu tienda seguirá funcionando normalmente, pero el badge de verificación ya no aparecerá en tu perfil.
                    </p>
                </div>
                <div class="bg-white/60 rounded-xl p-3 mb-6 backdrop-blur-sm border border-orange-200">
                    <p class="text-xs text-gray-600">
                        💡 Si tienes dudas sobre esta acción, contacta con nuestro equipo de soporte.
                    </p>
                </div>
                <button class="modal-close w-full px-6 py-3.5 rounded-xl bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold text-base transition-all transform hover:scale-105 shadow-lg">
                    Entendido
                </button>
            </div>
        `;
        
        document.body.appendChild(backdrop);
        document.body.appendChild(modal);
        
        // Animar entrada
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('opacity-0', 'scale-95');
        }, 10);
        
        // Cerrar modal
        const closeModal = () => {
            backdrop.classList.add('opacity-0');
            modal.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
                if (modal.parentNode) modal.parentNode.removeChild(modal);
            }, 300);
        };
        
        modal.querySelector('.modal-close').addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
    }
}

console.log('✅ notifications.js loaded successfully');

