

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => null,
    'selectId' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecciona una opción',
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
    'name' => null,
    'selectId' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Selecciona una opción',
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
    $uniqueId = $selectId ?? 'select-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
?>

<select 
    id="<?php echo e($uniqueId); ?>"
    name="<?php echo e($nameAttr); ?>"
    <?php if($disabled): ?> disabled <?php endif; ?>
    class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none <?php echo e($attributes->get('class')); ?>"
    <?php echo e($attributes->except('class')); ?>

>
    <?php if($placeholder): ?>
        <option value="" <?php if($selected === null || $selected === ''): ?> selected <?php endif; ?>><?php echo e($placeholder); ?></option>
    <?php endif; ?>
    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(is_array($label)): ?>
            <optgroup label="<?php echo e($value); ?>">
                <?php $__currentLoopData = $label; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optValue => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($optValue); ?>" <?php if($selected == $optValue): ?> selected <?php endif; ?>><?php echo e($optLabel); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
        <?php else: ?>
            <option value="<?php echo e($value); ?>" <?php if($selected == $value): ?> selected <?php endif; ?>>
                <?php echo e($label); ?>

            </option>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Selects/SelectBasic.blade.php ENDPATH**/ ?>