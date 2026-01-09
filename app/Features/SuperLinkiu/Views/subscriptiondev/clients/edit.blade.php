@extends('shared::layouts.admin')

@section('title', 'Editar Cliente')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.clients.show', $client) }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Editar Cliente</h1>
            <p class="text-sm text-gray-600">{{ $client->name }}</p>
        </div>
    </div>

    <form action="{{ route('superlinkiu.subscriptiondev.clients.update', $client) }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono (WhatsApp)</label>
                <div class="flex gap-2">
                    <select name="country_code" class="w-auto min-w-[120px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        <option value="+57" {{ old('country_code', $client->country_code) === '+57' ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="+52" {{ old('country_code', $client->country_code) === '+52' ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="+507" {{ old('country_code', $client->country_code) === '+507' ? 'selected' : '' }}>🇵🇦 +507</option>
                        <option value="+1" {{ old('country_code', $client->country_code) === '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                    </select>
                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                    <select name="document_type" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                        <option value="">Seleccionar...</option>
                        <option value="CC" {{ old('document_type', $client->document_type) === 'CC' ? 'selected' : '' }}>Cédula</option>
                        <option value="CE" {{ old('document_type', $client->document_type) === 'CE' ? 'selected' : '' }}>Cédula Extranjería</option>
                        <option value="NIT" {{ old('document_type', $client->document_type) === 'NIT' ? 'selected' : '' }}>NIT</option>
                        <option value="PA" {{ old('document_type', $client->document_type) === 'PA' ? 'selected' : '' }}>Pasaporte</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento</label>
                    <input type="text" name="document" value="{{ old('document', $client->document) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">{{ old('notes', $client->notes) }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $client->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                <label for="is_active" class="text-sm text-gray-700">Cliente activo</label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between rounded-b-lg">
            @if($client->subscriptions()->count() == 0)
                <form action="{{ route('superlinkiu.subscriptiondev.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 font-medium">Eliminar Cliente</button>
                </form>
            @else
                <span></span>
            @endif
            <div class="flex gap-3">
                <a href="{{ route('superlinkiu.subscriptiondev.clients.show', $client) }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Guardar Cambios</button>
            </div>
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
