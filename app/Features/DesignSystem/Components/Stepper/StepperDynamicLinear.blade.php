{{--
Stepper Dynamic Linear - Stepper con navegación lineal
Uso: Guía a los usuarios a través de pasos secuenciales de una tarea
Cuándo usar: Para formularios multi-paso, procesos de configuración, wizards
Cuándo NO usar: Cuando no necesites navegación secuencial entre pasos
Ejemplo: <x-stepper-dynamic-linear :steps="[['label' => 'Paso 1', 'content' => '...'], ['label' => 'Paso 2', 'content' => '...']]" />
--}}

@props([
    'steps' => [], // Array de pasos: [['label' => '...', 'content' => '...']]
    'stepperId' => null, // ID único para el stepper
    'currentIndex' => 1, // Índice del paso actual (default: 1)
])

@php
    $uniqueId = $stepperId ?? 'stepper-' . uniqid();
    $regularSteps = array_filter($steps, fn($step) => !($step['isFinal'] ?? false));
    $finalStep = collect($steps)->firstWhere('isFinal', true);
    $regularStepsCount = count($regularSteps);
@endphp

<!-- Stepper -->
<div 
    x-data="{
        currentStep: {{ $currentIndex }},
        totalSteps: {{ $regularStepsCount }},
        hasFinalStep: {{ $finalStep ? 'true' : 'false' }},
        allCompleted: false,
        
        isActiveStep(index) {
            return this.currentStep === index && !this.allCompleted;
        },
        
        isSuccessStep(index) {
            return this.currentStep > index && !this.allCompleted;
        },
        
        isCompletedStep(index) {
            return this.allCompleted;
        },
        
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
            } else if (this.hasFinalStep && this.currentStep === this.totalSteps) {
                this.currentStep = 'final';
            } else {
                this.allCompleted = true;
            }
        },
        
        previousStep() {
            if (this.currentStep === 'final') {
                this.currentStep = this.totalSteps;
            } else if (this.currentStep > 1) {
                this.allCompleted = false;
                this.currentStep--;
            }
        },
        
        finish() {
            this.allCompleted = true;
        },
        
        reset() {
            this.currentStep = 1;
            this.allCompleted = false;
        },
        
        showBackButton() {
            return this.currentStep > 1 || this.currentStep === 'final';
        },
        
        showNextButton() {
            return this.currentStep !== 'final' && !this.allCompleted;
        },
        
        showFinishButton() {
            return this.currentStep === 'final';
        }
    }"
    {{ $attributes }}
>
    <!-- Stepper Nav -->
    <ul class="relative flex flex-row gap-x-2">
        @foreach($regularSteps as $index => $step)
            @php
                $stepIndex = $index + 1;
                $label = $step['label'] ?? 'Step';
            @endphp
            
            <li 
                class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
                :class="{
                    'hs-stepper-active': isActiveStep({{ $stepIndex }}),
                    'hs-stepper-success': isSuccessStep({{ $stepIndex }}),
                    'hs-stepper-completed': isCompletedStep({{ $stepIndex }})
                }"
            >
                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span 
                        class="size-7 flex justify-center items-center shrink-0 font-medium rounded-full group-focus:bg-gray-200 transition-colors"
                        :class="{
                            'bg-blue-600 text-white': isActiveStep({{ $stepIndex }}) || isSuccessStep({{ $stepIndex }}),
                            'bg-teal-500 text-white': isCompletedStep({{ $stepIndex }}),
                            'bg-gray-100 text-gray-800': !isActiveStep({{ $stepIndex }}) && !isSuccessStep({{ $stepIndex }}) && !isCompletedStep({{ $stepIndex }})
                        }"
                    >
                        <span x-show="!isSuccessStep({{ $stepIndex }}) && !isCompletedStep({{ $stepIndex }})">{{ $stepIndex }}</span>
                        <svg 
                            x-show="isSuccessStep({{ $stepIndex }}) || isCompletedStep({{ $stepIndex }})"
                            class="shrink-0 size-3" 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="24" 
                            height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="3" 
                            stroke-linecap="round" 
                            stroke-linejoin="round"
                            style="display: none;"
                        >
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span class="ms-2 text-sm font-medium text-gray-800">
                        {{ $label }}
                    </span>
                </span>
                @if(!$loop->last)
                    <div 
                        class="w-full h-px flex-1 transition-colors"
                        :class="{
                            'bg-blue-600': isSuccessStep({{ $stepIndex }}) && !isCompletedStep({{ $stepIndex }}),
                            'bg-teal-600': isCompletedStep({{ $stepIndex }}),
                            'bg-gray-200': !isSuccessStep({{ $stepIndex }}) && !isCompletedStep({{ $stepIndex }})
                        }"
                    ></div>
                @endif
            </li>
        @endforeach
    </ul>
    <!-- End Stepper Nav -->

    <!-- Stepper Content -->
    <div class="mt-5 sm:mt-8">
        @foreach($regularSteps as $index => $step)
            @php
                $stepIndex = $index + 1;
                $content = $step['content'] ?? '';
            @endphp
            
            <div 
                x-show="currentStep === {{ $stepIndex }}"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                @if($stepIndex !== 1) style="display: none;" @endif
            >
                {!! $content !!}
            </div>
        @endforeach

        @if($finalStep)
            <div 
                x-show="currentStep === 'final'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                style="display: none;"
            >
                {!! $finalStep['content'] ?? '' !!}
            </div>
        @endif

        <!-- Button Group -->
        <div class="mt-5 flex justify-between items-center gap-x-2">
            <button 
                type="button" 
                @click="previousStep()"
                x-show="showBackButton()"
                :disabled="currentStep === 1"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
            >
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Atrás
            </button>
            <button 
                type="button" 
                @click="nextStep()"
                x-show="showNextButton()"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
            >
                Siguiente
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </button>
            <button 
                type="button" 
                @click="finish()"
                x-show="showFinishButton()"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                style="display: none;"
            >
                Finalizar
            </button>
            <button 
                type="reset" 
                @click="reset()"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                style="display: none;"
            >
                Reiniciar
            </button>
        </div>
        <!-- End Button Group -->
    </div>
    <!-- End Stepper Content -->
</div>
<!-- End Stepper -->
