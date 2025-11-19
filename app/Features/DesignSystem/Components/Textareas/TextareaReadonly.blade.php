{{--
Textarea Readonly - Textarea de solo lectura
Uso: Textarea que no puede ser modificado
Cuándo usar: Cuando necesites mostrar contenido que no debe ser editado
Cuándo NO usar: Cuando el contenido deba ser editable
Ejemplo: <x-textarea-readonly placeholder="Readonly" rows="3" />
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
    readonly
    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
    {{ $attributes }}
></textarea>















