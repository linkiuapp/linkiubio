

<?php if (isset($component)) { $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1 = $attributes; } ?>
<?php $component = App\Shared\Views\Components\TenantAdminLayout::resolve(['store' => $store] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tenant-admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\Shared\Views\Components\TenantAdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Detalles de Variable'); ?>

    <?php $__env->startSection('content'); ?>
    
    <div class="max-w-6xl mx-auto space-y-4">
        
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('tenant.admin.variables.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Detalles de Variable</h1>
        </div>
        

        
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        
                        <div class="shrink-0 w-12 h-12 bg-white rounded-lg border border-gray-200 p-2 flex items-center justify-center">
                            <?php
                                $variableNameLower = strtolower($variable->name);
                                
                                // Detectar icono según el nombre de la variable
                                if (str_contains($variableNameLower, 'color') || str_contains($variableNameLower, 'colour')) {
                                    $icon = 'palette';
                                } elseif (str_contains($variableNameLower, 'talla') || str_contains($variableNameLower, 'size') || str_contains($variableNameLower, 'tamaño')) {
                                    $icon = 'ruler';
                                } else {
                                    // Icono según tipo de variable
                                    $icon = match($variable->type) {
                                        'radio' => 'circle',
                                        'checkbox' => 'check-square',
                                        'text' => 'type',
                                        'numeric' => 'calculator',
                                        default => 'settings',
                                    };
                                }
                            ?>
                            <i data-lucide="<?php echo e($icon); ?>" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        

                        
                        <div class="flex-1 min-w-0">
                            <h2 class="text-base font-semibold text-gray-900 truncate"><?php echo e($variable->name); ?></h2>
                            <div class="flex items-center gap-2 flex-wrap mt-1">
                                
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $variable->is_active ? 'success' : 'error','text' => $variable->is_active ? 'Activa' : 'Inactiva']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variable->is_active ? 'success' : 'error'),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variable->is_active ? 'Activa' : 'Inactiva')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                

                                <?php if($variable->is_required_default): ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => 'Requerida']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => 'Requerida']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                    
                                <?php endif; ?>

                                
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => $variable->type_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variable->type_name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                
                            </div>
                        </div>
                        
                    </div>

                    
                    <div class="shrink-0">
                        <a href="<?php echo e(route('tenant.admin.variables.edit', [$store->slug, $variable->id])); ?>">
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'edit','size' => 'sm','text' => 'Editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'edit','size' => 'sm','text' => 'Editar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $attributes = $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $component = $__componentOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
                            
                        </a>
                    </div>
                    
                </div>
            </div>
            

            
            <div class="p-4 space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Información General</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                <p class="text-sm text-gray-900 mt-0.5"><?php echo e($variable->name); ?></p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                <p class="text-sm text-gray-900 mt-0.5"><?php echo e($variable->type_name); ?></p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Estado:</span>
                                <p class="text-sm text-gray-900 mt-0.5">
                                    <?php echo e($variable->is_active ? 'Activa' : 'Inactiva'); ?>

                                </p>
                            </div>
                            <?php if($variable->is_required_default): ?>
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Requerida por defecto:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">Sí</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    

                    
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">
                            <?php if($variable->type === 'numeric'): ?>
                                Configuración Numérica
                            <?php else: ?>
                                Configuración
                            <?php endif; ?>
                        </h3>
                        <div class="space-y-2">
                            <?php if($variable->type === 'numeric'): ?>
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Valor mínimo:</span>
                                    <p class="text-sm text-gray-900 mt-0.5"><?php echo e($variable->min_value ?? 'Sin límite'); ?></p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Valor máximo:</span>
                                    <p class="text-sm text-gray-900 mt-0.5"><?php echo e($variable->max_value ?? 'Sin límite'); ?></p>
                                </div>
                            <?php else: ?>
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Tipo de entrada:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">
                                        <?php if($variable->requiresOptions()): ?>
                                            Con opciones predefinidas
                                        <?php else: ?>
                                            Entrada libre
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Creado:</span>
                                <p class="text-xs text-gray-900 mt-0.5"><?php echo e($variable->created_at->format('d/m/Y H:i')); ?></p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Actualizado:</span>
                                <p class="text-xs text-gray-900 mt-0.5"><?php echo e($variable->updated_at->format('d/m/Y H:i')); ?></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Estadísticas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Opciones</p>
                                    <p class="text-lg font-bold text-gray-900 mt-0.5"><?php echo e($variable->options->count()); ?></p>
                                </div>
                                <i data-lucide="list" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        

                        
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Productos</p>
                                    <p class="text-lg font-bold text-gray-900 mt-0.5"><?php echo e($variable->assignments()->whereHas('product')->count()); ?></p>
                                </div>
                                <i data-lucide="package" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        

                        
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Creada</p>
                                    <p class="text-xs text-gray-900 mt-0.5"><?php echo e($variable->created_at->format('d/m/Y')); ?></p>
                                </div>
                                <i data-lucide="calendar" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
                

                
                <?php if($variable->requiresOptions()): ?>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Opciones de la Variable</h3>
                        <?php if($variable->options->count() > 0): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                <?php $__currentLoopData = $variable->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    
                                    <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm']); ?>
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-medium text-gray-900"><?php echo e($option->name); ?></h4>
                                                <span class="text-xs text-gray-500">#<?php echo e($loop->iteration); ?></span>
                                            </div>
                                            
                                            <?php if($option->price_modifier != 0): ?>
                                                <div class="text-xs">
                                                    <span class="font-medium text-gray-500">Precio:</span>
                                                    <?php if($option->price_modifier > 0): ?>
                                                        <span class="text-green-600 font-semibold">+$<?php echo e(number_format($option->price_modifier, 2)); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-red-600 font-semibold">-$<?php echo e(number_format(abs($option->price_modifier), 2)); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if($option->color_hex): ?>
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="font-medium text-gray-500">Color:</span>
                                                    <span 
                                                        class="inline-block w-4 h-4 rounded border border-gray-300" 
                                                        style="background-color: <?php echo e($option->color_hex); ?>"
                                                    ></span>
                                                    <span class="font-mono text-gray-600"><?php echo e($option->color_hex); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="pt-2 border-t border-gray-200">
                                                <span class="text-xs text-gray-500">
                                                    Creado: <?php echo e($option->created_at->format('d/m/Y')); ?>

                                                </span>
                                            </div>
                                        </div>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale7abd09368360b706a1fc8b7cc9ba036)): ?>
<?php $attributes = $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036; ?>
<?php unset($__attributesOriginale7abd09368360b706a1fc8b7cc9ba036); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale7abd09368360b706a1fc8b7cc9ba036)): ?>
<?php $component = $__componentOriginale7abd09368360b706a1fc8b7cc9ba036; ?>
<?php unset($__componentOriginale7abd09368360b706a1fc8b7cc9ba036); ?>
<?php endif; ?>
                                    
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            
                            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::EmptyStates.EmptyState','data' => ['svg' => 'empty-options.svg','title' => 'No hay opciones','message' => 'Esta variable no tiene opciones configuradas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['svg' => 'empty-options.svg','title' => 'No hay opciones','message' => 'Esta variable no tiene opciones configuradas']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                            
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                

                
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex flex-wrap items-center gap-4 text-xs">
                        <div>
                            <span class="font-medium text-gray-500">Fecha de creación:</span>
                            <span class="text-gray-900 ml-1"><?php echo e($variable->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Última actualización:</span>
                            <span class="text-gray-900 ml-1"><?php echo e($variable->updated_at->format('d/m/Y H:i')); ?></span>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $attributes = $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $component = $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/variables/show.blade.php ENDPATH**/ ?>