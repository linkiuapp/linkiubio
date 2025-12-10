

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
    <?php $__env->startSection('title', 'Nuevo Producto'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto space-y-6 mt-6">
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('tenant.admin.products.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Nuevo Producto</h1>
                    <p class="text-sm text-gray-600 mt-1">Crea un nuevo producto para tu tienda</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gray-100 rounded-lg px-4 py-2 border border-gray-200">
                    <span class="text-sm text-gray-700 font-medium"><?php echo e($currentCount); ?>/<?php echo e($maxProducts); ?> productos</span>
                </div>
            </div>
        </div>
        
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'crear_producto','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'crear_producto','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $attributes = $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $component = $__componentOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>

        
        <div data-tour="consumo">
            <?php if (isset($component)) { $__componentOriginal41ce05244c62d53131dc2872106fd4c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ce05244c62d53131dc2872106fd4c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertSoft','data' => ['type' => 'info','message' => 'Estás usando ' . $currentCount . ' de ' . $maxProducts . ' productos disponibles en tu plan ' . $store->plan->name . '.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Estás usando ' . $currentCount . ' de ' . $maxProducts . ' productos disponibles en tu plan ' . $store->plan->name . '.')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $attributes = $__attributesOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $component = $__componentOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__componentOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
        </div>
        

        
        <?php if($errors->any()): ?>
            <?php if (isset($component)) { $__componentOriginal4e12e3fb830c932c6bff0347987a4573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e12e3fb830c932c6bff0347987a4573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => 'error','title' => 'Por favor corrige los siguientes errores:']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','title' => 'Por favor corrige los siguientes errores:']); ?>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="text-sm text-gray-700"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $attributes = $__attributesOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $component = $__componentOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__componentOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
        <?php endif; ?>
        

        
        <form method="POST" action="<?php echo e(route('tenant.admin.products.store', $store->slug)); ?>" enctype="multipart/form-data" x-data="productCreateForm()" class="space-y-6">
            <?php echo csrf_field(); ?>
            
            
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
                        
                        <div data-tour="product-name">
                            <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre del Producto','placeholder' => 'Ej: Camiseta Básica Blanca','value' => old('name'),'required' => true,'error' => $errors->first('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre del Producto','placeholder' => 'Ej: Camiseta Básica Blanca','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name')),'required' => true,'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('name'))]); ?>
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
                        

                        
                        <div data-tour="product-sku">
                            <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'text','name' => 'sku','id' => 'sku','label' => 'SKU (Código)','placeholder' => 'Ej: CAM-BAS-001','value' => old('sku'),'error' => $errors->first('sku')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'sku','id' => 'sku','label' => 'SKU (Código)','placeholder' => 'Ej: CAM-BAS-001','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('sku')),'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('sku'))]); ?>
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
                        
                    </div>

                    
                    <div x-data="kiubotManager()" data-tour="product-description">
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
                            placeholder="Describe las características principales del producto..."><?php echo e(old('description')); ?></textarea>
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
                        <div class="mt-2" data-tour="kiubot-button">
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
                        
                        <div data-tour="product-price">
                            <label for="price" class="block text-sm font-medium text-gray-800 mb-2">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input 
                                    type="number" 
                                    id="price" 
                                    name="price" 
                                    value="<?php echo e(old('price')); ?>"
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
                        

                        
                        <div data-tour="product-type">
                            <label for="type" class="block text-sm font-medium text-gray-800 mb-2">
                                Tipo de Producto <span class="text-red-500">*</span>
                            </label>
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'type','selectId' => 'type','label' => 'Tipo de Producto','options' => [
                                    '' => 'Selecciona un tipo',
                                    'simple' => 'Simple',
                                    'variable' => 'Variable'
                                ],'selected' => old('type', ''),'placeholder' => '','xModel' => 'productType','@change' => 'toggleVariablesSection()','error' => $errors->first('type'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('type', '')),'placeholder' => '','x-model' => 'productType','@change' => 'toggleVariablesSection()','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('type')),'required' => true]); ?>
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

                    
                    <div class="border border-orange-200 rounded-lg p-4 bg-orange-50/50" x-data="{ promocionActiva: <?php echo e(old('promocion_activa') ? 'true' : 'false'); ?> }" data-tour="product-promotional-price">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="tag" class="w-5 h-5 text-orange-600"></i>
                                <span class="text-sm font-medium text-gray-800">Precio Promocional</span>
                            </div>
                            <input type="hidden" name="promocion_activa" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'promocion_activa','switchId' => 'promocion_activa','checked' => old('promocion_activa'),'value' => '1','xModel' => 'promocionActiva']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'promocion_activa','switch-id' => 'promocion_activa','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('promocion_activa')),'value' => '1','x-model' => 'promocionActiva']); ?>
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
                                               value="<?php echo e(old('precio_promocional')); ?>"
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
                                           value="<?php echo e(old('promocion_fecha_inicio')); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin (opcional)</label>
                                    <input type="date" 
                                           name="promocion_fecha_fin" 
                                           value="<?php echo e(old('promocion_fecha_fin')); ?>"
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_active','checked' => old('is_active', true),'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', true)),'value' => '1']); ?>
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
                    controlaStock: false, 
                    tipoStock: 'ilimitado'
                }" data-tour="product-stock">
                    
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
                                        checked
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
                            
                            <div x-show="productType === 'simple'">
                                <label for="cantidad_stock" class="block text-sm font-medium text-gray-800 mb-2">
                                    Cantidad en stock
                                </label>
                                <input 
                                    type="number" 
                                    name="cantidad_stock" 
                                    id="cantidad_stock"
                                    value="<?php echo e(old('cantidad_stock', 0)); ?>"
                                    min="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="0"
                                >
                                <p class="text-xs text-gray-600 mt-1">
                                    Cantidad inicial disponible en tu inventario
                                </p>
                            </div>

                            
                            <div x-show="productType === 'simple'">
                                <label for="umbral_alerta_stock" class="block text-sm font-medium text-gray-800 mb-2">
                                    Alerta de stock bajo
                                </label>
                                <input 
                                    type="number" 
                                    name="umbral_alerta_stock" 
                                    id="umbral_alerta_stock"
                                    value="<?php echo e(old('umbral_alerta_stock', 1)); ?>"
                                    min="1"
                                    max="100"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="1"
                                >
                                <p class="text-xs text-gray-600 mt-1">
                                    Te notificaremos cuando el stock llegue a esta cantidad o menos
                                </p>
                            </div>

                            
                            <div x-show="productType === 'variable'" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex gap-3">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Stock por Variantes</p>
                                        <p class="text-xs text-blue-700 mt-1">
                                            Guarda el producto primero. Luego podrás editar y asignar variables con sus cantidades individuales de stock (ej: Talla S = 10 unidades, Talla M = 5 unidades).
                                        </p>
                                    </div>
                                </div>
                            </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Imágenes del Producto','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Imágenes del Producto','shadow' => 'sm']); ?>
                <div class="space-y-4" data-tour="product-images">
                    <div 
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200 cursor-pointer" 
                        id="image-upload-area"
                        @click="$refs.fileInput.click()"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleFileDrop($event)"
                        :class="isDragging ? 'bg-blue-50 border-blue-400' : ''"
                    >
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="cloud-upload" class="w-12 h-12 text-gray-400"></i>
                            <div>
                                <p class="text-base text-gray-700 mb-2">Arrastra y suelta las imágenes aquí o</p>
                                <p class="text-gray-900 text-base font-semibold">haz clic para seleccionar</p>
                                <input 
                                    type="file" 
                                    id="images" 
                                    name="images[]" 
                                    multiple 
                                    accept="image/*" 
                                    class="hidden"
                                    x-ref="fileInput"
                                    @change="handleFileSelect($event)"
                                >
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
                <div class="space-y-4" data-tour="product-categories">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="<?php echo e($category->id); ?>"
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','id' => 'variables-section','style' => 'display: none;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','id' => 'variables-section','style' => 'display: none;']); ?>
                <div class="mb-4 pb-4 border-b border-gray-200" data-tour="product-variables">
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
                                    <?php
                                        $typeIcons = [
                                            'radio' => 'radio',
                                            'checkbox' => 'check-square',
                                            'text' => 'type',
                                            'numeric' => 'hash'
                                        ];
                                        $typeIcon = $typeIcons[$type] ?? 'settings';
                                    ?>
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        <?php echo e(\App\Features\TenantAdmin\Models\ProductVariable::TYPES[$type] ?? $type); ?>

                                        <span class="text-gray-500 font-normal">(<?php echo e($typeVariables->count()); ?>)</span>
                                    </h4>
                                </div>
                                
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $typeVariables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'variables['.e($variable->id).'][is_required]','checked' => false,'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'variables['.e($variable->id).'][is_required]','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'value' => '1']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','id' => 'variations-section','style' => 'display: none;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','id' => 'variations-section','style' => 'display: none;']); ?>
                <div x-data="variationsManager()">
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Variaciones del Producto</h3>
                                <p class="text-sm text-gray-600 mt-1">Crea las combinaciones específicas que venderás</p>
                            </div>
                            <div class="flex items-center gap-2">
                                
                                <button 
                                    type="button"
                                    @click="generateAllCombinations()"
                                    class="inline-flex items-center gap-2 text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Generar Todas
                                </button>
                                
                                <button 
                                    type="button"
                                    @click="addVariation()"
                                    class="inline-flex items-center gap-2 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-blue-600 hover:bg-gradient-to-br shadow-xl shadow-indigo-500/50 inset-shadow-lg inset-shadow-indigo-500/50 font-medium rounded-full text-sm px-4 py-2.5 text-center leading-5"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar Manual
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
                                                <option value="">-- Cualquiera --</option>
                                                <template x-for="option in variable.options" :key="option.id">
                                                    <option 
                                                        :value="String(option.id)" 
                                                        :selected="String(option.id) === String(variation.options[variable.id])"
                                                        x-text="option.name"
                                                    ></option>
                                                </template>
                                            </select>
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
                                        <span class="font-semibold text-gray-900" x-text="'$' + formatPrice(getBasePrice())"></span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm mt-1">
                                        <span class="text-gray-700">Precio final de esta variación:</span>
                                        <span class="font-bold text-blue-600" x-text="'$' + formatPrice(getBasePrice() + (parseFloat(variation.price_modifier) || 0))"></span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        
                        <div x-show="variations.length === 0" class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-gray-600 text-sm">No hay variaciones creadas</p>
                            <p class="text-gray-500 text-xs mt-1">Haz clic en "Agregar Variación" para crear la primera combinación</p>
                        </div>
                    </div>

                    
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg" x-show="variations.length > 0">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-900">
                                <p class="font-semibold mb-1">Gestión de Variaciones:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>Cada variación es una combinación única (ej: Rojo + Talla M)</li>
                                    <li>El stock y precio se manejan individualmente por variación</li>
                                    <li>Marca como "Obligatorio" las opciones que el cliente debe elegir</li>
                                </ul>
                            </div>
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
                    <a href="<?php echo e(route('tenant.admin.products.index', $store->slug)); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Crear Producto','htmlType' => 'submit','@click.prevent' => 'confirmSubmit()','dataTour' => 'save-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Crear Producto','html-type' => 'submit','@click.prevent' => 'confirmSubmit()','data-tour' => 'save-button']); ?>
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

    
    <?php $__env->startPush('styles'); ?>
    <script>
        // Registrar componentes Alpine usando alpine:init
        document.addEventListener('alpine:init', () => {
            // Componente para el formulario principal
            Alpine.data('productCreateForm', () => ({
                    productType: '<?php echo e(old('type', '')); ?>',
                    isDragging: false,
                    selectedFiles: [],
                    
                    init() {
                        // Inicializar iconos Lucide
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                        
                        // Mostrar/ocultar sección de variables según el tipo inicial
                        this.toggleVariablesSection();
                    },
                    
                    toggleVariablesSection() {
                        const variablesSection = document.getElementById('variables-section');
                        const variationsSection = document.getElementById('variations-section');
                        
                        if (this.productType === 'variable') {
                            if (variablesSection) {
                                variablesSection.style.display = 'block';
                            }
                            if (variationsSection) {
                                variationsSection.style.display = 'block';
                            }
                        } else {
                            if (variablesSection) {
                                variablesSection.style.display = 'none';
                            }
                            if (variationsSection) {
                                variationsSection.style.display = 'none';
                            }
                        }
                    },
                    
                    toggleVariableOptions(variableId, isChecked) {
                        const optionsDiv = document.getElementById('options_' + variableId);
                        if (optionsDiv) {
                            optionsDiv.style.display = isChecked ? 'block' : 'none';
                        }
                    },
                    
                    // Validar antes de submit
                    validateForm() {
                        if (this.productType !== 'variable') {
                            return true;
                        }
                        
                        // Usar la función de validación de variables (JavaScript vanilla)
                        if (typeof window.validateVariablesForm === 'function') {
                            return window.validateVariablesForm();
                        }
                        
                        return true;
                    },
                    
                    handleFileSelect(event) {
                        const files = Array.from(event.target.files);
                        this.processFiles(files);
                    },
                    
                    handleFileDrop(event) {
                        this.isDragging = false;
                        const files = Array.from(event.dataTransfer.files);
                        this.processFiles(files);
                    },
                    
                    processFiles(files) {
                        files.forEach(file => {
                            if (file.type.startsWith('image/')) {
                                this.selectedFiles.push(file);
                                this.createImagePreview(file);
                            }
                        });
                        this.updateFileInput();
                    },
                    
                    createImagePreview(file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const previewsContainer = document.getElementById('image-previews');
                            if (!previewsContainer) return;
                            
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'relative group';
                            previewDiv.dataset.fileName = file.name;
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="window.removeImage(this, '${file.name}')">
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
                    },
                    
                    updateFileInput() {
                        const fileInput = document.getElementById('images');
                        if (!fileInput) return;
                        
                        const dt = new DataTransfer();
                        this.selectedFiles.forEach(file => dt.items.add(file));
                        fileInput.files = dt.files;
                    },
                    
                    confirmSubmit() {
                        const form = this.$el.closest('form');
                        if (!form) return;
                        
                        // Validar formulario nativo
                        if (!form.checkValidity()) {
                            form.reportValidity();
                            return;
                        }
                        
                        // Validar variables
                        if (!this.validateForm()) {
                            return;
                        }
                        
                        form.submit();
                    }
                }));
        });
    </script>
    <?php $__env->stopPush(); ?>
    
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Gestión de Variables con JavaScript vanilla
        (function() {
            let selectedVariables = {};
            let searchTerm = '';
            
            function initVariables() {
                // Inicializar todas las variables como no seleccionadas
                <?php if($variables->count() > 0): ?>
                    <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        selectedVariables[<?php echo e($variable->id); ?>] = false;
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
                updateSelectedCount();
                setupEventListeners();
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
            
            // Función para validar antes de submit (usada por productCreateForm)
            window.validateVariablesForm = function() {
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
        
        // Función global para eliminar imágenes
        window.removeImage = function(button, fileName) {
            const form = Alpine.$data(document.querySelector('[x-data*="productCreateForm"]'));
            if (form && form.selectedFiles) {
                form.selectedFiles = form.selectedFiles.filter(file => file.name !== fileName);
                form.updateFileInput();
            }
            button.closest('.relative').remove();
        };
        
        // Inicializar iconos Lucide al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });

        // ===========================================
        // Gestor de Variaciones Manuales
        // ===========================================
        function variationsManager() {
            return {
                variations: [],
                nextId: 1,
                activeVariables: [], // Cache de variables activas para evitar re-renderizados
                
                init() {
                    // Inicializar variables activas
                    this.$nextTick(() => {
                        this.updateActiveVariables();
                    });

                    // Escuchar cambios en checkboxes de variables para actualizar la lista
                    document.addEventListener('change', (e) => {
                        if (e.target.classList.contains('variable-checkbox')) {
                            // Pequeño delay para asegurar que el DOM del checkbox se actualizó
                            setTimeout(() => {
                                this.updateActiveVariables();
                            }, 50);
                        }
                    });
                },

                updateActiveVariables() {
                    this.activeVariables = this.getSelectedVariables();
                },
                
                addVariation() {
                    // Asegurar que tenemos las variables actualizadas
                    this.updateActiveVariables();
                    const selectedVars = this.activeVariables;
                    
                    if (selectedVars.length === 0) {
                        window.toast.error('Sin variables', 'Selecciona al menos una variable primero', 5000, 'bottom-center');
                        return;
                    }
                    
                    const newVariation = {
                        id: this.nextId++,
                        options: {},
                        stock: 0,
                        price_modifier: 0,
                        sku: ''
                    };
                    
                    // Inicializar is_required para cada variable
                    selectedVars.forEach(variable => {
                        newVariation['is_required_' + variable.id] = false;
                    });
                    
                    this.variations.push(newVariation);
                },
                
                removeVariation(index) {
                    this.variations.splice(index, 1);
                },
                
                // Generar TODAS las combinaciones posibles automáticamente
                generateAllCombinations() {
                    this.updateActiveVariables();
                    const selectedVars = this.activeVariables;
                    
                    if (selectedVars.length === 0) {
                        window.toast.error('Sin variables', 'Selecciona al menos una variable primero', 5000, 'bottom-center');
                        return;
                    }
                    
                    // Verificar que todas las variables tengan opciones
                    const varsWithOptions = selectedVars.filter(v => v.options && v.options.length > 0);
                    if (varsWithOptions.length === 0) {
                        window.toast.error('Sin opciones', 'Las variables seleccionadas no tienen opciones definidas', 5000, 'bottom-center');
                        return;
                    }
                    
                    // Calcular total de combinaciones
                    const totalCombinations = varsWithOptions.reduce((total, v) => total * v.options.length, 1);
                    
                    if (totalCombinations > 50) {
                        window.toast.warning('Muchas combinaciones', `Se generarán ${totalCombinations} variaciones. Esto puede tardar.`, 5000, 'bottom-center');
                    }
                    
                    // Generar producto cartesiano
                    // Usamos los IDs originales (números) para que coincidan con el x-for de las opciones
                    const combinations = this.cartesianProduct(varsWithOptions.map(v => 
                        v.options.map(opt => ({ variableId: v.id, optionId: opt.id, optionName: opt.name }))
                    ));
                    
                    // Limpiar variaciones existentes
                    this.variations = [];
                    this.nextId = 1;
                    
                    // Crear una variación por cada combinación
                    combinations.forEach(combo => {
                        const newVariation = {
                            id: this.nextId++,
                            options: {},
                            stock: 0,
                            price_modifier: 0,
                            sku: ''
                        };
                        
                        // Asignar cada opción a su variable (como STRING para match con select value)
                        combo.forEach(item => {
                            newVariation.options[item.variableId] = String(item.optionId);
                        });
                        
                        this.variations.push(newVariation);
                    });
                    
                    window.toast.success('¡Listo!', `Se generaron ${this.variations.length} combinaciones automáticamente`, 5000, 'bottom-center');
                },
                
                // Función auxiliar: Producto cartesiano de arrays
                cartesianProduct(arrays) {
                    if (arrays.length === 0) return [[]];
                    
                    return arrays.reduce((acc, curr) => {
                        const result = [];
                        acc.forEach(a => {
                            curr.forEach(b => {
                                result.push([...a, b]);
                            });
                        });
                        return result;
                    }, [[]]);
                },
                
                getSelectedVariables() {
                    // Obtener las variables que están seleccionadas (checkbox marcado)
                    const variables = [];
                    const checkboxes = document.querySelectorAll('.variable-checkbox:checked');
                    
                    checkboxes.forEach(checkbox => {
                        const variableId = parseInt(checkbox.dataset.variableId);
                        const variableCard = checkbox.closest('.variable-card');
                        
                        if (variableCard) {
                            const variableName = variableCard.dataset.variableName;
                            const optionsData = variableCard.dataset.variableOptions;
                            
                            try {
                                const options = optionsData ? JSON.parse(optionsData) : [];
                                variables.push({
                                    id: variableId,
                                    name: variableName,
                                    options: options
                                });
                            } catch (e) {
                                console.error('Error parsing variable options:', e);
                            }
                        }
                    });
                    
                    return variables;
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
                
                getBasePrice() {
                    const priceInput = document.getElementById('price');
                    return parseFloat(priceInput?.value || 0);
                },
                
                formatPrice(price) {
                    return new Intl.NumberFormat('es-CO').format(price);
                }
            };
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/products/create.blade.php ENDPATH**/ ?>