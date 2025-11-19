{{--
QuickActionButton - Botón de acción rápida para dashboards
Uso: Acciones rápidas y frecuentes desde el dashboard
Cuándo usar: Dashboards, paneles de control, acceso rápido a funciones comunes
Cuándo NO usar: Acciones secundarias o poco frecuentes
Ejemplo: <x-quick-action-button href="/admin/products/create" label="Agregar Producto" icon="plus" color="primary" />
--}}

@props([
    'href' => '#',
    'label' => '',
    'icon' => 'plus',
    'color' => 'primary', // primary, success, warning, info, secondary
    'disabled' => false,
])

@php
    // Color classes mapping - Mejor contraste con fondos sólidos
    $colorClasses = [
        'primary' => [
            'bg' => 'bg-primary-300',
            'hoverBg' => 'hover:bg-primary-400',
            'iconBg' => 'bg-white bg-opacity-20',
            'iconColor' => 'text-white',
            'textColor' => 'text-white',
        ],
        'success' => [
            'bg' => 'bg-success-300',
            'hoverBg' => 'hover:bg-success-400',
            'iconBg' => 'bg-white bg-opacity-20',
            'iconColor' => 'text-white',
            'textColor' => 'text-white',
        ],
        'warning' => [
            'bg' => 'bg-warning-300',
            'hoverBg' => 'hover:bg-warning-400',
            'iconBg' => 'bg-white bg-opacity-20',
            'iconColor' => 'text-white',
            'textColor' => 'text-white',
        ],
        'info' => [
            'bg' => 'bg-info-300',
            'hoverBg' => 'hover:bg-info-400',
            'iconBg' => 'bg-white bg-opacity-20',
            'iconColor' => 'text-white',
            'textColor' => 'text-white',
        ],
        'secondary' => [
            'bg' => 'bg-secondary-300',
            'hoverBg' => 'hover:bg-secondary-400',
            'iconBg' => 'bg-white bg-opacity-20',
            'iconColor' => 'text-white',
            'textColor' => 'text-white',
        ],
    ];
    
    $colors = $colorClasses[$color] ?? $colorClasses['primary'];
    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<a href="{{ $href }}" 
   class="flex flex-col items-center justify-center h-full {{ $colors['bg'] }} {{ $disabled ? '' : $colors['hoverBg'] }} rounded-lg p-4 shadow-sm transition-all duration-200 group {{ $disabledClasses }}" 
   @if($disabled) onclick="event.preventDefault(); Swal.fire({ icon: 'info', title: 'Feature no disponible', text: 'Esta funcionalidad no está habilitada en tu plan.' });" @endif
   {{ $attributes }}>
    <div class="w-14 h-14 rounded-full {{ $colors['iconBg'] }} flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
        <i data-lucide="{{ $icon }}" class="w-7 h-7 {{ $colors['iconColor'] }}"></i>
    </div>
    <span class="text-sm font-semibold {{ $colors['textColor'] }} text-center leading-tight">{{ $label }}</span>
</a>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
