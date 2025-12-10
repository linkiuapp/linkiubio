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
    <?php $__env->startSection('title', 'Ver Producto'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-6 mt-6">
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('tenant.admin.products.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800"><?php echo e($product->name); ?></h1>
                    <?php if($product->sku): ?>
                    <span class="text-sm text-gray-600 font-mono mt-1 block"><?php echo e($product->sku); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('tenant.admin.products.edit', [$store->slug, $product->id])); ?>">
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'pencil','size' => 'md','text' => 'Editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'pencil','size' => 'md','text' => 'Editar']); ?>
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
        

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Información del Producto','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Información del Producto','shadow' => 'sm']); ?>
                    <div class="space-y-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                <p class="text-sm text-gray-900"><?php echo e($product->name); ?></p>
                            </div>
                            <?php if($product->sku): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                                <p class="text-sm text-gray-900 font-mono"><?php echo e($product->sku); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($product->description): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap"><?php echo e($product->description); ?></p>
                        </div>
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                <p class="text-lg font-semibold text-blue-600">$<?php echo e(number_format($product->price, 2)); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                                <p class="text-sm text-gray-900"><?php echo e($product->type === 'simple' ? 'Producto Simple' : 'Producto Variable'); ?></p>
                            </div>
                        </div>

                        
                        <?php if($product->controla_stock): ?>
                        <div class="pt-4 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Gestión de Stock</label>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Tipo de inventario:</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        <?php echo e($product->tipo_stock === 'ilimitado' ? 'Ilimitado' : 'Limitado'); ?>

                                    </span>
                                </div>
                                
                                <?php if($product->tipo_stock === 'limitado'): ?>
                                    <?php if($product->type === 'simple'): ?>
                                        
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Stock disponible:</span>
                                            <span class="text-lg font-bold <?php echo e($product->estaAgotado() ? 'text-red-600' : ($product->tieneStockBajo() ? 'text-yellow-600' : 'text-green-600')); ?>">
                                                <?php echo e($product->cantidad_stock ?? 0); ?> unidades
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Umbral de alerta:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($product->umbral_alerta_stock ?? 1); ?> unidades</span>
                                        </div>
                                    <?php else: ?>
                                        
                                        <?php
                                            $stockTotal = $product->variants->sum('stock');
                                            $stockReservado = 0; // Ya no se usa reserva en el nuevo sistema
                                            $stockDisponible = $stockTotal;
                                        ?>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Stock total:</span>
                                            <span class="text-lg font-bold <?php echo e($stockDisponible <= 0 ? 'text-red-600' : ($stockDisponible <= ($product->umbral_alerta_stock ?? 1) ? 'text-yellow-600' : 'text-green-600')); ?>">
                                                <?php echo e($stockDisponible); ?> unidades
                                            </span>
                                        </div>
                                        <?php if($stockReservado > 0): ?>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Stock reservado:</span>
                                            <span class="text-sm font-medium text-gray-600"><?php echo e($stockReservado); ?> unidades</span>
                                        </div>
                                        <?php endif; ?>
                                        <div class="text-xs text-gray-500 mt-2">
                                            Stock gestionado por variantes (<?php echo e($product->variants->count()); ?> variantes)
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        
                        <?php if($product->categories && $product->categories->count() > 0): ?>
                        <div class="pt-2 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => $category->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category->name)]); ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        
                        <div class="pt-2 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Creado</label>
                                    <p class="text-sm text-gray-900"><?php echo e($product->created_at->format('d/m/Y H:i')); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Actualizado</label>
                                    <p class="text-sm text-gray-900"><?php echo e($product->updated_at->format('d/m/Y H:i')); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="flex items-center gap-3 pt-2 border-t border-gray-200">
                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $product->is_active ? 'success' : 'error','text' => $product->is_active ? 'Activo' : 'Inactivo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'success' : 'error'),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'Activo' : 'Inactivo')]); ?>
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
                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $product->type === 'simple' ? 'info' : 'warning','text' => $product->type === 'simple' ? 'Simple' : 'Variable']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->type === 'simple' ? 'info' : 'warning'),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->type === 'simple' ? 'Simple' : 'Variable')]); ?>
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
                

                
                <?php if($product->images && $product->images->count() > 0): ?>
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Imágenes','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Imágenes','shadow' => 'sm']); ?>
                    <div class="mt-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative group">
                                <img src="<?php echo e($image->image_url); ?>" 
                                     alt="<?php echo e($product->name); ?>"
                                     onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>';"
                                     class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openImageModal('<?php echo e($image->image_url); ?>')">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-lg flex items-center justify-center">
                                    <i data-lucide="eye" class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                                <?php if($image->is_main): ?>
                                <div class="absolute top-2 left-2">
                                    <span class="bg-blue-600 text-white rounded-full px-2 py-1 text-xs font-medium">Principal</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php endif; ?>
                

            </div>
            

            
            <div class="space-y-6">
                
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Acciones','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Acciones','shadow' => 'sm']); ?>
                    <div class="space-y-3 mt-4">
                        <a href="<?php echo e(route('tenant.admin.products.edit', [$store->slug, $product->id])); ?>" class="block w-full">
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'pencil','size' => 'md','text' => 'Editar Producto','block' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'pencil','size' => 'md','text' => 'Editar Producto','block' => 'true']); ?>
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
                        
                        <form method="POST" action="<?php echo e(route('tenant.admin.products.toggle-status', [$store->slug, $product->id])); ?>" class="w-full" id="toggle-status-form">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => $product->is_active ? 'warning' : 'success','icon' => $product->is_active ? 'pause-circle' : 'play-circle','size' => 'md','text' => $product->is_active ? 'Desactivar' : 'Activar','htmlType' => 'submit','block' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'warning' : 'success'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'pause-circle' : 'play-circle'),'size' => 'md','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'Desactivar' : 'Activar'),'html-type' => 'submit','block' => 'true']); ?>
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
                        </form>

                        <form method="POST" action="<?php echo e(route('tenant.admin.products.destroy', [$store->slug, $product->id])); ?>" 
                              class="w-full" id="delete-product-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','htmlType' => 'submit','block' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','html-type' => 'submit','block' => 'true']); ?>
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
                        </form>
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
                

                
                <?php if($product->type === 'variable' && $product->variableAssignments && $product->variableAssignments->count() > 0): ?>
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Variables del Producto','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Variables del Producto','shadow' => 'sm']); ?>
                    <div class="space-y-4 mt-4">
                        <?php $__currentLoopData = $product->variableAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $variable = $assignment->variable;
                                $selectedOptions = $assignment->selected_options ?? [];
                            ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    <?php
                                        $typeIcons = [
                                            'radio' => 'radio',
                                            'checkbox' => 'check-square',
                                            'text' => 'type',
                                            'numeric' => 'hash'
                                        ];
                                        $icon = $typeIcons[$variable->type] ?? 'settings';
                                    ?>
                                    <i data-lucide="<?php echo e($icon); ?>" class="w-5 h-5 text-gray-500 mt-0.5"></i>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900"><?php echo e($assignment->custom_label ?: $variable->name); ?></h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => $variable->type_name,'class' => 'text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variable->type_name),'class' => 'text-xs']); ?>
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
                                            <?php if($assignment->is_required): ?>
                                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'warning','text' => 'Requerida','class' => 'text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning','text' => 'Requerida','class' => 'text-xs']); ?>
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
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if($variable->requiresOptions() && count($selectedOptions) > 0): ?>
                                    <div class="mt-3">
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Opciones seleccionadas:</label>
                                        <div class="flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $variable->activeOptions->whereIn('id', $selectedOptions); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center gap-2 px-2 py-1 bg-blue-50 border border-blue-200 rounded text-xs">
                                                    <span class="text-blue-900 font-medium"><?php echo e($option->name); ?></span>
                                                    <?php if($product->option_quantities && isset($product->option_quantities[$variable->id][$option->id])): ?>
                                                        <span class="text-blue-700">(<?php echo e($product->option_quantities[$variable->id][$option->id]); ?>)</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php elseif($variable->requiresOptions()): ?>
                                    <p class="text-xs text-gray-500 mt-2">Todas las opciones disponibles</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php endif; ?>
                

                
                <?php if($product->type === 'variable' && $product->variants && $product->variants->count() > 0): ?>
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Variaciones del Producto','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Variaciones del Producto','shadow' => 'sm']); ?>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-4">
                            Se encontraron <strong class="text-gray-900"><?php echo e($product->variants->count()); ?> variaciones</strong> para este producto
                        </p>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Combinación</th>
                                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Stock</th>
                                        <th class="px-3 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Precio</th>
                                        <th class="px-3 py-2.5 text-center text-xs font-semibold text-gray-700 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2.5">
                                            <div class="flex flex-wrap gap-1">
                                                <?php
                                                $variantDisplay = [];
                                                foreach ($variant->variant_options as $variableId => $optionId) {
                                                    $variable = $product->variableAssignments->firstWhere('variable_id', $variableId)?->variable;
                                                    $option = $variable?->options->find($optionId);
                                                    if ($variable && $option) {
                                                        $variantDisplay[] = [
                                                            'variable' => $variable->name,
                                                            'option' => $option->name,
                                                            'color' => $option->color_hex ?? null
                                                        ];
                                                    }
                                                }
                                                ?>
                                                
                                                <?php if(count($variantDisplay) > 0): ?>
                                                    <?php $__currentLoopData = $variantDisplay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 border border-blue-200 rounded text-xs">
                                                        <?php if($item['color']): ?>
                                                        <span class="w-3 h-3 rounded-full border border-gray-300" style="background-color: <?php echo e($item['color']); ?>"></span>
                                                        <?php endif; ?>
                                                        <span class="text-gray-700"><?php echo e($item['variable']); ?>:</span>
                                                        <strong class="text-gray-900"><?php echo e($item['option']); ?></strong>
                                                    </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <span class="text-xs text-gray-500 italic">Sin opciones específicas</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($variant->sku): ?>
                                            <code class="block mt-1 text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600"><?php echo e($variant->sku); ?></code>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <span class="font-semibold <?php echo e($variant->stock <= 0 ? 'text-red-600' : ($variant->stock <= 5 ? 'text-yellow-600' : 'text-green-600')); ?>">
                                                <?php echo e($variant->stock); ?> unidades
                                            </span>
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <div class="space-y-0.5">
                                                <?php if($variant->price_modifier != 0): ?>
                                                <span class="block text-xs text-gray-500">Base: $<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                                <span class="block text-xs font-medium <?php echo e($variant->price_modifier > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                                    <?php echo e($variant->formatted_price_modifier); ?>

                                                </span>
                                                <?php endif; ?>
                                                <span class="block font-bold text-gray-900">$<?php echo e(number_format($product->price + $variant->price_modifier, 0, ',', '.')); ?></span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2.5 text-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                                <?php echo e($variant->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'); ?>">
                                                <i data-lucide="<?php echo e($variant->is_active ? 'check-circle' : 'x-circle'); ?>" class="w-3 h-3"></i>
                                                <?php echo e($variant->is_active ? 'Activa' : 'Inactiva'); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
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
                <?php endif; ?>
                
            </div>
            
        </div>
    </div>

    
    <div x-data="{ open: false, imageUrl: '' }" x-on:keydown.escape.window="open = false" id="imageModalContainer">
        
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>

        
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            style="display: none;"
        >
            <div 
                class="sm:max-w-4xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none"
                x-transition:enter="transition-all ease-in-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all ease-in-out duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                >
                    
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Vista de Imagen</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200" 
                            aria-label="Cerrar"
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>

                    
                    <div class="p-4 overflow-y-auto">
                        <img :src="imageUrl" alt="Imagen del producto" class="max-w-full max-h-[70vh] object-contain mx-auto rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Función para abrir modal de imagen
        function openImageModal(imageUrl) {
            const container = document.getElementById('imageModalContainer');
            if (container) {
                const alpineData = Alpine.$data(container);
                if (alpineData) {
                    alpineData.imageUrl = imageUrl;
                    alpineData.open = true;
                }
            }
        }

        // Interceptar formulario de toggle status
        document.addEventListener('DOMContentLoaded', function() {
            const toggleForm = document.getElementById('toggle-status-form');
            if (toggleForm) {
                toggleForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const isActive = <?php echo e($product->is_active ? 'true' : 'false'); ?>;
                    const action = isActive ? 'desactivar' : 'activar';
                    const actionText = action.charAt(0).toUpperCase() + action.slice(1);
                    
                    // Mostrar modal de confirmación
                    const confirmModalContainer = document.getElementById('confirm-toggle-modal-container');
                    if (confirmModalContainer) {
                        const alpineData = Alpine.$data(confirmModalContainer);
                        if (alpineData) {
                            alpineData.message = `El producto será ${action}do`;
                            alpineData.open = true;
                            
                            // Manejar confirmación
                            document.getElementById('confirm-toggle-yes').onclick = async function() {
                                alpineData.open = false;
                                
                                const url = toggleForm.action;
                                
                                try {
                                    const response = await fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    });
                                    
                                    const data = await response.json();
                                    
                                    if (data.success) {
                                        window.showToast('success', data.message);
                                        setTimeout(() => {
                                            location.reload();
                                        }, 500);
                                    } else {
                                        window.showToast('error', data.error || 'Error al cambiar el estado');
                                    }
                                } catch (error) {
                                    window.showToast('error', 'Error al procesar la solicitud');
                                }
                            };
                        }
                    }
                });
            }
            
            // Función para mostrar modal de confirmación de eliminación
            function showDeleteConfirmation() {
                const confirmDeleteContainer = document.getElementById('confirm-delete-modal-container');
                if (confirmDeleteContainer) {
                    const alpineData = Alpine.$data(confirmDeleteContainer);
                    if (alpineData) {
                        alpineData.open = true;
                        
                        // Limpiar cualquier handler anterior
                        const yesButton = document.getElementById('confirm-delete-yes');
                        if (yesButton) {
                            yesButton.onclick = function() {
                                alpineData.open = false;
                                const deleteForm = document.getElementById('delete-product-form');
                                if (deleteForm) {
                                    deleteForm.submit();
                                }
                            };
                        }
                    }
                }
            }
            
            // Interceptar formulario de eliminación
            const deleteForm = document.getElementById('delete-product-form');
            if (deleteForm) {
                deleteForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    // Si está protegido, mostrar master key primero
                    <?php if($store->isActionProtected('products', 'delete')): ?>
                        requireMasterKey('products.delete', 'Eliminar producto: <?php echo e(addslashes($product->name)); ?>', () => {
                            // Después de validar master key, mostrar modal de confirmación
                            showDeleteConfirmation();
                        });
                    <?php else: ?>
                        // Si no está protegido, mostrar directamente el modal de confirmación
                        showDeleteConfirmation();
                    <?php endif; ?>
                });
            }
            
            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
    
    
    
    <div x-data="{ open: false, message: '' }" x-on:keydown.escape.window="open = false" id="confirm-toggle-modal-container">
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                    x-transition:enter="transition-all ease-in-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition-all ease-in-out duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Confirmar Acción</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none" 
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4" x-text="message"></p>
                        <div class="flex justify-end gap-3">
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'secondary','size' => 'md','text' => 'Cancelar','@click' => 'open = false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','size' => 'md','text' => 'Cancelar','@click' => 'open = false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $attributes = $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $component = $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => $product->is_active ? 'warning' : 'success','icon' => 'check','size' => 'md','text' => 'Confirmar','id' => 'confirm-toggle-yes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'warning' : 'success'),'icon' => 'check','size' => 'md','text' => 'Confirmar','id' => 'confirm-toggle-yes']); ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div x-data="{ open: false }" x-on:keydown.escape.window="open = false" id="confirm-delete-modal-container">
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                    x-transition:enter="transition-all ease-in-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition-all ease-in-out duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Confirmar Eliminación</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none" 
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4">¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.</p>
                        <div class="flex justify-end gap-3">
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'secondary','size' => 'md','text' => 'Cancelar','@click' => 'open = false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','size' => 'md','text' => 'Cancelar','@click' => 'open = false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $attributes = $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $component = $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','id' => 'confirm-delete-yes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','id' => 'confirm-delete-yes']); ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <?php if (isset($component)) { $__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Modals.ModalMasterKey','data' => ['modalId' => 'master-key-modal','action' => 'products.delete','actionLabel' => 'Eliminar producto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal-master-key'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => 'master-key-modal','action' => 'products.delete','actionLabel' => 'Eliminar producto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55)): ?>
<?php $attributes = $__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55; ?>
<?php unset($__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55)): ?>
<?php $component = $__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55; ?>
<?php unset($__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55); ?>
<?php endif; ?>
    
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
<?php endif; ?> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/products/show.blade.php ENDPATH**/ ?>