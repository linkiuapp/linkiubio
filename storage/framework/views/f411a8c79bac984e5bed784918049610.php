<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-lg font-bold text-gray-900">Dashboard</h1>
        <a href="<?php echo e(route('superlinkiu.stores.create')); ?>" class="bg-primary-300 hover:bg-primary-400 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Nueva Tienda
        </a>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Total Tiendas','value' => $stats['total_stores'],'icon' => 'store','color' => 'primary','description' => 'Total de tiendas registradas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total Tiendas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_stores']),'icon' => 'store','color' => 'primary','description' => 'Total de tiendas registradas']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Tiendas Activas','value' => $stats['active_stores'],'icon' => 'check-circle','color' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tiendas Activas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['active_stores']),'icon' => 'check-circle','color' => 'success']); ?>
             <?php $__env->slot('badge', null, []); ?> 
                <span class="text-xs font-medium text-success-600"><?php echo e($stats['active_percentage']); ?>% del total</span>
             <?php $__env->endSlot(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Verificadas','value' => $stats['verified_stores'],'icon' => 'shield-check','color' => 'info','description' => 'Con documentación verificada']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Verificadas','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['verified_stores']),'icon' => 'shield-check','color' => 'info','description' => 'Con documentación verificada']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.StatCard','data' => ['title' => 'Ingresos del Mes','value' => '$' . number_format($monthlyRevenue, 0, ',', '.') . ' COP','icon' => 'wallet','color' => 'secondary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ingresos del Mes','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('$' . number_format($monthlyRevenue, 0, ',', '.') . ' COP'),'icon' => 'wallet','color' => 'secondary']); ?>
             <?php $__env->slot('badge', null, []); ?> 
                <?php if($revenueGrowth > 0): ?>
                    <span class="text-xs font-medium text-success-600 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i>
                        +<?php echo e($revenueGrowth); ?>%
                    </span>
                <?php else: ?>
                    <span class="text-xs font-medium text-red-600 flex items-center gap-1">
                        <i data-lucide="trending-down" class="w-3 h-3"></i>
                        <?php echo e($revenueGrowth); ?>%
                    </span>
                <?php endif; ?>
             <?php $__env->endSlot(); ?>
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

    
    <?php if (isset($component)) { $__componentOriginal7948b302515c434d1b13060e286832b1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7948b302515c434d1b13060e286832b1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.PendingRequestsWidget','data' => ['stats' => $pendingStats,'viewAllUrl' => route('superlinkiu.store-requests.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pending-requests-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingStats),'viewAllUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('superlinkiu.store-requests.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7948b302515c434d1b13060e286832b1)): ?>
<?php $attributes = $__attributesOriginal7948b302515c434d1b13060e286832b1; ?>
<?php unset($__attributesOriginal7948b302515c434d1b13060e286832b1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7948b302515c434d1b13060e286832b1)): ?>
<?php $component = $__componentOriginal7948b302515c434d1b13060e286832b1; ?>
<?php unset($__componentOriginal7948b302515c434d1b13060e286832b1); ?>
<?php endif; ?>

    
    <?php if(count($alerts) > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $alertType = match($alert['type']) {
                        'error' => 'error',
                        'warning' => 'warning',
                        'info' => 'success',
                        default => 'success'
                    };
                ?>
                <?php if (isset($component)) { $__componentOriginal4e12e3fb830c932c6bff0347987a4573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e12e3fb830c932c6bff0347987a4573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => ''.e($alertType).'','title' => ''.e($alert['title']).'','message' => ''.e($alert['message']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => ''.e($alertType).'','title' => ''.e($alert['title']).'','message' => ''.e($alert['message']).'']); ?>
                    <?php if(isset($alert['items'])): ?>
                        <ul class="mt-2 space-y-1">
                            <?php $__currentLoopData = $alert['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm">
                                    • <?php echo e($item['store']); ?> - Plan <?php echo e($item['plan']); ?> (<?php echo e($item['days']); ?> días)
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(isset($alert['action'])): ?>
                        <a href="<?php echo e($alert['action']); ?>" class="text-sm font-semibold mt-2 inline-block underline">
                            Ver detalles →
                        </a>
                    <?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $attributes = $__attributesOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $component = $__componentOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__componentOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <?php if (isset($component)) { $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.ChartWidget','data' => ['type' => 'line','title' => 'Crecimiento Mensual','data' => $growthChartData,'chartId' => 'growthChart','height' => '300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'line','title' => 'Crecimiento Mensual','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($growthChartData),'chartId' => 'growthChart','height' => '300']); ?>
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
        
        <?php if(count($storesByPlan) > 0): ?>
            <?php if (isset($component)) { $__componentOriginal73a5a89601e1c9bf43a67bed690c06cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73a5a89601e1c9bf43a67bed690c06cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.ChartWidget','data' => ['type' => 'doughnut','title' => 'Distribución por Plan','data' => $planChartData,'chartId' => 'planChart','height' => '300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'doughnut','title' => 'Distribución por Plan','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($planChartData),'chartId' => 'planChart','height' => '300']); ?>
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
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribución por Plan</h3>
                <div class="flex items-center justify-center h-[300px]">
                    <div class="text-center">
                        <i data-lucide="pie-chart" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-sm text-gray-500">No hay datos disponibles</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginaleb4a655e31b73bf002e563e24004e77e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb4a655e31b73bf002e563e24004e77e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.LatestStoresTableWidget','data' => ['stores' => $latestStores,'viewAllUrl' => route('superlinkiu.stores.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('latest-stores-table-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stores' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($latestStores),'viewAllUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('superlinkiu.stores.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb4a655e31b73bf002e563e24004e77e)): ?>
<?php $attributes = $__attributesOriginaleb4a655e31b73bf002e563e24004e77e; ?>
<?php unset($__attributesOriginaleb4a655e31b73bf002e563e24004e77e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb4a655e31b73bf002e563e24004e77e)): ?>
<?php $component = $__componentOriginaleb4a655e31b73bf002e563e24004e77e; ?>
<?php unset($__componentOriginaleb4a655e31b73bf002e563e24004e77e); ?>
<?php endif; ?>
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

<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/dashboard.blade.php ENDPATH**/ ?>