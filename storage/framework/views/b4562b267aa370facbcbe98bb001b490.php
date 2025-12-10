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
    <?php $__env->startSection('title', 'Nuevo Cupón'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto space-y-6" x-data="couponForm()" x-init="init()">
        
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('tenant.admin.coupons.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Nuevo cupón</h1>
        </div>
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'crear_cupon','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'crear_cupon','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

        
        
        <?php if (isset($component)) { $__componentOriginal41ce05244c62d53131dc2872106fd4c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ce05244c62d53131dc2872106fd4c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertSoft','data' => ['type' => 'info','message' => 'Estás usando ' . $currentCount . ' de ' . $maxCoupons . ' cupones disponibles en tu plan ' . $store->plan->name . '.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Estás usando ' . $currentCount . ' de ' . $maxCoupons . ' cupones disponibles en tu plan ' . $store->plan->name . '.')]); ?>
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
        

        
        <form action="<?php echo e(route('tenant.admin.coupons.store', $store->slug)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 space-y-8">
                    
                    <section class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div data-tour="coupon-name">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Nombre del cupón','name' => 'name','id' => 'coupon-name','placeholder' => 'Ej: Descuento de bienvenida','containerClass' => 'w-full','maxlength' => '120','required' => true,'xModel' => 'form.name','value' => ''.e(old('name')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nombre del cupón','name' => 'name','id' => 'coupon-name','placeholder' => 'Ej: Descuento de bienvenida','container-class' => 'w-full','maxlength' => '120','required' => true,'x-model' => 'form.name','value' => ''.e(old('name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['name'];
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
                            <div data-tour="coupon-code">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Código del cupón (opcional)','name' => 'code','id' => 'coupon-code','placeholder' => 'Ej: BIENVENIDA20','containerClass' => 'w-full','xModel' => 'form.code','xOn:input' => 'form.code = (form.code || \'\').toUpperCase()','value' => ''.e(old('code')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Código del cupón (opcional)','name' => 'code','id' => 'coupon-code','placeholder' => 'Ej: BIENVENIDA20','container-class' => 'w-full','x-model' => 'form.code','x-on:input' => 'form.code = (form.code || \'\').toUpperCase()','value' => ''.e(old('code')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['code'];
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
                        </div>
                        <div data-tour="coupon-description">
                            <?php if (isset($component)) { $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Textareas.TextareaWithLabel','data' => ['label' => 'Descripción (opcional)','textareaName' => 'description','textareaId' => 'coupon-description','containerClass' => 'w-full','rows' => '3','placeholder' => 'Comparte un mensaje que explique el beneficio del cupón','xModel' => 'form.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Descripción (opcional)','textarea-name' => 'description','textarea-id' => 'coupon-description','container-class' => 'w-full','rows' => '3','placeholder' => 'Comparte un mensaje que explique el beneficio del cupón','x-model' => 'form.description']); ?><?php echo e(old('description')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $attributes = $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $component = $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
                        </div>
                    </section>

                    
                    <section class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-3">
                            <div data-tour="coupon-apply-to">
                                <?php if (isset($component)) { $__componentOriginal450570cc6c4e74e7c828af9b649d080c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal450570cc6c4e74e7c828af9b649d080c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectWithLabel','data' => ['label' => 'Aplicar a','name' => 'type','selected' => old('type', 'global'),'options' => collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->prepend('Selecciona una opción', ''),'xModel' => 'form.type','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Aplicar a','name' => 'type','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('type', 'global')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->prepend('Selecciona una opción', '')),'x-model' => 'form.type','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal450570cc6c4e74e7c828af9b649d080c)): ?>
<?php $attributes = $__attributesOriginal450570cc6c4e74e7c828af9b649d080c; ?>
<?php unset($__attributesOriginal450570cc6c4e74e7c828af9b649d080c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal450570cc6c4e74e7c828af9b649d080c)): ?>
<?php $component = $__componentOriginal450570cc6c4e74e7c828af9b649d080c; ?>
<?php unset($__componentOriginal450570cc6c4e74e7c828af9b649d080c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['type'];
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
                            <div data-tour="coupon-type">
                                <?php if (isset($component)) { $__componentOriginal450570cc6c4e74e7c828af9b649d080c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal450570cc6c4e74e7c828af9b649d080c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectWithLabel','data' => ['label' => 'Tipo de descuento','name' => 'discount_type','selected' => old('discount_type', 'percentage'),'options' => collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->prepend('Selecciona una opción', ''),'xModel' => 'form.discountType','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Tipo de descuento','name' => 'discount_type','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('discount_type', 'percentage')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->prepend('Selecciona una opción', '')),'x-model' => 'form.discountType','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal450570cc6c4e74e7c828af9b649d080c)): ?>
<?php $attributes = $__attributesOriginal450570cc6c4e74e7c828af9b649d080c; ?>
<?php unset($__attributesOriginal450570cc6c4e74e7c828af9b649d080c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal450570cc6c4e74e7c828af9b649d080c)): ?>
<?php $component = $__componentOriginal450570cc6c4e74e7c828af9b649d080c; ?>
<?php unset($__componentOriginal450570cc6c4e74e7c828af9b649d080c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['discount_type'];
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
                            <div data-tour="coupon-value">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Valor del descuento','type' => 'number','name' => 'discount_value','id' => 'discount-value','containerClass' => 'w-full','placeholder' => 'Ingresa el valor','step' => '0.01','min' => '0.01','xBind:max' => 'form.discountType === \'percentage\' ? 100 : null','required' => true,'xModel.number' => 'form.discountValue','value' => ''.e(old('discount_value')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Valor del descuento','type' => 'number','name' => 'discount_value','id' => 'discount-value','container-class' => 'w-full','placeholder' => 'Ingresa el valor','step' => '0.01','min' => '0.01','x-bind:max' => 'form.discountType === \'percentage\' ? 100 : null','required' => true,'x-model.number' => 'form.discountValue','value' => ''.e(old('discount_value')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <p class="mt-1 text-xs text-gray-500" x-text="form.discountType === 'percentage' ? 'Ingresa el porcentaje de descuento (0 a 100).' : 'Ingresa el monto en pesos que se descontará.'"></p>
                                <?php $__errorArgs = ['discount_value'];
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
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div x-show="form.discountType === 'percentage'" x-cloak data-tour="coupon-max-discount">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Descuento máximo ($)','type' => 'number','name' => 'max_discount_amount','id' => 'max-discount-amount','containerClass' => 'w-full','placeholder' => 'Ej: 50000','step' => '100','min' => '0','value' => ''.e(old('max_discount_amount')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Descuento máximo ($)','type' => 'number','name' => 'max_discount_amount','id' => 'max-discount-amount','container-class' => 'w-full','placeholder' => 'Ej: 50000','step' => '100','min' => '0','value' => ''.e(old('max_discount_amount')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['max_discount_amount'];
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
                            <div data-tour="coupon-min-purchase">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Compra mínima ($)','type' => 'number','name' => 'min_purchase_amount','id' => 'min-purchase-amount','containerClass' => 'w-full','placeholder' => 'Ej: 30000','step' => '100','min' => '0','value' => ''.e(old('min_purchase_amount')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Compra mínima ($)','type' => 'number','name' => 'min_purchase_amount','id' => 'min-purchase-amount','container-class' => 'w-full','placeholder' => 'Ej: 30000','step' => '100','min' => '0','value' => ''.e(old('min_purchase_amount')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['min_purchase_amount'];
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
                        </div>
                    </section>

                    
                    <section class="space-y-4" x-show="form.type !== 'global'" x-cloak data-tour="coupon-applicability-section">
                        <div x-show="form.type === 'categories'" data-tour="coupon-categories">
                            <p class="text-sm font-medium text-gray-600">Selecciona las categorías en las que se aplicará el cupón.</p>
                            <div class="max-h-60 space-y-2 overflow-y-auto pr-1">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rounded-xl border border-gray-200 p-3 hover:bg-gray-50">
                                        <?php if (isset($component)) { $__componentOriginalb167bedcce30ae177df4f5c69cbeef26 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb167bedcce30ae177df4f5c69cbeef26 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Checkboxes.CheckboxWithDescription','data' => ['checkboxId' => 'category-'.$category->id,'checkboxName' => 'categories[]','checked' => in_array($category->id, old('categories', [])),'title' => $category->name,'description' => '','value' => ''.e($category->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('checkbox-with-description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['checkbox-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('category-'.$category->id),'checkbox-name' => 'categories[]','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($category->id, old('categories', []))),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category->name),'description' => '','value' => ''.e($category->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb167bedcce30ae177df4f5c69cbeef26)): ?>
<?php $attributes = $__attributesOriginalb167bedcce30ae177df4f5c69cbeef26; ?>
<?php unset($__attributesOriginalb167bedcce30ae177df4f5c69cbeef26); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb167bedcce30ae177df4f5c69cbeef26)): ?>
<?php $component = $__componentOriginalb167bedcce30ae177df4f5c69cbeef26; ?>
<?php unset($__componentOriginalb167bedcce30ae177df4f5c69cbeef26); ?>
<?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['categories'];
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
                        <div x-show="form.type === 'products'" x-cloak data-tour="coupon-products">
                            <p class="text-sm font-medium text-gray-600">Selecciona los productos donde el cupón será válido.</p>
                            <div class="max-h-60 space-y-2 overflow-y-auto pr-1">
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rounded-xl border border-gray-200 p-3 hover:bg-gray-50">
                                        <?php if (isset($component)) { $__componentOriginalb167bedcce30ae177df4f5c69cbeef26 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb167bedcce30ae177df4f5c69cbeef26 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Checkboxes.CheckboxWithDescription','data' => ['checkboxId' => 'product-'.$product->id,'checkboxName' => 'products[]','checked' => in_array($product->id, old('products', [])),'title' => $product->name,'description' => '$'.number_format($product->price, 0, ',', '.'),'value' => ''.e($product->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('checkbox-with-description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['checkbox-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('product-'.$product->id),'checkbox-name' => 'products[]','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($product->id, old('products', []))),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->name),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('$'.number_format($product->price, 0, ',', '.')),'value' => ''.e($product->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb167bedcce30ae177df4f5c69cbeef26)): ?>
<?php $attributes = $__attributesOriginalb167bedcce30ae177df4f5c69cbeef26; ?>
<?php unset($__attributesOriginalb167bedcce30ae177df4f5c69cbeef26); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb167bedcce30ae177df4f5c69cbeef26)): ?>
<?php $component = $__componentOriginalb167bedcce30ae177df4f5c69cbeef26; ?>
<?php unset($__componentOriginalb167bedcce30ae177df4f5c69cbeef26); ?>
<?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['products'];
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
                    </section>

                    
                    <section class="space-y-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div data-tour="coupon-max-uses">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Límite total de usos (opcional)','type' => 'number','name' => 'max_uses','id' => 'max-uses','containerClass' => 'w-full','placeholder' => 'Ej: 100','min' => '1','value' => ''.e(old('max_uses')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Límite total de usos (opcional)','type' => 'number','name' => 'max_uses','id' => 'max-uses','container-class' => 'w-full','placeholder' => 'Ej: 100','min' => '1','value' => ''.e(old('max_uses')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['max_uses'];
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
                            <div data-tour="coupon-uses-per-customer">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Usos por cliente (opcional)','type' => 'number','name' => 'uses_per_session','id' => 'uses-per-session','containerClass' => 'w-full','placeholder' => 'Ej: 1','min' => '1','value' => ''.e(old('uses_per_session')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Usos por cliente (opcional)','type' => 'number','name' => 'uses_per_session','id' => 'uses-per-session','container-class' => 'w-full','placeholder' => 'Ej: 1','min' => '1','value' => ''.e(old('uses_per_session')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['uses_per_session'];
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
                        </div>
                        <div class="grid gap-4 md:grid-cols-2" data-tour="coupon-dates">
                            <div data-tour="coupon-start-date">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Fecha de inicio (opcional)','type' => 'datetime-local','name' => 'start_date','id' => 'start-date','containerClass' => 'w-full','value' => ''.e(old('start_date')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha de inicio (opcional)','type' => 'datetime-local','name' => 'start_date','id' => 'start-date','container-class' => 'w-full','value' => ''.e(old('start_date')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['start_date'];
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
                            <div data-tour="coupon-end-date">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Fecha de fin (opcional)','type' => 'datetime-local','name' => 'end_date','id' => 'end-date','containerClass' => 'w-full','value' => ''.e(old('end_date')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha de fin (opcional)','type' => 'datetime-local','name' => 'end_date','id' => 'end-date','container-class' => 'w-full','value' => ''.e(old('end_date')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['end_date'];
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
                        </div>
                        <div class="border-t border-gray-200 pt-5" data-tour="coupon-time-restrictions">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">Restricciones horarias</h4>
                                    <p class="text-xs text-gray-500">Limita el uso del cupón a días y horarios específicos.</p>
                                </div>
                                <button type="button" class="text-sm font-semibold text-blue-600 hover:text-blue-700" @click.prevent="showTimeRestrictions = !showTimeRestrictions">
                                    <span x-text="showTimeRestrictions ? 'Ocultar' : 'Configurar'"></span>
                                </button>
                            </div>
                            <div x-show="showTimeRestrictions" x-transition class="mt-4 space-y-4" x-cloak>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Días permitidos</p>
                                    <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                                        <?php
                                            $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                        ?>
                                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50">
                                                <input type="checkbox"
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                    name="days_of_week[]"
                                                    value="<?php echo e($index); ?>"
                                                    <?php if(is_array(old('days_of_week')) && in_array($index, old('days_of_week'))): echo 'checked'; endif; ?>
                                                >
                                                <span class="text-gray-700"><?php echo e($day); ?></span>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Hora de inicio','type' => 'time','name' => 'start_time','id' => 'start-time','containerClass' => 'w-full','value' => ''.e(old('start_time')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Hora de inicio','type' => 'time','name' => 'start_time','id' => 'start-time','container-class' => 'w-full','value' => ''.e(old('start_time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                        <?php $__errorArgs = ['start_time'];
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
                                        <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Hora de fin','type' => 'time','name' => 'end_time','id' => 'end-time','containerClass' => 'w-full','value' => ''.e(old('end_time')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Hora de fin','type' => 'time','name' => 'end_time','id' => 'end-time','container-class' => 'w-full','value' => ''.e(old('end_time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                                        <?php $__errorArgs = ['end_time'];
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
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="border-t border-gray-200 p-6 space-y-6">
                    
                    <section class="flex justify-between gap-4 md:grid-cols-3">
                        <div class="col-span-1 flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchId' => 'is-active','switchName' => 'is_active','value' => '1','checked' => (bool) old('is_active', true)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-id' => 'is-active','switch-name' => 'is_active','value' => '1','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((bool) old('is_active', true))]); ?>
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
                            <div>
                                <p class="text-sm font-medium text-gray-800">Activar al guardar</p>
                                <p class="text-xs text-gray-500">El cupón estará disponible inmediatamente.</p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center gap-3" data-tour="coupon-public">
                            <input type="hidden" name="is_public" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchId' => 'is-public','switchName' => 'is_public','value' => '1','checked' => (bool) old('is_public')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-id' => 'is-public','switch-name' => 'is_public','value' => '1','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((bool) old('is_public'))]); ?>
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
                            <div>
                                <p class="text-sm font-medium text-gray-800">Cupón público</p>
                                <p class="text-xs text-gray-500">Visible en la tienda para todos los clientes.</p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center gap-3" data-tour="coupon-automatic">
                            <input type="hidden" name="is_automatic" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchId' => 'is-automatic','switchName' => 'is_automatic','value' => '1','checked' => (bool) old('is_automatic')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-id' => 'is-automatic','switch-name' => 'is_automatic','value' => '1','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((bool) old('is_automatic'))]); ?>
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
                            <div>
                                <p class="text-sm font-medium text-gray-800">Aplicación automática</p>
                                <p class="text-xs text-gray-500">El sistema aplicará el cupón sin código.</p>
                            </div>
                        </div>
                    </section>

                    
                    <section>
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-semibold text-gray-900" x-text="form.name || 'Nombre del cupón'"></span>
                                    <span class="text-xs font-mono uppercase tracking-wide text-gray-500" x-text="form.code || 'CÓDIGO-AUTO'"></span>
                                </div>
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700" x-text="previewScope"></span>
                            </div>
                            <div class="mt-4 text-2xl font-semibold text-blue-600">
                                <span x-show="isPercentage" x-text="(form.discountValue || 0) + '%'" x-cloak></span>
                                <span x-show="!isPercentage" x-text="currencyValue" x-cloak></span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Descuento estimado sobre el subtotal elegible.</p>
                        </div>
                    </section>

                    
                    <section class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="flex gap-3 md:order-2">
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'check','text' => 'Crear cupón','htmlType' => 'submit','dataTour' => 'save-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'check','text' => 'Crear cupón','html-type' => 'submit','data-tour' => 'save-button']); ?>
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
                            <a href="<?php echo e(route('tenant.admin.coupons.index', $store->slug)); ?>">
                                <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'error','text' => 'cancelar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'error','text' => 'cancelar']); ?>
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
                        </div>
                        <p class="text-xs text-gray-500 md:order-1">Revisa la configuración antes de guardar.</p>
                    </section>
                </div>
            </div>
        </form>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function couponForm() {
            return {
                form: {
                    name: <?php echo \Illuminate\Support\Js::from(old('name'))->toHtml() ?>,
                    code: <?php echo \Illuminate\Support\Js::from(old('code'))->toHtml() ?>,
                    description: <?php echo \Illuminate\Support\Js::from(old('description'))->toHtml() ?>,
                    type: <?php echo \Illuminate\Support\Js::from(old('type', 'global'))->toHtml() ?>,
                    discountType: <?php echo \Illuminate\Support\Js::from(old('discount_type', 'percentage'))->toHtml() ?>,
                    discountValue: <?php echo \Illuminate\Support\Js::from(old('discount_value', ''))->toHtml() ?>,
                },
                showTimeRestrictions: <?php echo e((old('days_of_week') || old('start_time') || old('end_time')) ? 'true' : 'false'); ?>,

                init() {
                    if (this.form.code) {
                        this.form.code = this.form.code.toUpperCase();
                    }
                },

                get previewScope() {
                    switch (this.form.type) {
                        case 'categories':
                            return 'Categorías';
                        case 'products':
                            return 'Productos';
                        default:
                            return 'Global';
                    }
                },

                get isPercentage() {
                    return this.form.discountType === 'percentage';
                },

                get currencyValue() {
                    const amount = parseFloat(this.form.discountValue || 0);
                    return amount > 0 ? `$${amount.toLocaleString('es-CO')}` : '$0';
                },
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
<?php endif; ?> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/coupons/create.blade.php ENDPATH**/ ?>