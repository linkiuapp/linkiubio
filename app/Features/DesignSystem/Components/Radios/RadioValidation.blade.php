{{--
Radio Validation - Radio con estados de validación
Uso: Radio con estados de error o éxito
Cuándo usar: Cuando necesites indicar validación del formulario
Cuándo NO usar: Cuando el radio normal sea suficiente
Ejemplo: <x-radio-validation name="radio-states" type="error" label="This is an error radio" />
--}}

@props([
    'type' => 'error', // 'error' o 'success'
    'label' => '',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $radioId ?? 'radio-' . uniqid();
    $nameAttr = $radioName ?? 'radio-states-' . uniqid();
    $isError = $type === 'error';
    $colorClass = $isError ? 'text-red-600 focus:ring-red-500 checked:border-red-500 checked:bg-red-500' : 'text-teal-600 focus:ring-teal-500 checked:border-teal-500 checked:bg-teal-500';
    $labelColorClass = $isError ? 'text-red-500' : 'text-teal-500';
@endphp

<div>
    <label for="{{ $uniqueId }}" class="flex items-center space-x-3">
        <input 
            type="radio" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            class="shrink-0 mt-0.5 border-gray-400 rounded-full {{ $colorClass }} disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}
        >
        <span class="text-sm {{ $labelColorClass }}">{{ $label }}</span>
    </label>
</div>















