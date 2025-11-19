{{--
PIN Input Numbers Only - Input PIN solo números
Uso: Input PIN que solo acepta números
Cuándo usar: Cuando necesites que el PIN solo contenga números
Cuándo NO usar: Cuando necesites aceptar letras también
Ejemplo: <x-pin-input-numbers-only length="4" />
--}}

@props([
    'length' => 4,
    'autofocus' => true,
])

@php
    $uniqueId = 'pin-input-numbers-' . uniqid();
    $inputs = [];
    for ($i = 0; $i < $length; $i++) {
        $inputs[] = $uniqueId . '-' . $i;
    }
@endphp

<div class="flex gap-x-3" x-data="{
    length: {{ $length }},
    inputs: [],
    init() {
        this.$nextTick(() => {
            this.inputs = this.$el.querySelectorAll('input[data-pin-index]');
            
            this.inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    // Solo permitir números
                    if (!/^[0-9]$/.test(e.target.value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Mover al siguiente input
                    if (e.target.value && index < this.length - 1) {
                        this.inputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        this.inputs[index - 1].focus();
                    }
                });
                
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const pasteArray = paste.replace(/[^0-9]/g, '').slice(0, this.length - index).split('');
                    
                    pasteArray.forEach((char, i) => {
                        const targetIndex = index + i;
                        if (targetIndex < this.length) {
                            this.inputs[targetIndex].value = char;
                            if (targetIndex < this.length - 1) {
                                this.inputs[targetIndex + 1].focus();
                            }
                        }
                    });
                });
            });
        });
    },
    getValue() {
        return Array.from(this.inputs).map(input => input.value).join('');
    }
}">
    @foreach($inputs as $index => $inputId)
        <input 
            type="text" 
            id="{{ $inputId }}"
            data-pin-index="{{ $index }}"
            @if($index === 0 && $autofocus) autofocus @endif
            maxlength="1"
            placeholder="⚬"
            inputmode="numeric"
            class="block size-11 text-center border-gray-200 rounded-md sm:text-sm [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}
        >
    @endforeach
</div>

