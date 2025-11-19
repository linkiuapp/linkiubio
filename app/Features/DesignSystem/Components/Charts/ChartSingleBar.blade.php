{{--
Chart Single Bar - Gráfico de barras simple
Uso: Gráfico de barras con una sola serie de datos
Cuándo usar: Cuando necesites comparar valores categóricos
Cuándo NO usar: Cuando necesites mostrar tendencias temporales (usa Area Chart)
Ejemplo: <x-chart-single-bar chartId="my-chart" />
Nota: Este componente requiere ApexCharts para funcionar. Ver documentación en el showcase.
--}}

@props([
    'chartId' => null,
])

@php
    $uniqueId = $chartId ?? 'chart-bar-' . uniqid();
@endphp

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
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [
                {
                    name: 'Ventas',
                    data: [23000, 44000, 55000, 57000, 56000, 61000, 58000, 63000, 60000, 66000, 34000, 78000]
                }
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '16px',
                    borderRadius: 0
                }
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 8,
                colors: ['transparent']
            },
            xaxis: {
                categories: [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre'
                ],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#9ca3af',
                        fontSize: '13px',
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
                        fontSize: '13px',
                        fontFamily: 'Inter, ui-sans-serif',
                        fontWeight: 400
                    },
                    formatter: (value) => value >= 1000 ? `${value / 1000}k` : value
                }
            },
            states: {
                hover: {
                    filter: {
                        type: 'darken',
                        value: 0.9
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: (value) => `$${value >= 1000 ? `${value / 1000}k` : value}`
                },
                custom: function (props) {
                    const { categories } = props.ctx.opts.xaxis;
                    const { dataPointIndex } = props;
                    const title = categories[dataPointIndex];
                    return buildTooltip(props, {
                        title: title,
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
                    plotOptions: {
                        bar: {
                            columnWidth: '14px'
                        }
                    },
                    stroke: {
                        width: 8
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
            colors: ['#2563eb', '#d1d5db'],
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
