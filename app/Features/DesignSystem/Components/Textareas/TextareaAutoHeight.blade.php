{{--
Textarea Auto Height - Textarea con altura automática
Uso: Textarea que crece automáticamente según el contenido
Cuándo usar: Cuando el usuario pueda escribir textos largos y quieras evitar scrollbars
Cuándo NO usar: Cuando necesites una altura fija
Ejemplo: <x-textarea-auto-height label="Contact us" placeholder="Say hi..." />
--}}

@props([
    'label' => null,
    'textareaId' => null,
    'textareaName' => null,
    'placeholder' => '',
    'defaultHeight' => 48,
    'maxHeight' => 144,
])

@php
    $uniqueId = $textareaId ?? 'textarea-' . uniqid();
    $nameAttr = $textareaName ?? $uniqueId;
    $maxHeightClass = 'max-h-' . ($maxHeight / 4); // Convertir px a rem (144px = 36rem)
@endphp

<div class="max-w-sm">
    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">{{ $label }}</label>
    @endif
    <textarea 
        id="{{ $uniqueId }}"
        name="{{ $nameAttr }}"
        rows="3"
        placeholder="{{ $placeholder }}"
        data-hs-textarea-auto-height=""
        class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {{ $attributes }}
    ></textarea>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-height functionality for textarea
        const textarea = document.getElementById('{{ $uniqueId }}');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                const newHeight = Math.min(this.scrollHeight, {{ $maxHeight }});
                this.style.height = newHeight + 'px';
            });
            
            // Set initial height
            if (textarea.value) {
                textarea.style.height = 'auto';
                const newHeight = Math.min(textarea.scrollHeight, {{ $maxHeight }});
                textarea.style.height = newHeight + 'px';
            } else {
                textarea.style.height = '{{ $defaultHeight }}px';
            }
        }
    });
</script>
@endpush















