@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Editar Tarea')

@section('content')
<div class="container-fluid max-w-3xl">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('superlinkiu.linkiudev.tasks.show', $task) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Editar Tarea</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $task->name }}</p>
        </div>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('superlinkiu.linkiudev.tasks.update', $task) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Proyecto --}}
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Proyecto</label>
                <select name="project_id" id="project_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }} ({{ $project->client?->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descripción</label>
                <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">{{ old('description', $task->description) }}</textarea>
            </div>

            {{-- Estado y Prioridad --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="review" {{ old('status', $task->status) === 'review' ? 'selected' : '' }}>En Revisión</option>
                        <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridad</label>
                    <select name="priority" id="priority" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300">
                        <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Media</option>
                        <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            {{-- Programar en Agenda --}}
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-3">📅 Programar en Agenda</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Fecha</label>
                        <input type="date" name="scheduled_date" value="{{ old('scheduled_date', $task->scheduled_date?->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Hora inicio</label>
                        <input type="time" name="scheduled_start_time" value="{{ old('scheduled_start_time', $task->scheduled_start_time ? \Carbon\Carbon::parse($task->scheduled_start_time)->format('H:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Hora fin</label>
                        <input type="time" name="scheduled_end_time" value="{{ old('scheduled_end_time', $task->scheduled_end_time ? \Carbon\Carbon::parse($task->scheduled_end_time)->format('H:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Recordatorio</label>
                    <select name="reminder_minutes" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option value="">Sin recordatorio</option>
                        <option value="15" {{ old('reminder_minutes', $task->reminder_minutes) == 15 ? 'selected' : '' }}>15 minutos</option>
                        <option value="30" {{ old('reminder_minutes', $task->reminder_minutes) == 30 ? 'selected' : '' }}>30 minutos</option>
                        <option value="60" {{ old('reminder_minutes', $task->reminder_minutes) == 60 ? 'selected' : '' }}>1 hora</option>
                    </select>
                </div>
            </div>

            {{-- Notificar --}}
            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="notify_on_complete" value="1" {{ old('notify_on_complete', $task->notify_on_complete) ? 'checked' : '' }} class="w-4 h-4 text-primary-300 bg-white border-gray-300 rounded focus:ring-primary-300">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Notificar al cliente al completar</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Enviar notificación por WhatsApp</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <form action="{{ route('superlinkiu.linkiudev.tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta tarea?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:underline">Eliminar tarea</button>
            </form>
            <div class="flex gap-3">
                <a href="{{ route('superlinkiu.linkiudev.tasks.show', $task) }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Guardar
                </button>
            </div>
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
</script>
@endpush
