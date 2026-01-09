@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - ' . $client->name)

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.linkiudev.clients.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    {{ $client->name }}
                    @if($client->is_active)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Activo</span>
                    @else
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Inactivo</span>
                    @endif
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Cliente desde {{ $client->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('superlinkiu.linkiudev.clients.edit', $client) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
            <a href="{{ route('superlinkiu.linkiudev.projects.create', ['client_id' => $client->id]) }}" class="px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="folder-plus" class="w-4 h-4"></i>
                Nuevo Proyecto
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info del Cliente --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Información de Contacto</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <i data-lucide="phone" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">WhatsApp</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->full_phone) }}" target="_blank" class="text-sm text-gray-900 dark:text-white hover:text-primary-300">
                                {{ $client->country_code }} {{ $client->phone }}
                            </a>
                        </div>
                    </div>

                    @if($client->email)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <i data-lucide="mail" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                            <a href="mailto:{{ $client->email }}" class="text-sm text-gray-900 dark:text-white hover:text-primary-300">
                                {{ $client->email }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                @if($client->notes)
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notas</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $client->notes }}</p>
                </div>
                @endif
            </div>

            {{-- Próximos eventos --}}
            @if($client->agendaEntries->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mt-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Próximos Eventos</h3>
                <div class="space-y-3">
                    @foreach($client->agendaEntries as $entry)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $entry->date->format('d') }}</p>
                                <p class="text-xs font-medium text-gray-900 dark:text-white">{{ $entry->date->format('M') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $entry->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $entry->time_range }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Proyectos --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Proyectos ({{ $client->projects->count() }})
                    </h3>
                </div>

                @if($client->projects->isEmpty())
                    <div class="text-center py-12">
                        <i data-lucide="folder" class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No hay proyectos para este cliente</p>
                        <a href="{{ route('superlinkiu.linkiudev.projects.create', ['client_id' => $client->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Crear Proyecto
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($client->projects as $project)
                            <a href="{{ route('superlinkiu.linkiudev.projects.show', $project) }}" class="block p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->name }}</h4>
                                        @if($project->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $project->description }}</p>
                                        @endif
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800 dark:bg-{{ $project->status_color }}-900/30 dark:text-{{ $project->status_color }}-300">
                                        {{ $project->status_label }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                                <div class="h-full bg-primary-300 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $project->progress_percentage }}%</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $project->tasks_progress }} tareas</p>
                                    </div>
                                    @if($project->due_date)
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Fecha límite</p>
                                            <p class="text-xs font-medium {{ $project->is_overdue ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                                                {{ $project->due_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
