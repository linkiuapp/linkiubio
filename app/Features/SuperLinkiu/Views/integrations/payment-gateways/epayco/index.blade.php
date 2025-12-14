@extends('shared::layouts.admin')

@section('title', 'Configuración de Epayco')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Configuración de Epayco</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona las credenciales y configuración de la pasarela de pagos Epayco</p>
        </div>
        <a href="{{ route('superlinkiu.integrations.payment-gateways.epayco.transactions') }}" 
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
            <i data-lucide="list" class="w-4 h-4"></i>
            Ver Transacciones
        </a>
    </div>

    {{-- Formulario --}}
    <form method="POST" action="{{ route('superlinkiu.integrations.payment-gateways.epayco.store') }}">
        @csrf

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{-- Sección: Estado y Modo --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-blue-600"></i>
                    Estado y Configuración
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre para Mostrar <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="display_name"
                               value="{{ old('display_name', $epayco->display_name ?? 'Epayco') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('display_name') border-red-300 @enderror"
                               required>
                        @error('display_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <input type="text"
                               name="description"
                               value="{{ old('description', $epayco->description ?? 'Pasarela de pagos Epayco') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                               placeholder="Descripción de la pasarela">
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $epayco->is_active ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Activar Epayco</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                   name="is_test_mode"
                                   value="1"
                                   {{ old('is_test_mode', $epayco->is_test_mode ?? true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Modo Prueba (Sandbox)</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Sección: Credenciales para Checkout Tradicional --}}
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <i data-lucide="key" class="w-5 h-5 text-blue-600"></i>
                            Llaves Secretas (Checkout Tradicional)
                        </h2>
                        <p class="text-xs text-gray-600 mt-1">Utiliza estas llaves para la integración personalizada desde su página web</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Llaves secretas</h3>
                    <p class="text-xs text-gray-600 mb-4">Datos de configuración para la integración personalizada, copie estos datos y colóquelos en su formulario de envío POST.</p>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            P_CUST_ID_CLIENTE <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="customer_id"
                               value="{{ old('customer_id', $epayco ? $epayco->getCredential('customer_id') : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('customer_id') border-red-300 @enderror font-mono text-sm bg-gray-50"
                               placeholder="Ej: 1569692"
                               required>
                        @error('customer_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            P_KEY <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="p_key_input"
                                   name="p_key"
                                   value="{{ old('p_key', $epayco ? $epayco->getCredential('p_key') : '') }}"
                                   class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('p_key') border-red-300 @enderror font-mono text-sm bg-gray-50"
                                   placeholder="Ingresa tu P_KEY"
                                   required>
                            <button type="button"
                                    onclick="togglePasswordVisibility('p_key_input', 'p_key_eye')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" id="p_key_eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('p_key')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Sección: Credenciales para API REST --}}
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <i data-lucide="key" class="w-5 h-5 text-green-600"></i>
                            Llaves Secretas API Rest, Onpage Checkout, Standard Checkout
                        </h2>
                        <p class="text-xs text-gray-600 mt-1">Datos de configuración para la integración personalizada con nuestro API Rest, Onpage Checkout, Standard Checkout.</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            PUBLIC_KEY (apiKey) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="public_key_input"
                                   name="public_key"
                                   value="{{ old('public_key', $epayco ? $epayco->getCredential('public_key') : '') }}"
                                   class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('public_key') border-red-300 @enderror font-mono text-sm bg-gray-50"
                                   placeholder="Ingresa tu PUBLIC_KEY"
                                   required>
                            <button type="button"
                                    onclick="togglePasswordVisibility('public_key_input', 'public_key_eye')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" id="public_key_eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('public_key')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Usada para autenticación en API REST</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            PRIVATE_KEY (privateKey) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="private_key_input"
                                   name="private_key"
                                   value="{{ old('private_key', $epayco ? $epayco->getCredential('private_key') : '') }}"
                                   class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('private_key') border-red-300 @enderror font-mono text-sm bg-gray-50"
                                   placeholder="Ingresa tu PRIVATE_KEY"
                                   required>
                            <button type="button"
                                    onclick="togglePasswordVisibility('private_key_input', 'private_key_eye')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" id="private_key_eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('private_key')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Usada para autenticación en API REST</p>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('superlinkiu.dashboard') }}" 
                   class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Guardar Configuración
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <p class="text-sm text-green-800">{{ session('success') }}</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        }
    });

    function togglePasswordVisibility(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        
        if (input.type === 'password') {
            input.type = 'text';
            eye.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            eye.setAttribute('data-lucide', 'eye');
        }
        
        if (window.lucide) {
            lucide.createIcons();
        }
    }
</script>
@endpush
@endsection

