<div class="px-6 py-4">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="text-sm text-gray-600 mb-0">
           <?php if (isset($component)) { $__componentOriginal306e6fb75124299030121a954cc21860 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal306e6fb75124299030121a954cc21860 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeIndicator','data' => ['class' => 'caption-strong','text' => 'Versión Beta 1.0.1','type' => 'error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'caption-strong','text' => 'Versión Beta 1.0.1','type' => 'error']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal306e6fb75124299030121a954cc21860)): ?>
<?php $attributes = $__attributesOriginal306e6fb75124299030121a954cc21860; ?>
<?php unset($__attributesOriginal306e6fb75124299030121a954cc21860); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal306e6fb75124299030121a954cc21860)): ?>
<?php $component = $__componentOriginal306e6fb75124299030121a954cc21860; ?>
<?php unset($__componentOriginal306e6fb75124299030121a954cc21860); ?>
<?php endif; ?>
           - © <?php echo e(date('Y')); ?> <strong>Linkiu.bio</strong>. Todos los derechos reservados | Desarrollado por <strong>Linkiu Devs ♥️</strong>
        </p>
        <div class="flex flex-wrap items-center gap-3 text-xs">
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Acerca de <strong>Linkiu</strong></span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Términos y condiciones</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de privacidad</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Política de cookies</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
            <a href="#" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span>Políticas de envío</span>
                <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </a>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide en el footer
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/admin/footer.blade.php ENDPATH**/ ?>