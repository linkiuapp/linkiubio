{{--
Alert Discovery - Mensaje para notificar actualizaciones de UI o información sobre nuevas funciones
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'title' => '',
    'message' => '',
])

<div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-discovery-label" {{ $attributes }}>
    <div class="flex">
        <div class="shrink-0">
            <i data-lucide="info" class="shrink-0 size-4 text-blue-600 mt-1"></i>
        </div>
        <div class="ms-3">
            @if($title)
                <h3 id="hs-discovery-label" class="text-gray-800 font-semibold">
                    {{ $title }}
                </h3>
            @endif
            @if($message)
                <p class="mt-2 text-sm text-gray-700">
                    {{ $message }}
                </p>
            @endif
        </div>
    </div>
</div>
