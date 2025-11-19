{{--
Stepper Skipped - Stepper con pasos opcionales que pueden saltarse
Uso: Permite marcar pasos como opcionales y saltarlos
Cuándo usar: Cuando algunos pasos son opcionales en el proceso
Cuándo NO usar: Cuando todos los pasos son obligatorios
Ejemplo: <x-stepper-skipped :steps="[['label' => 'Paso 1', 'content' => '...', 'isOptional' => true], ['label' => 'Paso 2', 'content' => '...']]" />
--}}

@props([
    'steps' => [], // Array de pasos: [['label' => '...', 'content' => '...', 'isOptional' => false]]
    'stepperId' => null, // ID único para el stepper
    'currentIndex' => 1, // Índice del paso actual
])

@php
    $uniqueId = $stepperId ?? 'stepper-skipped-' . uniqid();
    $regularSteps = array_filter($steps, fn($step) => !($step['isFinal'] ?? false));
    $finalStep = collect($steps)->firstWhere('isFinal', true);
    $regularStepsCount = count($regularSteps);
@endphp

<!-- Stepper -->
<div 
    x-data="{
        currentStep: {{ $currentIndex }},
        skippedSteps: [],
        totalSteps: {{ $regularStepsCount }},
        hasFinalStep: {{ $finalStep ? 'true' : 'false' }},
        optionalSteps: {{ json_encode(array_map(fn($s) => ($s['isOptional'] ?? false), array_values($regularSteps))) }},
        
        isActiveStep(index) {
            return this.currentStep === index;
        },
        
        isOptionalStep(index) {
            return this.optionalSteps[index - 1] || false;
        },
        
        isSkippedStep(index) {
            return this.skippedSteps.includes(index);
        },
        
        skipStep() {
            if (this.isOptionalStep(this.currentStep) && !this.skippedSteps.includes(this.currentStep)) {
                this.skippedSteps.push(this.currentStep);
                this.nextStep();
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
            this.currentStep = 1;
            this.skippedSteps = [];
        },
        
        showBackButton() {
            return this.currentStep > 1 || this.currentStep === 'final';
        },
        
        showSkipButton() {
            return this.isOptionalStep(this.currentStep) && this.currentStep !== 'final';
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
                $isOptional = $step['isOptional'] ?? false;
            @endphp
            
            <li 
                class="flex items-center gap-x-2 shrink basis-0 flex-1 group {{ $stepIndex === $currentIndex ? 'active' : '' }}"
                :class="{
                    'active': isActiveStep({{ $stepIndex }})
                }"
            >
                <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                    <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600"
                        :class="{
                            'hs-stepper-active': isActiveStep({{ $stepIndex }})
                        }"
                    >
                        <span>{{ $stepIndex }}</span>
                    </span>
                    <span class="ms-2 text-sm font-medium text-gray-800 group-focus:text-gray-500">
                        {{ $label }}
                    </span>
                </span>
                @if(!$loop->last)
                    <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600"></div>
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
                @if($stepIndex !== $currentIndex) style="display: none;" @endif
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
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
            >
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Atrás
            </button>
            <button 
                type="button" 
                @click="skipStep()"
                x-show="showSkipButton()"
                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                style="display: none;"
            >
                Saltar
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
