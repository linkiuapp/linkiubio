
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'disabled' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
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
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'disabled' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $id = $id ?? 'input-' . uniqid();
    $baseClasses = 'py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
    $errorClasses = $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
?>

<div class="space-y-2">
    <?php if($label): ?>
        <label for="<?php echo e($id); ?>" class="inline-block text-sm font-medium text-gray-800">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-red-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    
    <input 
        type="<?php echo e($type); ?>"
        id="<?php echo e($id); ?>"
        name="<?php echo e($name); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        value="<?php echo e($value); ?>"
        <?php echo e($disabled ? 'disabled' : ''); ?>

        <?php echo e($required ? 'required' : ''); ?>

        class="<?php echo e($baseClasses); ?> <?php echo e($errorClasses); ?>"
        <?php echo e($attributes); ?>

    >
    
    <?php if($error): ?>
        <p class="text-sm text-red-600 mt-2"><?php echo e($error); ?></p>
    <?php elseif($help): ?>
        <p class="text-sm text-gray-500 mt-2"><?php echo e($help); ?></p>
    <?php endif; ?>
</div>






<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Inputs/TextInput.blade.php ENDPATH**/ ?>