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
                <h4 class="text-sm font-medium text-black-400">Colores del Tema</h4>
                <div class="grid grid-cols-5 gap-2">
                    {{-- Primary Colors --}}
                    <button 
                        @click="setColor('#da27a7')"
                        class="w-8 h-8 rounded bg-primary-300 hover:ring-2 hover:ring-primary-100"
                        title="Primary 300"
                    ></button>
                    <button 
                        @click="setColor('#e04cb6')"
                        class="w-8 h-8 rounded bg-primary-200 hover:ring-2 hover:ring-primary-100"
                        title="Primary 200"
                    ></button>
                    
                    {{-- Secondary Colors --}}
                    <button 
                        @click="setColor('#001b48')"
                        class="w-8 h-8 rounded bg-secondary-300 hover:ring-2 hover:ring-secondary-100"
                        title="Secondary 300"
                    ></button>
                    <button 
                        @click="setColor('#2b4267')"
                        class="w-8 h-8 rounded bg-secondary-200 hover:ring-2 hover:ring-secondary-100"
                        title="Secondary 200"
                    ></button>

                    {{-- Info Colors --}}
                    <button 
                        @click="setColor('#0000fe')"
                        class="w-8 h-8 rounded bg-info-300 hover:ring-2 hover:ring-info-100"
                        title="Info 300 (Azul)"
                    ></button>
                    
                    {{-- Black Colors --}}
                    <button 
                        @click="setColor('#1c1c1e')"
                        class="w-8 h-8 rounded bg-black-300 hover:ring-2 hover:ring-black-100"
                        title="Black 300"
                    ></button>
                    
                    {{-- Error Colors --}}
                    <button 
                        @click="setColor('#ed2e45')"
                        class="w-8 h-8 rounded bg-error-300 hover:ring-2 hover:ring-error-100"
                        title="Error 300 (Rojo)"
                    ></button>
                    
                    {{-- Success Colors --}}
                    <button 
                        @click="setColor('#00c76f')"
                        class="w-8 h-8 rounded bg-success-300 hover:ring-2 hover:ring-success-100"
                        title="Success 300 (Verde)"
                    ></button>
                    {{-- White Colors --}}
                    <button 
                        @click="setColor('#fdfdff')"
                        class="w-8 h-8 rounded bg-accent-50 hover:ring-2 hover:ring-accent-200 border border-black-200"
                        title="Accent 50 (Blanco)"
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