<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 space-y-6">


    <!-- Ticker de Promociones -->
    <?php if($tickers && $tickers->count() > 0 && $tickerConfig): ?>
        <?php
            $scrollSpeeds = [
                'slow' => 20,
                'medium' => 15,
                'fast' => 10
            ];
            $scrollDuration = $scrollSpeeds[$tickerConfig['scroll_speed']] ?? 15;
        ?>
        <div class="ticker-wrapper" 
             style="background-color: <?php echo e($tickerConfig['background_color']); ?>; color: <?php echo e($tickerConfig['text_color']); ?>;">
            <div class="ticker-container">
                <div class="flex items-center gap-2 py-3 px-4 whitespace-nowrap ticker-scroll" 
                     data-duration="<?php echo e($scrollDuration); ?>">
                    <?php $__currentLoopData = $tickers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold"><?php echo e($ticker->text); ?></span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php $__currentLoopData = $tickers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold"><?php echo e($ticker->text); ?></span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Slider de Novedades -->
    <?php if($sliders->count() > 0): ?>
        <div class="slider-container relative" x-data="sliderComponent(<?php echo e($sliders->toJson()); ?>, <?php echo e($sliders->first()->transition_duration ?? 5); ?>)">
            <!-- Slider principal -->
            <div class="overflow-hidden rounded-lg">
                <div class="flex gap-2 sm:gap-4" 
                     :style="getTransform()"
                     @transitionend="handleTransitionEnd()">
                    
                    <?php if($sliders->count() > 1): ?>
                        <!-- Duplicar último slide al inicio para efecto infinito -->
                        <?php $lastSlider = $sliders->last(); ?>
                        <div class="flex-shrink-0 relative flex justify-center w-full sm:w-auto">
                            <?php if($lastSlider->url && $lastSlider->url_type !== 'none'): ?>
                                <?php if($lastSlider->url_type === 'external'): ?>
                                    <a href="<?php echo e($lastSlider->url); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group w-full">
                                <?php else: ?>
                                    <a href="<?php echo e($lastSlider->url_type === 'internal' ? url($store->slug . '/' . ltrim($lastSlider->url, '/')) : '#'); ?>" 
                                       class="block relative group w-full">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="block relative group w-full">
                            <?php endif; ?>
                            
                            <!-- Imagen del slider - Responsive -->
                            <div class="w-full sm:w-[420px] h-[180px] sm:h-[200px] bg-accent-100 rounded-lg overflow-hidden relative">
                                <?php if($lastSlider->image_url): ?>
                                    <img src="<?php echo e($lastSlider->image_url); ?>" 
                                         alt="<?php echo e($lastSlider->name); ?>" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                                         style="image-rendering: auto; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                                <?php endif; ?>
                                
                                <!-- Overlay suave (solo si tiene enlace) -->
                                <?php if($lastSlider->url && $lastSlider->url_type !== 'none'): ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                <?php endif; ?>
                                
                                <!-- Indicador de enlace -->
                                <?php if($lastSlider->url && $lastSlider->url_type !== 'none'): ?>
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($lastSlider->url && $lastSlider->url_type !== 'none'): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Slides originales -->
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-shrink-0 relative flex justify-center w-full sm:w-auto">
                            <?php if($slider->url && $slider->url_type !== 'none'): ?>
                                <?php if($slider->url_type === 'external'): ?>
                                    <a href="<?php echo e($slider->url); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group w-full">
                                <?php else: ?>
                                    <a href="<?php echo e($slider->url_type === 'internal' ? url($store->slug . '/' . ltrim($slider->url, '/')) : '#'); ?>" 
                                       class="block relative group w-full">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="block relative group w-full">
                            <?php endif; ?>
                            
                            <!-- Imagen del slider - Responsive -->
                            <div class="w-full sm:w-[420px] h-[180px] sm:h-[200px] bg-accent-100 rounded-lg overflow-hidden relative">
                                <?php if($slider->image_url): ?>
                                    <img src="<?php echo e($slider->image_url); ?>" 
                                         alt="<?php echo e($slider->name); ?>" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                                         style="image-rendering: auto; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                                <?php endif; ?>
                                
                                <!-- Overlay suave (solo si tiene enlace) -->
                                <?php if($slider->url && $slider->url_type !== 'none'): ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                <?php endif; ?>
                                
                                <!-- Indicador de enlace -->
                                <?php if($slider->url && $slider->url_type !== 'none'): ?>
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($slider->url && $slider->url_type !== 'none'): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($sliders->count() > 1): ?>
                        <!-- Duplicar primer slide al final para efecto infinito -->
                        <?php $firstSlider = $sliders->first(); ?>
                        <div class="flex-shrink-0 relative flex justify-center w-full sm:w-auto">
                            <?php if($firstSlider->url && $firstSlider->url_type !== 'none'): ?>
                                <?php if($firstSlider->url_type === 'external'): ?>
                                    <a href="<?php echo e($firstSlider->url); ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group w-full">
                                <?php else: ?>
                                    <a href="<?php echo e($firstSlider->url_type === 'internal' ? url($store->slug . '/' . ltrim($firstSlider->url, '/')) : '#'); ?>" 
                                       class="block relative group w-full">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="block relative group w-full">
                            <?php endif; ?>
                            
                            <!-- Imagen del slider - Responsive -->
                            <div class="w-full sm:w-[420px] h-[180px] sm:h-[200px] bg-accent-100 rounded-lg overflow-hidden relative">
                                <?php if($firstSlider->image_url): ?>
                                    <img src="<?php echo e($firstSlider->image_url); ?>" 
                                         alt="<?php echo e($firstSlider->name); ?>" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                                         style="image-rendering: auto; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                                <?php endif; ?>
                                
                                <!-- Overlay suave (solo si tiene enlace) -->
                                <?php if($firstSlider->url && $firstSlider->url_type !== 'none'): ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                <?php endif; ?>
                                
                                <!-- Indicador de enlace -->
                                <?php if($firstSlider->url && $firstSlider->url_type !== 'none'): ?>
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($firstSlider->url && $firstSlider->url_type !== 'none'): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Indicadores (dots) - Solo si hay más de 1 slide -->
            <?php if($sliders->count() > 1): ?>
                <div class="flex justify-center mt-4 space-x-2">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button @click="goToSlide(<?php echo e($index); ?>)"
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="displaySlide === <?php echo e($index); ?> ? 'bg-primary-300 w-6' : 'bg-accent-300 hover:bg-accent-400'">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Categorías -->
    <div class="space-y-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-900">Categorías</h3>
            <a href="<?php echo e(route('tenant.categories', $store->slug)); ?>" 
               class="flex items-center gap-1 text-blue-700 hover:text-blue-800 transition-colors">
                <span class="text-base font-medium">Ver más</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-blue-700"></i>
            </a>
        </div>
        
        <?php if($categories->count() > 0): ?>
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
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug])); ?>" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la categoría con fondo colorido -->
                        <div class="w-72px h-72px mb-2 p-2 flex items-center justify-center rounded-2xl transition-all duration-200 hover:opacity-80" 
                             style="background-color: <?php echo e($categoryBgColor); ?>;">
                             <?php if($category->icon && $category->icon->image_url): ?>
                                 <img src="<?php echo e($category->icon->image_url); ?>" 
                                      alt="<?php echo e($category->name); ?>" 
                                      class="w-56px h-56px object-contain aspect-square"
                                      style="aspect-ratio: 1 / 1;">
                             <?php else: ?>
                                 <i data-lucide="image" class="w-56px h-56px text-brandNeutral-400 group-hover:text-brandPrimary-300"></i>
                             <?php endif; ?>
                        </div>
                        
                        <!-- Nombre de la categoría -->
                        <span class="text-xs font-normal text-slate-900 transition-colors leading-tight">
                            <?php echo e($category->name); ?>

                        </span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-8">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_gallery.svg" alt="img_linkiu_v1_gallery" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400">No hay categorías disponibles</p>
                <a href="<?php echo e(route('tenant.categories', $store->slug)); ?>" 
                   class="gap-2 inline-flex mt-3 px-4 py-2 bg-brandPrimary-300 text-brandWhite-100 rounded-lg text-body-lg-medium hover:bg-brandPrimary-400 transition-colors">
                    Ver todas las categorías
                    <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Top 3 más vendidos -->
    <div class="space-y-6">
        <h3 class="text-base font-semibold text-slate-900">Top 3 más vendidos</h3>
        
        <?php if($topProducts->count() > 0): ?>
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
                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                        $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                        $stockDisponible = $product->stock_disponible ?? 0;
                    ?>
                    <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative cursor-pointer" 
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
                                        <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                            <span class="text-base font-bold">
                                             🔥
                                            </span>
                                        </div>
                                        <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                            Queda <?php echo e($stockDisponible); ?> unidad<?php echo e($stockDisponible > 1 ? 'es' : ''); ?>

                                        </span>
                                        <?php if($product->categories->count() > 0): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php $__currentLoopData = $product->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                        <?php echo e($category->name); ?>

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
        <?php else: ?>
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos disponibles</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Lo más nuevo -->
    <div class="space-y-6">
        <h3 class="text-base font-semibold text-slate-900">Lo más nuevo</h3>
        
        <?php if($newProducts->count() > 0): ?>
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
                <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                            <span class="text-base font-bold">
                                            ✨
                                            </span>
                                        </div>
                                        <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                            Queda <?php echo e($stockDisponible); ?> unidad<?php echo e($stockDisponible > 1 ? 'es' : ''); ?>

                                        </span>
                                        <?php if($product->categories->count() > 0): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php $__currentLoopData = $product->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                        <?php echo e($category->name); ?>

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
        <?php else: ?>
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos nuevos disponibles</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<style>
    .ticker-wrapper {
        margin-bottom: 24px;
    }
    .ticker-container {
        overflow: hidden;
        width: 100%;
    }
    /* Asegurar que los margins se apliquen correctamente */
    .ticker-container {
        margin: inherit;
    }
    .ticker-scroll {
        display: inline-flex;
        white-space: nowrap;
        will-change: transform;
        animation: ticker-move linear infinite;
        width: max-content;
        box-sizing: content-box;
    }
    .ticker-scroll[data-duration="10"] {
        animation-duration: 10s;
    }
    .ticker-scroll[data-duration="15"] {
        animation-duration: 15s;
    }
    .ticker-scroll[data-duration="20"] {
        animation-duration: 20s;
    }
    @keyframes ticker-move {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function sliderComponent(sliders, duration = 5) {
    return {
        currentSlide: sliders.length > 1 ? 1 : 0, // Empezar en 1 porque el 0 es el duplicado del último
        sliders: sliders,
        duration: duration * 1000, // Convertir a milisegundos
        autoPlayInterval: null,
        isPlaying: true,
        maxSlide: 0,
        isMobile: false,
        isTransitioning: true,
        displaySlide: 0, // Índice mostrado al usuario (para indicadores)
        
        init() {
            this.checkViewport();
            
            if (this.sliders.length > 1) {
                this.startAutoPlay();
            }
            
            // Escuchar cambios de tamaño de ventana
            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.checkViewport();
                
                // Si cambió de móvil a desktop o viceversa, resetear posición
                if (wasMobile !== this.isMobile) {
                    if (this.sliders.length > 1) {
                        this.currentSlide = 1; // Resetear a primera posición real
                        this.displaySlide = 0;
                    } else {
                        this.currentSlide = 0;
                    }
                    // Forzar recálculo del transform
                    this.$nextTick(() => {
                        // Trigger re-render
                    });
                }
            });
        },
        
        checkViewport() {
            this.isMobile = window.innerWidth < 640; // sm breakpoint de Tailwind
        },
        
        getTransform() {
            // Calcular ancho dinámicamente según viewport
            const container = document.querySelector('.slider-container');
            if (!container) return 'transform: translateX(0px)';
            
            const isMobile = window.innerWidth < 640; // sm breakpoint
            const slideWidth = isMobile 
                ? window.innerWidth - 32 // w-full menos padding (px-4 = 16px cada lado)
                : 420; // w-[420px] en desktop
            const gap = isMobile ? 8 : 16; // gap-2 en móvil (8px), gap-4 en desktop (16px)
            const totalWidth = slideWidth + gap;
            
            const transition = this.isTransitioning ? 'transition: transform 0.5s ease-in-out;' : '';
            
            return `${transition} transform: translateX(-${this.currentSlide * totalWidth}px)`;
        },
        
        goToSlide(index) {
            // Ir al slide real (sumamos 1 porque el índice 0 es el duplicado)
            this.isTransitioning = true;
            this.currentSlide = index + 1;
            this.displaySlide = index;
            this.resetAutoPlay();
        },
        
        nextSlide() {
            this.isTransitioning = true;
            this.currentSlide++;
            this.displaySlide = ((this.currentSlide - 1) % this.sliders.length);
            this.resetAutoPlay();
        },
        
        handleTransitionEnd() {
            if (this.sliders.length <= 1) return;
            
            // Si llegamos al último duplicado (índice totalSlides + 1), saltar al inicio sin transición
            if (this.currentSlide === this.sliders.length + 1) {
                this.isTransitioning = false;
                this.currentSlide = 1;
                this.displaySlide = 0;
            }
            // Si estamos en el duplicado del inicio (índice 0), saltar al final sin transición
            else if (this.currentSlide === 0) {
                this.isTransitioning = false;
                this.currentSlide = this.sliders.length;
                this.displaySlide = this.sliders.length - 1;
            }
        },
        
        prevSlide() {
            if (this.sliders.length <= 1) return;
            
            this.isTransitioning = true;
            this.currentSlide--;
            
            if (this.currentSlide < 1) {
                this.currentSlide = this.sliders.length;
            }
            
            this.displaySlide = ((this.currentSlide - 1) % this.sliders.length);
            this.resetAutoPlay();
        },
        
        startAutoPlay() {
            if (this.sliders.length <= 1) return;
            
            this.autoPlayInterval = setInterval(() => {
                if (this.isPlaying) {
                    this.nextSlide();
                }
            }, this.duration);
        },
        
        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        },
        
        resetAutoPlay() {
            this.stopAutoPlay();
            this.startAutoPlay();
        },
        
        pauseAutoPlay() {
            this.isPlaying = false;
        },
        
        resumeAutoPlay() {
            this.isPlaying = true;
        }
    }
}


// Pausar auto-play cuando el usuario interactúa
document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.querySelector('.slider-container');
    
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', function() {
            const component = Alpine.$data(this);
            if (component && component.pauseAutoPlay) {
                component.pauseAutoPlay();
            }
        });
        
        sliderContainer.addEventListener('mouseleave', function() {
            const component = Alpine.$data(this);
            if (component && component.resumeAutoPlay) {
                component.resumeAutoPlay();
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/storefront/home.blade.php ENDPATH**/ ?>