{{--
Textarea Auto Height With Button - Textarea con auto-height y botón
Uso: Textarea con auto-height y botón de envío
Cuándo usar: Para formularios de mensajería o comentarios
Cuándo NO usar: Cuando no necesites un botón integrado
Ejemplo: <x-textarea-auto-height-with-button placeholder="Message..." button-text="Send" />
--}}

@props([
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'buttonText' => 'Send',
    'defaultHeight' => 48,
    'maxHeight' => 144,
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
@endphp

<div class="relative max-w-sm">
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="1"
        placeholder="{{ $placeholder }}"
        data-hs-textarea-auto-height='{"defaultHeight": {{ $defaultHeight }}}'
        class="max-h-36 py-2.5 sm:py-3 ps-4 pe-20 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none resize-none overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300"
        {{ $attributes }}
    ></textarea>

    <!-- Button Group -->
    <div class="absolute top-2 end-3 z-10">
        <button type="button" class="py-1.5 px-3 inline-flex shrink-0 justify-center items-center text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:outline-hidden focus:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            {{ $buttonText }}
        </button>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-height functionality for textarea
        const textarea = document.getElementById('{{ $uniqueId }}');
        if (textarea) {
            const defaultHeight = {{ $defaultHeight }};
            const maxHeight = {{ $maxHeight }};
            
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                const newHeight = Math.min(this.scrollHeight, maxHeight);
                this.style.height = newHeight + 'px';
            });
            
            // Set initial height
            textarea.style.height = defaultHeight + 'px';
        }
    });
</script>
@endpush















