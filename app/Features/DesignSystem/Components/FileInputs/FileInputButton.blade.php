{{--
File Input Button - Input de archivo con estilo de botón
Uso: Input de archivo con botón estilizado
Cuándo usar: Cuando necesites un input de archivo con apariencia de botón
Cuándo NO usar: Cuando necesites el input de archivo nativo sin estilos
Ejemplo: <x-file-input-button label="Choose profile photo" />
--}}

@props([
    'label' => 'Choose file',
    'inputId' => null,
    'inputName' => null,
    'accept' => null,
    'multiple' => false,
])

@php
    $uniqueId = $inputId ?? 'file-input-' . uniqid();
    $nameAttr = $inputName ?? $uniqueId;
@endphp

<div class="max-w-sm">
    <form>
        <label class="block">
            <span class="sr-only">{{ $label }}</span>
            <input 
                type="file" 
                id="{{ $uniqueId }}"
                name="{{ $nameAttr }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($multiple) multiple @endif
                class="block p-4 w-full text-sm text-gray-500 border border-gray-400 rounded-lg file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:disabled:opacity-50 file:disabled:pointer-events-none"
                {{ $attributes }}
            >
        </label>
    </form>
</div>

