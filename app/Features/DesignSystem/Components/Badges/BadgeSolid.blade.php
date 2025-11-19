{{--
Badge Sólido - La forma por defecto de badges de colores sólidos
Uso: Badges con colores sólidos para máxima visibilidad y contraste
Cuándo usar: Estados importantes, categorías principales, información crítica
Cuándo NO usar: Elementos decorativos, información secundaria que no requiere énfasis
Ejemplo: <x-badge-solid type="success" text="Activo" />
--}}

@props([
    'type' => 'info', // dark, secondary, success, info, error, warning, light
    'text' => 'Badge',
])

@php
    $typeClasses = [
        'dark' => 'bg-gray-800 text-white',
        'secondary' => 'bg-gray-500 text-white',
        'success' => 'bg-teal-500 text-white',
        'info' => 'bg-blue-600 text-white',
        'error' => 'bg-red-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'light' => 'bg-white text-gray-600',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $classes }}" {{ $attributes }}>
    {{ $text }}
</span>
