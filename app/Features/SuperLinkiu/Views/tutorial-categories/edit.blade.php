@extends('shared::layouts.admin')

@section('title', 'Editar Categoría')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('superlinkiu.tutorial-categories.index') }}" class="inline-flex items-center justify-center">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-800">Editar Categoría</h1>
    </div>

    <form action="{{ route('superlinkiu.tutorial-categories.update', $tutorialCategory) }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $tutorialCategory->name) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug (URL amigable)
                </label>
                <input type="text" 
                       name="slug" 
                       value="{{ old('slug', $tutorialCategory->slug) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea name="description" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">{{ old('description', $tutorialCategory->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Icono (nombre de Lucide)
                </label>
                <input type="text" 
                       name="icon" 
                       value="{{ old('icon', $tutorialCategory->icon) }}"
                       placeholder="book-open, video, etc."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Orden
                </label>
                <input type="number" 
                       name="order" 
                       value="{{ old('order', $tutorialCategory->order) }}"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active"
                       value="1"
                       {{ old('is_active', $tutorialCategory->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                    Categoría activa
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-6">
            <a href="{{ route('superlinkiu.tutorial-categories.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium">
                Actualizar Categoría
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
