// Sistema de notificaciones en tiempo real con Pusher
console.log('🔔 Notifications.js loaded');

// Función para pedir permiso de notificaciones de escritorio
function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission().then(permission => {
            console.log('🔔 Notification permission:', permission);
        });
    }
}

// Función para mostrar notificación de escritorio
function showDesktopNotification(title, options = {}) {
    if ('Notification' in window && Notification.permission === 'granted') {
        const notification = new Notification(title, {
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            ...options
        });

        // Cerrar automáticamente después de 10 segundos
        setTimeout(() => notification.close(), 10000);

        return notification;
    }
    return null;
}

// Función para mostrar toast/mensaje in-app
function showToast(message, type = 'info', duration = 5000) {
    const toast = document.createElement('div');
    const colors = {
        info: 'bg-info-300 text-white',
        success: 'bg-success-300 text-white',
        warning: 'bg-warning-300 text-white',
        error: 'bg-error-300 text-white',
        primary: 'bg-primary-300 text-white'
    };

    toast.className = `fixed top-4 right-4 ${colors[type] || colors.info} px-6 py-4 rounded-lg shadow-lg z-[9999] max-w-md animate-slide-in`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-2xl">🔔</span>
            <div class="flex-1">${message}</div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-accent-100">
                ✕
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// Función para reproducir sonido de notificación
function playNotificationSound() {
    // Crear un beep suave usando Web Audio API
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.value = 800; // Frecuencia del tono
        gainNode.gain.value = 0.1; // Volumen bajo

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.1); // Duración corta
    } catch (e) {
        console.log('No se pudo reproducir sonido:', e);
    }
}

// Función para actualizar badge de contador
function updateBadge(selector, count) {
    const badge = document.querySelector(selector);
    if (badge) {
        badge.textContent = count;
        if (count > 0) {
            badge.classList.remove('hidden');
            badge.classList.add('animate-pulse');
            setTimeout(() => badge.classList.remove('animate-pulse'), 1000);
        } else {
            badge.classList.add('hidden');
        }
    }
}

// ====================
// ADMIN TIENDA - Escuchar nuevos pedidos
// ====================
export function initTenantAdminNotifications(storeId) {
    if (!window.pusher) {
        console.error('❌ Pusher no está inicializado');
        return;
    }

    console.log('🔔 Inicializando notificaciones para Admin Tienda', { storeId });

    // Pedir permiso para notificaciones de escritorio
    requestNotificationPermission();

    // Canal para nuevos pedidos
    const ordersChannel = window.pusher.subscribe(`store.${storeId}.orders`);
    
    console.log('📡 Suscrito al canal: store.' + storeId + '.orders');
    
    ordersChannel.bind('new.order', function(data) {
        console.log('🛒 Nuevo pedido recibido:', data);

        // Notificación de escritorio
        const notification = showDesktopNotification('🛒 Nuevo Pedido', {
            body: `${data.customer_name}\nTotal: ${data.formatted_total}\n${data.order_number}`,
            tag: 'new-order-' + data.order_id,
            requireInteraction: true
        });

        if (notification) {
            notification.onclick = function() {
                window.focus();
                window.location.href = data.url;
            };
        }

        // Toast in-app
        showToast(
            `<strong>Nuevo Pedido #${data.order_number}</strong><br>
            ${data.customer_name} - ${data.formatted_total}`,
            'primary',
            8000
        );

        // Sonido
        playNotificationSound();

        // Actualizar contador si existe
        updateBadge('.new-orders-badge', parseInt(document.querySelector('.new-orders-badge')?.textContent || 0) + 1);
    });

    // Canal para tickets (respuestas de soporte)
    const ticketsChannel = window.pusher.subscribe(`store.${storeId}.tickets`);
    
    ticketsChannel.bind('ticket.response', function(data) {
        console.log('🎫 Nueva respuesta de ticket:', data);

        // Notificación de escritorio
        showDesktopNotification('🎫 Respuesta de Soporte', {
            body: `Ticket #${data.ticket_number}\n${data.sender_name}`,
            tag: 'ticket-response-' + data.ticket_id
        });

        // Toast in-app
        showToast(
            `<strong>Respuesta en Ticket #${data.ticket_number}</strong><br>
            ${data.sender_name}: ${data.message}`,
            'info',
            6000
        );

        playNotificationSound();
    });

    // Canal para anuncios de plataforma
    const announcementsChannel = window.pusher.subscribe('platform.announcements');
    
    announcementsChannel.bind('new.announcement', function(data) {
        console.log('📢 Nuevo anuncio:', data);

        // Notificación de escritorio
        showDesktopNotification(`${data.type_icon} ${data.type_label}`, {
            body: `${data.title}\n${data.message}`,
            tag: 'announcement-' + data.id
        });

        // Toast in-app con tipo según prioridad
        showToast(
            `<strong>${data.type_icon} ${data.title}</strong><br>
            ${data.message}`,
            data.is_urgent ? 'warning' : 'info',
            data.is_urgent ? 10000 : 6000
        );

        if (data.is_urgent) {
            playNotificationSound();
        }
    });

    console.log('✅ Notificaciones de Admin Tienda inicializadas');
}

