@extends('shared::layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Header con título y botón de acción --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-lg font-bold text-gray-900">Dashboard</h1>
        <a href="{{ route('superlinkiu.stores.create') }}" class="bg-primary-300 hover:bg-primary-400 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Nueva Tienda
        </a>
    </div>

    {{-- SECTION: Estadísticas Principales --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card 
            title="Total Tiendas" 
            :value="$stats['total_stores']" 
            icon="store" 
            color="primary"
            description="Total de tiendas registradas"
        />
        <x-stat-card 
            title="Tiendas Activas" 
            :value="$stats['active_stores']" 
            icon="check-circle" 
            color="success"
        >
            <x-slot name="badge">
                <span class="text-xs font-medium text-success-600">{{ $stats['active_percentage'] }}% del total</span>
            </x-slot>
        </x-stat-card>
        <x-stat-card 
            title="Verificadas" 
            :value="$stats['verified_stores']" 
            icon="shield-check" 
            color="info"
            description="Con documentación verificada"
        />
        <x-stat-card 
            title="Ingresos del Mes" 
            :value="'$' . number_format($monthlyRevenue, 0, ',', '.') . ' COP'"
            icon="wallet" 
            color="secondary"
        >
            <x-slot name="badge">
                @if($revenueGrowth > 0)
                    <span class="text-xs font-medium text-success-600 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i>
                        +{{ $revenueGrowth }}%
                    </span>
                @else
                    <span class="text-xs font-medium text-red-600 flex items-center gap-1">
                        <i data-lucide="trending-down" class="w-3 h-3"></i>
                        {{ $revenueGrowth }}%
                    </span>
                @endif
            </x-slot>
        </x-stat-card>
    </div>

    {{-- SECTION: Solicitudes Pendientes --}}
    <x-pending-requests-widget 
        :stats="$pendingStats"
        :viewAllUrl="route('superlinkiu.store-requests.index')"
    />

    {{-- SECTION: Alertas de Monitoreo --}}
    @if(count($alerts) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            @foreach($alerts as $alert)
                @php
                    $alertType = match($alert['type']) {
                        'error' => 'error',
                        'warning' => 'warning',
                        'info' => 'success',
                        default => 'success'
                    };
                @endphp
                <x-alert-bordered 
                    type="{{ $alertType }}"
                    title="{{ $alert['title'] }}"
                    message="{{ $alert['message'] }}"
                >
                    @if(isset($alert['items']))
                        <ul class="mt-2 space-y-1">
                            @foreach($alert['items'] as $item)
                                <li class="text-sm">
                                    • {{ $item['store'] }} - Plan {{ $item['plan'] }} ({{ $item['days'] }} días)
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(isset($alert['action']))
                        <a href="{{ $alert['action'] }}" class="text-sm font-semibold mt-2 inline-block underline">
                            Ver detalles →
                        </a>
                    @endif
                </x-alert-bordered>
            @endforeach
        </div>
    @endif

    {{-- SECTION: Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <x-chart-widget 
            type="line"
            title="Crecimiento Mensual"
            :data="$growthChartData"
            chartId="growthChart"
            height="300"
        />
        
        @if(count($storesByPlan) > 0)
            <x-chart-widget 
                type="doughnut"
                title="Distribución por Plan"
                :data="$planChartData"
                chartId="planChart"
                height="300"
            />
        @else
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribución por Plan</h3>
                <div class="flex items-center justify-center h-[300px]">
                    <div class="text-center">
                        <i data-lucide="pie-chart" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-sm text-gray-500">No hay datos disponibles</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- SECTION: Últimas Tiendas --}}
    <x-latest-stores-table-widget 
        :stores="$latestStores"
        :viewAllUrl="route('superlinkiu.stores.index')"
    />
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
