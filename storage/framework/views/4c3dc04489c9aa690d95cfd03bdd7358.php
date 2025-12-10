

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => 'Radio',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
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
    'label' => 'Radio',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $uniqueId = $radioId ?? 'radio-' . uniqid();
    $nameAttr = $radioName ?? 'radio-group-' . uniqid();
?>

<div class="flex <?php echo e($disabled ? 'opacity-40' : ''); ?>">
    <input 
        type="radio" 
        id="<?php echo e($uniqueId); ?>"
        name="<?php echo e($nameAttr); ?>"
        <?php if($checked): ?> checked <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        class="shrink-0 mt-0.5 border-gray-400 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        <?php echo e($attributes); ?>

    >
    <label for="<?php echo e($uniqueId); ?>" class="text-sm text-gray-500 ms-2"><?php echo e($label); ?></label>
</div>















<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Radios/RadioBasic.blade.php ENDPATH**/ ?>