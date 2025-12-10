

<?php $__env->startSection('title', 'Performance del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('superlinkiu.monitoring.index')); ?>" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Performance del Sistema</h1>
                <p class="text-sm text-gray-600 mt-1">Analiza el rendimiento y optimiza las consultas lentas</p>
            </div>
        </div>
    </div>
    

    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Queries Lentas</h2>
            <p class="text-sm text-gray-500 mt-1">Consultas que tardan más de 1 segundo en ejecutarse</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $slowQueries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $query): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900">
                                <?php echo e($query['execution_time_ms']); ?>ms
                            </span>
                            <?php if($query['route']): ?>
                                <span class="text-xs text-gray-500"><?php echo e($query['route']); ?></span>
                            <?php endif; ?>
                        </div>
                        <pre class="text-xs bg-gray-50 p-3 rounded overflow-x-auto text-gray-700"><?php echo e(Str::limit($query['query'], 200)); ?></pre>
                        <?php if($query['logged_at']): ?>
                            <p class="text-xs text-gray-500 mt-2">
                                <?php echo e(\Carbon\Carbon::parse($query['logged_at'])->diffForHumans()); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500 text-center py-4">No hay queries lentas registradas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    

    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Rutas con Mayor Tiempo de Respuesta</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $slowestRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo e($route['route']); ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e(number_format($route['count'])); ?> requests</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-red-600"><?php echo e($route['avg_time']); ?>ms</p>
                            <p class="text-xs text-gray-500">promedio</p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500 text-center py-4">No hay rutas lentas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/monitoring/performance.blade.php ENDPATH**/ ?>