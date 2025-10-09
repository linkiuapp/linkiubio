/**
 * Sistema de Notificaciones en Tiempo Real
 * Maneja notificaciones de pedidos, tickets, anuncios y solicitudes de tiendas
 */

console.log('🔔 notifications.js: Initializing...');

// Auto-inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNotifications);
} else {
    initNotifications();
}

function initNotifications() {
    console.log('🔔 notifications.js: DOM ready, checking for context...');

    // Esperar a que Pusher esté disponible
    if (typeof window.Echo === 'undefined' || typeof window.pusher === 'undefined') {
        console.warn('⚠️ Pusher/Echo not available yet, waiting...');
        setTimeout(initNotifications, 500);
        return;
    }

    console.log('✅ Pusher available, setting up notifications...');

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
    }

    // CLIENTE: Escuchar cambios de estado de pedido
    const orderId = body.dataset.orderId;
    if (orderId) {
        console.log(`🔔 Client detected (Order ID: ${orderId}), subscribing to order status...`);
        setupOrderStatusListener(orderId);
    }

    // TODOS: Escuchar anuncios de la plataforma
    setupAnnouncementsListener();
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
 */
function setupNewOrderListener(storeId) {
    try {
        window.Echo.channel(`store.${storeId}.orders`)
            .listen('new.order', (data) => {
                console.log('📦 Nuevo pedido recibido:', data);

                // Desktop notification
                showDesktopNotification(
                    '📦 Nuevo Pedido',
                    `Pedido #${data.order_number} de ${data.customer_name}`
                );

                // Toast in-app
                showToast(
                    '📦 Nuevo Pedido',
                    `<strong>Pedido #${data.order_number}</strong><br>` +
                    `Cliente: ${data.customer_name}<br>` +
                    `Total: $${data.total}<br>` +
                    `<a href="${data.order_url}" class="text-primary-200 underline">Ver pedido →</a>`,
                    'success',
                    8000
                );

                // Sonido
                playNotificationSound();
            });

        console.log('✅ New order listener configured for store:', storeId);
    } catch (error) {
        console.error('❌ Error setting up new order listener:', error);
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

                showToast(
                    '💬 Nueva Respuesta en Ticket',
                    `<strong>Ticket #${data.ticket_number}</strong><br>` +
                    `${data.response_preview}<br>` +
                    `<a href="${data.ticket_url}" class="text-primary-200 underline">Ver ticket →</a>`,
                    'info',
                    8000
                );

                showDesktopNotification(
                    '💬 Nueva Respuesta',
                    `Ticket #${data.ticket_number}: ${data.response_preview}`
                );

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
                console.log('📢 Nuevo anuncio:', data);

                showToast(
                    '📢 ' + data.title,
                    data.message,
                    'warning',
                    10000
                );

                showDesktopNotification(
                    '📢 ' + data.title,
                    data.message
                );

                playNotificationSound();
            });

        console.log('✅ Announcements listener configured');
    } catch (error) {
        console.error('❌ Error setting up announcements listener:', error);
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

console.log('✅ notifications.js loaded successfully');

