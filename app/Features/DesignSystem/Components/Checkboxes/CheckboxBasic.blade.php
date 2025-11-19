{{--
Checkbox Basic - Checkbox básico
Uso: Checkbox con label simple
Cuándo usar: Cuando necesites una opción de selección simple
Cuándo NO usar: Cuando necesites checkbox con descripción o dentro de formularios complejos
Ejemplo: <x-checkbox-basic label="Default checkbox" checked="false" />
--}}

@props([
    'label' => 'Checkbox',
    'checkboxId' => null,
    'checkboxName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $checkboxId ?? 'checkbox-' . uniqid();
    $nameAttr = $checkboxName ?? $uniqueId;
@endphp

<div class="flex {{ $disabled ? 'opacity-40' : '' }}">
    <input 
        type="checkbox" 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        class="shrink-0 mt-0.5 border-gray-400 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    >
    <label for="{{ $uniqueId }}" class="text-sm text-gray-500 ms-3">{{ $label }}</label>
</div>















