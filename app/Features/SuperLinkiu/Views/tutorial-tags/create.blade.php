@extends('shared::layouts.admin')

@section('title', 'Crear Etiqueta')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('superlinkiu.tutorial-tags.index') }}" class="inline-flex items-center justify-center">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-800">Crear Nueva Etiqueta</h1>
    </div>

    <form action="{{ route('superlinkiu.tutorial-tags.store') }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-6">
        @csrf

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug (URL amigable)
                </label>
                <input type="text" 
                       name="slug" 
                       value="{{ old('slug') }}"
                       placeholder="Se genera automáticamente"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-6">
            <a href="{{ route('superlinkiu.tutorial-tags.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium">
                Crear Etiqueta
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
