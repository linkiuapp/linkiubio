<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Términos y Condiciones - Linkiu">
    <title>Términos y Condiciones - Linkiu</title>
    
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
<body class="font-inter antialiased bg-white text-gray-900">
    <x-public-navbar />

    <!-- Content -->
    <main class="pt-32 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="font-satoshi text-4xl sm:text-5xl font-black text-gray-900 mb-4">Términos y Condiciones</h1>
                <p class="text-gray-600 font-inter">Última actualización: {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none font-inter text-gray-700 space-y-6">
                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">1. Aceptación de los Términos</h2>
                    <p>Al acceder y utilizar Linkiu, aceptas estar sujeto a estos términos y condiciones. Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar nuestros servicios.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">2. Descripción del Servicio</h2>
                    <p>Linkiu es una plataforma que permite a los usuarios crear y gestionar tiendas online. Ofrecemos herramientas para la creación de catálogos, gestión de pedidos, pagos y envíos.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">3. Registro y Cuenta</h2>
                    <p>Para utilizar nuestros servicios, debes crear una cuenta proporcionando información precisa y actualizada. Eres responsable de mantener la confidencialidad de tu cuenta y contraseña.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">4. Uso Aceptable</h2>
                    <p class="mb-4">Te comprometes a utilizar Linkiu de manera legal y ética. No debes usar nuestros servicios para actividades ilegales, fraudulentas o que violen los derechos de terceros.</p>
                    <p class="mb-4">Está prohibido:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Vender productos o servicios ilegales o fraudulentos</li>
                        <li>Engañar a usuarios con información falsa o productos que no se corresponden con lo anunciado</li>
                        <li>Usar la plataforma para actividades que violen leyes locales o nacionales</li>
                        <li>Realizar transacciones fraudulentas o estafas</li>
                        <li>Vulnerar la seguridad de la plataforma o de otros usuarios</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">5. Medidas Disciplinarias y Suspensión de Cuentas</h2>
                    <p class="mb-4">Linkiu se reserva el derecho de investigar cualquier reporte o denuncia de irregularidades en el uso de la plataforma. Como medida disciplinaria, Linkiu puede:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Investigar el caso reportado de manera exhaustiva</li>
                        <li>Solicitar información adicional al administrador de la tienda</li>
                        <li>Suspender temporal o permanentemente la cuenta si se confirman irregularidades</li>
                        <li>Cancelar la suscripción sin reembolso en casos graves de violación de términos</li>
                    </ul>
                    <p class="mb-4">Las suspensiones pueden aplicarse cuando se detecten:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Actividades fraudulentas o ilegales</li>
                        <li>Múltiples denuncias de usuarios por incumplimiento o estafa</li>
                        <li>Violación de derechos de terceros (propiedad intelectual, privacidad, etc.)</li>
                        <li>Uso de la plataforma para actividades prohibidas</li>
                    </ul>
                    <p>Si tu cuenta es suspendida, tendrás la oportunidad de apelar la decisión contactándonos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a> con la documentación que consideres relevante.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">6. Dominios Oficiales y Seguridad</h2>
                    <p>Los únicos dominios oficiales autorizados por Linkiu son:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-2">
                        <li><strong>linkiu.bio</strong></li>
                        <li><strong>linkiu.email</strong></li>
                        <li><strong>linkiu.com.co</strong></li>
                    </ul>
                    <p class="mt-4">Solo debes acceder a Linkiu a través de estos dominios oficiales. Cualquier otro dominio que pretenda representar a Linkiu no está autorizado. Linkiu no se hace responsable por el uso de servicios no oficiales o sitios web fraudulentos que intenten suplantar nuestra identidad.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">7. Propiedad Intelectual</h2>
                    <p>Todo el contenido de Linkiu, incluyendo diseño, logos, textos y software, es propiedad de Linkiu y está protegido por leyes de propiedad intelectual.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">8. Limitación de Responsabilidad</h2>
                    <p class="mb-4">Linkiu actúa como intermediario entre los administradores de tiendas (propietarios) y los usuarios finales (clientes). Linkiu proporciona la plataforma tecnológica que permite a los administradores crear y gestionar sus tiendas online, pero no participa directamente en las transacciones comerciales entre administradores y usuarios.</p>
                    <p class="mb-4">En consecuencia:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Linkiu no se hace responsable por pérdidas, daños o disputas derivadas de transacciones entre administradores y usuarios finales.</li>
                        <li>La responsabilidad por productos, servicios, entregas, pagos y cualquier otra transacción comercial recae directamente entre el administrador de la tienda y el usuario final.</li>
                        <li>Linkiu no garantiza la calidad, disponibilidad o cumplimiento de productos o servicios ofrecidos por los administradores.</li>
                        <li>El uso de la plataforma es bajo tu propio riesgo.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">9. Modificaciones</h2>
                    <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en vigor al publicarse en esta página.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">10. Contacto</h2>
                    <p>Para consultas sobre estos términos, puedes contactarnos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a>.</p>
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
