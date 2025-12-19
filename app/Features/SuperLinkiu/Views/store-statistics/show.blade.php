@extends('shared::layouts.admin')

@section('title', 'Estadísticas - ' . $store->name)

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('superlinkiu.store-statistics.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-900">📊 Estadísticas de {{ $store->name }}</h1>
            </div>
            <p class="text-sm text-gray-600">{{ $store->slug }}</p>
        </div>
        <a href="{{ route('superlinkiu.stores.show', $store) }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
            <i data-lucide="store" class="w-4 h-4"></i>
            Ver Tienda
        </a>
    </div>

    {{-- Filtros de Fecha --}}
    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('superlinkiu.store-statistics.show', $store) }}" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" 
                       name="date_from" 
                       value="{{ $dateFrom->format('Y-m-d') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" 
                       name="date_to" 
                       value="{{ $dateTo->format('Y-m-d') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                Actualizar
            </button>
        </form>
    </div>

    {{-- Métricas Principales --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Productos Creados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['products_created']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ventas Totales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_sales']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Ticket: ${{ number_format($stats['average_ticket'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ingresos por Domicilios</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['delivery_revenue'], 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ number_format($stats['delivery_orders']) }} pedidos</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i data-lucide="truck" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ingresos Totales</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Ventas Totales Netas --}}
    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200 shadow-sm mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-blue-900 mb-2">📊 Ventas Totales Netas</h3>
                <p class="text-3xl font-bold text-blue-900">${{ number_format($stats['net_sales'], 0, ',', '.') }}</p>
                <p class="text-sm text-blue-700 mt-1">Ingresos sin domicilios</p>
            </div>
            <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center">
                <i data-lucide="trending-up" class="w-8 h-8 text-blue-700"></i>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Gráfico de Ventas Mensuales --}}
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Ventas Mensuales</h3>
            <div class="h-[300px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Gráfico de Ingresos Mensuales --}}
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Ingresos Mensuales</h3>
            <div class="h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Distribución por Tipo de Entrega --}}
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Ingresos por Tipo de Entrega</h3>
        <div class="h-[300px]">
            <canvas id="deliveryTypeChart"></canvas>
        </div>
    </div>

    {{-- Top Productos y Categorías --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Top Productos Vendidos --}}
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top 10 Productos Vendidos</h3>
            @if(count($topProducts) > 0)
                <div class="space-y-3">
                    @foreach($topProducts as $index => $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product['product_name'] }}</p>
                                    <p class="text-xs text-gray-600">{{ number_format($product['total_quantity']) }} unidades</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">${{ number_format($product['total_revenue'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-8">No hay productos vendidos en este período</p>
            @endif
        </div>

        {{-- Distribución por Categorías --}}
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Distribución por Categorías</h3>
            @if(count($categoryDistribution) > 0)
                <div class="h-[300px]">
                    <canvas id="categoryChart"></canvas>
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-8">No hay datos de categorías disponibles</p>
            @endif
        </div>
    </div>

    {{-- Comparación con Período Anterior --}}
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Comparación con Período Anterior</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600 mb-2">Ventas</p>
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_sales']) }}</p>
                    @php
                        $salesChange = $previousPeriodStats['total_sales'] > 0 
                            ? (($stats['total_sales'] - $previousPeriodStats['total_sales']) / $previousPeriodStats['total_sales']) * 100 
                            : 0;
                    @endphp
                    @if($salesChange != 0)
                        <span class="text-sm font-medium {{ $salesChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $salesChange > 0 ? '+' : '' }}{{ number_format($salesChange, 1) }}%
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Período anterior: {{ number_format($previousPeriodStats['total_sales']) }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600 mb-2">Ingresos</p>
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    @php
                        $revenueChange = $previousPeriodStats['total_revenue'] > 0 
                            ? (($stats['total_revenue'] - $previousPeriodStats['total_revenue']) / $previousPeriodStats['total_revenue']) * 100 
                            : 0;
                    @endphp
                    @if($revenueChange != 0)
                        <span class="text-sm font-medium {{ $revenueChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $revenueChange > 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Período anterior: ${{ number_format($previousPeriodStats['total_revenue'], 0, ',', '.') }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600 mb-2">Productos Vendidos</p>
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['products_sold']) }}</p>
                    @php
                        $productsChange = $previousPeriodStats['products_sold'] > 0 
                            ? (($stats['products_sold'] - $previousPeriodStats['products_sold']) / $previousPeriodStats['products_sold']) * 100 
                            : 0;
                    @endphp
                    @if($productsChange != 0)
                        <span class="text-sm font-medium {{ $productsChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $productsChange > 0 ? '+' : '' }}{{ number_format($productsChange, 1) }}%
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Período anterior: {{ number_format($previousPeriodStats['products_sold']) }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si Chart.js está disponible
    if (typeof Chart === 'undefined') {
        console.error('Chart.js no está disponible');
        return;
    }

    // Gráfico de Ventas Mensuales
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        try {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlySales['labels']),
                    datasets: [{
                        label: 'Ventas',
                        data: @json($monthlySales['data']),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' ventas';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12
                                },
                                color: '#6b7280'
                            },
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280'
                            },
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al crear gráfico de ventas:', error);
        }
    }

    // Gráfico de Ingresos Mensuales
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        try {
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyRevenue['labels']),
                    datasets: [{
                        label: 'Ingresos (COP)',
                        data: @json($monthlyRevenue['data']),
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return '$' + new Intl.NumberFormat('es-CO').format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280',
                                callback: function(value) {
                                    return '$' + new Intl.NumberFormat('es-CO', { maximumFractionDigits: 0 }).format(value);
                                }
                            },
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280'
                            },
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)'
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al crear gráfico de ingresos:', error);
        }
    }

    // Gráfico de Tipo de Entrega
    const deliveryCtx = document.getElementById('deliveryTypeChart');
    if (deliveryCtx) {
        try {
            const deliveryData = @json($revenueByDeliveryType);
            new Chart(deliveryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Domicilio', 'Recoger', 'Consumo Local', 'Servicio Habitación'],
                    datasets: [{
                        data: [
                            deliveryData.delivery.revenue || 0,
                            deliveryData.pickup.revenue || 0,
                            deliveryData.dine_in.revenue || 0,
                            deliveryData.room_service.revenue || 0
                        ],
                        backgroundColor: [
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderColor: [
                            'rgb(249, 115, 22)',
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                },
                                color: '#374151'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    return label + ': $' + new Intl.NumberFormat('es-CO').format(value);
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al crear gráfico de tipo de entrega:', error);
        }
    }

    // Gráfico de Categorías
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx && @json(count($categoryDistribution)) > 0) {
        try {
            const categoryData = @json($categoryDistribution);
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: categoryData.map(c => c.category_name),
                    datasets: [{
                        data: categoryData.map(c => c.total_quantity),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(14, 165, 233, 0.8)',
                            'rgba(251, 191, 36, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                },
                                color: '#374151',
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return {
                                                text: label + ': ' + value + ' unidades (' + percentage + '%)',
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                strokeStyle: data.datasets[0].borderColor,
                                                lineWidth: data.datasets[0].borderWidth,
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value + ' unidades (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al crear gráfico de categorías:', error);
        }
    }

    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
@endsection
