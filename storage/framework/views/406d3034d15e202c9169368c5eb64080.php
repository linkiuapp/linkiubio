<?php $__env->startSection('title', 'Factura #' . $invoice->invoice_number); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Factura #<?php echo e($invoice->invoice_number); ?></h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona y descarga tu factura</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('tenant.admin.billing.index', ['store' => $invoice->store->slug])); ?>" 
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Volver
            </a>
            <a href="<?php echo e(route('tenant.admin.invoices.download', ['store' => $invoice->store->slug, 'invoice' => $invoice])); ?>" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i>
                Descargar PDF
            </a>
            <button onclick="printInvoice()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Imprimir
            </button>
        </div>
    </div>

    <!-- Factura -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-8" id="invoice-content">
            <!-- Header de la factura -->
            <div class="flex flex-wrap justify-between gap-6 border-b border-gray-200 pb-6 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-black-500 mb-1">Factura #<?php echo e($invoice->invoice_number); ?></h2>
                    <p class="text-caption text-black-300 mb-1">Fecha de emisión: <?php echo e($invoice->issue_date->format('d/m/Y')); ?></p>
                    <p class="text-caption text-black-300">Fecha de vencimiento: <?php echo e($invoice->due_date->format('d/m/Y')); ?></p>
                </div>
                <div class="text-right">
                    <?php if($billingSettings->logo_url): ?>
                        <?php
                            $logoUrl = $billingSettings->logo_url;
                            // Si la URL comienza con /storage/, convertir a URL completa
                            if (strpos($logoUrl, '/storage/') === 0) {
                                $logoUrl = asset($logoUrl);
                            }
                            // O si es solo el path del storage, agregar asset
                            if (!filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                                $logoUrl = asset('storage/' . ltrim($logoUrl, '/storage/'));
                            }
                        ?>
                        <img src="<?php echo e($logoUrl); ?>" alt="Logo" class="h-16 mb-3 ml-auto">
                    <?php endif; ?>
                    <div class="text-caption text-black-400">
                        <p class="font-semibold text-black-500"><?php echo e($billingSettings->company_name ?? 'Linkiu.bio'); ?></p>
                        <?php if($billingSettings->company_address): ?>
                            <p><?php echo e($billingSettings->company_address); ?></p>
                        <?php endif; ?>
                        <?php if($billingSettings->tax_id): ?>
                            <p><?php echo e($billingSettings->tax_id); ?></p>
                        <?php endif; ?>
                        <?php if($billingSettings->phone): ?>
                            <p><?php echo e($billingSettings->phone); ?></p>
                        <?php endif; ?>
                        <?php if($billingSettings->email): ?>
                            <p><?php echo e($billingSettings->email); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h6 class="text-body-large font-bold text-black-500 mb-3">Facturado a:</h6>
                    <div class="text-caption text-black-400 space-y-1">
                        <p><strong>Tienda:</strong> <?php echo e($invoice->store->name); ?></p>
                        <p><strong>Propietario:</strong> <?php echo e($invoice->store->owner_name); ?></p>
                        <p><strong>Email:</strong> <?php echo e($invoice->store->owner_email); ?></p>
                        <?php if($invoice->store->phone): ?>
                            <p><strong>Teléfono:</strong> <?php echo e($invoice->store->phone); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <div class="text-caption text-black-400 space-y-1">
                        <p><strong>Fecha de emisión:</strong> <?php echo e($invoice->issue_date->format('d \\d\\e F, Y')); ?></p>
                        <p><strong>ID de factura:</strong> #<?php echo e($invoice->invoice_number); ?></p>
                        <p><strong>Plan:</strong> <?php echo e($invoice->plan->name ?? 'N/A'); ?></p>
                        <p><strong>Período:</strong> <?php echo e(ucfirst($invoice->billing_period ?? 'Mensual')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Detalle de servicios -->
            <div class="mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-caption font-medium text-gray-500 uppercase tracking-wider">Ítem</th>
                                <th class="px-6 py-3 text-left text-caption font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-center text-caption font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-6 py-3 text-right text-caption font-medium text-gray-500 uppercase tracking-wider">Precio Unit.</th>
                                <th class="px-6 py-3 text-right text-caption font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="px-6 py-4 text-caption font-medium text-black-500">01</td>
                                <td class="px-6 py-4 text-caption text-black-400">
                                    <div>
                                        <p class="font-medium"><?php echo e($invoice->plan->name ?? 'Plan de suscripción'); ?></p>
                                        <p class="text-caption text-black-300">
                                            Suscripción <?php echo e(strtolower($invoice->billing_period ?? 'mensual')); ?>

                                            <?php if($invoice->period_start && $invoice->period_end): ?>
                                                <br><?php echo e($invoice->period_start->format('d/m/Y')); ?> - <?php echo e($invoice->period_end->format('d/m/Y')); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-caption text-black-400 text-center">1</td>
                                <td class="px-6 py-4 text-caption text-black-400 text-right">$<?php echo e(number_format($invoice->amount, 0, ',', '.')); ?> COP</td>
                                <td class="px-6 py-4 text-caption font-medium text-black-500 text-right">$<?php echo e(number_format($invoice->amount, 0, ',', '.')); ?> COP</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totales -->
                <div class="flex justify-end mt-6">
                    <div class="w-80">
                        <div class="space-y-2">
                            <div class="flex justify-between py-2">
                                <span class="text-caption text-black-400">Subtotal:</span>
                                <span class="font-bold text-black-500">$<?php echo e(number_format($invoice->amount, 0, ',', '.')); ?> COP</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-caption text-black-400">Descuento:</span>
                                <span class="font-bold text-black-500">$0 COP</span>
                            </div>
                            <div class="flex justify-between py-2 border-t border-gray-200 pt-4">
                                <span class="font-bold text-black-500">Total:</span>
                                <span class="text-body-large font-bold text-black-500">$<?php echo e(number_format($invoice->amount, 0, ',', '.')); ?> COP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado y método de pago -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h6 class="text-body-large font-bold text-black-500 mb-3">Estado del pago:</h6>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-medium
                        <?php if($invoice->status === 'paid'): ?> bg-success-100 text-success-700
                        <?php elseif($invoice->status === 'pending'): ?> bg-warning-100 text-warning-700
                        <?php else: ?> bg-error-100 text-error-700 <?php endif; ?>">
                        <?php if($invoice->status === 'paid'): ?>
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Pagada
                        <?php elseif($invoice->status === 'pending'): ?>
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-clock-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Pendiente
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Vencida
                        <?php endif; ?>
                    </span>
                </div>
                <?php if($invoice->payment_method): ?>
                <div>
                    <h6 class="text-body-large font-bold text-black-500 mb-3">Método de pago:</h6>
                    <p class="text-caption text-black-400"><?php echo e($invoice->payment_method); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <?php if($billingSettings->footer_text): ?>
            <div class="mt-12 pt-6 border-t border-gray-200">
                <p class="text-center text-caption text-black-300"><?php echo e($billingSettings->footer_text); ?></p>
            </div>
            <?php endif; ?>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-center text-caption text-black-300 font-bold">¡Gracias por confiar en Linkiu.bio!</p>
            </div>
        </div>
    </div>
</div>

<script>
function printInvoice() {
    var printContents = document.getElementById('invoice-content').innerHTML;
    var originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shared::layouts.tenant-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/billing/invoice-view.blade.php ENDPATH**/ ?>