@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-6 space-y-6">
    <!-- Header del carrito -->
    <div class="flex flex-col items-center justify-center">
        <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_cart.svg" alt="img_linkiu_v1_cart" class="h-32 w-auto" loading="lazy">
        <h1 class="h3 text-brandNeutral-400 mt-4">Mi Carrito</h1>
        <p class="caption text-brandNeutral-400">Revisa tus productos antes de continuar</p>
    </div>

    <!-- Contenedor del carrito -->
    <div id="cart-container" class="space-y-4">
        <!-- Loading state -->
        <div id="cart-loading" class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-300 mx-auto"></div>
            <p class="text-black-300 mt-2">Cargando carrito...</p>
        </div>

        <!-- Empty state -->
        <div id="cart-empty" class="text-center py-12 hidden">
            <h3 class="h4 text-brandNeutral-400 mt-4">Tu carrito está vacío</h3>
            <p class="caption text-brandNeutral-400 mb-6">¡Agrega algunos productos deliciosos!</p>
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="inline-flex items-center gap-2 bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 px-6 py-3 rounded-full caption transition-colors text-center">
                Continuar comprando
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Cart items -->
        <div id="cart-items" class="space-y-3 hidden">
            <!-- Items will be loaded here -->
        </div>

        <!-- Cart summary -->
        <div id="cart-summary" class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 hidden">
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="caption text-brandNeutral-400">Subtotal:</span>
                    <span id="cart-subtotal" class="body-lg-bold text-brandNeutral-400">$0</span>
                </div>
                <div class="border-t border-brandWhite-300 pt-3">
                    <div class="flex justify-between items-center">
                        <span class="caption text-brandNeutral-400">Total:</span>
                        <span id="cart-total" class="body-lg-bold text-brandNeutral-400">$0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div id="cart-actions" class="space-y-3 hidden">
            <a href="{{ route('tenant.checkout.create', $store->slug) }}" 
               id="checkout-btn" 
               class="block w-full bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 rounded-lg caption transition-colors text-center">
                Finalizar compra
            </a>
            <button id="clear-cart-btn" 
                    class="w-full bg-brandError-100 hover:bg-brandError-300 text-brandError-400 py-2 rounded-lg caption transition-colors text-center">
                Vaciar carrito
            </button>
        </div>
    </div>
</div>

