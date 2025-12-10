<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="asset-url" content="<?php echo e(asset('')); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - <?php echo e($store->name); ?></title>

    
    <?php
        $getLatestAppFavicon = function() {
            try {
                $tempFavicon = session('temp_app_favicon');
                if ($tempFavicon) {
                    return $tempFavicon;
                }

                $envFavicon = env('APP_FAVICON');
                if ($envFavicon) {
                    return $envFavicon;
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Error searching for app favicon: ' . $e->getMessage());
                return null;
            }
        };

        $faviconSrc = asset('favicon.ico');

        if ($store->design && $store->design->favicon_url) {
            $faviconSrc = $store->design->favicon_url;
        } else {
            $appFavicon = $getLatestAppFavicon();
            if ($appFavicon) {
                try {
                    $faviconSrc = asset('storage/' . $appFavicon);
                } catch (\Exception $e) {
                    Log::error('Error generating favicon URL: ' . $e->getMessage());
                    $faviconSrc = asset('storage/' . $appFavicon);
                }
            }
        }
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e($faviconSrc); ?>">
    

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/tours.css', 'resources/js/app.js', 'resources/js/tours/tour-manager.js']); ?>
    

    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    

    
    <?php echo $__env->yieldPushContent('styles'); ?>
    

    

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            
            <?php if(session('onboarding_step_completed')): ?>
                if (typeof window.confetti === 'function') {
                    const stepKey = 'confetti_step_shown_<?php echo e(now()->timestamp); ?>';
                    if (!sessionStorage.getItem(stepKey)) {
                        setTimeout(() => {
                            window.confetti({
                                particleCount: 50,
                                spread: 60,
                                origin: { y: 0.6 },
                                colors: ['#da27a7', '#0000fe', '#00c76f'],
                                startVelocity: 20,
                                ticks: 40
                            });
                            sessionStorage.setItem(stepKey, 'true');
                        }, 400);
                    }
                }
                <?php
                    session()->forget('onboarding_step_completed');
                ?>
            <?php endif; ?>

            <?php if(session('onboarding_just_completed')): ?>
                if (typeof window.confetti === 'function') {
                    const finalKey = 'confetti_final_shown_<?php echo e(auth()->id() ?? 0); ?>';
                    if (!sessionStorage.getItem(finalKey)) {
                        setTimeout(() => {
                            const duration = 3000;
                            const animationEnd = Date.now() + duration;
                            const defaults = {
                                startVelocity: 30,
                                spread: 360,
                                ticks: 60,
                                zIndex: 9999,
                                colors: ['#da27a7', '#001b48', '#ed2e45', '#0000fe', '#00c76f', '#e8e6fb']
                            };

                            function randomInRange(min, max) {
                                return Math.random() * (max - min) + min;
                            }

                            const interval = setInterval(function() {
                                const timeLeft = animationEnd - Date.now();

                                if (timeLeft <= 0) {
                                    return clearInterval(interval);
                                }

                                const particleCount = 50 * (timeLeft / duration);

                                window.confetti({
                                    ...defaults,
                                    particleCount,
                                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
                                });
                                window.confetti({
                                    ...defaults,
                                    particleCount,
                                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
                                });
                            }, 250);

                            sessionStorage.setItem(finalKey, 'true');
                        }, 500);
                    }
                }
                <?php
                    session()->forget('onboarding_just_completed');
                ?>
            <?php endif; ?>
        });
    </script>
    

    
    <script>
        document.addEventListener('alpine:init', () => {
            window.dispatchEvent(new CustomEvent('alpine-ready'));
        });
    </script>
    
</head>
<body class="bg-secondary-50 font-body tenant-admin" data-store-id="<?php echo e($store->id); ?>">
    
    <?php if (isset($component)) { $__componentOriginal62641c3f5209c19b58f8f690f6fd135d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62641c3f5209c19b58f8f690f6fd135d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.maintenance-notice','data' => ['variant' => 'admin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('maintenance-notice'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'admin']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62641c3f5209c19b58f8f690f6fd135d)): ?>
