@extends('shared::layouts.admin')

@section('title', 'Detalle de Alerta')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.monitoring.alerts.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Detalle de Alerta</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $alert->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.monitoring.alerts.edit', $alert->id) }}" 
               class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- SECTION: Contenido Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- SECTION: Información de la Alerta --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información de la Alerta</h2>
                        <div class="flex items-center gap-2">
                            @if($alert->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Activa
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactiva
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $alert->name }}</h3>
                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                Creada: {{ $alert->created_at->format('d/m/Y H:i') }}
                            </span>
                            @if($alert->last_triggered_at)
                                <span class="flex items-center gap-1">
                                    <i data-lucide="zap" class="w-4 h-4"></i>
                                    Última disparada: {{ $alert->last_triggered_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tipo</label>
                            @php
                                $typeLabels = [
                                    'error_rate' => 'Tasa de Errores',
                                    'traffic_spike' => 'Pico de Tráfico',
                                    'slow_response' => 'Respuesta Lenta',
                                    'high_memory' => 'Alto Uso de Memoria',
                                    'custom' => 'Personalizado',
                                ];
                            @endphp
                            <p class="text-sm font-medium text-gray-900">{{ $typeLabels[$alert->type] ?? $alert->type }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Canal</label>
                            <div class="flex items-center gap-2">
                                @php
                                    $channelIcons = [
                                        'email' => 'mail',
                                        'whatsapp' => 'message-circle',
                                        'in_app' => 'bell',
                                    ];
                                    $channelColors = [
                                        'email' => 'text-blue-600',
                                        'whatsapp' => 'text-green-600',
                                        'in_app' => 'text-purple-600',
                                    ];
                                @endphp
                                <i data-lucide="{{ $channelIcons[$alert->channel] ?? 'bell' }}" class="w-4 h-4 {{ $channelColors[$alert->channel] ?? 'text-gray-600' }}"></i>
                                <p class="text-sm font-medium text-gray-900 capitalize">{{ $alert->channel }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Cooldown</label>
                            <p class="text-sm font-medium text-gray-900">{{ $alert->cooldown_minutes }} minutos</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Última Actualización</label>
                            <p class="text-sm font-medium text-gray-900">{{ $alert->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Información de la Alerta --}}

            {{-- SECTION: Condiciones --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Condiciones</h2>
                </div>
                
                <div class="p-6">
                    @php
                        $conditions = is_array($alert->conditions) ? $alert->conditions : (json_decode($alert->conditions, true) ?? []);
                    @endphp

                    @if($alert->type === 'error_rate')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Umbral</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['threshold']) ? $conditions['threshold'] : 'N/A' }} errores</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Ventana de tiempo</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['minutes']) ? $conditions['minutes'] : 'N/A' }} minutos</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Nivel</span>
                                <span class="text-sm font-medium text-gray-900">{{ $conditions['level'] ?? 'ERROR' }}</span>
                            </div>
                            @if(!empty($conditions['route_pattern']))
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Filtrar por Ruta</span>
                                <span class="text-sm font-medium text-gray-900">{{ $conditions['route_pattern'] }}</span>
                            </div>
                            @endif
                        </div>
                    @elseif($alert->type === 'traffic_spike')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Umbral</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['threshold']) ? $conditions['threshold'] : 'N/A' }} requests</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Ventana de tiempo</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['minutes']) ? $conditions['minutes'] : 'N/A' }} minutos</span>
                            </div>
                        </div>
                    @elseif($alert->type === 'slow_response')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Umbral</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['threshold_ms']) ? $conditions['threshold_ms'] : 'N/A' }} ms</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Ventana de tiempo</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['minutes']) ? $conditions['minutes'] : 'N/A' }} minutos</span>
                            </div>
                            @if(!empty($conditions['route_pattern']))
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Filtrar por Ruta</span>
                                <span class="text-sm font-medium text-gray-900">{{ $conditions['route_pattern'] }}</span>
                            </div>
                            @endif
                        </div>
                    @elseif($alert->type === 'high_memory')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Umbral</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['threshold_mb']) ? $conditions['threshold_mb'] : 'N/A' }} MB</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Ventana de tiempo</span>
                                <span class="text-sm font-medium text-gray-900">{{ isset($conditions['minutes']) ? $conditions['minutes'] : 'N/A' }} minutos</span>
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-gray-600">
                            <pre class="bg-gray-50 p-4 rounded-lg overflow-auto">{{ json_encode($conditions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                </div>
            </div>
            {{-- End SECTION: Condiciones --}}
        </div>
        {{-- End SECTION: Contenido Principal --}}

        {{-- SECTION: Sidebar --}}
        <div class="space-y-6">
            {{-- SECTION: Acciones --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Acciones</h2>
                </div>
                
                <div class="p-6 space-y-3">
                    <a href="{{ route('superlinkiu.monitoring.alerts.edit', $alert->id) }}" 
                       class="block w-full text-center bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Editar Alerta
                    </a>
                    <form method="POST" action="{{ route('superlinkiu.monitoring.alerts.toggle-status', $alert->id) }}">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            {{ $alert->is_active ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('superlinkiu.monitoring.alerts.destroy', $alert->id) }}"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta alerta?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Eliminar Alerta
                        </button>
                    </form>
                </div>
            </div>
            {{-- End SECTION: Acciones --}}
        </div>
        {{-- End SECTION: Sidebar --}}
    </div>
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

