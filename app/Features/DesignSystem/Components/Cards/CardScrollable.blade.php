{{--
Card Scrollable - Card con área de contenido scrolleable
Uso: Cards que contienen mucho contenido que necesita scroll interno
Cuándo usar: Contenido extenso, listas largas, texto que excede el espacio disponible
Cuándo NO usar: Contenido corto, cuando el scroll global de la página es suficiente
Ejemplo: <x-card-scrollable title="Contenido largo" height="320" />
--}}

@props([
    'title' => 'Card title',
    'content' => '',
    'height' => '320', // Altura en px (sin 'px')
    'showScrollbar' => true, // Si mostrar scrollbar estilizado
])

@php
    // Scrollbar classes
    $scrollbarClasses = $showScrollbar ? 
        '[&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300' : 
        '';
    
    // Height class
    $heightClass = 'h-' . $height;
    if (is_numeric($height)) {
        $heightClass = 'h-[' . $height . 'px]';
    }
@endphp

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" {{ $attributes }}>
    <div class="{{ $heightClass }} overflow-y-auto p-4 md:p-5 {{ $scrollbarClasses }}">
        @if($title)
            <h4 class="h4 text-gray-800">
                {{ $title }}
            </h4>
        @endif
        
        @if($content)
            <div class="mt-2 body-small text-gray-500">
                {!! $content !!}
            </div>
        @else
            <div class="mt-2 body-small text-gray-500">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
