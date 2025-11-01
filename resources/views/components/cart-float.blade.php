<!-- Carrito flotante tipo Pill - Mobile First -->
<div id="cart-float" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-[360px] h-[88px] bg-brandWhite-50 rounded-full shadow-xl z-[1000] px-3 py-2 sm:px-4 sm:py-3 flex items-center">
    <div class="flex items-center justify-between gap-2 sm:gap-3 w-full">
        <!-- Icono carrito con badge -->
        <div class="relative flex-shrink-0">
            <div class="w-[56px] h-[56px] bg-brandSecondary-300 rounded-full flex items-center justify-center">
                <!-- Animación cuando se agrega producto -->
                <lord-icon
                    src="https://cdn.lordicon.com/qfijwmqj.json"
                    trigger="loop"
                    stroke="bold"
                    colors="primary:#f2f1fd,secondary:#f2f1fd"
                    style="width:40px;height:40px">
                </lord-icon>
            </div>
            <!-- Badge contador -->
            <div class="pl-24px cart-badge absolute -top-1 -right-1 border-2 border-brandWhite-300 bg-brandError-300 text-brandError-50 body-lg-bold rounded-full min-w-[24px] h-[24px] sm:min-w-[20px] sm:h-5 flex items-center justify-center px-1" style="display: none;">
                0
            </div>
        </div>
        
        <!-- Información del carrito -->
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 min-w-0">
            <p class="cart-count-text caption text-brandNeutral-400 truncate">
                0 productos
            </p>
            <span class="hidden sm:inline text-brandNeutral-400">•</span>
            <p class="cart-total-price h3 text-brandNeutral-400 truncate">
                $0
            </p>
        </div>
        
        <!-- Botones de acción - Responsive -->
        <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
            <a href="{{ route('tenant.checkout.create', $store->slug ?? 'store') }}" 
               class="checkout-btn bg-brandPrimary-300 text-brandWhite-100 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full body-lg-medium flex items-center gap-1">
                <span>Ver Carrito</span>
                <i data-lucide="arrow-right" class="w-[16px] h-[16px] sm:w-[24px] sm:h-[24px] text-brandWhite-50"></i>
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