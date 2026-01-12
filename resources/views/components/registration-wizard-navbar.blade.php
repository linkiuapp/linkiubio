@props([
    'currentStep' => 1,
    'totalSteps' => 4,
    'showBackButton' => false,
    'backRoute' => null,
])

@php
    $steps = [
        1 => [
            'title' => 'Plan',
            'icon' => 'package',
        ],
        2 => [
            'title' => 'Negocio',
            'icon' => 'briefcase',
        ],
        3 => [
            'title' => 'Tienda',
            'icon' => 'store',
        ],
        4 => [
            'title' => 'Propietario',
            'icon' => 'user',
        ],
    ];
@endphp

<div class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-8 lg:py-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 lg:gap-0">
            {{-- Stepper compacto --}}
            <div class="flex items-center justify-center gap-2 sm:gap-3 md:gap-6 w-full lg:w-auto overflow-x-auto pb-1 lg:pb-0">
                @foreach($steps as $stepNum => $step)
                    @php
                        $isCompleted = $stepNum < $currentStep;
                        $isActive = $stepNum == $currentStep;
                        $isPending = $stepNum > $currentStep;
                    @endphp
                    
                    <div class="flex items-center flex-shrink-0">
                        {{-- Círculo con icono --}}
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300
                                @if($isCompleted)
                                    bg-green-500 text-white
                                @elseif($isActive)
                                    bg-accent-300 text-white ring-2 ring-accent-300/30
                                @else
                                    bg-gray-200 text-gray-400
                                @endif">
                                @if($isCompleted)
                                    <i data-lucide="check" class="w-5 h-5 md:w-5 md:h-5"></i>
                                @else
                                    <i data-lucide="{{ $step['icon'] }}" class="w-5 h-5 md:w-5 md:h-5"></i>
                                @endif
                            </div>
                            {{-- Label del paso --}}
                            <span class="text-xs md:text-sm font-medium mt-2 whitespace-nowrap
                                @if($isActive) text-accent-300 @elseif($isCompleted) text-green-600 @else text-gray-400 @endif">
                                {{ $step['title'] }}
                            </span>
                        </div>
                        
                        {{-- Línea conectora --}}
                        @if($stepNum < $totalSteps)
                            <div class="w-6 md:w-12 h-0.5 mx-1 md:mx-2 relative flex-shrink-0">
                                <div class="absolute inset-0 bg-gray-200"></div>
                                <div class="absolute inset-0 bg-accent-300 transition-all duration-500 
                                    @if($stepNum < $currentStep) w-full @else w-0 @endif"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            {{-- Botones a la derecha --}}
            <div class="w-full lg:w-auto">
                <div class="flex items-center gap-2 sm:gap-3 w-full lg:w-auto">
                    @if($showBackButton && $backRoute)
                        <a href="{{ $backRoute }}" class="hidden lg:flex text-sm text-gray-600 hover:text-gray-900 font-medium items-center gap-1 transition-colors px-3 py-1.5 rounded-lg hover:bg-gray-50">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Volver</span>
                        </a>
                    @endif
                    
                    <button type="button" 
                            @click="calendlyOpen = true"
                            class="px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 border border-gray-300 text-slate-950 hover:border-gray-500 font-semibold text-xs sm:text-sm rounded-lg transition-colors whitespace-nowrap flex-1 lg:flex-none text-center justify-center">
                        <span class="hidden sm:inline">Agendar reunión</span>
                        <span class="sm:hidden">Reunión</span>
                    </button>
                    
                    <a href="{{ route('store.login') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg font-semibold text-xs sm:text-sm transition-colors whitespace-nowrap flex-1 lg:flex-none text-center justify-center">
                        <span class="hidden sm:inline">Ya tengo cuenta</span>
                        <span class="sm:hidden">Mi cuenta</span>
                    </a>
                </div>
                
                {{-- Texto de regresar en móvil --}}
                @if($showBackButton && $backRoute)
                    <a href="{{ $backRoute }}" class="lg:hidden block text-center mt-2 text-xs text-gray-600 hover:text-gray-900 font-medium underline transition-colors">
                        Regresar al paso anterior
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar iconos Lucide cuando el componente se monte
    document.addEventListener('DOMContentLoaded', function() {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
</script>

    <!-- Calendly Modal -->
    <div 
        x-show="calendlyOpen" 
        x-cloak
        x-transition
        @click.self="calendlyOpen = false"
        @keydown.escape.window="calendlyOpen = false"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    >
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <!-- Close Button -->
            <button 
                @click="calendlyOpen = false"
                class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5 text-gray-600"></i>
            </button>
            
            <!-- Calendly Widget -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/linkiucloud/30min?hide_event_type_details=1&hide_gdpr_banner=1&text_color=050506&primary_color=ea0038" style="min-width:320px;height:700px;"></div>
        </div>
    </div>

<script>
    // Inicializar iconos Lucide cuando el componente se monte
    document.addEventListener('DOMContentLoaded', function() {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
