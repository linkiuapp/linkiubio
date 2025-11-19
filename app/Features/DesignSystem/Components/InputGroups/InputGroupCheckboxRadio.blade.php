{{--
Input Group Checkbox Radio - Input con checkbox o radio en el addon
Uso: Permite agregar un checkbox o radio button dentro del addon del input group
Cuándo usar: Cuando necesites combinar un input con una opción de selección (checkbox/radio) en el addon
Cuándo NO usar: Cuando el checkbox/radio no esté relacionado visualmente con el input
Ejemplo: <x-input-group-checkbox-radio type="checkbox" input-id="my-input" placeholder="Checkbox" />
--}}

@props([
    'type' => 'checkbox', // 'checkbox' o 'radio'
    'inputId' => null,
    'inputName' => null,
    'placeholder' => '',
])

@php
    $uniqueId = $inputId ?? 'input-group-' . uniqid();
    $inputNameAttr = $inputName ?? $uniqueId;
    $isRadio = $type === 'radio';
@endphp

<div class="flex rounded-lg">
    <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-400 bg-gray-50 text-sm text-gray-500">
        <span class="flex">
            <input 
                type="{{ $type }}" 
                class="shrink-0 border-gray-200 {{ $isRadio ? 'rounded-full' : 'rounded-sm' }} text-blue-600 focus:ring-blue-500" 
                id="{{ $uniqueId }}"
                name="{{ $inputNameAttr }}"
            >
            <label for="{{ $uniqueId }}" class="sr-only">{{ ucfirst($type) }}</label>
        </span>
    </span>
    <input 
        type="text" 
        name="{{ $uniqueId }}-input" 
        id="{{ $uniqueId }}-input" 
        class="py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-400 rounded-e-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
        placeholder="{{ $placeholder }}"
    >
</div>

