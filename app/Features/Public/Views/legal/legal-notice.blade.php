<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aviso Legal - Linkiu">
    <title>Aviso Legal - Linkiu</title>
    
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
                <h1 class="font-satoshi text-4xl sm:text-5xl font-black text-gray-900 mb-4">Aviso Legal</h1>
                <p class="text-gray-600 font-inter">Última actualización: {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none font-inter text-gray-700 space-y-6">
                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">1. Datos Identificativos</h2>
                    <p>En cumplimiento con el deber de información, los datos identificativos del titular de este sitio web son:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-2">
                        <li><strong>Denominación social:</strong> Linkiu</li>
                        <li><strong>Correo electrónico:</strong> soporte@linkiu.bio</li>
                        <li><strong>Sitio web:</strong> linkiu.bio</li>
                    </ul>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">2. Dominios Autorizados</h2>
                    <p>Los únicos dominios oficiales autorizados por Linkiu son:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-2">
                        <li><strong>linkiu.bio</strong></li>
                        <li><strong>linkiu.email</strong></li>
                        <li><strong>linkiu.com.co</strong></li>
                    </ul>
                    <p class="mt-4">Cualquier otro dominio que pretenda representar a Linkiu no es oficial y no está autorizado. Recomendamos verificar siempre que estés accediendo a uno de estos dominios oficiales para proteger tu información y evitar fraudes.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">3. Objeto</h2>
                    <p>El presente aviso legal regula el uso del sitio web linkiu.bio, propiedad de Linkiu, así como los servicios ofrecidos a través de la plataforma.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">4. Condiciones de Uso</h2>
                    <p>El acceso y uso de este sitio web implica la aceptación de las condiciones de uso establecidas. El usuario se compromete a utilizar el sitio de forma lícita y conforme a la legislación vigente.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">5. Propiedad Intelectual</h2>
                    <p>Todo el contenido de este sitio web, incluyendo textos, gráficos, logos, iconos, imágenes y software, es propiedad de Linkiu y está protegido por las leyes de propiedad intelectual.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">6. Responsabilidad</h2>
                    <p>Linkiu no se hace responsable de los daños que puedan derivarse del uso de la información contenida en este sitio web o de la imposibilidad de acceder a él.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">7. Legislación Aplicable</h2>
                    <p>Este aviso legal se rige por la legislación colombiana. Para cualquier controversia, las partes se someten a los juzgados y tribunales de Colombia.</p>
                </section>

                <section>
                    <h2 class="font-satoshi text-2xl font-bold text-gray-900 mb-4">8. Contacto</h2>
                    <p>Para cualquier consulta sobre este aviso legal, puedes contactarnos en <a href="mailto:soporte@linkiu.bio" class="text-brand-200 hover:underline">soporte@linkiu.bio</a>.</p>
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
