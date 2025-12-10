@extends('shared::layouts.admin')

@section('title', 'Monitoreo del Sistema')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Monitoreo del Sistema</h2>
                    <p class="text-sm text-gray-600">Monitoreo en tiempo real de errores, tráfico y performance</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.monitoring.alerts.index') }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        Alertas
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    {{-- SECTION: Resumen (Últimas 24h) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stat-card 
            title="Errores" 
            :value="$summary['errors_count']" 
            icon="alert-triangle" 
            color="error"
            description="Últimas 24 horas"
        />
        <x-stat-card 
            title="Tráfico" 
            :value="number_format($summary['traffic_count'])" 
            icon="activity" 
            color="primary"
            description="Requests últimas 24h"
        />
        <x-stat-card 
            title="Tiempo Promedio" 
            :value="$summary['avg_response_time'] . ' ms'" 
            icon="clock" 
            color="info"
            description="Tiempo de respuesta"
        />
        <x-stat-card 
            title="Tasa de Errores" 
            :value="$summary['error_rate'] . '%'" 
            icon="percent" 
            color="warning"
            description="Porcentaje de errores"
        />
    </div>
    {{-- End SECTION: Resumen --}}

    {{-- SECTION: Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Gráfico de Errores --}}
        <x-chart-widget 
            type="line"
            title="Errores por Día (Últimos 7 días)"
            :data="[
                'labels' => array_column($errorsByDay, 'date'),
                'datasets' => [[
                    'label' => 'Errores',
                    'data' => array_column($errorsByDay, 'error'),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ], [
                    'label' => 'Advertencias',
                    'data' => array_column($errorsByDay, 'warning'),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ]]
            ]"
            chartId="errorsChart"
            height="300"
        />

        {{-- Gráfico de Tráfico --}}
        <x-chart-widget 
            type="bar"
            title="Tráfico por Día (Últimos 7 días)"
            :data="[
                'labels' => array_column($trafficByDay, 'date'),
                'datasets' => [[
                    'label' => 'Requests',
                    'data' => array_column($trafficByDay, 'count'),
                    'backgroundColor' => '#7432F8',
                    'borderColor' => '#7432F8',
                    'borderWidth' => 1
                ]]
            ]"
            chartId="trafficChart"
            height="300"
        />
    </div>
    {{-- End SECTION: Gráficos --}}

    {{-- SECTION: Errores Recientes --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Errores Recientes</h3>
                <a href="{{ route('superlinkiu.monitoring.errors') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                    Ver todos →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ocurrencias</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última vez</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentErrors as $error)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $levelColors = [
                                        'ERROR' => 'bg-red-100 text-red-800',
                                        'WARNING' => 'bg-yellow-100 text-yellow-800',
                                        'INFO' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $color = $levelColors[$error['level']] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                    {{ $error['level'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-md truncate">
                                    {{ Str::limit($error['message'], 80) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $error['route'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $error['occurrence_count'] ?? 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($error['last_occurred_at'])->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('superlinkiu.monitoring.errors.show', $error['id']) }}" 
                                   class="text-primary-600 hover:text-primary-900">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay errores recientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- End SECTION: Errores Recientes --}}

    {{-- SECTION: Rutas Más Visitadas y Más Lentas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Rutas Más Visitadas --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <h3 class="text-lg font-semibold text-gray-900">Rutas Más Visitadas</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topRoutes as $route)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $route['route'] }}</p>
                                <p class="text-xs text-gray-500">{{ number_format($route['count']) }} requests</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $route['avg_time'] }}ms</p>
                                <p class="text-xs text-gray-500">promedio</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Rutas Más Lentas --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <h3 class="text-lg font-semibold text-gray-900">Rutas Más Lentas</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($slowestRoutes as $route)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $route['route'] }}</p>
                                <p class="text-xs text-gray-500">{{ number_format($route['count']) }} requests</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-red-600">{{ $route['avg_time'] }}ms</p>
                                <p class="text-xs text-gray-500">promedio</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No hay rutas lentas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Rutas --}}

    {{-- SECTION: Navegación --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('superlinkiu.monitoring.errors') }}" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Errores</h3>
                    <p class="text-sm text-gray-500">Ver todos los errores</p>
                </div>
            </div>
        </a>

        <a href="{{ route('superlinkiu.monitoring.traffic') }}" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="activity" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Tráfico</h3>
                    <p class="text-sm text-gray-500">Análisis de tráfico</p>
                </div>
            </div>
        </a>

        <a href="{{ route('superlinkiu.monitoring.performance') }}" 
           class="bg-white rounded-lg border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="gauge" class="w-6 h-6 text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Performance</h3>
                    <p class="text-sm text-gray-500">Métricas de rendimiento</p>
                </div>
            </div>
        </a>
    </div>
    {{-- End SECTION: Navegación --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

