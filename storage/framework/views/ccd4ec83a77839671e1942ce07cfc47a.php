

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'count' => '', // Número o texto a mostrar
    'type' => 'notification', // notification, indicator, profile
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left
    'color' => 'red', // red, green, blue, yellow, gray
    'animated' => false, // Si incluye animación ping
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
    'count' => '', // Número o texto a mostrar
    'type' => 'notification', // notification, indicator, profile
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left
    'color' => 'red', // red, green, blue, yellow, gray
    'animated' => false, // Si incluye animación ping
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $positionClasses = [
        'top-right' => 'absolute top-0 end-0 -translate-y-1/2 translate-x-1/2',
        'top-left' => 'absolute top-0 start-0 -translate-y-1/2 -translate-x-1/2',
        'bottom-right' => 'absolute bottom-0 end-0 translate-y-1/2 translate-x-1/2',
        'bottom-left' => 'absolute bottom-0 start-0 translate-y-1/2 -translate-x-1/2'
    ];
    
    $colorClasses = [
        'red' => 'bg-red-500 text-white',
        'green' => 'bg-teal-500 text-white',
        'blue' => 'bg-blue-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 text-white'
    ];
    
    $positionClass = $positionClasses[$position] ?? $positionClasses['top-right'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['red'];
    
    if ($type === 'notification' && $count) {
        $badgeClasses = 'inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium transform ' . $positionClass . ' ' . $colorClass;
    } elseif ($type === 'profile') {
        $badgeClasses = 'inline-flex items-center w-3.5 h-3.5 rounded-full border-2 border-white transform ' . $positionClass . ' ' . $colorClass;
    } else {
        $badgeClasses = 'inline-flex items-center w-3 h-3 rounded-full border-2 border-white transform ' . $positionClass . ' ' . $colorClass;
    }
?>

<?php if($animated): ?>
    <span class="flex absolute <?php echo e($positionClass); ?>">
        <?php if($count && $type === 'notification'): ?>
            <span class="animate-ping absolute inline-flex size-full rounded-full <?php echo e(str_replace('bg-' . ($color === 'green' ? 'teal' : $color) . '-500', 'bg-' . ($color === 'green' ? 'teal' : $color) . '-400', str_replace('bg-green-500', 'bg-teal-500', $colorClass))); ?> opacity-75"></span>
            <span class="relative inline-flex text-xs <?php echo e(str_replace(' transform', '', $colorClass)); ?> rounded-full py-0.5 px-1.5">
                <?php echo e($count); ?>

            </span>
        <?php else: ?>
            <span class="animate-ping absolute inline-flex size-full rounded-full <?php echo e(str_replace('bg-' . ($color === 'green' ? 'teal' : $color) . '-500', 'bg-' . ($color === 'green' ? 'teal' : $color) . '-400', str_replace('bg-green-500', 'bg-teal-500', $colorClass))); ?> opacity-75"></span>
            <span class="relative inline-flex rounded-full size-3 <?php echo e(str_replace(' transform', '', $colorClass)); ?>"></span>
        <?php endif; ?>
    </span>
<?php else: ?>
    <span class="<?php echo e($badgeClasses); ?>" <?php echo e($attributes); ?>>
        <?php if($count && $type === 'notification'): ?>
            <?php echo e($count); ?>

        <?php elseif($type === 'profile'): ?>
            <span class="sr-only"><?php echo e($count ?: 'Badge value'); ?></span>
        <?php endif; ?>
    </span>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Badges/BadgePositioned.blade.php ENDPATH**/ ?>