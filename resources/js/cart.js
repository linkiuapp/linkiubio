// Sistema de carrito unificado con Session (servidor)
class Cart {
    constructor() {
        this.items = []; // Solo para cache local temporal
        
        // Verificar que estamos en el contexto correcto
        if (!this.isValidContext()) {
            console.log('ℹ️ Cart: Invalid context, skipping initialization');
            return;
        }
        
        try {
            this.initializeEvents();
            this.syncWithServer();
        } catch (error) {
            console.error('❌ Cart: Error during initialization:', error);
        }
    }
    
    // Verificar que estamos en un contexto válido para el carrito
    isValidContext() {
        // Verificar que tenemos los elementos necesarios del DOM
        const hasCSRFToken = document.querySelector('meta[name="csrf-token"]') !== null;
        const isStorefront = !window.location.pathname.includes('/admin') && 
                            !window.location.pathname.includes('/superlinkiu');
        
        return hasCSRFToken && isStorefront;
    }

    // Ya no usamos LocalStorage, todo se maneja en servidor
    // Mantenemos cache local solo para UI responsiva
    loadCart() {
        // Cache local solo temporal, la fuente de verdad es el servidor
        return this.items;
    }

    // Sincronizar con servidor en lugar de guardar localmente
    saveCart() {
        // No guardamos en LocalStorage, confiamos en el servidor
        this.updateCartDisplay();
    }

    // Agregar producto al carrito
    async addProduct(product) {
        try {
            // Enviar al servidor (única fuente de verdad)
            const response = await fetch(this.getCartAddUrl(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: product.id,
                    quantity: 1,
                    variants: product.variants || null
                })
            });

            const data = await response.json();
            
