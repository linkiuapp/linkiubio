<!-- Carrito flotante tipo Pill - Mobile First -->
<div id="cart-float" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-[360px] h-[88px] sm:w-[480px] bg-slate-900 rounded-full shadow-xl z-[1000] px-3 py-2 sm:px-4 sm:py-3 flex items-center">
    <div class="flex items-center justify-between gap-2 sm:gap-3 w-full">
        <!-- Icono carrito con badge -->
        <div class="relative flex-shrink-0">
            <!-- Animación cuando se agrega producto -->
            <img src="{{ asset('images-ui/emoji_toast_Linkiu_shop.svg') }}" alt="Emoji Linkiu Shop" class="w-16 h-16 object-cover">
            <!-- Badge contador -->
            <div class="animate-pulse cart-badge absolute -top-1 -right-1 border-2 border-white bg-red-600 text-white text-sm font-bold rounded-full min-w-[24px] h-[24px] sm:min-w-[20px] sm:h-5 flex items-center justify-center px-1" style="display: none;">
                0
            </div>
        </div>
        
        <!-- Información del carrito -->
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 min-w-0">
            <p class="cart-count-text caption text-white truncate">
                0 productos
            </p>
            <span class="hidden sm:inline text-white">•</span>
            <p class="cart-total-price h3 lg:h4 text-white truncate">
                $0
            </p>
        </div>
        
        <!-- Botones de acción - Responsive -->
        <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
            <a href="{{ route('tenant.cart.index', $store->slug ?? 'store') }}"
               class="view-cart-btn bg-rose-600 shadow-lg shadow-rose-600/50 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-full body-lg-medium flex items-center gap-1">
                <span>Ver Carrito</span>
                <i data-lucide="arrow-right" class="w-[16px] h-[16px] sm:w-[24px] sm:h-[24px] text-white"></i>
            </a>
        </div>
    </div>
</div>


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