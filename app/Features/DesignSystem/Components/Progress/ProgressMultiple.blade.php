{{--
Progress Multiple - Barra de progreso con múltiples segmentos
Uso: Progreso con diferentes categorías, estadísticas segmentadas
Cuándo usar: Cuando necesites mostrar múltiples valores en una sola barra
Cuándo NO usar: Cuando necesites una sola barra de progreso
Ejemplo: <x-progress-multiple :segments="[['value' => 25, 'color' => 'blue'], ['value' => 15, 'color' => 'blue']]" />
--}}

@props([
    'segments' => [], // Array de objetos: ['value' => int, 'color' => string]
    'height' => 'h-1.5',
])

@php
    $colorMap = [
        'blue' => 'bg-blue-400',
        'blue-dark' => 'bg-blue-700',
        'gray' => 'bg-gray-800',
        'orange' => 'bg-orange-600',
        'green' => 'bg-teal-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
    ];
@endphp

<div class="flex w-full {{ $height }} bg-gray-200 rounded-full overflow-hidden" {{ $attributes }}>
    @foreach($segments as $segment)
        @php
            $value = max(0, min(100, $segment['value'] ?? 0));
            $color = $colorMap[$segment['color'] ?? 'blue'] ?? 'bg-blue-400';
        @endphp
        <div class="flex flex-col justify-center overflow-hidden {{ $color }} text-xs text-white text-center whitespace-nowrap" 
             style="width: {{ $value }}%" 
             role="progressbar" 
             aria-valuenow="{{ $value }}" 
             aria-valuemin="0" 
             aria-valuemax="100"></div>
    @endforeach
</div>















