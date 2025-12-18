<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Información del Negocio - Linkiu</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen">
        {{-- Wizard Progress --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold">
                            2
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Paso 2 de 4</p>
                            <p class="text-xs text-gray-600">Información del Negocio</p>
                        </div>
                    </div>
                    <a href="{{ route('register.step1') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        ← Volver a Planes
                    </a>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-900 mb-3">Cuéntanos sobre tu Negocio</h2>
                <p class="text-base font-normal text-slate-600">Necesitamos verificar que tu negocio es real y cumple con nuestras políticas</p>
            </div>

            <form method="POST" action="{{ route('register.step2.store') }}" class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @csrf
                
                {{-- Sección: Categoría de Negocio --}}
                <div class="p-6 lg:p-8 border-b border-gray-200">
                    <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="briefcase" class="w-5 h-5 text-blue-600"></i>
                        Categoría del Negocio
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            ¿Qué tipo de negocio tienes? <span class="text-red-500">*</span>
                        </label>
                        <select name="business_category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('business_category_id') border-red-300 @enderror text-base"
                                required>
                            <option value="">Categoría de tu negocio</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('business_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs font-normal text-slate-600 mt-2">
                            <i data-lucide="info" class="w-3 h-3 inline"></i>
                            Esto nos ayuda a configurar las herramientas adecuadas para tu negocio
                        </p>
                        @error('business_category_id')
                            <p class="text-sm font-normal text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Sección: Información Básica --}}
                <div class="p-6 lg:p-8 border-b border-gray-200">
                    <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i data-lucide="building" class="w-5 h-5 text-blue-600"></i>
                        Información Básica
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Nombre del Negocio <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="business_name"
                                   value="{{ old('business_name') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('business_name') border-red-300 @enderror"
                                   placeholder="Mi Negocio S.A.S"
                                   required>
                            @error('business_name')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select name="document_type"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('document_type') border-red-300 @enderror"
                                    required>
                                <option value="">Seleccionar tipo</option>
                                <option value="nit" {{ old('document_type') == 'nit' ? 'selected' : '' }}>NIT (Empresa)</option>
                                <option value="cc" {{ old('document_type') == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="ce" {{ old('document_type') == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            </select>
                            @error('document_type')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Número de Documento <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="document_number"
                                   value="{{ old('document_number') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('document_number') border-red-300 @enderror"
                                   placeholder="123456789-0"
                                   required>
                            @error('document_number')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Teléfono de Contacto <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('phone') border-red-300 @enderror"
                                   placeholder="+57 300 123 4567"
                                   required>
                            @error('phone')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Email de Contacto <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('email') border-red-300 @enderror"
                                   placeholder="contacto@minegocio.com"
                                   required>
                            @error('email')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Ciudad <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="city"
                                   value="{{ old('city') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('city') border-red-300 @enderror"
                                   placeholder="Medellín"
                                   required>
                            @error('city')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="department"
                                   value="{{ old('department') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('department') border-red-300 @enderror"
                                   placeholder="Antioquia"
                                   required>
                            @error('department')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Dirección Física <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="address"
                                   value="{{ old('address') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('address') border-red-300 @enderror"
                                   placeholder="Calle 123 #45-67"
                                   required>
                            @error('address')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Descripción del Negocio
                            </label>
                            <textarea name="description"
                                      rows="3"
                                      class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('description') border-red-300 @enderror"
                                      placeholder="Describe brevemente tu negocio...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección: Verificación de Documentos --}}
                <div class="p-6 lg:p-8 bg-blue-50 border-t border-blue-100">
                    <div class="flex items-start gap-3">
                        <i data-lucide="shield-check" class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-base text-slate-900 mb-1">Verificación de Seguridad</h4>
                            <p class="text-sm font-normal text-slate-600">
                                La información proporcionada será verificada para garantizar la autenticidad de tu negocio. 
                                Este proceso ayuda a mantener nuestra plataforma segura para todos.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Botones de Navegación --}}
                <div class="p-6 lg:p-8 bg-slate-50 grid grid-cols-1 md:grid-cols-2 gap-4 items-center justify-center">
                    <a href="{{ route('register.step1') }}" 
                       class="px-6 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Paso Anterior
                    </a>
                    <button type="submit" 
                            class="px-8 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                        <span>Continuar al Paso 3</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
    // Inicializar iconos Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    </style>
</body>
</html>

