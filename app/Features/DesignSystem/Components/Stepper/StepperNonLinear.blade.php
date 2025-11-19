{{--
Stepper Non Linear - Stepper con navegación no lineal y botón "Complete Step"
Uso: Permite completar pasos individualmente sin seguir un orden estricto
Cuándo usar: Cuando los pasos pueden completarse independientemente
Cuándo NO usar: Cuando necesites navegación secuencial obligatoria
Ejemplo: <x-stepper-non-linear :steps="[['label' => 'Paso 1', 'content' => '...'], ['label' => 'Paso 2', 'content' => '...']]" />
--}}

@props([
    'steps' => [], // Array de pasos: [['label' => '...', 'content' => '...']]
    'stepperId' => null, // ID único para el stepper
    'currentIndex' => null, // Índice del paso inicial (default: último paso)
])

@php
    $uniqueId = $stepperId ?? 'stepper-non-linear-' . uniqid();
    $regularSteps = array_filter($steps, fn($step) => !($step['isFinal'] ?? false));
    $finalStep = collect($steps)->firstWhere('isFinal', true);
    $regularStepsCount = count($regularSteps);
    $initialIndex = $currentIndex ?? $regularStepsCount;
@endphp

<!-- Stepper -->
<div 
    x-data="{
        currentStep: {{ $initialIndex }},
        completedSteps: [],
        totalSteps: {{ $regularStepsCount }},
        hasFinalStep: {{ $finalStep ? 'true' : 'false' }},
        
        isActiveStep(index) {
            return this.currentStep === index;
        },
        
        isCompletedStep(index) {
            return this.completedSteps.includes(index);
        },
        
        goToStep(index) {
            this.currentStep = index;
        },
        
        completeCurrentStep() {
            if (!this.completedSteps.includes(this.currentStep)) {
                this.completedSteps.push(this.currentStep);
            }
        },
        
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
            } else if (this.hasFinalStep && this.currentStep === this.totalSteps) {
                this.currentStep = 'final';
            }
        },
        
        previousStep() {
            if (this.currentStep === 'final') {
                this.currentStep = this.totalSteps;
            } else if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        
        finish() {
            console.log('Wizard completado');
        },
        
        reset() {
            this.currentStep = {{ $initialIndex }};
            this.completedSteps = [];
        },
        
        showBackButton() {
            return this.currentStep > 1 || this.currentStep === 'final';
        },
        
        showNextButton() {
            return this.currentStep !== 'final';
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
                class="flex items-center gap-x-2 shrink basis-0 flex-1 group cursor-pointer {{ $stepIndex === $initialIndex ? 'active' : '' }}"
                :class="{
                    'active': isActiveStep({{ $stepIndex }}),
                    'success': isCompletedStep({{ $stepIndex }})
                }"
                @click="goToStep({{ $stepIndex }})"
            >
                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                    <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600"
                        :class="{
                            'hs-stepper-active': isActiveStep({{ $stepIndex }}),
                            'hs-stepper-success': isCompletedStep({{ $stepIndex }})
                        }"
                    >
                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">{{ $stepIndex }}</span>
                        <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </span>
                    <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500">
                        {{ $label }}
                    </span>
                </span>
                @if(!$loop->last)
                    <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600"
                        :class="{
                            'hs-stepper-success': isCompletedStep({{ $stepIndex }})
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
                @if($stepIndex !== $initialIndex) style="display: none;" @endif
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
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
            >
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Atrás
            </button>
            <button 
                type="button" 
                @click="completeCurrentStep()"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
            >
                Completar Paso
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
