{{--
List Group Files - Grupo de lista con archivos y botones de acción
Uso: Lista de archivos descargables, documentos, archivos adjuntos
Cuándo usar: Cuando necesites mostrar archivos con acciones como descargar
Cuándo NO usar: Cuando necesites listas simples sin acciones
Ejemplo: <x-list-group-files :items="[['name' => 'resume.pdf', 'action' => 'Download', 'actionIcon' => 'download']]" />
--}}

@props([
    'items' => [], // Array de objetos: ['name', 'action'?, 'actionIcon'?, 'actionUrl'?]
    'textSize' => 'body-small',
    'textColor' => 'text-gray-800',
])

<ul class="flex flex-col justify-end text-start -space-y-px" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $name = $item['name'] ?? '';
            $action = $item['action'] ?? 'Download';
            $actionIcon = $item['actionIcon'] ?? 'download';
            $actionUrl = $item['actionUrl'] ?? '#';
        @endphp
        <li class="flex items-center gap-x-2 p-3 {{ $textSize }} bg-white border border-gray-200 {{ $textColor }} first:rounded-t-lg first:mt-0 last:rounded-b-lg">
            <div class="w-full flex justify-between truncate">
                <span class="me-3 flex-1 w-0 truncate">
                    {{ $name }}
                </span>
                <a href="{{ $actionUrl }}" 
                   type="button" 
                   class="flex items-center gap-x-2 text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 whitespace-nowrap">
                    <i data-lucide="{{ $actionIcon }}" class="shrink-0 size-4"></i>
                    {{ $action }}
                </a>
            </div>
        </li>
    @endforeach
</ul>















