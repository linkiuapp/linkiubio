{{--
Checkbox Validation - Checkbox con estados de validación
Uso: Checkbox con estados de error o éxito
Cuándo usar: Cuando necesites indicar validación del formulario
Cuándo NO usar: Cuando el checkbox normal sea suficiente
Ejemplo: <x-checkbox-validation type="error" label="This is an error checkbox" />
--}}

@props([
    'type' => 'error', // 'error' o 'success'
    'label' => '',
    'checkboxId' => null,
    'checkboxName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $checkboxId ?? 'checkbox-' . uniqid();
    $nameAttr = $checkboxName ?? $uniqueId;
    $isError = $type === 'error';
    $colorClass = $isError ? 'text-red-600 focus:ring-red-500 checked:border-red-500 checked:bg-red-500' : 'text-teal-600 focus:ring-teal-500 checked:border-teal-500 checked:bg-teal-500';
    $labelColorClass = $isError ? 'text-red-500' : 'text-teal-500';
@endphp

<div>
    <label for="{{ $uniqueId }}" class="flex items-center space-x-3">
        <input 
            type="checkbox" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            class="shrink-0 mt-0.5 border-gray-400 rounded-sm {{ $colorClass }} disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}
        >
        <span class="text-sm {{ $labelColorClass }}">{{ $label }}</span>
    </label>
</div>















