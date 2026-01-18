@extends('shared::layouts.admin')

@section('title', 'Gestión de Tutoriales')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        {{-- SECTION: Header --}}
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Gestión de Tutoriales</h2>
                    <p class="text-sm text-gray-600">Administra los tutoriales y guías para usuarios</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.tutorial-categories.index') }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="folder" class="w-5 h-5"></i>
                        Categorías
                    </a>
                    <a href="{{ route('superlinkiu.tutorial-tags.index') }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="tags" class="w-5 h-5"></i>
                        Etiquetas
                    </a>
                    <a href="{{ route('superlinkiu.tutorials.create') }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Crear Tutorial
                    </a>
                </div>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Statistics --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="book-open" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Activos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Inactivos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="x-circle" class="w-5 h-5 text-gray-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Statistics --}}

        {{-- SECTION: Filters --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dificultad</label>
                    <select name="difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todos los niveles</option>
                        @foreach($difficulties as $key => $label)
                            <option value="{{ $key }}" {{ request('difficulty') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Título o contenido..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 flex-1 justify-center font-medium transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('superlinkiu.tutorials.index') }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                </div>
            </form>
        </div>
        {{-- End SECTION: Filters --}}

        {{-- SECTION: Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tutorial
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Categoría
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Dificultad
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Vistas
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tutorials as $tutorial)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $tutorial->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($tutorial->description, 80) }}
                                    </p>
                                    @if($tutorial->tags->isNotEmpty())
                                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                                            @foreach($tutorial->tags->take(3) as $tag)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                            @if($tutorial->tags->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $tutorial->tags->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $tutorial->category->name }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $colors = [
                                        'beginner' => 'bg-green-100 text-green-800',
                                        'intermediate' => 'bg-yellow-100 text-yellow-800',
                                        'advanced' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$tutorial->difficulty_level] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $tutorial->difficulty_label }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tutorial->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($tutorial->views_count) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.tutorials.show', $tutorial) }}"
                                       class="text-blue-600 hover:text-blue-800"
                                       title="Ver">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('superlinkiu.tutorials.edit', $tutorial) }}"
                                       class="text-gray-600 hover:text-gray-800"
                                       title="Editar">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('superlinkiu.tutorials.destroy', $tutorial) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este tutorial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800"
                                                title="Eliminar">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="book-open" class="w-12 h-12 text-gray-400 mb-4"></i>
                                    <p class="text-gray-500 font-medium">No se encontraron tutoriales</p>
                                    <p class="text-gray-400 text-sm mt-1">Crea tu primer tutorial para comenzar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- End SECTION: Table --}}

        {{-- SECTION: Pagination --}}
        @if($tutorials->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tutorials->links() }}
            </div>
        @endif
        {{-- End SECTION: Pagination --}}
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
