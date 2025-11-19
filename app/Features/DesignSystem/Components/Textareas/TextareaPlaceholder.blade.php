{{--
Textarea Placeholder - Textarea básico con placeholder
Uso: Textarea simple con placeholder
Cuándo usar: Cuando necesites un campo de texto multilínea básico
Cuándo NO usar: Cuando necesites label o validación
Ejemplo: <x-textarea-placeholder placeholder="This is a textarea placeholder" rows="3" />
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
    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
    {{ $attributes }}
></textarea>















