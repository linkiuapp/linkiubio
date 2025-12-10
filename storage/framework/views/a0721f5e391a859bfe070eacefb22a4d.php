

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info', // dark, secondary, info, success, danger, warning, light
    'title' => '',
    'message' => '',
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
    'type' => 'info', // dark, secondary, info, success, danger, warning, light
    'title' => '',
    'message' => '',
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
        'dark' => 'bg-gray-100 border border-gray-200 text-gray-800',
        'secondary' => 'bg-gray-50 border border-gray-200 text-gray-600',
        'info' => 'bg-blue-100 border border-blue-200 text-blue-800',
        'success' => 'bg-teal-100 border border-teal-200 text-teal-800',
        'danger' => 'bg-red-100 border border-red-200 text-red-800',
        'warning' => 'bg-yellow-100 border border-yellow-200 text-yellow-800',
        'light' => 'bg-white/10 border border-white/10 text-white',
    ];
    
    $idLabels = [
        'dark' => 'hs-soft-color-dark-label',
        'secondary' => 'hs-soft-color-secondary-label',
        'info' => 'hs-soft-color-info-label',
        'success' => 'hs-soft-color-success-label',
        'danger' => 'hs-soft-color-danger-label',
        'warning' => 'hs-soft-color-warning-label',
        'light' => 'hs-soft-color-light-label',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
    $labelId = $idLabels[$type] ?? $idLabels['info'];
?>

<div class="mt-2 <?php echo e($classes); ?> text-sm rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="<?php echo e($labelId); ?>" <?php echo e($attributes); ?>>
    <?php if($title): ?>
        <span id="<?php echo e($labelId); ?>" class="font-bold"><?php echo e($title); ?></span>
    <?php endif; ?>
    <?php if($message): ?>
        <?php if($title): ?> <?php echo e($message); ?> <?php else: ?> <span id="<?php echo e($labelId); ?>"><?php echo e($message); ?></span> <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Alerts/AlertSoft.blade.php ENDPATH**/ ?>