{{--
Textarea Gray - Textarea con fondo gris
Uso: Textarea con variante de fondo gris
Cuándo usar: Cuando necesites diferenciar visualmente el campo
Cuándo NO usar: Cuando el diseño requiera bordes visibles
Ejemplo: <x-textarea-gray placeholder="This is a textarea placeholder" rows="3" />
--}}

@props([
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
@endphp

<textarea 
    id="{{ $uniqueId }}"
    name="{{ $nameAttr }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    class="py-2 px-3 sm:py-3 sm:px-4 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
    {{ $attributes }}
></textarea>















