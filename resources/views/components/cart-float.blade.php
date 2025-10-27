<!-- Carrito flotante tipo Pill -->
<div id="cart-float" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-accent-50 border-2 border-accent-200 rounded-full shadow-xl z-[1000] px-4 py-3">
    <div class="flex items-center gap-4">
        <!-- Icono carrito con badge -->
        <div class="relative flex-shrink-0">
            <div class="w-10 h-10 bg-primary-300 rounded-full flex items-center justify-center">
                <x-solar-bag-2-outline class="w-5 h-5 text-accent-50" />
            </div>
            <!-- Badge contador -->
            <div class="cart-badge absolute -top-1 -right-1 bg-error-300 text-accent-50 text-caption font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5" style="display: none;">
                0
            </div>
        </div>
        
        <!-- Información del carrito -->
        <div class="flex items-center gap-3">
            <p class="cart-count-text text-caption font-bold text-black-400 whitespace-nowrap">
                0 productos
            </p>
            <span class="text-disabled-200">•</span>
            <p class="cart-total-price text-body-small font-bold text-black-500 whitespace-nowrap">
                $0
            </p>
        </div>
        
        <!-- Separador vertical -->
        <div class="w-px h-8 bg-accent-200"></div>
        
        <!-- Botones de acción -->
        <div class="flex items-center gap-2">
            <a href="{{ route('tenant.cart.index', $store->slug ?? 'store') }}" 
               class="view-cart-btn bg-accent-200 text-black-500 px-4 py-2 rounded-full text-caption font-bold whitespace-nowrap">
                Ver
            </a>
            <a href="{{ route('tenant.checkout.create', $store->slug ?? 'store') }}" 
               class="checkout-btn bg-secondary-300 text-accent-50 px-4 py-2 rounded-full text-caption font-bold flex items-center gap-1.5 whitespace-nowrap">
                <span>Comprar</span>
                <x-solar-arrow-right-outline class="w-4 h-4" />
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