<?php $attributes = $__attributesOriginal62641c3f5209c19b58f8f690f6fd135d; ?>
<?php unset($__attributesOriginal62641c3f5209c19b58f8f690f6fd135d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62641c3f5209c19b58f8f690f6fd135d)): ?>
<?php $component = $__componentOriginal62641c3f5209c19b58f8f690f6fd135d; ?>
<?php unset($__componentOriginal62641c3f5209c19b58f8f690f6fd135d); ?>
<?php endif; ?>

    
    <?php if(session('preview_mode')): ?>
        <div class="bg-warning-300 border-b-2 border-warning-400 px-6 py-3 sticky top-0 z-[9999]">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center gap-3">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-eye-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-black-500 flex-shrink-0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                        <p class="text-sm font-semibold text-black-500">
                            Modo Vista Previa - SuperAdmin
                        </p>
                        <span class="text-xs text-black-400">
                            Viendo como: <span class="font-semibold"><?php echo e(session('preview_mode.store_name')); ?></span>
                        </span>
                        <span class="text-xs text-black-400 hidden sm:inline">
                            • Desde: <?php echo e(session('preview_mode.started_at')->format('H:i')); ?>

                        </span>
                    </div>
                </div>

                <form action="<?php echo e(route('linkiu.admin-preview.exit')); ?>" method="POST" class="flex-shrink-0">
                    <?php echo csrf_field(); ?>
                    <button 
                        type="submit"
                        class="bg-error-200 hover:bg-error-300 text-accent-50 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors"
                    >
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-logout-3-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span class="hidden sm:inline">Salir del Preview</span>
                        <span class="sm:hidden">Salir</span>
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    

    
    <?php echo $__env->make('shared::admin.tenant-sidebar', ['store' => $store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    

    
    <?php echo $__env->make('shared::admin.tenant-navbar', ['store' => $store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    

    
    <div 
        x-data="{
            marginLeft: '0px',
            paddingTop: '80px',
            initInterval: null,
            
            updatePosition() {
                const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
                const isMinified = savedMinified === 'true';
                const isDesktop = window.innerWidth >= 1024;
                
                if (typeof Alpine !== 'undefined' && Alpine.store) {
                    const store = Alpine.store('sidebar');
                    if (store) {
                        if (!store.isDesktop) {
                            this.marginLeft = '0px';
                        } else if (store.isMinified) {
                            this.marginLeft = '65px';
                        } else {
                            this.marginLeft = '288px';
                        }
                        return;
                    }
                }
                
                if (!isDesktop) {
                    this.marginLeft = '0px';
                } else if (isMinified) {
                    this.marginLeft = '65px';
                } else {
                    this.marginLeft = '288px';
                }
            },
            
            init() {
                this.updatePosition();
                
                const trySync = () => {
                    if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
                        this.updatePosition();
                        if (this.initInterval) {
                            clearInterval(this.initInterval);
                            this.initInterval = null;
                        }
                    }
                };
                
                let attempts = 0;
                this.initInterval = setInterval(() => {
                    attempts++;
                    if (attempts > 40) {
                        clearInterval(this.initInterval);
                        this.initInterval = null;
                    }
                    trySync();
                }, 50);
                
                window.addEventListener('sidebar-state-changed', () => {
                    this.updatePosition();
                });
                
                document.addEventListener('alpine:initialized', () => {
                    this.$nextTick(() => {
                        this.updatePosition();
                    });
                });
                
                window.addEventListener('resize', () => {
                    this.updatePosition();
                });
            }
        }"
        class="main-content transition-all duration-300"
        :style="`margin-left: ${marginLeft}; padding-top: ${paddingTop};`"
    >
        
        <main class="main-content-inner pb-24">
            
            <?php if (! empty(trim($__env->yieldContent('header')))): ?>
                <div class="page-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="heading-2 text-black-500 mb-1"><?php echo $__env->yieldContent('title'); ?></h1>
                            <?php if (! empty(trim($__env->yieldContent('subtitle')))): ?>
                                <p class="body-base text-black-300"><?php echo $__env->yieldContent('subtitle'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-3">
                            <?php echo $__env->yieldContent('actions'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            

            
            
            

            
            <div class="content-area">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            
        </main>
        

        
        <footer 
            x-data="{
                left: '0px',
                width: '100%',
                initInterval: null,
                
                updatePosition() {
                    const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
                    const isMinified = savedMinified === 'true';
                    const isDesktop = window.innerWidth >= 1024;
                    
                    if (typeof Alpine !== 'undefined' && Alpine.store) {
                        const store = Alpine.store('sidebar');
                        if (store) {
                            if (!store.isDesktop) {
                                this.left = '0px';
                                this.width = '100%';
                            } else if (store.isMinified) {
                                this.left = '65px';
                                this.width = 'calc(100% - 65px)';
                            } else {
                                this.left = '288px';
                                this.width = 'calc(100% - 288px)';
                            }
                            return;
                        }
                    }
                    
                    if (!isDesktop) {
                        this.left = '0px';
                        this.width = '100%';
                    } else if (isMinified) {
                        this.left = '65px';
                        this.width = 'calc(100% - 65px)';
                    } else {
                        this.left = '288px';
                        this.width = 'calc(100% - 288px)';
                    }
                },
                
                init() {
                    this.updatePosition();
                    
                    const trySync = () => {
                        if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
                            this.updatePosition();
                            if (this.initInterval) {
                                clearInterval(this.initInterval);
                                this.initInterval = null;
                            }
                        }
                    };
                    
                    let attempts = 0;
                    this.initInterval = setInterval(() => {
                        attempts++;
                        if (attempts > 40) {
                            clearInterval(this.initInterval);
                            this.initInterval = null;
                        }
                        trySync();
                    }, 50);
                    
                    window.addEventListener('sidebar-state-changed', () => {
                        this.updatePosition();
                    });
                    
                    document.addEventListener('alpine:initialized', () => {
                        this.$nextTick(() => {
                            this.updatePosition();
                        });
                    });
                    
                    window.addEventListener('resize', () => {
                        this.updatePosition();
                    });
                }
            }"
            class="fixed bottom-0 right-0 bg-white border-t border-gray-200 z-40 transition-all duration-300"
            :style="`left: ${left}; width: ${width};`"
        >
            <?php echo $__env->make('shared::admin.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </footer>
        
    </div>
    

    
    <div 
        id="loading-overlay"
        class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50 hidden"
    >
        <div class="bg-accent-50 rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary-300"></div>
            <span class="body-base text-black-400">Cargando...</span>
        </div>
    </div>
    

    
    <div 
        x-data="announcementPopups"
        x-init="init()"
        <?php echo $__env->yieldSection(); ?>-announcement-popup.window="showPopupFromPusher($event.detail)"
        x-show="popups.length > 0 && currentPopupIndex < popups.length"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center px-4"
        style="display: none;"
    >
        <div 
            class="absolute inset-0 bg-black-400/60 backdrop-blur-md" 
            @click="closePopup()"
        ></div>

        <div 
            x-show="popups.length > 0 && currentPopupIndex < popups.length"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative bg-accent-50 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden"
        >
            <div 
                :class="`bg-gradient-to-r from-${currentPopup.type_color}-100 to-${currentPopup.type_color}-75 border-b-4 border-${currentPopup.type_color}-200`"
                class="py-5 px-6"
            >
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div :class="`bg-${currentPopup.type_color}-200 rounded-full p-3`">
                            <span class="text-4xl" x-text="currentPopup.type_icon"></span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-h4 font-bold text-black-400 mb-1" x-text="currentPopup.title"></h3>
                            <div class="flex items-center gap-3 text-sm text-black-300">
                                <span 
                                    :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${currentPopup.type_color}-200 text-accent-50`"
                                >
                                    Crítico
                                </span>
                                <span class="flex items-center gap-1">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-calendar-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                    <span x-text="currentPopup.published_at"></span>
                                </span>
                                <span :class="`flex items-center gap-1 px-2 py-1 rounded-full bg-${currentPopup.type_color}-100`">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-star-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                    <span x-text="`Prioridad ${currentPopup.priority}`"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button 
                        @click="closePopup()"
                        class="text-black-300 hover:text-black-400 transition-colors p-2 hover:bg-black-50 rounded-lg"
                    >
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    </button>
                </div>
            </div>

            <div class="overflow-y-auto max-h-[calc(90vh-280px)] p-6">
                <div class="prose prose-sm max-w-none">
                    <div 
                        class="text-black-400 leading-relaxed whitespace-pre-wrap text-base"
                        x-html="currentPopup.content"
                    ></div>
                </div>

                <div x-show="currentPopup.banner_image_url" class="mt-6">
                    <a 
                        :href="currentPopup.banner_link || '#'"
                        :target="currentPopup.banner_link ? '_blank' : '_self'"
                        class="block rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
                    >
                        <img 
                            :src="currentPopup.banner_image_url"
                            alt="Banner"
                            class="w-full h-auto object-cover"
                        >
                    </a>
                </div>

                <div class="mt-6 p-4 bg-info-50 border border-info-100 rounded-lg">
                    <div class="flex items-start gap-3">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-info-300 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <div class="text-sm text-info-300">
                            <strong>Importante:</strong> Este es un anuncio crítico que requiere tu atención inmediata.
                            Por favor, léelo completamente antes de continuar.
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-accent-100 border-t border-accent-200 py-4 px-6">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span 
                            class="text-sm text-black-300 font-medium"
                            x-text="`Anuncio ${currentPopupIndex + 1} de ${popups.length}`"
                        ></span>
                        <div class="flex gap-1">
                            <template x-for="(popup, index) in popups" :key="popup.id">
                                <div 
                                    :class="index === currentPopupIndex ? 'bg-primary-300 w-8' : 'bg-black-200 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"
                                ></div>
                            </template>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a 
                            :href="currentPopup.show_url"
                            class="btn-outline-info px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform"
                        >
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-eye-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Ver Detalle Completo
                        </a>
                        <button 
                            @click="markAsReadAndNext()"
                            :class="currentPopupIndex < popups.length - 1 ? 'btn-primary' : 'btn-success'"
                            class="px-6 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform shadow-md"
                        >
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            <span x-show="currentPopupIndex < popups.length - 1">Siguiente Anuncio</span>
                            <span x-show="currentPopupIndex >= popups.length - 1">Entendido</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    

    
    <script>
        // Sistema híbrido: Pusher (instantáneo) + Polling (fallback)
        window.orderNotificationSystem = {
            storeSlug: '<?php echo e($store->slug); ?>',
            lastOrderCount: null,
            pollingInterval: null,
            pusherWorking: false,
            lastNotificationTime: 0,
            notifiedOrderIds: new Set() // Registro de pedidos ya notificados
        };

        document.addEventListener('DOMContentLoaded', function() {
            const system = window.orderNotificationSystem;
            
            // Función para verificar si ya se notificó este pedido
            function yaNotificado(orderId) {
                if (system.notifiedOrderIds.has(orderId)) {
                    return true;
                }
                system.notifiedOrderIds.add(orderId);
                // Limpiar IDs antiguos (mantener solo los últimos 50)
                if (system.notifiedOrderIds.size > 50) {
                    const arr = Array.from(system.notifiedOrderIds);
                    system.notifiedOrderIds = new Set(arr.slice(-50));
                }
                return false;
            }
            
            // 1️⃣ PUSHER: Notificaciones instantáneas (principal)
            if (typeof Echo !== 'undefined') {
                const storeId = <?php echo e($store->id); ?>;
                
                // Escuchar nuevos pedidos
                Echo.channel('store.' + storeId + '.orders')
                    .listen('.new.order', (event) => {
                        if (yaNotificado(event.order_id)) return;
                        system.pusherWorking = true;
                        system.lastNotificationTime = Date.now();
                        mostrarToastPedido(event, 'Nuevo Pedido');
                    });

                // Escuchar reservas de mesa
                Echo.channel('store.' + storeId + '.table-reservations')
                    .listen('.new.table.reservation', (event) => {
                        if (yaNotificado('mesa-' + event.reservation_id)) return;
                        system.pusherWorking = true;
                        system.lastNotificationTime = Date.now();
                        mostrarToastPedido({
                            order_id: event.reservation_id,
                            order_number: 'MESA-' + event.table_number,
                            customer_name: event.customer_name + ' - ' + event.people_count + ' personas',
                            total: 0,
                            url: event.url || '#'
                        }, 'Nueva Reserva de Mesa');
                    });

                // Escuchar pedidos de mesa (Dine-in)
                Echo.channel('store.' + storeId + '.dine-in-orders')
                    .listen('.new.dine.in.order', (event) => {
                        if (yaNotificado('dine-' + event.order_id)) return;
                        system.pusherWorking = true;
                        system.lastNotificationTime = Date.now();
                        mostrarToastPedido({
                            order_id: event.order_id,
                            order_number: 'MESA-' + event.table_number,
                            customer_name: event.table_name || 'Mesa ' + event.table_number,
                            total: event.total,
                            url: event.url || '#'
                        }, 'Nuevo Pedido de Mesa');
                    });

                // Escuchar reservas de hotel
                Echo.channel('store.' + storeId + '.hotel-reservations')
                    .listen('.new.hotel.reservation', (event) => {
                        if (yaNotificado('hotel-' + event.reservation_id)) return;
                        system.pusherWorking = true;
                        system.lastNotificationTime = Date.now();
                        mostrarToastPedido({
                            order_id: event.reservation_id,
                            order_number: 'HOTEL-' + event.room_number,
                            customer_name: event.customer_name + ' - ' + event.nights + ' noches',
                            total: event.total || 0,
                            url: event.url || '#'
                        }, 'Nueva Reserva de Hotel');
                    });
            }

            // 2️⃣ POLLING: Fallback confiable cada 15 segundos
            async function checkForNewOrders() {
                try {
                    const response = await fetch(`/${system.storeSlug}/admin/orders/api/count`);
                    
                    if (response.ok) {
                        const data = await response.json();
                        
                        if (data.success) {
                            // Inicializar conteo en primera carga
                            if (system.lastOrderCount === null) {
                                system.lastOrderCount = data.count;
                                return;
                            }
                            
                            // Detectar nuevos pedidos
                            if (data.count > system.lastOrderCount) {
                                if (data.latest_order) {
                                    // Verificar si ya se notificó este pedido
                                    if (!yaNotificado(data.latest_order.id)) {
                                        mostrarToastPedido({
                                            order_id: data.latest_order.id,
                                            order_number: data.latest_order.order_number,
                                            customer_name: data.latest_order.customer_name,
                                            total: data.latest_order.total,
                                            url: `/${system.storeSlug}/admin/orders/${data.latest_order.id}`
                                        }, 'Nuevo Pedido');
                                    }
                                }
                                
                                system.lastOrderCount = data.count;
                            }
                        }
                    }
                } catch (error) {
                    // Error silencioso
                }
            }

            // Iniciar polling cada 15 segundos
            checkForNewOrders(); // Primera llamada inmediata
            system.pollingInterval = setInterval(checkForNewOrders, 15000);

            // Limpiar al salir
            window.addEventListener('beforeunload', () => {
                if (system.pollingInterval) {
                    clearInterval(system.pollingInterval);
                }
            });
        });

        // Función auxiliar para mostrar toast de pedido/reserva
        function mostrarToastPedido(event, tipoMensaje = 'Nuevo Pedido') {
            // Mostrar toast
            if (window.toast) {
                window.toast.order({
                    order_id: event.order_id,
                    order_number: event.order_number,
                    customer_name: event.customer_name,
                    total: event.total,
                    delivery_type: event.delivery_type,
                    url: event.url
                }, 15000);
            }
            
            // Reproducir sonido (opcional, sin bloquear si falla)
            try {
                const audio = new Audio('<?php echo e(asset('sounds/order-notification.mp3')); ?>');
                audio.volume = 0.5;
                audio.play().catch(e => {});
            } catch (e) {
                // Ignorar si no hay sonido
            }
            
            // Actualizar badge de pedidos en el menú (si existe)
            const ordersBadge = document.querySelector('[data-orders-badge]');
            if (ordersBadge) {
                const currentCount = parseInt(ordersBadge.textContent) || 0;
                ordersBadge.textContent = currentCount + 1;
                ordersBadge.classList.remove('hidden');
            }
        }
    </script>
    

    
    <script>
        window.store = {
            id: <?php echo e($store->id); ?>,
            name: '<?php echo e($store->name); ?>',
            slug: '<?php echo e($store->slug); ?>',
            status: '<?php echo e($store->status); ?>',
            plan: {
                name: '<?php echo e($store->plan->name ?? 'Basic'); ?>',
                limits: {
                    products: <?php echo e($store->plan->max_products ?? 20); ?>,
                    categories: <?php echo e($store->plan->max_categories ?? 3); ?>,
                    variables: <?php echo e($store->plan->max_variables ?? 5); ?>,
                    coupons: <?php echo e($store->plan->max_active_coupons ?? 1); ?>,
                    sliders: <?php echo e($store->plan->max_slider ?? 1); ?>,
                    locations: <?php echo e($store->plan->max_sedes ?? 1); ?>

                }
            }
        };

        function announcementPopups() {
            return {
                popups: [],
                currentPopupIndex: 0,
                loading: false,

                get currentPopup() {
                    return this.popups[this.currentPopupIndex] || {};
                },

                async init() {
                    await this.loadPopups();
                },

                async loadPopups() {
                    if (this.loading) return;
                    this.loading = true;

                    try {
                        const response = await fetch('<?php echo e(route("tenant.admin.announcements.api.popups", $store->slug)); ?>');
                        const data = await response.json();
                        this.popups = data;
                        if (this.popups.length > 0) {
                            setTimeout(() => {
                                this.currentPopupIndex = 0;
                            }, 500);
                        }
                    } catch (error) {
                        // Error silencioso
                    } finally {
                        this.loading = false;
                    }
                },

                async markAsReadAndNext() {
                    try {
                        await fetch(`<?php echo e(route('tenant.admin.announcements.mark-as-read', ['store' => $store->slug, 'announcement' => ':id'])); ?>`.replace(':id', this.currentPopup.id), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (error) {
                        // Error silencioso
                    }

                    if (this.currentPopupIndex < this.popups.length - 1) {
                        this.currentPopupIndex++;
                    } else {
                        this.closePopup();
                    }
                },

                closePopup() {
                    this.popups = [];
                    this.currentPopupIndex = 0;
                },

                showPopupFromPusher(announcementData) {
                    if (!this.popups.find(p => p.id === announcementData.id)) {
                        this.popups.push(announcementData);

                        if (this.currentPopupIndex >= this.popups.length - 1) {
                            this.currentPopupIndex = this.popups.length - 1;
                        }
                    }
                }
            }
        }
    </script>
    
    
    
    <?php if (isset($component)) { $__componentOriginal05ab678be4a93b1db297cea753417346 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal05ab678be4a93b1db297cea753417346 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kiubot-floating-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kiubot-floating-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal05ab678be4a93b1db297cea753417346)): ?>
<?php $attributes = $__attributesOriginal05ab678be4a93b1db297cea753417346; ?>
<?php unset($__attributesOriginal05ab678be4a93b1db297cea753417346); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal05ab678be4a93b1db297cea753417346)): ?>
<?php $component = $__componentOriginal05ab678be4a93b1db297cea753417346; ?>
<?php unset($__componentOriginal05ab678be4a93b1db297cea753417346); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/layouts/tenant-admin.blade.php ENDPATH**/ ?>