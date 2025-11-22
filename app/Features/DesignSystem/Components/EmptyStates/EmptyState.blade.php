{{--
Empty State - Componente para estados vacíos
Uso: Mostrar mensaje cuando no hay elementos en listas, tablas o secciones
Cuándo usar: Cuando una lista/colección está vacía y necesitas guiar al usuario
Cuándo NO usar: Cuando hay contenido disponible
Ejemplo: <x-empty-state svg="empty-categories.svg" title="No hay categorías" message="Crea tu primera categoría para comenzar" />
--}}

@props([
    'svg' => 'empty-state.svg', // Nombre del archivo SVG en images-ui (ubicado en app/Features/DesignSystem/images-ui/)
    'title' => 'No hay elementos',
    'message' => 'Comienza agregando tu primer elemento',
    'action' => null, // Slot para botón de acción
])

@php
    // Los SVG están en app/Features/DesignSystem/images-ui/
    // Se acceden a través de la ruta /images-ui/{filename} definida en routes/web.php
    $svgPath = asset('images-ui/' . $svg);
@endphp

<div class="flex flex-col items-center justify-center py-8 px-6">
    {{-- ITEM: SVG Image --}}
    <div class="mb-4">
        <img 
            src="{{ $svgPath }}" 
            alt="{{ $title }}"
            class="w-48 h-48 object-contain"
            loading="lazy"
        >
    </div>
    {{-- End ITEM: SVG Image --}}

    {{-- ITEM: Title --}}
    <h3 class="text-lg font-semibold text-gray-800 mb-2">
        {{ $title }}
    </h3>
    {{-- End ITEM: Title --}}

    {{-- ITEM: Message --}}
    <p class="text-sm text-gray-500 mb-6 text-center max-w-md">
        {{ $message }}
    </p>
    {{-- End ITEM: Message --}}

    {{-- ITEM: Action Button --}}
    @isset($action)
        <div>
            {{ $action }}
        </div>
    @endisset
    {{-- End ITEM: Action Button --}}
</div>

