

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'success', // success, error, warning
    'title' => '',
    'message' => '',
    'iconName' => null,
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
    'type' => 'success', // success, error, warning
    'title' => '',
    'message' => '',
    'iconName' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $dynamicTitle = $attributes->get('x-title');
    $dynamicMessage = $attributes->get('x-message');
    $attributes = $attributes->except(['x-title', 'x-message']);

    $typeClasses = [
        'success' => [
            'container' => 'bg-teal-50 border-t-2 border-teal-500 rounded-lg',
            'iconBg' => 'border-4 border-teal-100 bg-teal-200 text-teal-800',
            'titleId' => 'hs-bordered-success-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-teal-700'
        ],
        'error' => [
            'container' => 'bg-red-50 border-s-4 border-red-500 p-4',
            'iconBg' => 'border-4 border-red-100 bg-red-200 text-red-800',
            'titleId' => 'hs-bordered-red-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-gray-700'
        ],
        'warning' => [
            'container' => 'bg-amber-50 border-t-2 border-amber-500 rounded-lg',
            'iconBg' => 'border-4 border-amber-100 bg-amber-200 text-amber-800',
            'titleId' => 'hs-bordered-warning-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-amber-700'
        ],
    ];
    
    $config = $typeClasses[$type] ?? $typeClasses['success'];
    $icon = $iconName ?: match($type) {
        'success' => 'check-circle',
        'error' => 'x',
        'warning' => 'alert-triangle',
        default => 'check-circle'
    };
?>

<div
    class="<?php echo e($config['container']); ?> p-4"
    role="alert"
    tabindex="-1"
    aria-labelledby="<?php echo e($config['titleId']); ?>"
    <?php echo e($attributes); ?>

    x-init="window.createIcons ? window.createIcons({ icons: window.lucideIcons }) : null"
>
    <div class="flex">
        <div class="shrink-0">
            <!-- Icon -->
            <span class="inline-flex justify-center items-center size-8 rounded-full <?php echo e($config['iconBg']); ?>">
                <i data-lucide="<?php echo e($icon); ?>" class="shrink-0 size-4"></i>
            </span>
            <!-- End Icon -->
        </div>
        <div class="ms-3">
            <?php if($title || $dynamicTitle): ?>
                <h3
                    id="<?php echo e($config['titleId']); ?>"
                    class="<?php echo e($config['title']); ?> font-semibold"
                    <?php if($dynamicTitle): ?> x-text="<?php echo e($dynamicTitle); ?>" <?php endif; ?>
                >
                    <?php if (! ($dynamicTitle)): ?>
                        <?php echo e($title); ?>

                    <?php endif; ?>
                </h3>
            <?php endif; ?>
            <?php if($message || $dynamicMessage): ?>
                <p
                    class="text-sm <?php echo e($config['message']); ?>"
                    <?php if($dynamicMessage): ?> x-text="<?php echo e($dynamicMessage); ?>" <?php endif; ?>
                >
                    <?php if (! ($dynamicMessage)): ?>
                        <?php echo e($message); ?>

                    <?php endif; ?>
                </p>
            <?php endif; ?>
            <?php if($slot->isNotEmpty()): ?>
                <div class="text-sm <?php echo e($config['message']); ?> mt-2">
                    <?php echo e($slot); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Alerts/AlertBordered.blade.php ENDPATH**/ ?>