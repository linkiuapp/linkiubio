<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Política de Privacidad - Linkiu">
    <title>Política de Privacidad - Linkiu</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Satoshi Font -->
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 200: '#0007F7', 400: '#000684' },
                        accent: { 300: '#EA0038', 400: '#9E0024' },
                        dark: { 800: '#0a0a0f', 900: '#050506' }
                    },
                    fontFamily: {
                        satoshi: ['Satoshi', 'sans-serif'],
                        inter: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .font-satoshi { font-family: 'Satoshi', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* Dropdown menu */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Megamenu */
        .megamenu {
            opacity: 0;
            visibility: hidden;
            transform: translateX(-50%) translateY(10px);
            transition: all 0.25s ease;
        }
        .megamenu-trigger:hover .megamenu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        
        /* Alpine.js x-cloak */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900" x-data="{ mobileMenu: false, productosOpen: false, funcionesOpen: false, recursosOpen: false, ayudaOpen: false, empresaOpen: false, calendlyOpen: false }">
    <x-public-navbar />

    <!-- Content -->
    <main class="pt-32 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="font-satoshi text-4xl sm:text-5xl font-black text-gray-900 mb-4">Política de Privacidad</h1>
                <p class="text-gray-600 font-inter">Última actualización: {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none font-inter text-gray-700 space-y-6">
                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">1. Información que Recopilamos</h2>
                    <p>Recopilamos información que nos proporcionas directamente, como nombre, correo electrónico, información de pago y datos de tu negocio cuando te registras en Linkiu.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">2. Uso de la Información</h2>
                    <p>Utilizamos tu información para proporcionar, mantener y mejorar nuestros servicios, procesar transacciones, comunicarnos contigo y cumplir con obligaciones legales.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">3. Compartir Información</h2>
                    <p>No vendemos ni alquilamos tu información personal. Solo compartimos información con terceros cuando es necesario para proporcionar nuestros servicios o cuando la ley lo requiere.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">4. Seguridad</h2>
                    <p>Implementamos medidas de seguridad técnicas y organizativas para proteger tu información personal contra acceso no autorizado, pérdida o destrucción.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">5. Tus Derechos</h2>
                    <p>Tienes derecho a acceder, rectificar, eliminar o portar tus datos personales. Puedes ejercer estos derechos contactándonos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a>.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">6. Cookies</h2>
                    <p>Utilizamos cookies para mejorar tu experiencia. Puedes gestionar las preferencias de cookies en tu navegador. Para más información, consulta nuestra <a href="{{ route('legal.cookies') }}" class="text-brand-200 hover:underline">Política de Cookies</a>.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">7. Cambios a esta Política</h2>
                    <p>Podemos actualizar esta política ocasionalmente. Te notificaremos sobre cambios significativos publicando la nueva política en esta página.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">8. Contacto</h2>
                    <p>Para preguntas sobre esta política, contáctanos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a>.</p>
                </section>
            </div>
        </div>
    </main>

    <x-public-footer />

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
