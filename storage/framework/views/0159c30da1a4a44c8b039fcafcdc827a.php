<?php $__env->startSection('content'); ?>
<div class="p-4 space-y-4">
    <!-- Breadcrumb -->
    <nav class="flex caption text-brandInfo-300">
        <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
        <span class="mx-1">/</span>
        <a href="<?php echo e(route('tenant.catalog', $store->slug)); ?>" class="hover:text-brandInfo-400 transition-colors">Catálogo</a>
        <span class="mx-1">/</span>
        <span class="text-brandNeutral-400 caption-strong"><?php echo e($product->name); ?></span>
    </nav>

    <!-- Producto Principal -->
    <div class="bg-brandWhite-100 rounded-lg p-4 space-y-4">
        <!-- Imagen Principal -->
        <div class="w-full aspect-square sm:h-72 bg-brandWhite-100 rounded-xl overflow-hidden mb-3" id="main-image-container">
            <?php if($product->images->count() > 0): ?>
                <img src="<?php echo e($product->images->first()->image_url); ?>" 
                     alt="<?php echo e($product->name); ?>" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            <?php elseif($product->main_image_url): ?>
                <img src="<?php echo e($product->main_image_url); ?>" 
                     alt="<?php echo e($product->name); ?>" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-brandNeutral-200">
                    <i data-lucide="gallery" class="w-16 h-16 text-brandNeutral-200"></i>
                </div>
            <?php endif; ?>
        </div>

        <!-- Galería de miniaturas (solo si hay más de 1 imagen) -->
        <?php if($product->images->count() > 1): ?>
            <div class="space-y-2">
                <p class="caption text-brandNeutral-400">Imágenes (<?php echo e($product->images->count()); ?>)</p>
                <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="w-20 h-20 sm:w-16 sm:h-16 bg-brandPrimary-50 rounded-lg overflow-hidden flex-shrink-0 cursor-pointer border-2 transition-all duration-200 image-thumb <?php echo e($index === 0 ? 'border-brandPrimary-300' : 'border-transparent hover:border-brandPrimary-200'); ?>" 
                             onclick="changeMainImage('<?php echo e($image->image_url); ?>', <?php echo e($index); ?>)">
                            <img src="<?php echo e($image->image_url); ?>" 
                                 alt="<?php echo e($product->name); ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Información del Producto -->
        <div class="space-y-3">
            <!-- Título, precio y compartir -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <h1 class="body-lg-bold text-brandNeutral-400 mb-1"><?php echo e($product->name); ?></h1>
                    <div class="flex items-center gap-2">
                        <?php if($product->tienePromocionActiva()): ?>
                            <span class="body-sm text-brandNeutral-300 line-through">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                            <span class="body-lg-bold text-brandError-400">$<?php echo e(number_format($product->precio_promocional, 0, ',', '.')); ?></span>
                            <span class="px-2 py-0.5 bg-brandError-400 text-brandWhite-50 text-xs font-bold rounded">-<?php echo e($product->porcentaje_descuento); ?>%</span>
                        <?php else: ?>
                            <span class="body-lg-bold text-brandNeutral-400">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Botón Compartir (solo si está permitido) -->
                <?php if($product->allow_sharing): ?>
                <button onclick="shareProduct()" 
                        class="flex-shrink-0 flex items-center gap-2 bg-brandSuccess-300 hover:bg-brandSuccess-200 text-brandWhite-50 px-3 py-2 rounded-lg caption transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span class="hidden sm:inline">Compartir producto</span>
                </button>
                <?php endif; ?>
            </div>

            <!-- Categorías -->
            <?php if($product->categories->count() > 0): ?>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('tenant.category', [$store->slug, $category->slug])); ?>" 
                           class="px-3 py-1 bg-brandSuccess-50 border border-brandSuccess-400 text-brandSuccess-400 rounded-full caption hover:bg-brandSuccess-200 transition-colors">
                            <span class="caption text-brandSuccess-400">
                                <?php echo e($category->name); ?>

                            </span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- Descripción -->
            <?php if($product->description): ?>
                <div class="space-y-2">
                    <h3 class="caption text-brandNeutral-400">Descripción</h3>
                    <p class="caption text-brandNeutral-400 leading-relaxed"><?php echo e($product->description); ?></p>
                </div>
            <?php endif; ?>

            <!-- SKU -->
            <?php if($product->sku): ?>
                <div class="caption text-brandNeutral-400">
                    SKU: <?php echo e($product->sku); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Variables del Producto (si aplica) - Diseño moderno estilo Zara/Nike -->
        <?php if($product->type === 'variable' && $product->variables->count() > 0): ?>
            <div class="border-t border-brandNeutral-50 pt-4 space-y-5" id="product-variables" x-data="variableSelector()">
                <h3 class="body-lg-bold text-brandNeutral-400">Selecciona las opciones</h3>
                
                <?php $__currentLoopData = $product->variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isColorVariable = $variable->type === 'color' || 
                                          str_contains(strtolower($variable->name), 'color') ||
                                          $variable->options->contains(fn($opt) => !empty($opt->color_hex));
                        $isTextVariable = $variable->type === 'text';
                        $isNumericVariable = $variable->type === 'numeric';
                        $requiresOptions = $variable->requiresOptions();
                    ?>
                    <div class="space-y-3" data-variable-id="<?php echo e($variable->id); ?>">
                        <div class="flex items-center justify-between">
                            <label class="caption text-brandNeutral-400 font-medium">
                                <?php echo e($variable->name); ?>

                                <?php if($variable->is_required_default): ?>
                                    <span class="text-brandError-400">*</span>
                                <?php endif; ?>
                            </label>
                            <?php if($requiresOptions): ?>
                            <span class="caption text-brandNeutral-300" 
                                  x-show="selectedOptions[<?php echo e($variable->id); ?>]"
                                  x-text="getOptionName(<?php echo e($variable->id); ?>)">
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        
                        <input type="hidden" id="variable_<?php echo e($variable->id); ?>" x-model="selectedOptions[<?php echo e($variable->id); ?>]">
                        
                        <?php if($isTextVariable): ?>
                            
                            <textarea
                                id="variable_text_<?php echo e($variable->id); ?>"
                                x-model="textInputs[<?php echo e($variable->id); ?>]"
                                @input="updateTextVariable(<?php echo e($variable->id); ?>, $event.target.value)"
                                placeholder="Escribe aquí..."
                                rows="3"
                                class="w-full px-4 py-3 border border-brandNeutral-200 rounded-lg caption focus:border-brandPrimary-300 focus:ring-1 focus:ring-brandPrimary-300 focus:outline-none resize-none"
                                :required="<?php echo e($variable->is_required_default ? 'true' : 'false'); ?>"
                            ></textarea>
                        <?php elseif($isNumericVariable): ?>
                            
                            <input
                                type="number"
                                id="variable_numeric_<?php echo e($variable->id); ?>"
                                x-model="numericInputs[<?php echo e($variable->id); ?>]"
                                @input="updateNumericVariable(<?php echo e($variable->id); ?>, $event.target.value)"
                                placeholder="Ingresa un número"
                                <?php if($variable->min_value !== null): ?> min="<?php echo e($variable->min_value); ?>" <?php endif; ?>
                                <?php if($variable->max_value !== null): ?> max="<?php echo e($variable->max_value); ?>" <?php endif; ?>
                                step="any"
                                class="w-full px-4 py-3 border border-brandNeutral-200 rounded-lg caption focus:border-brandPrimary-300 focus:ring-1 focus:ring-brandPrimary-300 focus:outline-none"
                                :required="<?php echo e($variable->is_required_default ? 'true' : 'false'); ?>"
                            >
                            <?php if($variable->min_value !== null || $variable->max_value !== null): ?>
                                <p class="text-xs text-brandNeutral-300 mt-1">
                                    <?php if($variable->min_value !== null && $variable->max_value !== null): ?>
                                        Rango: <?php echo e(number_format($variable->min_value, 0, ',', '.')); ?> - <?php echo e(number_format($variable->max_value, 0, ',', '.')); ?>

                                    <?php elseif($variable->min_value !== null): ?>
                                        Mínimo: <?php echo e(number_format($variable->min_value, 0, ',', '.')); ?>

                                    <?php elseif($variable->max_value !== null): ?>
                                        Máximo: <?php echo e(number_format($variable->max_value, 0, ',', '.')); ?>

                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        <?php elseif($isColorVariable): ?>
                            
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $variable->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button"
                                            @click="selectOption(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>', '<?php echo e(addslashes($option->name)); ?>')"
                                            :class="{
                                                'ring-2 ring-offset-2 ring-brandPrimary-300 scale-110': selectedOptions[<?php echo e($variable->id); ?>] === '<?php echo e($option->id); ?>',
                                                'opacity-40 cursor-not-allowed line-through': !isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>'),
                                                'hover:scale-105': isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>')
                                            }"
                                            :disabled="!isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>')"
                                            class="w-10 h-10 rounded-full transition-all duration-200 relative group"
                                            style="background-color: <?php echo e($option->color_hex ?? '#CCCCCC'); ?>;"
                                            title="<?php echo e($option->name); ?>">
                                        
                                        <span x-show="selectedOptions[<?php echo e($variable->id); ?>] === '<?php echo e($option->id); ?>'"
                                              class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-5 h-5 <?php echo e($option->color_hex && $option->color_hex !== '#FFFFFF' && $option->color_hex !== '#ffffff' ? 'text-white' : 'text-brandNeutral-400'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                        
                                        <span x-show="!isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>')"
                                              class="absolute inset-0 flex items-center justify-center">
                                            <span class="w-full h-0.5 bg-brandError-300 rotate-45 absolute"></span>
                                        </span>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $variable->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button"
                                            @click="selectOption(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>', '<?php echo e(addslashes($option->name)); ?>')"
                                            :class="{
                                                'bg-green-600 text-white border-green-900 shadow-md': selectedOptions[<?php echo e($variable->id); ?>] === '<?php echo e($option->id); ?>',
                                                'bg-gray-50 text-gray-900 border-gray-200 hover:border-gray-600': selectedOptions[<?php echo e($variable->id); ?>] !== '<?php echo e($option->id); ?>' && isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>'),
                                                'bg-gray-100 text-gray-900 border-gray-100 cursor-not-allowed line-through': !isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>')
                                            }"
                                            :disabled="!isOptionAvailable(<?php echo e($variable->id); ?>, '<?php echo e($option->id); ?>')"
                                            class="px-4 py-2 rounded-lg border-2 caption font-medium transition-all duration-200 min-w-[3rem] text-center">
                                        <?php echo e($option->name); ?>

                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        
                        
                        <?php if($product->controla_stock && $product->tipo_stock === 'limitado'): ?>
                            <div x-show="selectedOptions[<?php echo e($variable->id); ?>]" 
                                 x-transition
                                 class="flex items-center gap-1">
                                <template x-if="getOptionStock(<?php echo e($variable->id); ?>) > 0 && getOptionStock(<?php echo e($variable->id); ?>) <= 5">
                                    <span class="text-sm text-red-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert-icon lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>                                        ¡Solo quedan <span x-text="getOptionStock(<?php echo e($variable->id); ?>)"></span>!
                                    </span>
                                </template>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
                <div x-show="allOptionsSelected && !currentVariant" 
                     x-transition
                     class="p-3 bg-brandError-50 border border-brandError-200 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-brandError-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="caption text-brandError-400">Esta combinación no está disponible</span>
                </div>
                
                
                <div x-show="currentVariant && currentVariant.price_modifier !== 0" 
                     x-transition
                     class="p-3 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="caption text-brandNeutral-400">Precio con esta selección:</span>
                        <span class="body-lg-bold text-brandSuccess-400" x-text="'$' + calculateTotalPrice().toLocaleString('es-CO')"></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Indicador de Stock -->
        <?php if($product->controla_stock && $product->tipo_stock === 'limitado'): ?>
            <div class="p-3 bg-brandWhite-100 rounded-lg">
                <?php if($product->type === 'simple'): ?>
                    <?php
                        $stock = $product->cantidad_stock ?? 0;
                    ?>
                    <?php if($stock > 0): ?>
                        <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-icon lucide-package"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/><path d="M12 22V12"/><polyline points="3.29 7 12 12 20.71 7"/><path d="m7.5 4.27 9 5.15"/></svg>
                            <span class="caption text-brandSuccess-300 font-medium">
                                <?php echo e($stock); ?> <?php echo e($stock == 1 ? 'unidad disponible' : 'unidades disponibles'); ?>

                            </span>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-x-icon lucide-package-x"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><path d="m17 13 5 5m-5 0 5-5"/></svg>
                            <span class="caption text-brandError-300 font-medium">Agotado</span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div id="stock-indicator" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <span id="stock-text" class="caption text-brandPrimary-300">Selecciona las opciones para ver disponibilidad</span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Botón Agregar al Carrito -->
        <div class="pt-2">
            <?php if($product->type === 'simple'): ?>
                <button class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 py-3 rounded-lg caption transition-colors flex items-center justify-center gap-2 add-to-cart-btn"
                        data-product-id="<?php echo e($product->id); ?>"
                        data-product-name="<?php echo e($product->name); ?>"
                        data-product-price="<?php echo e($product->price); ?>"
                        data-product-image="<?php echo e($product->main_image_url); ?>">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-brandWhite-50"></i>
                    Agregar al Carrito
                </button>
            <?php else: ?>
                <button id="add-variable-product-btn" 
                        class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-400 disabled:bg-brandNeutral-50 disabled:cursor-not-allowed text-brandWhite-50 py-3 rounded-lg transition-colors flex items-center justify-center gap-2"
                        onclick="addVariableProductToCart()">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-brandWhite-50"></i>
                    Agregar al Carrito
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Productos Relacionados / Alternativas -->
    <?php if($relatedProducts->count() > 0): ?>
        <div class="space-y-3">
            <?php if($product->estaAgotado()): ?>
                
                <div class="bg-brandWarning-50 border border-brandWarning-200 rounded-lg p-4 text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-brandWarning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="caption-strong text-brandWarning-500">Este producto está agotado</span>
                    </div>
                    <p class="caption text-brandNeutral-400">¡Pero tenemos estas alternativas que te pueden interesar!</p>
                </div>
                <h2 class="caption-strong text-brandSuccess-400">✨ Productos Similares Disponibles</h2>
            <?php else: ?>
                <h2 class="caption text-brandNeutral-400">Productos Relacionados</h2>
            <?php endif; ?>
            
            <div class="grid grid-cols-2 gap-3">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('tenant.product', [$store->slug, $relatedProduct->slug])); ?>" 
                       class="bg-brandWhite-100 rounded-lg p-3 border border-brandNeutral-50 hover:border-brandPrimary-200 transition-colors">
                        <!-- Imagen -->
                        <div class="w-full h-24 bg-brandWhite-100 rounded-lg overflow-hidden mb-2">
                            <?php if($relatedProduct->main_image_url): ?>
                                <img src="<?php echo e($relatedProduct->main_image_url); ?>" 
                                     alt="<?php echo e($relatedProduct->name); ?>" 
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-brandNeutral-400">
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

                        <!-- Info -->
                        <div class="space-y-1">
                            <h3 class="caption text-brandNeutral-400 line-clamp-1"><?php echo e($relatedProduct->name); ?></h3>
                            <div class="body-lg-bold text-brandNeutral-400">
                                $<?php echo e(number_format($relatedProduct->price, 0, ',', '.')); ?>

                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
    // Preparar datos de variables con opciones completas
    $variablesData = $product->variables->map(function($var) {
        return [
            'id' => $var->id,
            'name' => $var->name,
            'type' => $var->type,
            'is_required' => $var->is_required_default ?? false,
            'min_value' => $var->min_value,
            'max_value' => $var->max_value,
            'options' => $var->options->map(fn($opt) => [
                'id' => $opt->id,
                'name' => $opt->name,
                'color_hex' => $opt->color_hex
            ])
        ];
    });

    // Preparar datos de variaciones
    $variantsData = [];
    if ($product->type === 'variable') {
        $variantsData = $product->variants->map(function($variant) {
            return [
                'id' => $variant->id,
                'options' => $variant->variant_options,
                'stock' => $variant->stock,
                'price_modifier' => (float)$variant->price_modifier,
                'sku' => $variant->sku
            ];
        })->toArray();
    }
