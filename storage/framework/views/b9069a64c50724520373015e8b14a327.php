

<?php $__env->startSection('title', 'Plan y Facturación'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="billingManager()">
    
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Plan y Facturación</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tu suscripción y facturación</p>
        </div>
        
        <?php if($isInTrial && $trialDaysRemaining > 0): ?>
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg animate-pulse">
            <div class="flex items-center gap-3">
                <i data-lucide="gift" class="w-6 h-6"></i>
                <div>
                    <p class="font-bold text-lg">Período de Prueba</p>
                    <p class="text-sm text-green-100"><?php echo e($trialDaysRemaining); ?> <?php echo e($trialDaysRemaining === 1 ? 'día restante' : 'días restantes'); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-2 px-4" aria-label="Tabs">
                <button @click="activeTab = 'plan'" 
                        :class="activeTab === 'plan' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    Mi Plan
                </button>
                <button @click="activeTab = 'usage'" 
                        :class="activeTab === 'usage' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    Uso y Límites
                </button>
                <button @click="activeTab = 'invoices'" 
                        :class="activeTab === 'invoices' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    Facturas
                </button>
                <button @click="activeTab = 'change'" 
                        :class="activeTab === 'change' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Cambiar Plan
                </button>
            </nav>
        </div>

        
        <div class="p-6">
            
            <div x-show="activeTab === 'plan'" x-transition class="space-y-6">
                
                
                <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <i data-lucide="crown" class="w-8 h-8 text-blue-600"></i>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Plan <?php echo e($subscription->plan->name); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo e($subscription->billing_cycle_label); ?></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Precio</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        $<?php echo e(number_format($subscription->next_billing_amount, 0, ',', '.')); ?><span class="text-sm font-normal text-gray-600">/<?php echo e($subscription->billing_cycle_label); ?></span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Próximo Pago</p>
                                    <p class="text-base font-semibold text-gray-900">
                                        <?php echo e($subscription->next_billing_date->locale('es')->isoFormat('D MMM YYYY')); ?>

                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Estado</p>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                        <?php if($subscription->is_active): ?> bg-green-100 text-green-800
                                        <?php elseif($subscription->is_cancelled): ?> bg-yellow-100 text-yellow-800
                                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($subscription->is_active): ?>
                                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                                            Activa
                                        <?php elseif($subscription->is_cancelled): ?>
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            Cancelada
                                        <?php else: ?>
                                            <i data-lucide="x-circle" class="w-3 h-3"></i>
                                            Suspendida
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>

                            
                            <?php if($isInTrial): ?>
                            <div class="mt-4 p-4 bg-white bg-opacity-80 backdrop-blur rounded-lg border-2 border-green-400">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="sparkles" class="w-5 h-5 text-green-600"></i>
                                    <div class="flex-1">
                                        <p class="font-bold text-green-900">¡Estás en período de prueba!</p>
                                        <p class="text-sm text-green-700">
                                            Te quedan <strong><?php echo e($trialDaysRemaining); ?> <?php echo e($trialDaysRemaining === 1 ? 'día' : 'días'); ?></strong> gratis. 
                                            Primer cobro: <?php echo e($subscription->current_period_start->locale('es')->isoFormat('D MMM YYYY')); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            
                            <?php if($subscription->pending_charges > 0): ?>
                            <div class="mt-4 p-4 bg-white bg-opacity-80 backdrop-blur rounded-lg border-2 border-blue-400">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                                    <div class="flex-1">
                                        <p class="font-bold text-blue-900">Cargos Pendientes</p>
                                        <p class="text-sm text-blue-700 mb-2">
                                            Se agregarán <strong>$<?php echo e(number_format($subscription->pending_charges, 0, ',', '.')); ?></strong> a tu próxima factura
                                        </p>
                                        <?php if($subscription->pending_charges_details && count($subscription->pending_charges_details) > 0): ?>
                                        <div class="space-y-1">
                                            <?php $__currentLoopData = $subscription->pending_charges_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p class="text-xs text-blue-600">
                                                • <?php echo e($detail['description'] ?? 'Ajuste'); ?>: $<?php echo e(number_format($detail['amount'] ?? 0, 0, ',', '.')); ?>

                                            </p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="flex flex-col gap-2 ml-6">
                            <?php if($subscription->is_active && !$subscription->is_cancelled): ?>
                            <button @click="showCancelModal = true"
                                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                Cancelar Suscripción
                            </button>
                            <?php endif; ?>

                            <?php if($subscription->is_cancelled): ?>
                            <button @click="showReactivateModal = true"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                Reactivar
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <?php if($subscription->plan->features_list && count($subscription->plan->features_list) > 0): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
                        Incluye en tu Plan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <?php $__currentLoopData = $subscription->plan->features_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0"></i>
                            <span><?php echo e($feature); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <div x-show="activeTab === 'usage'" x-transition class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i data-lucide="activity" class="w-5 h-5 text-blue-600"></i>
                        Uso General: <?php echo e(number_format($planUsage['overall_percentage'], 1)); ?>%
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        $resourceLabels = [
                            'products' => 'Productos',
                            'categories' => 'Categorías',
                            'variables' => 'Variables',
                            'product_images' => 'Imágenes por Producto',
                            'sliders' => 'Sliders',
                            'active_coupons' => 'Cupones Activos',
                            'locations' => 'Ubicaciones',
                            'delivery_zones' => 'Zonas de Envío',
                            'payment_methods' => 'Métodos de Pago',
                            'bank_accounts' => 'Cuentas Bancarias',
                            'order_history_months' => 'Meses de Historial',
                            'admins' => 'Administradores',
                            'tickets_this_month' => 'Tickets este Mes',
                        ];
                        ?>
                        
                        <?php $__currentLoopData = $resourceLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($planUsage[$key])): ?>
                            <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700"><?php echo e($label); ?></span>
                                    <span class="text-xs font-semibold px-2 py-1 rounded
                                        <?php echo e($planUsage[$key]['percentage'] >= 90 ? 'bg-red-100 text-red-800' : 
                                           ($planUsage[$key]['percentage'] >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')); ?>">
                                        <?php echo e(number_format($planUsage[$key]['percentage'], 0)); ?>%
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 mb-2">
                                    <?php echo e($planUsage[$key]['current']); ?> de <?php echo e($planUsage[$key]['limit'] === -1 ? '∞' : $planUsage[$key]['limit']); ?>

                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all
                                        <?php echo e($planUsage[$key]['percentage'] >= 90 ? 'bg-red-600' : 
                                           ($planUsage[$key]['percentage'] >= 70 ? 'bg-yellow-500' : 'bg-green-500')); ?>"
                                         style="width: <?php echo e(min(100, $planUsage[$key]['percentage'])); ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
            <div x-show="activeTab === 'invoices'" x-transition class="space-y-6">
                
                
                <?php
                $paymentSetting = \App\Models\RegistrationPaymentSetting::getActive();
                ?>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                        Datos Bancarios para Pagos
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 text-xs mb-1">Banco:</p>
                            <p class="font-semibold text-gray-900"><?php echo e($paymentSetting->bank_name); ?></p>
                            <br>
                            <p class="text-gray-600 text-xs mb-1">Tipo de cuenta:</p>
                            <p class="font-semibold text-gray-900"><?php echo e($paymentSetting->account_type); ?></p>
                            <br>
                            <p class="text-gray-600 text-xs mb-1">Número de cuenta:</p>
                            <p class="font-semibold text-gray-900"><?php echo e($paymentSetting->account_number); ?></p>
                            <br>
                            <p class="text-gray-600 text-xs mb-1">Titular:</p>
                            <p class="font-semibold text-gray-900"><?php echo e($paymentSetting->account_holder); ?></p>
                            <br>
                            <p class="text-gray-600 text-xs mb-1">NIT:</p>
                            <p class="font-semibold text-gray-900"><?php echo e($paymentSetting->nit); ?></p>
                        </div>
                        <?php if($paymentSetting->qr_code_image): ?>
                        <div class="flex items-center justify-center">
                            <img src="<?php echo e($paymentSetting->qr_code_url); ?>" 
                                 alt="QR de Pago" 
                                 class="w-56 h-56 object-contain border-2 border-blue-300 rounded-lg bg-white p-2">
                        </div>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-blue-700 mt-3 flex items-center gap-2">
                        <i data-lucide="info" class="w-3 h-3"></i>
                        Transfiere a esta cuenta y envía el comprobante a: <strong class="ml-1">facturas@linkiu.email</strong>
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-blue-600"></i>
                            Historial de Facturas
                        </h3>
                    </div>

                    <?php if($invoices->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Factura</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                                            <span class="font-semibold text-gray-900"><?php echo e($invoice->invoice_number); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php echo e($invoice->issue_date->format('d M Y')); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900">$<?php echo e(number_format($invoice->amount, 0, ',', '.')); ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                            <?php if($invoice->status === 'paid'): ?> bg-green-100 text-green-800
                                            <?php elseif($invoice->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                            <?php elseif($invoice->status === 'overdue'): ?> bg-red-100 text-red-800
                                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                            <?php if($invoice->status === 'paid'): ?>
                                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                                Pagada
                                            <?php elseif($invoice->status === 'pending'): ?>
                                                <i data-lucide="clock" class="w-3 h-3"></i>
                                                Pendiente
                                            <?php elseif($invoice->status === 'overdue'): ?>
                                                <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                                Vencida
                                            <?php else: ?>
                                                <?php echo e(ucfirst($invoice->status)); ?>

                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="<?php echo e(route('tenant.admin.invoices.show', ['store' => $store->slug, 'invoice' => $invoice->id])); ?>"
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="Ver factura">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <a href="<?php echo e(route('tenant.admin.invoices.download', ['store' => $store->slug, 'invoice' => $invoice->id])); ?>"
                                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                               title="Descargar PDF">
                                                <i data-lucide="download" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="px-6 py-12 text-center">
                        <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-gray-600">No hay facturas generadas aún</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div x-show="activeTab === 'change'" x-transition class="space-y-6">
                
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-sm text-blue-900">
                            <p class="font-semibold mb-1">Importante:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li><strong>Mejorar plan:</strong> Se aplica de inmediato y se ajusta el cobro por los días restantes</li>
                                <li><strong>Bajar plan:</strong> Se aplica en el próximo período de facturación</li>
                                <li><strong>Cambiar período:</strong> Se aplica en el próximo cobro (con descuento del nuevo período)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Selecciona el Período de Facturación</h3>
                    <div class="grid grid-cols-4 gap-3">
                        <?php
                        $periods = [
                            'monthly' => ['label' => 'Mensual', 'discount' => 0],
                            'quarterly' => ['label' => 'Trimestral', 'discount' => 5],
                            'semester' => ['label' => 'Semestral', 'discount' => 10],
                            'annual' => ['label' => 'Anual', 'discount' => 15],
                        ];
                        ?>
                        
                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodKey => $periodData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="billing_period" 
                                   value="<?php echo e($periodKey); ?>"
                                   x-model="selectedPeriod"
                                   class="peer sr-only">
                            <div class="p-4 border-2 rounded-xl transition-all text-center
                                        peer-checked:border-blue-600 peer-checked:bg-blue-50
                                        hover:border-gray-400"
                                 :class="selectedPeriod === '<?php echo e($periodKey); ?>' ? 'border-blue-600 bg-blue-50' : 'border-gray-200'">
                                <p class="font-semibold text-gray-900 mb-1"><?php echo e($periodData['label']); ?></p>
                                <?php if($periodData['discount'] > 0): ?>
                                <span class="inline-block px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">
                                    AHORRA <?php echo e($periodData['discount']); ?>%
                                </span>
                                <?php endif; ?>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if($pendingRequests->count() > 0): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-yellow-900 mb-3 flex items-center gap-2">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                        Solicitud Pendiente
                    </h3>
                    <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg p-4 border border-yellow-300">
                        <p class="text-sm text-gray-700">
                            Cambio de <strong><?php echo e($request->currentPlan->name); ?></strong> a <strong><?php echo e($request->requestedPlan->name); ?></strong>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Solicitado el <?php echo e($request->requested_at->format('d M Y')); ?>

                        </p>
                        <?php if($request->reason): ?>
                        <p class="text-xs text-gray-600 mt-2 italic">"<?php echo e($request->reason); ?>"</p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $availablePlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $isCurrent = $plan->id === $subscription->plan_id;
                    ?>
                    
                    <?php
                    $prices = [
                        'monthly' => $plan->getPriceForPeriod('monthly'),
                        'quarterly' => $plan->getPriceForPeriod('quarterly'),
                        'semester' => $plan->getPriceForPeriod('semester'),
                        'annual' => $plan->getPriceForPeriod('annual'),
                    ];
                    ?>
                    
                    <div class="relative bg-white rounded-2xl border-2 <?php echo e($isCurrent ? 'border-blue-500 shadow-xl' : 'border-gray-200'); ?> overflow-hidden transition-all hover:shadow-lg">
                        
                        <?php if($isCurrent): ?>
                        <div class="absolute top-4 right-4 z-10">
                            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-lg">
                                TU PLAN
                            </span>
                        </div>
                        <?php endif; ?>

                        
                        <div class="p-6 <?php echo e($isCurrent ? 'bg-gradient-to-br from-blue-50 to-indigo-50' : 'bg-gray-50'); ?>">
                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($plan->name); ?></h3>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-bold text-gray-900">
                                    <span x-show="selectedPeriod === 'monthly'" x-transition>$<?php echo e(number_format($prices['monthly'], 0, ',', '.')); ?></span>
                                    <span x-show="selectedPeriod === 'quarterly'" x-transition style="display: none;">$<?php echo e(number_format($prices['quarterly'], 0, ',', '.')); ?></span>
                                    <span x-show="selectedPeriod === 'semester'" x-transition style="display: none;">$<?php echo e(number_format($prices['semester'], 0, ',', '.')); ?></span>
                                    <span x-show="selectedPeriod === 'annual'" x-transition style="display: none;">$<?php echo e(number_format($prices['annual'], 0, ',', '.')); ?></span>
                                </span>
                                <span class="text-gray-600">
                                    /<span x-text="selectedPeriod === 'monthly' ? 'mes' : (selectedPeriod === 'quarterly' ? 'trim' : (selectedPeriod === 'semester' ? 'sem' : 'año'))"></span>
                                </span>
                            </div>
                            
                            <?php if($plan->trial_days > 0): ?>
                            <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-green-500 text-white rounded-full text-xs font-bold">
                                <i data-lucide="gift" class="w-3 h-3"></i>
                                <?php echo e($plan->trial_days); ?> días gratis
                            </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="p-6">
                            <?php if($plan->features_list && count($plan->features_list) > 0): ?>
                            <ul class="space-y-2 mb-6">
                                <?php $__currentLoopData = array_slice($plan->features_list, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-start gap-2 text-xs">
                                    <i data-lucide="check" class="w-3 h-3 text-green-600 flex-shrink-0 mt-0.5"></i>
                                    <span class="text-gray-700"><?php echo e($feature); ?></span>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>

                            
                            <?php if(!$isCurrent): ?>
                            <?php
                            $isUpgrade = $prices['monthly'] > $subscription->plan->monthly_price;
                            ?>
                            <button @click="requestPlanChange(<?php echo e($plan->id); ?>, '<?php echo e($plan->name); ?>', <?php echo e(json_encode($prices)); ?>)"
                                    class="w-full px-6 py-3 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl <?php echo e($isUpgrade ? 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' : 'bg-gray-600 hover:bg-gray-700'); ?>">
                                <?php echo e($isUpgrade ? 'Mejorar a ' . $plan->name : 'Cambiar a ' . $plan->name); ?>

                            </button>
                            <?php else: ?>
                            <div class="w-full px-6 py-3 bg-gray-100 text-gray-500 rounded-xl font-bold text-center cursor-not-allowed">
                                Plan Actual
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div x-show="showPlanChangeModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showPlanChangeModal = false"
         style="display: none;"
         x-cloak></div>

    <div x-show="showPlanChangeModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
         style="display: none;"
         x-cloak>
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div @click.stop
                 class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Solicitar Cambio de Plan</h3>
                    <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200"
                            @click="showPlanChangeModal = false">
                        <i data-lucide="x" class="shrink-0 size-4"></i>
                    </button>
                </div>

                <form @submit.prevent="submitPlanChange" class="p-4">
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-gray-700 mb-2">
                                Cambio solicitado a: <strong x-text="selectedPlanName"></strong>
                            </p>
                            <p class="text-xs text-gray-600 mb-1">
                                Período: <strong x-text="selectedBillingPeriod === 'monthly' ? 'Mensual' : (selectedBillingPeriod === 'quarterly' ? 'Trimestral' : (selectedBillingPeriod === 'semester' ? 'Semestral' : 'Anual'))"></strong>
                            </p>
                            <p class="text-sm font-bold text-blue-900">
                                Precio: $<span x-text="Math.round(selectedPlanPrice).toLocaleString('es-CO')"></span>/<span x-text="selectedBillingPeriod === 'monthly' ? 'mes' : (selectedBillingPeriod === 'quarterly' ? 'trim' : (selectedBillingPeriod === 'semester' ? 'sem' : 'año'))"></span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Razón del cambio (opcional)
                            </label>
                            <textarea x-model="changeReason"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none text-sm"
                                      placeholder="¿Por qué quieres cambiar de plan?"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirma tu contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password"
                                   x-model="password"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                   placeholder="Tu contraseña">
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 mt-4 border-t border-gray-200">
                        <button type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50"
                                @click="showPlanChangeModal = false">
                            Cancelar
                        </button>
                        <button type="submit"
                                :disabled="!password"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Solicitar Cambio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function billingManager() {
    return {
        activeTab: 'plan',
        selectedPeriod: 'monthly',
        showCancelModal: false,
        showReactivateModal: false,
        showPlanChangeModal: false,
        selectedPlanId: null,
        selectedPlanName: '',
        selectedPlanPrice: 0,
        selectedBillingPeriod: 'monthly',
        changeReason: '',
        password: '',
        

        requestPlanChange(planId, planName, pricesObj) {
            this.selectedPlanId = planId;
            this.selectedPlanName = planName;
            // Obtener precio según el período seleccionado
            this.selectedPlanPrice = pricesObj[this.selectedPeriod] || pricesObj['monthly'];
            this.selectedBillingPeriod = this.selectedPeriod;
            this.changeReason = '';
            this.password = '';
            this.showPlanChangeModal = true;
            
            this.$nextTick(() => {
                if (window.createIcons && window.lucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            });
        },

        async submitPlanChange() {
            if (!this.password) {
                if (window.toast) {
                    window.toast.error('Error', 'Debes ingresar tu contraseña', 3000, 'bottom-center');
                }
                return;
            }

            try {
                const response = await fetch('<?php echo e(route('tenant.admin.billing.request-plan-change', $store->slug)); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        plan_id: this.selectedPlanId,
                        billing_period: this.selectedBillingPeriod,
                        reason: this.changeReason,
                        password: this.password
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showPlanChangeModal = false;
                    
                    if (window.toast) {
                        window.toast.success('Solicitud enviada', data.message, 5000, 'bottom-center');
                    }
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    if (window.toast) {
                        window.toast.error('Error', data.message, 5000, 'bottom-center');
                    }
                }
            } catch (error) {
                if (window.toast) {
                    window.toast.error('Error', 'No se pudo procesar la solicitud', 5000, 'bottom-center');
                }
            }
        }
    }
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});

// Re-inicializar cuando Alpine cambie pestañas
document.addEventListener('alpine:initialized', () => {
    setTimeout(() => {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    }, 100);
});
</script>

<style>
[x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('shared::layouts.tenant-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/billing/index.blade.php ENDPATH**/ ?>