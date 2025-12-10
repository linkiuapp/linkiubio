

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
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
    'label' => '',
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
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
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
?>

<div class="<?php echo e($containerClass); ?>">
    <label for="<?php echo e($uniqueId); ?>" class="block text-sm font-medium mb-2"><?php echo e($label); ?></label>
    <textarea 
        id="<?php echo e($uniqueId); ?>"
        name="<?php echo e($nameAttr); ?>"
        rows="<?php echo e($rows); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        <?php echo e($attributes); ?>

    ><?php echo e(trim($slot) ?: ($attributes->get('value') ?? '')); ?></textarea>
</div>









<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Textareas/TextareaWithLabel.blade.php ENDPATH**/ ?>