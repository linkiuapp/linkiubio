{{--
Timeline Heading - Encabezado de sección en timeline
Uso: Agrupar eventos por fecha o categoría
Cuándo usar: Para separar eventos en secciones (ej: por fecha)
Cuándo NO usar: Para elementos individuales de timeline
Ejemplo: <x-timeline-heading>1 Ago, 2023</x-timeline-heading>
--}}

@props([
    'text' => '',
])

<div class="ps-2 my-2 first:mt-0">
    <h3 class="caption font-medium uppercase text-gray-500">
        {{ $text ?: $slot }}
    </h3>
</div>















