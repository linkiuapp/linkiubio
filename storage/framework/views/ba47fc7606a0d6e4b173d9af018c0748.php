<?php $__env->startSection('content'); ?>
<div class="p-4 space-y-6">
    <!-- Header -->
    <div class="space-y-2">
        <nav class="flex text-xs md:text-sm font-medium text-slate-900">
            <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" class="text-blue-600 hover:text-blue-900 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-xs md:text-sm font-medium text-slate-900">Favoritos</span>
        </nav>
        
        <p class="text-base font-medium text-slate-900">Mis productos favoritos (<span id="favorites-count">0</span>)</p>
    </div>

        
    <div id="empty-favorites-state" class="hidden">
        <div class="flex flex-col items-center justify-center py-16 space-y-4">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" 
                 alt="Sin favoritos" 
                 class="h-32 w-auto" 
                 loading="lazy">
            <div class="text-center space-y-2">
                <h3 class="h3 text-brandNeutral-400">Aún no tienes favoritos</h3>
                <p class="caption text-brandNeutral-400 max-w-md mx-auto">
                    Explora nuestro catálogo y guarda tus productos preferidos para encontrarlos fácilmente
                </p>
            </div>
            <a href="<?php echo e(route('tenant.catalog', $store->slug)); ?>" 
               class="bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 px-6 py-3 rounded-lg caption transition-colors">
                Explorar Catálogo
            </a>
        </div>
    </div>

    
    <div id="favorites-grid" class="hidden space-y-4">
        
        <div class="flex items-center justify-between gap-4 p-3 bg-brandWhite-100 rounded-lg">
            <div class="flex items-center gap-2">
                <i data-lucide="heart" class="w-16px h-16px text-brandError-400"></i>
                <span class="caption-strong text-brandNeutral-400">Tus productos guardados</span>
            </div>
            <button id="clear-all-favorites-btn" 
                    class="caption text-brandError-400 hover:text-brandError-500 transition-colors">
                Limpiar todos
            </button>
        </div>

        
        <div id="favorites-products-grid" class="space-y-4">
            
        </div>
    </div>

    
    <div id="loading-favorites" class="flex flex-col items-center justify-center py-16">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brandPrimary-300"></div>
        <p class="caption text-brandNeutral-400 mt-4">Cargando favoritos...</p>
    </div>
</div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Calcular color de fondo de las cards (igual que en catálogo)
        <?php
            $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
            if (strpos($bgColor, '#') === 0) {
                $hex = str_replace('#', '', $bgColor);
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $cardBgColor = "rgba($r, $g, $b, 0.1)";
            } else {
                $cardBgColor = $bgColor;
            }
        ?>
        window.FAVORITES_CARD_BG_COLOR = '<?php echo e($cardBgColor); ?>';
        
        // Cargar favoritos al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Esperar a que loadFavoritesPage esté disponible
            const checkAndLoad = () => {
                if (typeof window.loadFavoritesPage === 'function') {
                    window.loadFavoritesPage('<?php echo e($store->slug); ?>');
                } else {
                    // Reintentar después de un breve delay
                    setTimeout(checkAndLoad, 100);
                }
            };
            checkAndLoad();
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/favorites/index.blade.php ENDPATH**/ ?>