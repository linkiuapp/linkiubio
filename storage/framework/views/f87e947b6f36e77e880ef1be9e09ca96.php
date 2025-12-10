<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($store->name ?? 'Linkiu Store'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="store-slug" content="<?php echo e($store->slug); ?>">
    <meta name="asset-url" content="<?php echo e(asset('')); ?>">

    <?php if($store->design && $store->design->favicon_url): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo e($store->design->favicon_url); ?>">
    <?php endif; ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Lordicon -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>
<body class="bg-brandWhite-50 md:max-w-[480px] max-w-full mx-auto overflow-x-hidden">
    
    <?php if (isset($component)) { $__componentOriginal62641c3f5209c19b58f8f690f6fd135d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62641c3f5209c19b58f8f690f6fd135d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.maintenance-notice','data' => ['variant' => 'tenant']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('maintenance-notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'tenant']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62641c3f5209c19b58f8f690f6fd135d)): ?>
<?php $attributes = $__attributesOriginal62641c3f5209c19b58f8f690f6fd135d; ?>
<?php unset($__attributesOriginal62641c3f5209c19b58f8f690f6fd135d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62641c3f5209c19b58f8f690f6fd135d)): ?>
<?php $component = $__componentOriginal62641c3f5209c19b58f8f690f6fd135d; ?>
<?php unset($__componentOriginal62641c3f5209c19b58f8f690f6fd135d); ?>
<?php endif; ?>

    <!-- Header -->
    <header class="relative overflow-hidden" style="background: <?php echo e($store->design ? $store->design->header_background_color : ''); ?>">
        <div class="px-6 py-16 text-center">

            <!-- Logo -->
            <div class="mb-2">
                <div class="mx-auto flex items-center justify-center">
                    <?php if($store->design && $store->design->logo_url): ?>
                        <div class="relative inline-block border-4 border-brandWhite-300 rounded-full">
                            <img src="<?php echo e($store->design->logo_url); ?>" 
                                 alt="Logo" 
                                 class="w-[130px] h-[130px] md:w-[150px] md:h-[150px] rounded-full object-cover border-6 border-brandWhite-300">
                            <?php if($store->verified): ?>
                                <a href="<?php echo e(route('tenant.verified', $store->slug)); ?>" class="absolute bottom-2 border-2 border-brandInfo-300 left-24 bg-brandInfo-50 rounded-full p-1 shadow-lg" title="Tienda verificada">
                                    <i data-lucide="badge-check" class="w-16px h-16px text-brandInfo-400"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('tenant.verified', $store->slug)); ?>" class="absolute bottom-2 border-2 border-brandNeutral-300 left-24 bg-brandNeutral-50 rounded-full p-2 shadow-lg" title="Tienda no verificada">
                                    <i data-lucide="badge-x" class="w-16px h-16px text-brandNeutral-400"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Nombre de la tienda y badge de verificación -->
            <div class="flex items-center gap-2 justify-center mb-2">
                <h1 class="h1 capitalize" style="color: <?php echo e($store->design ? $store->design->header_text_color : '#ffffff'); ?>">
                    <?php echo e($store->name ?? 'Linkiu Store'); ?>

                </h1>
            </div>            

            <!-- Descripción -->
            <p class="body-small text-center" style="color: <?php echo e($store->design ? $store->design->header_description_color : '#e9d5ff'); ?>">
                <?php echo e($store->description ?? 'Comidas Rápidas en Sincelejo'); ?>

            </p>
        </div>
    </header>

    <!-- Menu inferior -->
    <nav class="max-w-full md:max-w-[480px] bg-brandWhite-100 rounded-b-3xl px-6 sm:px-10 py-4 flex">
        <div class="flex items-center justify-center gap-1 w-full md:w-auto">

            <!-- Contacto (Sedes) -->
            <a href="<?php echo e(route('tenant.contact', $store->slug)); ?>" 
               class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.contact') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                <i data-lucide="building-2" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Sedes</span>
            </a>

            <!-- Catálogo -->
            <a href="<?php echo e(route('tenant.catalog', $store->slug)); ?>" 
               class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.catalog') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                <i data-lucide="shopping-basket" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Catálogo</span>
            </a>

            <!-- Inicio -->
            <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" 
               class="flex flex-col gap-1 jusitfy-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.home') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                <i data-lucide="store" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Inicio</span>
            </a>

            <!-- Promos -->
            <a href="<?php echo e(route('tenant.promotions', $store->slug)); ?>" 
               class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.promotions') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                <i data-lucide="badge-percent" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Promos</span>
            </a>

            <!-- Reservas (cambia según categoría de negocio) -->
            <?php if(featureEnabled($store, 'reservas_mesas') && featureEnabled($store, 'reservas_hotel')): ?>
                
                <a href="<?php echo e(route('tenant.reservations.select-type', $store->slug)); ?>" 
                   class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.reservations.*') || request()->routeIs('tenant.hotel-reservations.*') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                    <i data-lucide="calendar-heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                    <span class="body-small sm:body-lg">Reservas</span>
                </a>
            <?php elseif(featureEnabled($store, 'reservas_mesas')): ?>
                <a href="<?php echo e(route('tenant.reservations.index', $store->slug)); ?>" 
                   class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.reservations.*') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                    <i data-lucide="calendar-heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                    <span class="body-small sm:body-lg">Reservas</span>
                </a>
            <?php elseif(featureEnabled($store, 'reservas_hotel')): ?>
                <a href="<?php echo e(route('tenant.hotel-reservations.index', $store->slug)); ?>" 
                   class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.hotel-reservations.*') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                    <i data-lucide="calendar-heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                    <span class="body-small sm:body-lg">Reservas</span>
                </a>
            <?php elseif(featureEnabled($store, 'favoritos')): ?>
                <a href="<?php echo e(route('tenant.favorites.index', $store->slug)); ?>" 
                   class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] relative <?php echo e(request()->routeIs('tenant.favorites.*') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                    <i data-lucide="heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                    <span class="body-small sm:body-lg">Favoritos</span>
                    
                    <span id="favorites-menu-badge" class="hidden absolute -top-1 -right-1 bg-brandError-400 text-brandWhite-50 text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
                </a>
            <?php else: ?>
                <!-- Fallback: coming soon si no tiene ningún feature -->
                <a href="<?php echo e(route('tenant.coming-soon', $store->slug)); ?>" 
                   class="flex flex-col gap-1 justify-center items-center py-3 px-2 min-w-[70px] <?php echo e(request()->routeIs('tenant.coming-soon') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl'); ?> transition-colors">
                    <i data-lucide="calendar-heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                    <span class="body-small sm:body-lg">Reservas</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
        
        <!-- Footer -->
        <?php echo $__env->make('frontend.components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </main>

    <!-- Verificación de la tienda -->
    <script>
        function verificationBadge() {
            return {
                verified: <?php echo e($store->verified ? 'true' : 'false'); ?>,

                startPolling() {
                    // Consultar cada 3 segundos
                    setInterval(() => {
                        this.checkVerificationStatus();
                    }, 3000);
                },

                async checkVerificationStatus() {
                    try {
                        const response = await fetch('<?php echo e(route("tenant.verification-status", $store->slug)); ?>');
                        const data = await response.json();
                        this.verified = data.verified;
                    } catch (error) {
                        // Error silencioso - no afecta funcionalidad
                    }
                }
            }
        }
    </script>

    <!-- Carrito flotante (solo en páginas de navegación) -->
    <?php if (! (request()->routeIs(['tenant.cart.index', 'tenant.checkout.*']))): ?>
        <?php if (isset($component)) { $__componentOriginal46b97128ca05743dfc4aa7f995b76ffa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46b97128ca05743dfc4aa7f995b76ffa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-float','data' => ['store' => $store]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-float'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['store' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46b97128ca05743dfc4aa7f995b76ffa)): ?>
<?php $attributes = $__attributesOriginal46b97128ca05743dfc4aa7f995b76ffa; ?>
<?php unset($__attributesOriginal46b97128ca05743dfc4aa7f995b76ffa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46b97128ca05743dfc4aa7f995b76ffa)): ?>
<?php $component = $__componentOriginal46b97128ca05743dfc4aa7f995b76ffa; ?>
<?php unset($__componentOriginal46b97128ca05743dfc4aa7f995b76ffa); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html> <?php /**PATH C:\laragon\www\Liniu_Final\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>