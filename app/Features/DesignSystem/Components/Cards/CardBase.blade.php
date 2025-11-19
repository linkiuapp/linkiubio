{{--
Card Base - Componente base para todos los tipos de cards basado en Preline UI
Uso: Card básico flexible que sirve como base para contenido estructurado
Cuándo usar: Contenedores de información, secciones de contenido, elementos agrupados
Cuándo NO usar: Elementos simples que no requieren agrupación visual
Ejemplo: <x-card-base size="md" title="Título" content="Contenido del card" />
--}}

@props([
    'size' => 'md', // sm, md, lg
    'title' => '',
    'content' => '',
    'footer' => '',
    'link' => '',
    'linkText' => 'Card link',
    'shadow' => 'sm', // none, sm, md, lg
    'hover' => false, // Efectos de hover
    'rounded' => 'xl', // lg, xl, 2xl
])

@php
    // Size classes (padding variations)
    $sizeClasses = [
        'sm' => 'p-4 md:p-5',
        'md' => 'p-4 md:p-7',
        'lg' => 'p-4 md:p-10',
    ];
    
    // Shadow classes
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
    ];
    
    // Get classes
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $shadowClass = $shadowClasses[$shadow] ?? $shadowClasses['sm'];
    $roundedClass = 'rounded-' . $rounded;
    
    // Hover classes
    $hoverClass = $hover ? 'hover:shadow-lg focus:shadow-lg transition' : '';
    
    // Container classes
    $containerClasses = "flex flex-col bg-white border border-gray-200 {$shadowClass} {$roundedClass} {$hoverClass}";
    
    // Link wrapper
    $isLink = !empty($link);
@endphp

@if($isLink)
    <a href="{{ $link }}" class="{{ $containerClasses }}" {{ $attributes }}>
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
            
            @if($footer)
                <p class="mt-5 caption text-gray-500">
                    {{ $footer }}
                </p>
            @endif
        </div>
    </a>
@else
    <div class="{{ $containerClasses }}" {{ $attributes }}>
        <div class="{{ $sizeClass }}">
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
            
            @if($footer)
                <p class="mt-5 caption text-gray-500">
                    {{ $footer }}
                </p>
            @endif
        </div>
    </div>
@endif
