
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cupón
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo y descuento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Validez
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uso
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            
                            <?php
                                $usagePercentage = $coupon->max_uses ? min(100, (int) round(($coupon->current_uses / $coupon->max_uses) * 100)) : null;
                                $progressColor = $usagePercentage === null
                                    ? 'info'
                                    : ($usagePercentage >= 80 ? 'red' : ($usagePercentage >= 60 ? 'yellow' : 'green'));
                                $statusBadgeType = $statusBadgeMap[$coupon->status_info['text']] ?? 'info';
                                $typeBadge = $typeBadgeMap[$coupon->type] ?? 'info';
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors" data-coupon-id="<?php echo e($coupon->id); ?>">
                                
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2">
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($coupon->name); ?></p>
                                        <?php if($coupon->is_public || $coupon->is_automatic): ?>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <?php if($coupon->is_public): ?>
                                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => 'Público']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => 'Público']); ?>
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

                                                <?php if($coupon->is_automatic): ?>
                                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'success','text' => 'Automático']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','text' => 'Automático']); ?>
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
                                        <?php endif; ?>
                                    </div>
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top ">
                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'dark','text' => 'Código: '.e($coupon->code).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'dark','text' => 'Código: '.e($coupon->code).'']); ?>
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
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2">
                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $typeBadge,'text' => \App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] ?? ucfirst($coupon->type)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($typeBadge),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] ?? ucfirst($coupon->type))]); ?>
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
                                        <p class="text-sm text-gray-700">
                                            <?php if($coupon->discount_type === 'percentage'): ?>
                                                <span class="font-semibold text-gray-900"><?php echo e($coupon->discount_value); ?>%</span> de descuento
                                            <?php else: ?>
                                                <span class="font-semibold text-gray-900">$<?php echo e(number_format($coupon->discount_value, 0, ',', '.')); ?></span> de descuento
                                            <?php endif; ?>
                                        </p>
                                        <?php if($coupon->min_purchase_amount): ?>
                                            <p class="text-xs text-gray-500">Compra mínima: $<?php echo e(number_format($coupon->min_purchase_amount, 0, ',', '.')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm text-gray-700 space-y-1">
                                        <?php if($coupon->start_date): ?>
                                            <p>Desde <?php echo e($coupon->start_date->format('d/m/Y')); ?></p>
                                        <?php endif; ?>
                                        <?php if($coupon->end_date): ?>
                                            <p>Hasta <?php echo e($coupon->end_date->format('d/m/Y')); ?></p>
                                        <?php endif; ?>
                                        <?php if (! ($coupon->start_date || $coupon->end_date)): ?>
                                            <p>Sin límite definido</p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p>
                                            <span class="font-semibold text-gray-900"><?php echo e($coupon->current_uses); ?></span>
                                            <?php if($coupon->max_uses): ?>
                                                / <?php echo e($coupon->max_uses); ?> usos
                                            <?php else: ?>
                                                usos ilimitados
                                            <?php endif; ?>
                                        </p>
                                        <?php if($usagePercentage !== null): ?>
                                            <?php if (isset($component)) { $__componentOriginal536e95f6530dab970742d3c959f12236 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal536e95f6530dab970742d3c959f12236 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Progress.ProgressBasic','data' => ['value' => $usagePercentage,'color' => $progressColor]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('progress-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($usagePercentage),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($progressColor)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal536e95f6530dab970742d3c959f12236)): ?>
<?php $attributes = $__attributesOriginal536e95f6530dab970742d3c959f12236; ?>
<?php unset($__attributesOriginal536e95f6530dab970742d3c959f12236); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal536e95f6530dab970742d3c959f12236)): ?>
<?php $component = $__componentOriginal536e95f6530dab970742d3c959f12236; ?>
<?php unset($__componentOriginal536e95f6530dab970742d3c959f12236); ?>
<?php endif; ?>
                                            <p class="text-xs text-gray-500"><?php echo e($usagePercentage); ?>% utilizado</p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top">
                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $statusBadgeType,'text' => $coupon->status_info['text']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusBadgeType),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($coupon->status_info['text'])]); ?>
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
                                </td>
                                

                                
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center justify-center gap-2">
                                        
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
                                                href="<?php echo e(route('tenant.admin.coupons.show', ['store' => $store->slug, 'coupon' => $coupon])); ?>"
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
                                                href="<?php echo e(route('tenant.admin.coupons.edit', ['store' => $store->slug, 'coupon' => $coupon])); ?>"
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => $coupon->is_active ? 'Desactivar' : 'Activar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($coupon->is_active ? 'Desactivar' : 'Activar')]); ?>
                                            <form
                                                method="POST"
                                                action="<?php echo e(route('tenant.admin.coupons.toggle-status', ['store' => $store->slug, 'coupon' => $coupon])); ?>"
                                                class="inline"
                                            >
                                                <?php echo csrf_field(); ?>
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 <?php echo e($coupon->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-teal-600 hover:bg-teal-50'); ?> rounded-lg transition-colors"
                                                    aria-label="<?php echo e($coupon->is_active ? 'Desactivar' : 'Activar'); ?>"
                                                >
                                                    <i data-lucide="<?php echo e($coupon->is_active ? 'pause' : 'play'); ?>" class="w-4 h-4"></i>
                                                </button>
                                            </form>
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
                                        

                                        <?php if($coupon->current_uses === 0): ?>
                                            
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
                                                    @click.stop="deleteCoupon({
                                                        id: <?php echo e($coupon->id); ?>,
                                                        name: <?php echo \Illuminate\Support\Js::from($coupon->name)->toHtml() ?>,
                                                        url: <?php echo \Illuminate\Support\Js::from(route('tenant.admin.coupons.destroy', ['store' => $store->slug, 'coupon' => $coupon]))->toHtml() ?>
                                                    }, $event)"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    aria-label="Eliminar"
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
                                            
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                            <tr>
                                <td colspan="7" class="px-6 py-12">
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
                                         <?php $__env->slot('action', null, []); ?> 
                                            <?php if(request()->hasAny(['search', 'status', 'type', 'discount_type'])): ?>
                                                <a href="<?php echo e(route('tenant.admin.coupons.index', ['store' => $store->slug])); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'rotate-ccw','text' => 'Limpiar filtros']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'rotate-ccw','text' => 'Limpiar filtros']); ?>
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
                                            <?php elseif($remainingSlots > 0): ?>
                                                <a href="<?php echo e(route('tenant.admin.coupons.create', ['store' => $store->slug])); ?>">
                                                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear primer cupón']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear primer cupón']); ?>
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
                                            <?php endif; ?>
                                         <?php $__env->endSlot(); ?>
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

                        
                        <tr id="coupons-empty-state" class="hidden">
                            <td colspan="6" class="px-6 py-12">
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
                                     <?php $__env->slot('action', null, []); ?> 
                                        <?php if(request()->hasAny(['search', 'status', 'type', 'discount_type'])): ?>
                                            <a href="<?php echo e(route('tenant.admin.coupons.index', ['store' => $store->slug])); ?>">
                                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'rotate-ccw','text' => 'Limpiar filtros']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'rotate-ccw','text' => 'Limpiar filtros']); ?>
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
                                        <?php elseif($remainingSlots > 0): ?>
                                            <a href="<?php echo e(route('tenant.admin.coupons.create', ['store' => $store->slug])); ?>">
                                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear primer cupón']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Crear primer cupón']); ?>
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
                                        <?php endif; ?>
                                     <?php $__env->endSlot(); ?>
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


<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/coupons/components/table-view.blade.php ENDPATH**/ ?>