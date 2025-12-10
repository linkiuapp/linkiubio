

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'enabled' => env('MAINTENANCE_NOTICE_ENABLED', false),
    'message' => null,
    'variant' => null,
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
    'enabled' => env('MAINTENANCE_NOTICE_ENABLED', false),
    'message' => null,
    'variant' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $defaultMessage = 'Estamos realizando mantenimiento en la plataforma, por lo que podrían presentarse intermitencias durante el proceso. Agradecemos tu comprensión.';
    $displayMessage = $message ?? $defaultMessage;
    
    // Detectar variant automáticamente si no se especifica
    if (!$variant) {
        $variant = request()->routeIs('tenant.*') && !request()->routeIs('tenant.admin.*') 
            ? 'tenant' 
            : 'admin';
    }
    
    // Configuración según variant
    $isTenant = $variant === 'tenant';
?>

<?php if($enabled): ?>
<?php if($isTenant): ?>

<div 
    x-data="{
        show: false,
        dismissed: false,
        init() {
            const dismissed = localStorage.getItem('maintenance_notice_dismissed');
            if (!dismissed) {
                this.show = true;
            }
        },
        dismiss() {
            this.show = false;
            this.dismissed = true;
            localStorage.setItem('maintenance_notice_dismissed', 'true');
            setTimeout(() => {
                localStorage.removeItem('maintenance_notice_dismissed');
            }, 24 * 60 * 60 * 1000);
        }
    }"
    x-show="show && !dismissed"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-[-100%]"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-[-100%]"
    class="fixed top-0 left-1/2 transform -translate-x-1/2 w-[480px] max-w-full z-[9999] bg-slate-900 shadow-xl"
    style="display: none;"
    role="alert"
    aria-live="polite"
>
    <div class="p-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="shrink-0">
                    <img src="<?php echo e(asset('images-ui/emoji_toast_Linkiu_warning.svg')); ?>" alt="Emoji Linkiu Warning" class="w-16 h-16 object-cover">
                </div>
                <p class="text-sm font-regular text-white flex-1">
                    <?php echo e($displayMessage); ?>

                </p>
            </div>
            <button 
                @click="dismiss()"
                type="button"
                class="shrink-0 flex items-center justify-center size-8 rounded-lg text-white hover:bg-warning-300 hover:text-warning-900 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-warning-400 focus:ring-offset-2 focus:ring-offset-warning-200"
                aria-label="Cerrar notificación"
            >
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
</div>
<?php else: ?>

<div 
    x-data="{
        show: false,
        dismissed: false,
        init() {
            const dismissed = localStorage.getItem('maintenance_notice_dismissed');
            if (!dismissed) {
                // Mostrar después de un pequeño delay para mejor UX
                setTimeout(() => {
                    this.show = true;
                }, 500);
            }
        },
        dismiss() {
            this.show = false;
            this.dismissed = true;
            localStorage.setItem('maintenance_notice_dismissed', 'true');
            setTimeout(() => {
                localStorage.removeItem('maintenance_notice_dismissed');
            }, 24 * 60 * 60 * 1000);
        }
    }"
    x-show="show && !dismissed"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-full"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-full"
    class="fixed bottom-4 left-1/2 transform -translate-x-1/2 max-w-xl w-full mx-4 z-[9999] bg-slate-900 rounded-xl shadow-xl"
    style="display: none;"
    role="alert"
    aria-live="polite"
>
    <div class="p-4">
        <div class="flex items-center gap-3">
            <div class="shrink-0 mt-0.5">
                <img src="<?php echo e(asset('images-ui/emoji_toast_Linkiu_warning.svg')); ?>" alt="Emoji Linkiu Warning" class="w-16 h-16 object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white">
                    <?php echo e($displayMessage); ?>

                </p>
            </div>
            <button 
                @click="dismiss()"
                type="button"
                class="shrink-0 flex items-center justify-center size-8 rounded-lg text-white hover:bg-warning-100 hover:text-warning-900 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-warning-400 focus:ring-offset-2"
                aria-label="Cerrar notificación"
            >
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Inicializar iconos de Lucide para este componente
    (function() {
        'use strict';
        
        function initLucideIcons() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
                if (typeof lucide.icons !== 'undefined') {
                    lucide.createIcons({ icons: lucide.icons });
                }
            }
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initLucideIcons);
        } else {
            initLucideIcons();
        }
        
        document.addEventListener('alpine:initialized', initLucideIcons);
    })();
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php /**PATH C:\laragon\www\Liniu_Final\resources\views/components/maintenance-notice.blade.php ENDPATH**/ ?>