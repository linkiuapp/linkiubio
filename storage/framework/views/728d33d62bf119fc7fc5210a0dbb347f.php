<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 space-y-6">
    <!-- Breadcrumbs -->
    <nav class="flex flex-wrap items-center caption text-brandInfo-300 gap-1">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Si el breadcrumb es 'Categorías', forzar la URL al catálogo general de categorías
                $isCategories = Str::lower($breadcrumb['name']) === 'categorías';
                $breadcrumbUrl = $isCategories 
                    ? route('tenant.catalog', $store->slug) 
                    : $breadcrumb['url'];
            ?>

            <?php if($breadcrumbUrl): ?>
                <a href="<?php echo e($breadcrumbUrl); ?>" class="hover:text-brandInfo-400 transition-colors">
                    <?php echo e($breadcrumb['name']); ?>

                </a>
                <?php if($index < count($breadcrumbs) - 1): ?>
                    <span class="mx-1">/</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-brandNeutral-500 caption-strong"><?php echo e($breadcrumb['name']); ?></span>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <!-- Header de la categoría -->
    <div class="space-y-2">
        <div class="flex items-center space-x-3">
            <!-- Icono de la categoría -->
            <?php if($category->icon && $category->icon->image_url): ?>
                <div class="w-12 h-12 bg-brandWhite-100 rounded-lg p-2 flex items-center justify-center">
                    <img src="<?php echo e($category->icon->image_url); ?>" 
                         alt="<?php echo e($category->name); ?>" 
                         class="w-full h-full object-contain">
                </div>
            <?php endif; ?>
            
            <div class="flex-1">
                <h1 class="h3 text-brandNeutral-400"><?php echo e($category->name); ?></h1>
                <?php if($category->description): ?>
                    <p class="text-brandNeutral-400 mt-1 caption"><?php echo e($category->description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Subcategorías -->
    <?php if($subcategories->count() > 0): ?>
        <div class="space-y-6">
            <h2 class="text-base font-semibold text-slate-900">Subcategorías</h2>
            
            <?php
                // Calcular el color de fondo de las categorías una sola vez
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $categoryBgColor = "rgba($r, $g, $b, 0.1)";
                } else {
                    $categoryBgColor = $bgColor;
                }
            ?>
            <div class="grid grid-cols-4 gap-2">
                <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tenant.category', [$store->slug, $subcategory->slug])); ?>" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la subcategoría con fondo colorido -->
                        <div class="w-72px h-72px mb-2 p-2 flex items-center justify-center rounded-2xl transition-all duration-200 hover:opacity-80" 
                             style="background-color: <?php echo e($categoryBgColor); ?>;">
                             <?php if($subcategory->icon && $subcategory->icon->image_url): ?>
                                 <img src="<?php echo e($subcategory->icon->image_url); ?>" 
                                      alt="<?php echo e($subcategory->name); ?>" 
                                      class="w-56px h-56px object-contain aspect-square"
                                      style="aspect-ratio: 1 / 1;">
                             <?php else: ?>
                                 <i data-lucide="image" class="w-56px h-56px text-brandNeutral-400 group-hover:text-brandPrimary-300"></i>
                             <?php endif; ?>
                        </div>

                        <!-- Nombre de la subcategoría -->
                        <span class="text-xs font-normal text-slate-900 transition-colors leading-tight">
                            <?php echo e($subcategory->name); ?>

                        </span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Productos -->
    <?php if($products->count() > 0): ?>
        <div class="space-y-6">
            <h2 class="text-base font-semibold text-slate-900">
                Productos
                <span class="text-sm font-normal text-slate-600">(<?php echo e($products->count()); ?>)</span>
            </h2>
            
            <?php
                // Calcular el color de fondo de las cards una sola vez
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad
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
            <div class="space-y-4">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                        $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                        $stockDisponible = $product->stock_disponible ?? 0;
                    ?>
                    <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative" 
                         style="background-color: <?php echo e($cardBgColor); ?>;">
                        <div class="flex items-center gap-4">
                            <!-- Imagen del producto -->
                            <div class="w-[120px] h-[120px] md:w-[126px] md:h-[126px] rounded-lg flex-shrink-0 overflow-hidden">
                                <?php if($product->main_image_url): ?>
                                    <img src="<?php echo e($product->main_image_url); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0 flex flex-col md:gap-1 gap-0">
                                <!-- Badge de Stock bajo -->
                                <?php if($tieneStockBajo && $stockDisponible > 0): ?>
                                    <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                        <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                            Queda <?php echo e($stockDisponible); ?> unidad<?php echo e($stockDisponible > 1 ? 'es' : ''); ?>

                                        </span>
                                        <?php if($product->categories->count() > 1): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php $__currentLoopData = $product->categories->where('id', '!=', $category->id)->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                        <?php echo e($cat->name); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif($estaAgotado): ?>
                                    <div class="flex items-center gap-1.5 w-fit">
                                        <span class="text-xs font-medium text-white bg-red-500 px-2 py-0.5 rounded-full">
                                            Agotado
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Título del producto -->
                                <h3 class="text-base font-bold text-slate-900 leading-tight"><?php echo e($product->name); ?></h3>
                                
                                <!-- Descripción -->
                                <?php if($product->description): ?>
                                    <p class="text-xs font-normal text-slate-900 leading-tight line-clamp-1"><?php echo e($product->description); ?></p>
                                <?php endif; ?>

                                <!-- Precios -->
                                <div class="flex items-center gap-2">
                                    <?php if($product->tienePromocionActiva()): ?>
                                        <span class="text-base font-normal text-slate-900 line-through">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                        <span class="text-base font-bold text-slate-900">$<?php echo e(number_format($product->precio_promocional, 0, ',', '.')); ?></span>
                                    <?php else: ?>
                                        <span class="text-base font-bold text-slate-900">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Botones de acción -->
                                <div class="flex gap-2 items-center md:mt-0 mt-2">
                                    <?php if (isset($component)) { $__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.add-to-cart-button','data' => ['product' => $product,'store' => $store]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('add-to-cart-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'store' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0)): ?>
