{{--
Badge con Indicador - Badge con punto indicador para mostrar estado
Uso: Badges que requieren un indicador visual de estado o actividad
Cuándo usar: Estados de conexión, actividad en tiempo real, indicadores de estado
Cuándo NO usar: Información estática, badges decorativos sin estado específico
Ejemplo: <x-badge-indicator type="success" text="Conectado" />
--}}

@props([
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
])

@php
    $typeClasses = [
        'dark' => [
            'container' => 'bg-gray-100 text-gray-800',
            'indicator' => 'bg-gray-800'
        ],
        'secondary' => [
            'container' => 'bg-gray-50 text-gray-500',
            'indicator' => 'bg-gray-500'
        ],
        'success' => [
            'container' => 'bg-teal-100 text-teal-800',
            'indicator' => 'bg-teal-800'
        ],
        'info' => [
            'container' => 'bg-blue-100 text-blue-800',
            'indicator' => 'bg-blue-800'
        ],
        'error' => [
            'container' => 'bg-red-100 text-red-800',
            'indicator' => 'bg-red-800'
        ],
        'warning' => [
            'container' => 'bg-yellow-100 text-yellow-800',
            'indicator' => 'bg-yellow-800'
        ],
        'light' => [
            'container' => 'bg-white text-gray-600',
            'indicator' => 'bg-gray-600'
        ],
    ];
    
    $config = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $config['container'] }}" {{ $attributes }}>
    <span class="size-1.5 inline-block rounded-full {{ $config['indicator'] }}"></span>
    {{ $text }}
</span>
