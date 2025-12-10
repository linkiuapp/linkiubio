

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'stats' => [],
    'viewAllUrl' => '#',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'stats' => [],
    'viewAllUrl' => '#',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $hasCritical = ($stats['critical'] ?? 0) > 0;
    $hasUrgent = ($stats['urgent'] ?? 0) > 0 && !$hasCritical;
?>

<?php if(($stats['total'] ?? 0) > 0): ?>
<div class="bg-white border-l-4 <?php echo e($hasCritical ? 'border-red-500' : ($hasUrgent ? 'border-orange-500' : 'border-warning-400')); ?> rounded-lg shadow-sm overflow-hidden relative">
    
    <?php if($hasCritical): ?>
    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
        🚨 <?php echo e($stats['critical']); ?> CRÍTICA(S)
    </div>
    <?php elseif($hasUrgent): ?>
    <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
        ⚠️ <?php echo e($stats['urgent']); ?> URGENTE(S)
    </div>
    <?php endif; ?>
    
    <div class="p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                    <div class="w-10 h-10 bg-warning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-warning-500"></i>
                    </div>
                    Solicitudes de Tiendas Pendientes
                </h3>
                <p class="text-sm text-gray-600">
                    <?php echo e($stats['total']); ?> solicitud(es) esperando revisión
                    <?php if(isset($stats['oldest']) && $stats['oldest']): ?>
                        • La más antigua: <strong><?php echo e($stats['oldest']->created_at->diffForHumans()); ?></strong>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Pendientes</p>
                        <p class="text-3xl font-bold text-warning-600"><?php echo e($stats['total'] ?? 0); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-warning-600"></i>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-gray-50 rounded-lg p-4 border-2 <?php echo e($hasCritical ? 'border-red-300 ring-2 ring-red-200' : 'border-gray-200'); ?>">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Críticas (>24h)</p>
                        <p class="text-3xl font-bold text-red-600"><?php echo e($stats['critical'] ?? 0); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>
                <?php if($hasCritical): ?>
                <p class="text-xs text-red-600 mt-2 font-semibold">⚠️ Requiere atención inmediata</p>
                <?php endif; ?>
            </div>
            
            
            <div class="bg-gray-50 rounded-lg p-4 border-2 <?php echo e($hasUrgent ? 'border-orange-300 ring-2 ring-orange-200' : 'border-gray-200'); ?>">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Urgentes (>6h)</p>
                        <p class="text-3xl font-bold text-orange-600"><?php echo e($stats['urgent'] ?? 0); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i data-lucide="bell" class="w-6 h-6 text-orange-600"></i>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tiempo Promedio</p>
                        <p class="text-3xl font-bold text-blue-600"><?php echo e($stats['avg_hours'] ?? 0); ?>h</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i data-lucide="hourglass" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-2">
                    <?php if(($stats['avg_hours'] ?? 0) > 6): ?>
                        <span class="text-orange-600 font-semibold">⚠️ Por encima del objetivo (6h)</span>
                    <?php else: ?>
                        <span class="text-green-600 font-semibold">✓ Dentro del objetivo (6h)</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        
        
        <div class="flex items-center gap-3 flex-wrap">
            <a href="<?php echo e($viewAllUrl); ?>" 
               class="bg-primary-300 hover:bg-primary-400 text-white px-6 py-3 rounded-lg flex items-center gap-2 font-semibold transition-colors">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Revisar Solicitudes (<?php echo e($stats['total'] ?? 0); ?>)
            </a>
            
            <?php if($hasCritical): ?>
            <a href="<?php echo e($viewAllUrl); ?>?tab=pending" 
               class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg flex items-center gap-2 font-semibold transition-colors animate-pulse">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                Atender Críticas (<?php echo e($stats['critical']); ?>)
            </a>
            <?php endif; ?>
            
            <button onclick="window.location.reload()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Actualizar
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Dashboard/PendingRequestsWidget.blade.php ENDPATH**/ ?>