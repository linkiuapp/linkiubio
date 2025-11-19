{{--
Textarea With Corner Hint - Textarea con hint en la esquina
Uso: Textarea con información adicional en la esquina del label
Cuándo usar: Cuando necesites mostrar información como límite de caracteres
Cuándo NO usar: Cuando no necesites información adicional en el label
Ejemplo: <x-textarea-with-corner-hint label="Contact us" corner-hint="100 characters" placeholder="Say hi..." rows="3" />
--}}

@props([
    'label' => '',
    'cornerHint' => '',
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
    <div class="flex flex-wrap justify-between items-center gap-2">
        <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
        <span class="block mb-2 text-sm text-gray-500">{{ $cornerHint }}</span>
    </div>
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    ></textarea>
</div>















