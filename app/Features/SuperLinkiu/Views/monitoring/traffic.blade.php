@extends('shared::layouts.admin')

@section('title', 'Análisis de Tráfico')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.monitoring.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Análisis de Tráfico</h1>
                <p class="text-sm text-gray-600 mt-1">Monitorea el tráfico y rendimiento de las rutas</p>
            </div>
        </div>
        <div>
            <form method="GET" action="{{ route('superlinkiu.monitoring.traffic') }}" class="flex items-center gap-2">
                <select name="hours" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    <option value="1" {{ $hours == 1 ? 'selected' : '' }}>Última hora</option>
                    <option value="24" {{ $hours == 24 ? 'selected' : '' }}>Últimas 24 horas</option>
                    <option value="168" {{ $hours == 168 ? 'selected' : '' }}>Última semana</option>
                </select>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Actualizar
                </button>
            </form>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    {{-- SECTION: Rutas Más Visitadas --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Rutas Más Visitadas</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($topRoutes as $route)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $route['route'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ number_format($route['count']) }} requests</p>
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
    {{-- End SECTION: Rutas Más Visitadas --}}

    {{-- SECTION: Rutas Más Lentas --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Rutas Más Lentas</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($slowestRoutes as $route)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $route['route'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ number_format($route['count']) }} requests</p>
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
    {{-- End SECTION: Rutas Más Lentas --}}

    {{-- SECTION: Distribución de Status Codes --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Distribución de Status Codes</h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($statusCodes as $status)
                    @php
                        $statusColors = [
                            200 => 'bg-green-100 text-green-800',
                            201 => 'bg-green-100 text-green-800',
                            204 => 'bg-green-100 text-green-800',
                            400 => 'bg-yellow-100 text-yellow-800',
                            401 => 'bg-yellow-100 text-yellow-800',
                            403 => 'bg-yellow-100 text-yellow-800',
                            404 => 'bg-yellow-100 text-yellow-800',
                            500 => 'bg-red-100 text-red-800',
                            502 => 'bg-red-100 text-red-800',
                            503 => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$status['status_code']] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ $status['status_code'] }}
                            </span>
                            <span class="text-sm text-gray-600">
                                {{ number_format($status['count']) }} requests
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- End SECTION: Distribución de Status Codes --}}

    {{-- SECTION: IPs Más Activas --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">IPs Más Activas</h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($topIPs as $ip)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm font-medium text-gray-900">{{ $ip['ip_address'] }}</span>
                        <span class="text-sm text-gray-600">{{ number_format($ip['count']) }} requests</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- End SECTION: IPs Más Activas --}}

    {{-- SECTION: Stores con Más Tráfico --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-900">Stores con Más Tráfico</h2>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($topStores as $store)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm font-medium text-gray-900">{{ $store['store_name'] }}</span>
                        <span class="text-sm text-gray-600">{{ number_format($store['count']) }} requests</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No hay datos disponibles</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- End SECTION: Stores con Más Tráfico --}}
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

