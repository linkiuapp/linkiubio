{{--
Card Horizontal - Card con layout horizontal que incluye imagen y contenido lado a lado
Uso: Cards con imagen prominente, productos, artículos con media visual
Cuándo usar: Contenido que se beneficia de imagen lateral, productos, noticias
Cuándo NO usar: Contenido solo de texto, espacios estrechos móviles
Ejemplo: <x-card-horizontal image="/path/to/image.jpg" title="Título" content="Descripción" />
--}}

@props([
    'image' => '',
    'imageAlt' => 'Card Image',
    'title' => 'Card title',
    'content' => '',
    'footer' => '',
    'link' => '',
    'imagePosition' => 'left', // left, right
    'imageWidth' => 'sm:max-w-48 md:max-w-60', // Tailwind width classes
])

@php
    // Image position classes
    $imageOrder = $imagePosition === 'right' ? 'sm:order-last' : '';
    $imageRounding = $imagePosition === 'left' ? 'rounded-t-xl sm:rounded-s-xl sm:rounded-se-none' : 'rounded-t-xl sm:rounded-e-xl sm:rounded-ss-none';
    
    // Container element
    $element = $link ? 'a' : 'div';
    $linkAttributes = $link ? "href=\"{$link}\"" : '';
@endphp

<{{ $element }} class="bg-white border border-gray-200 rounded-xl shadow-sm sm:flex @if($link) hover:shadow-md transition-shadow @endif" @if($link) {!! $linkAttributes !!} @endif {{ $attributes }}>
    {{-- Image section --}}
    @if($image)
        <div class="shrink-0 relative w-full {{ $imageRounding }} overflow-hidden pt-[20%] {{ $imageWidth }} {{ $imageOrder }}">
            <img class="w-full h-full absolute top-0 start-0 object-cover" 
                 src="{{ $image }}" 
                 alt="{{ $imageAlt }}">
        </div>
    @endif
    
    {{-- Content section --}}
    <div class="flex flex-wrap">
        <div class="p-4 flex flex-col h-full sm:p-5">
            @if($title)
                <h4 class="h4 text-gray-800">
                    {{ $title }}
                </h4>
            @endif
            
            @if($content)
                <p class="mt-1 body-small text-gray-500">
                    {{ $content }}
                </p>
            @endif
            
            {{ $slot }}
            
            @if($footer)
                <div class="mt-5 sm:mt-auto">
                    <p class="caption text-gray-500">
                        {{ $footer }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</{{ $element }}>
