{{--
Badge Suave - Estilos de badges de colores suaves predefinidos
Uso: Badges con colores suaves para una apariencia más sutil y elegante
Cuándo usar: Información secundaria, etiquetas decorativas, clasificaciones no críticas
Cuándo NO usar: Alertas importantes, estados críticos que requieren máxima atención
Ejemplo: <x-badge-soft type="success" text="Completado" />
--}}

@props([
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
])

@php
    $typeClasses = [
        'dark' => 'bg-gray-100 text-gray-800',
        'secondary' => 'bg-gray-50 text-gray-500',
        'success' => 'bg-teal-100 text-teal-800',
        'info' => 'bg-blue-100 text-blue-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'light' => 'bg-white text-gray-600',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $classes }}" {{ $attributes }}>
    {{ $text }}
</span>
