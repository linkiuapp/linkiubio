@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Editar Cliente')

@section('content')
<div class="container-fluid max-w-3xl">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('superlinkiu.linkiudev.clients.show', $client) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Editar Cliente</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $client->name }}</p>
        </div>
    </div>

    {{-- Formulario --}}
    <form action="{{ route('superlinkiu.linkiudev.clients.update', $client) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nombre o Empresa <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name', $client->name) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Teléfono (WhatsApp) <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <select 
                        name="country_code" 
                        class="w-auto min-w-[140px] px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-200 focus:border-blue-500"
                    >
                        <option value="+57" {{ old('country_code', $client->country_code) === '+57' ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="+52" {{ old('country_code', $client->country_code) === '+52' ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="+507" {{ old('country_code', $client->country_code) === '+507' ? 'selected' : '' }}>🇵🇦 +507</option>
                        <option value="+1" {{ old('country_code', $client->country_code) === '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+34" {{ old('country_code', $client->country_code) === '+34' ? 'selected' : '' }}>🇪🇸 +34</option>
                        <option value="+51" {{ old('country_code', $client->country_code) === '+51' ? 'selected' : '' }}>🇵🇪 +51</option>
                        <option value="+54" {{ old('country_code', $client->country_code) === '+54' ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="+56" {{ old('country_code', $client->country_code) === '+56' ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="+593" {{ old('country_code', $client->country_code) === '+593' ? 'selected' : '' }}>🇪🇨 +593</option>
                    </select>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone"
                        value="{{ old('phone', $client->phone) }}"
                        required
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('phone') border-red-500 @enderror"
                    >
                </div>
                @error('phone')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email (opcional)
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    value="{{ old('email', $client->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notas --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Notas (opcional)
                </label>
                <textarea 
                    name="notes" 
                    id="notes"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-300 @error('notes') border-red-500 @enderror"
                >{{ old('notes', $client->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <form action="{{ route('superlinkiu.linkiudev.clients.toggle-active', $client) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-{{ $client->is_active ? 'red' : 'green' }}-600 hover:underline">
                    {{ $client->is_active ? 'Desactivar cliente' : 'Activar cliente' }}
                </button>
            </form>
            <div class="flex gap-3">
                <a href="{{ route('superlinkiu.linkiudev.clients.show', $client) }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
