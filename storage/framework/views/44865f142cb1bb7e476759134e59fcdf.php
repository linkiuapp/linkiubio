

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'containerClass' => 'max-w-sm',
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
    'label' => '',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'containerClass' => 'max-w-sm',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $inputId = $id ?: 'input-' . uniqid();
?>

<div class="<?php echo e($containerClass); ?>">
    <label for="<?php echo e($inputId); ?>" class="block text-sm font-medium mb-2"><?php echo e($label); ?></label>
    <input 
        type="<?php echo e($type); ?>" 
        id="<?php echo e($inputId); ?>" 
        <?php if($name): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        <?php if(!is_null($value) && $value !== ''): ?> value="<?php echo e($value); ?>" <?php endif; ?>
        <?php if($required): ?> required <?php endif; ?>
        <?php if($readonly): ?> readonly <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        placeholder="<?php echo e($placeholder); ?>"
        <?php echo e($attributes->merge([
                'class' => 'p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none'
            ])); ?>>
</div>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Inputs/InputWithLabel.blade.php ENDPATH**/ ?>