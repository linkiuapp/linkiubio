{{--
Alert Bordered - Mensajes con borde para significar actualizaciones o información importante
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'success', // success, error, warning
    'title' => '',
    'message' => '',
    'iconName' => null,
])

@php
    $dynamicTitle = $attributes->get('x-title');
    $dynamicMessage = $attributes->get('x-message');
    $attributes = $attributes->except(['x-title', 'x-message']);

    $typeClasses = [
        'success' => [
            'container' => 'bg-teal-50 border-t-2 border-teal-500 rounded-lg',
            'iconBg' => 'border-4 border-teal-100 bg-teal-200 text-teal-800',
            'titleId' => 'hs-bordered-success-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-teal-700'
        ],
        'error' => [
            'container' => 'bg-red-50 border-s-4 border-red-500 p-4',
            'iconBg' => 'border-4 border-red-100 bg-red-200 text-red-800',
            'titleId' => 'hs-bordered-red-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-gray-700'
        ],
        'warning' => [
            'container' => 'bg-amber-50 border-t-2 border-amber-500 rounded-lg',
            'iconBg' => 'border-4 border-amber-100 bg-amber-200 text-amber-800',
            'titleId' => 'hs-bordered-warning-style-label',
            'title' => 'text-gray-800',
            'message' => 'text-amber-700'
        ],
    ];
    
    $config = $typeClasses[$type] ?? $typeClasses['success'];
    $icon = $iconName ?: match($type) {
        'success' => 'check-circle',
        'error' => 'x',
        'warning' => 'alert-triangle',
        default => 'check-circle'
    };
@endphp

<div
    class="{{ $config['container'] }} p-4"
    role="alert"
    tabindex="-1"
    aria-labelledby="{{ $config['titleId'] }}"
    {{ $attributes }}
    x-init="window.createIcons ? window.createIcons({ icons: window.lucideIcons }) : null"
>
    <div class="flex">
        <div class="shrink-0">
            <!-- Icon -->
            <span class="inline-flex justify-center items-center size-8 rounded-full {{ $config['iconBg'] }}">
                <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
            </span>
            <!-- End Icon -->
        </div>
        <div class="ms-3">
            @if($title || $dynamicTitle)
                <h3
                    id="{{ $config['titleId'] }}"
                    class="{{ $config['title'] }} font-semibold"
                    @if($dynamicTitle) x-text="{{ $dynamicTitle }}" @endif
                >
                    @unless($dynamicTitle)
                        {{ $title }}
                    @endunless
                </h3>
            @endif
            @if($message || $dynamicMessage)
                <p
                    class="text-sm {{ $config['message'] }}"
                    @if($dynamicMessage) x-text="{{ $dynamicMessage }}" @endif
                >
                    @unless($dynamicMessage)
                        {{ $message }}
                    @endunless
                </p>
            @endif
            @if($slot->isNotEmpty())
                <div class="text-sm {{ $config['message'] }} mt-2">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</div>
