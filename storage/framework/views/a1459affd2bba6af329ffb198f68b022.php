



<div class="table-container">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                
                
                <tr class="table-header">
                    <th class="px-6 py-3">
                        <input type="checkbox" id="selectAll" class="rounded border-accent-300">
                    </th>
                    <th class="px-6 py-3 text-left">Tienda</th>
                    <th class="px-6 py-3 text-left">Plan</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-left">Verificada</th>
                    <th class="px-6 py-3 text-left">Creada</th>
                    <th class="px-12 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-accent-50 divide-y divide-accent-100">
                <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="text-black-400 hover:bg-accent-100">
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" class="store-checkbox rounded border-accent-300" value="<?php echo e($store->id); ?>">
                        </td>

                        
                        
                        <td class="px-6 py-4">
                            <div class="flex text-sm">
                                <?php if($store->design && $store->design->is_published && $store->design->logo_url): ?>
                                    <div class="relative hidden w-10 h-10 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="<?php echo e($store->design->logo_url); ?>"
                                            alt="<?php echo e($store->name); ?>"
                                            loading="lazy" />
                                    </div>
                                <?php else: ?>
                                    <div class="w-10 h-10 mr-3 rounded-full bg-primary-100 flex items-center justify-center">
                                        <span class="text-primary-300 font-semibold text-sm">
                                            <?php echo e(strtoupper(substr($store->name, 0, 2))); ?>

                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold"><?php echo e($store->name); ?></p>
                                    <p class="text-xs text-black-200"><?php echo e($store->email); ?></p>
                                    <p class="text-xs text-black-200"><?php echo e($store->slug); ?></p>
                                    <p class="text-xs text-black-200"><?php echo e($store->phone); ?></p>
                                </div>
                            </div>
                        </td>

                        
                        
                        <td class="py-4 text-sm">
                            <span class="bagde-table-primary"><?php echo e($store->plan->name); ?></span>
                        </td>

                        
                        
                        <td class="px-2 py-4 text-sm">
                            <?php if($store->status === 'active'): ?>
                                <span class="bagde-table-success">Activa</span>
                            <?php elseif($store->status === 'inactive'): ?>
                                <span class="bagde-table-warning">Inactiva</span>
                            <?php else: ?>
                                <span class="bg-error-200 text-accent-50 px-2 py-1 rounded-full text-xs font-medium">Suspendida</span>
                            <?php endif; ?>
                        </td>

                        
                        
                        <td class="px-6 py-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            class="sr-only peer verified-toggle"
                                            <?php echo e($store->verified ? 'checked' : ''); ?>

                                            data-store-id="<?php echo e($store->id); ?>"
                                            data-url="<?php echo e(route('superlinkiu.stores.toggle-verified', $store)); ?>">
                                        <div class="table-toggle"></div>
                                    </label>
                        </td>

                        
                        
                        <td class="px-4 py-4 text-sm text-black-200">
                            <?php echo e($store->created_at->format('d/m/Y')); ?>

                        </td>

                        
                        
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('superlinkiu.stores.show', $store)); ?>"
                                    class="table-action-show" 
                                    title="Ver detalles">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-eye-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-action-icon']); ?>
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
                                </a>
                                <a href="<?php echo e(route('superlinkiu.stores.edit', $store)); ?>"
                                    class="table-action-edit"
                                    title="Editar">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-pen-2-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-action-icon']); ?>
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
                                </a>
                                <button type="button" 
                                    onclick="event.preventDefault(); event.stopPropagation(); window.handleLoginAsStore('<?php echo e($store->slug); ?>');"
                                    class="table-action-login"
                                    title="Entrar como admin">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-login-3-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-action-icon']); ?>
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
                                </button>
                                <button @click="openDeleteModal('<?php echo e($store->slug); ?>', '<?php echo e($store->name); ?>')"
                                    class="table-action-delete"
                                    title="Eliminar">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-trash-bin-trash-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-action-icon']); ?>
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
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                    
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-black-200">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-box-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-12 h-12 mx-auto mb-3 text-black-100']); ?>
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
                            <p class="text-base font-semibold">No se encontraron tiendas con los filtros aplicados</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/stores/components/table-view.blade.php ENDPATH**/ ?>