{{--
Card With Alert - Card que incluye una alerta integrada en su diseño
Uso: Cards que necesitan mostrar información importante o alertas contextuales
Cuándo usar: Notificaciones importantes, advertencias, información destacada
Cuándo NO usar: Contenido normal sin alertas, información que no requiere énfasis
Ejemplo: <x-card-with-alert header="Featured" alertType="warning" alertMessage="Atención requerida!" title="Título del card" />
--}}

@props([
    'header' => '',
    'alertType' => 'info', // info, success, warning, error
    'alertMessage' => 'This is an alert box.',
    'alertBold' => 'Attention needed!',
    'title' => 'Card title',
    'content' => '',
    'link' => '',
    'linkText' => 'Card link',
])

@php
    // Alert type classes
    $alertClasses = [
        'info' => 'bg-blue-100 border-blue-200 text-blue-800',
        'success' => 'bg-green-100 border-green-200 text-green-800', 
        'warning' => 'bg-yellow-100 border-yellow-200 text-yellow-800',
        'error' => 'bg-red-100 border-red-200 text-red-800',
    ];
    
    $alertClass = $alertClasses[$alertType] ?? $alertClasses['info'];
@endphp

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" {{ $attributes }}>
    {{-- Header section --}}
    @if($header)
        <div class="border-b border-gray-200 rounded-t-xl py-3 px-4 md:py-4 md:px-5">
            <p class="mt-1 body-small text-gray-500">
                {{ $header }}
            </p>
        </div>
    @endif
    
    {{-- Alert section --}}
    <div class="{{ $alertClass }} border-b border-gray-200 body-small p-4">
        @if($alertBold)
            <span class="font-bold">{{ $alertBold }}</span>
        @endif
        {{ $alertMessage }}
    </div>
    
    {{-- Content section --}}
    <div class="p-4 md:p-5">
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
