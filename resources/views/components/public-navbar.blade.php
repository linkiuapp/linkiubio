<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-slate-950 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="/images-ui/logo_linkiu_landing_white.svg" alt="Linkiu" class="h-8">
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-1">
                <!-- Inicio -->
                <a href="/" class="px-4 py-2 {{ request()->is('/') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white' }} font-medium transition-colors rounded-lg hover:bg-gray-800">
                    Inicio
                </a>
                
                <!-- Productos MEGAMENU -->
                <div class="megamenu-trigger relative">
                    <button class="px-4 py-2 {{ request()->routeIs('ecommerce.index') || request()->routeIs('restaurant.index') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white' }} font-medium transition-colors rounded-lg hover:bg-gray-800 flex items-center gap-1">
                        Productos
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div class="megamenu fixed pt-2 w-[700px] max-w-[calc(100vw-2rem)] z-50" style="left: 50vw; top: calc(1rem + 4rem + 1px);">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 overflow-hidden">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Ecommerce Card -->
                                <a href="{{ route('ecommerce.index') }}" class="group bg-gradient-to-br from-brand-200/5 to-brand-400/10 rounded-xl p-4 border border-brand-200/20 hover:border-brand-200/40 transition-all hover:shadow-lg">
                                    <div class="flex items-start gap-4">
                                        <!-- Wireframe mini -->
                                        <div class="w-20 h-20 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                            <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                                <div class="h-2 bg-brand-200/30 rounded w-3/4"></div>
                                                <div class="flex-1 grid grid-cols-2 gap-1">
                                                    <div class="bg-brand-200/20 rounded"></div>
                                                    <div class="bg-brand-200/20 rounded"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="shopping-bag" class="w-5 h-5 text-brand-200"></i>
                                                <span class="font-satoshi font-bold text-gray-900">Ecommerce</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mb-3">Tienda online completa con carrito, pagos y envíos.</p>
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-brand-200 group-hover:gap-2 transition-all">
                                                Explorar <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                
                                <!-- Restaurante Card -->
                                <a href="{{ route('restaurant.index') }}" class="group bg-gradient-to-br from-accent-300/5 to-accent-400/10 rounded-xl p-4 border border-accent-300/20 hover:border-accent-300/40 transition-all hover:shadow-lg">
                                    <div class="flex items-start gap-4">
                                        <!-- Wireframe mini -->
                                        <div class="w-20 h-20 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                            <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                                <div class="flex items-center gap-1">
                                                    <div class="w-3 h-3 bg-accent-300/30 rounded"></div>
                                                    <div class="h-2 bg-gray-200 rounded flex-1"></div>
                                                </div>
                                                <div class="flex-1 space-y-1">
                                                    <div class="h-3 bg-accent-300/20 rounded"></div>
                                                    <div class="h-3 bg-accent-300/20 rounded w-4/5"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="utensils" class="w-5 h-5 text-accent-300"></i>
                                                <span class="font-satoshi font-bold text-gray-900">Restaurante</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mb-3">Menú digital, pedidos y reservas de mesas.</p>
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-accent-300 group-hover:gap-2 transition-all">
                                                Explorar <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                
                                <!-- Dropshipping Card (Próximamente) -->
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 opacity-70">
                                    <div class="flex items-start gap-4">
                                        <div class="w-20 h-20 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                            <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                                <div class="h-2 bg-purple-500/30 rounded w-3/4"></div>
                                                <div class="flex-1 grid grid-cols-2 gap-1">
                                                    <div class="bg-purple-500/20 rounded"></div>
                                                    <div class="bg-purple-500/20 rounded"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="truck" class="w-5 h-5 text-purple-500"></i>
                                                <span class="font-satoshi font-bold text-gray-900">Dropshipping</span>
                                                <span class="px-2 py-0.5 bg-brand-200/10 text-brand-200 text-[10px] font-bold rounded-full">PRONTO</span>
                                            </div>
                                            <p class="text-xs text-gray-500">Vende sin inventario, conecta proveedores.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Servicios Card (Próximamente) -->
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 opacity-70">
                                    <div class="flex items-start gap-4">
                                        <div class="w-20 h-20 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                            <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                                <div class="flex items-center gap-1">
                                                    <div class="w-3 h-3 bg-indigo-500/30 rounded"></div>
                                                    <div class="h-2 bg-gray-200 rounded flex-1"></div>
                                                </div>
                                                <div class="flex-1 space-y-1">
                                                    <div class="h-3 bg-indigo-500/20 rounded"></div>
                                                    <div class="h-3 bg-indigo-500/20 rounded w-4/5"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="briefcase" class="w-5 h-5 text-indigo-500"></i>
                                                <span class="font-satoshi font-bold text-gray-900">Servicios</span>
                                                <span class="px-2 py-0.5 bg-brand-200/10 text-brand-200 text-[10px] font-bold rounded-full">PRONTO</span>
                                            </div>
                                            <p class="text-xs text-gray-500">Agenda citas y gestiona servicios.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Funciones MEGAMENU -->
                <div class="megamenu-trigger relative">
                    <button class="px-4 py-2 {{ request()->routeIs('functions.index') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white' }} font-medium transition-colors rounded-lg hover:bg-gray-800 flex items-center gap-1">
                        Funciones
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div class="megamenu fixed pt-2 w-[1200px] max-w-[calc(100vw-2rem)] z-50" style="left: 50vw; top: calc(1rem + 4rem + 1px);">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 overflow-hidden">
                            <div class="grid grid-cols-4 gap-6">
                                <!-- Columna 1: Gestión -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="layout-grid" class="w-4 h-4"></i>
                                        Gestión
                                    </p>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="package" class="w-5 h-5 text-brand-200 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Productos</span>
                                                <span class="text-xs text-gray-500">Catálogo ilimitado</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="box" class="w-5 h-5 text-brand-200 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Inventario</span>
                                                <span class="text-xs text-gray-500">Stock en tiempo real</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="layers" class="w-5 h-5 text-brand-200 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Variantes</span>
                                                <span class="text-xs text-gray-500">Tallas, colores, opciones</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="folder" class="w-5 h-5 text-brand-200 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Categorías</span>
                                                <span class="text-xs text-gray-500">Organiza tu catálogo</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="clock" class="w-5 h-5 text-brand-200 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Bajo pedido</span>
                                                <span class="text-xs text-gray-500">Vende sin stock</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Columna 2: Ventas -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                        Ventas
                                    </p>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="shopping-bag" class="w-5 h-5 text-accent-300 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Pedidos</span>
                                                <span class="text-xs text-gray-500">Gestión completa</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="credit-card" class="w-5 h-5 text-accent-300 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Pagos</span>
                                                <span class="text-xs text-gray-500">Múltiples métodos</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="truck" class="w-5 h-5 text-accent-300 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Envíos</span>
                                                <span class="text-xs text-gray-500">Zonas y tarifas</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="tag" class="w-5 h-5 text-accent-300 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Cupones</span>
                                                <span class="text-xs text-gray-500">Descuentos y ofertas</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="percent" class="w-5 h-5 text-accent-300 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Promociones</span>
                                                <span class="text-xs text-gray-500">Ofertas especiales</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Columna 3: Comunicación -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="zap" class="w-4 h-4"></i>
                                        Comunicación
                                    </p>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="message-circle" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">WhatsApp</span>
                                                <span class="text-xs text-gray-500">Notificaciones automáticas</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="bar-chart-3" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Dashboard</span>
                                                <span class="text-xs text-gray-500">Métricas y reportes</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="palette" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Diseño</span>
                                                <span class="text-xs text-gray-500">Personaliza tu tienda</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="qr-code" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">QR Mesas</span>
                                                <span class="text-xs text-gray-500">Para restaurantes</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="calendar" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Reservas</span>
                                                <span class="text-xs text-gray-500">Agenda online</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Columna 4: Kiubot - IA -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="bot" class="w-4 h-4"></i>
                                        Kiubot - IA
                                    </p>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="shield-check" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Verificación de Pagos</span>
                                                <span class="text-xs text-gray-500">Comprobantes automáticos</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="message-square" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Atención Automática</span>
                                                <span class="text-xs text-gray-500">Chat inteligente 24/7</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="brain" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Recomendaciones</span>
                                                <span class="text-xs text-gray-500">Productos sugeridos</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="search" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Búsqueda Inteligente</span>
                                                <span class="text-xs text-gray-500">Encuentra productos fácil</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group cursor-default">
                                            <i data-lucide="lightbulb" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Asistente Virtual</span>
                                                <span class="text-xs text-gray-500">Ayuda en tiempo real</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Banner inferior del megamenu -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                            <i data-lucide="list" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">Ver todas las funciones</p>
                                            <p class="text-purple-100 text-sm">Descubre todo lo que incluye cada plan</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('functions.index') }}" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-purple-50 transition-colors">
                                        Ver funciones
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Planes -->
                <a href="{{ route('plans.index') }}" class="px-4 py-2 {{ request()->routeIs('plans.index') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white' }} font-medium transition-colors rounded-lg hover:bg-gray-800">
                    Planes
                </a>

                <!-- Recursos MEGAMENU -->
                <div class="megamenu-trigger relative">
                    <button class="px-4 py-2 {{ request()->routeIs('faq.index') || request()->routeIs('contact.index') || request()->routeIs('about.index') || request()->routeIs('team.index') || request()->routeIs('partners.index') || request()->routeIs('release-notes.index') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white' }} font-medium transition-colors rounded-lg hover:bg-gray-800 flex items-center gap-1">
                        Recursos
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                    <div class="megamenu fixed pt-2 w-[900px] max-w-[calc(100vw-2rem)] z-50" style="left: 50vw; top: calc(1rem + 4rem + 1px);">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 overflow-hidden">
                            <div class="grid grid-cols-3 gap-6">
                                <!-- Columna 1: Ayuda y Soporte -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                                        Ayuda
                                    </p>
                                    <div class="space-y-1">
                                        <a href="{{ route('faq.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('faq.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="message-circle-question" class="w-5 h-5 text-blue-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Preguntas Frecuentes</span>
                                                <span class="text-xs text-gray-500">Respuestas rápidas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                            <i data-lucide="book-open" class="w-5 h-5 text-blue-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Tutoriales</span>
                                                <span class="text-xs text-gray-500">Guías paso a paso</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('contact.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('contact.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="mail" class="w-5 h-5 text-blue-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Contacto</span>
                                                <span class="text-xs text-gray-500">Hablemos contigo</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Columna 2: Empresa -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="building" class="w-4 h-4"></i>
                                        Empresa
                                    </p>
                                    <div class="space-y-1">
                                        <a href="{{ route('about.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('about.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="info" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Nosotros</span>
                                                <span class="text-xs text-gray-500">Conoce Linkiu</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('team.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('team.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="users" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Equipo</span>
                                                <span class="text-xs text-gray-500">Quiénes somos</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('partners.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('partners.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="handshake" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Partners</span>
                                                <span class="text-xs text-gray-500">Trabaja con nosotros</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Columna 3: Recursos -->
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                        Recursos
                                    </p>
                                    <div class="space-y-1">
                                        <a href="{{ route('store.login') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                            <i data-lucide="log-in" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Entrar a mi tienda</span>
                                                <span class="text-xs text-gray-500">Acceso para clientes</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                            <i data-lucide="pen-tool" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Blog</span>
                                                <span class="text-xs text-gray-500">Artículos y noticias</span>
                                            </div>
                                        </a>
                                        <a href="{{ route('release-notes.index') }}" class="flex items-center gap-3 p-2 rounded-lg {{ request()->routeIs('release-notes.index') ? 'bg-gray-100' : 'hover:bg-gray-50' }} transition-colors group">
                                            <i data-lucide="sparkles" class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform"></i>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 block">Nuevas Actualizaciones</span>
                                                <span class="text-xs text-gray-500">Release notes</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="hidden lg:flex items-center gap-3">
                <button @click="calendlyOpen = true" class="px-5 py-2.5 border-2 border-gray-600 text-gray-300 hover:border-gray-500 hover:text-white font-semibold rounded-lg transition-colors">
                    Agendar reunión
                </button>
                <a href="{{ route('register.step1') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-5 py-2.5 rounded-lg font-semibold transition-colors">
                    Prueba gratis
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-gray-300 hover:text-white">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak class="lg:hidden bg-gray-900 border-t border-gray-800 py-4 px-4">
        <div class="flex flex-col gap-2">
            <a href="/" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium">Inicio</a>
            
            <!-- Productos Mobile -->
            <button @click="productosOpen = !productosOpen" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium flex items-center justify-between w-full">
                <span>Productos</span>
                <i data-lucide="chevron-down" class="w-4 h-4" :class="productosOpen && 'rotate-180'"></i>
            </button>
            <div x-show="productosOpen" class="pl-4 space-y-1">
                <a href="{{ route('ecommerce.index') }}" class="block px-4 py-2 text-gray-400 hover:text-white">Ecommerce</a>
                <a href="{{ route('restaurant.index') }}" class="block px-4 py-2 text-gray-400 hover:text-white">Restaurante</a>
                <a href="#" class="block px-4 py-2 text-gray-500">Dropshipping (Próximamente)</a>
                <a href="#" class="block px-4 py-2 text-gray-500">Servicios (Próximamente)</a>
            </div>
            
            <!-- Funciones Mobile -->
            <a href="{{ route('functions.index') }}" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium flex items-center justify-between w-full">
                <span>Funciones</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            
            <a href="{{ route('plans.index') }}" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium">Planes</a>
            
            <!-- Ayuda Mobile -->
            <button @click="ayudaOpen = !ayudaOpen" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium flex items-center justify-between w-full">
                <span>Ayuda</span>
                <i data-lucide="chevron-down" class="w-4 h-4" :class="ayudaOpen && 'rotate-180'"></i>
            </button>
            <div x-show="ayudaOpen" class="pl-4 space-y-1">
                <a href="{{ route('faq.index') }}" class="block px-4 py-2 {{ request()->routeIs('faq.index') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white' }} rounded-lg transition-colors">Preguntas Frecuentes</a>
                <a href="#" class="block px-4 py-2 text-gray-400 hover:text-white rounded-lg transition-colors">Tutoriales</a>
                <a href="{{ route('contact.index') }}" class="block px-4 py-2 {{ request()->routeIs('contact.index') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white' }} rounded-lg transition-colors">Contacto</a>
            </div>
            
            <!-- Empresa Mobile -->
            <button @click="empresaOpen = !empresaOpen" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium flex items-center justify-between w-full">
                <span>Empresa</span>
                <i data-lucide="chevron-down" class="w-4 h-4" :class="empresaOpen && 'rotate-180'"></i>
            </button>
            <div x-show="empresaOpen" class="pl-4 space-y-1">
                <a href="{{ route('about.index') }}" class="block px-4 py-2 {{ request()->routeIs('about.index') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white' }} rounded-lg transition-colors">Nosotros</a>
                <a href="{{ route('team.index') }}" class="block px-4 py-2 {{ request()->routeIs('team.index') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white' }} rounded-lg transition-colors">Equipo</a>
                <a href="{{ route('partners.index') }}" class="block px-4 py-2 {{ request()->routeIs('partners.index') ? 'text-white bg-gray-800' : 'text-gray-400 hover:text-white' }} rounded-lg transition-colors">Partners</a>
            </div>
            
            <!-- Recursos Mobile -->
            <button @click="recursosOpen = !recursosOpen" class="px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg font-medium flex items-center justify-between w-full">
                <span>Recursos</span>
                <i data-lucide="chevron-down" class="w-4 h-4" :class="recursosOpen && 'rotate-180'"></i>
            </button>
            <div x-show="recursosOpen" class="pl-4 space-y-1">
                <a href="{{ route('store.login') }}" class="block px-4 py-2 text-gray-400 hover:text-white">Entrar a mi tienda</a>
                <a href="#" class="block px-4 py-2 text-gray-400 hover:text-white">Blog</a>
                <a href="{{ route('release-notes.index') }}" class="block px-4 py-2 text-gray-400 hover:text-white">Nuevas Actualizaciones</a>
            </div>
            
            <hr class="border-gray-700 my-2">
            <button @click="calendlyOpen = true" class="w-full px-4 py-3 border-2 border-gray-600 text-gray-300 hover:border-gray-500 hover:text-white font-semibold rounded-lg transition-colors text-left">
                Agendar reunión
            </button>
            <a href="{{ route('register.step1') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-5 py-3 rounded-lg font-semibold text-center block">
                Prueba gratis
            </a>
        </div>
    </div>
</nav>
