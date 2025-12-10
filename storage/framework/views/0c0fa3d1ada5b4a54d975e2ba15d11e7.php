

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'tour',
    'autoStart' => false,
    'showButton' => true,
    'buttonClass' => '',
    'buttonText' => 'Ayuda',
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
    'tour',
    'autoStart' => false,
    'showButton' => true,
    'buttonClass' => '',
    'buttonText' => 'Ayuda',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $tourService = app(\App\Services\TourService::class);
    $store = view()->shared('currentStore');
    $shouldShow = $store ? $tourService->shouldShowTour($store, $tour) : false;
?>

<?php if($shouldShow): ?>
    <?php if($showButton): ?>
    <button 
        type="button"
        onclick="window.startTour && window.startTour('<?php echo e($tour); ?>', true)"
        class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors <?php echo e($buttonClass); ?>"
        title="Ver tutorial"
    >
        <i data-lucide="help-circle" class="w-4 h-4"></i>
        <span><?php echo e($buttonText); ?></span>
    </button>
    <?php endif; ?>
    
    <?php if($autoStart): ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si el tour ya fue completado
            if (localStorage.getItem('tour_<?php echo e($tour); ?>_completed') !== 'true') {
                // Esperar un momento para que la página cargue completamente
                setTimeout(function() {
                    if (window.startTour) {
                        window.startTour('<?php echo e($tour); ?>');
                    }
                }, 800);
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php /**PATH C:\laragon\www\Liniu_Final\resources\views/components/tour-trigger.blade.php ENDPATH**/ ?>