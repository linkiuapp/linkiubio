{{--
Progress Basic - Barra de progreso básica
Uso: Indicadores de progreso, cargas, procesos
Cuándo usar: Cuando necesites mostrar el progreso de una tarea o proceso
Cuándo NO usar: Cuando necesites barras complejas con múltiples segmentos
Ejemplo: <x-progress-basic :value="25" />
--}}

@props([
    'value' => 0, // Valor del progreso (0-100)
    'color' => 'blue', // blue, gray, dark, green, red, yellow, white
    'height' => 'h-1.5', // Altura: h-1.5, h-2, h-4
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
    
    $value = max(0, min(100, $value)); // Asegurar que esté entre 0 y 100
@endphp

<div class="flex w-full {{ $height }} bg-gray-200 rounded-full overflow-hidden" 
     role="progressbar" 
     aria-valuenow="{{ $value }}" 
     aria-valuemin="0" 
     aria-valuemax="100"
     {{ $attributes }}>
    <div class="flex flex-col justify-center rounded-full overflow-hidden {{ $barColor }} text-xs text-white text-center whitespace-nowrap transition duration-500" 
         style="width: {{ $value }}%"></div>
</div>















