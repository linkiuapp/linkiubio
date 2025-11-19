{{--
Clipboard Tooltip - Copiar texto al portapapeles con tooltip
Uso: Permite copiar texto al portapapeles desde un input hidden, mostrando tooltip
Cuándo usar: Cuando el texto a copiar esté oculto o sea un comando/formato especial
Cuándo NO usar: Cuando el texto esté visible (usa ClipboardBasic)
Ejemplo: <x-clipboard-tooltip text="npm install preline" buttonText="$ npm i preline" />
--}}

@props([
    'text' => '',
    'buttonText' => '',
    'targetId' => null,
    'successText' => 'Copiado',
])

@php
    $uniqueId = $targetId ?? 'clipboard-tooltip-' . uniqid();
@endphp

<input type="hidden" id="{{ $uniqueId }}" value="{{ $text }}">

<button 
    type="button" 
    class="js-clipboard-example group hs-tooltip relative py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-mono rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
    data-clipboard-target="#{{ $uniqueId }}" 
    data-clipboard-action="copy" 
    data-clipboard-success-text="{{ $successText }}"
>
    {{ $buttonText ?: $text }}
    <span class="border-s border-gray-200 ps-3.5">
        <i data-lucide="copy" class="js-clipboard-default size-4 group-hover:rotate-6 transition" x-init="lucide.createIcons()"></i>
        <i data-lucide="check" class="js-clipboard-success hidden size-4 text-blue-600 rotate-6" x-init="lucide.createIcons()"></i>
    </span>

    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity hidden invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-lg shadow-2xs" role="tooltip">
        {{ $successText }}
    </span>
</button>

