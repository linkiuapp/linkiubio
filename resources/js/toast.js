/**
 * Sistema unificado de toasts para Linkiu
 * Diseño consistente con iconos personalizados
 */

class ToastManager {
    constructor() {
        this.assetUrl = document.querySelector('meta[name="asset-url"]')?.content || '';
    }

    /**
     * Mostrar toast genérico
     * @param {string} type - Tipo: success, error, warning, info, favorite, shop
     * @param {string} title - Título del toast
     * @param {string} message - Mensaje del toast
     * @param {number} duration - Duración en ms (default: 5000)
     * @param {string} position - Posición: top-center, bottom-center (default: top-center)
     */
    show(type, title, message, duration = 5000, position = 'top-center') {
        // Mapeo de tipos a iconos
        const icons = {
            success: 'emoji_toast_Linkiu_check.svg',
            error: 'emoji_toast_Linkiu_error.svg',
            warning: 'emoji_toast_Linkiu_warning.svg',
            info: 'emoji_toast_Linkiu_info.svg',
            favorite: 'emoji_toast_Linkiu_favorite.svg',
            shop: 'emoji_toast_Linkiu_shop.svg'
        };

        const imageUrl = `${this.assetUrl}images-ui/${icons[type] || icons.info}`;
        
        // Configurar posición y animación
        const positionClasses = position === 'bottom-center' 
            ? 'bottom-6 left-1/2 -translate-x-1/2'
            : 'top-6 left-1/2 -translate-x-1/2';
        
        const initialTransform = position === 'bottom-center' ? 'translate-y-full' : '-translate-y-full';
        const animationOut = position === 'bottom-center' ? 'translate-y-full' : '-translate-y-full';
        
        // Crear notificación temporal
        const notification = document.createElement('div');
        notification.className = `fixed ${positionClasses} ${initialTransform} bg-slate-900 items-center justify-center px-4 py-3 rounded-full shadow-2xl z-[9999] transition-all duration-500 opacity-0 min-w-[380px] md:min-w-[400px]`;
        notification.dataset.animationOut = animationOut;
        notification.innerHTML = `
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0">
                    <img src="${imageUrl}" alt="${type}" class="w-16 h-16 md:w-20 md:h-20">
                </div>

                <div class="flex flex-col gap-1 flex-1">
                    <span class="text-sm md:text-base font-bold text-white">${title}</span>
                    <span class="text-xs md:text-base font-normal text-white">${message}</span>
                </div>
                
                <div class="flex-shrink-0">
                    <button class="close-toast hover:opacity-70 transition-opacity">
                        <i data-lucide="circle-x" class="w-5 h-5 text-white"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Inicializar iconos de Lucide en la notificación
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
        
        // Agregar evento de cerrar
        const closeBtn = notification.querySelector('.close-toast');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                this.closeToast(notification);
            });
        }
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-y-full', '-translate-y-full', 'opacity-0');
            notification.classList.add('translate-y-0');
        }, 100);
        
        // Auto-cerrar después de la duración
        setTimeout(() => {
            this.closeToast(notification);
        }, duration);
    }

    /**
     * Cerrar toast con animación
     */
    closeToast(notification) {
        if (!notification || !notification.parentNode) return;
        
        const animationOut = notification.dataset.animationOut || '-translate-y-full';
        notification.classList.remove('translate-y-0');
        notification.classList.add(animationOut, 'opacity-0');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    /**
     * Métodos de acceso rápido
     */
    success(title, message, duration = 5000, position = 'top-center') {
        this.show('success', title, message, duration, position);
    }

    error(title, message, duration = 5000, position = 'top-center') {
        this.show('error', title, message, duration, position);
    }

    warning(title, message, duration = 5000, position = 'top-center') {
        this.show('warning', title, message, duration, position);
    }

    info(title, message, duration = 5000, position = 'top-center') {
        this.show('info', title, message, duration, position);
    }

    favorite(title, message, duration = 5000, position = 'top-center') {
        this.show('favorite', title, message, duration, position);
    }

    shop(title, message, duration = 5000, position = 'top-center') {
        this.show('shop', title, message, duration, position);
    }

    /**
     * Toast para nuevo pedido
     * @param {object} orderData - Datos del pedido {order_number, customer_name, total, delivery_type, order_id}
     * @param {number} duration - Duración en ms (default: 15000)
     */
    order(orderData, duration = 15000) {
        const imageUrl = `${this.assetUrl}images-ui/emoji_toast_Linkiu_shop.svg`;
        const position = 'bottom-center';
        
        const initialTransform = 'translate-y-full';
        const animationOut = 'translate-y-full';
        
        // Crear notificación temporal
        const notification = document.createElement('div');
        notification.className = `fixed bottom-6 left-1/2 -translate-x-1/2 ${initialTransform} bg-slate-900 items-center justify-center px-4 py-3 rounded-full shadow-2xl z-[9999] transition-all duration-500 opacity-0 min-w-[380px] md:min-w-[420px]`;
        notification.dataset.animationOut = animationOut;
        notification.dataset.orderId = orderData.order_id;
        notification.innerHTML = `
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0">
                    <img src="${imageUrl}" alt="order" class="w-14 h-14 md:w-16 md:h-16">
                </div>

                <div class="flex flex-col gap-1 flex-1">
                    <span class="text-sm md:text-base font-bold text-white">¡Nuevo Pedido! #${orderData.order_number}</span>
                    <span class="text-xs md:text-base font-normal text-white">${orderData.customer_name} - $${orderData.total.toLocaleString('es-CO')}</span>
                </div>
                
                <div class="flex-shrink-0 flex items-center gap-4">
                    <button class="view-order-btn px-4 py-3 bg-yellow-500 hover:bg-yellow-600 rounded-full text-sm md:text-base font-medium text-black transition-colors" data-order-id="${orderData.order_id}">
                        Ver pedido
                    </button>
                    <button class="close-toast hover:opacity-70 transition-opacity">
                        <i data-lucide="circle-x" class="w-5 h-5 text-white"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Inicializar iconos de Lucide
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
        
        // Evento botón "Ver"
        const viewBtn = notification.querySelector('.view-order-btn');
        if (viewBtn) {
            viewBtn.addEventListener('click', () => {
                // Si viene URL en orderData, usarla; sino construir ruta básica
                if (orderData.url) {
                    window.location.href = orderData.url;
                } else {
                    window.location.href = `/admin/orders/${orderData.order_id}`;
                }
            });
        }
        
        // Evento cerrar
        const closeBtn = notification.querySelector('.close-toast');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                this.closeToast(notification);
            });
        }
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-y-full', '-translate-y-full', 'opacity-0');
            notification.classList.add('translate-y-0');
        }, 100);
        
        // Auto-cerrar después de la duración (si no es infinito)
        if (duration !== Infinity) {
            setTimeout(() => {
                this.closeToast(notification);
            }, duration);
        }
    }

    /**
     * Modal de confirmación con diseño similar al toast
     * @param {string} type - Tipo: warning, error, info
     * @param {string} title - Título del modal
     * @param {string} message - Mensaje del modal
     * @param {string} confirmText - Texto botón confirmar (default: "Confirmar")
     * @param {string} cancelText - Texto botón cancelar (default: "Cancelar")
     * @returns {Promise<boolean>} - true si confirmó, false si canceló
     */
    modal(type, title, message, confirmText = 'Confirmar', cancelText = 'Cancelar') {
        return new Promise((resolve) => {
            const icons = {
                warning: 'emoji_toast_Linkiu_warning.svg',
                error: 'emoji_toast_Linkiu_error.svg',
                info: 'emoji_toast_Linkiu_info.svg'
            };

            const imageUrl = `${this.assetUrl}images-ui/${icons[type] || icons.warning}`;
            
            // Crear backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998] transition-opacity duration-300 opacity-0';
            backdrop.style.backdropFilter = 'blur(4px)';
            
            // Crear modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[9999] flex items-start justify-center p-2 pt-2 opacity-0 scale-95 transition-all duration-300';
            modal.innerHTML = `
                <div class="bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full p-4 transform">
                    <div class="flex flex-col items-center text-center gap-2">
                        <div class="flex-shrink-0 flex items-center gap-4">
                            <img src="${imageUrl}" alt="${type}" class="w-16 h-16 md:w-20 md:h-20">
                            <div class="flex flex-col gap-2 items-start">
                                <h3 class="text-base md:text-lg font-bold text-white">${title}</h3>
                                <p class="text-sm md:text-base text-white/80">${message}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 w-full mt-2">
                            <button class="modal-cancel flex-1 px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white text-sm md:text-base font-medium transition-colors">
                                ${cancelText}
                            </button>
                            <button class="modal-confirm flex-1 px-4 py-2 rounded-lg bg-red-500 hover:bg-red-900 text-white text-sm md:text-base font-medium transition-colors">
                                ${confirmText}
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar al DOM
            document.body.appendChild(backdrop);
            document.body.appendChild(modal);
            
            // Animar entrada
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                modal.classList.remove('opacity-0', 'scale-95');
            }, 10);
            
            // Función para cerrar el modal
            const closeModal = (confirmed) => {
                backdrop.classList.add('opacity-0');
                modal.classList.add('opacity-0', 'scale-95');
                
                setTimeout(() => {
                    if (backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
                    if (modal.parentNode) modal.parentNode.removeChild(modal);
                    resolve(confirmed);
                }, 300);
            };
            
            // Event listeners
            modal.querySelector('.modal-confirm').addEventListener('click', () => closeModal(true));
            modal.querySelector('.modal-cancel').addEventListener('click', () => closeModal(false));
            backdrop.addEventListener('click', () => closeModal(false));
        });
    }
}

// Crear instancia global
window.toast = new ToastManager();

// Export para usar en módulos
export default window.toast;

