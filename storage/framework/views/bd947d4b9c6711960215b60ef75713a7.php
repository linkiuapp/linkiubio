

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value' => 0, // Valor del progreso (0-100)
    'color' => 'blue', // blue, gray, dark, green, red, yellow, white
    'height' => 'h-1.5', // Altura: h-1.5, h-2, h-4
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
    'value' => 0, // Valor del progreso (0-100)
    'color' => 'blue', // blue, gray, dark, green, red, yellow, white
    'height' => 'h-1.5', // Altura: h-1.5, h-2, h-4
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $barColor = match($color) {
        'blue' => 'bg-blue-600',
        'gray' => 'bg-gray-500',
        'dark' => 'bg-gray-800',
        'green' => 'bg-teal-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'white' => 'bg-white',
        default => 'bg-blue-600',
    };
    
    $value = max(0, min(100, $value)); // Asegurar que esté entre 0 y 100
?>

<div class="flex w-full <?php echo e($height); ?> bg-gray-200 rounded-full overflow-hidden" 
     role="progressbar" 
     aria-valuenow="<?php echo e($value); ?>" 
     aria-valuemin="0" 
     aria-valuemax="100"
     <?php echo e($attributes); ?>>
    <div class="flex flex-col justify-center rounded-full overflow-hidden <?php echo e($barColor); ?> text-xs text-white text-center whitespace-nowrap transition duration-500" 
         style="width: <?php echo e($value); ?>%"></div>
</div>















<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Progress/ProgressBasic.blade.php ENDPATH**/ ?>