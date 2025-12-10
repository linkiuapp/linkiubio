

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'success', // success, error, warning, info, dark, secondary
    'icon' => 'check-circle',
    'text' => '',
    'iconOnly' => false, // true para mostrar solo el icono
    'loading' => false, // true para animación spin en el icono
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
    'type' => 'success', // success, error, warning, info, dark, secondary
    'icon' => 'check-circle',
    'text' => '',
    'iconOnly' => false, // true para mostrar solo el icono
    'loading' => false, // true para animación spin en el icono
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $typeClasses = [
        'success' => 'bg-teal-100 text-teal-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
        'dark' => 'bg-gray-100 text-gray-800',
        'secondary' => 'bg-gray-50 text-gray-500',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['success'];
    $padding = $iconOnly ? 'py-1 px-1.5' : 'py-1 px-2';
    $iconClass = 'shrink-0 size-3';
    if ($loading || $icon === 'loader' || $icon === 'loading') {
        $iconClass .= ' animate-spin';
    }
?>

<span class="<?php echo e($padding); ?> inline-flex items-center gap-x-1 text-xs font-medium <?php echo e($classes); ?> rounded-full" <?php echo e($attributes); ?>>
    <?php if($icon): ?>
        <i data-lucide="<?php echo e($icon); ?>" class="<?php echo e($iconClass); ?>"></i>
    <?php endif; ?>
    <?php if(!$iconOnly && $text): ?>
        <?php echo e($text); ?>

    <?php endif; ?>
</span>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Badges/BadgeIcon.blade.php ENDPATH**/ ?>