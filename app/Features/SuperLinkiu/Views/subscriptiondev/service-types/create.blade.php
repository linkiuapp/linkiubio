@extends('shared::layouts.admin')

@section('title', 'Nuevo Tipo de Servicio')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.service-types.index') }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Nuevo Tipo de Servicio</h1>
            <p class="text-sm text-gray-600">Define un nuevo tipo de suscripción</p>
        </div>
    </div>

    <form action="{{ route('superlinkiu.subscriptiondev.service-types.store') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
        @csrf

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej: Dominio .com" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                    <select name="category" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="description" rows="2" placeholder="Descripción del servicio..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio Base *</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">$</span>
                        <input type="number" name="default_price" value="{{ old('default_price') }}" required min="0" step="0.01" placeholder="150000" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-r-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Moneda</label>
                    <select name="currency" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        <option value="COP" {{ old('currency', 'COP') === 'COP' ? 'selected' : '' }}>COP</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Precios por Período (opcional)</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Mensual</label>
                        <input type="number" name="price_monthly" value="{{ old('price_monthly') }}" min="0" step="0.01" placeholder="50000" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Trimestral</label>
                        <input type="number" name="price_quarterly" value="{{ old('price_quarterly') }}" min="0" step="0.01" placeholder="140000" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Semestral</label>
                        <input type="number" name="price_semiannual" value="{{ old('price_semiannual') }}" min="0" step="0.01" placeholder="270000" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Anual</label>
                        <input type="number" name="price_annual" value="{{ old('price_annual') }}" min="0" step="0.01" placeholder="500000" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-24 px-3 py-2.5 border border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Orden de aparición en las listas</p>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 rounded-b-lg">
            <a href="{{ route('superlinkiu.subscriptiondev.service-types.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Crear Tipo</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
