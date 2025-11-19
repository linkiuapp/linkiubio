{{--
Clipboard Basic - Copiar texto al portapapeles (uso básico)
Uso: Permite copiar texto al portapapeles con un botón
Cuándo usar: Cuando necesites que el usuario copie texto visible en la página
Cuándo NO usar: Cuando el texto esté oculto (usa ClipboardTooltip)
Ejemplo: <x-clipboard-basic text="npm install preline" />
--}}

@props([
    'text' => '',
    'targetId' => null,
    'successText' => 'Copiado',
])

@php
    $uniqueId = $targetId ?? 'clipboard-' . uniqid();
@endphp

<div class="inline-flex items-center gap-x-3">
    <div id="{{ $uniqueId }}" class="text-sm font-medium text-gray-800">
        {{ $text }}
    </div>

    <button 
        type="button" 
        class="js-clipboard-example group p-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
        data-clipboard-target="#{{ $uniqueId }}" 
        data-clipboard-action="copy" 
        data-clipboard-success-text="{{ $successText }}"
    >
        <i data-lucide="copy" class="js-clipboard-default size-4 group-hover:rotate-6 transition" x-init="lucide.createIcons()"></i>
        <i data-lucide="check" class="js-clipboard-success hidden size-4 text-blue-600" x-init="lucide.createIcons()"></i>
    </button>
</div>















