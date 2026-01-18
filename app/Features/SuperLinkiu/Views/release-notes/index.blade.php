@extends('shared::layouts.admin')

@section('title', 'Gestión de Release Notes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        {{-- SECTION: Header --}}
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Gestión de Release Notes</h2>
                    <p class="text-sm text-gray-600">Administra las notas de versión y actualizaciones</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.release-notes.create') }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Crear Release Note
                    </a>
                </div>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Statistics --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
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

                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Versión Actual</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['current'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="star" class="w-5 h-5 text-yellow-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Statistics --}}

        {{-- SECTION: Filters --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Versión o descripción..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Filtrar
                    </button>
                    <a href="{{ route('superlinkiu.release-notes.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </a>
                </div>
            </form>
        </div>
        {{-- End SECTION: Filters --}}

        {{-- SECTION: Release Notes List --}}
        <div class="px-6 py-4">
            @if($releaseNotes->count() > 0)
                <div class="space-y-4">
                    @foreach($releaseNotes as $releaseNote)
                        <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            v{{ $releaseNote->version }}
                                        </h3>
                                        @if($releaseNote->is_current)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                Versión Actual
                                            </span>
                                        @endif
                                        @if($releaseNote->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Inactivo
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                            {{ $releaseNote->release_date->format('d/m/Y') }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="list" class="w-4 h-4"></i>
                                            {{ $releaseNote->items->count() }} items
                                        </span>
                                    </div>

                                    @if($releaseNote->items->count() > 0)
                                        <div class="mt-3 space-y-1">
                                            @foreach($releaseNote->items->take(3) as $item)
                                                <div class="flex items-start gap-2 text-sm text-gray-600">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                        {{ $item->type === 'new' ? 'bg-green-100 text-green-700' : '' }}
                                                        {{ $item->type === 'fix' ? 'bg-blue-100 text-blue-700' : '' }}
                                                        {{ $item->type === 'improvement' ? 'bg-purple-100 text-purple-700' : '' }}
                                                        {{ $item->type === 'deprecated' ? 'bg-orange-100 text-orange-700' : '' }}
                                                    ">
                                                        {{ $item->type_label }}
                                                    </span>
                                                    <span class="flex-1">{{ \Illuminate\Support\Str::limit($item->description, 80) }}</span>
                                                </div>
                                            @endforeach
                                            @if($releaseNote->items->count() > 3)
                                                <p class="text-xs text-gray-500 mt-1">+{{ $releaseNote->items->count() - 3 }} más...</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('superlinkiu.release-notes.edit', $releaseNote) }}" 
                                       class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('superlinkiu.release-notes.destroy', $releaseNote) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta nota de versión?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($releaseNotes->hasPages())
                    <div class="mt-6">
                        {{ $releaseNotes->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i data-lucide="file-text" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay release notes</h3>
                    <p class="text-gray-600 mb-4">Crea tu primera nota de versión para comenzar</p>
                    <a href="{{ route('superlinkiu.release-notes.create') }}" 
                       class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Crear Release Note
                    </a>
                </div>
            @endif
        </div>
        {{-- End SECTION: Release Notes List --}}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
