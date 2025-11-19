{{--
Alert With List - Alerta que incluye una lista de elementos o errores
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'title' => '',
    'items' => [], // Array de elementos para la lista
])

<div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-with-list-label" {{ $attributes }}>
    <div class="flex">
        <div class="shrink-0">
            <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
        </div>
        <div class="ms-4">
            @if($title)
                <h3 id="hs-with-list-label" class="text-sm font-semibold">
                    {{ $title }}
                </h3>
            @endif
            @if(count($items) > 0)
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc space-y-1 ps-5">
                        @foreach($items as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
