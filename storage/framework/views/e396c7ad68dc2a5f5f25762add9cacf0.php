<?php if (isset($component)) { $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1 = $attributes; } ?>
<?php $component = App\Shared\Views\Components\TenantAdminLayout::resolve(['store' => $store] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tenant-admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\Shared\Views\Components\TenantAdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Inventario'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-6 mt-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Gestión de Inventario</h1>
                <p class="text-sm text-gray-600 mt-1">Controla el stock de tus productos en tiempo real</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('tenant.admin.products.index', $store->slug)); ?>" data-tour="ver-productos" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Ver Productos
                </a>
            </div>
        </div>
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_inventario','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_inventario','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $attributes = $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $component = $__componentOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4" data-tour="stats-cards">
            
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Productos</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($estadisticas['total']); ?></h3>
                        <p class="text-xs text-gray-500 mt-1">Con control de stock</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Unidades</p>
                        <h3 class="text-2xl font-bold text-green-600 mt-2"><?php echo e(number_format($estadisticas['total_unidades'])); ?></h3>
                        <p class="text-xs text-gray-500 mt-1">En inventario</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="boxes" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Stock Bajo</p>
                        <h3 class="text-2xl font-bold text-yellow-600 mt-2"><?php echo e($estadisticas['stock_bajo']); ?></h3>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($estadisticas['stock_bajo'] == 1 ? 'Producto' : 'Productos'); ?> con ≤ 1 unidad</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                    </div>
                </div>
                <?php if($estadisticas['stock_bajo'] > 0): ?>
                <a href="#stock-bajo" class="text-xs text-yellow-600 hover:underline mt-2 inline-block">Ver productos</a>
                <?php endif; ?>
            </div>

            
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Agotados</p>
                        <h3 class="text-2xl font-bold text-red-600 mt-2"><?php echo e($estadisticas['agotados']); ?></h3>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($estadisticas['agotados'] == 1 ? 'Producto' : 'Productos'); ?> sin stock</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>
                <?php if($estadisticas['agotados'] > 0): ?>
                <a href="#agotados" class="text-xs text-red-600 hover:underline mt-2 inline-block">Ver productos</a>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($productosStockBajo->isNotEmpty()): ?>
        <div id="stock-bajo" data-tour="stock-bajo" 
             x-data="{ expanded: false, itemsToShow: 5 }"
             class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6">
            <div class="flex items-start gap-4">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1"></i>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-yellow-900">
                            Productos con Stock Bajo (<?php echo e($productosStockBajo->count()); ?>)
                        </h3>
                        <?php if($productosStockBajo->count() > 5): ?>
                        <button 
                            @click="expanded = !expanded"
                            class="text-sm text-yellow-700 hover:text-yellow-900 font-medium flex items-center gap-1">
                            <span x-text="expanded ? 'Ver menos' : 'Ver todos'"></span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $productosStockBajo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div x-show="expanded || <?php echo e($index); ?> < itemsToShow"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="bg-white rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img 
                                    src="<?php echo e($producto->main_image_url); ?>" 
                                    alt="<?php echo e($producto->name); ?>"
                                    class="w-16 h-16 rounded object-cover"
                                >
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900"><?php echo e($producto->name); ?></h4>
                                    <p class="text-xs text-gray-500">SKU: <?php echo e($producto->sku); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-sm font-bold text-yellow-600">
                                        <?php echo e($producto->cantidad_stock); ?> unidades
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Umbral: <?php echo e($producto->umbral_alerta_stock); ?>

                                    </p>
                                </div>
                                <a 
                                    href="<?php echo e(route('tenant.admin.products.edit', ['store' => $store->slug, 'product' => $producto->id])); ?>"
                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors"
                                >
                                    Actualizar Stock
                                </a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if($productosStockBajo->count() > 5): ?>
                    <p x-show="!expanded" class="text-sm text-yellow-700 mt-3 text-center">
                        ... y <?php echo e($productosStockBajo->count() - 5); ?> productos más
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($productosAgotados->isNotEmpty()): ?>
        <div id="agotados" data-tour="productos-agotados" 
             x-data="{ expanded: false, itemsToShow: 5 }"
             class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6">
            <div class="flex items-start gap-4">
                <i data-lucide="x-circle" class="w-6 h-6 text-red-600 flex-shrink-0 mt-1"></i>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-red-900">
                            Productos Agotados (<?php echo e($productosAgotados->count()); ?>)
                        </h3>
                        <?php if($productosAgotados->count() > 5): ?>
                        <button 
                            @click="expanded = !expanded"
                            class="text-sm text-red-700 hover:text-red-900 font-medium flex items-center gap-1">
                            <span x-text="expanded ? 'Ver menos' : 'Ver todos'"></span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $productosAgotados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div x-show="expanded || <?php echo e($index); ?> < itemsToShow"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="bg-white rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img 
                                    src="<?php echo e($producto->main_image_url); ?>" 
                                    alt="<?php echo e($producto->name); ?>"
                                    class="w-16 h-16 rounded object-cover opacity-50"
                                >
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900"><?php echo e($producto->name); ?></h4>
                                    <p class="text-xs text-gray-500">SKU: <?php echo e($producto->sku); ?></p>
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        <i data-lucide="x-circle" class="w-3 h-3"></i>
                                        Sin stock
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a 
                                    href="<?php echo e(route('tenant.admin.products.edit', ['store' => $store->slug, 'product' => $producto->id])); ?>"
                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors"
                                >
                                    Reabastecer
                                </a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if($productosAgotados->count() > 5): ?>
                    <p x-show="!expanded" class="text-sm text-red-700 mt-3 text-center">
                        ... y <?php echo e($productosAgotados->count() - 5); ?> productos más
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="bg-white rounded-lg border border-gray-200 p-6" data-tour="movimientos-recientes">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Movimientos Recientes</h3>
            
            <?php if($movimientosRecientes->isEmpty()): ?>
            <div class="text-center py-12">
                <i data-lucide="package-x" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                <p class="text-sm text-gray-500">No hay movimientos de stock aún</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="text-center py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="text-center py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="text-right py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $movimientosRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <p class="text-xs text-gray-600"><?php echo e($movimiento->created_at->format('d/m/Y H:i')); ?></p>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="<?php echo e($movimiento->producto->main_image_url); ?>" 
                                        alt="<?php echo e($movimiento->producto->name); ?>"
                                        class="w-10 h-10 rounded object-cover"
                                    >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900"><?php echo e($movimiento->producto->name); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($movimiento->producto->sku); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <?php
                                    $tipoConfig = [
                                        'entrada' => ['label' => 'Entrada', 'color' => 'green'],
                                        'salida' => ['label' => 'Salida', 'color' => 'red'],
                                        'venta' => ['label' => 'Venta', 'color' => 'blue'],
                                        'devolucion' => ['label' => 'Devolución', 'color' => 'green'],
                                        'ajuste' => ['label' => 'Ajuste', 'color' => 'yellow'],
                                        'reserva' => ['label' => 'Reserva', 'color' => 'purple'],
                                        'liberacion' => ['label' => 'Liberación', 'color' => 'gray'],
                                    ];
                                    $config = $tipoConfig[$movimiento->tipo] ?? ['label' => $movimiento->tipo, 'color' => 'gray'];
                                ?>
                                <span class="inline-flex items-center px-2 py-1 bg-<?php echo e($config['color']); ?>-100 text-<?php echo e($config['color']); ?>-700 rounded-full text-xs font-medium">
                                    <?php echo e($config['label']); ?>

                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-sm font-bold <?php echo e($movimiento->cantidad > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e($movimiento->cantidad > 0 ? '+' : ''); ?><?php echo e($movimiento->cantidad); ?>

                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <p class="text-xs text-gray-500">
                                    <?php echo e($movimiento->creador->name ?? 'Sistema'); ?>

                                </p>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $attributes = $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $component = $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/inventario/index.blade.php ENDPATH**/ ?>