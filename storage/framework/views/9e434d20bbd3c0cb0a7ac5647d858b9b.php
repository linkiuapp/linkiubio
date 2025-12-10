

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
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
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
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
        'dark' => 'bg-gray-100 text-gray-800',
        'secondary' => 'bg-gray-50 text-gray-500',
        'success' => 'bg-teal-100 text-teal-800',
        'info' => 'bg-blue-100 text-blue-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'light' => 'bg-white text-gray-600',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
?>

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium <?php echo e($classes); ?>" <?php echo e($attributes); ?>>
    <?php echo e($text); ?>

</span>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Badges/BadgeSoft.blade.php ENDPATH**/ ?>