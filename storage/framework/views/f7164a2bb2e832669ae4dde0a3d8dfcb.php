

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'stats' => [],
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
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['total'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Total</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-amber-100 text-amber-600 rounded-xl">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Pendientes</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-xl">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['confirmed'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Confirmados</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-purple-100 text-purple-600 rounded-xl">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['preparing'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Preparando</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-xl">
                <i data-lucide="truck" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['shipped'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Enviados</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-xl">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['delivered'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Entregados</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-red-100 text-red-600 rounded-xl">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['cancelled'] ?? 0); ?></div>
                <div class="text-xs text-gray-500">Cancelados</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-xl">
                <i data-lucide="banknote" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-emerald-600">$<?php echo e(number_format($stats['total_revenue'] ?? 0, 0, ',', '.')); ?></div>
                <div class="text-xs text-gray-500">Total ingresos por productos</div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center bg-gray-100 text-gray-600 rounded-xl">
                <i data-lucide="package-check" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-slate-600">$<?php echo e(number_format($stats['total_shipping'] ?? 0, 0, ',', '.')); ?></div>
                <div class="text-xs text-gray-500">Total ingresos por envíos</div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Orders/OrdersStatsWidget.blade.php ENDPATH**/ ?>