{{--
Switch Basic - Switch básico
Uso: Toggle switch básico
Cuándo usar: Cuando necesites un toggle simple sin descripción
Cuándo NO usar: Cuando necesites mostrar texto descriptivo
Ejemplo: <x-switch-basic checked="false" />
--}}

@props([
    'switchId' => null,
    'switchName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $switchId ?? 'switch-' . uniqid();
    $nameAttr = $switchName ?? $uniqueId;
@endphp

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
    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
</label>















