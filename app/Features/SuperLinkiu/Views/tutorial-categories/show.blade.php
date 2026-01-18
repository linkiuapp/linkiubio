@extends('shared::layouts.admin')

@section('title', $tutorialCategory->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('superlinkiu.tutorial-categories.index') }}" class="inline-flex items-center justify-center">
            <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-800">{{ $tutorialCategory->name }}</h1>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Información</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Slug:</p>
                        <p class="font-medium text-gray-900">{{ $tutorialCategory->slug }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Estado:</p>
                        @if($tutorialCategory->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activa
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactiva
                            </span>
                        @endif
                    </div>
                    @if($tutorialCategory->description)
                        <div class="col-span-2">
                            <p class="text-gray-500">Descripción:</p>
                            <p class="text-gray-900">{{ $tutorialCategory->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Tutoriales ({{ $tutorialCategory->tutorials->count() }})</h2>
                    <a href="{{ route('superlinkiu.tutorials.create', ['category_id' => $tutorialCategory->id]) }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        Crear tutorial en esta categoría
                    </a>
                </div>
                
                @if($tutorialCategory->tutorials->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tutorialCategory->tutorials as $tutorial)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $tutorial->title }}</td>
                                        <td class="px-6 py-4">
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
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('superlinkiu.tutorials.edit', $tutorial) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No hay tutoriales en esta categoría</p>
                @endif
            </div>
        </div>
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
