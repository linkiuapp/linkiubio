<!-- Footer -->
<footer class="bg-dark-900 text-gray-400 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-8 pb-12">
            <!-- Logo y descripción -->
            <div class="col-span-2">
                <a href="/" class="inline-block mb-6">
                    <img src="/images-ui/logo_linkiu_landing_white.svg" alt="Linkiu" class="h-8">
                </a>
                <p class="text-gray-400 mb-6 max-w-sm font-inter text-sm">
                    La plataforma más simple para crear tu tienda online. 
                    Ideal para restaurantes, tiendas de ropa, accesorios y más.
                </p>
                <div class="flex gap-3">
                    <a href="https://instagram.com/linkiu_bio" target="_blank" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="https://www.facebook.com/linkiu.bio" target="_blank" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="https://www.tiktok.com/@linkiu_bio" target="_blank" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="music" class="w-5 h-5"></i>
                    </a>
                    <a href="https://www.youtube.com/@linkiu_bio" target="_blank" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="youtube" class="w-5 h-5"></i>
                    </a>
                    <a href="https://wa.me/573104594344" target="_blank" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </a>
                    <a href="mailto:soporte@linkiu.bio" class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors border border-white/10">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
            
            <!-- Productos -->
            <div>
                <h4 class="text-white font-satoshi font-bold mb-4">Productos</h4>
                <ul class="space-y-3 font-inter text-sm">
                    <li><a href="{{ route('ecommerce.index') }}" class="hover:text-white transition-colors">Ecommerce</a></li>
                    <li><a href="{{ route('restaurant.index') }}" class="hover:text-white transition-colors">Restaurantes</a></li>
                    <li><a href="#" class="hover:text-white transition-colors text-gray-500">Dropshipping</a></li>
                    <li><a href="#" class="hover:text-white transition-colors text-gray-500">Servicios</a></li>
                    <li><a href="#" class="hover:text-white transition-colors text-gray-500">Hotelería</a></li>
                </ul>
            </div>
            
            <!-- Ayuda -->
            <div>
                <h4 class="text-white font-satoshi font-bold mb-4">Ayuda</h4>
                    <ul class="space-y-3 font-inter text-sm">
                        <li><a href="{{ route('faq.index') }}" class="hover:text-white transition-colors">Preguntas Frecuentes</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tutoriales</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-white transition-colors">Contacto</a></li>
                    </ul>
            </div>
            
            <!-- Empresa -->
            <div>
                <h4 class="text-white font-satoshi font-bold mb-4">Empresa</h4>
                <ul class="space-y-3 font-inter text-sm">
                    <li><a href="{{ route('about.index') }}" class="hover:text-white transition-colors">Nosotros</a></li>
                    <li><a href="{{ route('team.index') }}" class="hover:text-white transition-colors">Equipo</a></li>
                    <li><a href="{{ route('partners.index') }}" class="hover:text-white transition-colors">Partners</a></li>
                    <li><a href="{{ route('plans.index') }}" class="hover:text-white transition-colors">Ver planes</a></li>
                </ul>
            </div>
            
            <!-- Recursos -->
            <div>
                <h4 class="text-white font-satoshi font-bold mb-4">Recursos</h4>
                <ul class="space-y-3 font-inter text-sm">
                    <li><a href="{{ route('store.login') }}" class="hover:text-white transition-colors">Cómo entrar a mi tienda</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{ route('release-notes.index') }}" class="hover:text-white transition-colors">Nuevas Actualizaciones</a></li>
                </ul>
            </div>
            
            <!-- Legal -->
            <div>
                <h4 class="text-white font-satoshi font-bold mb-4">Legal</h4>
                <ul class="space-y-3 font-inter text-sm">
                    <li><a href="{{ route('legal.terms') }}" class="hover:text-white transition-colors">Términos y condiciones</a></li>
                    <li><a href="{{ route('legal.privacy') }}" class="hover:text-white transition-colors">Política de privacidad</a></li>
                    <li><a href="{{ route('legal.cookies') }}" class="hover:text-white transition-colors">Política de cookies</a></li>
                    <li><a href="{{ route('legal.refunds') }}" class="hover:text-white transition-colors">Política de reembolsos</a></li>
                    <li><a href="{{ route('legal.notice') }}" class="hover:text-white transition-colors">Aviso legal</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm font-inter">&copy; {{ date('Y') }} Linkiu. Todos los derechos reservados.</p>
            <p class="text-sm font-inter">Hecho con ❤️ en Colombia 🇨🇴</p>
        </div>
    </div>
</footer>
