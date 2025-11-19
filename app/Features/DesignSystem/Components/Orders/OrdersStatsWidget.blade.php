{{--
OrdersStatsWidget - Widget de estadísticas de pedidos
Uso: Mostrar estadísticas de pedidos por estado y tipo
Cuándo usar: Vista index de pedidos
Cuándo NO usar: Cuando no se necesiten estadísticas
Ejemplo: <x-orders-stats-widget :stats="$stats" />
--}}

@props([
    'stats' => [],
])

<div class="bg-white rounded-lg shadow-sm p-4">
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
        {{-- Total --}}
        <div class="text-center p-3 bg-gradient-to-r from-primary-100 to-primary-50 rounded-lg border-l-4 border-primary-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Total</div>
        </div>
        
        {{-- Pendientes --}}
        <div class="text-center p-3 bg-gradient-to-r from-warning-100 to-warning-50 rounded-lg border-l-4 border-warning-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['pending'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Pendientes</div>
        </div>
        
        {{-- Confirmados --}}
        <div class="text-center p-3 bg-gradient-to-r from-info-100 to-info-50 rounded-lg border-l-4 border-info-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['confirmed'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Confirmados</div>
        </div>
        
        {{-- Preparando --}}
        <div class="text-center p-3 bg-gradient-to-r from-secondary-100 to-secondary-50 rounded-lg border-l-4 border-secondary-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['preparing'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Preparando</div>
        </div>
        
        {{-- Enviados --}}
        <div class="text-center p-3 bg-gradient-to-r from-primary-100 to-primary-50 rounded-lg border-l-4 border-primary-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['shipped'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Enviados</div>
        </div>
        
        {{-- Entregados --}}
        <div class="text-center p-3 bg-gradient-to-r from-success-100 to-success-50 rounded-lg border-l-4 border-success-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['delivered'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Entregados</div>
        </div>
        
        {{-- Cancelados --}}
        <div class="text-center p-3 bg-gradient-to-r from-red-100 to-red-50 rounded-lg border-l-4 border-red-400">
            <div class="text-xl font-bold text-gray-900">{{ $stats['cancelled'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Cancelados</div>
        </div>
        
        {{-- Ingresos --}}
        <div class="text-center p-3 bg-gradient-to-r from-success-100 to-success-50 rounded-lg border-l-4 border-success-400">
            <div class="text-lg font-bold text-gray-900">${{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
            <div class="text-xs text-gray-600 mt-1">Ingresos</div>
        </div>
    </div>
</div>

