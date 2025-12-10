<?php if (isset($component)) { $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1 = $attributes; } ?>
<?php $component = App\Shared\Views\Components\TenantAdminLayout::resolve(['store' => $store] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tenant-admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\Shared\Views\Components\TenantAdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Dashboard'); ?>
    <?php $__env->startSection('subtitle', 'Panel de administración de tu tienda'); ?>

    <?php $__env->startSection('content'); ?>
        
        <?php if($store->approval_status === 'pending_approval'): ?>
        <div class="mb-6 bg-white border-l-4 border-warning-400 rounded-lg p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-swarning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-warning-500"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">⏰ Tu tienda está en revisión</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Estamos revisando tu solicitud. Este proceso usualmente toma <strong>24-48 horas</strong>.
                        Te notificaremos por email cuando tu tienda esté aprobada y lista para publicar.
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($banners->isNotEmpty()): ?>
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Anuncios</h3>
                <?php if (isset($component)) { $__componentOriginale113f27684f3a6a2f950cb1c290536ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale113f27684f3a6a2f950cb1c290536ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.AnnouncementCarouselStatic','data' => ['banners' => $banners,'height' => 'h-64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('announcement-carousel-static'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['banners' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banners),'height' => 'h-64']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale113f27684f3a6a2f950cb1c290536ee)): ?>
