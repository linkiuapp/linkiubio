
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sede
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ubicación
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contacto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activar/Desactivar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado operativo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr
                                class="hover:bg-gray-50 transition-colors"
                                data-location-id="<?php echo e($location->id); ?>"
                                data-location-main="<?php echo e($location->is_main ? 'true' : 'false'); ?>"
                                data-set-main-url="<?php echo e(route('tenant.admin.locations.set-as-main', ['store' => $store->slug, 'location' => $location->id])); ?>"
                            >
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-semibold text-blue-600">
                                            <?php echo e(mb_strtoupper(mb_substr($location->name, 0, 2))); ?>

                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2" data-location-main-wrapper>
                                                <p class="text-sm font-semibold text-gray-900"><?php echo e($location->name); ?></p>
                                                <?php if($location->is_main): ?>
                                                    <span class="badge-principal inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Principal</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($location->manager_name): ?>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <span class="font-medium text-gray-700">Encargado:</span> <?php echo e($location->manager_name); ?>

                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <p class="text-sm text-gray-900"><?php echo e($location->city); ?>, <?php echo e($location->department); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($location->address); ?></p>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <p class="text-sm text-gray-900"><?php echo e($location->phone); ?></p>
                                    <?php if($location->whatsapp): ?>
                                        <p class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-700">WhatsApp:</span> <?php echo e($location->whatsapp); ?>

                                        </p>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-2">
                                        <label for="toggle-<?php echo e($location->id); ?>" class="flex items-center gap-3">
                                            <span class="text-xs font-medium text-gray-600">
                                                <?php echo e($location->is_active ? 'Activa' : 'Inactiva'); ?>

                                            </span>
                                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    id="toggle-<?php echo e($location->id); ?>"
                                                    class="peer sr-only location-toggle"
                                                    data-url="<?php echo e(route('tenant.admin.locations.toggle-status', ['store' => $store->slug, 'location' => $location->id])); ?>"
                                                    <?php echo e($location->is_active ? 'checked' : ''); ?>

                                                    <?php echo e($location->is_main ? 'disabled' : ''); ?>

                                                >
                                                <span class="toggle-track absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 <?php echo e($location->is_main ? 'opacity-50 cursor-not-allowed' : ''); ?>"></span>
                                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                            </label>
                                            <span data-location-main-tooltip class="<?php echo e($location->is_main ? '' : 'hidden'); ?>">
                                                <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'No puedes desactivar la sede principal. Asigna otra sede como principal primero.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'No puedes desactivar la sede principal. Asigna otra sede como principal primero.']); ?>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-2">
                                        <?php
                                            $operationalStatus = $location->currentStatus['status'] ?? 'closed';
                                            $statusMap = [
                                                'open' => ['type' => 'success', 'text' => 'Abierto'],
                                                'temporarily_closed' => ['type' => 'warning', 'text' => 'Cerrado temporalmente'],
                                                'closed' => ['type' => 'error', 'text' => 'Cerrado'],
                                            ];
                                            $operationalBadge = $statusMap[$operationalStatus] ?? $statusMap['closed'];
                                        ?>
                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $operationalBadge['type'],'text' => $operationalBadge['text']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($operationalBadge['type']),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($operationalBadge['text'])]); ?>
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
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-2">
                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Ver detalles']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Ver detalles']); ?>
                                            <a
                                                href="<?php echo e(route('tenant.admin.locations.show', ['store' => $store->slug, 'location' => $location->id])); ?>"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>

                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Editar']); ?>
                                            <a
                                                href="<?php echo e(route('tenant.admin.locations.edit', ['store' => $store->slug, 'location' => $location->id])); ?>"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>

                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Eliminar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Eliminar']); ?>
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                aria-label="Eliminar"
                                                @click.stop="deleteLocation(<?php echo e($location->id); ?>, '<?php echo e(addslashes($location->name)); ?>', $event)"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>

                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Establecer como principal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Establecer como principal']); ?>
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors <?php echo e($location->is_main ? 'hidden' : ''); ?>"
                                                aria-label="Establecer como principal"
                                                data-location-set-main
                                                data-url="<?php echo e(route('tenant.admin.locations.set-as-main', ['store' => $store->slug, 'location' => $location->id])); ?>"
                                                <?php echo e($location->is_main ? 'disabled' : ''); ?>

                                            >
                                                <i data-lucide="star" class="w-4 h-4"></i>
                                            </button>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12">
                                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::EmptyStates.EmptyState','data' => ['svg' => $emptyStateSvg,'title' => $emptyStateTitle,'message' => $emptyStateMessage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['svg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateSvg),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateTitle),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateMessage)]); ?>
                                        <?php if($remainingSlots > 0): ?>
                                             <?php $__env->slot('action', null, []); ?> 
                                                <a href="<?php echo e(route('tenant.admin.locations.create', ['store' => $store->slug])); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear sede']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear sede']); ?>
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
                                             <?php $__env->endSlot(); ?>
                                        <?php endif; ?>
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
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr id="dynamic-empty-state" style="display: none;">
                            <td colspan="5" class="px-6 py-12">
                                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::EmptyStates.EmptyState','data' => ['svg' => $emptyStateSvg,'title' => $emptyStateTitle,'message' => $emptyStateMessage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['svg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateSvg),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateTitle),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateMessage)]); ?>
                                    <?php if($remainingSlots > 0): ?>
                                         <?php $__env->slot('action', null, []); ?> 
                                            <a href="<?php echo e(route('tenant.admin.locations.create', ['store' => $store->slug])); ?>">
                                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear sede']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear sede']); ?>
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
                                         <?php $__env->endSlot(); ?>
                                    <?php endif; ?>
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/locations/components/table-view.blade.php ENDPATH**/ ?>