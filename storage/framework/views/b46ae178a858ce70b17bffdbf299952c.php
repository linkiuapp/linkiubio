
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
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
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
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
    $id = $id ?? 'icon-input-' . uniqid();
    $baseClasses = 'py-3 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
    $errorClasses = $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
    $paddingClasses = $iconPosition === 'left' ? 'ps-11 pe-4' : 'ps-4 pe-11';
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
    
    <div class="relative">
        <input 
            type="<?php echo e($type); ?>"
            id="<?php echo e($id); ?>"
            name="<?php echo e($name); ?>"
            placeholder="<?php echo e($placeholder); ?>"
            value="<?php echo e($value); ?>"
            <?php echo e($disabled ? 'disabled' : ''); ?>

            <?php echo e($required ? 'required' : ''); ?>

            class="<?php echo e($baseClasses); ?> <?php echo e($errorClasses); ?> <?php echo e($paddingClasses); ?> border-gray-300"
            <?php echo e($attributes); ?>

        >
        
        <?php if($icon): ?>
            <div class="absolute inset-y-0 <?php echo e($iconPosition === 'left' ? 'start-0 flex items-center pointer-events-none z-20 ps-4' : 'end-0 flex items-center pointer-events-none z-20 pe-4'); ?>">
                <i data-lucide="<?php echo e($icon); ?>" class="flex-shrink-0 size-4 text-gray-400"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if($error): ?>
        <p class="text-sm text-red-600 mt-2"><?php echo e($error); ?></p>
    <?php endif; ?>
</div>






<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Inputs/InputWithIcon.blade.php ENDPATH**/ ?>