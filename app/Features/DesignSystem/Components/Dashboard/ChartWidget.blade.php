{{--
ChartWidget - Widget de gráficos con Chart.js
Uso: Mostrar gráficos de datos usando Chart.js
Cuándo usar: Dashboards donde se necesitan visualizaciones de datos
Cuándo NO usar: Cuando no se necesita visualización gráfica
Ejemplo: <x-chart-widget type="line" title="Crecimiento Mensual" :data="$chartData" />
--}}

@props([
    'type' => 'line', // line, bar, doughnut, pie
    'title' => '',
    'data' => [],
    'options' => [],
    'height' => '300',
    'chartId' => null,
])

@php
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
@endphp

<div class="bg-white rounded-lg shadow-sm p-5">
    @if($title)
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $title }}</h3>
    @endif
    <div class="relative" style="height: {{ $height }}px;">
        <canvas id="{{ $uniqueId }}"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('{{ $uniqueId }}');
    if (!ctx) {
        console.error('No se encontró el elemento canvas con id: {{ $uniqueId }}');
        return;
    }
    
    const chartData = @json($data);
    const chartOptions = @json($mergedOptions);
    
    // Validar que hay datos
    if (!chartData || !chartData.labels || chartData.labels.length === 0) {
        console.warn('No hay datos para el gráfico {{ $uniqueId }}');
        return;
    }
    
    // Configurar callback para tooltip en gráficos doughnut/pie
    if ('{{ $type }}' === 'doughnut' || '{{ $type }}' === 'pie') {
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
            type: '{{ $type }}',
            data: chartData,
            options: chartOptions
        });
    } catch (error) {
        console.error('Error al crear el gráfico {{ $uniqueId }}:', error);
    }
});
</script>
@endpush