            if (data.success) {
                // Actualizar badge de cantidad del producto
                this.updateProductBadge(product.id, data.cart);
                
                // Actualizar UI con datos del servidor PRIMERO
                this.updateCartDisplayFromServer(data);
                
                // Mostrar feedback CON los datos actualizados
                this.showAddedFeedback(product.name, data.cart);
            } else {
                this.showError(data.message || 'Error al agregar producto');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            const isNetworkError = !navigator.onLine || error.name === 'NetworkError' || error.message.includes('fetch');
            this.showError('Error al agregar producto', isNetworkError);
        }
    }

    // Remover producto del carrito (ahora vía servidor)
    async removeProduct(itemKey) {
        try {
            const response = await fetch(this.getCartRemoveUrl(), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ item_key: itemKey })
            });

            const data = await response.json();
            if (data.success) {
                this.updateCartDisplayFromServer(data);
            } else {
                this.showError(data.message || 'Error al eliminar producto');
            }
        } catch (error) {
            console.error('Error removing from cart:', error);
            const isNetworkError = !navigator.onLine || error.name === 'NetworkError' || error.message.includes('fetch');
            this.showError('Error al eliminar producto', isNetworkError);
        }
    }

    // Actualizar cantidad de producto (ahora vía servidor)
    async updateQuantity(itemKey, quantity) {
        if (quantity <= 0) {
            this.removeProduct(itemKey);
            return;
        }

        try {
            const response = await fetch(this.getCartUpdateUrl(), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    item_key: itemKey,
                    quantity: quantity
                })
            });

            const data = await response.json();
            if (data.success) {
                this.updateCartDisplayFromServer(data);
            } else {
                this.showError(data.message || 'Error al actualizar cantidad');
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            const isNetworkError = !navigator.onLine || error.name === 'NetworkError' || error.message.includes('fetch');
            this.showError('Error al actualizar cantidad', isNetworkError);
        }
    }

    // Limpiar carrito (ahora vía servidor)
    async clearCart() {
        // Mostrar confirmación con el nuevo modal unificado
        const confirmed = await window.toast.modal(
            'warning',
            '¿Vaciar carrito?',
            'Se eliminarán todos los productos del carrito',
            'Sí, vaciar',
            'Cancelar'
        );

        // Si el usuario cancela, no hacer nada
        if (!confirmed) {
            return;
        }

        try {
            const response = await fetch(this.getCartClearUrl(), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            if (data.success) {
                this.updateCartDisplayFromServer(data);
                
                // Mostrar mensaje de éxito
                window.toast.success(
                    '¡Carrito vaciado!',
                    'Todos los productos fueron eliminados',
                    5000
                );
            } else {
                this.showError(data.message || 'Error al vaciar carrito');
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
            const isNetworkError = !navigator.onLine || error.name === 'NetworkError' || error.message.includes('fetch');
            this.showError('Error al vaciar carrito', isNetworkError);
        }
    }

    // Obtener total de productos (ahora desde el servidor)
    getTotalItems() {
        // Ya no usamos this.items, confiamos en los datos del servidor
        // Este método se mantiene para compatibilidad pero debería usarse updateCartDisplayFromServer
        const badge = document.querySelector('.cart-badge');
        return badge ? parseInt(badge.textContent) || 0 : 0;
    }

    // Obtener total del precio (ahora desde el servidor)
    getTotalPrice() {
        // Ya no calculamos localmente, confiamos en los datos del servidor
        const priceText = document.querySelector('.cart-total-price');
        if (priceText) {
            const price = priceText.textContent.replace(/[^\d]/g, '');
            return parseInt(price) || 0;
        }
        return 0;
    }

    // Actualizar display del carrito flotante
    updateCartDisplay() {
        const cartFloat = document.getElementById('cart-float');
        if (!cartFloat) return;

        const totalItems = this.getTotalItems();
        const totalPrice = this.getTotalPrice();

        // Actualizar badge contador
        const badge = cartFloat.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = totalItems;
            badge.style.display = totalItems > 0 ? 'flex' : 'none';
        }

        // Actualizar texto de cantidad
        const countText = cartFloat.querySelector('.cart-count-text');
        if (countText) {
            countText.textContent = totalItems === 1 ? '1 producto' : `${totalItems} productos`;
        }

        // Actualizar precio total
        const priceText = cartFloat.querySelector('.cart-total-price');
        if (priceText) {
            priceText.textContent = `$${this.formatPrice(totalPrice)}`;
        }

        // Mostrar carrito (siempre visible)
        cartFloat.classList.remove('hidden');
    }

    // Formatear precio
    formatPrice(price) {
        return new Intl.NumberFormat('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    }

    // Sincronizar con el servidor al cargar
    async syncWithServer() {
        try {
            const response = await fetch(this.getCartGetUrl());
            const data = await response.json();
            
            if (data.success) {
                this.updateCartDisplayFromServer(data);
                // Actualizar todos los badges de productos
                this.updateAllProductBadges(data.cart);
            } else {
                // Si no hay carrito en servidor, mostrar carrito vacío
                this.updateCartDisplayFromServer({
                    cart_count: 0,
                    formatted_cart_total: '$0'
                });
                // Ocultar todos los badges
                this.hideAllProductBadges();
            }
        } catch (error) {
            console.error('Error syncing with server:', error);
            // En caso de error, mostrar carrito vacío en lugar de usar localStorage
            this.updateCartDisplayFromServer({
                cart_count: 0,
                formatted_cart_total: '$0'
            });
            // Ocultar todos los badges
            this.hideAllProductBadges();
        }
    }

    // Obtener URL para agregar al carrito
    getCartAddUrl() {
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const storeSlug = pathParts[0] || '';
        
        if (!storeSlug) {
            throw new Error('No se pudo determinar el slug de la tienda');
        }
        
        return `/${storeSlug}/carrito/agregar`;
    }

    // Obtener URL para obtener carrito
    getCartGetUrl() {
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const storeSlug = pathParts[0] || '';
        
        if (!storeSlug) {
            throw new Error('No se pudo determinar el slug de la tienda');
        }
        
        return `/${storeSlug}/carrito/contenido`;
    }

    // Obtener URL para actualizar carrito
    getCartUpdateUrl() {
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const storeSlug = pathParts[0] || '';
        
        if (!storeSlug) {
            throw new Error('No se pudo determinar el slug de la tienda');
        }
        
        return `/${storeSlug}/carrito/actualizar`;
    }

    // Obtener URL para eliminar del carrito
    getCartRemoveUrl() {
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const storeSlug = pathParts[0] || '';
        
        if (!storeSlug) {
            throw new Error('No se pudo determinar el slug de la tienda');
        }
        
        return `/${storeSlug}/carrito/eliminar`;
    }

    // Obtener URL para limpiar carrito
    getCartClearUrl() {
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const storeSlug = pathParts[0] || '';
        
        if (!storeSlug) {
            throw new Error('No se pudo determinar el slug de la tienda');
        }
        
        return `/${storeSlug}/carrito/limpiar`;
    }

    // Actualizar display con datos del servidor
    updateCartDisplayFromServer(serverData) {
        const cartFloat = document.getElementById('cart-float');
        if (!cartFloat) return;

        // Actualizar badge contador
        const badge = cartFloat.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = serverData.cart_count || 0;
            badge.style.display = serverData.cart_count > 0 ? 'flex' : 'none';
        }

        // Actualizar texto de cantidad
        const countText = cartFloat.querySelector('.cart-count-text');
        if (countText) {
            const count = serverData.cart_count || 0;
            countText.textContent = count === 1 ? '1 producto' : `${count} productos`;
        }

        // Actualizar precio total
        const priceText = cartFloat.querySelector('.cart-total-price');
        if (priceText) {
            priceText.textContent = serverData.formatted_cart_total || '$0';
        }

        // Actualizar todos los badges de productos en la página
        if (serverData.cart) {
            this.updateAllProductBadges(serverData.cart);
        } else {
            this.hideAllProductBadges();
        }

        // Mostrar carrito (siempre visible)
        cartFloat.classList.remove('hidden');
    }

    // Mostrar feedback cuando se agrega producto
    showAddedFeedback(productName, cartData) {
        // Usar el sistema unificado de toasts
        if (window.toast) {
            window.toast.success(
                '¡Actualización exitosa!',
                '¡Hey! Tu producto se agregó al carrito',
                5000
            );
        }
    }

    // Mostrar error con manejo robusto
    showError(message, isNetworkError = false) {
        // Determinar el tipo de error y mensaje apropiado
        let finalTitle = "¡Ups! Algo salió mal";
        let finalMessage = message;
        
        if (isNetworkError) {
            finalTitle = "Sin conexión";
            finalMessage = "Verifica tu internet e intenta nuevamente";
        } else if (message.includes('404')) {
            finalTitle = "Producto no encontrado";
            finalMessage = "La página será actualizada";
            setTimeout(() => window.location.reload(), 2000);
        } else if (message.includes('500')) {
            finalTitle = "Error del servidor";
            finalMessage = "Intenta nuevamente en unos momentos";
        } else if (message.includes('no disponible')) {
            finalTitle = "Producto agotado";
            finalMessage = "Este producto ya no está disponible";
        }

        // Usar el sistema unificado de toasts
        if (window.toast) {
            window.toast.error(finalTitle, finalMessage, isNetworkError ? 5000 : 4000);
        }
    }

    // Actualizar badge de cantidad del producto
    updateProductBadge(productId, cartData) {
        const badge = document.querySelector(`[data-product-badge="${productId}"]`);
        if (!badge) {
            console.log('⚠️ Badge not found for product:', productId);
            return;
        }
        
        // Buscar la cantidad de este producto en el carrito
        const quantity = this.getProductQuantityInCart(productId, cartData);
        
        console.log('🔢 Updating badge for product', productId, 'quantity:', quantity);
        
        if (quantity > 0) {
            badge.textContent = quantity;
            badge.style.display = 'flex';
            badge.classList.remove('hidden');
            console.log('✅ Badge shown for product', productId);
            // Animación de bounce
            badge.classList.add('animate-bounce');
            setTimeout(() => badge.classList.remove('animate-bounce'), 500);
        } else {
            badge.style.display = 'none';
            badge.classList.add('hidden');
            console.log('❌ Badge hidden for product', productId);
        }
    }
    
    // Actualizar todos los badges de productos en la página
    updateAllProductBadges(cartData) {
        if (!cartData || !cartData.items) {
            this.hideAllProductBadges();
            return;
        }
        
        // Buscar todos los badges en la página
        const badges = document.querySelectorAll('[data-product-badge]');
        badges.forEach(badge => {
            const productId = badge.dataset.productBadge;
            const quantity = this.getProductQuantityInCart(productId, cartData);
            
            if (quantity > 0) {
                badge.textContent = quantity;
                badge.style.display = 'flex';
                badge.classList.remove('hidden');
            } else {
                badge.style.display = 'none';
                badge.classList.add('hidden');
            }
        });
    }
    
    // Ocultar todos los badges
    hideAllProductBadges() {
        const badges = document.querySelectorAll('[data-product-badge]');
        badges.forEach(badge => {
            badge.style.display = 'none';
            badge.classList.add('hidden');
        });
    }
    
    // Obtener cantidad de un producto en el carrito
    getProductQuantityInCart(productId, cartData) {
        if (!cartData || !cartData.items) return 0;
        
        let totalQuantity = 0;
        cartData.items.forEach(item => {
            // El item puede tener product_id o variant.product_id
            const itemProductId = item.product_id || (item.variant && item.variant.product_id);
            if (itemProductId == productId) {
                totalQuantity += item.quantity || 1;
            }
        });
        
        return totalQuantity;
    }

    // Inicializar eventos
    initializeEvents() {
        // Eventos para botones "agregar al carrito"
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.add-to-cart-btn');
            if (btn) {
                e.preventDefault();
                e.stopPropagation(); // Evitar que el click se propague al enlace padre
                
                const productData = {
                    id: parseInt(btn.dataset.productId),
                    name: btn.dataset.productName,
                    price: parseFloat(btn.dataset.productPrice),
                    image: btn.dataset.productImage || null
                };
                
                console.log('🛒 Add to cart clicked:', productData);
                this.addProduct(productData);
            }
        }, true); // Usar capture phase para interceptar antes que otros handlers

        // Evento para ir al carrito
        document.addEventListener('click', (e) => {
            if (e.target.closest('.view-cart-btn')) {
                e.preventDefault();
                window.location.href = e.target.closest('.view-cart-btn').href;
            }
        });
    }
}

