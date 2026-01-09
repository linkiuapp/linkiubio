@extends('shared::layouts.admin')

@section('title', 'Editar Tipo de Servicio')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.service-types.index') }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Editar Tipo de Servicio</h1>
            <p class="text-sm text-gray-600">{{ $serviceType->name }}</p>
        </div>
    </div>

    <form action="{{ route('superlinkiu.subscriptiondev.service-types.update', $serviceType) }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $serviceType->name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                    <select name="category" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $serviceType->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">{{ old('description', $serviceType->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio Base *</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">$</span>
                        <input type="number" name="default_price" value="{{ old('default_price', $serviceType->default_price) }}" required min="0" step="0.01" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-r-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Moneda</label>
                    <select name="currency" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        <option value="COP" {{ old('currency', $serviceType->currency) === 'COP' ? 'selected' : '' }}>COP</option>
                        <option value="USD" {{ old('currency', $serviceType->currency) === 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Precios por Período (opcional)</h4>
                @php
                    $prices = $serviceType->period_prices ?? [];
                @endphp
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Mensual</label>
                        <input type="number" name="price_monthly" value="{{ old('price_monthly', $prices['monthly'] ?? '') }}" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Trimestral</label>
                        <input type="number" name="price_quarterly" value="{{ old('price_quarterly', $prices['quarterly'] ?? '') }}" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Semestral</label>
                        <input type="number" name="price_semiannual" value="{{ old('price_semiannual', $prices['semiannual'] ?? '') }}" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Anual</label>
                        <input type="number" name="price_annual" value="{{ old('price_annual', $prices['annual'] ?? '') }}" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $serviceType->sort_order) }}" min="0" class="w-24 px-3 py-2.5 border border-gray-300 rounded-lg">
                </div>
                <div class="flex items-center pt-6">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $serviceType->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Activo</label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 rounded-b-lg">
            <a href="{{ route('superlinkiu.subscriptiondev.service-types.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Guardar Cambios</button>
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
