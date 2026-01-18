@extends('shared::layouts.admin')

@section('title', 'Categorías de Tutoriales')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('superlinkiu.tutorials.index') }}" class="inline-flex items-center justify-center">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-800">Categorías de Tutoriales</h1>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Categorías de Tutoriales</h2>
                    <p class="text-sm text-gray-600">Administra las categorías para organizar los tutoriales</p>
                </div>
                <a href="{{ route('superlinkiu.tutorial-categories.create') }}" 
                   class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Crear Categoría
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tutoriales</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($category->icon)
                                        <i data-lucide="{{ $category->icon }}" class="w-5 h-5 text-gray-600"></i>
                                    @endif
                                    <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->tutorials()->count() }}</td>
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.tutorial-categories.edit', $category) }}" 
                                       class="text-gray-600 hover:text-gray-800">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('superlinkiu.tutorial-categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('¿Estás seguro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No hay categorías creadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
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
