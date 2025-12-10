

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'text' => 'Tooltip superior',
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
    'text' => 'Tooltip superior',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $uniqueId = 'tooltip-' . uniqid();
?>

<div class="relative inline-block" x-data="{ open: false }">
    <div @mouseenter="open = true" @mouseleave="open = false">
        <?php echo e($slot); ?>

    </div>
    
    <div 
        x-show="open"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs whitespace-nowrap bottom-full left-1/2 -translate-x-1/2 mb-2"
        role="tooltip"
        style="display: none;"
    >
        <?php echo e($text); ?>

    </div>
</div>















<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Tooltips/TooltipTop.blade.php ENDPATH**/ ?>