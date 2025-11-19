{{--
Card Image - Card con imagen en diferentes posiciones (top, bottom) y efectos opcionales
Uso: Cards que destacan contenido visual, productos, artículos con imágenes
Cuándo usar: Contenido visual importante, productos, galerías, artículos
Cuándo NO usar: Contenido puramente textual, cards de información
Ejemplo: <x-card-image image="/path/to/image.jpg" position="top" title="Título" hover="scale" />
--}}

@props([
    'image' => '',
    'imageAlt' => 'Card Image',
    'position' => 'top', // top, bottom
    'title' => 'Card title',
    'content' => '',
    'footer' => '',
    'link' => '',
    'linkText' => '',
    'hover' => 'shadow', // none, shadow, scale
    'size' => 'md', // sm, md, lg (para padding)
])

@php
    // Size classes
    $sizeClasses = [
        'sm' => 'p-4 md:p-5',
        'md' => 'p-4 md:p-5',
        'lg' => 'p-4 md:p-7',
    ];
    
    // Hover effect classes
    $hoverClasses = [
        'none' => '',
        'shadow' => 'hover:shadow-lg focus:shadow-lg transition',
        'scale' => 'group hover:shadow-lg focus:shadow-lg transition overflow-hidden',
    ];
    
    // Image classes based on hover effect
    $imageClasses = [
        'none' => 'w-full h-auto',
        'shadow' => 'w-full h-auto',
        'scale' => 'w-full h-full absolute top-0 start-0 object-cover group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out',
    ];
    
    // Image container classes for scale effect
    $imageContainerClasses = $hover === 'scale' 
        ? 'relative pt-[45%] sm:pt-[50%] lg:pt-[55%] overflow-hidden'
        : '';
    
    // Image rounding
    $imageRounding = $position === 'top' ? 'rounded-t-xl' : 'rounded-b-xl';
    
    // Get classes
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $hoverClass = $hoverClasses[$hover] ?? $hoverClasses['shadow'];
    $imageClass = $imageClasses[$hover] ?? $imageClasses['shadow'];
    
    // Container element
    $element = $link ? 'a' : 'div';
    $linkAttributes = $link ? "href=\"{$link}\"" : '';
@endphp

<{{ $element }} class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl {{ $hoverClass }}" @if($link) {!! $linkAttributes !!} @endif {{ $attributes }}>
    {{-- Image at top --}}
    @if($image && $position === 'top')
        @if($hover === 'scale')
            <div class="{{ $imageContainerClasses }} {{ $imageRounding }}">
                <img class="{{ $imageClass }} {{ $imageRounding }}" 
                     src="{{ $image }}" 
                     alt="{{ $imageAlt }}">
            </div>
        @else
            <img class="{{ $imageClass }} {{ $imageRounding }}" 
                 src="{{ $image }}" 
                 alt="{{ $imageAlt }}">
        @endif
    @endif
    
    {{-- Content section --}}
    <div class="{{ $sizeClass }}">
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
        
        @if($linkText && $link && !($link && $element === 'a'))
            <a class="mt-3 inline-flex items-center gap-x-1 body-small font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-700 hover:underline focus:underline focus:outline-none focus:text-blue-700" 
               href="{{ $link }}">
                {{ $linkText }}
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @endif
        
        @if($footer)
            <p class="mt-5 caption text-gray-500">
                {{ $footer }}
            </p>
        @endif
    </div>
    
    {{-- Image at bottom --}}
    @if($image && $position === 'bottom')
        <img class="{{ $imageClass }} {{ $imageRounding }}" 
             src="{{ $image }}" 
             alt="{{ $imageAlt }}">
    @endif
</{{ $element }}>
