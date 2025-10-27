@props([
    'label' => '',
    'modelName' => '',
    'placeholder' => '#000000',
    'required' => false
])

<div 
    x-data="colorPicker('{{ $modelName }}')"
    {{ $attributes->merge(['class' => 'space-y-3']) }}
>
    @if($label)
        <label class="text-sm font-medium text-black-400">
            {{ $label }}
            @if($required)
                <span class="text-error-400">*</span>
            @endif
        </label>
    @endif

    <div class="flex items-center gap-3">
        {{-- Color Preview Button --}}
        <button 
            type="button"
            @click="open"
            class="w-10 h-10 rounded-lg ring-1 ring-accent-200 transition-shadow hover:ring-2 hover:ring-primary-400"
            :style="{ backgroundColor: color }"
            :class="{ 'ring-error-400': error }"
        ></button>

        {{-- Color Input --}}
        <div class="relative flex-1">
            <input 
                type="text" 
                id="color_input_{{ $modelName }}"
                name="{{ $modelName }}"
                x-model="color"
                @input="validate"
                @blur="validateFinal"
                :class="{ 'border-error-400 focus:ring-error-400': error }"
                class="w-full px-3 py-2 rounded-lg bg-accent-100 border border-accent-200 focus:ring-2 focus:ring-primary-400 focus:border-transparent transition-colors"
                placeholder="#000000"
            >
            
            {{-- Error Message --}}
            <p 
                x-show="error"
                x-text="error"
                class="absolute left-0 top-full mt-1 text-xs text-error-400"
            ></p>
        </div>

        {{-- Color Picker Popup --}}
        <div
            x-show="isOpen"
            @click.away="close"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-2 bg-accent-50 rounded-lg shadow-lg p-4"
            style="display: none;"
        >
            {{-- Preset Colors --}}
            <div class="space-y-3">
                <h4 class="text-sm font-medium text-black-400">Colores Predeterminados</h4>
                <div class="grid grid-cols-6 gap-2">
                    {{-- Fila 1: Colores cálidos --}}
                    <button 
                        @click="setColor('#da27a7')"
                        style="background-color: #da27a7"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-primary-300"
                        title="Rosa vibrante"
                    ></button>
                    <button 
                        @click="setColor('#ed2e45')"
                        style="background-color: #ed2e45"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-error-300"
                        title="Rojo"
                    ></button>
                    <button 
                        @click="setColor('#ff6b35')"
                        style="background-color: #ff6b35"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-orange-300"
                        title="Naranja"
                    ></button>
                    <button 
                        @click="setColor('#ffad0d')"
                        style="background-color: #ffad0d"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-warning-300"
                        title="Amarillo"
                    ></button>
                    <button 
                        @click="setColor('#a855f7')"
                        style="background-color: #a855f7"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-purple-300"
                        title="Púrpura"
                    ></button>
                    <button 
                        @click="setColor('#ec4899')"
                        style="background-color: #ec4899"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-pink-300"
                        title="Rosa chicle"
                    ></button>
                    
                    {{-- Fila 2: Colores fríos --}}
                    <button 
                        @click="setColor('#00c76f')"
                        style="background-color: #00c76f"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-success-300"
                        title="Verde"
                    ></button>
                    <button 
                        @click="setColor('#10b981')"
                        style="background-color: #10b981"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-emerald-300"
                        title="Esmeralda"
                    ></button>
                    <button 
                        @click="setColor('#14b8a6')"
                        style="background-color: #14b8a6"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-teal-300"
                        title="Turquesa"
                    ></button>
                    <button 
                        @click="setColor('#06b6d4')"
                        style="background-color: #06b6d4"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-cyan-300"
                        title="Cian"
                    ></button>
                    <button 
                        @click="setColor('#0000fe')"
                        style="background-color: #0000fe"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-info-300"
                        title="Azul eléctrico"
                    ></button>
                    <button 
                        @click="setColor('#001b48')"
                        style="background-color: #001b48"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-secondary-300"
                        title="Azul marino"
                    ></button>
                    
                    {{-- Fila 3: Neutros y especiales --}}
                    <button 
                        @click="setColor('#1c1c1e')"
                        style="background-color: #1c1c1e"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-black-300"
                        title="Negro"
                    ></button>
                    <button 
                        @click="setColor('#4b5563')"
                        style="background-color: #4b5563"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-gray-400"
                        title="Gris oscuro"
                    ></button>
                    <button 
                        @click="setColor('#9ca3af')"
                        style="background-color: #9ca3af"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-gray-300"
                        title="Gris"
                    ></button>
                    <button 
                        @click="setColor('#d1d5db')"
                        style="background-color: #d1d5db"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-gray-200"
                        title="Gris claro"
                    ></button>
                    <button 
                        @click="setColor('#f3f4f6')"
                        style="background-color: #f3f4f6"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-accent-200 border border-black-200"
                        title="Blanco hueso"
                    ></button>
                    <button 
                        @click="setColor('#ffffff')"
                        style="background-color: #ffffff"
                        class="w-8 h-8 rounded hover:ring-2 hover:ring-accent-200 border border-black-200"
                        title="Blanco"
                    ></button>
                </div>
            </div>

            {{-- Custom Color Picker --}}
            <div class="mt-4">
                <input 
                    type="color" 
                    x-model="color"
                    @input="validate"
                    class="w-full h-10 rounded cursor-pointer"
                >
            </div>
        </div>
    </div>
</div>

{{-- Alpine component definido en store-design/index.blade.php --}} 