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
    <?php $__env->startSection('title', 'Editar Producto'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto space-y-6 mt-6">
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('tenant.admin.products.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Editar Producto</h1>
                    <p class="text-sm text-gray-600 mt-1"><?php echo e($product->name); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                    <?php echo e($product->is_active ? 'Activo' : 'Inactivo'); ?>

                </span>
            </div>
        </div>
        

        <form method="POST" action="<?php echo e(route('tenant.admin.products.update', [$store->slug, $product->id])); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Información Básica','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Información Básica','shadow' => 'sm']); ?>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre del Producto','placeholder' => 'Ej: Camiseta Básica Blanca','value' => old('name', $product->name),'required' => true,'error' => $errors->first('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre del Producto','placeholder' => 'Ej: Camiseta Básica Blanca','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name', $product->name)),'required' => true,'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $attributes = $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $component = $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
                        

                        
                        <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'text','name' => 'sku','id' => 'sku','label' => 'SKU (Código)','placeholder' => 'Ej: CAM-BAS-001','value' => old('sku', $product->sku),'error' => $errors->first('sku')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'sku','id' => 'sku','label' => 'SKU (Código)','placeholder' => 'Ej: CAM-BAS-001','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('sku', $product->sku)),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('sku'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $attributes = $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $component = $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
                        
                    </div>

                    
                    <div x-data="kiubotManager()">
                        <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                            Descripción
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            x-ref="descriptionTextarea"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Describe las características principales del producto..."><?php echo e(old('description', $product->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        
                        <?php if($store->plan && $store->plan->kiubot_enabled): ?>
                        <div class="mt-2">
                            <button 
                                type="button"
                                @click="improveDescription()"
                                :disabled="improving"
                                class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-blue-600 hover:bg-gradient-to-br shadow-xl shadow-indigo-500/50 inset-shadow-lg inset-shadow-indigo-500/50 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                            >
                                <img x-show="!improving" src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-5 h-5">
                                <svg x-show="improving" x-cloak class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="improving ? 'Mejorando con KiuBot...' : 'Mejorar con KiuBot'"></span>
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        
                        <div 
                            x-show="animating" 
                            x-cloak
                            class="mt-3 p-4 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-lg"
                        >
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-purple-900 mb-1">KiuBot está escribiendo...</p>
                                    <div class="relative h-1 bg-purple-200 rounded-full overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <?php echo $__env->make('tenant-admin::Core.products.partials.kiubot-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-800 mb-2">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input 
                                    type="number" 
                                    id="price" 
                                    name="price" 
                                    value="<?php echo e(old('price', $product->price)); ?>"
                                    min="0" 
                                    step="0.01"
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="15000"
                                    required>
                            </div>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        

                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-800 mb-2">
                                Tipo de Producto <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'type','selectId' => 'type','label' => 'Tipo de Producto','options' => [
                                    '' => 'Selecciona un tipo',
                                    'simple' => 'Simple',
                                    'variable' => 'Variable'
                                ],'selected' => old('type', $product->type),'placeholder' => '','error' => $errors->first('type'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'type','select-id' => 'type','label' => 'Tipo de Producto','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Selecciona un tipo',
                                    'simple' => 'Simple',
                                    'variable' => 'Variable'
                                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('type', $product->type)),'placeholder' => '','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('type')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $attributes = $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $component = $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
                        </div>
                        
                    </div>

                    
                    <div class="border border-orange-200 rounded-lg p-4 bg-orange-50/50" x-data="{ promocionActiva: <?php echo e(old('promocion_activa', $product->promocion_activa) ? 'true' : 'false'); ?> }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="tag" class="w-5 h-5 text-orange-600"></i>
                                <span class="text-sm font-medium text-gray-800">Precio Promocional</span>
                            </div>
                            <input type="hidden" name="promocion_activa" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'promocion_activa','switchId' => 'promocion_activa','checked' => old('promocion_activa', $product->promocion_activa),'value' => '1','xModel' => 'promocionActiva']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'promocion_activa','switch-id' => 'promocion_activa','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('promocion_activa', $product->promocion_activa)),'value' => '1','x-model' => 'promocionActiva']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                        </div>
                        
                        <div x-show="promocionActiva" x-collapse class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio Oferta</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                        <input type="number" 
                                               name="precio_promocional" 
                                               value="<?php echo e(old('precio_promocional', $product->precio_promocional)); ?>"
                                               min="0" 
                                               step="0.01"
                                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                               placeholder="25000">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Debe ser menor al precio original</p>
                                </div>
                                
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio (opcional)</label>
                                    <input type="date" 
                                           name="promocion_fecha_inicio" 
                                           value="<?php echo e(old('promocion_fecha_inicio', $product->promocion_fecha_inicio?->format('Y-m-d'))); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin (opcional)</label>
                                    <input type="date" 
                                           name="promocion_fecha_fin" 
                                           value="<?php echo e(old('promocion_fecha_fin', $product->promocion_fecha_fin?->format('Y-m-d'))); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">
                                <i data-lucide="info" class="w-3 h-3 inline"></i>
                                Si no defines fechas, la promoción estará activa indefinidamente mientras el toggle esté encendido.
                            </p>
                        </div>
                    </div>
                    

                    
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_active','checked' => old('is_active', $product->is_active),'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', $product->is_active)),'value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-800">Producto activo</span>
                            <p class="text-xs text-gray-500">El producto estará visible en tu tienda</p>
                        </div>
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
            

            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Gestión de Inventario','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestión de Inventario','shadow' => 'sm']); ?>
                <div x-data="{ 
                    controlaStock: <?php echo e(old('controla_stock', $product->controla_stock) ? 'true' : 'false'); ?>, 
                    tipoStock: '<?php echo e(old('tipo_stock', $product->tipo_stock ?? 'ilimitado')); ?>'
                }">
                    
                    <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg">
                        <input 
                            type="checkbox" 
                            name="controla_stock" 
                            id="controla_stock"
                            x-model="controlaStock"
                            value="1"
                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-0.5"
                        >
                        <div class="flex-1">
                            <label for="controla_stock" class="block text-sm font-medium text-gray-800 cursor-pointer">
                                Controlar inventario de este producto
                            </label>
                            <p class="text-xs text-gray-600 mt-1">
                                Activa esto para limitar la cantidad disponible y evitar sobreventa
                            </p>
                        </div>
                    </div>

                    
                    <div x-show="controlaStock" x-transition class="mt-4 space-y-4 p-4 border border-gray-200 rounded-lg">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-3">Tipo de inventario</label>
                            <div class="space-y-2">
                                <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input 
                                        type="radio" 
                                        name="tipo_stock" 
                                        value="ilimitado"
                                        x-model="tipoStock"
                                        class="w-4 h-4 mt-0.5 text-blue-600 focus:ring-blue-500"
                                    >
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-gray-800">Ilimitado</span>
                                        <p class="text-xs text-gray-600 mt-0.5">El producto siempre estará disponible</p>
                                    </div>
                                </label>
                                
                                <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input 
                                        type="radio" 
                                        name="tipo_stock" 
                                        value="limitado"
                                        x-model="tipoStock"
                                        class="w-4 h-4 mt-0.5 text-blue-600 focus:ring-blue-500"
                                    >
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-gray-800">Limitado</span>
                                        <p class="text-xs text-gray-600 mt-0.5">Controla la cantidad exacta disponible</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        
                        <div x-show="tipoStock === 'limitado'" x-transition class="space-y-4 pt-4 border-t border-gray-200">
                            
                            <?php if($product->type === 'simple'): ?>
                            <div>
                                <label for="cantidad_stock" class="block text-sm font-medium text-gray-800 mb-2">
                                    Cantidad en stock
                                </label>
                                <input 
                                    type="number" 
                                    name="cantidad_stock" 
                                    id="cantidad_stock"
                                    value="<?php echo e(old('cantidad_stock', $product->cantidad_stock ?? 0)); ?>"
                                    min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="0"
                                >
                                <p class="text-xs text-gray-600 mt-1">
                                    Cantidad actual disponible en tu inventario
                                </p>
                            </div>

                            
                            <div>
                                <label for="umbral_alerta_stock" class="block text-sm font-medium text-gray-800 mb-2">
                                    Alerta de stock bajo
                                </label>
                                <input 
                                    type="number" 
                                    name="umbral_alerta_stock" 
                                    id="umbral_alerta_stock"
                                    value="<?php echo e(old('umbral_alerta_stock', $product->umbral_alerta_stock ?? 1)); ?>"
                                    min="1"
                                    max="100"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="5"
                                >
                                <p class="text-xs text-gray-600 mt-1">
                                    Te notificaremos cuando el stock llegue a esta cantidad o menos
                                </p>
                            </div>
                            <?php else: ?>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex gap-3">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Stock por Variantes</p>
                                        <p class="text-xs text-blue-700 mt-1">
                                            Este producto tiene variables asignadas. El stock se maneja individualmente por cada opción seleccionada (ej: Talla S = 10 unidades, Talla M = 5 unidades).
                                        </p>
                                        <p class="text-xs text-blue-700 mt-2 font-medium">
                                            Configura el stock de cada opción en la sección "Variables" más abajo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Imágenes Actuales','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Imágenes Actuales','shadow' => 'sm']); ?>
                <div class="space-y-4 mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative group">
                            <img src="<?php echo e($image->image_url); ?>" onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>';" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <label class="flex items-center bg-red-600 text-white rounded-full p-1 cursor-pointer hover:bg-red-700">
                                    <input type="checkbox" 
                                           name="delete_images[]" 
                                           value="<?php echo e($image->id); ?>" 
                                           class="sr-only delete-image-checkbox"
                                           onchange="toggleImageForDeletion(this)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </label>
                            </div>
                            <div class="absolute bottom-1 left-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <?php if($image->is_main): ?>
                                <span class="bg-blue-600 text-white rounded-full px-2 py-1 text-xs font-medium">
                                    Principal
                                </span>
                                <?php else: ?>
                                <button type="button" 
                                        onclick="setMainImage(<?php echo e($image->id); ?>)"
                                        class="bg-gray-900 bg-opacity-75 text-white rounded-full px-2 py-1 text-xs hover:bg-opacity-100 transition-opacity">
                                    Hacer principal
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-sm text-gray-600 mt-4">
                        Marca las imágenes que deseas eliminar con el ícono de basura. Las imágenes marcadas se eliminarán al guardar.
                    </p>
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
            

            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Agregar Nuevas Imágenes','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Agregar Nuevas Imágenes','shadow' => 'sm']); ?>
                <div class="space-y-4 mt-4">
                    <div 
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200 cursor-pointer" 
                        id="image-upload-area"
                        onclick="document.getElementById('images').click()"
                    >
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="cloud-upload" class="w-12 h-12 text-gray-400"></i>
                            <div>
                                <p class="text-base text-gray-700 mb-2">Arrastra y suelta las imágenes aquí o</p>
                                <p class="text-gray-900 text-base font-semibold">haz clic para seleccionar</p>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </div>
                            <p class="text-sm text-gray-500">Soporta múltiples imágenes (JPG, PNG, WEBP)</p>
                        </div>
                    </div>
                    <div id="image-previews" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
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
            

            
            <?php if($categories->count() > 0): ?>
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Categorías','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Categorías','shadow' => 'sm']); ?>
                <div class="space-y-4 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="<?php echo e($category->id); ?>"
                                <?php echo e($product->categories->contains($category->id) ? 'checked' : ''); ?>

                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-800"><?php echo e($category->name); ?></span>
                                <?php if($category->description): ?>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e($category->description); ?></p>
                                <?php endif; ?>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <a href="<?php echo e(route('tenant.admin.categories.create', $store->slug)); ?>" 
                           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Crear nueva categoría
                        </a>
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
            

            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','id' => 'variables-section','style' => 'display: '.e($product->type === 'variable' ? 'block' : 'none').';']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','id' => 'variables-section','style' => 'display: '.e($product->type === 'variable' ? 'block' : 'none').';']); ?>
                <div class="mt-4 mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Variables del Producto</h3>
                            <p class="text-sm text-gray-600 mt-1">Asigna variables personalizables a este producto</p>
                        </div>
                        <?php if($variables->count() == 0): ?>
                            <a href="<?php echo e(route('tenant.admin.variables.index', $store->slug)); ?>" 
                               class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1 font-medium">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                Crear Variable
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($variables->count() > 0): ?>
                        
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">
                                    Variables seleccionadas: <strong id="selected-variables-count" class="text-gray-900">0</strong>
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button"
                                    id="select-all-variables"
                                    class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1"
                                >
                                    <i data-lucide="check-square" class="w-3 h-3"></i>
                                    Seleccionar todas
                                </button>
                                <span class="text-gray-300">|</span>
                                <button 
                                    type="button"
                                    id="deselect-all-variables"
                                    class="text-xs text-gray-600 hover:text-gray-700 font-medium flex items-center gap-1"
                                >
                                    <i data-lucide="square" class="w-3 h-3"></i>
                                    Deseleccionar todas
                                </button>
                            </div>
                        </div>
                        
                        
                        
                        <div class="mt-3">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input 
                                    type="text"
                                    id="variable-search-input"
                                    placeholder="Buscar variables por nombre..."
                                    class="w-full pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                        </div>
                        
                    <?php endif; ?>
                </div>
                
                <div class="space-y-4" id="variables-container">
                    <?php if($variables->count() > 0): ?>
                        <?php
                            $groupedVariables = $variables->groupBy('type');
                        ?>
                        
                        <?php $__currentLoopData = $groupedVariables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $typeVariables): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="variable-group" data-type="<?php echo e($type); ?>">
                                <div class="mb-3 flex items-center gap-2">
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        <?php echo e(\App\Features\TenantAdmin\Models\ProductVariable::TYPES[$type] ?? $type); ?>

                                        <span class="text-gray-500 font-normal">(<?php echo e($typeVariables->count()); ?>)</span>
                                    </h4>
                                </div>
                                
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $typeVariables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $assignment = $product->variableAssignments->firstWhere('variable_id', $variable->id);
                                            $isAssigned = $assignment !== null;
                                        ?>
                                        <div 
                                            class="variable-card border rounded-lg p-4 transition-all duration-200 border-gray-200 hover:border-blue-300 bg-white"
                                            data-variable-id="<?php echo e($variable->id); ?>"
                                            data-variable-name="<?php echo e(strtolower($variable->name)); ?>"
                                            data-variable-icon="<?php echo e($variable->icon ?? 'box'); ?>"
                                            data-variable-options='<?php echo json_encode($variable->activeOptions->map(fn($opt) => ["id" => $opt->id, "name" => $opt->name, "color_hex" => $opt->color_hex])) ?>'
                                        >
                                            <div class="flex items-center gap-4">
                                                
                                                <div class="flex items-center">
                                                    <input 
                                                        type="checkbox" 
                                                        id="variable_<?php echo e($variable->id); ?>"
                                                        name="variables[<?php echo e($variable->id); ?>][enabled]"
                                                        value="1"
                                                        <?php echo e($isAssigned ? 'checked' : ''); ?>

                                                        class="variable-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        data-variable-id="<?php echo e($variable->id); ?>"
                                                    >
                                                </div>

                                                
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i data-lucide="<?php echo e($variable->icon ?? 'box'); ?>" class="w-5 h-5 text-blue-600"></i>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="flex-1">
                                                    <label for="variable_<?php echo e($variable->id); ?>" class="cursor-pointer">
                                                        <h4 class="text-sm font-semibold text-gray-900"><?php echo e($variable->name); ?></h4>
                                                        <p class="text-xs text-gray-500 mt-0.5">
                                                            <?php echo e($variable->activeOptions->count()); ?> opciones disponibles
                                                        </p>
                                                    </label>
                                                </div>

                                                
                                                <div class="flex items-center gap-2">
                                                    <input type="hidden" name="variables[<?php echo e($variable->id); ?>][is_required]" value="0">
                                                    <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'variables['.e($variable->id).'][is_required]','checked' => $isAssigned ? ($assignment->is_required ?? false) : false,'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'variables['.e($variable->id).'][is_required]','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isAssigned ? ($assignment->is_required ?? false) : false),'value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                                                    <span class="text-xs text-gray-600">Obligatorio</span>
                                                </div>

                                                
                                                <div class="w-64">
                                                    <input 
                                                        type="text" 
                                                        name="variables[<?php echo e($variable->id); ?>][custom_label]"
                                                        value="<?php echo e($isAssigned ? ($assignment->custom_label ?? '') : ''); ?>"
                                                        placeholder="Nombre personalizado"
                                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    >
                                                </div>

                                                
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-medium">
                                                    <?php echo e($variable->type_name); ?>

                                                </span>

                                                
                                                <?php if($variable->is_active): ?>
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">Activa</span>
                                                <?php else: ?>
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">Inactiva</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="settings" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                            <p class="text-sm mb-2">No hay variables creadas</p>
                            <a href="<?php echo e(route('tenant.admin.variables.index', $store->slug)); ?>" 
                               class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Crear primera variable
                            </a>
                        </div>
                    <?php endif; ?>
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
            

            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','id' => 'variations-section','style' => 'display: '.e($product->type === 'variable' ? 'block' : 'none').';']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','id' => 'variations-section','style' => 'display: '.e($product->type === 'variable' ? 'block' : 'none').';']); ?>
                <div x-data="variationsManager()">
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Variaciones del Producto</h3>
                                <p class="text-sm text-gray-600 mt-1">Edita las combinaciones específicas que vendes</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button"
                                    @click="generateAllCombinations()"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-purple-700 bg-purple-100 border border-purple-300 rounded-full hover:bg-purple-200 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Generar Todas las Combinaciones
                                </button>
                                <button 
                                    type="button"
                                    @click="addVariation()"
                                    class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-blue-600 hover:bg-gradient-to-br shadow-xl shadow-indigo-500/50 inset-shadow-lg inset-shadow-indigo-500/50 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar Variación
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-4">
                        <template x-for="(variation, index) in variations" :key="variation.id">
                            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-gray-800" x-text="'Variación #' + (index + 1)"></h4>
                                    <button 
                                        type="button"
                                        @click="removeVariation(index)"
                                        class="text-red-600 hover:text-red-700 p-1"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    
                                    <template x-for="variable in activeVariables" :key="'var-' + variable.id">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                <span x-text="variable.name"></span>
                                                <span class="text-xs text-gray-500 ml-1">(puede dejarse vacío)</span>
                                            </label>
                                            <select 
                                                :name="'variations[' + variation.id + '][options][' + variable.id + ']'"
                                                x-model="variation.options[variable.id]"
                                                @change="checkDuplicate(index)"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                            >
                                                <option value="" :selected="!variation.options[variable.id]">-- Cualquiera --</option>
                                                <template x-for="option in variable.options" :key="option.id">
                                                    <option 
                                                        :value="String(option.id)" 
                                                        :selected="String(option.id) === String(variation.options[variable.id])"
                                                        x-text="option.name"
                                                    ></option>
                                                </template>
                                            </select>
                                            <p x-show="variation.options[variable.id]" class="text-xs text-gray-500 mt-1">
                                                Seleccionado: <span x-text="variation.options[variable.id]"></span>
                                            </p>
                                        </div>
                                    </template>

                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                        <input 
                                            type="number"
                                            :name="'variations[' + variation.id + '][stock]'"
                                            x-model="variation.stock"
                                            min="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                            placeholder="0"
                                        >
                                    </div>

                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio Adicional</label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-2 text-gray-500 text-sm">$</span>
                                            <input 
                                                type="number"
                                                :name="'variations[' + variation.id + '][price_modifier]'"
                                                x-model="variation.price_modifier"
                                                step="0.01"
                                                class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                                placeholder="0"
                                            >
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Usa valores negativos para descuento</p>
                                    </div>

                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU (Opcional)</label>
                                        <input 
                                            type="text"
                                            :name="'variations[' + variation.id + '][sku]'"
                                            x-model="variation.sku"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                            placeholder="Ej: CAM-ROJO-M"
                                        >
                                    </div>
                                </div>

                                
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-700">Precio base del producto:</span>
                                        <span class="font-bold text-gray-900">$<span x-text="(<?php echo e($product->price ?? 0); ?>).toLocaleString('es-CO')"></span></span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm mt-1" x-show="variation.price_modifier != 0">
                                        <span class="text-gray-700">Precio adicional:</span>
                                        <span class="font-semibold" :class="variation.price_modifier > 0 ? 'text-green-600' : 'text-red-600'">
                                            <span x-text="variation.price_modifier > 0 ? '+' : ''"></span>$<span x-text="Math.abs(variation.price_modifier).toLocaleString('es-CO')"></span>
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-base mt-2 pt-2 border-t border-blue-300">
                                        <span class="font-semibold text-gray-800">Precio final:</span>
                                        <span class="font-bold text-lg text-blue-600">
                                            $<span x-text="(<?php echo e($product->price ?? 0); ?> + parseFloat(variation.price_modifier || 0)).toLocaleString('es-CO')"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        
                        <div x-show="variations.length === 0" class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay variaciones</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza agregando una variación del producto</p>
                        </div>
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
            

            
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-end gap-3">
                    <a href="<?php echo e(route('tenant.admin.products.show', [$store->slug, $product->id])); ?>">
                        <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'error','size' => 'md','text' => 'Cancelar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'error','size' => 'md','text' => 'Cancelar']); ?>
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
                    </a>
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Actualizar Producto','htmlType' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Actualizar Producto','html-type' => 'submit']); ?>
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
            
        </form>
    </div>

    <?php
        // Preparar variables
        $variablesData = [];
        foreach ($variables as $var) {
            $opts = [];
            foreach ($var->activeOptions as $opt) {
                $opts[] = ['id' => $opt->id, 'name' => $opt->name];
            }
            $variablesData[] = ['id' => $var->id, 'name' => $var->name, 'options' => $opts];
        }
        
        // Preparar variaciones
        $variationsData = [];
        foreach ($product->variants as $v) {
            $variationsData[] = [
                'id' => $v->id,
                'options' => $v->variant_options ?? [],
                'stock' => $v->stock ?? 0,
                'price_modifier' => $v->price_modifier ?? 0,
                'sku' => $v->sku
            ];
        }
        
        // Convertir a JSON para JavaScript
        $variablesJson = json_encode($variablesData);
        $variationsJson = json_encode($variationsData);
    ?>
    
    
    
    <?php $__env->startPush('scripts'); ?>
    <script>
        
        // Gestión de Variables con JavaScript vanilla
        (function() {
            let selectedVariables = {};
            let searchTerm = '';
            
            function initVariables() {
                // Inicializar variables seleccionadas basándose en las asignaciones existentes
                <?php if($variables->count() > 0): ?>
                    <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $assignment = $product->variableAssignments->firstWhere('variable_id', $variable->id);
                            $isAssigned = $assignment !== null;
                        ?>
                        selectedVariables[<?php echo e($variable->id); ?>] = <?php echo e($isAssigned ? 'true' : 'false'); ?>;
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
                updateSelectedCount();
                setupEventListeners();
                
                // Inicializar visualización de opciones para variables ya seleccionadas
                Object.keys(selectedVariables).forEach(variableId => {
                    if (selectedVariables[variableId]) {
                        const checkbox = document.getElementById('variable_' + variableId);
                        if (checkbox && checkbox.checked) {
                            toggleVariable(parseInt(variableId), true);
                        }
                    }
                });
            }
            
            function setupEventListeners() {
                // Checkboxes de variables
                document.querySelectorAll('.variable-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const variableId = parseInt(this.dataset.variableId);
                        const isChecked = this.checked;
                        toggleVariable(variableId, isChecked);
                    });
                });
                
                // Checkboxes de opciones
                document.querySelectorAll('.variable-option-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const variableId = parseInt(this.dataset.variableId);
                        const optionId = parseInt(this.dataset.optionId);
                        const isChecked = this.checked;
                        
                        // Mostrar/ocultar campo de cantidad
                        const optionItem = this.closest('.option-item');
                        if (optionItem) {
                            const quantityField = optionItem.querySelector('.option-quantity-field');
                            if (quantityField) {
                                if (isChecked) {
                                    quantityField.style.display = 'flex';
                                    quantityField.style.alignItems = 'center';
                                } else {
                                    quantityField.style.display = 'none';
                                    // Resetear cantidad cuando se deselecciona
                                    const quantityInput = quantityField.querySelector('.option-quantity-input');
                                    if (quantityInput) {
                                        quantityInput.value = '0';
                                    }
                                }
                            }
                        }
                        
                        validateVariableOptions(variableId);
                    });
                });
                
                // Botones de seleccionar/deseleccionar todas
                const selectAllBtn = document.getElementById('select-all-variables');
                const deselectAllBtn = document.getElementById('deselect-all-variables');
                
                if (selectAllBtn) {
                    selectAllBtn.addEventListener('click', selectAllVariables);
                }
                
                if (deselectAllBtn) {
                    deselectAllBtn.addEventListener('click', deselectAllVariables);
                }
                
                // Búsqueda
                const searchInput = document.getElementById('variable-search-input');
                if (searchInput) {
                    let searchTimeout;
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            searchTerm = this.value.toLowerCase();
                            filterVariables();
                        }, 300);
                    });
                }
                
                // Mostrar/ocultar sección de variables según el tipo de producto
                const typeSelect = document.getElementById('type');
                if (typeSelect) {
                    typeSelect.addEventListener('change', function() {
                        const variablesSection = document.getElementById('variables-section');
                        if (variablesSection) {
                            if (this.value === 'variable') {
                                variablesSection.style.display = 'block';
                            } else {
                                variablesSection.style.display = 'none';
                            }
                        }
                    });
                }
            }
            
            function toggleVariable(variableId, isChecked) {
                selectedVariables[variableId] = isChecked;
                
                const variableCard = document.querySelector(`[data-variable-id="${variableId}"]`);
                const optionsDiv = document.getElementById(`options_${variableId}`);
                
                if (variableCard) {
                    if (isChecked) {
                        variableCard.classList.remove('border-gray-200', 'bg-white');
                        variableCard.classList.add('border-blue-500', 'bg-blue-50');
                        if (optionsDiv) {
                            optionsDiv.style.display = 'block';
                            optionsDiv.style.opacity = '1';
                            optionsDiv.style.transform = 'translateY(0)';
                        }
                    } else {
                        variableCard.classList.remove('border-blue-500', 'bg-blue-50');
                        variableCard.classList.add('border-gray-200', 'bg-white');
                        if (optionsDiv) {
                            optionsDiv.style.display = 'none';
                        }
                        
                        // Ocultar campos de cantidad y deseleccionar opciones cuando se deselecciona la variable
                        const optionItems = variableCard.querySelectorAll('.option-item');
                        optionItems.forEach(item => {
                            const checkbox = item.querySelector('.variable-option-checkbox');
                            const quantityField = item.querySelector('.option-quantity-field');
                            if (checkbox && checkbox.checked) {
                                checkbox.checked = false;
                            }
                            if (quantityField) {
                                quantityField.style.display = 'none';
                                const quantityInput = quantityField.querySelector('.option-quantity-input');
                                if (quantityInput) {
                                    quantityInput.value = '0';
                                }
                            }
                        });
                        
                        // Limpiar errores
                        const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                        if (errorMsg) {
                            errorMsg.style.display = 'none';
                        }
                    }
                }
                
                updateSelectedCount();
            }
            
            function updateSelectedCount() {
                const count = Object.values(selectedVariables).filter(v => v).length;
                const countElement = document.getElementById('selected-variables-count');
                if (countElement) {
                    countElement.textContent = count;
                }
            }
            
            function selectAllVariables() {
                document.querySelectorAll('.variable-checkbox').forEach(function(checkbox) {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (checkbox && !checkbox.checked) {
                        checkbox.checked = true;
                        selectedVariables[variableId] = true;
                        toggleVariable(variableId, true);
                    }
                });
            }
            
            function deselectAllVariables() {
                document.querySelectorAll('.variable-checkbox').forEach(function(checkbox) {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                        selectedVariables[variableId] = false;
                        toggleVariable(variableId, false);
                    }
                });
            }
            
            function filterVariables() {
                const variableCards = document.querySelectorAll('.variable-card');
                variableCards.forEach(card => {
                    const variableName = card.dataset.variableName || '';
                    if (!searchTerm || variableName.includes(searchTerm)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 200);
                    }
                });
            }
            
            function validateVariableOptions(variableId) {
                const checkboxes = document.querySelectorAll(`input[name="variables[${variableId}][options][]"]:checked`);
                const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                
                if (checkboxes.length === 0 && errorMsg) {
                    errorMsg.style.display = 'flex';
                } else if (errorMsg) {
                    errorMsg.style.display = 'none';
                }
            }
            
            // Función para validar antes de submit
            window.validateVariablesForm = function() {
                const typeSelect = document.getElementById('type');
                if (!typeSelect || typeSelect.value !== 'variable') {
                    return true;
                }
                
                const selectedCount = Object.values(selectedVariables).filter(v => v).length;
                
                if (selectedCount === 0) {
                    window.showToast('error', 'Debes seleccionar al menos una variable para productos variables');
                    return false;
                }
                
                // Validar que cada variable seleccionada tenga al menos una opción
                let hasErrors = false;
                document.querySelectorAll('.variable-option-checkbox').forEach(checkbox => {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (selectedVariables[variableId]) {
                        const variableOptions = document.querySelectorAll(`input[name="variables[${variableId}][options][]"]:checked`);
                        if (variableOptions.length === 0) {
                            const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                            if (errorMsg) {
                                errorMsg.style.display = 'flex';
                                hasErrors = true;
                            }
                        }
                    }
                });
                
                return !hasErrors;
            };
            
            // Inicializar cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initVariables);
            } else {
                initVariables();
            }
        })();
        
        // Validación del formulario antes de submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const typeSelect = document.getElementById('type');
            if (typeSelect && typeSelect.value === 'variable') {
                if (typeof window.validateVariablesForm === 'function') {
                    if (!window.validateVariablesForm()) {
                        e.preventDefault();
                        return false;
                    }
                }
            }
        });
        
        // Inicializar iconos Lucide al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
            
            // Inicializar drag & drop para nuevas imágenes
            initImageUpload();
        });
        
        // Función para marcar/desmarcar imágenes para eliminar
        function toggleImageForDeletion(checkbox) {
            const imageDiv = checkbox.closest('.group');
            if (checkbox.checked) {
                imageDiv.classList.add('opacity-50');
                imageDiv.querySelector('img').style.filter = 'grayscale(100%)';
            } else {
                imageDiv.classList.remove('opacity-50');
                imageDiv.querySelector('img').style.filter = 'none';
            }
        }
        
        // Función para establecer imagen principal
        async function setMainImage(imageId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo e(url($store->slug . "/admin/products/" . $product->id . "/set-main-image")); ?>';
            form.innerHTML = `
                <?php echo csrf_field(); ?>
                <input type="hidden" name="image_id" value="${imageId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
        
        // Inicializar drag & drop para nuevas imágenes
        function initImageUpload() {
            const uploadArea = document.getElementById('image-upload-area');
            const fileInput = document.getElementById('images');
            const previewsContainer = document.getElementById('image-previews');
            
            if (!uploadArea || !fileInput || !previewsContainer) return;
            
            let selectedFiles = [];
            
            // Click en el área de upload
            uploadArea.addEventListener('click', () => fileInput.click());
            
            // Drag & drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('bg-blue-50', 'border-blue-400');
            });
            
            uploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400');
                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });
            
            // Selección de archivos
            fileInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);
                handleFiles(files);
            });
            
            function handleFiles(files) {
                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        selectedFiles.push(file);
                        createImagePreview(file);
                    }
                });
                updateFileInput();
            }
            
            function createImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'relative group';
                    previewDiv.dataset.fileName = file.name;
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                        <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeImage(this, '${file.name}')">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                        </button>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                    previewsContainer.appendChild(previewDiv);
                    
                    // Re-inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                };
                reader.readAsDataURL(file);
            }
            
            function removeImage(button, fileName) {
                selectedFiles = selectedFiles.filter(file => file.name !== fileName);
                button.closest('.relative').remove();
                updateFileInput();
            }
            
            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }
            
            // Exponer función globalmente
            window.removeImage = removeImage;
        }

        // ===========================================
        // KiuBot - Asistente para mejorar textos
        // ===========================================
        function kiubotManager() {
            return {
                improving: false,
                animating: false,
                showModal: false,
                originalText: '',
                improvedText: '',
                
                improveDescription() {
                    // Obtener el texto actual
                    const description = this.$refs.descriptionTextarea.value.trim();
                    
                    if (!description) {
                        window.toast.error('Campo vacío', 'Por favor escribe una descripción primero', 5000, 'bottom-center');
                        return;
                    }
                    
                    if (description.length < 10) {
                        window.toast.error('Texto muy corto', 'La descripción debe tener al menos 10 caracteres', 5000, 'bottom-center');
                        return;
                    }
                    
                    this.improving = true;
                    this.animating = true;
                    this.originalText = description;
                    
                    // Obtener el nombre del producto para contexto
                    const productName = document.getElementById('name')?.value || '';
                    
                    // Llamar al API
                    fetch('<?php echo e(route('tenant.admin.products.improve-description', $store->slug)); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            description: description,
                            product_name: productName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.improvedText = data.improved_text;
                            
                            // Pequeño delay para efecto de finalización
                            setTimeout(() => {
                                this.animating = false;
                                this.improving = false;
                                this.showModal = true;
                            }, 500);
                        } else {
                            this.animating = false;
                            this.improving = false;
                            window.toast.error('Error', data.error || 'No se pudo mejorar la descripción', 5000, 'bottom-center');
                        }
                    })
                    .catch(error => {
                        this.animating = false;
                        this.improving = false;
                        console.error('Error:', error);
                        window.toast.error('Error', 'Error al comunicarse con KiuBot. Verifica tu conexión a internet', 5000, 'bottom-center');
                    });
                },
                
                useImprovedText() {
                    this.$refs.descriptionTextarea.value = this.improvedText;
                    this.closeModal();
                    window.toast.success('Descripción actualizada', 'El texto ha sido mejorado por KiuBot', 5000, 'bottom-center');
                },
                
                regenerate() {
                    this.closeModal();
                    // Pequeña pausa para que se cierre el modal
                    setTimeout(() => {
                        this.improveDescription();
                    }, 300);
                },
                
                closeModal() {
                    this.showModal = false;
                }
            };
        }

        // ===========================================
        // Variaciones Manager - Gestión de variaciones manuales
        // ===========================================
        function variationsManager() {
            return {
                variations: [],
                nextId: 1,
                allVariables: [],
                activeVariables: [],
                
                init() {
                    // Cargar variables desde PHP
                    const rawVariables = <?php echo $variablesJson; ?>;
                    
                    // Reconstruir los objetos manualmente para evitar que Alpine.js los vacíe
                    this.allVariables = rawVariables.map(variable => {
                        return {
                            id: variable.id,
                            name: variable.name,
                            options: variable.options.map(option => ({
                                id: option.id,
                                name: option.name
                            }))
                        };
                    });
                    
                    // Cargar variaciones desde PHP
                    const existingVariations = <?php echo $variationsJson; ?>;
                    
                    // Usar $nextTick para asegurar que Alpine.js esté listo
                    this.$nextTick(() => {
                        existingVariations.forEach((variant) => {
                            // Convertir TODOS los valores a strings para consistencia
                            const options = {};
                            Object.keys(variant.options).forEach(key => {
                                const stringKey = String(key);
                                const stringValue = String(variant.options[key]);
                                options[stringKey] = stringValue;
                            });
                            
                            this.variations.push({
                                id: variant.id,
                                options: options,
                                stock: variant.stock,
                                price_modifier: variant.price_modifier,
                                sku: variant.sku
                            });
                        });
                        
                        this.nextId = this.variations.length > 0 ? Math.max(...this.variations.map(v => v.id)) + 1 : 1;
                        
                        // Actualizar variables activas
                        this.updateActiveVariables();
                    });
                    
                    // Escuchar cambios en los checkboxes de variables
                    document.querySelectorAll('.variable-checkbox').forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            this.updateActiveVariables();
                        });
                    });
                },
                
                updateActiveVariables() {
                    this.activeVariables = this.allVariables.filter(v => {
                        const checkbox = document.querySelector(`.variable-checkbox[data-variable-id="${v.id}"]`);
                        return checkbox && checkbox.checked;
                    });
                },
                
                addVariation() {
                    this.variations.push({
                        id: this.nextId++,
                        options: {},
                        stock: 0,
                        price_modifier: 0,
                        sku: ''
                    });
                },
                
                removeVariation(index) {
                    this.variations.splice(index, 1);
                },
                
                getSelectedVariables() {
                    // Filtrar solo las variables que tienen el checkbox marcado
                    return this.allVariables.filter(v => {
                        const checkbox = document.querySelector(`.variable-checkbox[data-variable-id="${v.id}"]`);
                        return checkbox && checkbox.checked;
                    });
                },
                
                // Verificar si la combinación actual ya existe en otra variación
                checkDuplicate(currentIndex) {
                    const currentVariation = this.variations[currentIndex];
                    if (!currentVariation) return;
                    
                    // Crear key de la combinación actual
                    const currentKey = this.getVariationKey(currentVariation);
                    
                    // Si no tiene opciones seleccionadas, no verificar
                    if (!currentKey) return;
                    
                    // Buscar si existe en otra variación
                    for (let i = 0; i < this.variations.length; i++) {
                        if (i === currentIndex) continue;
                        
                        const otherKey = this.getVariationKey(this.variations[i]);
                        
                        if (currentKey === otherKey) {
                            // Encontró duplicado - resetear la última opción cambiada
                            window.toast.warning(
                                'Combinación duplicada', 
                                `Esta combinación ya existe en la variación #${i + 1}. Elige otra opción.`,
                                5000, 
                                'bottom-center'
                            );
                            
                            // Resetear todas las opciones de esta variación
                            this.variations[currentIndex].options = {};
                            return;
                        }
                    }
                },
                
                // Generar una key única para una variación basada en sus opciones
                getVariationKey(variation) {
                    if (!variation.options || Object.keys(variation.options).length === 0) {
                        return null;
                    }
                    
                    // Filtrar opciones vacías y ordenar para consistencia
                    const entries = Object.entries(variation.options)
                        .filter(([key, val]) => val && val !== '')
                        .sort(([a], [b]) => a.localeCompare(b));
                    
                    if (entries.length === 0) return null;
                    
                    return entries.map(([k, v]) => `${k}:${v}`).join('|');
                },
                
                generateAllCombinations() {
                    // Obtener variables seleccionadas con sus opciones
                    const selectedVars = this.getSelectedVariables();
                    
                    if (selectedVars.length === 0) {
                        window.toast.warning('Sin variables', 'Debes seleccionar al menos una variable primero', 5000, 'bottom-center');
                        return;
                    }
                    
                    // Verificar que todas tengan opciones
                    const varsWithOptions = selectedVars.filter(v => v.options && v.options.length > 0);
                    
                    if (varsWithOptions.length === 0) {
                        window.toast.warning('Sin opciones', 'Las variables seleccionadas no tienen opciones disponibles', 5000, 'bottom-center');
                        return;
                    }
                    
                    // Calcular producto cartesiano
                    const cartesianProduct = (arrays) => {
                        return arrays.reduce((acc, curr) => {
                            const result = [];
                            acc.forEach(a => {
                                curr.forEach(b => {
                                    result.push([...a, b]);
                                });
                            });
                            return result;
                        }, [[]]);
                    };
                    
                    // Preparar arrays de opciones
                    const optionArrays = varsWithOptions.map(v => 
                        v.options.map(opt => ({
                            variableId: String(v.id),
                            optionId: String(opt.id),
                            optionName: opt.name
                        }))
                    );
                    
                    // Generar combinaciones
                    const combinations = cartesianProduct(optionArrays);
                    
                    // Limitar para evitar demasiadas variaciones
                    if (combinations.length > 100) {
                        window.toast.warning('Demasiadas combinaciones', `Se generarían ${combinations.length} variaciones. Considera reducir las opciones.`, 5000, 'bottom-center');
                        return;
                    }
                    
                    // Obtener combinaciones existentes para evitar duplicados
                    const existingKeys = new Set();
                    this.variations.forEach(v => {
                        const key = Object.entries(v.options || {})
                            .sort(([a], [b]) => a.localeCompare(b))
                            .map(([k, val]) => `${k}:${val}`)
                            .join('|');
                        if (key) existingKeys.add(key);
                    });
                    
                    // Agregar solo combinaciones nuevas
                    let addedCount = 0;
                    combinations.forEach(combo => {
                        const newVariation = {
                            id: this.nextId++,
                            options: {},
                            stock: 0,
                            price_modifier: 0,
                            sku: ''
                        };
                        
                        combo.forEach(item => {
                            newVariation.options[item.variableId] = item.optionId;
                        });
                        
                        // Verificar si ya existe
                        const key = Object.entries(newVariation.options)
                            .sort(([a], [b]) => a.localeCompare(b))
                            .map(([k, val]) => `${k}:${val}`)
                            .join('|');
                        
                        if (!existingKeys.has(key)) {
                            this.variations.push(newVariation);
                            existingKeys.add(key);
                            addedCount++;
                        }
                    });
                    
                    // Actualizar variables activas para forzar re-render
                    this.updateActiveVariables();
                    
                    if (addedCount > 0) {
                        window.toast.success('¡Combinaciones generadas!', `Se agregaron ${addedCount} variaciones nuevas`, 5000, 'bottom-center');
                    } else {
                        window.toast.info('Sin cambios', 'Todas las combinaciones ya existen', 5000, 'bottom-center');
                    }
                }
            };
        }
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
<?php endif; ?> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/products/edit.blade.php ENDPATH**/ ?>