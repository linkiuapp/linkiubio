{{--
PendingRequestsWidget - Widget de solicitudes pendientes con prioridades
Uso: Mostrar estadísticas de solicitudes pendientes con niveles de prioridad
Cuándo usar: Dashboards de Super Admin donde se monitorean solicitudes
Cuándo NO usar: Cuando no hay solicitudes pendientes o no aplica
Ejemplo: <x-pending-requests-widget :stats="$pendingStats" />
--}}

@props([
    'stats' => [],
    'viewAllUrl' => '#',
])

@php
    $hasCritical = ($stats['critical'] ?? 0) > 0;
    $hasUrgent = ($stats['urgent'] ?? 0) > 0 && !$hasCritical;
@endphp

@if(($stats['total'] ?? 0) > 0)
<div class="bg-white border-l-4 {{ $hasCritical ? 'border-red-500' : ($hasUrgent ? 'border-orange-500' : 'border-warning-400') }} rounded-lg shadow-sm overflow-hidden relative">
    {{-- Badge de prioridad flotante --}}
    @if($hasCritical)
    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
        🚨 {{ $stats['critical'] }} CRÍTICA(S)
    </div>
    @elseif($hasUrgent)
    <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
        ⚠️ {{ $stats['urgent'] }} URGENTE(S)
    </div>
    @endif
    
    <div class="p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                    <div class="w-10 h-10 bg-warning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-warning-500"></i>
                    </div>
                    Solicitudes de Tiendas Pendientes
                </h3>
                <p class="text-sm text-gray-600">
                    {{ $stats['total'] }} solicitud(es) esperando revisión
                    @if(isset($stats['oldest']) && $stats['oldest'])
                        • La más antigua: <strong>{{ $stats['oldest']->created_at->diffForHumans() }}</strong>
                    @endif
                </p>
            </div>
        </div>
        
        {{-- Estadísticas en grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Total Pendientes --}}
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Pendientes</p>
                        <p class="text-3xl font-bold text-warning-600">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-warning-600"></i>
                    </div>
                </div>
            </div>
            
            {{-- Críticas (>24h) --}}
            <div class="bg-gray-50 rounded-lg p-4 border-2 {{ $hasCritical ? 'border-red-300 ring-2 ring-red-200' : 'border-gray-200' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Críticas (>24h)</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['critical'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                    </div>
                </div>
                @if($hasCritical)
                <p class="text-xs text-red-600 mt-2 font-semibold">⚠️ Requiere atención inmediata</p>
                @endif
            </div>
            
            {{-- Urgentes (>6h) --}}
            <div class="bg-gray-50 rounded-lg p-4 border-2 {{ $hasUrgent ? 'border-orange-300 ring-2 ring-orange-200' : 'border-gray-200' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Urgentes (>6h)</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $stats['urgent'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i data-lucide="bell" class="w-6 h-6 text-orange-600"></i>
                    </div>
                </div>
            </div>
            
            {{-- Tiempo Promedio --}}
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tiempo Promedio</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['avg_hours'] ?? 0 }}h</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i data-lucide="hourglass" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-2">
                    @if(($stats['avg_hours'] ?? 0) > 6)
                        <span class="text-orange-600 font-semibold">⚠️ Por encima del objetivo (6h)</span>
                    @else
                        <span class="text-green-600 font-semibold">✓ Dentro del objetivo (6h)</span>
                    @endif
                </p>
            </div>
        </div>
        
        {{-- Botones de acción --}}
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ $viewAllUrl }}" 
               class="bg-primary-300 hover:bg-primary-400 text-white px-6 py-3 rounded-lg flex items-center gap-2 font-semibold transition-colors">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Revisar Solicitudes ({{ $stats['total'] ?? 0 }})
            </a>
            
            @if($hasCritical)
            <a href="{{ $viewAllUrl }}?tab=pending" 
               class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg flex items-center gap-2 font-semibold transition-colors animate-pulse">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                Atender Críticas ({{ $stats['critical'] }})
            </a>
            @endif
            
            <button onclick="window.location.reload()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Actualizar
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

