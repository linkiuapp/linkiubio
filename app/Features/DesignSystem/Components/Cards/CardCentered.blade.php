{{--
Card Centered - Card con contenido centrado vertical y horizontalmente
Uso: Contenido principal centrado, CTAs importantes, mensajes destacados
Cuándo usar: Contenido que debe ser el foco principal, acciones importantes
Cuándo NO usar: Contenido extenso, listas, información de apoyo
Ejemplo: <x-card-centered title="Título centrado" content="Mensaje principal" link="#" linkText="Acción principal" />
--}}

@props([
    'title' => '',
    'content' => '',
    'link' => '',
    'linkText' => 'Card link',
    'height' => '240', // Altura mínima en px (sin 'px')
    'icon' => '', // Lucide icon opcional
])

@php
    // Height class
    $heightClass = 'min-h-' . $height;
    if (is_numeric($height)) {
        $heightClass = 'min-h-[' . $height . 'px]';
    }
@endphp

<div class="{{ $heightClass }} flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" {{ $attributes }}>
    <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5 text-center">
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-8 h-8 text-blue-600 mb-3"></i>
        @endif
        
        @if($title)
            <h4 class="h4 text-gray-800">
                {{ $title }}
            </h4>
        @endif
        
        @if($content)
            <p class="mt-2 body-small text-gray-500">
                {{ $content }}
            </p>
        @endif
        
        {{ $slot }}
        
        @if($link && $linkText)
            <a class="mt-3 inline-flex items-center gap-x-1 body-small font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-700 hover:underline focus:underline focus:outline-none focus:text-blue-700" 
               href="{{ $link }}">
                {{ $linkText }}
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @endif
    </div>
</div>
