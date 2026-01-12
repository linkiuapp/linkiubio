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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            {{-- Stepper compacto --}}
            <div class="flex items-center gap-2 md:gap-4">
                @foreach($steps as $stepNum => $step)
                    @php
                        $isCompleted = $stepNum < $currentStep;
                        $isActive = $stepNum == $currentStep;
                        $isPending = $stepNum > $currentStep;
                    @endphp
                    
                    <div class="flex items-center">
                        {{-- Círculo con icono --}}
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300
                                @if($isCompleted)
                                    bg-green-500 text-white
                                @elseif($isActive)
                                    bg-accent-300 text-white ring-2 ring-accent-300/30
                                @else
                                    bg-gray-200 text-gray-400
                                @endif">
                                @if($isCompleted)
                                    <i data-lucide="check" class="w-4 h-4 md:w-5 md:h-5"></i>
                                @else
                                    <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 md:w-5 md:h-5"></i>
                                @endif
                            </div>
                            {{-- Label del paso --}}
                            <span class="text-xs md:text-sm font-medium mt-1.5
                                @if($isActive) text-accent-300 @elseif($isCompleted) text-green-600 @else text-gray-400 @endif">
                                {{ $step['title'] }}
                            </span>
                        </div>
                        
                        {{-- Línea conectora --}}
                        @if($stepNum < $totalSteps)
                            <div class="w-8 md:w-12 h-0.5 mx-1 md:mx-2 relative">
                                <div class="absolute inset-0 bg-gray-200"></div>
                                <div class="absolute inset-0 bg-accent-300 transition-all duration-500 
                                    @if($stepNum < $currentStep) w-full @else w-0 @endif"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            {{-- Botones a la derecha --}}
            <div class="flex items-center gap-2 md:gap-3">
                @if($showBackButton && $backRoute)
                    <a href="{{ $backRoute }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1.5 transition-colors px-3 py-1.5 rounded-lg hover:bg-gray-50">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Volver</span>
                    </a>
                @endif
                
                <button type="button" 
                        @click="calendlyOpen = true"
                        class="px-5 py-2.5 border border-gray-300 text-slate-950 hover:border-gray-500 font-semibold rounded-lg transition-colors">
                    Agendar reunión
                </button>
                
                <a href="{{ route('store.login') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-5 py-2.5 rounded-lg font-semibold transition-colors">
                    Ya tengo cuenta
                </a>
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
