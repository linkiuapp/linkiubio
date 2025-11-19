{{--
Input Group Sizes - Diferentes tamaños de input group
Uso: Permite mostrar input groups en diferentes tamaños (small, default, large)
Cuándo usar: Cuando necesites variar el tamaño del input group según el contexto
Cuándo NO usar: Cuando el tamaño deba ser siempre el mismo
Ejemplo: <x-input-group-sizes size="small" addon-text="Small" />
--}}

@props([
    'size' => 'default', // 'small', 'default', 'large'
    'addonText' => '',
    'inputId' => null,
    'inputName' => null,
    'placeholder' => '',
])

@php
    $uniqueId = $inputId ?? 'input-group-' . uniqid();
    $inputNameAttr = $inputName ?? $uniqueId;
    
    $sizeClasses = [
        'small' => [
            'input' => 'py-1.5 sm:py-2 px-3 pe-11',
            'addon' => 'px-4',
        ],
        'default' => [
            'input' => 'py-2.5 sm:py-3 px-4 pe-11',
            'addon' => 'px-4',
        ],
        'large' => [
            'input' => 'py-3 px-4 pe-11 sm:p-5',
            'addon' => 'px-4',
        ],
    ];
    
    $classes = $sizeClasses[$size] ?? $sizeClasses['default'];
    $addonText = $addonText ?: ucfirst($size);
@endphp

<div class="flex rounded-lg">
    <span class="{{ $classes['addon'] }} inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-400 bg-gray-50 text-sm text-gray-500">
        {{ $addonText }}
    </span>
    <input 
        type="text" 
        class="{{ $classes['input'] }} block w-full border border-gray-400 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        id="{{ $uniqueId }}"
        name="{{ $inputNameAttr }}"
        placeholder="{{ $placeholder }}"
    >
</div>

