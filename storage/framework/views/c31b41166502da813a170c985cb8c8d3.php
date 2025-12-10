

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variables' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_variables.svg',
    'emptyStateTitle' => 'No hay variables disponibles',
    'emptyStateMessage' => 'Comienza agregando variables para tus productos.',
    'totalVariables' => 0,
    'variableLimit' => 0,
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
    'variables' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_variables.svg',
    'emptyStateTitle' => 'No hay variables disponibles',
    'emptyStateMessage' => 'Comienza agregando variables para tus productos.',
    'totalVariables' => 0,
    'variableLimit' => 0,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Construir la ruta del SVG desde la carpeta images-ui del DesignSystem
    // Los SVG están en app/Features/DesignSystem/images-ui/
    // Se acceden a través de la ruta /images-ui/{filename} definida en routes/web.php
    $svgPath = asset('images-ui/' . ltrim($emptyStateSvg, '/'));
?>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        <input 
                            type="checkbox" 
                            id="select-all-variables" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Variable
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tipo
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Activar/Desactivar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Opciones
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Productos
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors" data-variable-id="<?php echo e($variable->id); ?>" data-products-count="<?php echo e($variable->products_count); ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input 
                                type="checkbox" 
                                class="variable-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 <?php echo e($variable->products_count > 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>" 
                                value="<?php echo e($variable->id); ?>"
                                <?php if($variable->products_count > 0): ?> disabled <?php endif; ?>
                            >
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm">
                                <div class="w-10 h-10 mr-3 flex items-center justify-center bg-gray-100 rounded-lg">
                                    <?php
                                        $variableNameLower = strtolower($variable->name);
                                        
                                        // Detectar icono según el nombre de la variable
                                        if (str_contains($variableNameLower, 'color') || str_contains($variableNameLower, 'colour')) {
                                            $icon = 'palette';
                                        } elseif (str_contains($variableNameLower, 'talla') || str_contains($variableNameLower, 'size') || str_contains($variableNameLower, 'tamaño')) {
                                            $icon = 'ruler';
                                        } else {
                                            // Icono según tipo de variable
                                            $icon = match($variable->type) {
                                                'radio' => 'circle',
                                                'checkbox' => 'check-square',
                                                'text' => 'type',
                                                'numeric' => 'calculator',
                                                default => 'settings',
                                            };
                                        }
                                    ?>
                                    <i data-lucide="<?php echo e($icon); ?>" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($variable->name); ?></p>
                                    <p class="text-xs text-gray-500">
                                        <?php if($variable->requiresOptions()): ?>
                                            <?php echo e($variable->options->count()); ?> opciones
                                        <?php elseif($variable->isNumeric()): ?>
                                            <?php if($variable->min_value || $variable->max_value): ?>
                                                Rango: <?php echo e($variable->min_value ?? 0); ?> - <?php echo e($variable->max_value ?? '∞'); ?>

                                            <?php else: ?>
                                                Sin límites
                                            <?php endif; ?>
                                        <?php else: ?>
                                            Texto libre
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => $variable->type_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variable->type_name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if($variable->is_active): ?>
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'success','text' => 'Activa']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','text' => 'Activa']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'error','text' => 'Inactiva']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','text' => 'Inactiva']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 flex items-center">
                            <label for="toggle-<?php echo e($variable->id); ?>" class="relative inline-block w-11 h-6 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggle-<?php echo e($variable->id); ?>"
                                    class="peer sr-only variable-toggle"
                                    data-variable-id="<?php echo e($variable->id); ?>"
                                    data-url="<?php echo e(route('tenant.admin.variables.toggle-status', [$store->slug, $variable->id])); ?>"
                                    <?php echo e($variable->is_active ? 'checked' : ''); ?>

                                >
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if($variable->requiresOptions()): ?>
                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => (string)$variable->options->count()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((string)$variable->options->count())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => (string)$variable->products_count]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((string)$variable->products_count)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2 justify-center">
                                <a 
                                    href="<?php echo e(route('tenant.admin.variables.show', [$store->slug, $variable->id])); ?>"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    aria-label="Ver detalles"
                                    title="Ver detalles"
                                >
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="<?php echo e(route('tenant.admin.variables.edit', [$store->slug, $variable->id])); ?>"
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                    aria-label="Editar"
                                    title="Editar"
                                >
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <button 
                                    type="button"
                                    @click.stop="deleteVariable(<?php echo e($variable->id); ?>, '<?php echo e(addslashes($variable->name)); ?>', $event)"
                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors variable-delete-btn <?php echo e($variable->products_count > 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                                    data-variable-id="<?php echo e($variable->id); ?>"
                                    data-products-count="<?php echo e($variable->products_count); ?>"
                                    aria-label="Eliminar"
                                    title="Eliminar"
                                    <?php if($variable->products_count > 0): ?> disabled <?php endif; ?>
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12">
                            <div class="flex flex-col items-center justify-center text-center">
                                <img src="<?php echo e($svgPath); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($emptyStateTitle); ?></h3>
                                <p class="text-sm text-gray-600 mb-6"><?php echo e($emptyStateMessage); ?></p>
                                <?php if($totalVariables < $variableLimit): ?>
                                    <a 
                                        href="<?php echo e(route('tenant.admin.variables.create', $store->slug)); ?>"
                                        class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                    >
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        Crear primera variable
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                
                
                <tr id="dynamic-empty-state" style="display: none;">
                    <td colspan="8" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <img src="<?php echo e($svgPath); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($emptyStateTitle); ?></h3>
                            <p class="text-sm text-gray-600 mb-6"><?php echo e($emptyStateMessage); ?></p>
                            <?php if($totalVariables < $variableLimit): ?>
                                <a 
                                    href="<?php echo e(route('tenant.admin.variables.create', $store->slug)); ?>"
                                    class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                >
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    Crear primera variable
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }

    // Toggle de estado de variable
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('variable-toggle')) {
            const variableId = e.target.dataset.variableId;
            const url = e.target.dataset.url;
            const originalChecked = e.target.checked;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el badge de estado en la misma fila
                    const row = e.target.closest('tr');
                    if (row) {
                        const statusCell = row.querySelector('td:nth-child(4)');
                        if (statusCell) {
                            if (e.target.checked) {
                                statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">Activa</span>';
                            } else {
                                statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">Inactiva</span>';
                            }
                        }
                    }
                } else {
                    e.target.checked = !originalChecked;
                    // Mostrar error con AlertBordered
                    const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                    if (variableManagement) {
                        variableManagement.showToggleError = true;
                        variableManagement.toggleErrorMessage = data.error || 'Error al cambiar el estado';
                        setTimeout(() => {
                            variableManagement.showToggleError = false;
                        }, 5000);
                    }
                }
            })
            .catch(error => {
                e.target.checked = !originalChecked;
                // Mostrar error con AlertBordered
                const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                if (variableManagement) {
                    variableManagement.showToggleError = true;
                    variableManagement.toggleErrorMessage = 'Error al cambiar el estado';
                    setTimeout(() => {
                        variableManagement.showToggleError = false;
                    }, 5000);
                }
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Variables/VariablesTable.blade.php ENDPATH**/ ?>