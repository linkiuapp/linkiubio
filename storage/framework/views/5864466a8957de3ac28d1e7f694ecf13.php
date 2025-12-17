<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Elige tu Plan - Linkiu</title>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen">
        
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
                    <a href="<?php echo e(route('store.login')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
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

        
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Elige el Plan Perfecto</h2>
                <p class="text-base font-normal text-gray-600">Sin contratos. Sin sorpresas. Cancela cuando quieras.</p>
            </div>

            
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
                    
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('register.step1.store')); ?>" x-data="planSelection()">
                <?php echo csrf_field(); ?>
                
                
                <div class="flex justify-center mb-12">
                    <div class="inline-flex items-center gap-3 bg-white rounded-full p-2 shadow-lg border border-gray-200">
                        <label class="cursor-pointer">
                            <input type="radio" name="billing_period" value="monthly" x-model="selectedPeriod" class="hidden">
                            <span class="block px-6 py-2 rounded-full transition-all font-medium"
                                  :class="selectedPeriod === 'monthly' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Mensual
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="quarterly" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-3 -right-3 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('quarterly')">5</span>%
                            </span>
                            <span class="block px-6 py-2 rounded-full transition-all font-medium"
                                  :class="selectedPeriod === 'quarterly' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Trimestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="semester" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-3 -right-3 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('semester')">10</span>%
                            </span>
                            <span class="block px-6 py-2 rounded-full transition-all font-medium"
                                  :class="selectedPeriod === 'semester' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Semestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="annual" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-3 -right-3 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('annual')">15</span>%
                            </span>
                            <span class="block px-6 py-2 rounded-full transition-all font-medium"
                                  :class="selectedPeriod === 'annual' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Anual
                            </span>
                        </label>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-6 pt-12">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $colors = [
                                ['bg' => 'bg-purple-100', 'icon' => 'bg-purple-50', 'button' => 'bg-purple-600 hover:bg-purple-700 text-white border-purple-600', 'check' => 'bg-purple-600'],
                                ['bg' => 'bg-blue-600', 'icon' => 'bg-white', 'button' => 'bg-white hover:bg-blue-50 text-blue-600 border-white', 'check' => 'bg-white', 'text' => 'text-white'],
                                ['bg' => 'bg-green-100', 'icon' => 'bg-green-50', 'button' => 'bg-green-600 hover:bg-green-700 text-white border-green-600', 'check' => 'bg-green-600'],
                            ];
                            $colorScheme = $colors[$index % 3];
                            $isFeatured = $plan->is_featured;
                        ?>
                        
                        <div class="pricing-plan-wrapper">
                            <label class="cursor-pointer block <?php echo e($isFeatured ? 'lg:-mt-[50px] lg:scale-105 z-10' : ''); ?>">
                                <input type="radio" name="plan_id" value="<?php echo e($plan->id); ?>" x-model="selectedPlan" class="sr-only peer" required>
                                
                                <div class="relative rounded-3xl overflow-hidden border py-8 lg:py-10 px-6 lg:px-8 transition-all duration-300 
                                            <?php echo e($colorScheme['bg']); ?> 
                                            <?php echo e($isFeatured ? 'border-blue-600' : 'border-gray-200'); ?>

                                            peer-checked:ring-4 peer-checked:ring-blue-500 peer-checked:border-blue-600 peer-checked:shadow-2xl
                                            hover:shadow-xl <?php echo e(isset($colorScheme['text']) ? $colorScheme['text'] : ''); ?>">
                                    
                    <?php if($isFeatured): ?>
                        <span class="absolute right-0 top-0 bg-white bg-opacity-90 text-blue-600 rounded-bl-3xl py-2 px-6 text-sm font-bold shadow-lg">
                            POPULAR
                        </span>
                    <?php endif; ?>

                                    
                                    <div class="flex items-center gap-4 mb-6">
                                        <span class="w-[72px] h-[72px] flex justify-center items-center rounded-2xl <?php echo e($colorScheme['icon']); ?> shadow-md">
                                            <i data-lucide="zap" class="w-10 h-10 <?php echo e(isset($colorScheme['text']) ? 'text-blue-600' : 'text-gray-700'); ?>"></i>
                                        </span>
                                        <div>
                                            <span class="font-medium text-base <?php echo e(isset($colorScheme['text']) ? 'text-white opacity-90' : 'text-gray-600'); ?>">
                                                <?php if($plan->trial_days > 0): ?>
                                                    <?php echo e($plan->trial_days); ?> días gratis
                                                <?php else: ?>
                                                    Para tu negocio
                                                <?php endif; ?>
                                            </span>
                                            <h6 class="text-xl font-black <?php echo e(isset($colorScheme['text']) ? 'text-white' : 'text-gray-900'); ?>">
                                                <?php echo e($plan->name); ?>

                                            </h6>
                                        </div>
                                    </div>

                    
                    <?php if($plan->description): ?>
                        <p class="text-sm mb-6 <?php echo e(isset($colorScheme['text']) ? 'text-white opacity-90' : 'text-gray-600'); ?>">
                            <?php echo e(Str::limit($plan->description, 150)); ?>

                        </p>
                    <?php endif; ?>

                    
                    <div class="mb-6">
                        <h3 class="text-2xl font-black <?php echo e(isset($colorScheme['text']) ? 'text-white' : 'text-gray-900'); ?>">
                            <span x-text="formatPrice(<?php echo e($plan->id); ?>)"><?php echo e($plan->getPriceFormatted()); ?></span>
                            <span class="text-lg font-medium <?php echo e(isset($colorScheme['text']) ? 'text-white opacity-75' : 'text-gray-600'); ?>">
                                / <span x-text="getPeriodLabel()">mes</span>
                            </span>
                        </h3>
                    </div>

                    
                    <button type="button" 
                            @click="selectedPlan = <?php echo e($plan->id); ?>; $nextTick(() => { $el.closest('form').submit(); })"
                            class="w-full py-3 rounded-lg font-semibold transition-all mb-6 <?php echo e($colorScheme['button']); ?> shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                        <span class="inline-flex items-center justify-center gap-2">
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            Seleccionar Plan
                        </span>
                    </button>

                    
                    <div x-data="{ showAll: false }" class="mb-8">
                        <span class="block mb-4 font-semibold <?php echo e(isset($colorScheme['text']) ? 'text-white' : 'text-gray-900'); ?>">
                            Lo que incluye:
                        </span>
                        <ul class="space-y-3">
                            <?php
                                $features = $plan->features_list ?? [];
                                $mainFeatures = array_slice($features, 0, 5);
                                $extraFeatures = array_slice($features, 5);
                            ?>
                            <?php $__currentLoopData = $mainFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center gap-3">
                                    <span class="w-6 h-6 flex justify-center items-center <?php echo e($colorScheme['check']); ?> rounded-full flex-shrink-0">
                                        <i data-lucide="check" class="w-4 h-4 <?php echo e(isset($colorScheme['text']) ? 'text-blue-600' : 'text-white'); ?>"></i>
                                    </span>
                                    <span class="text-sm <?php echo e(isset($colorScheme['text']) ? 'text-white' : 'text-gray-700'); ?>">
                                        <?php echo e($feature); ?>

                                    </span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php if(count($extraFeatures) > 0): ?>
                                <div x-show="showAll" x-cloak x-transition>
                                    <?php $__currentLoopData = $extraFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="flex items-center gap-3 mt-3">
                                            <span class="w-6 h-6 flex justify-center items-center <?php echo e($colorScheme['check']); ?> rounded-full flex-shrink-0">
                                                <i data-lucide="check" class="w-4 h-4 <?php echo e(isset($colorScheme['text']) ? 'text-blue-600' : 'text-white'); ?>"></i>
                                            </span>
                                            <span class="text-sm <?php echo e(isset($colorScheme['text']) ? 'text-white' : 'text-gray-700'); ?>">
                                                <?php echo e($feature); ?>

                                            </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </ul>
                        
                        <?php if(count($extraFeatures) > 0): ?>
                            <button type="button" 
                                    @click="showAll = !showAll; $nextTick(() => { if (window.createIcons) window.createIcons({ icons: window.lucideIcons }); })" 
                                    class="mt-4 text-sm font-medium <?php echo e(isset($colorScheme['text']) ? 'text-white underline' : 'text-blue-600 hover:text-blue-800'); ?> transition-colors">
                                <span x-show="!showAll">+ Ver más (<?php echo e(count($extraFeatures)); ?>)</span>
                                <span x-show="showAll">- Ver menos</span>
                            </button>
                        <?php endif; ?>
                    </div>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </form>
        </main>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('planSelection', () => ({
            selectedPlan: null,
            selectedPeriod: 'monthly',
            <?php
                $planData = [];
                foreach($plans as $plan) {
                    $planData[$plan->id] = [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'prices' => $plan->prices ?? [],
                        'price' => $plan->price
                    ];
                }
            ?>
            plans: <?php echo json_encode($planData, 15, 512) ?>,
            
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\Public/Views/registration/step1-plans.blade.php ENDPATH**/ ?>