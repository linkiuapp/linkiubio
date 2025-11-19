{{--
Progress Vertical - Barra de progreso vertical
Uso: Progreso vertical, indicadores de altura, gráficos verticales
Cuándo usar: Cuando necesites mostrar progreso en orientación vertical
Cuándo NO usar: Cuando necesites barras horizontales estándar
Ejemplo: <x-progress-vertical :value="25" height="h-32" />
--}}

@props([
    'value' => 0,
    'color' => 'blue',
    'height' => 'h-32', // Altura del contenedor
    'width' => 'w-2', // Ancho de la barra
])

@php
    $barColor = match($color) {
        'blue' => 'bg-blue-600',
        'gray' => 'bg-gray-500',
        'dark' => 'bg-gray-800',
        'green' => 'bg-teal-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'white' => 'bg-white',
        default => 'bg-blue-600',
    };
    
    $value = max(0, min(100, $value));
@endphp

<div class="flex flex-col flex-nowrap justify-end {{ $width }} {{ $height }} bg-gray-200 rounded-full overflow-hidden" 
     role="progressbar" 
     aria-valuenow="{{ $value }}" 
     aria-valuemin="0" 
     aria-valuemax="100"
     {{ $attributes }}>
    <div class="rounded-full overflow-hidden {{ $barColor }}" style="height: {{ $value }}%"></div>
</div>















