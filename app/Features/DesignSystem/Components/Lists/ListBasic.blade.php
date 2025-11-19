{{--
List Basic - Lista básica con estilos (disc, decimal, none)
Uso: Listas simples de contenido, índices, enumeraciones
Cuándo usar: Cuando necesites mostrar contenido en formato de lista ordenada o con viñetas
Cuándo NO usar: Cuando necesites listas interactivas o con iconos personalizados
Ejemplo: <x-list-basic type="disc" :items="['Item 1', 'Item 2', 'Item 3']" />
--}}

@props([
    'type' => 'disc', // disc, decimal, none
    'items' => [], // Array de items
    'spacing' => 'space-y-2', // Espaciado entre items
    'textColor' => 'text-gray-800',
    'textSize' => 'body-small', // Tamaño de texto
])

@php
    $listClasses = match($type) {
        'disc' => 'list-disc',
        'decimal' => 'list-decimal',
        'none' => 'list-none',
        default => 'list-disc',
    };
    
    $containerClasses = "{$listClasses} list-inside {$spacing} {$textColor} {$textSize}";
@endphp

@if($type === 'decimal')
    <ol class="{{ $containerClasses }}" {{ $attributes }}>
        @foreach($items as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ol>
@else
    <ul class="{{ $containerClasses }}" {{ $attributes }}>
        @foreach($items as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
@endif















