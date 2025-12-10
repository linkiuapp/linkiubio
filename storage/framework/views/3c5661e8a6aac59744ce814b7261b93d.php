

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'store' => null,
    'currentFilters' => [],
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
    'store' => null,
    'currentFilters' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form method="GET" action="<?php echo e(route('tenant.admin.orders.index', $store->slug)); ?>" x-data="{ showAdvanced: false }">
    <div class="bg-white rounded-lg shadow-sm p-4">
        
        <div class="flex flex-wrap items-center gap-3 mb-4">
            
            <select name="status" class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:16px_16px] bg-[right_0.5rem_center] bg-no-repeat">
                <option value="">Todos los estados</option>
                <option value="pending" <?php echo e(($currentFilters['status'] ?? '') === 'pending' ? 'selected' : ''); ?>>Pendiente</option>
                <option value="confirmed" <?php echo e(($currentFilters['status'] ?? '') === 'confirmed' ? 'selected' : ''); ?>>Confirmado</option>
                <option value="preparing" <?php echo e(($currentFilters['status'] ?? '') === 'preparing' ? 'selected' : ''); ?>>Preparando</option>
                <option value="shipped" <?php echo e(($currentFilters['status'] ?? '') === 'shipped' ? 'selected' : ''); ?>>Enviado</option>
                <option value="delivered" <?php echo e(($currentFilters['status'] ?? '') === 'delivered' ? 'selected' : ''); ?>>Entregado</option>
                <option value="cancelled" <?php echo e(($currentFilters['status'] ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelado</option>
            </select>

            
            <select name="order_type" class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:16px_16px] bg-[right_0.5rem_center] bg-no-repeat">
                <option value="">Todos los tipos</option>
                <option value="delivery" <?php echo e(($currentFilters['order_type'] ?? '') === 'delivery' ? 'selected' : ''); ?>>Domicilio</option>
                <option value="pickup" <?php echo e(($currentFilters['order_type'] ?? '') === 'pickup' ? 'selected' : ''); ?>>Recoger</option>
                <option value="dine_in" <?php echo e(($currentFilters['order_type'] ?? '') === 'dine_in' ? 'selected' : ''); ?>>Consumo Local</option>
                <option value="room_service" <?php echo e(($currentFilters['order_type'] ?? '') === 'room_service' ? 'selected' : ''); ?>>Habitación</option>
            </select>

            
            <select name="payment_method" class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:16px_16px] bg-[right_0.5rem_center] bg-no-repeat">
                <option value="">Todos los métodos</option>
                <option value="transferencia" <?php echo e(($currentFilters['payment_method'] ?? '') === 'transferencia' ? 'selected' : ''); ?>>Transferencia</option>
                <option value="contra_entrega" <?php echo e(($currentFilters['payment_method'] ?? '') === 'contra_entrega' ? 'selected' : ''); ?>>Contra Entrega</option>
                <option value="efectivo" <?php echo e(($currentFilters['payment_method'] ?? '') === 'efectivo' ? 'selected' : ''); ?>>Efectivo</option>
            </select>

            
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" 
                       name="search" 
                       value="<?php echo e($currentFilters['search'] ?? ''); ?>" 
                       placeholder="Buscar por número, cliente..." 
                       class="w-full px-3 py-2 pl-10 pr-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>

            
            <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm hover:bg-primary-600 transition-colors flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Buscar
            </button>

            <a href="<?php echo e(route('tenant.admin.orders.index', $store->slug)); ?>" 
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Limpiar
            </a>
        </div>

        
        <div>
            <button type="button" 
                    @click="showAdvanced = !showAdvanced" 
                    class="text-sm text-primary-500 hover:text-primary-600 flex items-center gap-1 transition-colors">
                <span x-text="showAdvanced ? 'Ocultar filtros avanzados' : 'Mostrar filtros avanzados'"></span>
                <i data-lucide="chevron-down" 
                   class="w-4 h-4 transition-transform" 
                   x-bind:class="{ 'rotate-180': showAdvanced }"></i>
            </button>
            
            <div x-show="showAdvanced" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fecha Desde</label>
                    <input type="date" 
                           name="date_from" 
                           value="<?php echo e($currentFilters['date_from'] ?? ''); ?>" 
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fecha Hasta</label>
                    <input type="date" 
                           name="date_to" 
                           value="<?php echo e($currentFilters['date_to'] ?? ''); ?>" 
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Monto Desde</label>
                    <input type="number" 
                           name="amount_from" 
                           value="<?php echo e($currentFilters['amount_from'] ?? ''); ?>" 
                           placeholder="0" 
                           min="0" 
                           step="1000"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Monto Hasta</label>
                    <input type="number" 
                           name="amount_to" 
                           value="<?php echo e($currentFilters['amount_to'] ?? ''); ?>" 
                           placeholder="Sin límite" 
                           min="0" 
                           step="1000"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Orders/OrdersFiltersWidget.blade.php ENDPATH**/ ?>