<x-tenant-admin-layout :store="$store">
@section('title', 'Crear Tipo de Habitación')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-accent-50 rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-black-500 mb-2">Crear Tipo de Habitación</h2>
                <p class="text-sm text-black-300">Define un nuevo tipo de habitación con sus características y precios</p>
            </div>
            <a href="{{ route('tenant.admin.hotel.room-types.index', $store->slug) }}" 
               class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 inline mr-2"></i>
                Volver
            </a>
        </div>

        <form method="POST" action="{{ route('tenant.admin.hotel.room-types.store', $store->slug) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Información Básica -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-black-500 border-b border-accent-100 pb-2">Información Básica</h3>
                
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Nombre del Tipo *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                    @error('name')
                        <p class="mt-1 text-sm text-error-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Capacidad -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-black-500 border-b border-accent-100 pb-2">Capacidad</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Capacidad Máxima *</label>
                        <input type="number" name="max_occupancy" value="{{ old('max_occupancy', 2) }}" min="1" max="50" required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        @error('max_occupancy')
                            <p class="mt-1 text-sm text-error-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Personas Incluidas (Base) *</label>
                        <input type="number" name="base_occupancy" value="{{ old('base_occupancy', 2) }}" min="1" max="50" required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        <p class="mt-1 text-xs text-black-300">Incluidas en el precio base por noche</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Máximo Adultos (opcional)</label>
                        <input type="number" name="max_adults" value="{{ old('max_adults') }}" min="1"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Máximo Niños (opcional)</label>
                        <input type="number" name="max_children" value="{{ old('max_children') }}" min="0"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                    </div>
                </div>
            </div>

            <!-- Precios -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-black-500 border-b border-accent-100 pb-2">Precios</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Precio Base por Noche *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-black-300">$</span>
                            <input type="number" name="base_price_per_night" value="{{ old('base_price_per_night') }}" step="0.01" min="0" required
                                   class="w-full pl-8 pr-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        </div>
                        @error('base_price_per_night')
                            <p class="mt-1 text-sm text-error-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-2">Precio por Persona Adicional</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-black-300">$</span>
                            <input type="number" name="extra_person_price" value="{{ old('extra_person_price', 0) }}" step="0.01" min="0"
                                   class="w-full pl-8 pr-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        </div>
                        <p class="mt-1 text-xs text-black-300">Cargo adicional por persona extra sobre el base_occupancy</p>
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-black-500 border-b border-accent-100 pb-2">Estado</h3>
                
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                           class="w-4 h-4 text-primary-300 border-accent-200 rounded focus:ring-primary-200">
                    <label class="text-sm font-medium text-black-400">Habilitar este tipo de habitación</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Orden de Visualización</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                    <p class="mt-1 text-xs text-black-300">Número menor = aparece primero</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-accent-100">
                <a href="{{ route('tenant.admin.hotel.room-types.index', $store->slug) }}" 
                   class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    Crear Tipo de Habitación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
</x-tenant-admin-layout>