// Función de inicialización del carrito
function initializeCart() {
    console.log('🛒 initializeCart() called');
    console.log('📍 Current path:', window.location.pathname);
    console.log('📋 Document readyState:', document.readyState);
    
    // Verificar que estamos en una página de storefront
    const isStorefront = !window.location.pathname.includes('/admin') && 
                        !window.location.pathname.includes('/superlinkiu') &&
                        window.location.pathname !== '/' &&
                        window.location.pathname !== '/login' &&
                        window.location.pathname !== '/register';
    
    console.log('🏪 Is storefront?', isStorefront);
    
    // Verificar CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (isStorefront) {
        try {
            console.log('🛒 Creating new Cart instance...');
            window.cart = new Cart();
            console.log('✅ Cart initialized successfully');
            console.log('✅ Cart available:', typeof window.cart);
            console.log('✅ window.cart:', window.cart);
        } catch (error) {
            console.error('❌ Error initializing cart:', error);
            console.error('❌ Error stack:', error.stack);
        }
    } else {
        console.log('ℹ️ Cart not initialized (not in storefront context)');
        console.log('ℹ️ Reasons:', {
            hasAdmin: window.location.pathname.includes('/admin'),
            hasSuperLinkiu: window.location.pathname.includes('/superlinkiu'),
            isRoot: window.location.pathname === '/',
            isLogin: window.location.pathname === '/login',
            isRegister: window.location.pathname === '/register'
        });
    }
}

