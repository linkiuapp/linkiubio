{{--
Alert Actions - Ejemplo de alerta más interactiva con botones de acción
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'title' => '',
    'message' => '',
    'actions' => [], // Array de acciones [['text' => 'Texto', 'action' => 'función()']]
])

<div class="bg-blue-100 border border-blue-200 text-gray-800 rounded-lg p-4" role="alert" tabindex="-1" aria-labelledby="hs-actions-label" {{ $attributes }}>
    <div class="flex">
        <div class="shrink-0">
            <i data-lucide="info" class="shrink-0 size-4 mt-1"></i>
        </div>
        <div class="ms-3">
            @if($title)
                <h3 id="hs-actions-label" class="font-semibold">
                    {{ $title }}
                </h3>
            @endif
            @if($message)
                <div class="mt-2 text-sm text-gray-600">
                    {{ $message }}
                </div>
            @endif
            @if(count($actions) > 0)
                <div class="mt-4">
                    <div class="flex gap-x-3">
                        @foreach($actions as $action)
                            <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none" @if(isset($action['action'])) onclick="{{ $action['action'] }}" @endif>
                                {{ $action['text'] ?? 'Acción' }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
