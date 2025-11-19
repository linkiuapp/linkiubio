{{--
Badge Icon - Badge con icono de Lucide para mostrar indicación visual
Código exacto de Preline UI sin modificaciones en clases
--}}

@props([
    'type' => 'success', // success, error, warning, info, dark, secondary
    'icon' => 'check-circle',
    'text' => '',
    'iconOnly' => false, // true para mostrar solo el icono
    'loading' => false, // true para animación spin en el icono
])

@php
    $typeClasses = [
        'success' => 'bg-teal-100 text-teal-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
        'dark' => 'bg-gray-100 text-gray-800',
        'secondary' => 'bg-gray-50 text-gray-500',
    ];
    
    $classes = $typeClasses[$type] ?? $typeClasses['success'];
    $padding = $iconOnly ? 'py-1 px-1.5' : 'py-1 px-2';
    $iconClass = 'shrink-0 size-3';
    if ($loading || $icon === 'loader' || $icon === 'loading') {
        $iconClass .= ' animate-spin';
    }
@endphp

<span class="{{ $padding }} inline-flex items-center gap-x-1 text-xs font-medium {{ $classes }} rounded-full" {{ $attributes }}>
    @if($icon)
        <i data-lucide="{{ $icon }}" class="{{ $iconClass }}"></i>
    @endif
    @if(!$iconOnly && $text)
        {{ $text }}
    @endif
</span>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
