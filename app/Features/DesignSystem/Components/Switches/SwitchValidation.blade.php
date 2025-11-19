{{--
Switch Validation - Switch con estados de validación
Uso: Switch con estados de validación (valid/invalid)
Cuándo usar: Cuando necesites indicar validación del formulario
Cuándo NO usar: Cuando el switch normal sea suficiente
Ejemplo: <x-switch-validation type="valid" label="Valid switch" checked="true" />
--}}

@props([
    'type' => 'valid', // 'valid' o 'invalid'
    'label' => '',
    'switchId' => null,
    'switchName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $switchId ?? 'switch-' . uniqid();
    $nameAttr = $switchName ?? $uniqueId;
    $isValid = $type === 'valid';
    $colorClass = $isValid ? 'peer-checked:bg-teal-600' : 'peer-checked:bg-red-600';
@endphp

<div class="flex items-center gap-x-3">
    <label for="{{ $uniqueId }}" class="relative inline-block w-11 h-6 cursor-pointer">
        <input 
            type="checkbox" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            class="peer sr-only"
            {{ $attributes }}
        >
        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out {{ $colorClass }} peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
    </label>
    @if($label)
        <label for="{{ $uniqueId }}" class="text-sm text-gray-500">{{ $label }}</label>
    @endif
</div>















