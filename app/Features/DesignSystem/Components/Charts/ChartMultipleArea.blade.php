{{--
Chart Multiple Area - Gráfico de área múltiple
Uso: Gráfico de área con múltiples series de datos
Cuándo usar: Cuando necesites comparar múltiples tendencias de datos
Cuándo NO usar: Cuando solo necesites una serie (usa Single Area)
Ejemplo: <x-chart-multiple-area chartId="my-chart" :legend="[['label' => 'Ingresos', 'color' => 'blue-600'], ['label' => 'Gastos', 'color' => 'purple-600']]" />
Nota: Este componente requiere ApexCharts para funcionar. Ver documentación en el showcase.
--}}

@props([
    'chartId' => null,
    'legend' => [
        ['label' => 'Ingresos', 'color' => 'blue-600'],
        ['label' => 'Gastos', 'color' => 'purple-600'],
    ],
])

@php
    $uniqueId = $chartId ?? 'chart-multiple-area-' . uniqid();
@endphp

{{-- Legend Indicator --}}
<div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
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
<!-- End Legend Indicator -->

<div id="{{ $uniqueId }}" class="min-h-[300px]"></div>

@push('scripts')
<script>
window.addEventListener('load', () => {
    if (typeof buildChart === 'undefined') {
        console.error('buildChart no está disponible. Asegúrate de que apexcharts-helpers.js esté cargado.');
        return;
    }

    (function() {
        buildChart('#{{ $uniqueId }}', (mode) => ({
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [
                {
                    name: 'Ingresos',
                    data: [18000, 51000, 60000, 38000, 88000, 50000, 40000, 52000, 88000, 80000, 60000, 70000]
                },
                {
                    name: 'Gastos',
                    data: [27000, 38000, 60000, 77000, 40000, 50000, 49000, 29000, 42000, 27000, 42000, 50000]
                }
            ],
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight',
                width: 2
            },
            grid: {
                strokeDashArray: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: 'vertical',
                    shadeIntensity: 1,
                    opacityFrom: 0.1,
                    opacityTo: 0.8
                }
            },
            xaxis: {
                type: 'category',
                tickPlacement: 'on',
                categories: [
                    '25 Enero 2023',
                    '26 Enero 2023',
                    '27 Enero 2023',
                    '28 Enero 2023',
                    '29 Enero 2023',
                    '30 Enero 2023',
                    '31 Enero 2023',
                    '1 Febrero 2023',
                    '2 Febrero 2023',
                    '3 Febrero 2023',
                    '4 Febrero 2023',
                    '5 Febrero 2023'
                ],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    stroke: {
                        dashArray: 0
                    },
                    dropShadow: {
                        show: false
                    }
                },
                tooltip: {
                    enabled: false
                },
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '13px',
                        fontFamily: 'Inter, ui-sans-serif',
                        fontWeight: 400
                    },
                    formatter: (title) => {
                        let t = title;
                        if (t) {
                            const newT = t.split(' ');
                            t = `${newT[0]} ${newT[1].slice(0, 3)}`;
                        }
                        return t;
                    }
                }
            },
            yaxis: {
                labels: {
                    align: 'left',
                    minWidth: 0,
                    maxWidth: 140,
                    style: {
                        colors: '#9ca3af',
                        fontSize: '13px',
                        fontFamily: 'Inter, ui-sans-serif',
                        fontWeight: 400
                    },
                    formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
                }
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy'
                },
                y: {
                    formatter: (value) => `$${value >= 1000 ? `${value / 1000}k` : value}`
                },
                custom: function (props) {
                    const { categories } = props.ctx.opts.xaxis;
                    const { dataPointIndex } = props;
                    const title = categories[dataPointIndex].split(' ');
                    const newTitle = `${title[0]} ${title[1]}`;
                    return buildTooltip(props, {
                        title: newTitle,
                        mode,
                        hasTextLabel: true,
                        wrapperExtClasses: 'min-w-28',
                        labelDivider: ':',
                        labelExtClasses: 'ms-2'
                    });
                }
            },
            responsive: [{
                breakpoint: 568,
                options: {
                    chart: {
                        height: 300
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#9ca3af',
                                fontSize: '11px',
                                fontFamily: 'Inter, ui-sans-serif',
                                fontWeight: 400
                            },
                            offsetX: -2,
                            formatter: (title) => title.slice(0, 3)
                        }
                    },
                    yaxis: {
                        labels: {
                            align: 'left',
                            minWidth: 0,
                            maxWidth: 140,
                            style: {
                                colors: '#9ca3af',
                                fontSize: '11px',
                                fontFamily: 'Inter, ui-sans-serif',
                                fontWeight: 400
                            },
                            formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
                        }
                    }
                }
            }]
        }), {
            colors: ['#2563eb', '#9333ea'],
            fill: {
                gradient: {
                    shadeIntensity: .1,
                    opacityFrom: .5,
                    opacityTo: 0,
                    stops: [50, 100, 100, 100]
                }
            },
            xaxis: {
                labels: {
                    style: {
                        colors: '#9ca3af'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#9ca3af'
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb'
            }
        });
    })();
});
</script>
@endpush
