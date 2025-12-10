<?php $__env->startPush('scripts'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<!-- Pusher para notificaciones en tiempo real -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 py-6 space-y-6" data-order-id="<?php echo e($order->id); ?>">
    <!-- Header dinámico según método de envío -->
    <div class="text-center">
        <div class="w-28 h-28 bg-gradient-to-r from-brandPrimary-300 to-brandSecondary-300 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
            <?php if(($order->delivery_type ?? '') === 'domicilio'): ?>
            <lord-icon
                src="https://cdn.lordicon.com/kxnplube.json"
                trigger="loop"
                stroke="bold"
                colors="primary:#ffffff,secondary:#ffffff"
                style="width:100px;height:100px">
            </lord-icon>
            <?php else: ?>
            <lord-icon
                src="https://cdn.lordicon.com/wxopfjkt.json"
                trigger="loop"
                stroke="bold"
                colors="primary:#ffffff,secondary:#ffffff"
                style="width:100px;height:100px">
            </lord-icon>
            <?php endif; ?>
        </div>
        
        <?php if(($order->delivery_type ?? '') === 'domicilio'): ?>
            <h1 class="h1 font-bold text-brandNeutral-400 mb-2">¡Tu pedido viene en camino!</h1>
            <p class="body-regular text-brandNeutral-400">Lo enviaremos a tu domicilio lo antes posible</p>
        <?php else: ?>
            <h1 class="h1 font-bold text-brandNeutral-400 mb-2">¡Tu pedido está listo!</h1>
            <p class="body-regular text-brandNeutral-400">Podrás recogerlo en nuestra tienda pronto</p>
        <?php endif; ?>
    </div>

    <!-- Código de pedido destacado -->
    <div class="bg-gradient-to-r from-brandPrimary-100 to-brandSecondary-100 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <div class="text-center">
            <h2 class="caption-strong text-brandNeutral-400 mb-2">CÓDIGO DE PEDIDO</h2>
            <div class="bg-brandWhite-50 rounded-lg p-4 border-2 border-dashed border-brandPrimary-300">
                <p class="h1 font-bold text-brandPrimary-300 tracking-wider" id="order-code"><?php echo e($order->order_number ?? 'N/A'); ?></p>
                <button onclick="copyOrderCode()" class="mt-2 caption bg-brandPrimary-300 hover:bg-brandSuccess-300 hover:text-brandWhite-50 text-brandWhite-50 px-3 py-2 rounded-full transition-colors">
                    Copiar
                </button>
            </div>
        </div>
    </div>

    <!-- Estado del pedido en tiempo real -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="body-large font-bold text-brandNeutral-400 mb-4 flex items-center">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-clipboard-list-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-brandNeutral-400 mr-2']); ?>
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
            Estado del pedido
        </h3>
        <div id="order-status-tracker" class="space-y-4">
            <!-- Los estados se cargan dinámicamente -->
            <div class="text-center py-4">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-brandPrimary-300 mx-auto"></div>
                <p class="body-small text-brandNeutral-400 mt-2">Cargando estado...</p>
            </div>
        </div>
    </div>

    <!-- Detalles del pedido -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="body-large text-brandNeutral-400 mb-4 flex items-center">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-document-text-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-brandNeutral-400 mr-2']); ?>
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
            Detalles del pedido
        </h3>
        
        <div class="space-y-4">
            <!-- Información del cliente -->
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">Información del Cliente</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Nombre:</span>
                        <span class="caption-strong text-brandNeutral-400"><?php echo e($order->customer_name ?? 'N/A'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Teléfono:</span>
                        <span class="caption-strong text-brandNeutral-400"><?php echo e($order->customer_phone ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Información de entrega -->
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">
                    <?php if(($order->delivery_type ?? '') === 'domicilio'): ?>
                        Información de Envío
                    <?php else: ?>
                        Información de Recogida
                    <?php endif; ?>
                </h4>
                <div class="space-y-2 text-sm">
                    <?php if(($order->delivery_type ?? '') === 'domicilio'): ?>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Dirección:</span>
                            <span class="caption-strong text-brandNeutral-400 text-right"><?php echo e($order->customer_address ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Ciudad:</span>
                            <span class="caption-strong text-brandNeutral-400"><?php echo e($order->city ?? 'N/A'); ?></span>
                        </div>
                    <?php else: ?>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Dirección tienda:</span>
                            <span class="caption-strong text-brandNeutral-400 text-right"><?php echo e($store->address ?? 'Ver en Google Maps'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Horario:</span>
                            <span class="caption-strong text-brandNeutral-400"><?php echo e($store->schedule ?? 'Lun-Vie 9am-6pm'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Resumen de pago -->
            <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                <h4 class="caption-strong text-brandNeutral-400 mb-3">Resumen de Pago</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="caption text-brandNeutral-400">Método:</span>
                        <span class="caption-strong text-brandNeutral-400">
                            <?php if(($order->payment_method ?? '') === 'efectivo' || ($order->payment_method ?? '') === 'cash'): ?>
                                Efectivo
                            <?php elseif(($order->payment_method ?? '') === 'transferencia' || ($order->payment_method ?? '') === 'bank_transfer'): ?>
                                Transferencia
                            <?php elseif(($order->payment_method ?? '') === 'contra_entrega'): ?>
                                Contra Entrega
                            <?php elseif(($order->payment_method ?? '') === 'card_terminal'): ?>
                                Terminal de Pago
                            <?php else: ?>
                                <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A'))); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if((($order->payment_method ?? '') === 'efectivo' || ($order->payment_method ?? '') === 'cash') && isset($order->cash_amount)): ?>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Pagas con:</span>
                            <span class="caption-strong text-brandNeutral-400">$<?php echo e(number_format($order->cash_amount, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="caption text-brandNeutral-400">Tu cambio:</span>
                            <span class="caption-strong text-brandSuccess-400">$<?php echo e(number_format($order->cash_amount - $order->total, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="border-t border-accent-200 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="caption-strong text-brandNeutral-400">Total a pagar:</span>
                            <span class="h3 text-brandPrimary-300">$<?php echo e(number_format($order->total ?? 0, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones de compartir -->
    <div class="bg-brandWhite-50 rounded-xl p-6 border border-brandWhite-300 shadow-sm">
        <h3 class="body-large font-bold text-brandNeutral-400 mb-4 flex items-center">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-share-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-brandNeutral-400 mr-2']); ?>
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
            Compartir
        </h3>
        
        <div class="grid grid-cols-1 gap-3">
            <!-- Compartir con el negocio -->
            <button onclick="shareWithBusiness()" class="flex items-center justify-center w-full bg-brandSuccess-300 hover:bg-brandSuccess-200 text-brandWhite-50 py-3 px-4 rounded-lg font-medium transition-colors">
                <i data-lucide="phone" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
                Contactar al negocio
            </button>
            
            <!-- Compartir con un amigo -->
            <button onclick="shareWithFriend()" class="flex items-center justify-center w-full bg-brandInfo-300 hover:bg-brandInfo-200 text-brandWhite-50 py-3 px-4 rounded-lg font-medium transition-colors">
                <i data-lucide="heart" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
                Compartir con un amigo
            </button>
        </div>
    </div>

    <!-- Acciones principales -->
    <div class="grid grid-cols-1 gap-3">
        <button onclick="refreshOrderStatus()" class="flex items-center justify-center w-full bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-50 py-3 px-4 rounded-lg font-semibold transition-colors">
            <i data-lucide="refresh-cw" class="w-6 h-6 text-brandWhite-50 mr-2"></i>
            Actualizar estado
        </button>
        
        <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" 
           class="flex items-center justify-center w-full bg-brandWhite-300 hover:bg-brandWhite-200 text-brandNeutral-400 py-3 px-4 rounded-lg font-medium transition-colors">
            <i data-lucide="shopping-cart" class="w-6 h-6 text-brandNeutral-400 mr-2"></i>
            Continuar comprando
        </a>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
const ORDER_ID = <?php echo e($order->id ?? 'null'); ?>;
const STORE_SLUG = '<?php echo e($store->slug ?? ''); ?>';
const STORE_PHONE = '<?php echo e($store->phone ?? ''); ?>';
const CUSTOMER_PHONE = '<?php echo e($order->customer_phone ?? ''); ?>';

// Cargar estado del pedido al iniciar
document.addEventListener('DOMContentLoaded', function() {
    loadOrderStatus();
    
    // ✅ RESETEAR CARRITO DESPUÉS DE PEDIDO COMPLETADO
    resetCartAfterOrder();
    
    // 🎉 CONFETTI DE CELEBRACIÓN - Solo en primera carga
    if (!sessionStorage.getItem('order_confetti_shown_<?php echo e($order->id); ?>')) {
        if (typeof window.confetti === 'function') {
            setTimeout(() => {
                // Confetti sutil desde arriba
                window.confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.4 },
                    colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                    startVelocity: 25,
                    ticks: 50,
                    gravity: 0.8
                });
                
                // Segundo burst más pequeño
                setTimeout(() => {
                    window.confetti({
                        particleCount: 40,
                        spread: 50,
                        origin: { y: 0.4 },
                        colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                        startVelocity: 20,
                        ticks: 40
                    });
                }, 250);
            }, 300);
            
            // Marcar que ya se mostró
            sessionStorage.setItem('order_confetti_shown_<?php echo e($order->id); ?>', 'true');
        }
    }
    
    // 🔔 INICIALIZAR PUSHER PARA ESCUCHAR CAMBIOS EN TIEMPO REAL
    initRealtimeNotifications();
    
    // Actualizar cada 30 segundos (backup por si Pusher falla)
    setInterval(loadOrderStatus, 30000);
});

// Función para resetear el carrito después de completar el pedido
function resetCartAfterOrder() {
    try {
        // Si existe la función global clearCart (del cart.js)
        if (typeof window.clearCart === 'function') {
            window.clearCart();
            console.log('🛒 Carrito reseteado después del pedido');
        }
        
        // También limpiar localStorage por si acaso
        localStorage.removeItem('cart_items');
        localStorage.removeItem('cart_count');
        
        // Limpiar sessionStorage
        sessionStorage.removeItem('cart_data');
        
    } catch (error) {
        console.error('Error reseteando carrito:', error);
    }
}

// Cargar estado del pedido
async function loadOrderStatus() {
    if (!ORDER_ID) return;
    
    try {
        const response = await fetch(`/${STORE_SLUG}/checkout/api/order-status?id=${ORDER_ID}`);
        const data = await response.json();
        
        if (data.success) {
            renderOrderStatus(data.order);
        }
    } catch (error) {
        console.error('Error cargando estado:', error);
    }
}

// Mapear estados de inglés (BD) a español (frontend)
function mapOrderStatus(dbStatus) {
    const statusMap = {
        'pending': 'pendiente',
        'confirmed': 'confirmado', 
        'preparing': 'en_preparacion',
        'ready': 'listo',
        'shipped': 'en_camino',
        'delivered': 'entregado'
    };
    return statusMap[dbStatus] || dbStatus;
}

// Renderizar estado del pedido
function renderOrderStatus(order) {
    const container = document.getElementById('order-status-tracker');
    
    // Mapear el estado de la BD al español
    const currentStatus = mapOrderStatus(order.status);
    
    console.log('🔄 Estado actualizado:', {
        original: order.status,
        mapped: currentStatus,
        order: order
    });
    
    const statusSteps = [
        { key: 'pendiente', label: 'Pedido Recibido', icon: '<i data-lucide="clipboard-copy" class="w-6 h-6 text-brandPrimary-500"></i>', description: 'Tu pedido ha sido registrado' },
        { key: 'confirmado', label: 'Confirmado', icon: '<i data-lucide="flame" class="w-6 h-6 text-brandPrimary-500"></i>', description: 'Hemos confirmado tu pedido' },
        { key: 'en_preparacion', label: 'En Preparación', icon: '<i data-lucide="wand-sparkles" class="w-6 h-6 text-brandPrimary-500"></i>', description: 'Estamos preparando tu pedido' },
        { key: 'listo', label: 'Listo', icon: '<i data-lucide="thumbs-up" class="w-6 h-6 text-brandPrimary-500"></i>', description: 'Tu pedido está listo' },
        { key: 'en_camino', label: 'En Camino', icon: '<i data-lucide="party-popper" class="w-6 h-6 text-brandPrimary-500"></i>', description: 'En route a tu dirección' },
        { key: 'entregado', label: 'Entregado', icon: '<i data-lucide="trophy" class="w-6 h-6 text-brandPrimary-500"></i>', description: '¡Disfruta tu pedido!' }
    ];
    
    // Encontrar el estado actual para mostrar el indicador principal
    const currentStep = statusSteps.find(step => step.key === currentStatus);
    
    let html = `
        <!-- Indicador principal del estado actual -->
        <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-lg p-4 mb-4 border border-primary-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary-300 rounded-full flex items-center justify-center text-accent-50 text-lg mr-3">
                        ${currentStep ? currentStep.icon : '<?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-clipboard-list-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-accent-50']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>'}
                    </div>
                    <div>
                        <h4 class="font-semibold text-primary-500">Estado Actual</h4>
                        <p class="text-body-small text-primary-500">${currentStep ? currentStep.label : currentStatus}</p>
                        <p class="text-small text-primary-500"> Actualizado: ${new Date(order.updated_at).toLocaleString('es-ES')}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tracker de progreso -->
        <div class="space-y-3">
    `;
    
    statusSteps.forEach((step, index) => {
        const isActive = currentStatus === step.key;
        const isCompleted = getStatusOrder(currentStatus) > getStatusOrder(step.key);
        
        html += `
            <div class="flex items-center ${isActive ? 'bg-primary-50 border border-primary-200 rounded-lg p-3' : 'p-3'}">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3 ${
                    isCompleted ? 'bg-success-300 text-black-500' :
                    isActive ? 'bg-primary-300 text-accent-50' :
                    'bg-accent-200 text-black-500'
                }">
                    ${isCompleted ? '<?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-black-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>' : step.icon}
                </div>
                <div class="flex-1">
                    <h4 class="text-caption font-semibold ${isActive ? 'text-primary-400' : isCompleted ? 'text-success-400' : 'text-black-400'}">${step.label}</h4>
                    <p class="text-caption ${isActive ? 'text-primary-300' : 'text-black-300'}">${step.description}</p>
                </div>
                ${isActive ? '<div class="animate-pulse w-2 h-2 bg-primary-300 rounded-full"></div>' : ''}
            </div>
        `;
    });
    
    html += '</div></div>'; // Cerrar tanto el space-y-3 como el contenedor principal
    container.innerHTML = html;
    
    // Inicializar iconos de Lucide después de insertar HTML dinámicamente
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
}

// Obtener orden numérico del estado
function getStatusOrder(status) {
    const order = {
        'pendiente': 1,
        'confirmado': 2,
        'en_preparacion': 3,
        'listo': 4,
        'en_camino': 5,
        'entregado': 6
    };
    return order[status] || 0;
}

// Copiar código de pedido
function copyOrderCode() {
    const code = document.getElementById('order-code').textContent;
    
    navigator.clipboard.writeText(code).then(() => {
        alert('📋 Código copiado: ' + code);
    }).catch(() => {
        alert('Código del pedido: ' + code);
    });
}

// Compartir con el negocio via WhatsApp
function shareWithBusiness() {
    const orderNumber = '<?php echo e($order->order_number ?? "N/A"); ?>';
    const customerName = '<?php echo e($order->customer_name ?? "Cliente"); ?>';
    const total = '<?php echo e($order->total ?? 0); ?>';
    const storeName = '<?php echo e($store->name ?? "Tienda"); ?>';
    
    let message = `🛍️ *Confirmación de Pedido*\n\n`;
    message += `👋 ¡Hola ${storeName}! Soy *${customerName}*\n\n`;
    message += `📋 *Pedido:* #${orderNumber}\n`;
    message += `💰 *Total:* $${formatPrice(total)}\n\n`;
    
    <?php if(($order->delivery_type ?? '') === 'domicilio'): ?>
        message += `🚚 *Tipo:* Domicilio\n`;
        message += `📍 *Dirección:* <?php echo e($order->customer_address ?? 'N/A'); ?>\n`;
    <?php else: ?>
        message += `🏪 *Tipo:* Recogida en tienda\n`;
    <?php endif; ?>
    
    message += `📞 *Teléfono:* <?php echo e($order->customer_phone ?? 'N/A'); ?>\n\n`;
    message += `¿Podrían confirmar que recibieron mi pedido? ¡Gracias! 😊`;
    
    const whatsappNumber = STORE_PHONE || '<?php echo e($store->phone ?? ""); ?>';
    if (!whatsappNumber) {
        alert('Número de WhatsApp no configurado para esta tienda');
        return;
    }
    
    const url = `https://wa.me/${whatsappNumber.replace(/\D/g, '')}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Compartir con un amigo
function shareWithFriend() {
    const orderCode = document.getElementById('order-code').textContent;
    const message = `¡Acabo de hacer un pedido en <?php echo e($store->name ?? 'esta tienda'); ?>! 🛍️\n\nCódigo: ${orderCode}\n\nRevisa sus productos: ${window.location.origin}/<?php echo e($store->slug ?? ''); ?>`;
    
    if (CUSTOMER_PHONE) {
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    } else {
        // Copiar al portapapeles si no hay teléfono
        navigator.clipboard.writeText(message).then(() => {
            alert('📋 Mensaje copiado. Compártelo donde quieras!');
        }).catch(() => {
            alert('Mensaje para compartir:\n\n' + message);
        });
    }
}

// Actualizar estado manualmente
function refreshOrderStatus() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="mr-2">⏳</span>Actualizando...';
    button.disabled = true;
    
    loadOrderStatus().then(() => {
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    });
}

// 🔔 INICIALIZAR NOTIFICACIONES EN TIEMPO REAL CON PUSHER
function initRealtimeNotifications() {
    if (!ORDER_ID) {
        console.log('❌ No hay ORDER_ID, no se inicializa Pusher');
        return;
    }
    
    try {
        console.log('🔔 Inicializando Pusher para pedido:', ORDER_ID);
        
        // Inicializar Pusher
        const pusher = new Pusher('<?php echo e(config("broadcasting.connections.pusher.key")); ?>', {
            cluster: '<?php echo e(config("broadcasting.connections.pusher.options.cluster")); ?>',
            forceTLS: true
        });
        
        // Suscribirse al canal del pedido
        const orderChannel = pusher.subscribe(`order.${ORDER_ID}`);
        
        console.log('📡 Suscrito al canal: order.' + ORDER_ID);
        
        // Escuchar cambios de estado
        orderChannel.bind('status.changed', function(data) {
            console.log('🔔 ¡Estado del pedido cambió!', data);
            
            // Mostrar notificación visual
            showStatusChangeNotification(data);
            
            // Reproducir sonido
            playNotificationSound();
            
            // Actualizar el estado en la página
            loadOrderStatus();
        });
        
        console.log('✅ Pusher inicializado correctamente');
        
    } catch (error) {
        console.error('❌ Error inicializando Pusher:', error);
    }
}

// Mostrar notificación de cambio de estado
function showStatusChangeNotification(data) {
    // Crear toast
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-success-300 text-white px-6 py-4 rounded-lg shadow-lg z-[9999] max-w-md animate-slide-in';
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-2xl">🔔</span>
            <div class="flex-1">
                <strong class="block mb-1">¡Estado actualizado!</strong>
                <span class="text-sm">${data.message}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-accent-100">
                ✕
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Reproducir sonido de notificación
function playNotificationSound() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.value = 800;
        gainNode.gain.value = 0.1;

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.1);
    } catch (e) {
        console.log('No se pudo reproducir sonido:', e);
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/checkout/success.blade.php ENDPATH**/ ?>