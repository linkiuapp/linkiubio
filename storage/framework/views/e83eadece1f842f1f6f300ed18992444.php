



<div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
    <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
        <h2 class="text-body-regular text-black-500 mb-0 font-bold">Filtros de Búsqueda</h2>
    </div>
    
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('superlinkiu.stores.index')); ?>" id="filterForm">
            <input type="hidden" name="view" value="<?php echo e($viewType); ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-black-300 mb-2">Buscar</label>
                    <div class="relative">
                        <input type="text" 
                            name="search" 
                            value="<?php echo e(request('search')); ?>"
                            placeholder="Buscar por nombre, email, documento o slug..."
                            class="w-full pl-10 pr-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-magnifer-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-black-200 absolute left-3 top-2.5']); ?>
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
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">Plan</label>
                    <select name="plan_id" class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                        <option value="">Todos los planes</option>
                        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($plan->id); ?>" <?php echo e(request('plan_id') == $plan->id ? 'selected' : ''); ?>>
                                <?php echo e($plan->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">Estado</label>
                    <select name="status" class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                        <option value="">Todos los estados</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Activa</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactiva</option>
                        <option value="suspended" <?php echo e(request('status') == 'suspended' ? 'selected' : ''); ?>>Suspendida</option>
                    </select>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">Verificación</label>
                    <select name="verified" class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                        <option value="">Todas</option>
                        <option value="1" <?php echo e(request('verified') === '1' ? 'selected' : ''); ?>>Verificadas</option>
                        <option value="0" <?php echo e(request('verified') === '0' ? 'selected' : ''); ?>>No verificadas</option>
                    </select>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">Desde</label>
                    <input type="date" 
                        name="start_date" 
                        value="<?php echo e(request('start_date')); ?>"
                        class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">Hasta</label>
                    <input type="date" 
                        name="end_date" 
                        value="<?php echo e(request('end_date')); ?>"
                        class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                </div>

                
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary px-4 py-2 rounded-lg flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-filter-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
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
                        Filtrar
                    </button>
                    <a href="<?php echo e(route('superlinkiu.stores.index')); ?>" class="btn-outline-secondary px-4 py-2 rounded-lg">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/stores/components/filters.blade.php ENDPATH**/ ?>