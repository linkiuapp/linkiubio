{{--
Switch With Description - Switch con descripción
Uso: Switch con texto descriptivo al lado
Cuándo usar: Cuando necesites mostrar el estado o contexto del switch
Cuándo NO usar: Cuando el switch sea autoexplicativo
Ejemplo: <x-switch-with-description label="Unchecked" checked="false" />
--}}

@props([
    'label' => '',
    'labelPosition' => 'right', // 'left' o 'right'
    'switchId' => null,
    'switchName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $switchId ?? 'switch-' . uniqid();
    $nameAttr = $switchName ?? $uniqueId;
    $isLabelLeft = $labelPosition === 'left';
@endphp

<div class="flex items-center gap-x-3">
    @if($isLabelLeft)
        <label for="{{ $uniqueId }}" class="text-sm text-gray-500">{{ $label }}</label>
    @endif
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
    @if(!$isLabelLeft)
        <label for="{{ $uniqueId }}" class="text-sm text-gray-500">{{ $label }}</label>
    @endif
</div>















