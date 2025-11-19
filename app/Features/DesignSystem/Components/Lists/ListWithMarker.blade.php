{{--
List With Marker - Lista con marcador personalizado de color
Uso: Listas con marcadores de color personalizado
Cuándo usar: Cuando necesites destacar los marcadores con un color específico
Cuándo NO usar: Cuando necesites listas simples o con iconos
Ejemplo: <x-list-with-marker color="blue" :items="['FAQ', 'License', 'Terms']" />
--}}

@props([
    'color' => 'blue', // blue, red, green, yellow, gray, etc.
    'items' => [],
    'spacing' => 'space-y-2',
    'textColor' => 'text-gray-600',
    'textSize' => 'body-small',
])

@php
    $markerColor = match($color) {
        'blue' => 'marker:text-blue-600',
        'red' => 'marker:text-red-600',
        'green' => 'marker:text-green-600',
        'yellow' => 'marker:text-yellow-600',
        'gray' => 'marker:text-gray-600',
        default => 'marker:text-blue-600',
    };
    
    $containerClasses = "list-disc ps-5 {$spacing} {$textSize} {$textColor} {$markerColor}";
@endphp

<ul class="{{ $containerClasses }}" {{ $attributes }}>
    @foreach($items as $item)
        <li>{{ $item }}</li>
    @endforeach
</ul>















