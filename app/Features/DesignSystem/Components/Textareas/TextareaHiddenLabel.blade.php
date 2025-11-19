{{--
Textarea Hidden Label - Textarea con label oculto
Uso: Textarea con label oculto para accesibilidad
Cuándo usar: Cuando el placeholder sea suficiente pero necesites accesibilidad
Cuándo NO usar: Cuando el label deba ser visible
Ejemplo: <x-textarea-hidden-label label="Comment" placeholder="Say hi..." rows="3" />
--}}

@props([
    'label' => '',
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
@endphp

<div class="max-w-sm">
    <label for="{{ $uniqueId }}" class="sr-only">{{ $label }}</label>
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    ></textarea>
</div>















