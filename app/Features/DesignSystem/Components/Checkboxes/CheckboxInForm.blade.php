{{--
Checkbox In Form - Checkbox dentro de un input de formulario
Uso: Checkbox estilizado como input de formulario con borde
Cuándo usar: Cuando necesites checkboxes que parezcan inputs de formulario
Cuándo NO usar: Cuando el checkbox simple sea suficiente
Ejemplo: <x-checkbox-in-form label="Default checkbox" checked="false" />
--}}

@props([
    'label' => 'Checkbox',
    'checkboxId' => null,
    'checkboxName' => null,
    'checked' => false,
    'disabled' => false,
    'layout' => 'horizontal', // 'horizontal' o 'vertical'
])

@php
    $uniqueId = $checkboxId ?? 'checkbox-' . uniqid();
    $nameAttr = $checkboxName ?? $uniqueId;
    $isVertical = $layout === 'vertical';
@endphp

<label 
    for="{{ $uniqueId }}" 
    class="{{ $isVertical ? 'max-w-xs' : '' }} flex p-3 w-full bg-white border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
>
    <input 
        type="checkbox" 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        class="shrink-0 mt-0.5 border-gray-400 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    >
    <span class="text-sm text-gray-500 ms-3">{{ $label }}</span>
</label>















