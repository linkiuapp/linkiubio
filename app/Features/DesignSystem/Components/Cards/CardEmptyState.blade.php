{{--
Card Empty State - Card para mostrar estados vacíos con icono y mensaje
Uso: Pantallas o secciones sin datos, estados iniciales, placeholders amigables
Cuándo usar: Listas vacías, sin resultados de búsqueda, estados iniciales
Cuándo NO usar: Errores críticos, contenido que está cargando
Ejemplo: <x-card-empty-state icon="inbox" message="No hay datos para mostrar" />
--}}

@props([
    'icon' => 'inbox', // Lucide icon name
    'message' => 'No hay datos para mostrar',
    'description' => '',
    'height' => '240', // Altura mínima en px (sin 'px')
    'action' => '', // URL para acción opcional
    'actionText' => 'Agregar elemento',
])

@php
    // Height class
    $heightClass = 'min-h-' . $height;
    if (is_numeric($height)) {
        $heightClass = 'min-h-[' . $height . 'px]';
    }
@endphp

<div class="{{ $heightClass }} flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" {{ $attributes }}>
    <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-10 h-10 text-gray-500"></i>
        @endif
        
        <p class="mt-2 body-small text-gray-800">
            {{ $message }}
        </p>
        
        @if($description)
            <p class="mt-1 caption text-gray-500">
                {{ $description }}
            </p>
        @endif
        
        @if($action)
            <a href="{{ $action }}" 
               class="mt-4 inline-flex items-center gap-x-1 body-small font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-700 hover:underline focus:underline focus:outline-none focus:text-blue-700">
                {{ $actionText }}
                <i data-lucide="plus" class="w-4 h-4"></i>
            </a>
        @endif
        
        {{ $slot }}
    </div>
</div>
