{{--
Badge con Avatar - Badge con imagen de avatar del usuario
Uso: Badges para mostrar usuarios, colaboradores, asignaciones de persona
Cuándo usar: Equipos de trabajo, asignaciones, participantes, usuarios activos
Cuándo NO usar: Categorías generales, estados sin personas involucradas
Ejemplo: <x-badge-avatar name="Christina" avatar="/images/avatar.jpg" removable="false" />
--}}

@props([
    'name' => 'Usuario',
    'avatar' => '', // URL de la imagen del avatar
    'removable' => false, // Si incluye botón de eliminar
    'onRemove' => '', // Función JavaScript para eliminar
    'id' => '', // ID del badge
])

@php
    $badgeId = $id ?: 'badge-avatar-' . uniqid();
    $removeAction = $onRemove ?: "document.getElementById('{$badgeId}').remove()";
    $padding = $removable ? 'p-1.5' : 'p-1.5 pe-3';
@endphp

<div id="{{ $badgeId }}" class="inline-flex flex-nowrap items-center bg-white border border-gray-200 rounded-full {{ $padding }}" {{ $attributes }}>
    @if($avatar)
        <img class="me-1.5 inline-block w-6 h-6 rounded-full" 
             src="{{ $avatar }}" 
             alt="Avatar de {{ $name }}">
    @else
        <div class="me-1.5 inline-flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full">
            <i data-lucide="user" class="w-4 h-4 text-gray-500"></i>
        </div>
    @endif
    
    <div class="whitespace-nowrap body-small font-medium text-gray-800">
        {{ $name }}
    </div>
    
    @if($removable)
        <div class="ms-2.5 inline-flex justify-center items-center w-5 h-5 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 cursor-pointer transition-colors"
             onclick="{{ $removeAction }}">
            <i data-lucide="x" class="w-3 h-3"></i>
        </div>
    @endif
</div>
