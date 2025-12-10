



<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-4">
        
        <div class="flex bg-accent-100 rounded-lg p-1">
            <a href="<?php echo e(route('superlinkiu.stores.index', array_merge(request()->all(), ['view' => 'table']))); ?>" 
                class="px-3 py-1.5 rounded transition-colors <?php echo e($viewType === 'table' ? 'bg-primary-200 text-accent-50' : 'text-black-300'); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-list-outline'); ?>
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
            </a>
            <a href="<?php echo e(route('superlinkiu.stores.index', array_merge(request()->all(), ['view' => 'cards']))); ?>" 
                class="px-3 py-1.5 rounded transition-colors <?php echo e($viewType === 'cards' ? 'bg-primary-200 text-accent-50' : 'text-black-300'); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-widget-2-outline'); ?>
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
            </a>
        </div>

        
        <span class="text-sm text-black-300">
            Mostrando <?php echo e($stores->firstItem() ?? 0); ?> - <?php echo e($stores->lastItem() ?? 0); ?> de <?php echo e($stores->total()); ?> tiendas
        </span>
    </div>

    
    <div class="flex items-center gap-3" id="bulkActions" style="display: none;">
        <span class="text-sm text-black-300">
            <span id="selectedCount">0</span> seleccionadas
        </span>
        <select id="bulkActionSelect" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none">
            <option value="">Acción en lote...</option>
            <option value="activate">Activar</option>
            <option value="deactivate">Desactivar</option>
            <option value="suspend">Suspender</option>
            <option value="verify">Verificar</option>
            <option value="unverify">Quitar verificación</option>
            <option value="delete">Eliminar</option>
        </select>
        <button @click="executeBulkAction()" class="btn-primary px-3 py-1.5 rounded-lg text-sm">
            Aplicar
        </button>
    </div>
</div> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/stores/components/toolbar.blade.php ENDPATH**/ ?>