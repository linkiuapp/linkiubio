@extends('shared::layouts.admin')

@section('title', 'Dashboard de Planes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Dashboard de Planes</h1>
            <p class="text-sm text-gray-600 mt-1">Métricas y análisis de suscripciones</p>
        </div>
        <a href="{{ route('superlinkiu.plans.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="list" class="w-4 h-4"></i>
            Ver Planes
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- MRR --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs font-medium">MRR</p>
                    <p class="text-2xl font-bold mt-1">${{ number_format($stats['mrr'], 0, ',', '.') }}</p>
                    <p class="text-blue-200 text-xs mt-1">Ingresos mensuales</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        {{-- ARR --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs font-medium">ARR Proyectado</p>
                    <p class="text-2xl font-bold mt-1">${{ number_format($stats['arr'], 0, ',', '.') }}</p>
                    <p class="text-green-200 text-xs mt-1">Ingresos anuales</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        {{-- Tiendas Activas --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs font-medium">Tiendas Activas</p>
                    <p class="text-2xl font-bold mt-1">{{ number_format($stats['total_stores']) }}</p>
                    <p class="text-purple-200 text-xs mt-1">{{ $stats['stores_in_trial'] }} en trial</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i data-lucide="store" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        {{-- Churn Rate --}}
        <div class="bg-gradient-to-br from-{{ $stats['churn_rate'] > 5 ? 'red' : 'gray' }}-500 to-{{ $stats['churn_rate'] > 5 ? 'red' : 'gray' }}-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-{{ $stats['churn_rate'] > 5 ? 'red' : 'gray' }}-100 text-xs font-medium">Churn Rate</p>
                    <p class="text-2xl font-bold mt-1">{{ $stats['churn_rate'] }}%</p>
                    <p class="text-{{ $stats['churn_rate'] > 5 ? 'red' : 'gray' }}-200 text-xs mt-1">{{ $stats['cancelled_last_30'] }} canceladas (30d)</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <i data-lucide="user-minus" class="w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Distribución por Plan (Gráfico) --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-blue-600"></i>
                    Distribución por Plan
                </h2>
            </div>
            <div class="p-6">
                <canvas id="planDistributionChart" height="250"></canvas>
            </div>
        </div>

        {{-- Tendencia de Ingresos --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="line-chart" class="w-5 h-5 text-green-600"></i>
                    Tendencia de Ingresos
                </h2>
            </div>
            <div class="p-6">
                <canvas id="revenueTrendChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Planes Más Rentables --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="trophy" class="w-5 h-5 text-yellow-600"></i>
                    Planes Más Rentables
                </h2>
            </div>
            <div class="p-6">
                @if(count($topPlans) > 0)
                    <div class="space-y-3">
                        @foreach($topPlans as $index => $plan)
                            <div class="flex items-center gap-4 p-3 rounded-lg {{ $index === 0 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }}">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm {{ $index === 0 ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $plan['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $plan['stores_count'] }} tiendas</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">${{ number_format($plan['mrr'], 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">MRR</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No hay datos disponibles</p>
                @endif
            </div>
        </div>

        {{-- Conversión de Trials --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="gift" class="w-5 h-5 text-purple-600"></i>
                    Conversión de Trials
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-3xl font-bold text-purple-600">{{ $trialConversions['conversion_rate'] }}%</p>
                        <p class="text-xs text-purple-600 mt-1">Tasa de conversión</p>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $trialConversions['current_trials'] }}</p>
                        <p class="text-xs text-blue-600 mt-1">Trials activos</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Trials finalizados (90d)</span>
                    <span class="font-semibold">{{ $trialConversions['ended_trials'] }}</span>
                </div>
                <div class="flex items-center justify-between text-sm mt-2">
                    <span class="text-gray-600">Convertidos a pago</span>
                    <span class="font-semibold text-green-600">{{ $trialConversions['converted'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas de Límites --}}
    @if(count($storesNearLimits) > 0)
    <div class="bg-white rounded-lg shadow-sm border border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h2 class="text-base font-semibold text-red-800 flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                Tiendas Cerca de Límites
                <span class="ml-2 px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded-full">{{ count($storesNearLimits) }}</span>
            </h2>
            <p class="text-xs text-red-600 mt-1">Estas tiendas están al 80% o más de sus límites. Considera contactarlas para upgrade.</p>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-3 font-medium text-gray-600">Tienda</th>
                            <th class="text-left py-2 px-3 font-medium text-gray-600">Plan</th>
                            <th class="text-left py-2 px-3 font-medium text-gray-600">Recurso</th>
                            <th class="text-left py-2 px-3 font-medium text-gray-600">Uso</th>
                            <th class="text-center py-2 px-3 font-medium text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($storesNearLimits as $item)
                            @foreach($item['alerts'] as $alert)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    @if($loop->first)
                                        <td class="py-2 px-3" rowspan="{{ count($item['alerts']) }}">
                                            <a href="{{ route('superlinkiu.stores.show', $item['store']) }}" class="font-medium text-blue-600 hover:underline">
                                                {{ $item['store']->name }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-3 text-gray-600" rowspan="{{ count($item['alerts']) }}">
                                            {{ $item['store']->plan->name ?? 'Sin plan' }}
                                        </td>
                                    @endif
                                    <td class="py-2 px-3">{{ $alert['resource'] }}</td>
                                    <td class="py-2 px-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full {{ $alert['percent'] >= 100 ? 'bg-red-500' : ($alert['percent'] >= 90 ? 'bg-orange-500' : 'bg-yellow-500') }}" style="width: {{ min($alert['percent'], 100) }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium {{ $alert['percent'] >= 100 ? 'text-red-600' : 'text-gray-600' }}">
                                                {{ $alert['used'] }}/{{ $alert['limit'] }}
                                            </span>
                                        </div>
                                    </td>
                                    @if($loop->first)
                                        <td class="py-2 px-3 text-center" rowspan="{{ count($item['alerts']) }}">
                                            <a href="{{ route('superlinkiu.stores.edit', $item['store']) }}" class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-xs font-medium">
                                                <i data-lucide="arrow-up-circle" class="w-3 h-3"></i>
                                                Upgrade
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Distribución por Plan (Doughnut)
    const planDistribution = @json($planDistribution);
    new Chart(document.getElementById('planDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: planDistribution.map(p => p.name),
            datasets: [{
                data: planDistribution.map(p => p.count),
                backgroundColor: planDistribution.map(p => p.color),
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                    }
                }
            }
        }
    });

    // Tendencia de Ingresos (Line)
    const revenueTrend = @json($revenueTrend);
    new Chart(document.getElementById('revenueTrendChart'), {
        type: 'line',
        data: {
            labels: revenueTrend.map(r => r.month),
            datasets: [{
                label: 'Ingresos',
                data: revenueTrend.map(r => r.revenue),
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CO');
                        }
                    }
                }
            }
        }
    });

    // Inicializar iconos
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
