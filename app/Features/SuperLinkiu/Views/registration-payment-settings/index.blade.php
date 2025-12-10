@extends('shared::layouts.admin')

@section('title', 'Configuración de Pago - Registro')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Configuración de Pago para Registro</h1>
            <p class="text-sm text-gray-600 mt-1">Datos bancarios y QR que se mostrarán en el wizard de registro público</p>
        </div>
    </div>

    {{-- Formulario --}}
    <form method="POST" action="{{ route('superlinkiu.registration-payment-settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{-- Sección: Datos Bancarios --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                    Datos Bancarios
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Banco <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="bank_name"
                               value="{{ old('bank_name', $setting->bank_name) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('bank_name') border-red-300 @enderror"
                               required>
                        @error('bank_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Cuenta <span class="text-red-500">*</span>
                        </label>
                        <select name="account_type"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('account_type') border-red-300 @enderror"
                                required>
                            <option value="Ahorros" {{ old('account_type', $setting->account_type) == 'Ahorros' ? 'selected' : '' }}>Ahorros</option>
                            <option value="Corriente" {{ old('account_type', $setting->account_type) == 'Corriente' ? 'selected' : '' }}>Corriente</option>
                        </select>
                        @error('account_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Cuenta <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="account_number"
                               value="{{ old('account_number', $setting->account_number) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('account_number') border-red-300 @enderror"
                               required>
                        @error('account_number')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Titular <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="account_holder"
                               value="{{ old('account_holder', $setting->account_holder) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('account_holder') border-red-300 @enderror"
                               required>
                        @error('account_holder')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            NIT <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nit"
                               value="{{ old('nit', $setting->nit) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('nit') border-red-300 @enderror"
                               placeholder="901234567-1"
                               required>
                        @error('nit')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: QR Code --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="qr-code" class="w-5 h-5 text-blue-600"></i>
                    QR Code de Pago
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Upload QR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Subir QR Code
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                            <input type="file" 
                                   name="qr_code_image" 
                                   id="qr_code_image"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewQR(event)">
                            <label for="qr_code_image" class="cursor-pointer">
                                <i data-lucide="upload" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                <p class="text-gray-700 font-medium mb-1">Click para seleccionar QR</p>
                                <p class="text-sm text-gray-500">JPG o PNG - Máximo 2MB</p>
                            </label>
                        </div>
                        @error('qr_code_image')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview QR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            QR Actual
                        </label>
                        <div class="border-2 border-gray-200 rounded-xl p-4 bg-gray-50">
                            @if($setting->qr_code_image)
                                <div class="text-center" id="qr-preview-container">
                                    <img src="{{ $setting->qr_code_url }}" 
                                         alt="QR Code" 
                                         class="w-48 h-48 mx-auto object-contain mb-3"
                                         id="qr-preview-img">
                                    <button type="button" 
                                            onclick="deleteQR()"
                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                        Eliminar QR
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-8" id="qr-preview-container">
                                    <i data-lucide="image-off" class="w-16 h-16 text-gray-300 mx-auto mb-3"></i>
                                    <p class="text-sm text-gray-500">No hay QR configurado</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-900 mb-1">Sobre el QR Code</p>
                            <p class="text-sm text-blue-700">
                                Este QR se mostrará en el Step 4 del wizard de registro público, junto a los datos bancarios. 
                                Los usuarios podrán escanear el QR para hacer la transferencia más fácilmente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botón Guardar --}}
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Guardar Configuración
            </button>
        </div>
    </form>
</div>

{{-- Toast de éxito --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success(
            '¡Hey! felicidades',
            '{{ session('success') }}',
            5000,
            'bottom-center'
        );
    }
});
</script>
@endif

<script>
function previewQR(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const container = document.getElementById('qr-preview-container');
        container.innerHTML = `
            <div class="text-center">
                <img src="${e.target.result}" 
                     alt="Preview QR" 
                     class="w-48 h-48 mx-auto object-contain mb-3 border-2 border-green-500 rounded-lg"
                     id="qr-preview-img">
                <p class="text-sm text-green-600 font-medium">✓ Nuevo QR seleccionado</p>
            </div>
        `;
        
        if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
    };
    reader.readAsDataURL(file);
}

async function deleteQR() {
    if (!confirm('¿Eliminar el QR code actual?')) return;
    
    try {
        const response = await fetch('{{ route('superlinkiu.registration-payment-settings.delete-qr') }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('qr-preview-container').innerHTML = `
                <div class="text-center py-8">
                    <i data-lucide="image-off" class="w-16 h-16 text-gray-300 mx-auto mb-3"></i>
                    <p class="text-sm text-gray-500">No hay QR configurado</p>
                </div>
            `;
            
            if (window.toast) {
                window.toast.success('QR eliminado', data.message, 3000, 'bottom-center');
            }
            
            if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
        }
    } catch (error) {
        if (window.toast) {
            window.toast.error('Error', 'No se pudo eliminar el QR', 3000, 'bottom-center');
        }
    }
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection

