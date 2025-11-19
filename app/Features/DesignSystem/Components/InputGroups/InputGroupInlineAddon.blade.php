{{--
Input Group Inline Addon - Addon dentro del input
Uso: Permite agregar un addon dentro del input (ej: "http://" antes del texto)
Cuándo usar: Cuando necesites un prefijo visual dentro del mismo campo de input
Cuándo NO usar: Cuando el addon deba ser parte del borde del input
Ejemplo: <x-input-group-inline-addon addon-text="http://" input-id="url" placeholder="www.example.com" />
--}}

@props([
    'addonText' => 'http://',
    'inputId' => null,
    'inputName' => null,
    'label' => null,
    'placeholder' => '',
])

@php
    $uniqueId = $inputId ?? 'input-group-' . uniqid();
    $inputNameAttr = $inputName ?? $uniqueId;
@endphp

@if($label)
    <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
@endif
<div class="relative">
    <input 
        type="text" 
        id="{{ $uniqueId }}" 
        name="{{ $inputNameAttr }}" 
        class="py-2.5 sm:py-3 px-4 ps-16 block w-full border border-gray-400 rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $placeholder }}"
    >
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
        <span class="text-sm text-gray-500">{{ $addonText }}</span>
    </div>
</div>

