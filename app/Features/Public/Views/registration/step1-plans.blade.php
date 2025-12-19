<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Elige tu Plan - Linkiu</title>
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
                            1
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Paso 1 de 4</p>
                            <p class="text-xs text-gray-600">Elige tu Plan</p>
                        </div>
                    </div>
                    <a href="{{ route('store.login') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        ¿Ya tienes cuenta? Inicia sesión →
                    </a>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Elige el Plan Perfecto</h2>
                <p class="text-base font-normal text-gray-600">Sin contratos. Sin sorpresas. Cancela cuando quieras.</p>
            </div>

            {{-- Banner Promocional --}}
            <div class="max-w-4xl mx-auto mb-12">
                <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl p-6 lg:p-8 shadow-2xl overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex-1 text-center md:text-left">
                                <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                                    <h3 class="text-lg lg:text-xl font-black text-white">
                                        Acceso Inmediato + 15 Días Gratis
                                    </h3>
                                </div>
                                <p class="text-blue-100 text-sm lg:text-base leading-relaxed">
                                    Completa tu pago hoy, activa tu registro y obtén acceso inmediato.<br>
                                    <span class="font-semibold text-white">El tiempo de tu plan comenzará a correr el día 16.</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl px-6 py-4 border border-white border-opacity-30">
                                    <div class="text-center">
                                        <div class="text-3xl font-black text-white">15</div>
                                        <div class="text-sm text-blue-100 font-medium">Días Gratis</div>
                                        <div class="text-xs text-blue-100 font-normal">Acceso Inmediato</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Decoración de fondo --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('register.step1.store') }}" x-data="planSelection()">
                @csrf
                
                {{-- Selector de Período --}}
                <div class="flex justify-center mb-12">
                    <div class="grid grid-cols-2 md:inline-flex items-center gap-2 md:gap-3 bg-white rounded-2xl md:rounded-full p-2 shadow-lg border border-gray-200 w-full max-w-md md:w-auto md:max-w-none">
                        <label class="cursor-pointer">
                            <input type="radio" name="billing_period" value="monthly" x-model="selectedPeriod" class="hidden">
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'monthly' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Mensual
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="quarterly" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-orange-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('quarterly')">5</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'quarterly' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Trimestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="semester" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-yellow-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('semester')">10</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'semester' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Semestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="annual" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-green-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('annual')">15</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'annual' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Anual
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Grid de Planes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-6 pt-2 md:pt-12">
                    @foreach($plans as $index => $plan)
                        @php
                            $isFeatured = $plan->is_featured;
                            // Mapear nombre del plan a la imagen del banner
                            $planImages = [
                                'Explorer' => 'banner_planes_explorer_registre.svg',
                                'Master' => 'banner_planes_master_registre.svg',
                                'Legend' => 'banner_planes_legend_registre.svg',
                            ];
                            $bannerImage = $planImages[$plan->name] ?? 'banner_planes_explorer_registre.svg';
                        @endphp
                        
                        <div class="pricing-plan-wrapper">
                            <label class="cursor-pointer block {{ $isFeatured ? 'lg:-mt-[50px] lg:scale-105 z-10' : '' }}">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" x-model="selectedPlan" class="sr-only peer" required>
                                
                                <div class="relative rounded-3xl overflow-hidden border bg-white border-gray-200 py-0 lg:py-0 transition-all duration-300 
                                            peer-checked:ring-1 peer-checked:ring-blue-500 peer-checked:border-blue-600 peer-checked:shadow-2xl
                                            hover:shadow-xl">

                                    {{-- Banner Superior con Gradiente --}}
                                    <div class="relative h-[158px] md:h-[172px] flex items-center justify-between px-4 overflow-hidden">
                                        <div class="relative z-10 ml-2 md:ml-0">
                                            <h6 class="text-lg font-bold text-slate-900 mb-1">
                                                {{ strtoupper($plan->name) }}
                                            </h6>
                                            @if($plan->trial_days > 0)
                                                <p class="text-sm md:text-base text-slate-900 font-medium mb-2">
                                                    {{ $plan->trial_days }} días gratis adicional
                                                </p>
                                            @endif
                                            @if($isFeatured)
                                                <span class="absolute bg-white text-slate-900 rounded-full py-1 px-3 text-xs font-bold shadow-lg z-20">
                                                    POPULAR
                                                </span>
                                            @endif
                                        </div>
                                        {{-- Ilustración decorativa --}}
                                        <div class="absolute right-0 top-0 h-full w-full flex items-center justify-center">
                                            <img src="{{ asset('images-ui/' . $bannerImage) }}" alt="Plan {{ $plan->name }}" class="h-full w-auto object-contain">
                                        </div>
                                    </div>

                                    {{-- Contenido del Plan --}}
                                    <div class="px-6 py-6">

                                        {{-- Precio Dinámico --}}
                                        <div class="mb-2">
                                            <h3 class="text-xl font-bold text-slate-900">
                                                <span x-text="formatPrice({{ $plan->id }})">{{ $plan->getPriceFormatted() }}</span>
                                                <span class="text-base font-medium text-slate-600">
                                                    <span x-text="getPeriodLabel()">Mes</span> COP
                                                </span>
                                            </h3>
                                        </div>

                                        {{-- Descripción --}}
                                        @if($plan->description)
                                            <p class="text-sm mb-4 font-normal text-slate-600">
                                                {{ Str::limit($plan->description, 150) }}
                                            </p>
                                        @endif

                                        {{-- Botón de Selección --}}
                                        <button type="button" 
                                                @click="selectedPlan = {{ $plan->id }}; $nextTick(() => { $el.closest('form').submit(); })"
                                                class="w-full py-3 rounded-lg font-semibold transition-all mb-4 bg-slate-900 hover:bg-slate-800 text-white border border-slate-800 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                            <span class="inline-flex items-center justify-center gap-2">
                                                Seleccionar plan
                                            </span>
                                        </button>

                                        {{-- Características --}}
                                        <div x-data="{ showAll: false }" class="mb-4">
                                            <span class="block mb-2 font-bold text-base text-slate-900">
                                                Lo que incluye:
                                            </span>
                                            <ul class="space-y-3">
                                                @php
                                                    $features = $plan->features_list ?? [];
                                                    $mainFeatures = array_slice($features, 0, 4);
                                                    $extraFeatures = array_slice($features, 4);
                                                @endphp
                                                @foreach($mainFeatures as $feature)
                                                    <li class="flex items-center gap-2">
                                                        <span class="flex justify-center items-center flex-shrink-0">
                                                            <i data-lucide="badge-check" class="w-4 h-4 text-slate-600"></i>
                                                        </span>
                                                        <span class="text-sm font-normal text-slate-600">
                                                            {{ $feature }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                                
                                                @if(count($extraFeatures) > 0)
                                                    <div x-show="showAll" x-cloak x-transition>
                                                        @foreach($extraFeatures as $feature)
                                                            <li class="flex items-center gap-3 mt-3">
                                                                <span class="flex justify-center items-center flex-shrink-0">
                                                                    <i data-lucide="badge-check" class="w-4 h-4 text-slate-600"></i>
                                                                </span>
                                                                <span class="text-sm font-normal text-slate-600">
                                                                    {{ $feature }}
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </ul>
                                            
                                            @if(count($extraFeatures) > 0)
                                                <button type="button" 
                                                        @click="showAll = !showAll; $nextTick(() => { if (window.createIcons) window.createIcons({ icons: window.lucideIcons }); })" 
                                                        class="mt-4 text-sm font-medium text-blue-600 hover:text-blue-800 underline transition-colors">
                                                    <span x-show="!showAll">Mostrar más</span>
                                                    <span x-show="showAll">Mostrar menos</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </main>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('planSelection', () => ({
            selectedPlan: null,
            selectedPeriod: 'monthly',
            @php
                $planData = [];
                foreach($plans as $plan) {
                    $planData[$plan->id] = [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'prices' => $plan->prices ?? [],
                        'price' => $plan->price
                    ];
                }
            @endphp
            plans: @json($planData),
            
            init() {
                this.$watch('selectedPlan', () => {
                    this.$nextTick(() => {
                        if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
                    });
                });
                
                this.$watch('selectedPeriod', () => {
                    this.$nextTick(() => {
                        if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
                    });
                });
            },
            
            formatPrice(planId) {
                const plan = this.plans[planId];
                if (!plan) return '$0';
                
                const prices = plan.prices || {};
                let price = 0;
                
                switch(this.selectedPeriod) {
                    case 'monthly':
                        price = plan.price;
                        break;
                    case 'quarterly':
                        price = prices.quarterly || (plan.price * 3);
                        break;
                    case 'semester':
                        price = prices.semester || (plan.price * 6);
                        break;
                    case 'annual':
                        price = prices.annual || (plan.price * 12);
                        break;
                }
                
                return '$' + new Intl.NumberFormat('es-CO').format(price);
            },
            
            getPeriodLabel() {
                const labels = {
                    'monthly': 'mes',
                    'quarterly': '3 meses',
                    'semester': '6 meses',
                    'annual': 'año'
                };
                return labels[this.selectedPeriod] || 'mes';
            },
            
            getDiscount(planId) {
                const plan = this.plans[planId];
                if (!plan || this.selectedPeriod === 'monthly') return 0;
                
                const prices = plan.prices || {};
                const monthlyPrice = plan.price;
                let actualPrice = 0;
                let months = 1;
                
                switch(this.selectedPeriod) {
                    case 'quarterly':
                        actualPrice = prices.quarterly || 0;
                        months = 3;
                        break;
                    case 'semester':
                        actualPrice = prices.semester || 0;
                        months = 6;
                        break;
                    case 'annual':
                        actualPrice = prices.annual || 0;
                        months = 12;
                        break;
                }
                
                if (actualPrice === 0 || monthlyPrice === 0) return 0;
                
                const fullPrice = monthlyPrice * months;
                const discount = ((fullPrice - actualPrice) / fullPrice) * 100;
                
                return Math.round(discount);
            },
            
            getAverageDiscount(period) {
                if (period === 'monthly') return 0;
                
                let totalDiscount = 0;
                let count = 0;
                
                Object.values(this.plans).forEach(plan => {
                    const discount = this.calculateDiscountForPlan(plan, period);
                    if (discount > 0) {
                        totalDiscount += discount;
                        count++;
                    }
                });
                
                return count > 0 ? Math.round(totalDiscount / count) : 0;
            },
            
            calculateDiscountForPlan(plan, period) {
                const prices = plan.prices || {};
                const monthlyPrice = plan.price;
                let actualPrice = 0;
                let months = 1;
                
                switch(period) {
                    case 'quarterly':
                        actualPrice = prices.quarterly || 0;
                        months = 3;
                        break;
                    case 'semester':
                        actualPrice = prices.semester || 0;
                        months = 6;
                        break;
                    case 'annual':
                        actualPrice = prices.annual || 0;
                        months = 12;
                        break;
                }
                
                if (actualPrice === 0 || monthlyPrice === 0) return 0;
                
                const fullPrice = monthlyPrice * months;
                return ((fullPrice - actualPrice) / fullPrice) * 100;
            }
        }));
    });

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
