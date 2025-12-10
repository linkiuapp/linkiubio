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
<?php $__env->startSection('title', 'Pedido #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto print-container">
    <!-- Componente de recibo POS (oculto, solo para generar PDF) -->
    <div id="order-receipt-pos" style="display: none; position: absolute; left: -9999px;">
        <?php if (isset($component)) { $__componentOriginal9a54ca02209e3ceb82c7f69dcc5a40e3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9a54ca02209e3ceb82c7f69dcc5a40e3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Orders.OrderReceiptPOS','data' => ['order' => $order,'store' => $store]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('order-receipt-pos'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($order),'store' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9a54ca02209e3ceb82c7f69dcc5a40e3)): ?>
<?php $attributes = $__attributesOriginal9a54ca02209e3ceb82c7f69dcc5a40e3; ?>
<?php unset($__attributesOriginal9a54ca02209e3ceb82c7f69dcc5a40e3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9a54ca02209e3ceb82c7f69dcc5a40e3)): ?>
<?php $component = $__componentOriginal9a54ca02209e3ceb82c7f69dcc5a40e3; ?>
<?php unset($__componentOriginal9a54ca02209e3ceb82c7f69dcc5a40e3); ?>
<?php endif; ?>
    </div>
    
    <!-- Header normal (oculto al imprimir) -->
    <div class="mb-6 print-header no-print">
        <div class="flex items-center gap-3 mb-4">
            <a href="<?php echo e(route('tenant.admin.orders.index', $store->slug)); ?>" 
               class="text-gray-600 hover:text-gray-700">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Pedido #<?php echo e($order->order_number); ?></h1>
            <?php
                $statusBadgeType = match($order->status) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'preparing' => 'info',
                    'shipped' => 'info',
                    'delivered' => 'success',
                    'cancelled' => 'error',
                    default => 'secondary'
                };
            ?>
            <div data-tour="order-status">
                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $statusBadgeType,'text' => $order->status_label]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusBadgeType),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($order->status_label)]); ?>
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
            </div>
            <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_primer_pedido']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_primer_pedido']); ?>
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
        </div>
        <p class="text-sm text-gray-600">
            Creado el <?php echo e($order->created_at->format('d/m/Y \a \l\a\s H:i')); ?> 
            (<?php echo e($order->created_at->diffForHumans()); ?>)
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 no-print">
        
        <!-- Columna Principal -->
        <div class="xl:col-span-2 space-y-6 print-section">
            
            <!-- Información del Cliente -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200" data-tour="customer-info">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Información del Cliente</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Nombre</label>
                        <div class="text-sm text-gray-900"><?php echo e($order->customer_name); ?></div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Teléfono</label>
                        <div class="text-sm text-gray-900">
                            <a href="https://wa.me/57<?php echo e(preg_replace('/\D/', '', $order->customer_phone)); ?>" 
                               target="_blank" class="text-green-600 hover:text-green-700 flex items-center gap-1">
                                <?php echo e($order->customer_phone); ?>

                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                    <?php if($order->customer_address): ?>
                    <div class="lg:col-span-2">
                        <label class="block text-xs text-gray-600 mb-1">Dirección</label>
                        <div class="text-sm text-gray-900"><?php echo e($order->customer_address); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($order->department): ?>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Departamento</label>
                        <div class="text-sm text-gray-900"><?php echo e($order->department); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($order->city): ?>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Ciudad</label>
                        <div class="text-sm text-gray-900"><?php echo e($order->city); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Productos del Pedido -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200" data-tour="order-details">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Productos (<?php echo e($order->items->count()); ?>)</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200">
                            <div class="w-12 h-12 rounded-lg flex-shrink-0 border border-gray-200 overflow-hidden bg-gray-100 relative mr-4">
                                <?php if($item->product && $item->product->main_image_url): ?>
                                    <img src="<?php echo e($item->product->main_image_url); ?>" 
                                         alt="<?php echo e($item->product_name); ?>" 
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <?php endif; ?>
                                <div class="w-full h-full <?php echo e($item->product && $item->product->main_image_url ? 'hidden' : 'flex'); ?> items-center justify-center absolute inset-0">
                                    <i data-lucide="package" class="w-6 h-6 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-900"><?php echo e($item->product_name); ?></div>
                                <?php if($item->variant_details): ?>
                                    <div class="text-xs text-gray-600"><?php echo e($item->formatted_variants); ?></div>
                                <?php endif; ?>
                                <?php if($item->product): ?>
                                    <a href="<?php echo e(route('tenant.admin.products.show', [$store->slug, $item->product->id])); ?>" 
                                       class="text-xs text-blue-600 hover:text-blue-700">
                                        Ver producto
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-900">Cant: <?php echo e($item->quantity); ?></div>
                                <div class="text-sm text-gray-600">$<?php echo e(number_format($item->unit_price, 0, ',', '.')); ?> c/u</div>
                                <div class="text-sm font-semibold text-gray-900">$<?php echo e(number_format($item->item_total, 0, ',', '.')); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Resumen</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 flex items-center gap-1">
                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                            Productos:
                        </span>
                        <span class="text-green-600 font-semibold">$<?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                    </div>
                    <?php if($order->shipping_cost > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 flex items-center gap-1">
                                <i data-lucide="truck" class="w-4 h-4"></i>
                                Envío:
                            </span>
                            <span class="text-gray-500">$<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($order->coupon_discount > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 flex items-center gap-1">
                                <i data-lucide="ticket" class="w-4 h-4"></i>
                                Descuento:
                            </span>
                            <span class="text-red-500">-$<?php echo e(number_format($order->coupon_discount, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total cobrado:</span>
                            <span class="text-lg font-semibold text-blue-600">$<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
                        </div>
                        <?php if($order->shipping_cost > 0): ?>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                Tu ingreso real: $<?php echo e(number_format($order->subtotal - ($order->coupon_discount ?? 0), 0, ',', '.')); ?>

                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Historial de Estados -->
            <?php if($order->statusHistory && $order->statusHistory->count() > 0): ?>
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Historial de Estados</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $order->statusHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex">
                            <div class="flex-shrink-0 w-8 h-8 <?php echo e($history->status_color); ?> rounded-full flex items-center justify-center mr-3">
                                <i data-lucide="check-circle" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm text-gray-900"><?php echo e($history->status_change); ?></div>
                                <?php if($history->notes): ?>
                                    <div class="text-xs text-gray-600 mt-1"><?php echo e($history->notes); ?></div>
                                <?php endif; ?>
                                <div class="text-xs text-gray-500">
                                    Por: <?php echo e($history->changed_by); ?> • <?php echo e($history->created_at->format('d/m/Y H:i')); ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 print-hide">
            
            <!-- Información de Entrega -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Entrega</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Tipo</label>
                        <div class="flex items-center text-sm">
                            <?php if(in_array($order->delivery_type, ['domicilio', 'local', 'national'])): ?>
                                <i data-lucide="truck" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900">
                                    <?php if($order->delivery_type === 'national'): ?>
                                        Envío Nacional
                                    <?php else: ?>
                                        Domicilio
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <i data-lucide="store" class="w-4 h-4 text-gray-600 mr-2"></i>
                                <span class="text-gray-900">Pickup en Tienda</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if(in_array($order->delivery_type, ['domicilio', 'local', 'national'])): ?>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Costo de Envío</label>
                            <div class="text-sm text-gray-900">
                                <?php if($order->shipping_cost > 0): ?>
                                    $<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?>

                                <?php else: ?>
                                    <span class="text-green-600">Gratis</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información de Pago -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Pago</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Método</label>
                        <div class="flex items-center text-sm">
                            <?php if($order->payment_method === 'transferencia' || $order->payment_method === 'bank_transfer'): ?>
                                <i data-lucide="credit-card" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900">Transferencia Bancaria</span>
                            <?php elseif($order->payment_method === 'contra_entrega'): ?>
                                <i data-lucide="wallet" class="w-4 h-4 text-yellow-600 mr-2"></i>
                                <span class="text-gray-900">Pago Contra Entrega</span>
                            <?php elseif($order->payment_method === 'efectivo' || $order->payment_method === 'cash'): ?>
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600 mr-2"></i>
                                <span class="text-gray-900">Efectivo</span>
                            <?php else: ?>
                                <i data-lucide="credit-card" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($order->payment_proof_path): ?>
                        <div data-tour="payment-proof">
                            <label class="block text-xs text-gray-600 mb-1">Comprobante</label>
                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 text-green-600 mr-2"></i>
                                    <a href="javascript:void(0)" 
                                       onclick="window.verComprobante('<?php echo e($order->payment_proof_url); ?>', '<?php echo e($order->order_number); ?>', <?php echo e($order->id); ?>, '<?php echo e($order->proof_validation_status ?? ''); ?>', <?php echo e($order->proof_validation_score ?? 0); ?>)"
                                       class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer">
                                        Ver comprobante
                                    </a>
                                </div>
                                
                                <?php if($order->proof_validation_status): ?>
                                    <?php if($order->proof_validation_status === 'valid'): ?>
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <i data-lucide="check-circle" class="w-3 h-3"></i> Validado IA
                                        </span>
                                    <?php elseif($order->proof_validation_status === 'suspicious'): ?>
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            <i data-lucide="alert-triangle" class="w-3 h-3"></i> Revisar
                                        </span>
                                    <?php elseif($order->proof_validation_status === 'fake'): ?>
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            <i data-lucide="x-circle" class="w-3 h-3"></i> Sospechoso
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cambiar Estado -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Cambiar Estado</h3>
                <div data-tour="change-status-button">
                    <label class="block text-xs text-gray-700 mb-2">Estado del Pedido</label>
                    <select id="order-status-select" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                            onchange="handleStatusChangeShow(<?php echo e($order->id); ?>, this.value, this, '<?php echo e($order->order_number); ?>')">
                        <option value="">Seleccionar estado</option>
                        <?php $__currentLoopData = ['pending' => 'Pendiente', 'confirmed' => 'Confirmado', 'preparing' => 'Preparando', 'shipped' => 'Enviado', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e($order->status === $status ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Notas del Pedido -->
            <?php if($order->notes): ?>
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Notas</h3>
                    <div class="text-sm text-gray-900"><?php echo e($order->notes); ?></div>
                </div>
            <?php endif; ?>

            <!-- Acciones Rápidas -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Acciones</h3>
                <div class="space-y-3">
                    <?php if($order->canBeEdited()): ?>
                        <a href="<?php echo e(route('tenant.admin.orders.edit', [$store->slug, $order->id])); ?>" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                           title="Editar pedido">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Editar Pedido
                        </a>
                    <?php endif; ?>
                    
                    <button onclick="printOrder()" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                            title="Descargar PDF del pedido">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        Descargar PDF
                    </button>
                    
                    <a href="https://wa.me/57<?php echo e(preg_replace('/\D/', '', $order->customer_phone)); ?>?text=Hola <?php echo e($order->customer_name); ?>, te contactamos sobre tu pedido #<?php echo e($order->order_number); ?>" 
                       target="_blank" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"
                       title="Contactar por WhatsApp">
                        <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                        Contactar por WhatsApp
                    </a>
                    
                    <?php if(!in_array($order->status, ['delivered', 'cancelled'])): ?>
                        <button @click="showCancelModal = true" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm"
                                title="Cancelar pedido">
                            <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                            Cancelar Pedido
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->startPush('styles'); ?>
<style>
/* Animación de escaneo para validación AI */
@keyframes scan {
    0% {
        top: 0;
    }
    50% {
        top: 100%;
    }
    100% {
        top: 0;
    }
}

.scan-line {
    position: absolute;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(
        to bottom,
        transparent,
        rgba(139, 92, 246, 0.8),
        rgba(59, 130, 246, 0.7),
        rgba(6, 182, 212, 0.6),
        transparent
    );
    box-shadow: 0 0 20px rgba(139, 92, 246, 0.8),
                0 0 40px rgba(59, 130, 246, 0.6),
                0 0 60px rgba(6, 182, 212, 0.4);
    animation: scan 2s linear infinite;
    filter: blur(1px);
}

.scan-line::before {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    height: 30px;
    background: linear-gradient(
        to bottom,
        rgba(139, 92, 246, 0.3),
        transparent
    );
    filter: blur(10px);
}

.scan-line::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.9),
        transparent
    );
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

@media print {
    /* Ocultar elementos del layout principal */
    body > main,
    body > aside,
    body > header,
    body > nav,
    body > footer {
        display: none !important;
    }
    
    /* Mostrar el contenedor principal */
    .print-container {
        display: block !important;
        visibility: visible !important;
        position: relative !important;
    }
    
    /* Ocultar elementos del layout */
    aside,
    .sidebar,
    nav,
    header,
    footer,
    .navbar,
    .tenant-navbar,
    .admin-navbar,
    .admin-footer,
    
    /* Ocultar elementos de la vista - pero NO print-only */
    .no-print:not(.print-only),
    button,
    a[href]:not(.print-link),
    .print-hide,
    .xl\\:col-span-2,
    [x-data]:not(.print-only),
    [x-show]:not(.print-only),
    [x-cloak]:not(.print-only),
    .fixed,
    .absolute,
    .print-section,
    .print-header {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Ocultar todos los hijos directos del contenedor excepto print-only */
    .print-container > .print-header,
    .print-container > .grid {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Asegurar que no-print no oculte print-only */
    .print-container > .no-print:not(.print-only) {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Mostrar solo la vista POS durante la impresión */
    /* El estilo inline display:none se mantiene, pero @media print lo sobrescribe */
    .print-only {
        display: block !important;
        visibility: visible !important;
        position: relative !important;
        width: 100% !important;
        max-width: 70mm !important;
        margin: 0 auto !important;
        opacity: 1 !important;
    }
    
    /* Sobrescribir cualquier estilo inline durante impresión */
    .print-only[style*="display: none"],
    .print-only[style*="display:none"] {
        display: block !important;
    }
    
    /* Asegurar que todos los hijos de print-only sean visibles */
    .print-only * {
        visibility: visible !important;
    }
    
    /* Asegurar que no-print no afecte a print-only durante impresión */
    .print-only.no-print {
        display: block !important;
    }
    
    /* Asegurar que el contenedor muestre print-only */
    .print-container .print-only {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Ajustar display de elementos dentro de print-only */
    .print-only table {
        display: table !important;
        width: 100% !important;
    }
    
    .print-only tr {
        display: table-row !important;
    }
    
    .print-only td,
    .print-only th {
        display: table-cell !important;
    }
    
    .print-only .flex {
        display: flex !important;
    }
    
    .print-only div,
    .print-only p,
    .print-only span,
    .print-only h1,
    .print-only h2,
    .print-only h3 {
        display: block !important;
    }
    
    /* Resetear layout para impresión */
    * {
        box-shadow: none !important;
        text-shadow: none !important;
    }
    
    /* Estilos para impresión tipo POS */
    @page {
        size: 80mm auto; /* Tamaño estándar de recibo térmico */
        margin: 5mm;
    }
    
    html, body {
        background: white !important;
        font-family: 'Courier New', monospace !important;
        font-size: 10pt;
        line-height: 1.3;
        color: #000 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
    }
    
    body {
        padding: 10mm !important;
        display: flex !important;
        justify-content: center !important;
        align-items: flex-start !important;
    }
    
    /* Contenedor principal - ocultar todo excepto print-only */
    .print-container {
        display: block !important;
        width: 70mm !important;
        max-width: 70mm !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }
    
    /* Ocultar todos los hijos directos del contenedor excepto print-only */
    .print-container > .no-print,
    .print-container > .print-header,
    .print-container > .grid {
        display: none !important;
    }
    
    /* Mostrar solo print-only */
    .print-only {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .print-only h1 {
        font-size: 14pt;
        font-weight: bold;
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .print-only p {
        margin: 2px 0;
        font-size: 9pt;
    }
    
    .print-only .text-xs {
        font-size: 9pt !important;
    }
    
    .print-only .text-sm {
        font-size: 10pt !important;
    }
    
    /* Separadores */
    .print-only .border-t {
        border-top: 1px solid #000 !important;
    }
    
    .print-only .border-dashed {
        border-style: dashed !important;
    }
    
    /* Tabla de productos */
    .print-only table {
        width: 100%;
        border-collapse: collapse;
        margin: 4px 0;
        font-size: 9pt;
    }
    
    .print-only table th {
        border-bottom: 1px solid #000;
        padding: 3px 0;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 8pt;
    }
    
    .print-only table td {
        padding: 2px 0;
        border-bottom: 1px dashed #666;
    }
    
    .print-only table tr:last-child td {
        border-bottom: none;
    }
    
    /* Totales */
    .print-only .font-bold {
        font-weight: bold;
    }
    
    .print-only .font-semibold {
        font-weight: 600;
    }
    
    /* Ocultar iconos y elementos decorativos */
    [data-lucide],
    i[data-lucide],
    .lucide,
    img {
        display: none !important;
    }
    
    /* Links */
    a {
        color: #000 !important;
        text-decoration: none !important;
    }
    
    /* Evitar saltos de página */
    .print-only {
        page-break-inside: avoid;
    }
    
    /* Ajustes de espaciado */
    .print-only .mb-1 {
        margin-bottom: 3px !important;
    }
    
    .print-only .mb-2 {
        margin-bottom: 6px !important;
    }
    
    .print-only .mb-3 {
        margin-bottom: 9px !important;
    }
    
    .print-only .mb-4 {
        margin-bottom: 12px !important;
    }
    
    .print-only .my-2 {
        margin-top: 6px !important;
        margin-bottom: 6px !important;
    }
    
    .print-only .mt-4 {
        margin-top: 12px !important;
    }
    
    /* Centrado de texto */
    .print-only .text-center {
        text-align: center !important;
    }
    
    /* Alineación */
    .print-only .text-left {
        text-align: left !important;
    }
    
    .print-only .text-right {
        text-align: right !important;
    }
    
    /* Flexbox para alineación */
    .print-only .flex {
        display: flex !important;
    }
    
    .print-only .justify-between {
        justify-content: space-between !important;
    }
    
    /* Bordes */
    .print-only .border-t-2 {
        border-top: 2px solid #000 !important;
    }
}

/* Animación de escaneo para validación de comprobantes */
@keyframes scan {
    0% {
        top: 0;
        opacity: 0;
    }
    25% {
        opacity: 1;
    }
    75% {
        opacity: 1;
    }
    100% {
        top: 100%;
        opacity: 0;
    }
}

.scan-line {
    position: absolute;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(139, 92, 246, 0.6),
        rgba(59, 130, 246, 0.8),
        rgba(6, 182, 212, 0.6),
        transparent
    );
    box-shadow: 0 0 20px rgba(139, 92, 246, 0.8),
                0 0 40px rgba(59, 130, 246, 0.6),
                0 0 60px rgba(6, 182, 212, 0.4);
    animation: scan 2s linear infinite;
    filter: blur(1px);
}

.scan-line::before {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    height: 30px;
    background: linear-gradient(
        to bottom,
        rgba(139, 92, 246, 0.3),
        transparent
    );
    filter: blur(10px);
}

.scan-line::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.9),
        transparent
    );
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ===========================
// FUNCIONES GLOBALES (deben cargarse primero)
// ===========================

// Función global para ver comprobante en modal con validación IA (COPIADO DE INDEX)
window.verComprobante = function(imageUrl, orderNumber, orderId = null, initialStatus = null, initialScore = 0) {
    const storeSlug = '<?php echo e($store->slug); ?>';
    const storeId = <?php echo e($store->id); ?>;
    
    // Crear backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'fixed inset-0 bg-black/80 backdrop-blur-sm z-[9998] transition-opacity duration-300 opacity-0';
    backdrop.style.backdropFilter = 'blur(4px)';
    
    // State para el modal
    let modalState = {
        loading: false,
        analyzing: false,
        validationStatus: initialStatus || '',
        validationScore: initialScore || 0
    };
    
    // Función para verificar estado de validación (POLLING)
    async function checkValidationStatus() {
        if (!orderId) return;
        
        try {
            const response = await fetch('/' + storeSlug + '/admin/orders/' + orderId + '/validation-status', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                
                // Si hay resultado, actualizar UI
                if (data.status && data.status !== null) {
                    console.log('✅ [Polling] Resultado encontrado:', data);
                    
                    // Detener polling
                    if (window.currentValidationPolling) {
                        clearInterval(window.currentValidationPolling);
                        window.currentValidationPolling = null;
                    }
                    
                    // Actualizar modal
                    window.updateValidationResult(data.status, data.score || 0);
                }
            }
        } catch (error) {
            console.error('❌ [Polling] Error:', error);
        }
    }
    
    // Variable para evitar procesar el resultado múltiples veces
    let resultProcessed = false;
    
    // Función GLOBAL para actualizar el modal con el resultado (usada por Polling y Pusher)
    window.updateValidationResult = function(status, score) {
        // Evitar procesar el mismo resultado múltiples veces
        if (resultProcessed) {
            console.log('⏭️ Resultado ya procesado, ignorando duplicado');
            return;
        }
        
        resultProcessed = true;
        console.log('✅ Procesando resultado:', status, score);
        
        modalState.validationStatus = status;
        modalState.validationScore = score;
        modalState.loading = false;
        modalState.analyzing = false;
        
        // Ocultar overlay de análisis
        const analysingOverlay = document.getElementById('analyzing-overlay');
        const validationBtn = document.getElementById('validation-btn');
        
        if (analysingOverlay) analysingOverlay.classList.add('hidden');
        if (validationBtn) validationBtn.style.display = 'none';
        
        // Actualizar contenedor de estado
        const statusContainer = document.getElementById('validation-status-container');
        if (statusContainer) {
            let statusHTML = '';
            if (status === 'valid') {
                statusHTML = '<div class="flex items-center gap-2 p-3 bg-green-50 text-green-700 rounded-lg">' +
                    '<i data-lucide="check-circle" class="w-5 h-5"></i>' +
                    '<div class="flex-1">' +
                    '<span class="font-medium">Comprobante validado</span>' +
                    '<p class="text-xs mt-1">Confianza: ' + score + '%</p>' +
                    '</div>' +
                    '</div>';
            } else if (status === 'suspicious') {
                statusHTML = '<div class="flex items-center gap-2 p-3 bg-yellow-50 text-yellow-700 rounded-lg">' +
                    '<i data-lucide="alert-triangle" class="w-5 h-5"></i>' +
                    '<div class="flex-1">' +
                    '<span class="font-medium">Comprobante dudoso</span>' +
                    '<p class="text-xs mt-1">Se recomienda revisión manual</p>' +
                    '</div>' +
                    '</div>';
            } else if (status === 'fake') {
                statusHTML = '<div class="flex items-center gap-2 p-3 bg-red-50 text-red-700 rounded-lg">' +
                    '<i data-lucide="x-circle" class="w-5 h-5"></i>' +
                    '<div class="flex-1">' +
                    '<span class="font-medium">Posible falsificación detectada</span>' +
                    '<p class="text-xs mt-1">Verificar con el cliente</p>' +
                    '</div>' +
                    '</div>';
            } else if (status === 'error') {
                statusHTML = '<div class="flex items-center gap-2 p-3 bg-gray-50 text-gray-700 rounded-lg">' +
                    '<i data-lucide="alert-circle" class="w-5 h-5"></i>' +
                    '<div class="flex-1">' +
                    '<span class="font-medium">Error en la validación</span>' +
                    '<p class="text-xs mt-1">Intenta nuevamente más tarde</p>' +
                    '</div>' +
                    '</div>';
            }
            statusContainer.innerHTML = statusHTML;
            
            // Reinicializar iconos
            if (window.createIcons && window.lucideIcons) {
                window.createIcons({ icons: window.lucideIcons });
            }
        }
        
        // Mostrar toast en bottom-center
        if (status === 'valid') {
            if (window.toast && typeof window.toast.success === 'function') {
                window.toast.success('✅ Validación completada', 'Comprobante auténtico - Confianza: ' + score + '%', 8000, 'bottom-center');
            }
        } else if (status === 'suspicious') {
            if (window.toast && typeof window.toast.warning === 'function') {
                window.toast.warning('⚠️ Validación completada', 'Comprobante dudoso - Se recomienda revisión manual', 10000, 'bottom-center');
            }
        } else if (status === 'fake') {
            if (window.toast && typeof window.toast.error === 'function') {
                window.toast.error('❌ Validación completada', 'Posible falsificación detectada - Verificar con el cliente', 10000, 'bottom-center');
            }
        } else if (status === 'error') {
            if (window.toast && typeof window.toast.error === 'function') {
                window.toast.error('❌ Error en validación', 'No se pudo validar el comprobante. Intenta nuevamente.', 8000, 'bottom-center');
            }
        }
        
        // Recargar la tabla después de 2 segundos
        setTimeout(() => {
            if (window.loadOrders) {
                window.loadOrders();
            }
        }, 2000);
    }
    
    // Función para validar comprobante (INICIA VALIDACIÓN + POLLING)
    window.validateProofModal = async function() {
        if (modalState.loading || modalState.validationStatus || !orderId) return;
        
        // Obtener banco seleccionado
        const bankSelector = document.getElementById('bank-selector');
        const selectedBank = bankSelector ? bankSelector.value : '';
        
        if (!selectedBank) {
            if (window.toast && typeof window.toast.warning === 'function') {
                window.toast.warning('Banco requerido', 'Por favor selecciona el banco/app de la transferencia', 5000, 'bottom-center');
            }
            return;
        }
        
        modalState.loading = true;
        modalState.analyzing = true;
        
        // Mostrar overlay de análisis
        const analysingOverlay = document.getElementById('analyzing-overlay');
        const validationBtn = document.getElementById('validation-btn');
        if (analysingOverlay) analysingOverlay.classList.remove('hidden');
        if (validationBtn) validationBtn.disabled = true;
        
        try {
            const response = await fetch('/' + storeSlug + '/admin/orders/' + orderId + '/validate-proof', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bank: selectedBank
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                if (window.toast && typeof window.toast.success === 'function') {
                    window.toast.success('¡Validación iniciada!', data.message || 'Verificando comprobante...', 5000, 'bottom-center');
                }
                
                // ⚡ INICIAR POLLING - Verificar cada 2 segundos
                console.log('🔄 [Polling] Iniciando verificación cada 2 segundos');
                checkValidationStatus(); // Primera verificación inmediata
                window.currentValidationPolling = setInterval(checkValidationStatus, 2000);
                
                // ⏱️ Timeout de 60 segundos (optimizado para comparación de plantillas)
                setTimeout(() => {
                    if (window.currentValidationPolling) {
                        clearInterval(window.currentValidationPolling);
                        window.currentValidationPolling = null;
                        console.log('⏱️ [Polling] Timeout - detenido');
                        
                        // Si aún está analizando, mostrar mensaje
                        if (modalState.analyzing) {
                            modalState.loading = false;
                            modalState.analyzing = false;
                            const analysingOverlay = document.getElementById('analyzing-overlay');
                            const validationBtn = document.getElementById('validation-btn');
                            if (analysingOverlay) analysingOverlay.classList.add('hidden');
                            if (validationBtn) validationBtn.disabled = false;
                            
                            if (window.toast && typeof window.toast.warning === 'function') {
                                window.toast.warning('Validación tomando mucho tiempo', 'Intenta refrescar la página en unos momentos', 8000, 'bottom-center');
                            }
                        }
                    }
                }, 60000);
            } else {
                if (window.toast && typeof window.toast.error === 'function') {
                    window.toast.error('Error', data.message || 'No se pudo validar el comprobante', 5000, 'bottom-center');
                }
                modalState.loading = false;
                modalState.analyzing = false;
                if (analysingOverlay) analysingOverlay.classList.add('hidden');
                if (validationBtn) validationBtn.disabled = false;
            }
        } catch (error) {
            if (window.toast && typeof window.toast.error === 'function') {
                window.toast.error('Error de conexión', 'No se pudo conectar con el servidor', 5000, 'bottom-center');
            }
            modalState.loading = false;
            modalState.analyzing = false;
            if (analysingOverlay) analysingOverlay.classList.add('hidden');
            if (validationBtn) validationBtn.disabled = false;
        }
    };
    
    // Crear modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-[9999] flex items-center justify-center p-4 opacity-0 scale-95 transition-all duration-300';
    
    modal.innerHTML = `
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 z-10">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-semibold text-gray-900">Comprobante - Pedido #${orderNumber}</h3>
                    <button onclick="window.cerrarModalComprobante()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                ${orderId && !modalState.validationStatus ? `
                <div>
                    <label for="bank-selector" class="block text-xs font-medium text-gray-600 mb-1.5">
                        <i data-lucide="building-2" class="w-3.5 h-3.5 inline mr-1"></i>
                        Banco/App de la transferencia:
                    </label>
                    <select 
                        id="bank-selector" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                        <option value="">Selecciona el banco/app...</option>
                        <option value="nequi">Nequi</option>
                        <option value="bancolombia">Bancolombia</option>
                        <option value="daviplata">Daviplata</option>
                        <option value="bbva">BBVA</option>
                        <option value="davivienda">Davivienda</option>
                        <option value="otro">Otro banco</option>
                    </select>
                </div>
                ` : ''}
            </div>
            
            <!-- Imagen con efecto de análisis -->
            <div class="p-4 overflow-auto max-h-[calc(90vh-280px)] flex items-center justify-center bg-gray-50 relative">
                <img src="${imageUrl}" alt="Comprobante" class="w-auto h-auto max-w-full max-h-[calc(90vh-320px)] rounded-lg shadow-lg" style="object-fit: contain;">
                
                <!-- Overlay de análisis animado -->
                <div id="analyzing-overlay" class="hidden absolute inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm rounded-lg transition-opacity duration-300">
                    <div class="relative">
                        <!-- Línea de escaneo animada -->
                        <div class="absolute inset-0 overflow-hidden rounded-lg">
                            <div class="scan-line"></div>
                        </div>
                        
                        <!-- Texto de análisis -->
                        <div class="relative z-10 text-center">
                            <div class="inline-flex items-center gap-3 px-6 py-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-2xl">
                                <div class="relative w-14 h-14 flex items-center justify-center">
                                    <!-- Círculo central sólido -->
                                    <div class="absolute w-3 h-3 rounded-full bg-gradient-to-r from-purple-400 to-blue-400 z-10"></div>
                                    <!-- Ondas pulsantes concéntricas -->
                                    <div class="absolute w-6 h-6 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 animate-ping"></div>
                                    <div class="absolute w-9 h-9 rounded-full bg-gradient-to-r from-purple-500/70 to-blue-500/70 animate-ping" style="animation-delay: 0.3s; animation-duration: 1s;"></div>
                                    <div class="absolute w-12 h-12 rounded-full bg-gradient-to-r from-purple-500/50 to-blue-500/50 animate-ping" style="animation-delay: 0.6s; animation-duration: 1.5s;"></div>
                                    <div class="absolute w-14 h-14 rounded-full bg-gradient-to-r from-purple-500/30 to-cyan-500/30 animate-ping" style="animation-delay: 0.9s; animation-duration: 1.8s;"></div>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-900 font-bold text-lg"><strong>KiuBot</strong> analizando...</p>
                                    <p class="text-gray-600 text-sm">Verificando autenticidad</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estado de validación -->
            <div id="validation-status-container" class="px-4 py-3 border-t border-gray-200 min-h-[60px]">
                ${modalState.validationStatus === 'valid' ? `
                <div class="flex items-center gap-2 p-3 bg-green-50 text-green-700 rounded-lg">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <div class="flex-1">
                        <span class="font-medium">Comprobante validado</span>
                        <p class="text-xs mt-1">Confianza: ${modalState.validationScore}%</p>
                    </div>
                </div>
                ` : ''}
                
                ${modalState.validationStatus === 'suspicious' ? `
                <div class="flex items-center gap-2 p-3 bg-yellow-50 text-yellow-700 rounded-lg">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    <div class="flex-1">
                        <span class="font-medium">Comprobante dudoso</span>
                        <p class="text-xs mt-1">Se recomienda revisión manual</p>
                    </div>
                </div>
                ` : ''}
                
                ${modalState.validationStatus === 'fake' ? `
                <div class="flex items-center gap-2 p-3 bg-red-50 text-red-700 rounded-lg">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                    <div class="flex-1">
                        <span class="font-medium">Posible falsificación detectada</span>
                        <p class="text-xs mt-1">Verificar con el cliente</p>
                    </div>
                </div>
                ` : ''}
                
                ${modalState.validationStatus === 'error' ? `
                <div class="flex items-center gap-2 p-3 bg-gray-50 text-gray-700 rounded-lg">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <div class="flex-1">
                        <span class="font-medium">Error en la validación</span>
                        <p class="text-xs mt-1">Intenta nuevamente más tarde</p>
                    </div>
                </div>
                ` : ''}
            </div>
            
            <!-- Botones de acción -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-4 py-3 flex gap-2">
                ${orderId && !modalState.validationStatus ? `
                <button 
                    id="validation-btn"
                    onclick="window.validateProofModal(); return false;"
                    class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 hover:from-purple-700 hover:via-blue-700 hover:to-cyan-700 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-lg shadow-purple-500/30">
                    <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-5 h-5">
                    <div class="flex flex-col items-start justify-start">
                        <span class="text-white font-semibold text-sm">Validar con KiuBot</span>
                        <span class="text-white font-normal text-xs"><strong>KiuBot</strong> esta en su version beta, es posible que cometamos errores.</span>
                    </div>
                </button>
                ` : ''}
                <a href="${imageUrl}" download class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    Descargar
                </a>
                <button onclick="window.cerrarModalComprobante()" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(backdrop);
    document.body.appendChild(modal);
    
    // Inicializar iconos
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
    
    // Animar entrada
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        modal.classList.remove('opacity-0', 'scale-95');
    }, 10);
    
    // Cerrar con ESC
    const handleEsc = (e) => {
        if (e.key === 'Escape') {
            window.cerrarModalComprobante();
        }
    };
    document.addEventListener('keydown', handleEsc);
    modal.dataset.escListener = 'true';
    
    // Cerrar con click en backdrop
    backdrop.addEventListener('click', window.cerrarModalComprobante);
    
    // NOTA: El listener de proof.validated está en el listener global de DOMContentLoaded
    // para evitar duplicados y asegurar que funcione siempre
};

window.cerrarModalComprobante = function() {
    const backdrop = document.querySelector('.fixed.inset-0.bg-black\\/80');
    const modal = document.querySelector('.fixed.inset-0.z-\\[9999\\]');
    
    if (backdrop) {
        backdrop.classList.add('opacity-0');
    }
    if (modal) {
        modal.classList.add('opacity-0', 'scale-95');
    }
    
    setTimeout(() => {
        if (backdrop && backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
        if (modal && modal.parentNode) modal.parentNode.removeChild(modal);
    }, 300);
};

// ===========================
// MODAL DE CAMBIO DE ESTADO (COPIADO DE INDEX)
// ===========================

// Función para mostrar modal de cambio de estado
function showStatusChangeModal(orderId, newStatus, selectElement, orderNumber) {
    const statusLabels = {
        'pending': 'Pendiente',
        'confirmed': 'Confirmado',
        'preparing': 'Preparando',
        'shipped': 'Enviado',
        'delivered': 'Entregado',
        'cancelled': 'Cancelado'
    };

    const originalStatus = selectElement ? selectElement.getAttribute('data-original-status') : null;
    
    // Crear modal si no existe
    let modalStatus = document.getElementById('status-change-modal');
    if (!modalStatus) {
        modalStatus = document.createElement('div');
        modalStatus.id = 'status-change-modal';
        modalStatus.className = 'fixed inset-0 z-[9999] overflow-y-auto';
        modalStatus.style.display = 'none';
        modalStatus.innerHTML = `
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" id="status-modal-backdrop"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" id="status-modal-content">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="info" class="h-6 w-6 text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-2">
                                    ¿Cambiar estado del pedido?
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    El estado cambiará a: <strong id="status-label"></strong>
                                </p>
                                <textarea id="status-notes-input" 
                                          class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                          placeholder="Notas adicionales (opcional)" 
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="status-confirm-btn"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-500 text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Cambiar Estado
                        </button>
                        <button type="button" id="status-cancel-btn"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modalStatus);
        
        // Inicializar iconos
        setTimeout(() => {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }
        }, 100);
    }
    
    // Configurar modal
    document.getElementById('status-label').textContent = statusLabels[newStatus];
    document.getElementById('status-notes-input').value = '';
    
    // Mostrar modal
    modalStatus.style.display = 'block';
    
    // Event listeners
    const confirmBtn = document.getElementById('status-confirm-btn');
    const cancelBtn = document.getElementById('status-cancel-btn');
    const backdrop = document.getElementById('status-modal-backdrop');
    
    const closeModal = () => {
        modalStatus.style.display = 'none';
        if (selectElement && originalStatus) {
            selectElement.value = originalStatus;
        }
    };
    
    const confirmChange = async () => {
        const notes = document.getElementById('status-notes-input').value;
        closeModal();
        await executeStatusChange(orderId, newStatus, notes);
    };
    
    // Remover listeners anteriores
    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = cancelBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    
    newConfirmBtn.addEventListener('click', confirmChange);
    newCancelBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
}

async function executeStatusChange(orderId, newStatus, notes) {
    try {
        const response = await fetch(`<?php echo e(route('tenant.admin.orders.update-status', [$store->slug, ':id'])); ?>`.replace(':id', orderId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus,
                notes: notes
            })
        });

        const data = await response.json();

        if (data.success) {
            if (typeof window.showToast === 'function') {
                window.showToast('success', '¡Estado actualizado!', 'El estado del pedido ha sido cambiado correctamente');
            }
            setTimeout(() => location.reload(), 1500);
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast('error', 'Error', data.message || 'No se pudo cambiar el estado del pedido');
            }
        }
    } catch (error) {
        if (typeof window.showToast === 'function') {
            window.showToast('error', 'Error de conexión', 'No se pudo conectar con el servidor');
        }
    }
}

function handleStatusChangeShow(orderId, newStatus, selectElement, orderNumber) {
    showStatusChangeModal(orderId, newStatus, selectElement, orderNumber);
}

// ===========================
// FUNCIONES DE VALIDACIÓN AI
// ===========================

window.validateProofModal = async function() {
    if (modalState.loading || modalState.validationStatus || !modalState.orderId) return;
    
    const storeSlug = '<?php echo e($store->slug); ?>';
    const orderId = modalState.orderId;
    
    const bankSelector = document.getElementById('bank-selector');
    const selectedBank = bankSelector ? bankSelector.value : '';
    
    if (!selectedBank) {
        if (window.toast && typeof window.toast.warning === 'function') {
            window.toast.warning('Banco requerido', 'Por favor selecciona el banco/app de la transferencia', 5000, 'bottom-center');
        }
        return;
    }
    
    modalState.loading = true;
    modalState.analyzing = true;
    
    const analysingOverlay = document.getElementById('analyzing-overlay');
    const validationBtn = document.getElementById('validation-btn');
    if (analysingOverlay) analysingOverlay.classList.remove('hidden');
    if (validationBtn) validationBtn.disabled = true;
    
    try {
        const response = await fetch('/' + storeSlug + '/admin/orders/' + orderId + '/validate-proof', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                bank: selectedBank
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (window.toast && typeof window.toast.success === 'function') {
                window.toast.success('Validación iniciada', 'Recibirás el resultado en unos segundos', 5000, 'bottom-center');
            }
            window.pollValidationResult(orderId, storeSlug);
        } else {
            throw new Error(data.message || 'Error al iniciar validación');
        }
    } catch (error) {
        console.error('Error:', error);
        modalState.loading = false;
        modalState.analyzing = false;
        
        if (analysingOverlay) analysingOverlay.classList.add('hidden');
        if (validationBtn) validationBtn.disabled = false;
        
        if (window.toast && typeof window.toast.error === 'function') {
            window.toast.error('Error', error.message || 'No se pudo iniciar la validación', 5000, 'bottom-center');
        }
    }
};

window.pollValidationResult = function(orderId, storeSlug) {
    const maxAttempts = 30;
    let attempts = 0;
    let resultProcessed = false;
    
    const pollInterval = setInterval(async () => {
        attempts++;
        
        if (attempts > maxAttempts || resultProcessed) {
            clearInterval(pollInterval);
            
            if (!resultProcessed) {
                modalState.loading = false;
                modalState.analyzing = false;
                
                const analysingOverlay = document.getElementById('analyzing-overlay');
                const validationBtn = document.getElementById('validation-btn');
                
                if (analysingOverlay) analysingOverlay.classList.add('hidden');
                if (validationBtn) validationBtn.style.display = 'none';
                
                if (window.toast && typeof window.toast.warning === 'function') {
                    window.toast.warning('Validación tomando mucho tiempo', 'Intenta refrescar la página en unos momentos', 8000, 'bottom-center');
                }
            }
            return;
        }
        
        try {
            const response = await fetch('/' + storeSlug + '/admin/orders/' + orderId + '/validation-status', {
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.status && data.status !== 'pending' && !resultProcessed) {
                resultProcessed = true;
                clearInterval(pollInterval);
                window.updateValidationResult(data.status, data.score);
            }
        } catch (error) {
            console.error('Polling error:', error);
        }
    }, 2000);
};

window.updateValidationResult = function(status, score) {
    modalState.loading = false;
    modalState.analyzing = false;
    modalState.validationStatus = status;
    modalState.validationScore = score;
    
    const analysingOverlay = document.getElementById('analyzing-overlay');
    const validationBtn = document.getElementById('validation-btn');
    
    if (analysingOverlay) analysingOverlay.classList.add('hidden');
    if (validationBtn) validationBtn.style.display = 'none';
    
    const statusContainer = document.getElementById('validation-status-container');
    if (statusContainer) {
        let statusHTML = '';
        
        if (status === 'valid') {
            statusHTML = '<div class="flex items-center gap-2 p-3 bg-green-50 text-green-700 rounded-lg">' +
                '<i data-lucide="check-circle" class="w-5 h-5"></i>' +
                '<div class="flex-1">' +
                '<span class="font-medium">Comprobante validado</span>' +
                '<p class="text-xs mt-1">Confianza: ' + score + '%</p>' +
                '</div>' +
                '</div>';
        } else if (status === 'suspicious') {
            statusHTML = '<div class="flex items-center gap-2 p-3 bg-yellow-50 text-yellow-700 rounded-lg">' +
                '<i data-lucide="alert-triangle" class="w-5 h-5"></i>' +
                '<div class="flex-1">' +
                '<span class="font-medium">Comprobante dudoso</span>' +
                '<p class="text-xs mt-1">Se recomienda revisión manual</p>' +
                '</div>' +
                '</div>';
        } else if (status === 'fake') {
            statusHTML = '<div class="flex items-center gap-2 p-3 bg-red-50 text-red-700 rounded-lg">' +
                '<i data-lucide="x-circle" class="w-5 h-5"></i>' +
                '<div class="flex-1">' +
                '<span class="font-medium">Posible falsificación</span>' +
                '<p class="text-xs mt-1">Verificar con el cliente</p>' +
                '</div>' +
                '</div>';
        } else if (status === 'error') {
            statusHTML = '<div class="flex items-center gap-2 p-3 bg-gray-50 text-gray-700 rounded-lg">' +
                '<i data-lucide="alert-circle" class="w-5 h-5"></i>' +
                '<div class="flex-1">' +
                '<span class="font-medium">Error en la validación</span>' +
                '<p class="text-xs mt-1">Intenta nuevamente más tarde</p>' +
                '</div>' +
                '</div>';
        }
        statusContainer.innerHTML = statusHTML;
        
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    }
    
    if (status === 'valid') {
        if (window.toast && typeof window.toast.success === 'function') {
            window.toast.success('Validación completada', 'Comprobante auténtico - Confianza: ' + score + '%', 8000, 'bottom-center');
        }
    } else if (status === 'suspicious') {
        if (window.toast && typeof window.toast.warning === 'function') {
            window.toast.warning('Validación completada', 'Comprobante dudoso - Se recomienda revisión manual', 10000, 'bottom-center');
        }
    } else if (status === 'fake') {
        if (window.toast && typeof window.toast.error === 'function') {
            window.toast.error('Validación completada', 'Posible falsificación detectada - Verificar con el cliente', 10000, 'bottom-center');
        }
    } else if (status === 'error') {
        if (window.toast && typeof window.toast.error === 'function') {
            window.toast.error('Error en validación', 'No se pudo validar el comprobante. Intenta nuevamente.', 8000, 'bottom-center');
        }
    }
    
    setTimeout(() => {
        window.location.reload();
    }, 2000);
};

// ===========================
// OTRAS FUNCIONES
// ===========================

function printOrder() {
    // Cargar html2pdf.js dinámicamente si no está cargado
    if (typeof html2pdf === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
        script.onload = function() {
            generatePDF();
        };
        document.head.appendChild(script);
    } else {
        generatePDF();
    }
    
    function generatePDF() {
        const receiptElement = document.getElementById('order-receipt-pos');
        if (!receiptElement) {
            alert('Error: No se encontró el contenedor del recibo');
            return;
        }
        
        // Obtener el contenido del componente
        const receiptContent = receiptElement.querySelector('.order-receipt-pos');
        if (!receiptContent) {
            alert('Error: No se encontró el contenido del recibo. Verifica la consola para más detalles.');
            console.error('Elemento order-receipt-pos no encontrado en:', receiptElement);
            return;
        }
        
        // Crear un contenedor temporal completamente visible en la pantalla
        const tempContainer = document.createElement('div');
        tempContainer.id = 'temp-pdf-container';
        tempContainer.style.position = 'fixed';
        tempContainer.style.left = '0';
        tempContainer.style.top = '0';
        tempContainer.style.width = '120mm';
        tempContainer.style.zIndex = '99999';
        tempContainer.style.backgroundColor = 'white';
        tempContainer.style.visibility = 'visible';
        tempContainer.style.display = 'block';
        tempContainer.style.opacity = '1';
        tempContainer.style.overflow = 'visible';
        
        // Clonar el contenido completo con todos sus estilos
        const clonedContent = receiptContent.cloneNode(true);
        
        // Asegurar que el contenido clonado tenga todos los estilos necesarios
        clonedContent.style.display = 'block';
        clonedContent.style.visibility = 'visible';
        clonedContent.style.opacity = '1';
        clonedContent.style.width = '120mm';
        clonedContent.style.backgroundColor = 'white';
        clonedContent.style.position = 'relative';
        clonedContent.style.left = '0';
        clonedContent.style.top = '0';
        
        // Asegurar que todos los elementos hijos sean visibles
        const allChildren = clonedContent.querySelectorAll('*');
        allChildren.forEach(child => {
            child.style.visibility = 'visible';
            if (child.style.display === 'none') {
                child.style.display = '';
            }
            if (child.style.opacity === '0' || child.style.opacity === '') {
                child.style.opacity = '1';
            }
        });
        
        tempContainer.appendChild(clonedContent);
        document.body.appendChild(tempContainer);
        
        // Esperar a que el contenido se renderice completamente
        setTimeout(() => {
            // Verificar que el contenido tenga texto
            const textContent = clonedContent.textContent || clonedContent.innerText;
            if (!textContent || textContent.trim().length === 0) {
                alert('Error: El contenido del recibo está vacío');
                document.body.removeChild(tempContainer);
                return;
            }
            
            console.log('Generando PDF con contenido de', textContent.length, 'caracteres');
            console.log('Dimensiones del contenido:', clonedContent.scrollWidth, 'x', clonedContent.scrollHeight);
            
            // Opciones para el PDF
            const opt = {
                margin: [0, 0, 0, 0],
                filename: 'pedido-<?php echo e($order->order_number); ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    logging: true,
                    allowTaint: false,
                    backgroundColor: '#ffffff',
                    width: clonedContent.scrollWidth || 264,
                    height: clonedContent.scrollHeight || 1000,
                    x: 0,
                    y: 0
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: [120, 500],
                    orientation: 'portrait'
                },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            
            // Generar y descargar el PDF desde el contenedor temporal
            html2pdf().set(opt).from(tempContainer).save().then(() => {
                console.log('PDF generado exitosamente');
                // Limpiar el contenedor temporal
                if (tempContainer.parentNode) {
                    document.body.removeChild(tempContainer);
                }
            }).catch((error) => {
                console.error('Error al generar PDF:', error);
                alert('Error al generar el PDF: ' + error.message);
                // Limpiar el contenedor temporal incluso si hay error
                if (tempContainer.parentNode) {
                    document.body.removeChild(tempContainer);
                }
            });
        }, 500);
    }
}

// Listener global para validación de comprobantes (siempre activo)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Echo !== 'undefined') {
        const storeId = <?php echo e($store->id); ?>;
        const currentOrderId = <?php echo e($order->id); ?>;
        
        console.log('[Echo] Conectando al canal store.' + storeId + '.orders para proof.validated');
        
        Echo.channel('store.' + storeId + '.orders')
            .listen('.proof.validated', (event) => {
            console.log('[Echo] Evento proof.validated recibido:', event);
            
            // Solo procesar si es para este pedido
            if (event.order_id === currentOrderId) {
                // Detener polling si existe (Pusher ganó la carrera)
                if (window.currentValidationPollingShow) {
                    clearInterval(window.currentValidationPollingShow);
                    window.currentValidationPollingShow = null;
                }
                
                // Si el modal está abierto, actualizar con la función compartida
                const modal = document.querySelector('.fixed.inset-0.z-\\[9999\\]');
                if (modal && typeof window.updateValidationResultShow === 'function') {
                    window.updateValidationResultShow(event.status, event.score);
                }
                
                // Mostrar toast según resultado
                if (event.status === 'valid') {
                    if (window.toast && typeof window.toast.success === 'function') {
                        window.toast.success(
                            'Validación completada',
                            'Comprobante auténtico - Confianza: ' + event.score + '%',
                            8000,
                            'bottom-center'
                        );
                    }
                } else if (event.status === 'suspicious') {
                    if (window.toast && typeof window.toast.warning === 'function') {
                        window.toast.warning(
                            'Validación completada',
                            'Comprobante dudoso - Se recomienda revisión manual',
                            10000,
                            'bottom-center'
                        );
                    }
                } else if (event.status === 'fake') {
                    if (window.toast && typeof window.toast.error === 'function') {
                        window.toast.error(
                            'Validación completada',
                            'Posible falsificación detectada - Verificar con el cliente',
                            10000,
                            'bottom-center'
                        );
                    }
                } else if (event.status === 'error') {
                    if (window.toast && typeof window.toast.error === 'function') {
                        window.toast.error(
                            'Error en validación',
                            'No se pudo validar el comprobante. Intenta nuevamente.',
                            8000,
                            'bottom-center'
                        );
                    }
                }
                
                // Si el modal está abierto, actualizar su estado
                const modalElement = document.querySelector('.fixed.inset-0.z-\\[9999\\]');
                if (modalElement) {
                    const analysingOverlay = document.getElementById('analyzing-overlay');
                    const validationBtn = document.getElementById('validation-btn');
                    
                    if (analysingOverlay) analysingOverlay.classList.add('hidden');
                    if (validationBtn) validationBtn.style.display = 'none';
                }
                
                // Recargar la página después de 2 segundos para actualizar la vista
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        });
    }
    
    // Inicializar select de estado con valor original
    const statusSelect = document.getElementById('order-status-select');
    if (statusSelect) {
        statusSelect.setAttribute('data-original-status', statusSelect.value);
    }
});
</script>
<?php $__env->stopPush(); ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/orders/show.blade.php ENDPATH**/ ?>