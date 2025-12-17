<!-- Footer -->
<footer class="pb-20 max-w-[348px] md:max-w-[420px] mx-auto">
    <div class="py-8">
        <!-- Sección superior: Features -->
        <div class="flex justify-around items-center mb-8">
            <!-- +5.0 Puntuación -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 mb-2 bg-amber-200 rounded-lg text-amber-700 flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-900 text-center leading-tight">+5.0</span>
                <span class="text-xs md:text-sm font-normal text-slate-900 text-center leading-tight">Puntuación</span>
            </div>

            <!-- Envios Seguros -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 mb-2 bg-blue-200 rounded-lg text-blue-900 flex items-center justify-center">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-900 text-center leading-tight">Envios</span>
                <span class="text-xs md:text-sm font-normal text-slate-900 text-center leading-tight">Seguros</span>
            </div>

            <!-- Compra Segura -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 mb-2 bg-green-200 rounded-lg text-green-900 flex items-center justify-center">
                    <i data-lucide="lock" class="w-6 h-6"></i>
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-900 text-center leading-tight">Compra</span>
                <span class="text-xs md:text-sm font-normal text-slate-900 text-center leading-tight">Segura</span>
            </div>

            <!-- 100% Garantía de devolución -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 mb-2 bg-red-200 rounded-lg text-red-900 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <span class="text-xs md:text-sm font-bold text-slate-900 text-center leading-tight">100%</span>
                <span class="text-xs md:text-sm font-normal text-slate-900 text-center leading-tight">Garantizado</span>
            </div>
        </div>

        <!-- Sección media: Links/Navegación -->
        <div class="bg-slate-900 rounded-2xl md:px-14 px-8 py-8 space-y-3">
            <!-- Políticas legales -->
            <a href="<?php echo e(route('tenant.legal-policies', $store->slug)); ?>" 
               class="flex items-center justify-between py-2 px-4 bg-white hover:bg-slate-50 rounded-lg transition-colors group">
                <span class="text-sm font-medium text-slate-900">Políticas legales</span>
                <i data-lucide="shield-check" class="w-5 h-5 text-slate-900"></i>
            </a>

            <!-- Acerca de nosotros -->
            <a href="<?php echo e(route('tenant.about-us', $store->slug)); ?>" 
               class="flex items-center justify-between py-3 px-4 bg-white hover:bg-slate-50 rounded-lg transition-colors group">
                <span class="text-sm font-medium text-slate-900">Acerca de nosotros</span>
                <i data-lucide="user" class="w-5 h-5 text-slate-900"></i>
            </a>

            <!-- Quiero mi tienda Linkiu -->
            <a href="<?php echo e(route('register.step1')); ?>" 
               class="flex items-center justify-between py-3 px-4 bg-white hover:bg-slate-50 rounded-lg transition-colors group">
                <span class="text-sm font-medium text-slate-900">Quiero mi tienda Linkiu</span>
                <i data-lucide="heart" class="w-5 h-5 text-slate-900"></i>
            </a>

            <!-- ¿Problemas con la tienda? -->
            <a href="<?php echo e(route('tenant.report-problem', $store->slug)); ?>" 
               class="flex items-center justify-between py-3 px-4 bg-red-600 hover:bg-red-700 rounded-lg transition-colors group">
                <span class="text-sm font-medium text-white">¿Problemas con la tienda?</span>
                <i data-lucide="life-buoy" class="w-5 h-5 text-white"></i>
            </a>
            <!-- Sección inferior: Copyright -->
            <div class="text-center space-y-2">
                <p class="text-sm font-semibold text-white capitalize">
                    <?php echo e($store->name); ?>

                </p>
                <p class="text-sm text-white">
                    © <?php echo e(date('Y')); ?> Todos los derechos reservados
                </p>
                <p class="text-sm text-white">
                    Desarrollado por <a href="https://linkiu.bio" target="_blank" class="text-white font-semibold underline hover:text-blue-400 transition-colors">Linkiu S.A.S</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\Liniu_Final\resources\views/frontend/components/footer.blade.php ENDPATH**/ ?>