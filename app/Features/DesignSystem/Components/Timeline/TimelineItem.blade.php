{{--
Timeline Item - Elemento individual de timeline
Uso: Representar un evento o acción en el tiempo
Cuándo usar: Dentro de un Timeline para mostrar eventos secuenciales
Cuándo NO usar: Para mostrar contenido no relacionado con el tiempo
Ejemplo: <x-timeline-item time="12:05PM" title="Evento" description="Descripción" />
--}}

@props([
    'time' => null, // Hora a mostrar en el lado izquierdo (opcional)
    'title' => '', // Título del evento
    'titleIcon' => null, // Icono de Lucide para el título (opcional)
    'description' => null, // Descripción del evento (opcional)
    'user' => null, // Usuario/autor: ['name' => '...', 'avatar' => '...' o 'initials' => '...']
    'dotIcon' => null, // Tipo de icono del punto: 'dot', 'avatar', 'icon', 'initials'
    'dotAvatar' => null, // URL del avatar para el punto
    'dotInitials' => null, // Iniciales para el punto (ej: 'A')
    'dotIconName' => null, // Nombre del icono Lucide para el punto
    'isLast' => false, // Si es el último elemento (oculta la línea)
])

@php
    $uniqueId = uniqid('timeline-item-');
    
    // Determinar qué mostrar en el punto del timeline
    $dotContent = null;
    if ($dotIcon === 'avatar' && $dotAvatar) {
        $dotContent = '<img class="shrink-0 size-7 rounded-full" src="' . e($dotAvatar) . '" alt="Avatar">';
    } elseif ($dotIcon === 'initials' && $dotInitials) {
        $dotContent = '<span class="flex shrink-0 justify-center items-center size-7 border border-gray-200 body-small font-semibold uppercase text-gray-800 rounded-full">' . e($dotInitials) . '</span>';
    } elseif ($dotIcon === 'icon' && $dotIconName) {
        $dotContent = '<span class="flex shrink-0 justify-center items-center size-7 bg-white border border-gray-200 rounded-full"><i data-lucide="' . e($dotIconName) . '" class="shrink-0 size-4 text-gray-600"></i></span>';
    } else {
        // Default: punto simple
        $dotContent = '<div class="size-2 rounded-full bg-gray-400"></div>';
    }
@endphp

<div class="flex gap-x-3">
    @if($time)
        <!-- Left Content -->
        <div class="min-w-14 text-end">
            <span class="caption text-gray-500">{{ $time }}</span>
        </div>
        <!-- End Left Content -->
    @endif

    <!-- Icon -->
    <div class="relative {{ $isLast ? '' : 'after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200' }}">
        <div class="relative z-10 size-7 flex justify-center items-center">
            {!! $dotContent !!}
        </div>
    </div>
    <!-- End Icon -->

    <!-- Right Content -->
    <div class="grow pt-0.5 {{ $isLast ? '' : 'pb-8' }}">
        <h3 class="flex gap-x-1.5 font-semibold text-gray-800">
            @if($titleIcon)
                <i data-lucide="{{ $titleIcon }}" class="shrink-0 size-4 mt-1"></i>
            @endif
            {{ $title }}
        </h3>
        @if($description)
            <p class="mt-1 body-small text-gray-600">
                {{ $description }}
            </p>
        @endif
        @if($user)
            <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 caption rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                @if(isset($user['avatar']))
                    <img class="shrink-0 size-4 rounded-full" src="{{ $user['avatar'] }}" alt="{{ $user['name'] ?? 'Avatar' }}">
                @elseif(isset($user['initials']))
                    <span class="flex shrink-0 justify-center items-center size-4 bg-white border border-gray-200 text-[10px] font-semibold uppercase text-gray-600 rounded-full">
                        {{ $user['initials'] }}
                    </span>
                @endif
                {{ $user['name'] ?? '' }}
            </button>
        @endif
    </div>
    <!-- End Right Content -->
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush

