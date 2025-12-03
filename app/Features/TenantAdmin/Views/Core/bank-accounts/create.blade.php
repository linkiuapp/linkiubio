<x-tenant-admin-layout :store="$store">

@section('title', 'Nueva Cuenta Bancaria')

@section('content')
<div class="space-y-4">
    {{-- Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.payment-methods.bank-accounts.index', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id]) }}" 
                   class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
        <div>
                    <h2 class="text-lg font-semibold text-gray-900">Nueva Cuenta Bancaria</h2>
                    <p class="text-sm text-gray-500">{{ $paymentMethod->name }}</p>
        </div>
    </div>
        </div>

            <form action="{{ route('tenant.admin.bank-accounts.store', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id]) }}" 
                  method="POST"
              class="p-6">
                @csrf
                
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Banco --}}
                        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Banco <span class="text-red-500">*</span>
                            </label>
                    <input type="text" name="bank_name" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('bank_name') border-red-300 @enderror"
                           value="{{ old('bank_name') }}" 
                           placeholder="Ej: Bancolombia, Davivienda..."
                           required>
                            @error('bank_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Tipo de Cuenta --}}
                        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Cuenta <span class="text-red-500">*</span>
                            </label>
                    <select name="account_type" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('account_type') border-red-300 @enderror"
                            required>
                                <option value="">Seleccionar...</option>
                                @foreach($accountTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('account_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('account_type')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Número de Cuenta --}}
                        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Número de Cuenta <span class="text-red-500">*</span>
                            </label>
                    <input type="text" name="account_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono @error('account_number') border-red-300 @enderror"
                           value="{{ old('account_number') }}" 
                           placeholder="1234567890"
                           pattern="[a-zA-Z0-9@]{10,20}"
                           oninput="this.value = this.value.replace(/[^a-zA-Z0-9@]/g, '')"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Letras, números y @ (10-20 caracteres)</p>
                            @error('account_number')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Titular de la Cuenta --}}
                        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Titular de la Cuenta <span class="text-red-500">*</span>
                            </label>
                    <input type="text" name="account_holder" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('account_holder') border-red-300 @enderror"
                           value="{{ old('account_holder') }}" 
                           placeholder="Nombre completo del titular"
                           required>
                            @error('account_holder')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Número de Documento --}}
                        <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Número de Documento <span class="text-gray-400">(Opcional)</span>
                            </label>
                    <input type="text" name="document_number" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('document_number') border-red-300 @enderror"
                           value="{{ old('document_number') }}" 
                           placeholder="Cédula o NIT">
                            @error('document_number')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                </div>
                
                {{-- Estado: siempre activa al crear --}}
                <input type="hidden" name="is_active" value="1">
            </div>
            
            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.admin.payment-methods.bank-accounts.index', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id]) }}" 
                   class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </a>
                <button type="submit" 
                        class="px-4 py-2.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                        Guardar Cuenta
                    </button>
                </div>
            </form>
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
</x-tenant-admin-layout>
