{{--
Textarea With Helper - Textarea con texto de ayuda
Uso: Textarea con texto de ayuda debajo
Cuándo usar: Cuando necesites proporcionar información adicional al usuario
Cuándo NO usar: Cuando el campo sea autoexplicativo
Ejemplo: <x-textarea-with-helper label="Leave your question" placeholder="Say hi..." helper-text="We'll get back to you soon." rows="3" />
--}}

@props([
    'label' => '',
    'helperText' => '',
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'rows' => 3,
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
    $helperId = $uniqueId . '-helper';
@endphp

<div class="max-w-sm">
    <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        aria-describedby="{{ $helperId }}"
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    ></textarea>
    <p class="mt-2 text-xs text-gray-500" id="{{ $helperId }}">{{ $helperText }}</p>
</div>















