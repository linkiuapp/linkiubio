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

<?php $__env->startSection('title', 'Editar Sede'); ?>

<?php $__env->startSection('content'); ?>
<div
    class="space-y-6"
    x-data="locationForm"
>
    
    <?php echo $__env->make('tenant-admin::Core/locations/components/notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php if (isset($component)) { $__componentOriginalf98a32c06d8462f5513d0fb3554f9141 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf98a32c06d8462f5513d0fb3554f9141 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Notifications.ToastNotification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast-notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf98a32c06d8462f5513d0fb3554f9141)): ?>
<?php $attributes = $__attributesOriginalf98a32c06d8462f5513d0fb3554f9141; ?>
<?php unset($__attributesOriginalf98a32c06d8462f5513d0fb3554f9141); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf98a32c06d8462f5513d0fb3554f9141)): ?>
<?php $component = $__componentOriginalf98a32c06d8462f5513d0fb3554f9141; ?>
<?php unset($__componentOriginalf98a32c06d8462f5513d0fb3554f9141); ?>
<?php endif; ?>

    
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Editar sede</h1>
            <p class="text-sm text-gray-600">Actualiza la información de tu sede sin perder la consistencia del sistema.</p>
        </div>
        <a href="<?php echo e(route('tenant.admin.locations.index', ['store' => $store->slug])); ?>">
            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'secondary','icon' => 'arrow-left','text' => 'Volver']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','icon' => 'arrow-left','text' => 'Volver']); ?>
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

    <form
        action="<?php echo e(route('tenant.admin.locations.update', ['store' => $store->slug, 'location' => $location->id])); ?>"
        method="POST"
        class="space-y-6"
    >
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Información de la sede','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Información de la sede','shadow' => 'sm']); ?>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Nombre de la sede *','name' => 'name','placeholder' => 'Ej. Sede Centro','value' => old('name', $location->name),'required' => true,'containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nombre de la sede *','name' => 'name','placeholder' => 'Ej. Sede Centro','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name', $location->name)),'required' => true,'container-class' => 'w-full']); ?>
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
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Encargado/Responsable','name' => 'manager_name','placeholder' => 'Nombre de la persona encargada','value' => old('manager_name', $location->manager_name),'containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Encargado/Responsable','name' => 'manager_name','placeholder' => 'Nombre de la persona encargada','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('manager_name', $location->manager_name)),'container-class' => 'w-full']); ?>
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
                    <?php $__errorArgs = ['manager_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-2">
                    <?php if (isset($component)) { $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Textareas.TextareaWithLabel','data' => ['label' => 'Descripción','textareaName' => 'description','rows' => '3','placeholder' => 'Breve descripción de la sede...','containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Descripción','textarea-name' => 'description','rows' => '3','placeholder' => 'Breve descripción de la sede...','container-class' => 'w-full']); ?><?php echo e(old('description', $location->description)); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $attributes = $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $component = $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-1 space-y-2">
                    <label class="block text-sm font-medium text-gray-800">Sede principal</label>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_main" value="<?php echo e(old('is_main', $location->is_main) ? 1 : 0); ?>">
                        <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_main','checked' => old('is_main', $location->is_main),'disabled' => $location->is_main,'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_main','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_main', $location->is_main)),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($location->is_main),'value' => '1']); ?>
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
                        <span class="text-sm text-gray-600">Establecer como sede principal</span>
                    </div>
                    <?php if($location->is_main): ?>
                        <p class="text-xs text-blue-600">Esta es la sede principal. Para cambiarla, asigna otra sede como principal.</p>
                    <?php else: ?>
                        <p class="text-xs text-gray-500">Solo puede haber una sede principal por tienda.</p>
                    <?php endif; ?>
                </div>

                <div class="md:col-span-1 space-y-2">
                    <label class="block text-sm font-medium text-gray-800">Estado</label>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="<?php echo e(old('is_active', $location->is_active) ? 1 : 0); ?>">
                        <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_active','checked' => old('is_active', $location->is_active),'disabled' => $location->is_main,'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', $location->is_active)),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($location->is_main),'value' => '1']); ?>
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
                        <span class="text-sm text-gray-600">Sede activa</span>
                    </div>
                    <?php if($location->is_main): ?>
                        <p class="text-xs text-blue-600">La sede principal debe permanecer activa.</p>
                    <?php else: ?>
                        <p class="text-xs text-gray-500">Las sedes inactivas no se mostrarán en el frontend.</p>
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

        
        <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Contacto y ubicación','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contacto y ubicación','shadow' => 'sm']); ?>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Teléfono *','name' => 'phone','placeholder' => '+57 1 234 5678','value' => old('phone', $location->phone),'required' => true,'containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Teléfono *','name' => 'phone','placeholder' => '+57 1 234 5678','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('phone', $location->phone)),'required' => true,'container-class' => 'w-full']); ?>
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
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'WhatsApp','name' => 'whatsapp','placeholder' => '+57 300 123 4567','value' => old('whatsapp', $location->whatsapp),'containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'WhatsApp','name' => 'whatsapp','placeholder' => '+57 300 123 4567','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('whatsapp', $location->whatsapp)),'container-class' => 'w-full']); ?>
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
                    <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Departamento *','name' => 'department','placeholder' => 'Cundinamarca','value' => old('department', $location->department),'required' => true,'containerClass' => 'w-full','xModel' => 'departmentInput']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Departamento *','name' => 'department','placeholder' => 'Cundinamarca','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('department', $location->department)),'required' => true,'container-class' => 'w-full','x-model' => 'departmentInput']); ?>
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
                    <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-1">
                    <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Ciudad *','name' => 'city','placeholder' => 'Bogotá','value' => old('city', $location->city),'required' => true,'containerClass' => 'w-full','xModel' => 'cityInput']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ciudad *','name' => 'city','placeholder' => 'Bogotá','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('city', $location->city)),'required' => true,'container-class' => 'w-full','x-model' => 'cityInput']); ?>
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
                    <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-2">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex-1">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Dirección *','name' => 'address','placeholder' => 'Calle 123 #45-67, Centro','value' => old('address', $location->address),'required' => true,'containerClass' => 'w-full','xModel' => 'addressInput']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Dirección *','name' => 'address','placeholder' => 'Calle 123 #45-67, Centro','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('address', $location->address)),'required' => true,'container-class' => 'w-full','x-model' => 'addressInput']); ?>
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
                            </div>
                            <div class="flex items-end">
                                <button
                                    type="button"
                                    @click="verifyLocation()"
                                    x-bind:disabled="isGeocoding"
                                    class="h-[42px] px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors flex items-center gap-2 text-sm font-medium"
                                >
                                    <i data-lucide="map-pin" class="w-4 h-4" x-show="!isGeocoding"></i>
                                    <span x-show="!isGeocoding">Verificar ubicación</span>
                                    <span x-show="isGeocoding" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Verificando...
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Preview del mapa -->
                        <div x-show="showMapPreview" x-cloak class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Ubicación encontrada</p>
                                    <p class="text-xs text-gray-600" x-text="formattedAddress"></p>
                                </div>
                                <button
                                    type="button"
                                    @click="clearMapPreview()"
                                    class="text-gray-400 hover:text-gray-600"
                                >
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <div class="rounded-lg overflow-hidden border border-gray-300">
                                <img x-bind:src="mapPreviewUrl" alt="Preview del mapa" class="w-full h-48 object-cover">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Las coordenadas se guardarán automáticamente al actualizar la sede.</p>
                        </div>
                        
                        <!-- Campos hidden para coordenadas -->
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">
                    </div>
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="md:col-span-2">
                    <?php if (isset($component)) { $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Textareas.TextareaWithLabel','data' => ['label' => 'Mensaje de WhatsApp','textareaName' => 'whatsapp_message','rows' => '2','placeholder' => 'Hola, me interesa conocer más sobre sus productos en [Nombre Sede]','containerClass' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Mensaje de WhatsApp','textarea-name' => 'whatsapp_message','rows' => '2','placeholder' => 'Hola, me interesa conocer más sobre sus productos en [Nombre Sede]','container-class' => 'w-full']); ?><?php echo e(old('whatsapp_message', $location->whatsapp_message)); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $attributes = $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $component = $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
                    <p class="text-xs text-gray-500 mt-1">Este mensaje se usará cuando los clientes hagan clic en el botón de WhatsApp.</p>
                    <?php $__errorArgs = ['whatsapp_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Horarios de atención','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Horarios de atención','shadow' => 'sm']); ?>
            <div class="space-y-6">
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">⚡ Aplicar preset rápido</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select
                            x-model="selectedPreset"
                            class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-200 text-sm"
                        >
                            <option value="">-- Selecciona un preset --</option>
                            <option value="weekdays-9-6">Lunes a Viernes 9am-6pm</option>
                            <option value="weekdays-sat-10-8">Lunes a Sábado 10am-8pm</option>
                            <option value="everyday-8-10">Todos los días 8am-10pm</option>
                            <option value="24-7">24 horas / 7 días</option>
                            <option value="nightclub">Nocturno (6pm-2am)</option>
                        </select>
                        <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'solid','color' => 'info','text' => 'Aplicar preset','htmlType' => 'button','@click' => 'applyPreset()','xBind:disabled' => '!selectedPreset']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','text' => 'Aplicar preset','html-type' => 'button','@click' => 'applyPreset()','x-bind:disabled' => '!selectedPreset']); ?>
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
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Los presets llenan automáticamente los horarios. Puedes ajustarlos después.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Día</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cerrado</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario principal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario adicional</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php
                                $days = [
                                    0 => 'Domingo',
                                    1 => 'Lunes',
                                    2 => 'Martes',
                                    3 => 'Miércoles',
                                    4 => 'Jueves',
                                    5 => 'Viernes',
                                    6 => 'Sábado',
                                ];
                            ?>

                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayNum => $dayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php
                                        $schedule = $schedulesByDay[$dayNum] ?? null;
                                        $dbIsClosed = $schedule ? (bool) $schedule->is_closed : false;
                                        $openTime1Value = $schedule && $schedule->open_time_1
                                            ? \Carbon\Carbon::parse($schedule->open_time_1)->format('H:i')
                                            : '';
                                        $closeTime1Value = $schedule && $schedule->close_time_1
                                            ? \Carbon\Carbon::parse($schedule->close_time_1)->format('H:i')
                                            : '';
                                        $openTime2Value = $schedule && $schedule->open_time_2
                                            ? \Carbon\Carbon::parse($schedule->open_time_2)->format('H:i')
                                            : '';
                                        $closeTime2Value = $schedule && $schedule->close_time_2
                                            ? \Carbon\Carbon::parse($schedule->close_time_2)->format('H:i')
                                            : '';
                                    ?>
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-gray-900"><?php echo e($dayName); ?></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center gap-2 text-sm text-gray-600">
                                            <input
                                                type="checkbox"
                                                name="day_<?php echo e($dayNum); ?>_closed"
                                                id="day_<?php echo e($dayNum); ?>_closed"
                                                class="schedule-closed-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                data-day="<?php echo e($dayNum); ?>"
                                                <?php echo e(old("day_{$dayNum}_closed", $dbIsClosed) ? 'checked' : ''); ?>

                                            >
                                            Cerrado
                                        </label>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2"
                                             :class="{ 'opacity-50': document.getElementById('day_<?php echo e($dayNum); ?>_closed')?.checked }">
                                            <input
                                                type="time"
                                                name="day_<?php echo e($dayNum); ?>_open_1"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="<?php echo e(old("day_{$dayNum}_open_1", $openTime1Value)); ?>"
                                                data-day="<?php echo e($dayNum); ?>"
                                            >
                                            <span class="text-gray-500">a</span>
                                            <input
                                                type="time"
                                                name="day_<?php echo e($dayNum); ?>_close_1"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="<?php echo e(old("day_{$dayNum}_close_1", $closeTime1Value)); ?>"
                                                data-day="<?php echo e($dayNum); ?>"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2"
                                             :class="{ 'opacity-50': document.getElementById('day_<?php echo e($dayNum); ?>_closed')?.checked }">
                                            <input
                                                type="time"
                                                name="day_<?php echo e($dayNum); ?>_open_2"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="<?php echo e(old("day_{$dayNum}_open_2", $openTime2Value)); ?>"
                                                data-day="<?php echo e($dayNum); ?>"
                                            >
                                            <span class="text-gray-500">a</span>
                                            <input
                                                type="time"
                                                name="day_<?php echo e($dayNum); ?>_close_2"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="<?php echo e(old("day_{$dayNum}_close_2", $closeTime2Value)); ?>"
                                                data-day="<?php echo e($dayNum); ?>"
                                            >
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Opcional (ej. horario de tarde)</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'soft','color' => 'secondary','size' => 'sm','icon' => 'copy','text' => 'Copiar','htmlType' => 'button','@click' => 'openCopyModal('.e($dayNum).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'soft','color' => 'secondary','size' => 'sm','icon' => 'copy','text' => 'Copiar','html-type' => 'button','@click' => 'openCopyModal('.e($dayNum).')']); ?>
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
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div
                    x-show="showCopyModal"
                    x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center px-4"
                    style="display: none;"
                >
                    <div class="absolute inset-0 bg-gray-900/50" @click="showCopyModal = false"></div>
                    <div class="relative w-full max-w-md rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                        <h4 class="text-base font-semibold text-gray-900 mb-4">
                            Copiar horario de <span x-text="getDayName(copyFromDay)"></span>
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">Selecciona los días a los que deseas copiar este horario:</p>
                        <div class="space-y-2 mb-6">
                            <template x-for="day in [0,1,2,3,4,5,6]" :key="day">
                                <label
                                    x-show="day !== copyFromDay"
                                    class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        :value="day"
                                        x-model="copyToDays"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span x-text="getDayName(day)"></span>
                                </label>
                            </template>
                        </div>
                        <div class="flex gap-3">
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'secondary','text' => 'Cancelar','htmlType' => 'button','class' => 'flex-1','@click' => 'showCopyModal = false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','text' => 'Cancelar','html-type' => 'button','class' => 'flex-1','@click' => 'showCopyModal = false']); ?>
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
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'solid','color' => 'info','text' => 'Copiar horario','htmlType' => 'button','class' => 'flex-1','@click' => 'copySchedule()','xBind:disabled' => 'copyToDays.length === 0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','text' => 'Copiar horario','html-type' => 'button','class' => 'flex-1','@click' => 'copySchedule()','x-bind:disabled' => 'copyToDays.length === 0']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Redes sociales','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Redes sociales','shadow' => 'sm']); ?>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => ''.e($label).'','name' => 'social_'.e($platform).'','placeholder' => 'https://'.e($platform).'.com/mi-sede','value' => ''.e(old('social_' . $platform, optional($socialLinksByPlatform[$platform] ?? null)->url)).'','containerClass' => 'w-full','type' => 'url']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($label).'','name' => 'social_'.e($platform).'','placeholder' => 'https://'.e($platform).'.com/mi-sede','value' => ''.e(old('social_' . $platform, optional($socialLinksByPlatform[$platform] ?? null)->url)).'','container-class' => 'w-full','type' => 'url']); ?>
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
                        <?php $__errorArgs = ["social_{$platform}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

        
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="<?php echo e(route('tenant.admin.locations.index', ['store' => $store->slug])); ?>">
                <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'error','text' => 'Cancelar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'error','text' => 'Cancelar']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'save','text' => 'Actualizar sede','htmlType' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'save','text' => 'Actualizar sede','html-type' => 'submit']); ?>
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
    </form>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('locationForm', () => ({
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',
        selectedPreset: '',
        showCopyModal: false,
        copyFromDay: null,
        copyToDays: [],
        
        // Geocoding state
        addressInput: <?php echo json_encode(old('address', $location->address ?? ''), 512) ?>,
        cityInput: <?php echo json_encode(old('city', $location->city ?? ''), 512) ?>,
        departmentInput: <?php echo json_encode(old('department', $location->department ?? ''), 512) ?>,
        latitude: <?php echo json_encode(old('latitude', $location->latitude), 512) ?>,
        longitude: <?php echo json_encode(old('longitude', $location->longitude), 512) ?>,
        isGeocoding: false,
        showMapPreview: <?php echo json_encode(($location->latitude && $location->longitude) ? true : false, 15, 512) ?>,
        mapPreviewUrl: <?php
            if ($location->latitude && $location->longitude && function_exists('getMapboxStaticMapUrlFromCoordinates')) {
                $mapUrl = getMapboxStaticMapUrlFromCoordinates($location->longitude, $location->latitude, 600, 256);
                echo $mapUrl ? json_encode($mapUrl) : "''";
            } else {
                echo "''";
            }
        ?>,
        formattedAddress: <?php echo json_encode(($location->address ?? '') . ', ' . ($location->city ?? '') . ', ' . ($location->department ?? '')) ?>,
        
        init() {
            // Initialize form behavior
            this.initScheduleCheckboxes();

            <?php if(session('error')): ?>
            if (window.toast) {
                window.toast.error(
                    'Error',
                    '<?php echo e(session('error')); ?>',
                    5000,
                    'bottom-center'
                );
            }
            <?php endif; ?>

            <?php if($errors->any()): ?>
            if (window.toast) {
                const errors = <?php echo json_encode($errors->all(), 15, 512) ?>;
                window.toast.error(
                    'Error de validación',
                    errors.join(', '),
                    5000,
                    'bottom-center'
                );
            }
            <?php endif; ?>
        },
        
        initScheduleCheckboxes() {
            const self = this;
            document.querySelectorAll('.schedule-closed-checkbox').forEach(checkbox => {
                // Remove old event listeners if any
                const oldListener = checkbox._changeListener;
                if (oldListener) {
                    checkbox.removeEventListener('change', oldListener);
                }
                
                // Create a new event listener
                const newListener = function() {
                    const day = this.dataset.day;
                    const open1 = document.querySelector(`[name="day_${day}_open_1"]`);
                    const close1 = document.querySelector(`[name="day_${day}_close_1"]`);
                    const open2 = document.querySelector(`[name="day_${day}_open_2"]`);
                    const close2 = document.querySelector(`[name="day_${day}_close_2"]`);
                    
                    if (this.checked) {
                        // Día cerrado: deshabilitar campos
                        open1.disabled = true;
                        close1.disabled = true;
                        open2.disabled = true;
                        close2.disabled = true;
                    } else {
                        // Día abierto: habilitar campos
                        open1.disabled = false;
                        close1.disabled = false;
                        open2.disabled = false;
                        close2.disabled = false;
                        
                        // Autocompletar horario principal si está vacío O si tiene valores inválidos
                        if (!open1.value || open1.value === '' || open1.value === '00:00') {
                            open1.value = '09:00';
                        }
                        if (!close1.value || close1.value === '' || close1.value === '00:00') {
                            close1.value = '18:00';
                        }
                        
                        // Validar que la hora de apertura sea menor que la de cierre
                        if (open1.value >= close1.value) {
                            open1.value = '09:00';
                            close1.value = '18:00';
                        }
                    }
                };
                
                // Store the listener reference for future cleanup
                checkbox._changeListener = newListener;
                
                // Add the event listener
                checkbox.addEventListener('change', newListener);
                
                // Set initial state
                newListener.call(checkbox);
            });
        },
        
        getDayName(dayNum) {
            const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            return days[dayNum] || '';
        },
        
        showNotificationMessage(message, type = 'success') {
            this.notificationMessage = message;
            this.notificationType = type;
            this.showNotification = true;
            
            setTimeout(() => {
                this.showNotification = false;
            }, 5000);
        },
        
        applyPreset() {
            if (!this.selectedPreset) return;
            
            const presets = {
                'weekdays-9-6': {
                    0: { closed: true },
                    1: { open1: '09:00', close1: '18:00' },
                    2: { open1: '09:00', close1: '18:00' },
                    3: { open1: '09:00', close1: '18:00' },
                    4: { open1: '09:00', close1: '18:00' },
                    5: { open1: '09:00', close1: '18:00' },
                    6: { closed: true }
                },
                'weekdays-sat-10-8': {
                    0: { closed: true },
                    1: { open1: '10:00', close1: '20:00' },
                    2: { open1: '10:00', close1: '20:00' },
                    3: { open1: '10:00', close1: '20:00' },
                    4: { open1: '10:00', close1: '20:00' },
                    5: { open1: '10:00', close1: '20:00' },
                    6: { open1: '10:00', close1: '20:00' }
                },
                'everyday-8-10': {
                    0: { open1: '08:00', close1: '22:00' },
                    1: { open1: '08:00', close1: '22:00' },
                    2: { open1: '08:00', close1: '22:00' },
                    3: { open1: '08:00', close1: '22:00' },
                    4: { open1: '08:00', close1: '22:00' },
                    5: { open1: '08:00', close1: '22:00' },
                    6: { open1: '08:00', close1: '22:00' }
                },
                '24-7': {
                    0: { open1: '00:00', close1: '23:59' },
                    1: { open1: '00:00', close1: '23:59' },
                    2: { open1: '00:00', close1: '23:59' },
                    3: { open1: '00:00', close1: '23:59' },
                    4: { open1: '00:00', close1: '23:59' },
                    5: { open1: '00:00', close1: '23:59' },
                    6: { open1: '00:00', close1: '23:59' }
                },
                'nightclub': {
                    0: { closed: true },
                    1: { closed: true },
                    2: { closed: true },
                    3: { closed: true },
                    4: { open1: '18:00', close1: '02:00' },
                    5: { open1: '18:00', close1: '02:00' },
                    6: { open1: '18:00', close1: '02:00' }
                }
            };
            
            const preset = presets[this.selectedPreset];
            if (!preset) return;
            
            for (let day in preset) {
                const config = preset[day];
                const checkbox = document.querySelector(`[name="day_${day}_closed"]`);
                const open1 = document.querySelector(`[name="day_${day}_open_1"]`);
                const close1 = document.querySelector(`[name="day_${day}_close_1"]`);
                const open2 = document.querySelector(`[name="day_${day}_open_2"]`);
                const close2 = document.querySelector(`[name="day_${day}_close_2"]`);
                
                if (config.closed) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                    open1.value = config.open1;
                    close1.value = config.close1;
                    open2.value = config.open2 || '';
                    close2.value = config.close2 || '';
                }
                
                // Trigger change event
                checkbox.dispatchEvent(new Event('change'));
            }
            
            this.showNotificationMessage('Los horarios se configuraron automáticamente.', 'success');
        },
        
        openCopyModal(dayNum) {
            this.copyFromDay = dayNum;
            this.copyToDays = [];
            this.showCopyModal = true;
        },
        
        copySchedule() {
            if (this.copyToDays.length === 0) return;
            
            const fromDay = this.copyFromDay;
            const fromCheckbox = document.querySelector(`[name="day_${fromDay}_closed"]`);
            const fromOpen1 = document.querySelector(`[name="day_${fromDay}_open_1"]`);
            const fromClose1 = document.querySelector(`[name="day_${fromDay}_close_1"]`);
            const fromOpen2 = document.querySelector(`[name="day_${fromDay}_open_2"]`);
            const fromClose2 = document.querySelector(`[name="day_${fromDay}_close_2"]`);
            
            this.copyToDays.forEach(toDay => {
                const toCheckbox = document.querySelector(`[name="day_${toDay}_closed"]`);
                const toOpen1 = document.querySelector(`[name="day_${toDay}_open_1"]`);
                const toClose1 = document.querySelector(`[name="day_${toDay}_close_1"]`);
                const toOpen2 = document.querySelector(`[name="day_${toDay}_open_2"]`);
                const toClose2 = document.querySelector(`[name="day_${toDay}_close_2"]`);
                
                toCheckbox.checked = fromCheckbox.checked;
                toOpen1.value = fromOpen1.value;
                toClose1.value = fromClose1.value;
                toOpen2.value = fromOpen2.value;
                toClose2.value = fromClose2.value;
                
                // Trigger change event
                toCheckbox.dispatchEvent(new Event('change'));
            });
            
            this.showCopyModal = false;
            
            this.showNotificationMessage(`Se copió el horario a ${this.copyToDays.length} día(s).`, 'success');
        },
        
        async verifyLocation() {
            const address = this.addressInput?.trim();
            const city = this.cityInput?.trim();
            const department = this.departmentInput?.trim();
            
            if (!address || !city || !department) {
                if (window.toast) {
                    window.toast.error(
                        'Campos incompletos',
                        'Por favor completa dirección, ciudad y departamento antes de verificar.',
                        4000,
                        'bottom-center'
                    );
                }
                return;
            }
            
            this.isGeocoding = true;
            
            try {
                const response = await fetch('<?php echo e(route("tenant.admin.locations.geocode", $store->slug)); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        address: address,
                        city: city,
                        department: department
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.latitude = data.latitude;
                    this.longitude = data.longitude;
                    this.mapPreviewUrl = data.map_url;
                    this.formattedAddress = data.formatted_address;
                    this.showMapPreview = true;
                    
                    if (window.toast) {
                        window.toast.success(
                            'Ubicación verificada',
                            'Las coordenadas se guardarán al actualizar la sede.',
                            3000,
                            'bottom-center'
                        );
                    }
                } else {
                    throw new Error(data.message || 'No se pudo encontrar la ubicación');
                }
            } catch (error) {
                console.error('Geocoding error:', error);
                if (window.toast) {
                    window.toast.error(
                        'Error',
                        error.message || 'No se pudo verificar la ubicación. Verifica la dirección e intenta de nuevo.',
                        5000,
                        'bottom-center'
                    );
                }
            } finally {
                this.isGeocoding = false;
            }
        },
        
        clearMapPreview() {
            this.showMapPreview = false;
            this.latitude = null;
            this.longitude = null;
            this.mapPreviewUrl = '';
            this.formattedAddress = '';
        }
    }));
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/locations/edit.blade.php ENDPATH**/ ?>