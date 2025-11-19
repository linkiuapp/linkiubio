{{--
Textarea With Label - Textarea con label
Uso: Textarea con label visible
Cuándo usar: Cuando necesites identificar claramente el campo
Cuándo NO usar: Cuando el placeholder sea suficiente para identificar el campo
Ejemplo: <x-textarea-with-label label="Comment" placeholder="Say hi..." rows="3" />
--}}

@props([
    'label' => '',
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
    'containerClass' => 'max-w-sm',
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
@endphp

<div class="{{ $containerClass }}">
    <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    >{{ trim($slot) ?: ($attributes->get('value') ?? '') }}</textarea>
</div>









