<x-tenant-admin-layout :store="$store">
@section('title', 'Editar Variable')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <x-solar-arrow-left-outline class="w-6 h-6" />
            </a>
            <h1 class="text-lg font-semibold text-black-500">Editar Variable</h1>
        </div>
        <div class="bg-info-50 border border-info-100 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <x-solar-info-circle-outline class="w-5 h-5 text-info-300 flex-shrink-0" />
                <p class="text-sm text-info-300">
                    Editando variable: <strong>{{ $variable->name }}</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <form action="{{ route('tenant.admin.variables.update', [$store->slug, $variable]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Card principal -->
        <div class="bg-accent-50 rounded-lg p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="lg:col-span-2">
                    <label for="name" class="block text-sm font-medium text-black-400 mb-2">
                        Nombre de la Variable *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $variable->name) }}"
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200" 
                           placeholder="Ej: Talla, Color, Material"
                           required>
                    @error('name')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo de Variable -->
                <div>
                    <label for="type" class="block text-sm font-medium text-black-400 mb-2">
                        Tipo de Variable *
                    </label>
                    <select id="type" 
                            name="type" 
                            class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500"
                            required>
                        <option value="">Selecciona un tipo</option>
                        <option value="radio" {{ old('type', $variable->type) == 'radio' ? 'selected' : '' }}>Selección única</option>
                        <option value="checkbox" {{ old('type', $variable->type) == 'checkbox' ? 'selected' : '' }}>Selección múltiple</option>
                        <option value="text" {{ old('type', $variable->type) == 'text' ? 'selected' : '' }}>Texto libre</option>
                        <option value="numeric" {{ old('type', $variable->type) == 'numeric' ? 'selected' : '' }}>Numérico</option>
                    </select>
                    @error('type')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requerido por defecto -->
                <div>
                    <label for="is_required_default" class="block text-sm font-medium text-black-400 mb-2">
                        Configuración
                    </label>
                    <div class="flex items-center">
                        <input type="hidden" name="is_required_default" value="0">
                        <input type="checkbox" 
                               id="is_required_default" 
                               name="is_required_default" 
                               value="1"
                               {{ old('is_required_default', $variable->is_required_default) == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-400 bg-accent-50 border-accent-200 rounded focus:ring-primary-200 focus:ring-2">
                        <label for="is_required_default" class="ml-2 text-sm text-black-400">
                            Requerido por defecto
                        </label>
                    </div>
                    @error('is_required_default')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valores mínimo y máximo (solo para tipo numérico) -->
                <div id="numericFields" style="display: none;" class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="min_value" class="block text-sm font-medium text-black-400 mb-2">
                                Valor Mínimo
                            </label>
                            <input type="number" 
                                   id="min_value" 
                                   name="min_value" 
                                   value="{{ old('min_value', $variable->min_value) }}"
                                   step="0.01"
                                   class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500" 
                                   placeholder="0.00">
                            @error('min_value')
                                <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="max_value" class="block text-sm font-medium text-black-400 mb-2">
                                Valor Máximo
                            </label>
                            <input type="number" 
                                   id="max_value" 
                                   name="max_value" 
                                   value="{{ old('max_value', $variable->max_value) }}"
                                   step="0.01"
                                   class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500" 
                                   placeholder="100.00">
                            @error('max_value')
                                <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Estado -->
                <div class="lg:col-span-2">
                    <label for="is_active" class="block text-sm font-medium text-black-400 mb-2">
                        Estado
                    </label>
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $variable->is_active) == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-400 bg-accent-50 border-accent-200 rounded focus:ring-primary-200 focus:ring-2">
                        <label for="is_active" class="ml-2 text-sm text-black-400">
                            Variable activa
                        </label>
                    </div>
                    @error('is_active')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Opciones de Variable -->
        <div id="optionsSection" style="display: none;">
            <div class="bg-accent-50 rounded-lg p-6">
                <div class="bg-info-50 border border-info-100 rounded-lg p-4 mb-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <x-solar-info-circle-outline class="w-5 h-5 text-info-200 flex-shrink-0" />
                        <p class="text-caption text-info-200">
                            Recuerda las opciones que no tienen precio, coloca un 0.
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-body-large font-bold text-black-500">Opciones de la Variable</h3>
                    <button type="button" 
                            id="addOption" 
                            class="btn-primary px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                        <x-solar-add-circle-outline class="w-5 h-5 mr-2" />
                        Agregar Opción
                    </button>
                </div>
                
                <div id="optionsContainer" class="space-y-4">
                    <!-- Las opciones se agregarán dinámicamente aquí -->
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" 
               class="btn-secondary px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                <x-solar-arrow-left-outline class="w-5 h-5" />
                Cancelar
            </a>
            <button type="submit" 
                    class="btn-primary px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                <x-solar-diskette-outline class="w-5 h-5" />
                Actualizar Variable
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const optionsSection = document.getElementById('optionsSection');
    const numericFields = document.getElementById('numericFields');
    const optionsContainer = document.getElementById('optionsContainer');
    const addOptionBtn = document.getElementById('addOption');
    let optionIndex = 0;

    // Mostrar/ocultar secciones según el tipo
    function toggleSections() {
        if (typeSelect.value === 'radio' || typeSelect.value === 'checkbox') {
            optionsSection.style.display = 'block';
            numericFields.style.display = 'none';
        } else if (typeSelect.value === 'numeric') {
            optionsSection.style.display = 'none';
            numericFields.style.display = 'block';
        } else {
            optionsSection.style.display = 'none';
            numericFields.style.display = 'none';
        }
    }

    typeSelect.addEventListener('change', toggleSections);

    // Agregar nueva opción
    addOptionBtn.addEventListener('click', function() {
        addOption();
    });

    function addOption(name = '', priceModifier = '', colorHex = '') {
        const optionDiv = document.createElement('div');
        optionDiv.className = 'option-item bg-accent-100 rounded-lg p-4';
        
        optionDiv.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-medium text-black-400">Opción ${optionIndex + 1}</h4>
                <button type="button" class="remove-option text-error-400 hover:text-error-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-1">
                        Nombre *
                    </label>
                    <input type="text" 
                           name="options[${optionIndex}][name]" 
                           value="${name}"
                           class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500" 
                           placeholder="Ej: Rojo, Talla M, etc."
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-1">
                        Modificador de Precio
                    </label>
                    <input type="number" 
                           name="options[${optionIndex}][price_modifier]" 
                           value="${priceModifier}"
                           step="0.01"
                           class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500" 
                           placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-1">
                        Color (hex)
                    </label>
                    <input type="text" 
                           name="options[${optionIndex}][color_hex]" 
                           value="${colorHex}"
                           class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500" 
                           placeholder="#FF0000">
                </div>
            </div>
        `;
        
        optionsContainer.appendChild(optionDiv);
        optionIndex++;
        
        // Agregar event listener para el botón de eliminar
        const removeBtn = optionDiv.querySelector('.remove-option');
        removeBtn.addEventListener('click', function() {
            optionDiv.remove();
        });
    }

    // Cargar opciones existentes al inicializar
    @if($variable->type === 'radio' || $variable->type === 'checkbox')
        optionsSection.style.display = 'block';
        @if(old('options'))
            @foreach(old('options') as $index => $option)
                addOption('{{ $option['name'] ?? '' }}', '{{ $option['price_modifier'] ?? '' }}', '{{ $option['color_hex'] ?? '' }}');
            @endforeach
        @else
            @foreach($variable->options as $option)
                addOption('{{ addslashes($option->name) }}', '{{ $option->price_modifier ?? 0 }}', '{{ $option->color_hex ?? '' }}');
            @endforeach
        @endif
        
        // Si no hay opciones, agregar una por defecto
        if (optionsContainer.children.length === 0) {
            addOption();
        }
    @elseif($variable->type === 'numeric')
        numericFields.style.display = 'block';
    @endif
    
    // Interceptar submit para mostrar SweetAlert2
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: '¿Actualizar variable?',
            text: 'Se guardarán los cambios realizados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#da27a7',
            cancelButtonColor: '#ed2e45',
            confirmButtonText: '✓ Sí, actualizar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Actualizando variable...',
                    text: 'Por favor espera',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
</x-tenant-admin-layout> 