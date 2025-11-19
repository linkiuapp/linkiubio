{{--
File Upload Single Image - Subida de una sola imagen
Uso: Permite subir una sola imagen con preview circular
Cuándo usar: Cuando necesites subir un avatar o imagen de perfil
Cuándo NO usar: Cuando necesites subir múltiples archivos (usa FileUploadBasic)
Ejemplo: <x-file-upload-single-image uploadUrl="/upload" />
Nota: Este componente requiere Dropzone.js y los helpers de Preline UI.
--}}

@props([
    'uploadUrl' => '/upload',
    'uniqueId' => null,
])

@php
    $uniqueId = $uniqueId ?? 'file-upload-single-' . uniqid();
    $config = json_encode([
        'url' => $uploadUrl,
        'acceptedFiles' => 'image/*',
        'maxFiles' => 1,
        'singleton' => true,
        'autoProcessQueue' => false
    ]);
@endphp

<div id="{{ $uniqueId }}" data-hs-file-upload='{!! $config !!}'>
    <template data-hs-file-upload-preview="">
        <div class="size-20">
            <img class="w-full object-contain rounded-full" data-dz-thumbnail="">
        </div>
    </template>

    <div class="flex flex-wrap items-center gap-3 sm:gap-5">
        <div class="group" data-hs-file-upload-previews="" data-hs-file-upload-pseudo-trigger="">
            <span class="group-has-[div]:hidden flex shrink-0 justify-center items-center size-20 border-2 border-dotted border-gray-300 text-gray-400 cursor-pointer rounded-full hover:bg-gray-50">
                <i data-lucide="user" class="shrink-0 size-7"></i>
            </span>
        </div>

        <div class="grow">
            <div class="flex items-center gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-file-upload-trigger="">
                    <i data-lucide="upload" class="shrink-0 size-4"></i>
                    Subir foto
                </button>
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-gray-200 bg-white text-gray-500 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-file-upload-clear="">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
