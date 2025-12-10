

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'size' => 'md', // sm, md, lg
    'title' => '',
    'content' => '',
    'footer' => '',
    'link' => '',
    'linkText' => 'Card link',
    'shadow' => 'sm', // none, sm, md, lg
    'hover' => false, // Efectos de hover
    'rounded' => 'xl', // lg, xl, 2xl
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
    'size' => 'md', // sm, md, lg
    'title' => '',
    'content' => '',
    'footer' => '',
    'link' => '',
    'linkText' => 'Card link',
    'shadow' => 'sm', // none, sm, md, lg
    'hover' => false, // Efectos de hover
    'rounded' => 'xl', // lg, xl, 2xl
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Size classes (padding variations)
    $sizeClasses = [
        'sm' => 'p-4 md:p-5',
        'md' => 'p-4 md:p-7',
        'lg' => 'p-4 md:p-10',
    ];
    
    // Shadow classes
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
    ];
    
    // Get classes
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $shadowClass = $shadowClasses[$shadow] ?? $shadowClasses['sm'];
    $roundedClass = 'rounded-' . $rounded;
    
    // Hover classes
    $hoverClass = $hover ? 'hover:shadow-lg focus:shadow-lg transition' : '';
    
    // Container classes
    $containerClasses = "flex flex-col bg-white border border-gray-200 {$shadowClass} {$roundedClass} {$hoverClass}";
    
    // Link wrapper
    $isLink = !empty($link);
?>

<?php if($isLink): ?>
    <a href="<?php echo e($link); ?>" class="<?php echo e($containerClasses); ?>" <?php echo e($attributes); ?>>
        <div class="<?php echo e($sizeClass); ?>">
            <?php if($title): ?>
                <h4 class="h4 text-gray-800">
                    <?php echo e($title); ?>

                </h4>
            <?php endif; ?>
            
            <?php if($content): ?>
                <p class="mt-1 body-small text-gray-500">
                    <?php echo e($content); ?>

                </p>
            <?php endif; ?>
            
            <?php echo e($slot); ?>

            
            <?php if($footer): ?>
                <p class="mt-5 caption text-gray-500">
                    <?php echo e($footer); ?>

                </p>
            <?php endif; ?>
        </div>
    </a>
<?php else: ?>
    <div class="<?php echo e($containerClasses); ?>" <?php echo e($attributes); ?>>
        <div class="<?php echo e($sizeClass); ?>">
            <?php if($title): ?>
                <h4 class="h4 text-gray-800">
                    <?php echo e($title); ?>

                </h4>
            <?php endif; ?>
            
            <?php if($content): ?>
                <p class="mt-2 body-small text-gray-500">
                    <?php echo e($content); ?>

                </p>
            <?php endif; ?>
            
            <?php echo e($slot); ?>

            
            <?php if($link && $linkText): ?>
                <a class="mt-3 inline-flex items-center gap-x-1 body-small font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-700 hover:underline focus:underline focus:outline-none focus:text-blue-700" 
                   href="<?php echo e($link); ?>">
                    <?php echo e($linkText); ?>

                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            <?php endif; ?>
            
            <?php if($footer): ?>
                <p class="mt-5 caption text-gray-500">
                    <?php echo e($footer); ?>

                </p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Cards/CardBase.blade.php ENDPATH**/ ?>