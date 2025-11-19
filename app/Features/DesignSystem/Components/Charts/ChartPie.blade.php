{{--
Chart Pie - Gráfico de pastel
Uso: Gráfico de pastel para mostrar proporciones
Cuándo usar: Cuando necesites mostrar la distribución porcentual de datos
Cuándo NO usar: Cuando necesites comparar valores absolutos (usa Bar Chart)
Ejemplo: <x-chart-pie chartId="my-chart" :legend="[['label' => 'Directo', 'color' => 'blue-600'], ['label' => 'Búsqueda', 'color' => 'cyan-500'], ['label' => 'Referido', 'color' => 'gray-300']]" />
Nota: Este componente requiere ApexCharts para funcionar. Ver documentación en el showcase.
--}}

@props([
    'chartId' => null,
    'legend' => [
        ['label' => 'Directo', 'color' => 'blue-600'],
        ['label' => 'Búsqueda Orgánica', 'color' => 'cyan-500'],
        ['label' => 'Referido', 'color' => 'gray-300'],
    ],
])

@php
    $uniqueId = $chartId ?? 'chart-pie-' . uniqid();
@endphp

<div class="p-4">
    <div class="h-75 flex flex-col justify-center items-center">
        <div id="{{ $uniqueId }}" class="w-full"></div>

        {{-- Legend Indicator --}}
        <div class="flex justify-center sm:justify-end items-center gap-x-4 mt-3 sm:mt-6">
            @foreach($legend as $item)
                @php
                    $colorClasses = [
                        'blue-600' => 'bg-blue-600',
                        'purple-600' => 'bg-purple-600',
                        'cyan-500' => 'bg-cyan-500',
                        'gray-300' => 'bg-gray-300',
                    ];
                    $bgColor = $colorClasses[$item['color']] ?? 'bg-blue-600';
                @endphp
                <div class="inline-flex items-center">
                    <span class="size-2.5 inline-block {{ $bgColor }} rounded-sm me-2"></span>
                    <span class="text-[13px] text-gray-600">
                        {{ $item['label'] }}
                    </span>
                </div>
            @endforeach
        </div>
        {{-- End Legend Indicator --}}
    </div>
</div>

@push('scripts')
<script>
window.addEventListener('load', () => {
    if (typeof buildChart === 'undefined') {
        console.error('buildChart no está disponible. Asegúrate de que apexcharts-helpers.js esté cargado.');
        return;
    }

    (function() {
        buildChart('#{{ $uniqueId }}', () => ({
            chart: {
                height: '100%',
                type: 'pie',
                zoom: {
                    enabled: false
                }
            },
            series: [70, 18, 12],
            labels: ['Directo', 'Búsqueda Orgánica', 'Referido'],
            title: {
                show: false
            },
            dataLabels: {
                style: {
                    fontSize: '20px',
                    fontFamily: 'Inter, ui-sans-serif',
                    fontWeight: '400',
                    colors: ['#fff', '#fff', '#1f2937']
                },
                dropShadow: {
                    enabled: false
                },
                formatter: (value) => `${value.toFixed(1)} %`
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: -15
                    }
                }
            },
            legend: {
                show: false
            },
            stroke: {
                width: 4
            },
            grid: {
                padding: {
                    top: -10,
                    bottom: -14,
                    left: -9,
                    right: -9
                }
            },
            tooltip: {
                enabled: false
            },
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        }), {
            colors: ['#3b82f6', '#22d3ee', '#e5e7eb'],
            stroke: {
                colors: ['rgb(255, 255, 255)']
            }
        }, {
            colors: ['#3b82f6', '#22d3ee', '#404040'],
            stroke: {
                colors: ['rgb(38, 38, 38)']
            }
        });
    })();
});
</script>
@endpush
