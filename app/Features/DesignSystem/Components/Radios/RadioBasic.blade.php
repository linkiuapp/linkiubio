{{--
Radio Basic - Radio básico
Uso: Radio button con label simple
Cuándo usar: Cuando necesites una opción única de una lista
Cuándo NO usar: Cuando necesites múltiples selecciones (usa checkbox)
Ejemplo: <x-radio-basic name="radio-group" label="Default radio" checked="false" />
--}}

@props([
    'label' => 'Radio',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $radioId ?? 'radio-' . uniqid();
    $nameAttr = $radioName ?? 'radio-group-' . uniqid();
@endphp

<div class="flex {{ $disabled ? 'opacity-40' : '' }}">
    <input 
        type="radio" 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        class="shrink-0 mt-0.5 border-gray-400 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    >
    <label for="{{ $uniqueId }}" class="text-sm text-gray-500 ms-2">{{ $label }}</label>
</div>















