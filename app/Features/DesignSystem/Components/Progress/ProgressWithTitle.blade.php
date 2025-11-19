{{--
Progress With Title - Barra de progreso con título y porcentaje
Uso: Progreso con descripción, tareas con título
Cuándo usar: Cuando necesites mostrar un título o descripción junto al progreso
Cuándo NO usar: Cuando necesites barras simples sin título
Ejemplo: <x-progress-with-title title="Progress title" :value="25" />
--}}

@props([
    'title' => 'Progress title',
    'value' => 0,
    'color' => 'blue',
    'height' => 'h-2',
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

<div {{ $attributes }}>
    <div class="mb-2 flex justify-between items-center">
        <h3 class="body-small font-semibold text-gray-800">{{ $title }}</h3>
        <span class="body-small text-gray-800">{{ $value }}%</span>
    </div>
    <div class="flex w-full {{ $height }} bg-gray-200 rounded-full overflow-hidden" 
         role="progressbar" 
         aria-valuenow="{{ $value }}" 
         aria-valuemin="0" 
         aria-valuemax="100">
        <div class="flex flex-col justify-center rounded-full overflow-hidden {{ $barColor }} text-xs text-white text-center whitespace-nowrap transition duration-500" 
             style="width: {{ $value }}%"></div>
    </div>
</div>















