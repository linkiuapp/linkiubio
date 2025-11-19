{{--
Chart Single Area - Gráfico de área simple
Uso: Gráfico de área con una sola serie de datos
Cuándo usar: Cuando necesites mostrar una tendencia de datos a lo largo del tiempo
Cuándo NO usar: Cuando necesites comparar múltiples series (usa Multiple Area)
Ejemplo: <x-chart-single-area chartId="my-chart" />
Nota: Este componente requiere ApexCharts para funcionar. Ver documentación en el showcase.
--}}

@props([
    'chartId' => null,
])

@php
    $uniqueId = $chartId ?? 'chart-area-' . uniqid();
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
                    name: 'Visitantes',
                    data: [180, 51, 60, 38, 88, 50, 40, 52, 88, 80, 60, 70]
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
                    formatter: (value) => `${value >= 1000 ? `${value / 1000}k` : value}`
                },
                custom: function (props) {
                    const { categories } = props.ctx.opts.xaxis;
                    const { dataPointIndex } = props;
                    const title = categories[dataPointIndex].split(' ');
                    const newTitle = `${title[0]} ${title[1]}`;
                    return buildTooltip(props, {
                        title: newTitle,
                        mode,
                        valuePrefix: '',
                        hasTextLabel: true,
                        wrapperExtClasses: 'min-w-28'
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

