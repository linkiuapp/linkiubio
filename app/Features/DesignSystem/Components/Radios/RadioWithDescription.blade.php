{{--
Radio With Description - Radio con título y descripción
Uso: Radio con título y texto descriptivo debajo
Cuándo usar: Cuando necesites proporcionar contexto adicional sobre la opción
Cuándo NO usar: Cuando el label simple sea suficiente
Ejemplo: <x-radio-with-description name="actions" title="Delete" description="Notify me when this action happens." checked="true" />
--}}

@props([
    'title' => '',
    'description' => '',
    'radioId' => null,
    'radioName' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $uniqueId = $radioId ?? 'radio-' . uniqid();
    $nameAttr = $radioName ?? 'radio-group-' . uniqid();
    $descriptionId = $uniqueId . '-description';
@endphp

<div class="relative flex items-start">
    <div class="flex items-center h-5 mt-1">
        <input 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            type="radio"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            aria-describedby="{{ $descriptionId }}"
            class="border-gray-400 rounded-full text-blue-600 focus:ring-blue-500"
            {{ $attributes }}
        >
    </div>
    <label for="{{ $uniqueId }}" class="ms-3">
        <span class="block text-sm font-semibold text-gray-800">{{ $title }}</span>
        <span id="{{ $descriptionId }}" class="block text-sm text-gray-600">{{ $description }}</span>
    </label>
</div>















