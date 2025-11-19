<x-tenant-admin-layout :store="$store">
    @section('title', 'Configuración de Envíos')
    
    @section('content')
<div x-data="shippingManager" x-init="init()" class="max-w-7xl mx-auto space-y-6 mt-6">
    
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Configuración de Envíos</h1>
            <p class="text-sm text-gray-600 mt-1">
                Sistema simple y flexible para configurar tus métodos de envío
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button 
                @click="saveAll()" 
                x-bind:disabled="saving"
                type="button"
                class="inline-flex items-center gap-2 px-4 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium"
            >
                <i data-lucide="save" class="w-4 h-4"></i>
                <span x-text="saving ? 'Guardando...' : 'Guardar Todo'"></span>
            </button>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    {{-- SECTION: Secciones principales en grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- SECTION: Recogida en Tienda Card --}}
        <x-card-base shadow="sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="store" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Recogida en Tienda</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Los clientes pueden recoger sus pedidos directamente</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <x-switch-basic 
                        switch-id="pickup_enabled"
                        switch-name="pickup_enabled"
                        :checked="$shipping->pickup_enabled ?? false"
                        value="1"
                        x-model="shipping.pickup_enabled"
                    />
                    <span class="text-xs font-medium text-gray-700" x-text="shipping.pickup_enabled ? 'Habilitado' : 'Deshabilitado'"></span>
                </div>
            </div>
            
            <div x-show="shipping.pickup_enabled" x-transition class="space-y-4 mt-4 pt-4 border-t border-gray-200">
                {{-- Tiempo de preparación --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de preparación</label>
                    <select 
                        x-model="shipping.pickup_preparation_time" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    >
                        @foreach(\App\Features\TenantAdmin\Models\SimpleShipping::PREPARATION_TIMES as $key => $label)
                            <option value="{{ $key }}" {{ ($shipping->pickup_preparation_time ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Instrucciones --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instrucciones para el cliente</label>
                    <textarea 
                        x-model="shipping.pickup_instructions" 
                        rows="3" 
                        placeholder="Ej: Puedes recoger tu pedido en nuestra tienda ubicada en..."
                        maxlength="500"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                    >{{ $shipping->pickup_instructions ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                </div>
            </div>
        </x-card-base>
        {{-- End SECTION: Recogida en Tienda Card --}}

        {{-- SECTION: Envío Local Card --}}
        <x-card-base shadow="sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="truck" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Envío Local</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Entregas dentro de tu ciudad principal</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <x-switch-basic 
                        switch-id="local_enabled"
                        switch-name="local_enabled"
                        :checked="$shipping->local_enabled ?? false"
                        value="1"
                        x-model="shipping.local_enabled"
                    />
                    <span class="text-xs font-medium text-gray-700" x-text="shipping.local_enabled ? 'Habilitado' : 'Deshabilitado'"></span>
                </div>
            </div>
            
            <div x-show="shipping.local_enabled" x-transition class="space-y-4 mt-4 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Ciudad principal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tu ciudad principal</label>
                        <x-ds.text-input
                            type="text"
                            name="local_city"
                            id="local_city"
                            placeholder="Ej: Sincelejo"
                            x-model="shipping.local_city"
                            :value="$shipping->local_city ?? ''"
                        />
                        <p class="text-xs text-gray-500 mt-1">Los clientes de esta ciudad pagarán tarifa local</p>
                    </div>
                    
                    {{-- Costo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Costo del envío</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input 
                                type="number" 
                                x-model="shipping.local_cost" 
                                placeholder="3000"
                                min="0"
                                step="500"
                                value="{{ $shipping->local_cost ?? '' }}"
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            >
                        </div>
                    </div>
                    
                    {{-- Tiempo de entrega --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de entrega</label>
                        <select 
                            x-model="shipping.local_preparation_time" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        >
                            @foreach(\App\Features\TenantAdmin\Models\SimpleShipping::PREPARATION_TIMES as $key => $label)
                                <option value="{{ $key }}" {{ ($shipping->local_preparation_time ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                {{-- Envío gratis --}}
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-center gap-3">
                        <x-switch-basic 
                            switch-id="local_free_shipping"
                            switch-name="local_free_shipping"
                            :checked="!!($shipping->local_free_from ?? null)"
                            value="1"
                            x-model="localFreeShippingEnabled"
                        />
                        <label class="text-sm font-medium text-gray-700">Activar envío gratis por monto</label>
                    </div>
                    
                    <div x-show="localFreeShippingEnabled" x-transition class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Envío gratis desde:</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input 
                                type="number" 
                                x-model="shipping.local_free_from" 
                                placeholder="50000"
                                min="0"
                                step="1000"
                                value="{{ $shipping->local_free_from ?? '' }}"
                                class="w-full pl-8 pr-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                            >
                        </div>
                    </div>
                </div>
                
                {{-- Instrucciones --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instrucciones para el cliente</label>
                    <textarea 
                        x-model="shipping.local_instructions" 
                        rows="3" 
                        placeholder="Ej: Entregamos en toda la ciudad de Sincelejo en horario de 8AM a 6PM"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                    >{{ $shipping->local_instructions ?? '' }}</textarea>
                </div>
            </div>
        </x-card-base>
        {{-- End SECTION: Envío Local Card --}}
        
    </div> <!-- Fin del grid -->

    {{-- SECTION: Envío Nacional Card --}}
    <x-card-base shadow="sm">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="rocket" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Envío Nacional</h3>
                    <p class="text-xs text-gray-600 mt-0.5">Configura zonas con diferentes tarifas</p>
                    <p class="text-xs text-gray-500 mt-0.5" x-text="`${zones.length}/${maxZones} zonas configuradas`"></p>
                </div>
            </div>
            
            <div class="flex items-center">
                <x-switch-basic 
                    switch-id="national_enabled"
                    switch-name="national_enabled"
                    :checked="$shipping->national_enabled ?? false"
                    value="1"
                    x-model="shipping.national_enabled"
                />
                <span class="text-xs font-medium text-gray-700 ml-2" x-text="shipping.national_enabled ? 'Habilitado' : 'Deshabilitado'"></span>
            </div>
        </div>
        
        <div x-show="shipping.national_enabled" x-transition class="space-y-6 mt-4 pt-4 border-t border-gray-200">
            {{-- Envío gratis nacional --}}
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <div class="flex items-center">
                    <x-switch-basic 
                        switch-id="national_free_shipping"
                        switch-name="national_free_shipping"
                        :checked="!!($shipping->national_free_from ?? null)"
                        value="1"
                        x-model="nationalFreeShippingEnabled"
                    />
                    <label class="text-sm font-medium text-gray-700 ml-2">Activar envío gratis nacional por monto</label>
                </div>
                
                <div x-show="nationalFreeShippingEnabled" x-transition class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Envío gratis desde:</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input 
                            type="number" 
                            x-model="shipping.national_free_from" 
                            placeholder="100000"
                            min="0"
                            step="1000"
                            value="{{ $shipping->national_free_from ?? '' }}"
                            class="w-full pl-8 pr-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                        >
                    </div>
                </div>
            </div>

            {{-- Instrucciones generales --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Instrucciones generales para envío nacional</label>
                <textarea 
                    x-model="shipping.national_instructions" 
                    rows="2" 
                    placeholder="Ej: Enviamos a nivel nacional mediante empresas de mensajería confiables"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none text-sm"
                >{{ $shipping->national_instructions ?? '' }}</textarea>
            </div>

            {{-- Zonas de envío --}}
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-base font-semibold text-gray-800">Zonas de Envío</h4>
                    <button @click="addZone()" 
                            x-bind:disabled="zones.length >= maxZones"
                            class="px-4 py-2 rounded-lg flex items-center justify-center gap-2 border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium"
                            x-bind:class="zones.length >= maxZones ? 'opacity-50 cursor-not-allowed' : ''">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        Agregar Zona
                    </button>
                </div>

                {{-- Lista de zonas --}}
                <div class="space-y-4" id="zones-container">
                    <template x-for="(zone, index) in zones" :key="zone.id || `new-${index}`">
                        <div class="border border-gray-200 rounded-lg overflow-hidden" x-bind:class="zone.is_editing ? 'border-blue-300 shadow-sm bg-blue-50' : 'bg-white'">
                            
                            {{-- Vista normal --}}
                            <div x-show="!zone.is_editing" x-transition class="p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                                            <h5 class="font-semibold text-gray-800" x-text="zone.name"></h5>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium" x-text="formatPrice(zone.cost)"></span>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium" x-text="getDeliveryTimeLabel(zone.delivery_time)"></span>
                                        </div>
                                        <div class="flex flex-wrap gap-1">
                                            <template x-for="(city, cIdx) in zone.cities" :key="city.id || `view-${index}-${cIdx}`">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs" x-text="typeof city === 'string' ? city : `${city.name} (${city.department})`"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="editZone(index)" class="text-blue-600 hover:text-blue-700 p-2 rounded-lg transition-colors" title="Editar zona">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button @click="@if($store->isActionProtected('shipping', 'delete_zone'))
                                                            requireMasterKey('shipping.delete_zone', `Eliminar zona: ${zones[index].name}`, () => deleteZone(index))
                                                        @else
                                                            deleteZone(index)
                                                        @endif" 
                                                class="text-red-600 hover:text-red-700 p-2 rounded-lg transition-colors" title="Eliminar zona">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Vista de edición --}}
                            <div x-show="zone.is_editing" x-transition>
                                <div class="p-4 bg-blue-50">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        {{-- Nombre --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la zona</label>
                                            <input 
                                                type="text" 
                                                x-model="zone.name" 
                                                placeholder="Ej: Ciudades Principales"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            >
                                        </div>
                                        
                                        {{-- Costo --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Costo del envío</label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                                <input 
                                                    type="number" 
                                                    x-model="zone.cost" 
                                                    placeholder="8000"
                                                    min="0"
                                                    step="500"
                                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                >
                                            </div>
                                        </div>
                                        
                                        {{-- Tiempo --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tiempo de entrega</label>
                                            <select 
                                                x-model="zone.delivery_time" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            >
                                                @foreach(\App\Features\TenantAdmin\Models\SimpleShipping::DELIVERY_TIMES as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    {{-- Cities Input con Tags y Departamento --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ciudades incluidas</label>
                                        
                                        {{-- Formulario para agregar ciudad --}}
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 mb-3">
                                            <div class="md:col-span-5">
                                                <input 
                                                    type="text" 
                                                    x-model="zone.newCity"
                                                    @keydown.enter.prevent="addCity(index)"
                                                    placeholder="Nombre de la ciudad"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                >
                                            </div>
                                            <div class="md:col-span-5">
                                                <select 
                                                    x-model="zone.newDepartment" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                >
                                                    <option value="">Selecciona departamento</option>
                                                    @foreach(['Amazonas', 'Antioquia', 'Arauca', 'Atlántico', 'Bolívar', 'Boyacá', 'Caldas', 'Caquetá', 'Casanare', 'Cauca', 'Cesar', 'Chocó', 'Córdoba', 'Cundinamarca', 'Guainía', 'Guaviare', 'Huila', 'La Guajira', 'Magdalena', 'Meta', 'Nariño', 'Norte de Santander', 'Putumayo', 'Quindío', 'Risaralda', 'San Andrés y Providencia', 'Santander', 'Sucre', 'Tolima', 'Valle del Cauca', 'Vaupés', 'Vichada'] as $dept)
                                                        <option value="{{ $dept }}">{{ $dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="md:col-span-2">
                                                <button @click="addCity(index)" 
                                                        type="button"
                                                        class="w-full px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center gap-1 text-sm font-medium transition-colors">
                                                    <i data-lucide="circle-plus" class="w-4 h-4"></i>
                                                    <span>Agregar</span>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        {{-- Tags de ciudades agregadas --}}
                                        <div class="flex flex-wrap gap-2 p-3 border border-gray-300 rounded-lg bg-white min-h-[44px]" x-effect="zone.cities.length && setTimeout(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); }, 50)">
                                            <template x-for="(city, cityIndex) in zone.cities" :key="city.id || cityIndex">
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm">
                                                    <span x-text="typeof city === 'string' ? city : `${city.name} (${city.department})`"></span>
                                                    <button @click="removeCityByIndex(index, cityIndex)" type="button" class="text-gray-500 hover:text-gray-700 transition-colors flex-shrink-0 inline-flex items-center justify-center w-4 h-4" title="Eliminar ciudad" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle"><circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path></svg>
                                                    </button>
                                                </span>
                                            </template>
                                            <span x-show="zone.cities.length === 0" class="text-sm text-gray-400">No hay ciudades agregadas</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Agrega ciudad y departamento. Máximo 20 ciudades por zona.</p>
                                    </div>
                                    
                                    {{-- Botones de acción --}}
                                    <div class="flex items-center gap-3">
                                        <button @click="saveZone(index)" 
                                                x-bind:disabled="!isZoneValid(zone)"
                                                class="px-4 py-2 rounded-lg flex items-center justify-center gap-2 border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium"
                                                x-bind:class="!isZoneValid(zone) ? 'opacity-50 cursor-not-allowed' : ''">
                                            Guardar Zona
                                        </button>
                                        <button @click="cancelEditZone(index)" class="px-4 py-2 rounded-lg flex items-center justify-center gap-2 border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800 transition-colors text-sm font-medium">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Estado vacío --}}
                <div x-show="zones.length === 0" class="text-center py-8 border-2 border-dashed border-gray-200 rounded-lg">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="map-pin" class="w-8 h-8 text-gray-400"></i>
                        </div>
                        <h4 class="text-base font-semibold text-gray-800 mb-2">No hay zonas configuradas</h4>
                        <p class="text-sm text-gray-600 mb-4">Agrega zonas para diferentes tarifas de envío nacional</p>
                        <button @click="addZone()" class="px-4 py-2 rounded-lg flex items-center justify-center gap-2 border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800 transition-colors text-sm font-medium">
                            <i data-lucide="circle-plus" class="w-4 h-4"></i>
                            Crear Primera Zona
                        </button>
                    </div>
                </div>
            </div>

            {{-- Configuración de ciudades no listadas --}}
            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                <div class="flex items-center gap-3 mb-3">
                    <x-switch-basic 
                        switch-id="allow_unlisted_cities"
                        switch-name="allow_unlisted_cities"
                        :checked="$shipping->allow_unlisted_cities ?? false"
                        value="1"
                        x-model="shipping.allow_unlisted_cities"
                    />
                    <label class="text-sm font-medium text-gray-700">Permitir pedidos de ciudades no listadas</label>
                </div>
                
                <div x-show="shipping.allow_unlisted_cities" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Costo por defecto:</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input 
                                type="number" 
                                x-model="shipping.unlisted_cities_cost" 
                                placeholder="12000"
                                min="0"
                                step="500"
                                value="{{ $shipping->unlisted_cities_cost ?? '' }}"
                                class="w-full pl-8 pr-3 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje para el cliente:</label>
                        <input 
                            type="text" 
                            x-model="shipping.unlisted_cities_message" 
                            placeholder="Contacta para confirmar disponibilidad"
                            value="{{ $shipping->unlisted_cities_message ?? '' }}"
                            class="w-full px-3 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm"
                        >
                    </div>
                </div>
            </div>
        </div>
    </x-card-base>
    {{-- End SECTION: Envío Nacional Card --}}

    {{-- SECTION: Master Key Modal --}}
    <x-modal-master-key 
        modal-id="master-key-modal"
        action="shipping.delete_zone"
        action-label="Eliminar zona"
    />
    {{-- End SECTION: Master Key Modal --}}

    {{-- SECTION: Modal de error --}}
    <div x-show="showErrorModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @click.away="showErrorModal = false"
         @keydown.escape.window="showErrorModal = false">
        
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="showErrorModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 @click.stop
                 class="relative bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 border border-gray-200">
                
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Error</h3>
                    <button @click="showErrorModal = false" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <p class="text-gray-700 leading-relaxed flex-1" x-text="errorMessage"></p>
                    </div>
                </div>
                
                <div class="flex justify-end p-4 border-t border-gray-200">
                    <button @click="showErrorModal = false" 
                            class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium text-sm">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Modal de error --}}
    
    {{-- SECTION: Modal de confirmación de eliminación --}}
    <div x-show="showDeleteConfirmation" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @click.away="cancelDeleteZone()"
         @keydown.escape.window="cancelDeleteZone()">
        
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="showDeleteConfirmation"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 @click.stop
                 class="relative bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 border border-gray-200">
                
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">¿Eliminar zona?</h3>
                    <button @click="cancelDeleteZone()" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 leading-relaxed">
                                Se eliminará la zona <strong x-text="zoneToDeleteName"></strong> de forma permanente.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 p-4 border-t border-gray-200">
                    <button @click="cancelDeleteZone()" 
                            class="px-6 py-2 border-2 border-gray-500 text-gray-500 rounded-lg hover:border-gray-800 hover:text-gray-800 transition-colors font-medium text-sm">
                        Cancelar
                    </button>
                    <button @click="confirmDeleteZone()" 
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium text-sm">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Modal de confirmación de eliminación --}}
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('shippingManager', () => ({
        // Data principal
        shipping: @json($shipping),
        zones: @json($shipping->zones ?? []),
        maxZones: {{ $maxZones }},
        currentZoneCount: {{ $currentZoneCount }},
        
        // Estados de UI
        saving: false,
        localFreeShippingEnabled: false,
        nationalFreeShippingEnabled: false,
        
        // Modal de error
        showErrorModal: false,
        errorMessage: '',
        
        // Modal de confirmación de eliminación
        showDeleteConfirmation: false,
        zoneToDelete: null,
        zoneToDeleteName: '',
        
        init() {
            // Inicializar toggles de envío gratis
            this.localFreeShippingEnabled = !!this.shipping.local_free_from;
            this.nationalFreeShippingEnabled = !!this.shipping.national_free_from;
            
            // Agregar _renderKey y guardar datos originales para cada zona
            // Agregar IDs únicos a las ciudades existentes que no los tengan
            this.zones = this.zones.map(zone => {
                // Agregar IDs únicos a las ciudades que no los tengan
                const citiesWithIds = (zone.cities || []).map(city => {
                    if (typeof city === 'string') {
                        return {
                            id: `city-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
                            name: city
                        };
                    } else if (!city.id) {
                        return {
                            ...city,
                            id: `city-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
                        };
                    }
                    return city;
                });
                
                const reactiveZone = Alpine.reactive({
                    ...zone,
                    _renderKey: Date.now() + Math.random(),
                    _originalData: JSON.parse(JSON.stringify(zone)), // Guardar copia de los datos originales
                    cities: Alpine.reactive(citiesWithIds) // Hacer reactivo el array de ciudades con IDs
                });
                return reactiveZone;
            });
            
            // Watchers para envío gratis
            this.$watch('localFreeShippingEnabled', (enabled) => {
                if (!enabled) {
                    this.shipping.local_free_from = null;
                }
            });
            
            this.$watch('nationalFreeShippingEnabled', (enabled) => {
                if (!enabled) {
                    this.shipping.national_free_from = null;
                }
            });
        },
        
        // Zona management
        addZone() {
            if (this.zones.length >= this.maxZones) {
                if (window.showToast) {
                    window.showToast(`Máximo ${this.maxZones} zonas permitidas en tu plan`, 'error');
                } else {
                    this.showError(`Máximo ${this.maxZones} zonas permitidas en tu plan`);
                }
                return;
            }
            
            this.zones.push({
                id: null,
                name: '',
                cost: 8000,
                delivery_time: '3-5dias',
                cities: [],
                newCity: '',
                newDepartment: '',
                is_editing: true,
                is_new: true,
                _renderKey: Date.now() + Math.random()
            });
        },
        
        editZone(index) {
            // Guardar datos originales antes de editar
            if (!this.zones[index]._originalData) {
                this.zones[index]._originalData = JSON.parse(JSON.stringify({
                    name: this.zones[index].name,
                    cost: this.zones[index].cost,
                    delivery_time: this.zones[index].delivery_time,
                    cities: this.zones[index].cities
                }));
            }
            this.zones[index].is_editing = true;
            this.zones[index].newCity = '';
            this.zones[index].newDepartment = '';
            
            // Reinicializar iconos Lucide después de entrar en modo edición
            this.$nextTick(() => {
                setTimeout(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }, 100);
            });
        },
        
        cancelEditZone(index) {
            if (this.zones[index].is_new) {
                this.zones.splice(index, 1);
            } else {
                // Restaurar datos originales si existen
                if (this.zones[index]._originalData) {
                    const original = this.zones[index]._originalData;
                    this.zones[index].name = original.name;
                    this.zones[index].cost = original.cost;
                    this.zones[index].delivery_time = original.delivery_time;
                    this.zones[index].cities = JSON.parse(JSON.stringify(original.cities));
                }
                
                // Cerrar modo de edición
                this.zones[index].is_editing = false;
                this.zones[index].newCity = '';
                this.zones[index].newDepartment = '';
                
                // Forzar re-render actualizando _renderKey y recreando la referencia del objeto
                const updatedZone = {
                    ...this.zones[index],
                    _renderKey: Date.now() + Math.random()
                };
                this.zones[index] = updatedZone;
                
                // Reinicializar iconos Lucide después del cambio
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }
        },
        
        async saveZone(index) {
            const zone = this.zones[index];
            
            if (!this.isZoneValid(zone)) {
                if (window.showToast) {
                    window.showToast('Por favor completa todos los campos requeridos', 'warning');
                } else {
                    this.showError('Por favor completa todos los campos requeridos');
                }
                return;
            }
            
            try {
                const url = zone.is_new ? 
                    '/{{ $store->slug }}/admin/envios/zones' :
                    `/{{ $store->slug }}/admin/envios/zones/${zone.id}`;
                
                const method = zone.is_new ? 'POST' : 'PUT';
                
                let response;
                
                if (zone.is_new) {
                    // POST para crear nueva zona - usar JSON
                    // Limpiar los IDs antes de enviar (el servidor no los necesita)
                    const citiesToSend = zone.cities.map(city => {
                        if (typeof city === 'string') return city;
                        const { id, ...cityWithoutId } = city;
                        return cityWithoutId;
                    });
                    
                    response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            name: zone.name,
                            cost: zone.cost,
                            delivery_time: zone.delivery_time,
                            cities: citiesToSend
                        })
                    });
                } else {
                    // PUT para actualizar - usar FormData
                    // Limpiar los IDs antes de enviar (el servidor no los necesita)
                    const citiesToSend = zone.cities.map(city => {
                        if (typeof city === 'string') return city;
                        const { id, ...cityWithoutId } = city;
                        return cityWithoutId;
                    });
                    
                    const form = new FormData();
                    form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    form.append('_method', 'PUT');
                    form.append('name', zone.name);
                    form.append('cost', zone.cost);
                    form.append('delivery_time', zone.delivery_time);
                    form.append('cities', JSON.stringify(citiesToSend));
                    
                    response = await fetch(url, {
                        method: 'POST',
                        body: form,
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                }
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Si es un error 422 (validación), mostrar el mensaje específico
                    if (response.status === 422 && data.message) {
                        this.showError(data.message);
                    } else {
                        this.showError(`Error HTTP ${response.status}: Problema en el servidor`);
                    }
                    return;
                }
                
                if (data.success) {
                    // Recargar TODAS las zonas desde el servidor
                    // IMPORTANTE: Usar JSON.parse(JSON.stringify()) para romper referencias y forzar reactividad
                    if (data.zones) {
                        const freshZones = JSON.parse(JSON.stringify(data.zones));
                        this.zones = freshZones.map(zone => ({
                            ...zone,
                            is_editing: false,
                            newCity: '',
                            newDepartment: '',
                            _renderKey: Date.now() + Math.random()
                        }));
                    }
                    
                    this.showSuccess(data.message);
                } else {
                    this.showError(data.message);
                }
            } catch (error) {
                this.showError('Error al guardar la zona: ' + error.message);
            }
        },
        
        async deleteZone(index) {
            const zone = this.zones[index];
            
            if (zone.is_new) {
                this.zones.splice(index, 1);
                return;
            }
            
            // Mostrar modal de confirmación
            this.showDeleteConfirmation = true;
            this.zoneToDelete = index;
            this.zoneToDeleteName = zone.name;
        },
        
        // Confirmar eliminación de zona
        confirmDeleteZone() {
            if (this.zoneToDelete !== null) {
                const index = this.zoneToDelete;
                this.executeDeleteZone(index);
            }
        },
        
        // Cancelar eliminación de zona
        cancelDeleteZone() {
            this.showDeleteConfirmation = false;
            this.zoneToDelete = null;
            this.zoneToDeleteName = '';
        },
        
        // Ejecutar eliminación de zona
        async executeDeleteZone(index) {
            const zone = this.zones[index];
            
            try {
                const url = `/{{ $store->slug }}/admin/envios/zones/${zone.id}`;
                
                // Crear un formulario temporal para envío
                const form = new FormData();
                form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                form.append('_method', 'DELETE');
                
                const response = await fetch(url, {
                    method: 'POST',
                    body: form,
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Si es un error 422 (validación), mostrar el mensaje específico
                    if (response.status === 422 && data.message) {
                        this.showError(data.message);
                    } else {
                        this.showError(`Error ${response.status}: Problema en el servidor`);
                    }
                    return;
                }
                
                if (data.success) {
                    this.zones.splice(index, 1);
                    this.showSuccess(data.message);
                } else {
                    this.showError(data.message);
                }
            } catch (error) {
                this.showError('Error al eliminar la zona: ' + error.message);
            } finally {
                this.showDeleteConfirmation = false;
                this.zoneToDelete = null;
                this.zoneToDeleteName = '';
            }
        },
        
        // Mostrar modal de error
        showError(message) {
            this.errorMessage = message;
            this.showErrorModal = true;
        },
        
        // Cities management
        addCity(zoneIndex) {
            const zone = this.zones[zoneIndex];
            const cityName = zone.newCity?.trim();
            const department = zone.newDepartment?.trim();
            
            if (!cityName) {
                if (window.showToast) {
                    window.showToast('Ingresa el nombre de la ciudad', 'warning');
                } else {
                    this.showError('Ingresa el nombre de la ciudad');
                }
                return;
            }
            
            if (zone.cities.length >= 20) {
                if (window.showToast) {
                    window.showToast('Máximo 20 ciudades por zona', 'warning');
                } else {
                    this.showError('Máximo 20 ciudades por zona');
                }
                return;
            }
            
            // Verificar duplicados (compatible con ambos formatos)
            const cityExists = zone.cities.some(c => {
                const name = typeof c === 'string' ? c : c.name;
                return name.toLowerCase() === cityName.toLowerCase();
            });
            
            if (cityExists) {
                if (window.showToast) {
                    window.showToast('Esta ciudad ya está agregada', 'warning');
                } else {
                    this.showError('Esta ciudad ya está agregada');
                }
                return;
            }
            
            // Agregar la nueva ciudad al array con un ID único
            const cityId = `city-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            const newCity = department ? { 
                id: cityId,
                name: cityName, 
                department: department 
            } : {
                id: cityId,
                name: cityName
            };
            
            // Agregar directamente al array de ciudades - Alpine.js detectará el cambio
            this.zones[zoneIndex].cities.push(newCity);
            this.zones[zoneIndex].newCity = '';
            this.zones[zoneIndex].newDepartment = '';
            
            // Reinicializar iconos Lucide después de agregar la ciudad
            // Usar un pequeño delay para asegurar que el DOM se haya actualizado
            this.$nextTick(() => {
                setTimeout(() => {
                    if (typeof lucide !== 'undefined') {
                        // Buscar específicamente el contenedor de tags de esta zona
                        const zoneElement = document.querySelector(`[x-data*="shippingManager"]`);
                        if (zoneElement) {
                            lucide.createIcons(zoneElement);
                        } else {
                            lucide.createIcons();
                        }
                    }
                }, 100);
            });
        },
        
        removeCityByIndex(zoneIndex, cityIndex) {
            if (this.zones[zoneIndex] && this.zones[zoneIndex].cities && cityIndex >= 0 && cityIndex < this.zones[zoneIndex].cities.length) {
                // Crear un nuevo array sin la ciudad eliminada para forzar reactividad
                const updatedCities = this.zones[zoneIndex].cities.filter((_, idx) => idx !== cityIndex);
                this.zones[zoneIndex].cities = updatedCities;
                
                // Reinicializar iconos Lucide después de eliminar la ciudad
                // Usar un pequeño delay para asegurar que el DOM se haya actualizado
                this.$nextTick(() => {
                    setTimeout(() => {
                        if (typeof lucide !== 'undefined') {
                            // Buscar específicamente el contenedor de tags de esta zona
                            const zoneElement = document.querySelector(`[x-data*="shippingManager"]`);
                            if (zoneElement) {
                                lucide.createIcons(zoneElement);
                            } else {
                                lucide.createIcons();
                            }
                        }
                    }, 100);
                });
            }
        },
        
        // Validation
        isZoneValid(zone) {
            return zone.name?.trim() && 
                   zone.cost >= 0 && 
                   zone.delivery_time && 
                   zone.cities.length > 0;
        },
        
        // Guardar configuración general
        async saveAll() {
            this.saving = true;
            
            try {
                const response = await fetch('{{ route("tenant.admin.simple-shipping.update", $store->slug) }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.shipping)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.shipping = data.shipping;
                    this.showSuccess(data.message);
                } else {
                    this.showError(data.message);
                }
            } catch (error) {
                this.showError('Error al guardar la configuración');
            } finally {
                this.saving = false;
            }
        },
        
        
        // Helpers
        formatPrice(price) {
            return '$' + new Intl.NumberFormat('es-CO').format(price);
        },
        
        getDeliveryTimeLabel(time) {
            const times = {
                @foreach(\App\Features\TenantAdmin\Models\SimpleShipping::DELIVERY_TIMES as $key => $label)
                    '{{ $key }}': '{{ $label }}',
                @endforeach
            };
            return times[time] || time;
        },
        
        showSuccess(message) {
            if (window.showToast) {
                window.showToast(message, 'success');
            } else {
                // Fallback si showToast no está disponible
                console.log('Success:', message);
            }
        }
    }));
});

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush

    @endsection
</x-tenant-admin-layout>
