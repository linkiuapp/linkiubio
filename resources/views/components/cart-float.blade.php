<!-- Carrito flotante tipo Pill - Mobile First -->
<div id="cart-float" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-[95%] max-w-[420px] bg-accent-50 border-2 border-accent-200 rounded-full shadow-xl z-[1000] px-3 py-2.5 sm:px-4 sm:py-3">
    <div class="flex items-center justify-between gap-2 sm:gap-3">
        <!-- Icono carrito con badge -->
        <div class="relative flex-shrink-0">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary-300 rounded-full flex items-center justify-center">
                <x-solar-bag-2-outline class="w-4 h-4 sm:w-5 sm:h-5 text-accent-50" />
            </div>
            <!-- Badge contador -->
            <div class="cart-badge absolute -top-1 -right-1 bg-error-300 text-accent-50 text-[10px] sm:text-caption font-bold rounded-full min-w-[18px] h-[18px] sm:min-w-[20px] sm:h-5 flex items-center justify-center px-1" style="display: none;">
                0
            </div>
        </div>
        
        <!-- Información del carrito -->
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 min-w-0">
            <p class="cart-count-text text-[12px] sm:text-caption font-bold text-black-400 truncate">
                0 productos
            </p>
            <span class="hidden sm:inline text-disabled-200">•</span>
            <p class="cart-total-price text-body-small sm:text-body-small font-bold text-black-500 truncate">
                $0
            </p>
        </div>
        
        <!-- Botones de acción - Responsive -->
        <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
            <a href="{{ route('tenant.cart.index', $store->slug ?? 'store') }}" 
               class="view-cart-btn bg-accent-200 text-black-500 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-[14px] sm:text-caption font-medium">
                Ver
            </a>
            <a href="{{ route('tenant.checkout.create', $store->slug ?? 'store') }}" 
               class="checkout-btn bg-secondary-300 text-accent-50 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-[14px] sm:text-caption font-medium flex items-center gap-1">
                <span>Comprar</span>
                <x-solar-arrow-right-outline class="w-3 h-3 sm:w-4 sm:h-4" />
            </a>
        </div>
    </div>
</div>

<!-- Spacer para que el contenido no quede oculto debajo del carrito -->
<div class="h-24"></div>

<script>
    // Script adicional para mejorar la experiencia del carrito
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar mensaje de carrito vacío
        function updateEmptyState() {
            const cartFloat = document.getElementById('cart-float');
            const emptyState = cartFloat?.querySelector('.cart-empty-state');
            const badge = cartFloat?.querySelector('.cart-badge');
            
            if (emptyState && badge) {
                const isEmpty = badge.style.display === 'none';
                emptyState.style.display = isEmpty ? 'block' : 'none';
            }
        }
        
        // Observar cambios en el badge para actualizar estado vacío
        const observer = new MutationObserver(updateEmptyState);
        const badge = document.querySelector('.cart-badge');
        
        if (badge) {
            observer.observe(badge, { 
                attributes: true, 
                attributeFilter: ['style'] 
            });
        }
        
        // Animación del badge cuando se actualiza (usando Tailwind)
        let lastBadgeCount = 0;
        setInterval(() => {
            const badge = document.querySelector('.cart-badge');
            if (badge && badge.textContent) {
                const currentCount = parseInt(badge.textContent);
                if (currentCount !== lastBadgeCount && currentCount > 0) {
                    badge.classList.add('animate-pulse');
                    setTimeout(() => badge.classList.remove('animate-pulse'), 600);
                    lastBadgeCount = currentCount;
                }
            }
        }, 500);
        
        // Llamar función inicial
        updateEmptyState();
    });
</script> 