{{--
StatCard - Card de estadísticas para dashboards
Uso: Mostrar métricas y estadísticas con icono y valor destacado
Cuándo usar: Dashboards, paneles de control, resúmenes de datos
Cuándo NO usar: Información detallada que requiere más espacio
Ejemplo: <x-stat-card title="Total" :value="150" icon="shopping-cart" color="primary" />
--}}

@props([
    'title' => '',
    'value' => 0,
    'icon' => 'info',
    'color' => 'primary', // primary, success, warning, info, secondary, accent
    'description' => '',
    'badge' => '',
])

@php
    // Color classes mapping - Mejor contraste con fondos blancos y bordes
    $colorClasses = [
        'primary' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-primary-300',
            'iconBg' => 'bg-primary-50',
            'iconColor' => 'text-primary-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'success' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-success-300',
            'iconBg' => 'bg-success-50',
            'iconColor' => 'text-success-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'warning' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-warning-300',
            'iconBg' => 'bg-warning-50',
            'iconColor' => 'text-warning-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'info' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-info-300',
            'iconBg' => 'bg-info-50',
            'iconColor' => 'text-info-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'secondary' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-secondary-300',
            'iconBg' => 'bg-secondary-50',
            'iconColor' => 'text-secondary-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
        'accent' => [
            'bg' => 'bg-white',
            'border' => 'border-l-4 border-accent-300',
            'iconBg' => 'bg-accent-50',
            'iconColor' => 'text-accent-400',
            'titleColor' => 'text-gray-600',
            'valueColor' => 'text-gray-900',
        ],
    ];
    
    $colors = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="{{ $colors['bg'] }} {{ $colors['border'] }} rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow" {{ $attributes }}>
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-lg {{ $colors['iconBg'] }} flex items-center justify-center flex-shrink-0">
                <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $colors['iconColor'] }}"></i>
            </div>
            <div>
                <h2 class="text-sm font-medium {{ $colors['titleColor'] }} mb-0">{{ $title }}</h2>
                @if($description)
                    <p class="text-xs text-gray-500 mt-1 mb-0">{{ $description }}</p>
                @endif
            </div>
        </div>
        {{-- Slot para badge personalizado --}}
        @if(isset($badge))
            <span class="ml-auto">
                {{ $badge }}
            </span>
        @elseif($badge !== '')
            <span class="ml-auto">
                {!! $badge !!}
            </span>
        @endif
    </div>
    <h3 class="text-3xl font-bold {{ $colors['valueColor'] }} mb-0">
        @if(is_numeric($value))
            {{ number_format($value) }}
        @else
            {{ $value }}
        @endif
    </h3>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
