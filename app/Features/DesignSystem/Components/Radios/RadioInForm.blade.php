{{--
Radio In Form - Radio dentro de un input de formulario
Uso: Radio estilizado como input de formulario con borde
Cuándo usar: Cuando necesites radios que parezcan inputs de formulario
Cuándo NO usar: Cuando el radio simple sea suficiente
Ejemplo: <x-radio-in-form name="radio-form" label="Default radio" checked="false" />
--}}

@props([
    'label' => 'Radio',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
    'layout' => 'horizontal', // 'horizontal' o 'vertical'
])

@php
    $uniqueId = $radioId ?? 'radio-' . uniqid();
    $nameAttr = $radioName ?? 'radio-form-' . uniqid();
    $isVertical = $layout === 'vertical';
@endphp

<label 
    for="{{ $uniqueId }}" 
    class="{{ $isVertical ? 'max-w-xs' : '' }} flex p-3 w-full bg-white border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
>
    <input 
        type="radio" 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        class="shrink-0 mt-0.5 border-gray-400 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    >
    <span class="text-sm text-gray-500 ms-3">{{ $label }}</span>
</label>















