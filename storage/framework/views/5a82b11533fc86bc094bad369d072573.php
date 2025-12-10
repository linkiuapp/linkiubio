<?php $__env->startSection('content'); ?>
<div class="p-4 space-y-6">

    <!-- Header -->
    <div class="space-y-3">
        
        <!-- Breadcrumbs -->
        <nav class="flex caption text-brandInfo-300">
            <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-brandNeutral-400 caption">Promociones</span>
        </nav>
        
        <!-- Title -->
        <div class="space-y-2">
            <h3 class="h3 text-brandNeutral-400">Nuestras Promociones</h3>
        </div>

        <!-- Información adicional -->
        <div class="bg-brandInfo-50 rounded-lg p-4">
            <h3 class="body-lg-bold text-brandInfo-400 mb-2">¿Cómo usar nuestros cupones?</h3>
            <div class="space-y-2 caption text-brandInfo-400">
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">1.</span>
                    <span>Copia el código de descuento tocando el botón "Copiar"</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">2.</span>
                    <span>Agrega productos a tu carrito de compras</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">3.</span>
                    <span>En el checkout, pega el código en el campo "Cupón de descuento"</span>
                </div>
                <div class="flex items-start gap-2">
                    <span class="caption-strong text-brandInfo-400">4.</span>
                    <span>¡Disfruta tu descuento! 🎉</span>
                </div>
            </div>
        </div>
    </div>

    <?php if($coupons->count() > 0): ?>
    
        <!-- Lista de promociones -->
        <div class="space-y-4">
            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-brandWhite-100 rounded-lg overflow-hidden shadow-sm" x-data="{ copied: false }">
                    
                    <!-- Header del cupón con descuento destacado -->
                    <div class="bg-gradient-to-r from-brandSecondary-300 to-brandPrimary-300 p-4 text-accent-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <!-- Descuento principal -->
                                <div class="h1 mb-1">
                                    <?php if($coupon->discount_type === 'percentage'): ?>
                                        <?php echo e($coupon->formatted_discount); ?> OFF
                                    <?php else: ?>
                                        <?php echo e($coupon->formatted_discount); ?> OFF
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Nombre del cupón -->
                                <div class="caption"><?php echo e($coupon->name); ?></div>
                            </div>
                            <!-- Badge de estado -->
                            <div class="text-right">
                                <span class="inline-flex items-center rounded-full bg-brandsuccess-50 border border-brandSuccess-400 px-2 py-1 caption-strong text-brandSuccess-400 <?php echo e($coupon->status_info['bg']); ?> <?php echo e($coupon->status_info['color']); ?> border <?php echo e($coupon->status_info['border']); ?>">
                                    <?php echo e($coupon->status_info['text']); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido del cupón -->
                    <div class="p-4 space-y-4">
                        
                        <!-- Código del cupón -->
                        <div>
                            <div class="body-lg-bold text-brandNeutral-400 mb-2">Código de descuento</div>
                            <div class="bg-brandWhite-50 border-2 border-dashed border-dashed-rounded border-brandPrimary-400 rounded-full p-3 flex items-center justify-between">
                                <span class="font-mono h2 text-brandPrimary-300"><?php echo e($coupon->code); ?></span>
                                <button 
                                    @click="
                                        navigator.clipboard.writeText('<?php echo e($coupon->code); ?>');
                                        copied = true;
                                        setTimeout(() => copied = false, 2000);
                                        showCopiedNotification('<?php echo e($coupon->code); ?>');
                                    " 
                                    class="body-lg-regular bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 px-3 py-1 rounded-full transition-colors flex items-center gap-2"
                                    type="button"
                                >
                                    <div class="flex items-center gap-2" x-show="!copied">
                                        <i data-lucide="copy" class="w-16px h-16px"></i>
                                        <span>Copiar</span>
                                    </div>
                                    <div class="flex items-center gap-2" x-show="copied" style="display: none;">
                                        <i data-lucide="circle-check" class="w-16px h-16px"></i>
                                        <span>¡Copiado!</span>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <?php if($coupon->description): ?>
                            <div class="body-lg-regular text-brandNeutral-400 text-center">
                                <?php echo e($coupon->description); ?>

                            </div>
                        <?php endif; ?>

                        <!-- Aplicabilidad -->
                        <?php if($coupon->type !== 'global'): ?>
                            <div class="bg-brandInfo-50 border border-brandInfo-100 rounded-lg p-3">
                                <div class="flex items-center gap-2 text-brandInfo-300">
                                    <i data-lucide="info" class="w-16px h-16px"></i>
                                    <span class="body-lg-regular">
                                        <?php if($coupon->type === 'categories'): ?>
                                            Válido para categorías específicas
                                        <?php else: ?>
                                            Válido para productos específicos
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Condiciones y validez -->
                        <div class="space-y-2">
                            <?php if($coupon->conditions_text): ?>
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="file-text" class="w-8px h-8px"></i>
                                    <span class="caption"><?php echo e($coupon->conditions_text); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if($coupon->expiry_text): ?>
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="calendar" class="w-8px h-8px"></i>
                                    <span class="caption"><?php echo e($coupon->expiry_text); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Días y horarios específicos -->
                            <?php if($coupon->days_of_week || $coupon->start_time || $coupon->end_time): ?>
                                <div class="flex items-center gap-2 text-brandNeutral-400">
                                    <i data-lucide="clock" class="w-8px h-8px"></i>
                                    <span class="caption">
                                        <?php if($coupon->days_of_week): ?>
                                            <?php
                                                $dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                                                $selectedDays = collect($coupon->days_of_week)->map(fn($day) => $dayNames[$day] ?? $day);
                                            ?>
                                            <?php echo e($selectedDays->join(', ')); ?>

                                        <?php endif; ?>
                                        <?php if($coupon->start_time || $coupon->end_time): ?>
                                            <?php echo e($coupon->start_time ? $coupon->start_time->format('H:i') : '00:00'); ?> - 
                                            <?php echo e($coupon->end_time ? $coupon->end_time->format('H:i') : '23:59'); ?>

                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Call to action -->
                        <div class="pt-2">
                            <div class="bg-brandSuccess-50 border border-brandSuccess-100 rounded-lg p-3 text-center flex items-center justify-center gap-2">
                                <i data-lucide="star" class="w-5 h-5 text-brandSuccess-400"></i>
                                <span class="caption-strong text-brandSuccess-400">Copia el código y úsalo en tu próxima compra</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    <?php else: ?>

        <!-- Estado vacío -->
        <div class="flex flex-col items-center justify-center py-8">
            <div class="flex flex-col items-center justify-center">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_coupon.svg" alt="img_linkiu_v1_coupon" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400 mt-4">No hay promociones activas</p>
                <a href="<?php echo e(route('tenant.home', $store->slug)); ?>" 
                   class="rounded-full gap-2 inline-flex mt-2 px-4 py-2 bg-brandPrimary-300 text-brandWhite-100 rounded-full body-lg-medium hover:bg-brandPrimary-400 transition-colors">
                Continuar comprando
                <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Función para mostrar notificación de cupón copiado usando el sistema unificado
    window.showCopiedNotification = function(couponCode) {
        if (window.toast) {
            window.toast.success(
                '¡Ufff! Cupón copiado exitosamente',
                `Código: ${couponCode}`,
                5000
            );
        }
    };

    // Auto-scroll to copied coupon for better UX
    document.addEventListener('alpine:init', () => {
        Alpine.data('couponCard', () => ({
            copied: false,
            
            async copyCoupon(code) {
                try {
                    await navigator.clipboard.writeText(code);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                    // Mostrar notificación
                    showCopiedNotification(code);
                } catch (err) {
                    console.error('Error al copiar:', err);
                    // Fallback para dispositivos que no soportan clipboard API
                    this.fallbackCopy(code);
                }
            },
            
            fallbackCopy(text) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
                // Mostrar notificación
                showCopiedNotification(text);
            }
        }));
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Tenant/Views/storefront/promotions.blade.php ENDPATH**/ ?>