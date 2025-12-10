

<?php $__env->startSection('title', 'Monitoreo del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Monitoreo del Sistema</h2>
                    <p class="text-sm text-gray-600">Monitoreo en tiempo real de errores, tráfico y performance</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('superlinkiu.monitoring.alerts.index')); ?>" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        Alertas
                    </a>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Errores','value' => $summary['errors_count'],'icon' => 'alert-triangle','color' => 'error','description' => 'Últimas 24 horas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Errores','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['errors_count']),'icon' => 'alert-triangle','color' => 'error','description' => 'Últimas 24 horas']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Tráfico','value' => number_format($summary['traffic_count']),'icon' => 'activity','color' => 'primary','description' => 'Requests últimas 24h']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tráfico','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($summary['traffic_count'])),'icon' => 'activity','color' => 'primary','description' => 'Requests últimas 24h']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Tiempo Promedio','value' => $summary['avg_response_time'] . ' ms','icon' => 'clock','color' => 'info','description' => 'Tiempo de respuesta']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tiempo Promedio','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['avg_response_time'] . ' ms'),'icon' => 'clock','color' => 'info','description' => 'Tiempo de respuesta']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Tasa de Errores','value' => $summary['error_rate'] . '%','icon' => 'percent','color' => 'warning','description' => 'Porcentaje de errores']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tasa de Errores','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['error_rate'] . '%'),'icon' => 'percent','color' => 'warning','description' => 'Porcentaje de errores']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
    </div>
    

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <?php if (isset($component)) { $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.ChartWidget','data' => ['type' => 'line','title' => 'Errores por Día (Últimos 7 días)','data' => [
                'labels' => array_column($errorsByDay, 'date'),
                'datasets' => [[
                    'label' => 'Errores',
                    'data' => array_column($errorsByDay, 'error'),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ], [
                    'label' => 'Advertencias',
                    'data' => array_column($errorsByDay, 'warning'),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ]]
            ],'chartId' => 'errorsChart','height' => '300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'line','title' => 'Errores por Día (Últimos 7 días)','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'labels' => array_column($errorsByDay, 'date'),
                'datasets' => [[
                    'label' => 'Errores',
                    'data' => array_column($errorsByDay, 'error'),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ], [
                    'label' => 'Advertencias',
                    'data' => array_column($errorsByDay, 'warning'),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ]]
            ]),'chartId' => 'errorsChart','height' => '300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc)): ?>
<?php $attributes = $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc; ?>
<?php unset($__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal73a5a89601e1c9bf43a67bed690c06cc)): ?>
<?php $component = $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc; ?>
<?php unset($__componentOriginal73a5a89601e1c9bf43a67bed690c06cc); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.ChartWidget','data' => ['type' => 'bar','title' => 'Tráfico por Día (Últimos 7 días)','data' => [
                'labels' => array_column($trafficByDay, 'date'),
                'datasets' => [[
                    'label' => 'Requests',
                    'data' => array_column($trafficByDay, 'count'),
                    'backgroundColor' => '#7432F8',
                    'borderColor' => '#7432F8',
                    'borderWidth' => 1
                ]]
            ],'chartId' => 'trafficChart','height' => '300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'bar','title' => 'Tráfico por Día (Últimos 7 días)','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                'labels' => array_column($trafficByDay, 'date'),
                'datasets' => [[
                    'label' => 'Requests',
                    'data' => array_column($trafficByDay, 'count'),
                    'backgroundColor' => '#7432F8',
                    'borderColor' => '#7432F8',
                    'borderWidth' => 1
                ]]
            ]),'chartId' => 'trafficChart','height' => '300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc)): ?>
<?php $attributes = $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc; ?>
<?php unset($__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal73a5a89601e1c9bf43a67bed690c06cc)): ?>
<?php $component = $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc; ?>
<?php unset($__componentOriginal73a5a89601e1c9bf43a67bed690c06cc); ?>
<?php endif; ?>
    </div>
    

    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Errores Recientes</h3>
                <a href="<?php echo e(route('superlinkiu.monitoring.errors')); ?>" 
                   class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                    Ver todos →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ocurrencias</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última vez</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $recentErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $levelColors = [
                                        'ERROR' => 'bg-red-100 text-red-800',
                                        'WARNING' => 'bg-yellow-100 text-yellow-800',
                                        'INFO' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $color = $levelColors[$error['level']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($color); ?>">
                                    <?php echo e($error['level']); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-md truncate">
                                    <?php echo e(Str::limit($error['message'], 80)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($error['route'] ?? 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($error['occurrence_count'] ?? 1); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($error['last_occurred_at'])->diffForHumans()); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo e(route('superlinkiu.monitoring.errors.show', $error['id'])); ?>" 
                                   class="text-primary-600 hover:text-primary-900">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay errores recientes
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <h3 class="text-lg font-semibold text-gray-900">Rutas Más Visitadas</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $topRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo e($route['route']); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e(number_format($route['count'])); ?> requests</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($route['avg_time']); ?>ms</p>
                                <p class="text-xs text-gray-500">promedio</p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500 text-center py-4">No hay datos disponibles</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <h3 class="text-lg font-semibold text-gray-900">Rutas Más Lentas</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $slowestRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo e($route['route']); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e(number_format($route['count'])); ?> requests</p>
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
    

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="<?php echo e(route('superlinkiu.monitoring.errors')); ?>" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Errores</h3>
                    <p class="text-sm text-gray-500">Ver todos los errores</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('superlinkiu.monitoring.traffic')); ?>" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="activity" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Tráfico</h3>
                    <p class="text-sm text-gray-500">Análisis de tráfico</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('superlinkiu.monitoring.performance')); ?>" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="gauge" class="w-6 h-6 text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Performance</h3>
                    <p class="text-sm text-gray-500">Métricas de rendimiento</p>
                </div>
            </div>
        </a>
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


<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/monitoring/index.blade.php ENDPATH**/ ?>