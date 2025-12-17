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
    
    
    <?php echo $__env->yieldPushContent('styles'); ?>
    
    
    <style>
        body {
            position: relative;
            background: #ffffff;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            height: 100vh;
            background: linear-gradient(to bottom, <?php
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad 50%
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    echo "rgba($r, $g, $b, 0.4)";
                } else {
                    echo $bgColor;
                }
            ?>, #ffffff);
            filter: blur(180px);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="md:max-w-[480px] max-w-full mx-auto overflow-x-hidden">
    
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
    <header class="z-[9999] overflow-hidden max-w-[348px] md:max-w-[450px] mx-auto rounded-t-3xl mt-[40px]" style="background: <?php echo e($store->design ? $store->design->header_background_color : ''); ?>">
        <div class="px-2 py-8 flex items-center justify-center gap-2 md:gap-6">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <?php if($store->design && $store->design->logo_url): ?>
                    <div class="relative inline-block border-4 border-white rounded-full">
                        <img src="<?php echo e($store->design->logo_url); ?>" 
                             alt="Logo" 
                             class="w-[80px] h-[80px] rounded-full object-cover border-6 border-brandWhite-300">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Contenido: Nombre, Badge y Descripción -->
            <div class="flex flex-col min-w-0">
                <!-- Nombre de la tienda y badge de verificación -->
                <div class="flex items-center gap-1">
                    <h1 class="text-[24px] font-extrabold capitalize truncate" style="color: <?php echo e($store->design ? $store->design->header_text_color : '#ffffff'); ?>">
                        <?php echo e($store->name ?? 'Nombre de la tienda'); ?>

                    </h1>
                    <?php if($store->verified): ?>
                        <a href="<?php echo e(route('tenant.verified', $store->slug)); ?>" 
                           class="flex-shrink-0" 
                           title="Tienda verificada">
                            <svg class="w-[24px] h-[24px] text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('tenant.verified', $store->slug)); ?>" 
                           class="flex-shrink-0" 
                           title="Tienda no verificada">
                           <svg class="w-[24px] h-[24px] text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Descripción -->
                <p class="text-[14px] truncate" style="color: <?php echo e($store->design ? $store->design->header_description_color : '#e9d5ff'); ?>">
                    <?php echo e($store->description ?? 'Descripción de la tienda'); ?>

                </p>
            </div>
        </div>
    </header>

    <!-- Menu inferior -->
    <nav class="max-w-[348px] md:max-w-[450px] w-full mx-auto bg-white rounded-b-3xl px-4 py-4 flex items-center justify-around">
        <!-- Contacto (Sedes) -->
        <a href="<?php echo e(route('tenant.contact', $store->slug)); ?>" 
           class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.contact') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
            <?php if(request()->routeIs('tenant.contact')): ?>
                <i data-lucide="store" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Sedes</span>
            <?php else: ?>
                <i data-lucide="store" class="w-6 h-6"></i>
            <?php endif; ?>
        </a>

        <!-- Catálogo / Menú -->
        <a href="<?php echo e(route('tenant.catalog', $store->slug)); ?>" 
           class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.catalog') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
            <?php if(request()->routeIs('tenant.catalog')): ?>
                <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                    <i data-lucide="utensils-crossed" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Menú</span>
                <?php else: ?>
                    <i data-lucide="shopping-bag" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Catálogo</span>
                <?php endif; ?>
            <?php else: ?>
                <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                    <i data-lucide="utensils-crossed" class="w-6 h-6"></i>
                <?php else: ?>
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                <?php endif; ?>
            <?php endif; ?>
        </a>

        <!-- Inicio -->
        <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" 
           class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.home') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
            <?php if(request()->routeIs('tenant.home')): ?>
                <i data-lucide="layout-grid" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Inicio</span>
            <?php else: ?>
                <i data-lucide="layout-grid" class="w-6 h-6"></i>
            <?php endif; ?>
        </a>

        <!-- Promos -->
        <a href="<?php echo e(route('tenant.promotions', $store->slug)); ?>" 
           class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.promotions') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
            <?php if(request()->routeIs('tenant.promotions')): ?>
                <i data-lucide="party-popper" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Promos</span>
            <?php else: ?>
                <i data-lucide="party-popper" class="w-6 h-6"></i>
            <?php endif; ?>
        </a>

        <!-- Reservas o Favoritos (cambia según categoría de negocio) -->
        <?php if(featureEnabled($store, 'reservas_mesas') && featureEnabled($store, 'reservas_hotel')): ?>
            <a href="<?php echo e(route('tenant.reservations.select-type', $store->slug)); ?>" 
               class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.reservations.*') || request()->routeIs('tenant.hotel-reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
                <?php if(request()->routeIs('tenant.reservations.*') || request()->routeIs('tenant.hotel-reservations.*')): ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    <?php endif; ?>
                    <span class="text-sm font-medium">Reservas</span>
                <?php else: ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php elseif(featureEnabled($store, 'reservas_mesas')): ?>
            <a href="<?php echo e(route('tenant.reservations.index', $store->slug)); ?>" 
               class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
                <?php if(request()->routeIs('tenant.reservations.*')): ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    <?php endif; ?>
                    <span class="text-sm font-medium">Reservas</span>
                <?php else: ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php elseif(featureEnabled($store, 'reservas_hotel')): ?>
            <a href="<?php echo e(route('tenant.hotel-reservations.index', $store->slug)); ?>" 
               class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.hotel-reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
                <?php if(request()->routeIs('tenant.hotel-reservations.*')): ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    <?php endif; ?>
                    <span class="text-sm font-medium">Reservas</span>
                <?php else: ?>
                    <?php if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant'): ?>
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    <?php else: ?>
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php elseif(featureEnabled($store, 'favoritos')): ?>
            <a href="<?php echo e(route('tenant.favorites.index', $store->slug)); ?>" 
               class="flex items-center justify-center p-2 relative <?php echo e(request()->routeIs('tenant.favorites.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
                <?php if(request()->routeIs('tenant.favorites.*')): ?>
                    <i data-lucide="heart" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Favoritos</span>
                <?php else: ?>
                    <i data-lucide="heart" class="w-6 h-6"></i>
                <?php endif; ?>
                
                <span id="favorites-menu-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
            </a>
        <?php else: ?>
            <!-- Fallback: coming soon si no tiene ningún feature -->
            <a href="<?php echo e(route('tenant.coming-soon', $store->slug)); ?>" 
               class="flex items-center justify-center p-2 <?php echo e(request()->routeIs('tenant.coming-soon') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900'); ?> transition-colors">
                <?php if(request()->routeIs('tenant.coming-soon')): ?>
                    <i data-lucide="app-window" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Apps</span>
                <?php else: ?>
                    <i data-lucide="app-window" class="w-6 h-6"></i>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </nav>

    <!-- Contenido principal -->
    <main class="relative z-0">
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