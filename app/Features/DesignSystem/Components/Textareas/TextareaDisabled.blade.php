{{--
Textarea Disabled - Textarea deshabilitado
Uso: Textarea que no puede ser usado
Cuándo usar: Cuando el campo deba estar deshabilitado por condiciones del formulario
Cuándo NO usar: Cuando el campo deba ser funcional
Ejemplo: <x-textarea-disabled placeholder="Disabled textarea" rows="3" />
--}}

@props([
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
    'readonly' => false,
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
    disabled
    @if($readonly) readonly @endif
    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
    {{ $attributes }}
></textarea>