<?php $attributes = $__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0; ?>
<?php unset($__attributesOriginal0ebc6ef07b571ddf6bdd9d88111343c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0)): ?>
<?php $component = $__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0; ?>
<?php unset($__componentOriginal0ebc6ef07b571ddf6bdd9d88111343c0); ?>
<?php endif; ?>
                                    <?php if(featureEnabled($store, 'favoritos')): ?>
                                        <button class="p-3 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110" 
                                                data-favorite-btn
                                                data-product-id="<?php echo e($product->id); ?>">
                                            <i data-lucide="heart" class="w-6 h-6 text-red-500 hover:text-red-600" style="fill: currentColor;"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Estado: Sin productos -->
        <?php if($subcategories->count() == 0): ?>
            <div class="text-center py-12 space-y-4 max-w-sm mx-auto">
                <div class="space-y-2 text-center flex flex-col items-center mx-auto">
                    <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
                    <h3 class="h3 text-brandNeutral-400">No hay productos en esta categoría</h3>
                    <p class="caption text-brandNeutral-300 max-w-sm mx-auto">
                        Aún no tenemos productos disponibles en esta categoría. 
                        Explora otras categorías o regresa pronto.
                    </p>
                </div>
                <div class="flex w-full flex-col-2 gap-3 items-center">
                    <a href="<?php echo e(route('tenant.catalog', $store->slug)); ?>" 
                       class="flex-1 flex justify-center items-center px-4 py-2 bg-brandPrimary-300 text-brandWhite-50 rounded-lg hover:bg-brandPrimary-400 transition-colors">
                        <i data-lucide="shopping-basket" class="w-6 h-6 mr-2"></i>
                        Ver catálogo
                    </a>
                    <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" 
                       class="flex-1 flex justify-center items-center px-4 py-2 bg-brandSecondary-300 text-brandWhite-50 rounded-lg hover:bg-brandSecondary-400 transition-colors">
                        <i data-lucide="home" class="w-6 h-6 mr-2"></i>
                        Ir al inicio
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/storefront/category.blade.php ENDPATH**/ ?>