<!-- Template para items del carrito -->
<template id="cart-item-template">
    <div class="cart-item bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300">
        <div class="flex items-center gap-3">
            <!-- Imagen del producto -->
            <div class="w-8 h-8 bg-brandPrimary-50 rounded-lg overflow-hidden flex-shrink-0">
                <img class="item-image w-8 h-8 object-cover" src="" alt="">
            </div>
            
            <!-- Información del producto -->
            <div class="flex-1 min-w-0">
                <h3 class="item-name caption-strong text-brandNeutral-400 truncate"></h3>
                <p class="item-variants caption text-brandNeutral-400"></p>
                <p class="item-price caption-strong text-brandNeutral-400"></p>
            </div>
            
            <!-- Controles de cantidad -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="quantity-decrease bg-brandPrimary-50 hover:bg-brandPrimary-100 w-8 h-8 rounded-full flex items-center justify-center transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg>                    <div class="loading-spinner hidden w-3 h-3 border-2 border-brandNeutral-400 border-t-brandNeutral-400 rounded-full animate-spin"></div>
                </button>
                <span class="item-quantity body-lg-bold text-brandNeutral-400 min-w-[2rem] text-center"></span>
                <button class="quantity-increase bg-brandPrimary-50 hover:bg-brandPrimary-100 w-8 h-8 rounded-full flex items-center justify-center transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>                    <div class="loading-spinner hidden w-4 h-4 border-2 border-brandNeutral-400 border-t-brandNeutral-400 rounded-full animate-spin"></div>
                </button>
            </div>
            
            <!-- Botón eliminar -->
            <button class="remove-item text-brandError-300 hover:text-brandError-200 p-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                <div class="loading-spinner hidden w-3 h-3 border-2 border-brandNeutral-400 border-t-brandNeutral-400 rounded-full animate-spin"></div>
            </button>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.getElementById('cart-container');
    const cartLoading = document.getElementById('cart-loading');
    const cartEmpty = document.getElementById('cart-empty');
    const cartItems = document.getElementById('cart-items');
    const cartSummary = document.getElementById('cart-summary');
    const cartActions = document.getElementById('cart-actions');
    const itemTemplate = document.getElementById('cart-item-template');

    // Cargar carrito al iniciar
    loadCart();

    async function loadCart() {
        try {
            const response = await fetch('{{ route("tenant.cart.get", $store->slug) }}');
            const data = await response.json();

            if (data.success) {
                displayCart(data);
            } else {
                showError('Error al cargar el carrito');
            }
        } catch (error) {
            console.error('Error loading cart:', error);
            showError('Error de conexión');
        }
    }

    function displayCart(data) {
        cartLoading.classList.add('hidden');

        if (data.items.length === 0) {
            cartEmpty.classList.remove('hidden');
            cartItems.classList.add('hidden');
            cartSummary.classList.add('hidden');
            cartActions.classList.add('hidden');
        } else {
            cartEmpty.classList.add('hidden');
            cartItems.classList.remove('hidden');
            cartSummary.classList.remove('hidden');
            cartActions.classList.remove('hidden');

            // Limpiar items existentes
            cartItems.innerHTML = '';

            // Agregar cada item
            data.items.forEach(item => {
                const itemElement = createCartItem(item);
                cartItems.appendChild(itemElement);
            });

            // Actualizar totales
            document.getElementById('cart-subtotal').textContent = data.formatted_total;
            document.getElementById('cart-total').textContent = data.formatted_total;
        }
    }

    function createCartItem(item) {
        const template = itemTemplate.content.cloneNode(true);
        const itemElement = template.querySelector('.cart-item');

        // Configurar datos del item
        itemElement.dataset.itemKey = item.key;
        // Configurar imagen del producto (compatible con nuevo y viejo formato)
        const imageElement = itemElement.querySelector('.item-image');
        const imageUrl = item.image_url || (item.product && item.product.main_image_url) || null;
        if (imageUrl) {
            imageElement.src = imageUrl;
        } else {
            imageElement.src = '{{ asset("assets/images/placeholder-product.svg") }}';
        }
        
        // Configurar datos (compatible con nuevo y viejo formato)
        const productName = item.product_name || (item.product && item.product.name) || 'Producto sin nombre';
        const productPrice = item.product_price || (item.product && item.product.price) || 0;
        
        itemElement.querySelector('.item-image').alt = productName;
        itemElement.querySelector('.item-name').textContent = productName;
        itemElement.querySelector('.item-variants').textContent = item.variant_display || '';
        
        // Usar el precio unitario correcto
        const unitPrice = productPrice + (item.variant_details?.precio_modificador || 0);
        itemElement.querySelector('.item-price').textContent = `$${formatPrice(unitPrice)}`;
        itemElement.querySelector('.item-quantity').textContent = item.quantity;

        // Event listeners
        itemElement.querySelector('.quantity-decrease').addEventListener('click', () => {
            updateQuantity(item.key, item.quantity - 1);
        });

        itemElement.querySelector('.quantity-increase').addEventListener('click', () => {
            updateQuantity(item.key, item.quantity + 1);
        });

        itemElement.querySelector('.remove-item').addEventListener('click', () => {
            removeItem(item.key);
        });

        return itemElement;
    }

    async function updateQuantity(itemKey, newQuantity) {
        if (newQuantity <= 0) {
            removeItem(itemKey);
            return;
        }

        // Mostrar loading state
        const itemElement = document.querySelector(`[data-item-key="${itemKey}"]`);
        if (itemElement) {
            showItemLoading(itemElement, 'quantity');
        }

        try {
            const response = await fetch('{{ route("tenant.cart.update", $store->slug) }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    item_key: String(itemKey),
                    quantity: parseInt(newQuantity)
                })
            });

            const data = await response.json();
            if (data.success) {
                loadCart();
                // El carrito flotante se actualiza automáticamente vía cart.js
            } else {
                showError(data.message || 'Error al actualizar cantidad');
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            showError('Error al actualizar cantidad');
        } finally {
            // Ocultar loading state
            if (itemElement) {
                hideItemLoading(itemElement, 'quantity');
            }
        }
    }

    async function removeItem(itemKey) {
        // ⚡ ELIMINACIÓN INSTANTÁNEA EN UI
        const itemElement = document.querySelector(`[data-item-key="${itemKey}"]`);
        if (itemElement) {
            // Animar eliminación instantánea
            itemElement.style.transform = 'translateX(-100%)';
            itemElement.style.opacity = '0';
            itemElement.style.transition = 'all 0.3s ease-out';
            
            // Remover del DOM después de la animación
            setTimeout(() => {
                itemElement.remove();
                // Verificar si el carrito quedó vacío
                checkIfCartEmpty();
            }, 300);
        }

        // Procesar eliminación en servidor en segundo plano
        try {
            const response = await fetch('{{ route("tenant.cart.remove", $store->slug) }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ item_key: itemKey })
            });

            const data = await response.json();
            if (data.success) {
                // Recargar carrito para actualizar totales correctos
                setTimeout(() => {
                    loadCart();
                }, 400);
                // El carrito flotante se actualiza automáticamente vía cart.js
            } else {
                // Si falla, mostrar error y recargar carrito para restaurar estado
                showError(data.message || 'Error al eliminar producto');
                setTimeout(() => {
                    loadCart();
                }, 500);
            }
        } catch (error) {
            console.error('Error removing item:', error);
            showError('Error de conexión');
            // Si falla, recargar carrito para restaurar estado
            setTimeout(() => {
                loadCart();
            }, 500);
        }
    }
    
    // Función para verificar si el carrito quedó vacío después de eliminación
    function checkIfCartEmpty() {
        const remainingItems = document.querySelectorAll('#cart-items .cart-item');
        if (remainingItems.length === 0) {
            cartEmpty.classList.remove('hidden');
            cartItems.classList.add('hidden');
            cartSummary.classList.add('hidden');
            cartActions.classList.add('hidden');
        }
    }

    // Event listener para vaciar carrito
    document.getElementById('clear-cart-btn').addEventListener('click', async function() {
        Swal.fire({
            title: '¿Vaciar carrito?',
            text: 'Todos los productos serán eliminados del carrito',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#ed2e45',
            confirmButtonText: 'Sí, vaciar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch('{{ route("tenant.cart.clear", $store->slug) }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        loadCart();
                        // El carrito flotante se actualiza automáticamente vía cart.js
                        
                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Carrito vaciado!',
                            text: 'Todos los productos fueron eliminados',
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'OK',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al vaciar el carrito',
                            confirmButtonColor: '#ed2e45',
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (error) {
                    console.error('Error clearing cart:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al vaciar el carrito',
                        confirmButtonColor: '#ed2e45',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });

    // Checkout button is now a direct link - no JavaScript needed

    function formatPrice(price) {
        return new Intl.NumberFormat('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    }

    // Mostrar loading state en elemento específico
    function showItemLoading(itemElement, type) {
        if (type === 'quantity') {
            const decreaseBtn = itemElement.querySelector('.quantity-decrease');
            const increaseBtn = itemElement.querySelector('.quantity-increase');
            
            if (decreaseBtn && increaseBtn) {
                // Deshabilitar botones
                decreaseBtn.disabled = true;
                increaseBtn.disabled = true;
                
                // Ocultar íconos y mostrar spinners
                decreaseBtn.querySelector('svg').classList.add('hidden');
                increaseBtn.querySelector('svg').classList.add('hidden');
                decreaseBtn.querySelector('.loading-spinner').classList.remove('hidden');
                increaseBtn.querySelector('.loading-spinner').classList.remove('hidden');
            }
        } else if (type === 'remove') {
            const removeBtn = itemElement.querySelector('.remove-item');
            
            if (removeBtn) {
                // Deshabilitar botón
                removeBtn.disabled = true;
                
                // Ocultar ícono y mostrar spinner
                removeBtn.querySelector('svg').classList.add('hidden');
                removeBtn.querySelector('.loading-spinner').classList.remove('hidden');
            }
        }
    }

    // Ocultar loading state en elemento específico
    function hideItemLoading(itemElement, type) {
        if (type === 'quantity') {
            const decreaseBtn = itemElement.querySelector('.quantity-decrease');
            const increaseBtn = itemElement.querySelector('.quantity-increase');
            
            if (decreaseBtn && increaseBtn) {
                // Habilitar botones
                decreaseBtn.disabled = false;
                increaseBtn.disabled = false;
                
                // Mostrar íconos y ocultar spinners
                decreaseBtn.querySelector('svg').classList.remove('hidden');
                increaseBtn.querySelector('svg').classList.remove('hidden');
                decreaseBtn.querySelector('.loading-spinner').classList.add('hidden');
                increaseBtn.querySelector('.loading-spinner').classList.add('hidden');
            }
        } else if (type === 'remove') {
            const removeBtn = itemElement.querySelector('.remove-item');
            
            if (removeBtn) {
                // Habilitar botón
                removeBtn.disabled = false;
                
                // Mostrar ícono y ocultar spinner
                removeBtn.querySelector('svg').classList.remove('hidden');
                removeBtn.querySelector('.loading-spinner').classList.add('hidden');
            }
        }
    }

    function showError(message) {
        // Evitar spam de notificaciones
        const existingNotification = document.querySelector('.cart-page-error');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Mostrar notificación de error mejorada
        const notification = document.createElement('div');
        notification.className = 'cart-page-error fixed top-4 right-4 bg-brandError-300 text-brandWhite-100 px-4 py-3 rounded-lg shadow-lg z-50 max-w-sm transform transition-all duration-300 translate-x-full';
        notification.innerHTML = `
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div class="flex-1">
                    <span class="caption font-medium">${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-brandWhite-100 hover:text-brandWhite-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto-hide después de 4 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }, 4000);
    }
});
</script>
@endpush
@endsection