<?php $attributes = $__attributesOriginale113f27684f3a6a2f950cb1c290536ee; ?>
<?php unset($__attributesOriginale113f27684f3a6a2f950cb1c290536ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale113f27684f3a6a2f950cb1c290536ee)): ?>
<?php $component = $__componentOriginale113f27684f3a6a2f950cb1c290536ee; ?>
<?php unset($__componentOriginale113f27684f3a6a2f950cb1c290536ee); ?>
<?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6" data-tour="stats-cards">
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl">
                        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['total'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Total</div>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-amber-100 text-amber-600 rounded-xl">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Pendientes</div>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-xl">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['confirmed'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Confirmados</div>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-purple-100 text-purple-600 rounded-xl">
                        <i data-lucide="package" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['preparing'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Preparando</div>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-xl">
                        <i data-lucide="truck" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['shipped'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Enviados</div>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-emerald-100 text-emerald-600 rounded-xl">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($stats['delivered'] ?? 0); ?></div>
                        <div class="text-xs text-gray-500">Entregados</div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if($store->plan && $store->plan->kiubot_enabled && !empty($insights['alerts'])): ?>
        <div class="mb-6" x-data="{ showAllAlerts: false }">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-5 h-5">
                    KiuBot te sugiere
                </h3>
                <?php if(count($insights['alerts']) > 2): ?>
                <button 
                    @click="showAllAlerts = !showAllAlerts"
                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
                >
                    <span x-text="showAllAlerts ? 'Ver menos' : 'Ver todas (<?php echo e(count($insights['alerts'])); ?>)'"></span>
                </button>
                <?php endif; ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <?php $__currentLoopData = $insights['alerts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div 
                    class="rounded-lg p-4 border transition-all hover:shadow-md
                        <?php if($alert['type'] === 'warning'): ?> bg-amber-50 border-amber-200
                        <?php elseif($alert['type'] === 'danger'): ?> bg-red-50 border-red-200
                        <?php else: ?> bg-blue-50 border-blue-200
                        <?php endif; ?>"
                    x-show="showAllAlerts || <?php echo e($index); ?> < 2"
                    x-transition
                >
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                            <?php if($alert['type'] === 'warning'): ?> bg-amber-100
                            <?php elseif($alert['type'] === 'danger'): ?> bg-red-100
                            <?php else: ?> bg-blue-100
                            <?php endif; ?>">
                            <?php if($alert['icon'] === 'package-x'): ?>
                                <i data-lucide="package-x" class="w-5 h-5 text-amber-600"></i>
                            <?php elseif($alert['icon'] === 'alert-triangle'): ?>
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600"></i>
                            <?php elseif($alert['icon'] === 'clock'): ?>
                                <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                            <?php elseif($alert['icon'] === 'trending-down'): ?>
                                <i data-lucide="trending-down" class="w-5 h-5 text-red-600"></i>
                            <?php elseif($alert['icon'] === 'ticket'): ?>
                                <i data-lucide="ticket" class="w-5 h-5 text-indigo-600"></i>
                            <?php else: ?>
                                <i data-lucide="bell" class="w-5 h-5 text-blue-600"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900"><?php echo e($alert['title']); ?></p>
                            <p class="text-xs text-gray-600 mt-0.5"><?php echo e($alert['message']); ?></p>
                            <?php if(isset($alert['action'])): ?>
                                <?php if(isset($alert['action']['route'])): ?>
                                <a href="<?php echo e(route($alert['action']['route'], ['store' => $store->slug])); ?>" 
                                   class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                    <?php echo e($alert['action']['label']); ?>

                                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                </a>
                                <?php elseif(isset($alert['action']['type']) && $alert['action']['type'] === 'chat'): ?>
                                <button 
                                    onclick="window.sendKiuBotQuestion && window.sendKiuBotQuestion('<?php echo e($alert['action']['prompt']); ?>')"
                                    class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                    <?php echo e($alert['action']['label']); ?>

                                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($store->plan && $store->plan->kiubot_enabled && !empty($insights['performance'])): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-indigo-100">Ventas esta semana</span>
                    <?php if(($insights['performance']['sales']['change_percent'] ?? 0) >= 0): ?>
                        <span class="px-2 py-0.5 bg-green-400/20 text-green-100 text-xs rounded-full flex items-center gap-1">
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            +<?php echo e($insights['performance']['sales']['change_percent'] ?? 0); ?>%
                        </span>
                    <?php else: ?>
                        <span class="px-2 py-0.5 bg-red-400/20 text-red-100 text-xs rounded-full flex items-center gap-1">
                            <i data-lucide="trending-down" class="w-3 h-3"></i>
                            <?php echo e($insights['performance']['sales']['change_percent'] ?? 0); ?>%
                        </span>
                    <?php endif; ?>
                </div>
                <div class="text-3xl font-bold">$<?php echo e(number_format($insights['performance']['sales']['this_week'] ?? 0, 0, ',', '.')); ?></div>
                <p class="text-xs text-indigo-200 mt-1">vs $<?php echo e(number_format($insights['performance']['sales']['last_week'] ?? 0, 0, ',', '.')); ?> semana pasada</p>
            </div>

            
            <?php if(!empty($insights['performance']['top_product'])): ?>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="star" class="w-4 h-4 text-yellow-500"></i>
                    <span class="text-sm font-medium text-gray-600">Producto estrella del mes</span>
                </div>
                <p class="font-bold text-gray-900 truncate"><?php echo e($insights['performance']['top_product']['name']); ?></p>
                <div class="flex items-center gap-4 mt-2">
                    <span class="text-sm text-gray-600">
                        <span class="font-semibold text-indigo-600"><?php echo e($insights['performance']['top_product']['units_sold']); ?></span> vendidos
                    </span>
                    <span class="text-sm text-gray-600">
                        $<?php echo e(number_format($insights['performance']['top_product']['revenue'] ?? 0, 0, ',', '.')); ?>

                    </span>
                </div>
            </div>
            <?php else: ?>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm font-medium text-gray-600">Producto estrella</span>
                </div>
                <p class="text-sm text-gray-500">Aún no tienes ventas este mes. ¡Crea tu primera promoción!</p>
            </div>
            <?php endif; ?>

            
            <?php if(!empty($insights['goals'])): ?>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-600">Meta del mes</span>
                    <span class="text-xs text-gray-500"><?php echo e($insights['goals']['current_month']['days_remaining'] ?? 0); ?> días restantes</span>
                </div>
                <div class="mb-2">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-900"><?php echo e($insights['goals']['goal']['progress_percent'] ?? 0); ?>%</span>
                        <span class="text-gray-500">$<?php echo e(number_format($insights['goals']['goal']['amount'] ?? 0, 0, ',', '.')); ?></span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500"
                             style="width: <?php echo e(min(100, $insights['goals']['goal']['progress_percent'] ?? 0)); ?>%"></div>
                    </div>
                </div>
                <?php if(($insights['goals']['goal']['orders_needed'] ?? 0) > 0): ?>
                <p class="text-xs text-gray-500">Necesitas <?php echo e($insights['goals']['goal']['orders_needed']); ?> pedidos más para alcanzar tu meta</p>
                <?php else: ?>
                <p class="text-xs text-green-600 font-medium">¡Meta alcanzada este mes!</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <?php if($store->plan && $store->plan->kiubot_enabled && !empty($insights['seasonal'])): ?>
        <div class="bg-gradient-to-r from-rose-50 to-orange-50 rounded-xl p-5 mb-6 border border-rose-100">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center">
                    <?php $event = $insights['seasonal'][0]; ?>
                    <?php if($event['icon'] === 'heart'): ?>
                        <i data-lucide="heart" class="w-6 h-6 text-rose-500"></i>
                    <?php elseif($event['icon'] === 'gift'): ?>
                        <i data-lucide="gift" class="w-6 h-6 text-pink-500"></i>
                    <?php elseif($event['icon'] === 'percent'): ?>
                        <i data-lucide="percent" class="w-6 h-6 text-gray-800"></i>
                    <?php else: ?>
                        <i data-lucide="calendar" class="w-6 h-6 text-orange-500"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-gray-900"><?php echo e($event['event']); ?></span>
                        <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-xs rounded-full">
                            <?php echo e($event['days_until']); ?> días
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2"><?php echo e($event['suggestion']); ?></p>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('tenant.admin.coupons.create', ['store' => $store->slug])); ?>" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-800 text-xs font-medium rounded-lg border border-gray-200 transition-colors">
                            <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                            Crear cupón "<?php echo e($event['suggested_coupon']); ?>"
                        </a>
                        <a href="<?php echo e(route('tenant.admin.sliders.create', ['store' => $store->slug])); ?>" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-800 text-xs font-medium rounded-lg border border-gray-200 transition-colors">
                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                            Crear banner
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($store->plan && $store->plan->kiubot_enabled): ?>
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6" x-data="assistantChat()" data-tour="kiubot-section">
            
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">KiuBot</h3>
                        <p class="text-xs text-gray-500">Tu asistente virtual para aprender a usar Linkiu</p>
                    </div>
                </div>
                
                <button 
                    @click="clearChat()"
                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                    title="Limpiar chat"
                >
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>

            
            <div class="h-[450px] overflow-y-auto mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200" id="chat-messages" x-ref="messagesContainer">
                
                <div class="chat chat-start mb-4">
                    <div class="chat-image avatar">
                        <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-10 h-10">
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="chat-bubble bg-white text-gray-800 shadow-sm">
                            <p class="text-sm">
                                ¡Hola! Soy <strong>KiuBot</strong>, tu asistente virtual. Puedo ayudarte a:
                            </p>
                            <ul class="mt-2 text-sm space-y-1 list-disc list-inside">
                                <li>Aprender a usar todas las funcionalidades de Linkiu</li>
                                <li>Darte ideas para aumentar tus ventas</li>
                                <li>Resolver dudas sobre la plataforma</li>
                            </ul>
                            <p class="mt-2 text-sm">
                                <strong>¿En qué puedo ayudarte hoy?</strong>
                            </p>
                        </div>
                        <div class="chat-header text-xs text-gray-500 mb-1">
                            KiuBot
                        </div>
                    </div>
                </div>

                
                <template x-for="(message, index) in messages" :key="index">
                    <div class="chat mb-4" :class="message.role === 'user' ? 'chat-end' : 'chat-start'">
                        <div class="chat-image avatar">
                            <template x-if="message.role === 'user'">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <i data-lucide="user" class="w-5 h-5 text-white"></i>
                                </div>
                            </template>
                            <template x-if="message.role !== 'user'">
                                <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-10 h-10">
                            </template>
                        </div>

                        <div class="flex flex-col gap-2">
                            <div 
                                class="chat-bubble shadow-sm max-w-[85%]"
                                :class="message.role === 'user' ? 'bg-blue-500 text-white' : 'bg-white text-gray-800'"
                            >
                                <p class="text-sm whitespace-pre-wrap" x-html="formatMessage(message.message)"></p>
                                
                                
                                <template x-if="message.actions && message.actions.length > 0">
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <template x-for="(action, actionIndex) in message.actions" :key="actionIndex">
                                            <a 
                                                :href="action.url" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-medium rounded-full transition-colors border border-indigo-200"
                                            >
                                                
                                                <span x-text="action.label"></span>
                                                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <div class="chat-header text-xs mb-1" :class="message.role === 'user' ? 'text-gray-500' : 'text-gray-500'">
                                <span x-text="message.role === 'user' ? 'Tú' : 'KiuBot'"></span>
                                <p class="text-xs text-gray-500">:</p>
                                <time class="text-xs opacity-50" x-text="new Date().toLocaleTimeString('es-CO', {hour: '2-digit', minute: '2-digit'})"></time>
                            </div>
                        </div>
                    </div>
                </template>

                
                <div x-show="loading" class="chat chat-start mb-4" x-cloak>
                    <div class="chat-image avatar">
                        <img src="<?php echo e(asset('images-ui/emoji_kiubot_linkiu.svg')); ?>" alt="KiuBot" class="w-10 h-10">
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="chat-bubble bg-white shadow-sm flex gap-2 items-center w-full">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                        <div class="chat-header text-xs text-gray-500">
                            KiuBot
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                
                <p class="text-xs text-gray-500 mb-2 font-medium">Aprende a usar</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-3">
                    <button 
                        @click="sendQuickQuestion('¿Cómo creo una categoría?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Crear categoría
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo agrego un producto?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Agregar producto
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo creo un cupón?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Crear cupón
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo gestiono mis pedidos?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Gestionar pedidos
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo configuro los envíos?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Configurar envíos
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo personalizo mi tienda?')"
                        class="px-3 py-2 text-xs text-left bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
                        :disabled="loading"
                    >
                        Diseño de tienda
                    </button>
                </div>

                
                <p class="text-xs text-gray-500 mb-2 font-medium">Análisis y sugerencias</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    <button 
                        @click="sendQuickQuestion('¿Cómo van mis ventas?')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        📈 Mis ventas
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo va mi meta del mes?')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        🎯 Mi meta
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo está mi inventario?')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        📦 Mi stock
                    </button>
                    <button 
                        @click="sendQuickQuestion('Dame ideas de promoción')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        💡 Ideas promo
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Cómo puedo mejorar mi catálogo?')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        🛍️ Optimizar catálogo
                    </button>
                    <button 
                        @click="sendQuickQuestion('¿Qué puedo hacer hoy?')"
                        class="px-3 py-2 text-xs text-left bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors border border-indigo-100"
                        :disabled="loading"
                    >
                        ✅ Sugerencias
                    </button>
                </div>
            </div>

            
            <div class="flex gap-2">
                <textarea 
                    x-model="message"
                    @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                    placeholder="Pregúntame algo sobre Linkiu..."
                    class="flex-1 border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                    rows="2"
                    :disabled="loading"
                ></textarea>
                <button 
                    @click="sendMessage()"
                    :disabled="!message.trim() || loading"
                    class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span class="hidden sm:inline">Enviar</span>
                </button>
            </div>
        </div>

        <?php $__env->startPush('scripts'); ?>
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('assistantChat', () => ({
                messages: [],
                message: '',
                loading: false,
                sessionId: null,

                init() {
                    // Generar session_id único
                    this.sessionId = this.generateSessionId();
                    
                    // Exponer función globalmente para las alertas proactivas
                    const self = this;
                    window.sendKiuBotQuestion = function(question) {
                        self.sendQuickQuestion(question);
                        // Scroll hacia el chat
                        document.getElementById('chat-messages')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    };
                    
                    // Inicializar iconos
                    this.$nextTick(() => {
                        if (window.createIcons) {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                },

                generateSessionId() {
                    return 'assistant_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                },

                async sendMessage() {
                    if (!this.message.trim() || this.loading) return;

                    const userMessage = this.message.trim();
                    this.message = '';
                    
                    // Agregar mensaje del usuario
                    this.messages.push({
                        role: 'user',
                        message: userMessage,
                        actions: []
                    });

                    this.loading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch('<?php echo e(route("tenant.admin.dashboard.chat", ["store" => $store->slug])); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                message: userMessage,
                                session_id: this.sessionId
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Guardar session_id si viene en la respuesta
                            if (data.session_id) {
                                this.sessionId = data.session_id;
                            }

                            // Agregar respuesta del asistente
                            this.messages.push({
                                role: 'assistant',
                                message: data.message,
                                actions: data.actions || []
                            });
                        } else {
                            this.messages.push({
                                role: 'assistant',
                                message: data.message || 'Lo siento, ocurrió un error. Por favor intenta nuevamente.',
                                actions: []
                            });
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.messages.push({
                            role: 'assistant',
                            message: 'Lo siento, ocurrió un error de conexión. Por favor verifica tu internet e intenta nuevamente.',
                            actions: []
                        });
                    } finally {
                        this.loading = false;
                        this.scrollToBottom();
                        
                        // Reinicializar iconos
                        this.$nextTick(() => {
                            if (window.createIcons) {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        });
                    }
                },

                sendQuickQuestion(question) {
                    this.message = question;
                    this.sendMessage();
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.messagesContainer;
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                },

                formatMessage(text) {
                    // Convertir saltos de línea a <br>
                    // Preservar la numeración (1., 2., etc.) con mejor formato
                    let formatted = text.replace(/\n/g, '<br>');
                    
                    // Mejorar el formato de pasos numerados para que se vean mejor
                    formatted = formatted.replace(/(\d+)\.\s+/g, '<strong>$1.</strong> ');
                    
                    return formatted;
                },

                clearChat() {
                    this.messages = [];
                    this.sessionId = this.generateSessionId();
                    this.scrollToBottom();
                }
            }));
        });
        </script>
        <?php $__env->stopPush(); ?>
        <?php endif; ?>

        
        <div class="bg-white rounded-lg shadow-sm p-5" data-tour="recent-orders">
            <?php if (isset($component)) { $__componentOriginal239df7b6d227984ebba2770b03cc9a0e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal239df7b6d227984ebba2770b03cc9a0e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Dashboard.OrdersTableWidget','data' => ['title' => 'Pedidos Recientes','orders' => $allOrders,'viewAllUrl' => route('tenant.admin.orders.index', ['store' => $store->slug]),'maxItems' => 20,'perPage' => 10,'storeSlug' => $store->slug]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('orders-table-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pedidos Recientes','orders' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allOrders),'viewAllUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('tenant.admin.orders.index', ['store' => $store->slug])),'maxItems' => 20,'perPage' => 10,'storeSlug' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->slug)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal239df7b6d227984ebba2770b03cc9a0e)): ?>
<?php $attributes = $__attributesOriginal239df7b6d227984ebba2770b03cc9a0e; ?>
<?php unset($__attributesOriginal239df7b6d227984ebba2770b03cc9a0e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal239df7b6d227984ebba2770b03cc9a0e)): ?>
<?php $component = $__componentOriginal239df7b6d227984ebba2770b03cc9a0e; ?>
<?php unset($__componentOriginal239df7b6d227984ebba2770b03cc9a0e); ?>
<?php endif; ?>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Chat bubbles styles */
        .chat {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .chat-start {
            flex-direction: row;
        }
        .chat-end {
            flex-direction: row-reverse justify-end;
            justify-content: flex-end;
            align-items: flex-center;
            padding-left: 0;
        }
        .chat-image {
            flex-shrink: 0;
        }
        .chat-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
            font-size: 0.75rem;
        }
        .chat-bubble {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            max-width: 85%;
            word-wrap: break-word;
        }
        .chat-start .chat-bubble {
            border-bottom-left-radius: 0.25rem;
        }
        .chat-end .chat-bubble {
            border-bottom-left-radius: 0.25rem;
        }
    </style>
    <?php $__env->stopPush(); ?>

    
    <?php
        // Asegurar que businessCategory esté cargada
        if (!$store->relationLoaded('businessCategory')) {
            $store->load('businessCategory');
        }
        
        $tourService = app(\App\Services\TourService::class);
        $shouldShowTour = $tourService->shouldShowTour($store, 'dashboard_bienvenida');
        // TEMPORAL: Permitir reiniciar el tour con ?reset_tour=1 en la URL
        $resetTour = request()->get('reset_tour') === '1';
        
        // DEBUG: Log temporal para verificar
        \Log::info('Tour Debug', [
            'store_id' => $store->id,
            'business_category_id' => $store->business_category_id,
            'vertical' => $store->businessCategory?->vertical ?? 'null',
            'shouldShowTour' => $shouldShowTour,
            'orders_count' => $store->orders()->count(),
        ]);
    ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // TEMPORAL: Reiniciar tour si hay parámetro en URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('reset_tour') === '1') {
                if (window.LinkiuTours && window.LinkiuTours.reset) {
                    window.LinkiuTours.reset('dashboard_bienvenida');
                    console.log('✅ Tour de bienvenida reiniciado');
                }
            }

            // Verificar si debe mostrarse el tour
            const shouldShow = <?php echo e($shouldShowTour ? 'true' : 'false'); ?>;
            const resetTour = <?php echo e($resetTour ? 'true' : 'false'); ?>;
            
            if (shouldShow || resetTour) {
                // Esperar a que todo esté cargado (Alpine, iconos, etc.)
                setTimeout(function() {
                    if (window.LinkiuTours && window.LinkiuTours.start) {
                        // Si es reset, forzar inicio
                        window.LinkiuTours.start('dashboard_bienvenida', resetTour);
                    } else if (window.startTour) {
                        window.startTour('dashboard_bienvenida', resetTour);
                    }
                }, 1000); // Esperar 1 segundo para que todo esté listo
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $attributes = $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $component = $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/dashboard.blade.php ENDPATH**/ ?>