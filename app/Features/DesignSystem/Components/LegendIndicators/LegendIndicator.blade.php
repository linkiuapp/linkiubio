{{--
Legend Indicator - Indicador de leyenda con punto de color
Uso: Leyendas de gráficos, indicadores de estado, categorías visuales
Cuándo usar: Cuando necesites mostrar un indicador visual simple con texto
Cuándo NO usar: Cuando necesites indicadores más complejos o interactivos
Ejemplo: <x-legend-indicator color="blue" text="Leyenda" />
--}}

@props([
    'color' => 'gray', // gray, dark, red, yellow, green, blue, indigo, purple, pink, light
    'text' => 'Legend indicator',
    'textSize' => 'body-small',
    'textColor' => 'text-gray-600',
    'size' => 'size-2', // Tamaño del punto (size-2, size-3, size-4)
])

@php
    $dotColor = match($color) {
        'dark' => 'bg-gray-800',
        'gray' => 'bg-gray-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'green' => 'bg-green-500',
        'blue' => 'bg-blue-600',
        'indigo' => 'bg-indigo-500',
        'purple' => 'bg-purple-500',
        'pink' => 'bg-pink-500',
        'light' => 'bg-white',
        default => 'bg-gray-500',
    };
@endphp

<div class="inline-flex items-center" {{ $attributes }}>
    <span class="{{ $size }} inline-block {{ $dotColor }} rounded-full me-2"></span>
    <span class="{{ $textSize }} {{ $textColor }}">{{ $text }}</span>
</div>















