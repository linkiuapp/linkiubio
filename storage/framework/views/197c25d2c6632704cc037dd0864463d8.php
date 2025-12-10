

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'line', // line, bar, doughnut, pie
    'title' => '',
    'data' => [],
    'options' => [],
    'height' => '300',
    'chartId' => null,
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
    'type' => 'line', // line, bar, doughnut, pie
    'title' => '',
    'data' => [],
    'options' => [],
    'height' => '300',
    'chartId' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $uniqueId = $chartId ?? 'chart-' . uniqid();
    
    // Opciones por defecto según el tipo de gráfico
    if ($type === 'line') {
        $defaultOptions = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'padding' => 12,
                    'cornerRadius' => 8,
                    'displayColors' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => '#E8F2FC',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => '#6D6D71',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => '#6D6D71',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ];
    } elseif ($type === 'doughnut' || $type === 'pie') {
        $defaultOptions = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 20,
                        'color' => '#2E2E34',
                        'font' => [
                            'size' => 14,
                        ],
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'padding' => 12,
                    'cornerRadius' => 8,
                    'displayColors' => false,
                ],
            ],
        ];
    } else {
        $defaultOptions = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'padding' => 12,
                    'cornerRadius' => 8,
                ],
            ],
        ];
    }
    
    // Merge con opciones personalizadas si se proporcionan
    if (!empty($options)) {
        $mergedOptions = array_replace_recursive($defaultOptions, $options);
    } else {
        $mergedOptions = $defaultOptions;
    }
?>

<div class="bg-white rounded-lg shadow-sm p-5">
    <?php if($title): ?>
        <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e($title); ?></h3>
    <?php endif; ?>
    <div class="relative" style="height: <?php echo e($height); ?>px;">
        <canvas id="<?php echo e($uniqueId); ?>"></canvas>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('<?php echo e($uniqueId); ?>');
    if (!ctx) {
        console.error('No se encontró el elemento canvas con id: <?php echo e($uniqueId); ?>');
        return;
    }
    
    const chartData = <?php echo json_encode($data, 15, 512) ?>;
    const chartOptions = <?php echo json_encode($mergedOptions, 15, 512) ?>;
    
    // Validar que hay datos
    if (!chartData || !chartData.labels || chartData.labels.length === 0) {
        console.warn('No hay datos para el gráfico <?php echo e($uniqueId); ?>');
        return;
    }
    
    // Configurar callback para tooltip en gráficos doughnut/pie
    if ('<?php echo e($type); ?>' === 'doughnut' || '<?php echo e($type); ?>' === 'pie') {
        if (!chartOptions.plugins) chartOptions.plugins = {};
        if (!chartOptions.plugins.tooltip) chartOptions.plugins.tooltip = {};
        if (!chartOptions.plugins.tooltip.callbacks) chartOptions.plugins.tooltip.callbacks = {};
        
        chartOptions.plugins.tooltip.callbacks.label = function(context) {
            const total = context.dataset.data.reduce((a, b) => a + b, 0);
            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
        };
    }
    
    try {
        new Chart(ctx.getContext('2d'), {
            type: '<?php echo e($type); ?>',
            data: chartData,
            options: chartOptions
        });
    } catch (error) {
        console.error('Error al crear el gráfico <?php echo e($uniqueId); ?>:', error);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Dashboard/ChartWidget.blade.php ENDPATH**/ ?>