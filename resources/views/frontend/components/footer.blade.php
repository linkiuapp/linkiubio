<!-- Footer -->
<footer class="bg-brandWhite-100 mt-12 pb-20">
    <div class="max-w-[375px] md:max-w-[400px] mx-auto px-6 py-8">
        <!-- Links principales -->
        <div class="flex flex-col gap-4 mb-6">
            <a href="{{ route('tenant.legal-policies', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-brandWhite-50 hover:bg-brandPrimary-50 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-6 h-6 sm:w-24px sm:h-24px"></i>
                    <span class="body-lg-medium text-brandNeutral-400">Políticas Legales</span>
                </div>
                <i data-lucide="arrow-up-right" class="w-6 h-6 sm:w-24px sm:h-24px text-brandNeutral-400"></i>
            </a>

            <a href="{{ route('tenant.about-us', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-brandWhite-50 hover:bg-brandPrimary-50 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="user-star" class="w-6 h-6 sm:w-24px sm:h-24px"></i>
                    <span class="body-lg-medium text-brandNeutral-400">Acerca de Nosotros</span>
                </div>
                <i data-lucide="arrow-up-right" class="w-6 h-6 sm:w-24px sm:h-24px text-brandNeutral-400"></i>
            </a>

            <a href="{{ route('tenant.report-problem', $store->slug) }}" 
               class="flex items-center justify-between py-3 px-4 bg-brandError-50 hover:bg-brandError-100 rounded-lg transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="life-buoy" class="w-6 h-6 sm:w-24px sm:h-24px text-brandError-400"></i>
                    <span class="body-lg-medium text-brandError-400 hover:text-brandError-50">¿Problemas con la tienda?</span>
                </div>
                <i data-lucide="arrow-up-right" class="w-6 h-6 sm:w-24px sm:h-24px text-brandError-400"></i>
            </a>
        </div>

        <!-- Divider -->
        <div class="border-t border-brandNeutral-50 my-4"></div>

        <!-- Info adicional -->
        <div class="text-center space-y-2">
            <p class="body-small text-brandNeutral-400 capitalize">
                {{ $store->name }}
            </p>
            <p class="caption text-brandNeutral-400">
                © {{ date('Y') }} Todos los derechos reservados<br> Desarrollado por <span class="body-lg-bold text-brandPrimary-400"><a href="https://linkiu.bio" target="_blank">Linkiu S.A.S</a></span>
            </p>
        </div>
    </div>
</footer>

