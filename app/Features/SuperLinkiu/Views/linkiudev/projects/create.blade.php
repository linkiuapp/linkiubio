@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Nuevo Proyecto')

@section('content')
<div class="container-fluid max-w-3xl">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('superlinkiu.linkiudev.projects.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Nuevo Proyecto</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Crea un nuevo proyecto de desarrollo</p>
        </div>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('superlinkiu.linkiudev.projects.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        @csrf

        <div class="space-y-6">
            {{-- Cliente --}}
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Cliente <span class="text-red-500">*</span>
                </label>
                <select 
                    name="client_id" 
                    id="client_id"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('client_id') border-red-500 @enderror"
                >
                    <option value="">Selecciona un cliente</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $selectedClientId) == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nombre del Proyecto <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('name') border-red-500 @enderror"
                    placeholder="Ej: Diseño Web Empresa X"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
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
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('description') border-red-500 @enderror"
                    placeholder="Descripción del proyecto..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado y Prioridad --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Estado
                    </label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    >
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>En Pausa</option>
                    </select>
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Prioridad
                    </label>
                    <select 
                        name="priority" 
                        id="priority"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    >
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Baja</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Media</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            {{-- Fechas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fecha de Inicio
                    </label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    >
                </div>
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fecha Límite
                    </label>
                    <input 
                        type="date" 
                        name="due_date" 
                        id="due_date"
                        value="{{ old('due_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300"
                    >
                </div>
            </div>

            {{-- Notificaciones --}}
            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="notify_client_on_status_change" 
                        value="1"
                        {{ old('notify_client_on_status_change', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-300 bg-white border-gray-300 rounded focus:ring-primary-300"
                    >
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Notificar al cliente</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Enviar notificación por WhatsApp cuando cambie el estado del proyecto</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('superlinkiu.linkiudev.projects.index') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Crear Proyecto
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
</script>
@endpush
