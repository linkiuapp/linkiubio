<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['order', 'store']));

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

foreach (array_filter((['order', 'store']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="order-receipt-pos" style="width: 120mm; padding: 5mm; background: white; font-family: 'Courier New', monospace; font-size: 10pt; color: #000; line-height: 1.3;">
    <!-- Header POS -->
    <div class="text-center mb-4">
        <h1 style="font-size: 14pt; font-weight: bold; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 1px;"><?php echo e($store->name); ?></h1>
        <?php if($store->address): ?>
        <p style="margin: 2px 0; font-size: 9pt;"><?php echo e($store->address); ?></p>
        <?php endif; ?>
        <?php if($store->phone): ?>
        <p style="margin: 2px 0; font-size: 9pt;">Tel: <?php echo e($store->phone); ?></p>
        <?php endif; ?>
        <?php if($store->email): ?>
        <p style="margin: 2px 0; font-size: 9pt;"><?php echo e($store->email); ?></p>
        <?php endif; ?>
        <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información del Pedido -->
    <div style="margin-bottom: 9px;">
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Pedido:</span>
            <span style="font-weight: bold;">#<?php echo e($order->order_number); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Fecha:</span>
            <span><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Estado:</span>
            <span><?php echo e($order->status_label); ?></span>
        </div>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información del Cliente -->
    <div style="margin-bottom: 9px;">
        <p style="font-size: 9pt; font-weight: bold; margin-bottom: 3px;">CLIENTE:</p>
        <p style="font-size: 9pt; margin: 2px 0;"><?php echo e($order->customer_name); ?></p>
        <p style="font-size: 9pt; margin: 2px 0;">Tel: <?php echo e($order->customer_phone); ?></p>
        <?php if($order->customer_address): ?>
        <p style="font-size: 9pt; margin: 2px 0;"><?php echo e($order->customer_address); ?></p>
        <?php endif; ?>
        <?php if($order->city): ?>
        <p style="font-size: 9pt; margin: 2px 0;"><?php echo e($order->city); ?><?php echo e($order->department ? ', ' . $order->department : ''); ?></p>
        <?php endif; ?>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Productos -->
    <div style="margin-bottom: 9px;">
        <p style="font-size: 9pt; font-weight: bold; margin-bottom: 6px;">PRODUCTOS:</p>
        <table style="width: 100%; border-collapse: collapse; margin: 4px 0; font-size: 9pt; table-layout: fixed;">
            <colgroup>
                <col style="width: 15%;">
                <col style="width: 40%;">
                <col style="width: 22.5%;">
                <col style="width: 22.5%;">
            </colgroup>
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th style="text-align: left; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Cant</th>
                    <th style="text-align: left; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Descripción</th>
                    <th style="text-align: right; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">P.Unit</th>
                    <th style="text-align: right; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="border-bottom: 1px dashed #666;">
                    <td style="padding: 4px 3px; vertical-align: top; text-align: left;"><?php echo e($item->quantity); ?></td>
                    <td style="padding: 4px 3px; vertical-align: top; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                        <?php echo e($item->product_name); ?>

                        <?php if($item->variant_details): ?>
                        <br><span style="font-size: 8pt; color: #666;">(<?php echo e($item->formatted_variants); ?>)</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right; padding: 4px 3px; vertical-align: top; white-space: nowrap;">$<?php echo e(number_format($item->unit_price, 0, ',', '.')); ?></td>
                    <td style="text-align: right; padding: 4px 3px; vertical-align: top; font-weight: 600; white-space: nowrap;">$<?php echo e(number_format($item->item_total, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <!-- Totales -->
    <div style="margin-bottom: 9px;">
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Subtotal:</span>
            <span>$<?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
        </div>
        <?php if($order->shipping_cost > 0): ?>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Envío:</span>
            <span>$<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
        </div>
        <?php endif; ?>
        <?php if($order->coupon_discount > 0): ?>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Descuento:</span>
            <span>-$<?php echo e(number_format($order->coupon_discount, 0, ',', '.')); ?></span>
        </div>
        <?php endif; ?>
        <div style="border-top: 2px solid #000; margin: 6px 0;"></div>
        <div style="display: flex; justify-content: space-between; font-size: 10pt; font-weight: bold; margin-bottom: 6px;">
            <span>TOTAL:</span>
            <span>$<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
        </div>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información de Pago y Entrega -->
    <div style="margin-bottom: 9px; font-size: 9pt;">
        <p style="margin-bottom: 3px;"><strong>Método de Pago:</strong> 
            <?php if($order->payment_method === 'transferencia' || $order->payment_method === 'bank_transfer'): ?>
                Transferencia Bancaria
            <?php elseif($order->payment_method === 'contra_entrega'): ?>
                Pago Contra Entrega
            <?php elseif($order->payment_method === 'efectivo' || $order->payment_method === 'cash'): ?>
                Efectivo
            <?php else: ?>
                <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?>

            <?php endif; ?>
        </p>
        <p style="margin-bottom: 3px;"><strong>Tipo de Entrega:</strong> 
            <?php if(in_array($order->delivery_type, ['domicilio', 'local', 'national'])): ?>
                <?php if($order->delivery_type === 'national'): ?>
                    Envío Nacional
                <?php else: ?>
                    Domicilio
                <?php endif; ?>
            <?php else: ?>
                Consumo en Local
            <?php endif; ?>
        </p>
        <?php if($order->notes): ?>
        <p style="margin-bottom: 3px;"><strong>Notas:</strong> <?php echo e($order->notes); ?></p>
        <?php endif; ?>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Footer POS -->
    <div style="text-align: center; font-size: 9pt; margin-top: 12px;">
        <p style="margin-bottom: 3px;">¡Gracias por su compra!</p>
        <p style="margin-bottom: 3px;">Pedido #<?php echo e($order->order_number); ?></p>
        <p><?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
    </div>
</div>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Orders/OrderReceiptPOS.blade.php ENDPATH**/ ?>