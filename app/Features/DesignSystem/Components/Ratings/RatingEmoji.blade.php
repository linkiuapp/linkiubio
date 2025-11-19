{{--
Rating Emoji - Sistema de calificación con emojis
Uso: Feedback rápido, satisfacción del cliente, encuestas
Cuándo usar: Cuando necesites una forma visual y rápida de obtener feedback
Cuándo NO usar: Cuando necesites calificaciones numéricas precisas
Ejemplo: <x-rating-emoji :emojis="['😔', '😐️', '🤩']" />
--}}

@props([
    'emojis' => ['😔', '😐️', '🤩'], // Array de emojis
    'size' => 'size-10', // Tamaño de los botones
    'selectedIndex' => null, // Índice del emoji seleccionado (null si ninguno)
    'onSelect' => null, // Callback cuando se selecciona un emoji
])

<div class="flex justify-center items-center gap-x-2" {{ $attributes }}>
    @foreach($emojis as $index => $emoji)
        @php
            $isSelected = $selectedIndex === $index;
            $buttonClass = $isSelected 
                ? "{$size} inline-flex justify-center items-center text-2xl rounded-full bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none transition-colors" 
                : "{$size} inline-flex justify-center items-center text-2xl rounded-full hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none transition-colors";
        @endphp
        <button 
            type="button" 
            class="{{ $buttonClass }}"
            data-index="{{ $index }}"
            @if($onSelect)
                onclick="(function() { {{ $onSelect }}({{ $index }}, '{{ $emoji }}'); })()"
            @endif
        >
            {{ $emoji }}
        </button>
    @endforeach
</div>

