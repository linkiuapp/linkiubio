{{--
Input Group Leading Button - Input con botón al inicio
Uso: Permite agregar un botón al inicio del input group
Cuándo usar: Cuando necesites una acción primaria relacionada con el input (ej: búsqueda)
Cuándo NO usar: Cuando el botón no tenga relación directa con el input
Ejemplo: <x-input-group-leading-button button-text="Buscar" input-id="search" />
--}}

@props([
    'buttonText' => 'Button',
    'buttonIcon' => null, // Nombre del icono Lucide
    'inputId' => null,
    'inputName' => null,
    'inputPlaceholder' => '',
    'trailingAddon' => null, // Texto para addon al final (ej: "http://")
    'trailingIcon' => null, // Nombre del icono Lucide al final
    'buttonSize' => 'default', // 'small', 'default', 'large'
])

@php
    $uniqueId = $inputId ?? 'input-group-' . uniqid();
    $inputNameAttr = $inputName ?? $uniqueId;
    $hasIcon = !empty($buttonIcon);
    $hasTrailing = !empty($trailingAddon) || !empty($trailingIcon);
    
    $buttonSizeClasses = [
        'small' => 'size-11.5',
        'default' => $hasIcon && empty($buttonText) ? 'size-11.5' : 'py-3 px-4',
        'large' => 'py-3 px-4'
    ];
    $buttonClass = $buttonSizeClasses[$buttonSize] ?? $buttonSizeClasses['default'];
@endphp

<div class="{{ $hasTrailing ? 'relative flex' : 'flex' }} rounded-lg">
    <button 
        type="button" 
        class="{{ $buttonClass }} shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
    >
        @if($hasIcon)
            <i data-lucide="{{ $buttonIcon }}" class="shrink-0 size-4"></i>
        @endif
        @if(!$hasIcon || !empty($buttonText))
            {{ $buttonText }}
        @endif
    </button>
    <input 
        type="text" 
        id="{{ $uniqueId }}" 
        name="{{ $inputNameAttr }}" 
        class="py-2.5 sm:py-3 px-4 {{ $hasTrailing ? 'pe-11' : '' }} block w-full border border-gray-400 {{ $hasTrailing ? 'rounded-0' : 'rounded-e-lg' }} sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $inputPlaceholder }}"
    >
    @if($hasTrailing)
        @if(!empty($trailingAddon))
            <span class="px-4 inline-flex items-center min-w-fit rounded-e-md border border-s-0 border-gray-400 bg-gray-50 text-sm">
                <span class="text-sm text-gray-500">{{ $trailingAddon }}</span>
            </span>
        @elseif(!empty($trailingIcon))
            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4">
                <i data-lucide="{{ $trailingIcon }}" class="shrink-0 size-4 text-gray-400"></i>
            </div>
        @endif
    @endif
</div>

