{{--
Input Group Basic Addon - Addon básico al inicio
Uso: Permite agregar un addon de texto al inicio del input group
Cuándo usar: Cuando necesites un prefijo de texto relacionado con el input (ej: "http://", "$", etc.)
Cuándo NO usar: Cuando el addon no sea texto estático
Ejemplo: <x-input-group-basic-addon addon-text="http://" input-id="url" placeholder="www.example.com" />
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
    <label for="{{ $uniqueId }}" class="block text-sm text-gray-700 font-medium">{{ $label }}</label>
@endif
<div class="flex rounded-lg">
    <div class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-400 bg-gray-50">
        <span class="text-sm text-gray-500">{{ $addonText }}</span>
    </div>
    <input 
        type="text" 
        name="{{ $inputNameAttr }}" 
        id="{{ $uniqueId }}" 
        class="py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-400 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $placeholder }}"
    >
</div>