// ====================
// SUPER ADMIN - Escuchar respuestas de tickets
// ====================
export function initSuperAdminNotifications() {
    if (!window.pusher) {
        console.error('❌ Pusher no está inicializado');
        return;
    }

    console.log('🔔 Inicializando notificaciones para SuperAdmin');

    requestNotificationPermission();

    // Canal para respuestas de tickets de las tiendas
    const ticketsChannel = window.pusher.subscribe('support.tickets');
    
    ticketsChannel.bind('ticket.response', function(data) {
        console.log('🎫 Nueva respuesta de ticket de tienda:', data);

        showDesktopNotification('🎫 Respuesta de Tienda', {
            body: `Ticket #${data.ticket_number}\n${data.sender_name}`,
            tag: 'ticket-response-' + data.ticket_id
        });

        showToast(
            `<strong>Respuesta en Ticket #${data.ticket_number}</strong><br>
            ${data.sender_name}: ${data.message}`,
            'primary',
            6000
        );

        playNotificationSound();
        updateBadge('.new-tickets-badge', parseInt(document.querySelector('.new-tickets-badge')?.textContent || 0) + 1);
    });

    console.log('✅ Notificaciones de SuperAdmin inicializadas');
}

// ====================
// CLIENTE - Escuchar cambios de estado de pedido
// ====================
export function initCustomerNotifications(orderId) {
    if (!window.pusher) {
        console.error('❌ Pusher no está inicializado');
        return;
    }

    console.log('🔔 Inicializando notificaciones para Cliente', { orderId });

    // Canal específico del pedido
    const orderChannel = window.pusher.subscribe(`order.${orderId}`);
    
    orderChannel.bind('status.changed', function(data) {
        console.log('📦 Estado del pedido cambió:', data);

        // Toast in-app
        showToast(
            `<strong>${data.message}</strong><br>
            Pedido #${data.order_number}`,
            'success',
            8000
        );

        playNotificationSound();

        // Actualizar estado en la página si existe el elemento
        const statusElement = document.querySelector('[data-order-status]');
        if (statusElement) {
            statusElement.textContent = data.status_label;
            statusElement.className = getStatusColorClass(data.new_status);
        }

        // Trigger custom event para que la página lo maneje
        window.dispatchEvent(new CustomEvent('orderStatusChanged', { detail: data }));
    });

    console.log('✅ Notificaciones de Cliente inicializadas');
}

// Función auxiliar para colores de estado
function getStatusColorClass(status) {
    const colors = {
        pending: 'bg-warning-300 text-white',
        confirmed: 'bg-success-300 text-white',
        preparing: 'bg-info-300 text-white',
        ready: 'bg-primary-300 text-white',
        in_transit: 'bg-info-300 text-white',
        delivered: 'bg-success-300 text-white',
        cancelled: 'bg-error-300 text-white'
    };
    return `px-3 py-1 rounded-full text-sm font-medium ${colors[status] || 'bg-black-300 text-white'}`;
}

// Auto-inicializar según el contexto
document.addEventListener('DOMContentLoaded', function() {
    // Esperar a que Pusher esté listo
    setTimeout(() => {
        const body = document.body;
        
        // Detectar contexto y auto-inicializar
        if (body.classList.contains('tenant-admin')) {
            const storeId = body.dataset.storeId;
            if (storeId) {
                initTenantAdminNotifications(storeId);
            }
        } else if (body.classList.contains('super-admin')) {
            initSuperAdminNotifications();
        } else if (body.classList.contains('customer-order-tracking')) {
            const orderId = body.dataset.orderId;
            if (orderId) {
                initCustomerNotifications(orderId);
            }
        }
    }, 1000);
});