// Inicializar carrito cuando carga la página (solo si estamos en storefront)
// Usar readyState para verificar si DOM ya está listo o esperar evento
if (document.readyState === 'loading') {
    // DOM aún no está listo, esperar evento
    document.addEventListener('DOMContentLoaded', initializeCart);
} else {
    // DOM ya está listo, inicializar inmediatamente
    initializeCart();
}

// Exponer funciones globales si es necesario (solo si el carrito está inicializado)
window.addToCart = function(productId, productName, productPrice, productImage) {
    if (window.cart && typeof window.cart.addProduct === 'function') {
        try {
            window.cart.addProduct({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage
            });
        } catch (error) {
            console.error('❌ Error adding to cart:', error);
        }
    } else {
        console.warn('⚠️ Cart not available or not initialized');
    }
};

window.removeFromCart = function(productId) {
    if (window.cart && typeof window.cart.removeProduct === 'function') {
        try {
            window.cart.removeProduct(productId);
        } catch (error) {
            console.error('❌ Error removing from cart:', error);
        }
    } else {
        console.warn('⚠️ Cart not available or not initialized');
    }
};

window.updateCartQuantity = function(productId, quantity) {
    if (window.cart && typeof window.cart.updateQuantity === 'function') {
        try {
            window.cart.updateQuantity(productId, quantity);
        } catch (error) {
            console.error('❌ Error updating cart quantity:', error);
        }
    } else {
        console.warn('⚠️ Cart not available or not initialized');
    }
};

window.clearCart = function() {
    if (window.cart && typeof window.cart.clearCart === 'function') {
        try {
            window.cart.clearCart();
        } catch (error) {
            console.error('❌ Error clearing cart:', error);
        }
    } else {
        console.warn('⚠️ Cart not available or not initialized');
    }
}; 