

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => '',
    'value' => 0,
    'icon' => 'info',
    'color' => 'primary', // primary, success, warning, info, secondary, accent
    'description' => '',
    'badge' => '',
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
    'title' => '',
    'value' => 0,
    'icon' => 'info',
    'color' => 'primary', // primary, success, warning, info, secondary, accent
    'description' => '',
    'badge' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Color classes mapping - Mejor contraste con fondos blancos y bordes
    $colorClasses = [
        'primary' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-primary-300',
            'iconBg' => 'bg-primary-50',
            'iconColor' => 'text-primary-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'success' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-success-300',
            'iconBg' => 'bg-success-50',
            'iconColor' => 'text-success-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'warning' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-warning-300',
            'iconBg' => 'bg-warning-50',
            'iconColor' => 'text-warning-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'info' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-info-300',
            'iconBg' => 'bg-info-50',
            'iconColor' => 'text-info-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'secondary' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-secondary-300',
            'iconBg' => 'bg-secondary-50',
            'iconColor' => 'text-secondary-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'accent' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-accent-300',
            'iconBg' => 'bg-accent-50',
            'iconColor' => 'text-accent-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
    ];
    
    $colors = $colorClasses[$color] ?? $colorClasses['primary'];
?>

<div class="<?php echo e($colors['bg']); ?> <?php echo e($colors['border']); ?> rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow" <?php echo e($attributes); ?>>
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-lg <?php echo e($colors['iconBg']); ?> flex items-center justify-center flex-shrink-0">
                <i data-lucide="<?php echo e($icon); ?>" class="w-6 h-6 <?php echo e($colors['iconColor']); ?>"></i>
            </div>
            <div>
                <h2 class="text-sm font-medium <?php echo e($colors['titleColor']); ?> mb-0"><?php echo e($title); ?></h2>
                <?php if($description): ?>
                    <p class="text-xs text-gray-500 mt-1 mb-0"><?php echo e($description); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if(isset($badge)): ?>
            <span class="ml-auto">
                <?php echo e($badge); ?>

            </span>
        <?php elseif($badge !== ''): ?>
            <span class="ml-auto">
                <?php echo $badge; ?>

            </span>
        <?php endif; ?>
    </div>
    <?php if($slot->isNotEmpty()): ?>
        <div class="text-3xl font-bold <?php echo e($colors['valueColor']); ?> mb-0">
            <?php echo e($slot); ?>

        </div>
    <?php else: ?>
        <h3 class="text-3xl font-bold <?php echo e($colors['valueColor']); ?> mb-0">
            <?php if(is_numeric($value)): ?>
                <?php echo e(number_format($value)); ?>

            <?php else: ?>
                <?php echo e($value); ?>

            <?php endif; ?>
        </h3>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Dashboard/StatCard.blade.php ENDPATH**/ ?>