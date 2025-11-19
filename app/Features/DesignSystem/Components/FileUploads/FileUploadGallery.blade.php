{{--
File Upload Gallery - Subida de archivos como galería de imágenes
Uso: Permite subir múltiples imágenes con preview en formato de galería
Cuándo usar: Cuando necesites subir múltiples imágenes y mostrarlas en una galería
Cuándo NO usar: Cuando necesites subir archivos de cualquier tipo (usa FileUploadBasic)
Ejemplo: <x-file-upload-gallery uploadUrl="/upload" />
Nota: Este componente requiere Dropzone.js y los helpers de Preline UI.
--}}

@props([
    'uploadUrl' => '/upload',
    'uniqueId' => null,
])

@php
    $uniqueId = $uniqueId ?? 'file-upload-gallery-' . uniqid();
    $config = json_encode([
        'url' => $uploadUrl,
        'acceptedFiles' => 'image/*',
        'autoHideTrigger' => false,
        'autoProcessQueue' => false,
        'extensions' => [
            'default' => [
                'class' => 'shrink-0 size-5'
            ],
            'xls' => [
                'class' => 'shrink-0 size-5'
            ],
            'zip' => [
                'class' => 'shrink-0 size-5'
            ],
            'csv' => [
                'icon' => '<i data-lucide="file-code" class="shrink-0 size-5"></i>',
                'class' => 'shrink-0 size-5'
            ]
        ]
    ]);
@endphp

<div id="{{ $uniqueId }}" data-hs-file-upload='{!! $config !!}'>
    <template data-hs-file-upload-preview="">
        <div class="relative mt-2 p-2 bg-white border border-gray-200 rounded-xl">
            <img class="mb-2 w-full object-cover rounded-lg" data-dz-thumbnail="">

            <div class="mb-1 flex justify-between items-center gap-x-3 whitespace-nowrap">
                <div class="w-10">
                    <span class="text-sm text-gray-800">
                        <span data-hs-file-upload-progress-bar-value="">0</span>%
                    </span>
                </div>

                <div class="flex items-center gap-x-2">
                    <button type="button" class="text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800" data-hs-file-upload-remove="">
                        <i data-lucide="trash-2" class="shrink-0 size-3.5"></i>
                    </button>
                </div>
            </div>

            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-hs-file-upload-progress-bar="">
                <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500" style="width: 0" data-hs-file-upload-progress-bar-pane=""></div>
            </div>
        </div>
    </template>

    <div class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
        <div class="text-center">
            <span class="inline-flex justify-center items-center size-16">
                <svg class="shrink-0 w-16 h-auto" width="71" height="51" viewBox="0 0 71 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.55172 8.74547L17.7131 6.88524V40.7377L12.8018 41.7717C9.51306 42.464 6.29705 40.3203 5.67081 37.0184L1.64319 15.7818C1.01599 12.4748 3.23148 9.29884 6.55172 8.74547Z" stroke="currentColor" stroke-width="2" class="stroke-blue-600"></path>
                    <path d="M64.4483 8.74547L53.2869 6.88524V40.7377L58.1982 41.7717C61.4869 42.464 64.703 40.3203 65.3292 37.0184L69.3568 15.7818C69.984 12.4748 67.7685 9.29884 64.4483 8.74547Z" stroke="currentColor" stroke-width="2" class="stroke-blue-600"></path>
                    <g filter="url(#filter4-{{ $uniqueId }})">
                        <rect x="17.5656" y="1" width="35.8689" height="42.7541" rx="5" stroke="currentColor" stroke-width="2" class="stroke-blue-600" shape-rendering="crispEdges"></rect>
                    </g>
                    <path d="M39.4826 33.0893C40.2331 33.9529 41.5385 34.0028 42.3537 33.2426L42.5099 33.0796L47.7453 26.976L53.4347 33.0981V38.7544C53.4346 41.5156 51.1959 43.7542 48.4347 43.7544H22.5656C19.8043 43.7544 17.5657 41.5157 17.5656 38.7544V35.2934L29.9728 22.145L39.4826 33.0893Z" class="fill-blue-50 stroke-blue-600" fill="currentColor" stroke="currentColor" stroke-width="2"></path>
                    <circle cx="40.0902" cy="14.3443" r="4.16393" class="fill-blue-50 stroke-blue-600" fill="currentColor" stroke="currentColor" stroke-width="2"></circle>
                    <defs>
                        <filter id="filter4-{{ $uniqueId }}" x="13.5656" y="0" width="43.8689" height="50.7541" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                            <feOffset dy="3"></feOffset>
                            <feGaussianBlur stdDeviation="1.5"></feGaussianBlur>
                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"></feColorMatrix>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect4"></feBlend>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect4" result="shape"></feBlend>
                        </filter>
                    </defs>
                </svg>
            </span>

            <div class="mt-4 flex flex-wrap justify-center text-sm/6 text-gray-600">
                <span class="pe-1 font-medium text-gray-800">
                    Arrastra tus imágenes aquí o
                </span>
                <span class="bg-white font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-hidden focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">buscar</span>
            </div>

            <p class="mt-1 text-xs text-gray-400">
                Selecciona archivos de hasta 2MB.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-x-2 empty:gap-0" data-hs-file-upload-previews=""></div>
</div>
