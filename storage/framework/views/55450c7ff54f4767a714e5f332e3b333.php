

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'svg' => 'empty-state.svg', // Nombre del archivo SVG en images-ui (ubicado en app/Features/DesignSystem/images-ui/)
    'title' => 'No hay elementos',
    'message' => 'Comienza agregando tu primer elemento',
    'action' => null, // Slot para botón de acción
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
    'svg' => 'empty-state.svg', // Nombre del archivo SVG en images-ui (ubicado en app/Features/DesignSystem/images-ui/)
    'title' => 'No hay elementos',
    'message' => 'Comienza agregando tu primer elemento',
    'action' => null, // Slot para botón de acción
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Los SVG están en app/Features/DesignSystem/images-ui/
    // Se acceden a través de la ruta /images-ui/{filename} definida en routes/web.php
    $svgPath = asset('images-ui/' . $svg);
?>

<div class="flex flex-col items-center justify-center py-8 px-6">
    
    <div class="mb-4">
        <img 
            src="<?php echo e($svgPath); ?>" 
            alt="<?php echo e($title); ?>"
            class="w-48 h-48 object-contain"
            loading="lazy"
        >
    </div>
    

    
    <h3 class="text-lg font-semibold text-gray-800 mb-2">
        <?php echo e($title); ?>

    </h3>
    

    
    <p class="text-sm text-gray-500 mb-6 text-center max-w-md">
        <?php echo e($message); ?>

    </p>
    

    
    <?php if(isset($action)): ?>
        <div>
            <?php echo e($action); ?>

        </div>
    <?php endif; ?>
    
</div>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/EmptyStates/EmptyState.blade.php ENDPATH**/ ?>