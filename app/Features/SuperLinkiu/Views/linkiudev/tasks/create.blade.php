@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Nueva Tarea')

@section('content')
<div class="container-fluid max-w-3xl">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Nueva Tarea</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Crea una nueva tarea</p>
        </div>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-medium">Por favor corrige los siguientes errores:</p>
                    <ul class="mt-2 text-sm list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('superlinkiu.linkiudev.tasks.store') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        @csrf
        @if($selectedProjectId)
            <input type="hidden" name="redirect_to_project" value="1">
        @endif

        <div class="space-y-6">
            {{-- Proyecto --}}
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Proyecto <span class="text-red-500">*</span>
                </label>
                <select 
                    name="project_id" 
                    id="project_id"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                >
                    <option value="">Selecciona un proyecto</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $selectedProjectId) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }} ({{ $project->client?->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nombre de la Tarea <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    placeholder="Ej: Diseñar mockups"
                >
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Descripción
                </label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                >{{ old('description') }}</textarea>
            </div>

            {{-- Estado y Prioridad --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="review" {{ old('status') === 'review' ? 'selected' : '' }}>En Revisión</option>
                    </select>
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridad</label>
                    <select name="priority" id="priority" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Media</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            {{-- Programar en Agenda --}}
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-3">📅 Programar en Agenda</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Fecha</label>
                        <input type="date" name="scheduled_date" value="{{ old('scheduled_date') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Hora inicio</label>
                        <input type="time" name="scheduled_start_time" value="{{ old('scheduled_start_time') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Hora fin</label>
                        <input type="time" name="scheduled_end_time" value="{{ old('scheduled_end_time') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Recordatorio (minutos antes)</label>
                    <select name="reminder_minutes" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option value="">Sin recordatorio</option>
                        <option value="15">15 minutos</option>
                        <option value="30" {{ old('reminder_minutes', $settings->default_reminder_minutes ?? 30) == 30 ? 'selected' : '' }}>30 minutos</option>
                        <option value="60">1 hora</option>
                    </select>
                </div>
            </div>

            {{-- Subtareas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtareas (opcional)</label>
                <div id="subtasks-container" class="space-y-2">
                    <div class="flex gap-2">
                        <input type="text" name="subtasks[]" placeholder="Subtarea 1" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <button type="button" onclick="addSubtask()" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Notificar --}}
            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="notify_on_complete" value="1" {{ old('notify_on_complete', true) ? 'checked' : '' }} class="w-4 h-4 text-primary-300 bg-white border-gray-300 rounded focus:ring-primary-300">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Notificar al cliente al completar</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Enviar notificación por WhatsApp</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ url()->previous() }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Crear Tarea
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});

function addSubtask() {
    const container = document.getElementById('subtasks-container');
    const count = container.children.length + 1;
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="subtasks[]" placeholder="Subtarea ${count}" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
        <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 text-red-500 hover:text-red-700">
            <i data-lucide="trash-2" class="w-4 h-4"></i>
        </button>
    `;
    container.appendChild(div);
    lucide.createIcons();
}
</script>
@endpush
