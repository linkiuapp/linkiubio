

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'categories' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_categorias.svg',
    'emptyStateTitle' => 'No hay categorías disponibles',
    'emptyStateMessage' => 'Comienza agregando categorías para tus productos.',
    'totalCategories' => 0,
    'categoryLimit' => 0,
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
    'categories' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_categorias.svg',
    'emptyStateTitle' => 'No hay categorías disponibles',
    'emptyStateMessage' => 'Comienza agregando categorías para tus productos.',
    'totalCategories' => 0,
    'categoryLimit' => 0,
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
                            id="select-all-categories" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Categoría
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
                        Productos
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors" data-category-id="<?php echo e($category->id); ?>" data-products-count="<?php echo e($category->products_count); ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input 
                                type="checkbox" 
                                class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 <?php echo e($category->products_count > 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>" 
                                value="<?php echo e($category->id); ?>"
                                <?php if($category->products_count > 0): ?> disabled <?php endif; ?>
                            >
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm">
                                <?php if($category->icon): ?>
                                    <img 
                                        class="object-contain w-10 h-10 mr-3 rounded"
                                        src="<?php echo e($category->icon->image_url); ?>"
                                        alt="<?php echo e($category->icon->display_name); ?>"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.querySelector('i').style.display='block';"
                                    />
                                <?php endif; ?>
                                <div class="flex items-center">
                                    <?php if(!$category->icon): ?>
                                        <i data-lucide="folder" class="w-10 h-10 mr-3 text-gray-400" style="display: none;"></i>
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-semibold text-gray-900"><?php echo e($category->name); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($category->slug); ?></p>
                                        <?php if($category->description): ?>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo e($category->description); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if($category->parent): ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Subcategoría de <?php echo e($category->parent->name); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                    Principal
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if($category->is_active): ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">
                                    Activa
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">
                                    Inactiva
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <label for="toggle-<?php echo e($category->id); ?>" class="relative inline-block w-11 h-6 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggle-<?php echo e($category->id); ?>"
                                    class="peer sr-only category-toggle"
                                    data-category-id="<?php echo e($category->id); ?>"
                                    data-url="<?php echo e(route('tenant.admin.categories.toggle-status', [$store->slug, $category->id])); ?>"
                                    <?php echo e($category->is_active ? 'checked' : ''); ?>

                                >
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e($category->products_count); ?>

                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a 
                                    href="<?php echo e(route('tenant.admin.categories.show', [$store->slug, $category->id])); ?>"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    aria-label="Ver detalles"
                                    title="Ver detalles"
                                >
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="<?php echo e(route('tenant.admin.categories.edit', [$store->slug, $category->id])); ?>"
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                    aria-label="Editar"
                                    title="Editar"
                                >
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <button 
                                    type="button"
                                    @click.stop="deleteCategory(<?php echo e($category->id); ?>, '<?php echo e(addslashes($category->name)); ?>', $event)"
                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors category-delete-btn <?php echo e($category->products_count > 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                                    data-category-id="<?php echo e($category->id); ?>"
                                    data-products-count="<?php echo e($category->products_count); ?>"
                                    aria-label="Eliminar"
                                    title="Eliminar"
                                    <?php if($category->products_count > 0): ?> disabled <?php endif; ?>
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12">
                            <div class="flex flex-col items-center justify-center text-center">
                                <img src="<?php echo e($svgPath); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($emptyStateTitle); ?></h3>
                                <p class="text-sm text-gray-600 mb-6"><?php echo e($emptyStateMessage); ?></p>
                                <?php if($totalCategories < $categoryLimit): ?>
                                    <a 
                                        href="<?php echo e(route('tenant.admin.categories.create', $store->slug)); ?>"
                                        class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                    >
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        Crear primera categoría
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                
                
                <tr id="dynamic-empty-state" style="display: none;">
                    <td colspan="7" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <img src="<?php echo e($svgPath); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($emptyStateTitle); ?></h3>
                            <p class="text-sm text-gray-600 mb-6"><?php echo e($emptyStateMessage); ?></p>
                            <?php if($totalCategories < $categoryLimit): ?>
                                <a 
                                    href="<?php echo e(route('tenant.admin.categories.create', $store->slug)); ?>"
                                    class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                >
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    Crear primera categoría
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

    // Toggle de estado de categoría
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('category-toggle')) {
            const categoryId = e.target.dataset.categoryId;
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
                            if (data.is_active) {
                                statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">Activa</span>';
                            } else {
                                statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">Inactiva</span>';
                            }
                        }
                    }
                    
                    // Mostrar toast de éxito
                    if (window.toast) {
                        const message = originalChecked 
                            ? 'La categoría se ha activado correctamente.'
                            : 'La categoría se ha desactivado correctamente.';
                        window.toast.success(
                            'Estado actualizado',
                            message,
                            5000,
                            'bottom-center'
                        );
                    }
                } else {
                    e.target.checked = !originalChecked;
                    // Mostrar error con toast
                    if (window.toast) {
                        window.toast.error(
                            'Error',
                            data.error || 'Error al cambiar el estado',
                            5000,
                            'bottom-center'
                        );
                    }
                }
            })
            .catch(error => {
                e.target.checked = !originalChecked;
                // Mostrar error con toast
                if (window.toast) {
                    window.toast.error(
                        'Error',
                        'Error al cambiar el estado',
                        5000,
                        'bottom-center'
                    );
                }
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Categories/CategoriesTable.blade.php ENDPATH**/ ?>