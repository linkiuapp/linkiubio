<?php
use Illuminate\Support\Facades\Storage;
use App\Shared\Models\BillingSetting;
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="asset-url" content="<?php echo e(asset('')); ?>">
    <title><?php echo e(config('app.name', 'Linkiu.bio')); ?> - <?php echo $__env->yieldContent('title', 'Super Linkiu'); ?></title>
    
    <!-- Favicon -->
    <?php
        // ✅ LEER DESDE BASE DE DATOS (persistente)
        $settings = BillingSetting::getInstance();
        $appFavicon = $settings->app_favicon;
        
        $faviconSrc = asset('favicon.ico'); // Default
        
        if ($appFavicon) {
            try {
                // ✅ Usar Storage::url() siempre - funciona en local Y en S3/Laravel Cloud
                $faviconSrc = Storage::disk('public')->url($appFavicon);
            } catch (\Exception $e) {
                \Log::error('Error generando URL de favicon en layout', [
                    'favicon_path' => $appFavicon,
                    'error' => $e->getMessage()
                ]);
            }
        }
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e($faviconSrc); ?>">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    
    
    <?php echo $__env->yieldPushContent('styles'); ?>
    
</head>
<body class="bg-secondary-50 font-body super-admin">

    
    <?php if (isset($component)) { $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shared::admin.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $attributes = $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $component = $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
    

    
    <?php if (isset($component)) { $__componentOriginal06600c18cadf0581659ec97dd74972b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal06600c18cadf0581659ec97dd74972b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shared::admin.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal06600c18cadf0581659ec97dd74972b4)): ?>
<?php $attributes = $__attributesOriginal06600c18cadf0581659ec97dd74972b4; ?>
<?php unset($__attributesOriginal06600c18cadf0581659ec97dd74972b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal06600c18cadf0581659ec97dd74972b4)): ?>
<?php $component = $__componentOriginal06600c18cadf0581659ec97dd74972b4; ?>
<?php unset($__componentOriginal06600c18cadf0581659ec97dd74972b4); ?>
<?php endif; ?>
    

    
    <div 
        x-data="{
            marginLeft: '0px',
            paddingTop: '80px',
            initInterval: null,
            
            updatePosition() {
                const savedMinified = localStorage.getItem('sidebar_super-admin-sidebar_minified');
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
                    const savedMinified = localStorage.getItem('sidebar_super-admin-sidebar_minified');
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
            <?php if (isset($component)) { $__componentOriginal563b6827cca32fa1a554dd261a47d2be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal563b6827cca32fa1a554dd261a47d2be = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shared::admin.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal563b6827cca32fa1a554dd261a47d2be)): ?>
<?php $attributes = $__attributesOriginal563b6827cca32fa1a554dd261a47d2be; ?>
<?php unset($__attributesOriginal563b6827cca32fa1a554dd261a47d2be); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal563b6827cca32fa1a554dd261a47d2be)): ?>
<?php $component = $__componentOriginal563b6827cca32fa1a554dd261a47d2be; ?>
<?php unset($__componentOriginal563b6827cca32fa1a554dd261a47d2be); ?>
<?php endif; ?>
        </footer>
        
    </div>
    

    
    <div 
        id="loading-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
        style="display: none;"
    >
        <div class="bg-white rounded-lg p-6 flex flex-col items-center gap-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-300"></div>
            <p class="text-gray-700">Cargando...</p>
        </div>
    </div>
    

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/layouts/admin.blade.php ENDPATH**/ ?>