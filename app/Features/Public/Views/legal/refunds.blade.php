<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Política de Reembolsos - Linkiu">
    <title>Política de Reembolsos - Linkiu</title>
    
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
                <h1 class="font-satoshi text-4xl sm:text-5xl font-black text-gray-900 mb-4">Política de Reembolsos</h1>
                <p class="text-gray-600 font-inter">Última actualización: {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none font-inter text-gray-700 space-y-6">
                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">1. Período de Prueba Gratuita</h2>
                    <p>Ofrecemos un período de prueba gratuito para que puedas evaluar nuestros servicios. Durante este período, puedes cancelar tu suscripción sin ningún cargo.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">2. Política de Devoluciones</h2>
                    <p class="mb-4"><strong>Política General:</strong> Si cancelas tu suscripción por decisión propia, tu plan permanecerá activo hasta el final del período de facturación que ya pagaste, sin importar si es mensual, trimestral, semestral o anual. <strong>No se realizará ningún reembolso por el tiempo restante del período pagado.</strong></p>
                    <p class="mb-4">Esta política aplica para todos los períodos de facturación:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li><strong>Mensual:</strong> Si pagaste un mes, tendrás acceso hasta el final de ese mes.</li>
                        <li><strong>Trimestral:</strong> Si pagaste 3 meses, tendrás acceso hasta el final del trimestre.</li>
                        <li><strong>Semestral:</strong> Si pagaste 6 meses, tendrás acceso hasta el final del semestre.</li>
                        <li><strong>Anual:</strong> Si pagaste un año, tendrás acceso hasta el final del año pagado.</li>
                    </ul>
                    <p class="mb-4">Ejemplos:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>Si pagaste el 1 de enero por un plan <strong>mensual</strong> y cancelas el 15 de enero, tendrás acceso completo hasta el 31 de enero. No se reembolsará nada.</li>
                        <li>Si pagaste el 1 de enero por un plan <strong>semestral</strong> (6 meses) y cancelas el 15 de febrero, tendrás acceso completo hasta el 30 de junio. No se reembolsará nada.</li>
                        <li>Si pagaste el 1 de enero por un plan <strong>anual</strong> (12 meses) y cancelas el 1 de marzo, tendrás acceso completo hasta el 31 de diciembre. No se reembolsará nada.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">3. Excepciones y Reembolsos</h2>
                    <p class="mb-4">Aunque nuestra política general es no realizar reembolsos, existen excepciones en casos específicos:</p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-4">
                        <h3 class="font-satoshi font-bold text-blue-900 mb-2">Reembolso Completo (Primeros 7 días)</h3>
                        <p class="text-blue-800 mb-2">Se realizará un reembolso completo si:</p>
                        <ul class="list-disc pl-6 space-y-1 text-blue-800">
                            <li>Experimentas problemas técnicos de Linkiu que no podemos resolver en 48 horas</li>
                            <li>La plataforma no está disponible durante más de 24 horas consecutivas</li>
                            <li>Te solicitamos información o documentación que no puedes proporcionar por causas ajenas a ti</li>
                        </ul>
                    </div>
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg mb-4">
                        <h3 class="font-satoshi font-bold text-amber-900 mb-2">Reembolso Prorrateado</h3>
                        <p class="text-amber-800 mb-2">Se realizará un reembolso prorrateado (solo por el tiempo restante) si:</p>
                        <ul class="list-disc pl-6 space-y-1 text-amber-800">
                            <li>Tu cuenta es suspendida o cancelada por Linkiu sin causa atribuible a ti</li>
                            <li>Se confirma que la suspensión fue un error de Linkiu</li>
                        </ul>
                        <p class="text-amber-800 mt-2 text-sm">El reembolso se calculará proporcionalmente al tiempo restante del período pagado.</p>
                    </div>
                    <p class="mb-4">Para solicitar un reembolso bajo estas excepciones, debes contactarnos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline font-semibold">soporte@linkiu.bio</a> dentro de los primeros 7 días después de la situación que genera el reembolso.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">4. Cancelación de Suscripción</h2>
                    <p class="mb-4">Puedes cancelar tu suscripción en cualquier momento desde tu panel de administración. La cancelación entrará en vigor al final del período de facturación que ya pagaste (mes, trimestre, semestre o año).</p>
                    <p class="mb-4">Al cancelar:</p>
                    <ul class="list-disc pl-6 space-y-2 mb-4">
                        <li>No se realizará ningún cargo adicional después de la cancelación</li>
                        <li>No se reembolsará el tiempo restante del período pagado (días, meses o años)</li>
                        <li>Tu tienda permanecerá activa y funcional hasta el final del período pagado</li>
                        <li>Después del período pagado, tu suscripción no se renovará automáticamente</li>
                    </ul>
                    <p>Si cancelas un plan anual después de 2 meses de uso, tendrás acceso completo los 10 meses restantes sin reembolso.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">5. Períodos de Prueba Gratuita</h2>
                    <p>Durante el período de prueba gratuita, puedes cancelar tu suscripción en cualquier momento sin ningún cargo. Una vez que se realice el primer pago, aplica la política de no devoluciones explicada anteriormente.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">6. Consultas</h2>
                    <p>Si tienes preguntas sobre esta política de reembolsos, contáctanos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a>. Estamos aquí para ayudarte.</p>
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
