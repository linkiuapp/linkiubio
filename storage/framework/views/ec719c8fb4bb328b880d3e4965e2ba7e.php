<?php $__env->startSection('content'); ?>
<div class="px-4 py-6 space-y-6">

    <h3 class="h3 text-brandNeutral-400">Nuestras promociones</h3>
    <!-- Slider de Novedades -->
    <?php if($sliders->count() > 0): ?>
        <div class="slider-container relative" x-data="sliderComponent(<?php echo e($sliders->toJson()); ?>, <?php echo e($sliders->first()->transition_duration ?? 5); ?>)">
            <!-- Slider principal -->
            <div class="overflow-hidden rounded-lg">
                <div class="flex gap-2 sm:gap-4 transition-transform duration-500 ease-in-out" 
                     :style="getTransform()">
                    
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
                    
                    <!-- Duplicar slides para efecto infinito (1 slide es suficiente ya que se muestra de 1 en 1) -->
                    <?php if($sliders->count() > 1): ?>
                        <?php $__currentLoopData = $sliders->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex-shrink-0 relative flex justify-center">
                                <?php if($slider->url && $slider->url_type !== 'none'): ?>
                                    <?php if($slider->url_type === 'external'): ?>
                                        <a href="<?php echo e($slider->url); ?>" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="block relative group">
                                    <?php else: ?>
                                        <a href="<?php echo e($slider->url_type === 'internal' ? url($store->slug . '/' . ltrim($slider->url, '/')) : '#'); ?>" 
                                           class="block relative group">
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="block relative group">
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
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-arrow-right-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-2 h-2 text-accent-50']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
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
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Indicadores (dots) - Solo si hay más de 1 slide -->
            <?php if($sliders->count() > 1): ?>
                <div class="flex justify-center mt-4 space-x-2">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button @click="goToSlide(<?php echo e($index); ?>)"
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="currentSlide === <?php echo e($index); ?> ? 'bg-primary-300 w-6' : 'bg-accent-300 hover:bg-accent-400'">
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Categorías -->
    <div>
        <h3 class="h3 text-brandNeutral-400 mb-4">Categorías</h3>
        
        <?php if($categories->count() > 0): ?>
            <div class="grid grid-cols-4 gap-2">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug])); ?>" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la categoría con fondo colorido -->
                        <div class="w-78px h-78 mb-2 p-2 flex items-center justify-center rounded-2xl bg-gradient-to-br from-brandWhite-100 to-brandWhite-100 hover:from-brandPrimary-100 hover:to-brandWhite-100 transition-all duration-200">
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
                        <span class="caption text-center text-brandNeutral-400 transition-colors leading-tight">
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
    <div>
        <h3 class="h3 text-brandNeutral-400 mb-8">Top 3 más vendidos</h3>
        
        <?php if($topProducts->count() > 0): ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                        $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                    ?>
                    <a href="<?php echo e(route('tenant.product', [$store->slug, $product->slug])); ?>" 
                       class="bg-brandWhite-100 hover:bg-brandPrimary-50 rounded-lg p-4 hover:shadow-sm transition-all duration-200 block relative <?php echo e($estaAgotado ? 'opacity-60' : ''); ?>">
                        
                       <!-- Badge MÁS VENDIDO -->
                        <div class="flex gap-1 items-center absolute -top-4 -left-2 bg-brandError-300 text-brandError-50 caption px-2 py-1 rounded-full z-10 shadow-sm">
                            <i data-lucide="flame" class="w-4 h-4 sm:w-24px sm:h-24px"></i>
                            MÁS VENDIDO
                        </div>

                        <!-- Badge de Stock -->
                        <?php if($estaAgotado): ?>
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-medium z-10">
                                Agotado
                            </div>
                        <?php elseif($tieneStockBajo): ?>
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-lg text-xs font-medium z-10 animate-pulse">
                                ¡Solo <?php echo e($product->stock_disponible); ?>!
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-[78px] h-[78px] rounded-lg flex-shrink-0 overflow-hidden">
                                <?php if($product->main_image_url): ?>
                                    <img src="<?php echo e($product->main_image_url); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-black-200">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-gallery-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="body-lg-bold text-brandNeutral-400 line-clamp-1"><?php echo e($product->name); ?></h3>
                                
                                <?php if($product->description): ?>
                                    <p class="caption text-brandNeutral-400 line-clamp-1"><?php echo e($product->description); ?></p>
                                <?php endif; ?>

                                <!-- Precio prominente -->
                                <div class="flex items-center gap-2 mb-1">
                                    <?php if($product->tienePromocionActiva()): ?>
                                        <span class="body-sm text-brandNeutral-300 line-through">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                        <span class="body-lg-bold text-brandError-400">$<?php echo e(number_format($product->precio_promocional, 0, ',', '.')); ?></span>
                                    <?php else: ?>
                                        <span class="body-lg-bold text-brandNeutral-400">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Categorías pequeñas -->
                                <?php if($product->categories->count() > 0): ?>
                                    <div class="flex flex-wrap gap-1">
                                        <?php $__currentLoopData = $product->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="px-2 py-0.5 bg-brandSuccess-50 text-brandSuccess-400 rounded-full caption">
                                                <?php echo e($category->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($product->categories->count() > 1): ?>
                                            <span class="bg-brandSuccess-50 px-2 py-0.5 caption items-center text-brandSuccess-400 rounded-full">+<?php echo e($product->categories->count() - +1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <!-- Botones de acción -->
                             <div class="flex flex-col gap-2">
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
                                    <button class="p-2 w-11 h-11 flex items-center justify-center transition-transform bg-brandError-50 hover:bg-brandError-300 rounded-lg hover:scale-110" 
                                            data-favorite-btn
                                            data-product-id="<?php echo e($product->id); ?>">
                                        <i data-lucide="heart" class="w-6 h-6 text-brandError-400 hover:text-brandError-50" style="fill: currentColor;"></i>
                                    </button>
                                <?php endif; ?>
                             </div>

                            
                        </div>
                    </a>
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
    <div>
        <h3 class="h3 text-brandNeutral-400 mb-8">Lo más nuevo</h3>
        
        <?php if($newProducts->count() > 0): ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tenant.product', [$store->slug, $product->slug])); ?>" 
                       class="bg-brandWhite-100 hover:bg-brandPrimary-50 rounded-lg p-4 hover:shadow-sm transition-all duration-200 block relative">
                        <!-- Badge NUEVO -->
                        <div class="flex items-center gap-1 absolute -top-2 -left-2 bg-brandSuccess-300 text-brandSuccess-50 caption px-2 py-1 rounded-full z-10 shadow-sm">
                            <i data-lucide="star" class="w-4 h-4 sm:w-24px sm:h-24px"></i> NUEVO
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-[78px] h-[78px] bg-accent-100 rounded-lg flex-shrink-0 overflow-hidden">
                                <?php if($product->main_image_url): ?>
                                    <img src="<?php echo e($product->main_image_url); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-brandNeutral-400">
                                        <i data-lucide="image" class="w-6 h-6 text-brandNeutral-400"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="body-lg-bold text-brandNeutral-400 line-clamp-1"><?php echo e($product->name); ?></h3>
                                
                                <?php if($product->description): ?>
                                    <p class="caption text-brandNeutral-400 line-clamp-1"><?php echo e($product->description); ?></p>
                                <?php endif; ?> 


                                <!-- Precio prominente -->
                                <div class="flex items-center gap-2">
                                    <?php if($product->tienePromocionActiva()): ?>
                                        <span class="body-sm text-brandNeutral-300 line-through">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                        <span class="body-lg-bold text-brandError-400">$<?php echo e(number_format($product->precio_promocional, 0, ',', '.')); ?></span>
                                    <?php else: ?>
                                        <span class="body-lg-bold text-brandNeutral-400">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Categorías pequeñas -->
                                <?php if($product->categories->count() > 0): ?>
                                    <div class="flex flex-wrap gap-1">
                                        <?php $__currentLoopData = $product->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="px-2 py-0.5 bg-brandSuccess-50 text-brandSuccess-400 rounded caption">
                                                <?php echo e($category->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($product->categories->count() > 1): ?>
                                            <span class="bg-brandSuccess-50 px-2 py-0.5 caption items-center text-brandSuccess-400 rounded-full">+<?php echo e($product->categories->count() - 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex flex-col gap-2">
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
                                    <button class="p-2 w-11 h-11 flex items-center justify-center transition-transform bg-brandError-50 hover:bg-brandError-300 rounded-lg hover:scale-110" 
                                            data-favorite-btn
                                            data-product-id="<?php echo e($product->id); ?>">
                                        <i data-lucide="heart" class="w-6 h-6 text-brandError-400 hover:text-brandError-50" style="fill: currentColor;"></i>
                                    </button>
                                <?php endif; ?>
                             </div>
                        </div>
                    </a>
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

<?php $__env->startPush('scripts'); ?>
<script>
function sliderComponent(sliders, duration = 5) {
    return {
        currentSlide: 0,
        sliders: sliders,
        duration: duration * 1000, // Convertir a milisegundos
        autoPlayInterval: null,
        isPlaying: true,
        maxSlide: 0,
        isMobile: false,
        
        init() {
            this.checkViewport();
            
            if (this.sliders.length > 1) {
                this.startAutoPlay();
            }
            
            // Escuchar cambios de tamaño de ventana
            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.checkViewport();
                
                // Si cambió de móvil a desktop o viceversa, resetear a slide 0
                if (wasMobile !== this.isMobile) {
                    this.currentSlide = 0;
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
            
            return `transform: translateX(-${this.currentSlide * totalWidth}px)`;
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.resetAutoPlay();
        },
        
        nextSlide() {
            this.currentSlide = this.currentSlide + 1;
            
            // Efecto infinito: si llegó al final, resetear sin transición
            if (this.currentSlide >= this.sliders.length) {
                setTimeout(() => {
                    const sliderElement = document.querySelector('.slider-container .flex');
                    if (sliderElement) {
                        sliderElement.style.transition = 'none';
                        this.currentSlide = 0;
                        
                        // Restaurar transición después de un frame
                        setTimeout(() => {
                            sliderElement.style.transition = 'transform 500ms ease-in-out';
                        }, 50);
                    }
                }, 500);
            }
            
            this.resetAutoPlay();
        },
        
        prevSlide() {
            if (this.currentSlide <= 0) {
                // Ir al final si está en el inicio
                this.currentSlide = this.maxSlide;
            } else {
                this.currentSlide = this.currentSlide - 1;
            }
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