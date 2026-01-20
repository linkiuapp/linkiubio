@extends('shared::layouts.admin')

@section('title', 'Nueva Herramienta de Linkiu')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6" x-data="toolForm()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.linkiu-tools.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Nueva Herramienta de Linkiu</h1>
                <p class="text-sm text-gray-600 mt-1">Registra una nueva herramienta o servicio utilizado en Linkiu</p>
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-medium text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('superlinkiu.linkiu-tools.store') }}" class="space-y-6">
        @csrf

        {{-- Sección 1: Información Básica --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    Información Básica
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                            Nombre de la Herramienta <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               x-model="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-300 @enderror"
                               placeholder="Ej: Stripe, AWS, SendGrid"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-800 mb-2">
                            Categoría
                        </label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                               x-model="category"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ej: Pagos, Hosting, Email">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                        Para qué sirve
                        <button type="button" @click="generateDescription()" 
                                :disabled="generatingDescription"
                                class="ml-2 px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 disabled:opacity-50">
                            <span x-show="!generatingDescription">✨ Generar con IA</span>
                            <span x-show="generatingDescription">Generando...</span>
                        </button>
                    </label>
                    <textarea id="description" name="description" rows="4"
                              x-model="description"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Descripción general de la herramienta...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="usage_in_linkiu" class="block text-sm font-medium text-gray-800 mb-2">
                        Para qué lo usamos en Linkiu
                        <button type="button" @click="generateUsage()" 
                                :disabled="generatingUsage || !description"
                                class="ml-2 px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 disabled:opacity-50">
                            <span x-show="!generatingUsage">✨ Generar con IA</span>
                            <span x-show="generatingUsage">Generando...</span>
                        </button>
                    </label>
                    <textarea id="usage_in_linkiu" name="usage_in_linkiu" rows="4"
                              x-model="usageInLinkiu"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Explicación de cómo se usa esta herramienta en Linkiu...">{{ old('usage_in_linkiu') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sección 2: URLs y Enlaces --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="link" class="w-5 h-5 text-green-600"></i>
                    URLs y Enlaces
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-800 mb-2">URL Principal</label>
                    <input type="url" id="url" name="url" value="{{ old('url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://...">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="dashboard_url" class="block text-sm font-medium text-gray-800 mb-2">URL del Panel</label>
                        <input type="url" id="dashboard_url" name="dashboard_url" value="{{ old('dashboard_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://...">
                    </div>
                    <div>
                        <label for="api_docs_url" class="block text-sm font-medium text-gray-800 mb-2">URL de Documentación API</label>
                        <input type="url" id="api_docs_url" name="api_docs_url" value="{{ old('api_docs_url') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 3: Facturación --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                    Facturación
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="billing_type" class="block text-sm font-medium text-gray-800 mb-2">
                            Tipo de Facturación <span class="text-red-500">*</span>
                        </label>
                        <select id="billing_type" name="billing_type" 
                                x-model="billingType"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="free">Gratis</option>
                            <option value="monthly">Mensual</option>
                            <option value="yearly">Anual</option>
                            <option value="pay_per_use">Por uso</option>
                        </select>
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-800 mb-2">Moneda</label>
                        <select id="currency" name="currency" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="USD">USD</option>
                            <option value="COP">COP</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="billingType !== 'free' && billingType !== 'pay_per_use'">
                    <div>
                        <label for="monthly_cost" class="block text-sm font-medium text-gray-800 mb-2">Costo Mensual</label>
                        <input type="number" id="monthly_cost" name="monthly_cost" value="{{ old('monthly_cost') }}"
                               step="0.01" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="yearly_cost" class="block text-sm font-medium text-gray-800 mb-2">Costo Anual</label>
                        <input type="number" id="yearly_cost" name="yearly_cost" value="{{ old('yearly_cost') }}"
                               step="0.01" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0.00">
                    </div>
                </div>
                {{-- Campos para herramientas pay_per_use --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4" x-show="billingType === 'pay_per_use'">
                    <div>
                        <label for="minimum_recharge" class="block text-sm font-medium text-gray-800 mb-2">Recarga Mínima Recomendada</label>
                        <input type="number" id="minimum_recharge" name="minimum_recharge" value="{{ old('minimum_recharge') }}"
                               step="0.01" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0.00">
                        <p class="text-xs text-gray-500 mt-1">Monto mínimo recomendado para recargar</p>
                    </div>
                    <div>
                        <label for="current_balance" class="block text-sm font-medium text-gray-800 mb-2">Saldo Actual (Opcional)</label>
                        <input type="number" id="current_balance" name="current_balance" value="{{ old('current_balance') }}"
                               step="0.01" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0.00">
                        <p class="text-xs text-gray-500 mt-1">Saldo actual si está disponible</p>
                    </div>
                    <div>
                        <label for="balance_currency" class="block text-sm font-medium text-gray-800 mb-2">Moneda del Saldo</label>
                        <select id="balance_currency" name="balance_currency" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Misma que moneda principal</option>
                            <option value="USD">USD</option>
                            <option value="COP">COP</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-800 mb-2">Fecha de Inicio</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="next_renewal_date" class="block text-sm font-medium text-gray-800 mb-2">Próxima Renovación</label>
                        <input type="date" id="next_renewal_date" name="next_renewal_date" value="{{ old('next_renewal_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 4: Credenciales --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="lock" class="w-5 h-5 text-red-600"></i>
                    Credenciales (Se encriptarán automáticamente)
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-800 mb-2">Usuario</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Usuario o email">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800 mb-2">Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                   x-bind:type="showPassword ? 'text' : 'password'"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" x-show="!showPassword" class="w-4 h-4"></i>
                                <i data-lucide="eye-off" x-show="showPassword" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="api_key" class="block text-sm font-medium text-gray-800 mb-2">API Key</label>
                        <div class="relative">
                            <input type="password" id="api_key" name="api_key" value="{{ old('api_key') }}"
                                   x-bind:type="showApiKey ? 'text' : 'password'"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="sk_...">
                            <button type="button" @click="showApiKey = !showApiKey"
                                    class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" x-show="!showApiKey" class="w-4 h-4"></i>
                                <i data-lucide="eye-off" x-show="showApiKey" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="api_secret" class="block text-sm font-medium text-gray-800 mb-2">API Secret</label>
                        <div class="relative">
                            <input type="password" id="api_secret" name="api_secret" value="{{ old('api_secret') }}"
                                   x-bind:type="showApiSecret ? 'text' : 'password'"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="••••••••">
                            <button type="button" @click="showApiSecret = !showApiSecret"
                                    class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">
                                <i data-lucide="eye" x-show="!showApiSecret" class="w-4 h-4"></i>
                                <i data-lucide="eye-off" x-show="showApiSecret" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-800 mb-2">ID de Cuenta</label>
                    <input type="text" id="account_id" name="account_id" value="{{ old('account_id') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="ID o número de cuenta">
                </div>
            </div>
        </div>

        {{-- Sección 5: Configuración Adicional --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-gray-600"></i>
                    Configuración Adicional
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-800 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="active">Activa</option>
                            <option value="inactive">Inactiva</option>
                            <option value="deprecated">Deprecada</option>
                        </select>
                    </div>
                    <div>
                        <label for="responsible_team" class="block text-sm font-medium text-gray-800 mb-2">Equipo Responsable</label>
                        <input type="text" id="responsible_team" name="responsible_team" value="{{ old('responsible_team') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ej: Desarrollo, DevOps">
                    </div>
                </div>
                <div>
                    <label for="notification_phone" class="block text-sm font-medium text-gray-800 mb-2">
                        Teléfono para Notificaciones WhatsApp
                    </label>
                    <input type="text" id="notification_phone" name="notification_phone" value="{{ old('notification_phone') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="+57XXXXXXXXXX">
                    <p class="mt-1 text-xs text-gray-600">Formato: +57 seguido del número (ej: +573001234567)</p>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_critical" name="is_critical" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_critical" class="text-sm font-medium text-gray-800">
                        Es crítica para el funcionamiento de Linkiu
                    </label>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-800 mb-2">Notas Adicionales</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Notas, observaciones, instrucciones...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('superlinkiu.linkiu-tools.index') }}" 
               class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Crear Herramienta
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('toolForm', () => ({
        name: '',
        category: '',
        description: '',
        usageInLinkiu: '',
        billingType: 'free',
        showPassword: false,
        showApiKey: false,
        showApiSecret: false,
        generatingDescription: false,
        generatingUsage: false,

        async generateDescription() {
            if (!this.name) {
                alert('Por favor ingresa el nombre de la herramienta primero');
                return;
            }

            this.generatingDescription = true;
            try {
                const response = await fetch('{{ route("superlinkiu.linkiu-tools.generate-description") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: this.name,
                        category: this.category
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.description = data.description;
                } else {
                    alert('Error: ' + (data.message || 'No se pudo generar la descripción'));
                }
            } catch (error) {
                alert('Error al generar descripción: ' + error.message);
            } finally {
                this.generatingDescription = false;
            }
        },

        async generateUsage() {
            if (!this.description) {
                alert('Por favor genera o ingresa la descripción primero');
                return;
            }

            this.generatingUsage = true;
            try {
                const response = await fetch('{{ route("superlinkiu.linkiu-tools.generate-usage") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: this.name,
                        description: this.description
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.usageInLinkiu = data.usage;
                } else {
                    alert('Error: ' + (data.message || 'No se pudo generar el uso'));
                }
            } catch (error) {
                alert('Error al generar uso: ' + error.message);
            } finally {
                this.generatingUsage = false;
            }
        }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
