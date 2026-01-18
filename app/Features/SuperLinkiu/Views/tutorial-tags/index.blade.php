@extends('shared::layouts.admin')

@section('title', 'Etiquetas de Tutoriales')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('superlinkiu.tutorials.index') }}" class="inline-flex items-center justify-center">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-800">Etiquetas de Tutoriales</h1>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Etiquetas de Tutoriales</h2>
                    <p class="text-sm text-gray-600">Administra las etiquetas para categorizar los tutoriales</p>
                </div>
                <a href="{{ route('superlinkiu.tutorial-tags.create') }}" 
                   class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Crear Etiqueta
                </a>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-gray-200">
            <form method="GET" class="flex gap-4">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar etiquetas..."
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg">
                    Buscar
                </button>
                <a href="{{ route('superlinkiu.tutorial-tags.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Limpiar
                </a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Slug</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tags as $tag)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $tag->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $tag->slug }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.tutorial-tags.edit', $tag) }}" 
                                       class="text-gray-600 hover:text-gray-800">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('superlinkiu.tutorial-tags.destroy', $tag) }}" 
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
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                No hay etiquetas creadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tags->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tags->links() }}
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
