@php
    $contextLabels = [
        'store' => 'Tiendas',
        'tenant_admin' => 'Admin Tiendas',
        'website' => 'Sitio Web',
        'super_admin' => 'Super Admin',
    ];
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Imagen
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Contexto
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Categoría
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Formato
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($images as $image)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ $image->url }}" 
                                 alt="{{ $image->name }}" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $image->name }}</h3>
                            @if($image->url)
                                <a href="{{ $image->url }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-sm text-blue-600 hover:text-blue-800 mt-1 inline-flex items-center gap-1">
                                    <span>{{ Str::limit($image->url, 40) }}</span>
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            @else
                                <p class="text-sm text-gray-400 mt-1">Sin URL</p>
                            @endif
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-900">{{ $contextLabels[$image->context] ?? $image->context }}</span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst(str_replace('_', ' ', $image->category)) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ strtoupper($image->mime_type === 'image/svg+xml' ? 'SVG' : 'WebP') }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($image->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactivo
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('superlinkiu.ui-images.edit', $image) }}"
                               class="text-gray-600 hover:text-gray-800"
                               title="Editar">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('superlinkiu.ui-images.destroy', $image) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?');">
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
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i data-lucide="image" class="w-12 h-12 text-gray-400 mb-4"></i>
                            <p class="text-gray-500 font-medium">No se encontraron imágenes</p>
                            <p class="text-gray-400 text-sm mt-1">Crea tu primera imagen para comenzar</p>
                            <a href="{{ route('superlinkiu.ui-images.create', ['context' => request('context', 'store')]) }}" 
                               class="mt-4 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                Agregar Primera Imagen
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="pagination-container">
    @if($images->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $images->appends(request()->query())->links() }}
        </div>
    @endif
</div>
