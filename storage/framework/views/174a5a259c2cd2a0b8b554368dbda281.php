

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => '',
    'description' => '',
    'checkboxId' => null,
    'checkboxName' => null,
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
    'title' => '',
    'description' => '',
    'checkboxId' => null,
    'checkboxName' => null,
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
    $uniqueId = $checkboxId ?? 'checkbox-' . uniqid();
    $nameAttr = $checkboxName ?? $uniqueId;
    $descriptionId = $uniqueId . '-description';
?>

<div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
        <input 
            id="<?php echo e($uniqueId); ?>"
            name="<?php echo e($nameAttr); ?>"
            type="checkbox"
            <?php if($checked): ?> checked <?php endif; ?>
            <?php if($disabled): ?> disabled <?php endif; ?>
            aria-describedby="<?php echo e($descriptionId); ?>"
            class="border-gray-400 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            <?php echo e($attributes); ?>

        >
    </div>
    <label for="<?php echo e($uniqueId); ?>" class="ms-3">
        <span class="block text-sm font-semibold text-gray-800"><?php echo e($title); ?></span>
        <span id="<?php echo e($descriptionId); ?>" class="block text-sm text-gray-600"><?php echo e($description); ?></span>
    </label>
</div>















<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Checkboxes/CheckboxWithDescription.blade.php ENDPATH**/ ?>