?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Precio base del producto (usa precio promocional si está activo)
    const basePrice = <?php echo e($product->precio_final); ?>;
    
    // Variables activas del producto
    const productVariables = <?php echo json_encode($variablesData, 15, 512) ?>;

    // Variaciones del producto con stock y precio
    const productVariants = <?php echo json_encode($variantsData, 15, 512) ?>;

    let selectedOptions = {}; // {variable_id: option_id}
    let currentVariant = null; // Variación actual seleccionada
    
    // Alpine.js component para selector de variables
    function variableSelector() {
        return {
            selectedOptions: {},
            optionNames: {},
            textInputs: {},
            numericInputs: {},
            currentVariant: null,
            allOptionsSelected: false,
            
            init() {
                // Escuchar cambios para actualizar el estado global
                this.$watch('selectedOptions', () => {
                    this.updateVariantSelection();
                });
            },
            
            selectOption(variableId, optionId, optionName) {
                // Verificar disponibilidad antes de seleccionar
                if (!this.isOptionAvailable(variableId, optionId)) {
                    return;
                }
                
                // Toggle: si ya está seleccionado, deseleccionar
                if (this.selectedOptions[variableId] === optionId) {
                    delete this.selectedOptions[variableId];
                    delete this.optionNames[variableId];
                } else {
                    this.selectedOptions[variableId] = optionId;
                    this.optionNames[variableId] = optionName;
                }
                
                // Actualizar el objeto global
                selectedOptions = { ...this.selectedOptions };
                
                // Forzar actualización del input hidden
                const hiddenInput = document.getElementById(`variable_${variableId}`);
                if (hiddenInput) {
                    hiddenInput.value = this.selectedOptions[variableId] || '';
                    hiddenInput.dispatchEvent(new Event('change'));
                }
            },
            
            getOptionName(variableId) {
                return this.optionNames[variableId] || '';
            },
            
            isOptionAvailable(variableId, optionId) {
                // Si no hay otras opciones seleccionadas, verificar si hay alguna variante con esta opción
                const otherSelections = { ...this.selectedOptions };
                delete otherSelections[variableId];
                
                // Buscar variantes que contengan esta opción
                const matchingVariants = productVariants.filter(variant => {
                    const variantOptions = variant.options || {};
                    
                    // Verificar que esta opción esté en la variante
                    if (String(variantOptions[variableId]) !== String(optionId)) {
                        return false;
                    }
                    
                    // Verificar que las otras selecciones también coincidan
                    for (const [key, value] of Object.entries(otherSelections)) {
                        if (variantOptions[key] && String(variantOptions[key]) !== String(value)) {
                            return false;
                        }
                    }
                    
                    return true;
                });
                
                // Verificar si alguna variante tiene stock (si controla stock)
                <?php if($product->controla_stock && $product->tipo_stock === 'limitado'): ?>
                return matchingVariants.some(v => v.stock > 0);
                <?php else: ?>
                return matchingVariants.length > 0;
                <?php endif; ?>
            },
            
            getOptionStock(variableId) {
                // Obtener stock disponible para la combinación actual
                if (!this.currentVariant) return 0;
                return this.currentVariant.stock || 0;
            },
            
            updateVariantSelection() {
                // Filtrar variables que requieren opciones (radio, checkbox) para la búsqueda de variantes
                const variablesRequiringOptions = productVariables.filter(v => {
                    return v.type === 'radio' || v.type === 'checkbox';
                });
                
                // Verificar si todas las opciones de variables con opciones están seleccionadas
                const variableIdsRequiringOptions = variablesRequiringOptions.map(v => v.id);
                const allRequiredOptionsSelected = variableIdsRequiringOptions.every(id => this.selectedOptions[id]);
                
                // Verificar si todas las variables (incluyendo texto y numérico) están completas
                const allVariableIds = productVariables.map(v => v.id);
                this.allOptionsSelected = allVariableIds.every(id => {
                    // Para variables de texto y numérico, verificar que tengan valor
                    const variable = productVariables.find(v => v.id === id);
                    if (variable && (variable.type === 'text' || variable.type === 'numeric')) {
                        return this.selectedOptions[id] && this.selectedOptions[id].toString().trim() !== '';
                    }
                    // Para variables con opciones, verificar que estén seleccionadas
                    return this.selectedOptions[id];
                });
                
                // Buscar variación que coincida exactamente (solo con variables que requieren opciones)
                if (allRequiredOptionsSelected && variableIdsRequiringOptions.length > 0) {
                    this.currentVariant = productVariants.find(variant => {
                        const variantOptions = variant.options || {};
                        const selectedKeys = variableIdsRequiringOptions.filter(id => this.selectedOptions[id]);
                        const variantKeys = Object.keys(variantOptions);

                        if (selectedKeys.length !== variantKeys.length) {
                            return false;
                        }

                        return selectedKeys.every(key => {
                            return variantOptions[key] && String(variantOptions[key]) === String(this.selectedOptions[key]);
                        });
                    });
                } else {
                    // Si no hay variables con opciones o no están todas seleccionadas, no hay variante
                    this.currentVariant = null;
                }
                
                // Actualizar variable global
                currentVariant = this.currentVariant;
                
                // Actualizar precio
                updatePrice();
                
                // Actualizar stock
                <?php if($product->controla_stock && $product->tipo_stock === 'limitado' && $product->type === 'variable'): ?>
                updateStockIndicator();
                <?php endif; ?>
            },
            
            calculateTotalPrice() {
                let total = basePrice;
                if (this.currentVariant && this.currentVariant.price_modifier) {
                    total += this.currentVariant.price_modifier;
                }
                return total;
            }
        };
    }

    function changeMainImage(imageUrl, index) {
        // Cambiar imagen principal
        const mainImage = document.getElementById('main-image');
        if (mainImage) {
            mainImage.style.opacity = '0.7';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }

        // Actualizar thumbnails activos
        document.querySelectorAll('.image-thumb').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-transparent', 'hover:border-brandPrimary-200');
                thumb.classList.add('border-brandPrimary-300');
            } else {
                thumb.classList.remove('border-brandPrimary-300');
                thumb.classList.add('border-transparent', 'hover:border-brandPrimary-200');
            }
        });
    }

    // Navegación con teclado (opcional)
    document.addEventListener('keydown', function(e) {
        const thumbs = document.querySelectorAll('.image-thumb');
        if (thumbs.length <= 1) return;

        const currentActive = Array.from(thumbs).findIndex(thumb => 
            thumb.classList.contains('border-brandPrimary-300'));
        
        if (e.key === 'ArrowRight' && currentActive < thumbs.length - 1) {
            thumbs[currentActive + 1].click();
        } else if (e.key === 'ArrowLeft' && currentActive > 0) {
            thumbs[currentActive - 1].click();
        }
    });

    // Función para compartir producto por WhatsApp
    function shareProduct() {
        const productName = <?php echo json_encode($product->name); ?>;
        const productPrice = "$<?php echo e(number_format($product->price, 0, ',', '.')); ?>";
        const productUrl = <?php echo json_encode(url()->current()); ?>;
        const storeName = <?php echo json_encode($store->name); ?>;
        const productDescription = <?php echo json_encode($product->description ?? ''); ?>;
        // Usar códigos Unicode para emojis que funcionan bien en WhatsApp
        const message = `¡Hey! Te comparto este pedido que estoy pensando hacer:\n\n` +
                `🍴 ${productName}\n` +
                `💰 ${productPrice}\n` +
                `🗨️ ${productDescription}\n\n` +
                `👉 Ver producto: ${productUrl}\n` +
                `Lo encontré en ${storeName}, ¿qué opinas?`;

        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }

    // Actualizar selección de variación (mantiene compatibilidad con Alpine.js)
    function updateVariantSelection() {
        // Recopilar opciones seleccionadas desde los inputs hidden
        selectedOptions = {};
        productVariables.forEach(variable => {
            const input = document.getElementById(`variable_${variable.id}`);
            if (input && input.value) {
                selectedOptions[variable.id] = input.value;
            }
        });

        // Buscar variación que coincida exactamente
        currentVariant = productVariants.find(variant => {
            const variantOptions = variant.options || {};
            const selectedKeys = Object.keys(selectedOptions);
            const variantKeys = Object.keys(variantOptions);

            if (selectedKeys.length !== variantKeys.length) {
                return false;
            }

            return selectedKeys.every(key => {
                return variantOptions[key] && String(variantOptions[key]) === String(selectedOptions[key]);
            });
        });

        // Actualizar precio
        updatePrice();
        
        // Actualizar stock si el producto controla stock
        <?php if($product->controla_stock && $product->tipo_stock === 'limitado' && $product->type === 'variable'): ?>
        updateStockIndicator();
        <?php endif; ?>
    }

    // Actualizar precio total
    function updatePrice() {
        let totalPrice = basePrice;
        
        if (currentVariant && currentVariant.price_modifier) {
            totalPrice += currentVariant.price_modifier;
        }

        const priceElement = document.getElementById('total-price');
        if (priceElement) {
            priceElement.textContent = '$' + totalPrice.toLocaleString('es-CO', { maximumFractionDigits: 0 });
        }
    }

    // Actualizar indicador de stock
    function updateStockIndicator() {
        const stockIndicator = document.getElementById('stock-indicator');
        if (!stockIndicator) return;

        if (currentVariant) {
            const stock = currentVariant.stock || 0;
            if (stock > 0) {
                stockIndicator.innerHTML = `
                    <i data-lucide="package-check" class="w-4 h-4 text-brandSuccess-300"></i>
                    <span class="caption text-brandSuccess-300 font-medium">
                        ${stock} ${stock == 1 ? 'unidad disponible' : 'unidades disponibles'}
                    </span>
                `;
            } else {
                stockIndicator.innerHTML = `
                    <i data-lucide="package-x" class="w-4 h-4 text-brandError-300"></i>
                    <span class="caption text-brandError-300 font-medium">Agotado</span>
                `;
            }
            // Reinicializar iconos de Lucide
            if (window.lucide) {
                window.lucide.createIcons();
            }
        } else {
            stockIndicator.innerHTML = `
                <i data-lucide="info" class="w-4 h-4 text-brandPrimary-300"></i>
                <span class="caption text-brandPrimary-300 font-medium">Selecciona las opciones para ver disponibilidad</span>
            `;
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
    }


    function addVariableProductToCart() {
        // Validar que se haya seleccionado una variación válida
        if (!currentVariant) {
            showVariableAlert('Por favor selecciona todas las opciones del producto');
            return;
        }

        // Validar stock si el producto controla stock
        <?php if($product->controla_stock && $product->tipo_stock === 'limitado'): ?>
        if (currentVariant.stock <= 0) {
            showVariableAlert('Esta variación está agotada');
            return;
        }
        <?php endif; ?>

        // Calcular precio total
        let totalPrice = basePrice;
        if (currentVariant.price_modifier) {
            totalPrice += currentVariant.price_modifier;
        }

        // Construir objeto de variantes para el carrito
        const variantsForCart = {};
        Object.keys(selectedOptions).forEach(variableId => {
            const optionId = selectedOptions[variableId];
            const variable = productVariables.find(v => v.id == variableId);
            
            // Buscar el nombre de la opción desde los datos de variables
            let optionName = '';
            if (variable && variable.options) {
                const option = variable.options.find(o => String(o.id) === String(optionId));
                optionName = option ? option.name : '';
            }
            
            variantsForCart[variableId] = [{
                option_id: parseInt(optionId),
                option_name: optionName
            }];
        });

        // Agregar al carrito
        if (window.cart) {
            window.cart.addProduct({
                id: <?php echo e($product->id); ?>,
                name: <?php echo json_encode($product->name); ?>,
                price: totalPrice,
                quantity: 1,
                image: <?php echo json_encode($product->main_image_url); ?>,
                variants: variantsForCart,
                variant_id: currentVariant.id
            });
        } else {
            console.error('Cart not initialized');
        }
    }

    // Función para mostrar alerta bonita (mismo estilo que "producto agregado")
    function showVariableAlert(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 bg-brandWarning-50 px-6 py-4 rounded-2xl shadow-2xl z-[9999] transition-all duration-500 -translate-y-32 opacity-0 min-w-[340px]';
        notification.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-brandNeutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="body-lg-bold text-brandNeutral-400">${message}</span>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('-translate-y-32', 'opacity-0');
        }, 100);
        
        // Animar salida y eliminar
        setTimeout(() => {
            notification.classList.add('-translate-y-32', 'opacity-0');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 2500);
    }

    // Calcular precio inicial si hay opciones preseleccionadas
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar indicador de stock para productos variables
        <?php if($product->controla_stock && $product->tipo_stock === 'limitado' && $product->type === 'variable'): ?>
        updateStockIndicator();
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/storefront/product.blade.php ENDPATH**/ ?>