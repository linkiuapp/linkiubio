<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InteractiveGuideController extends Controller
{
    /**
     * Estructura de navegación de Guía Interactiva
     */
    private function getNavigationStructure(): array
    {
        return [
            [
                'title' => 'Productos',
                'icon' => 'package',
                'slug' => 'products',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'products-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'products', 'section' => 'products-index']
                    ],
                    [
                        'title' => 'Creación de Producto',
                        'slug' => 'products-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'products', 'section' => 'products-create']
                    ],
                    [
                        'title' => 'Edición de Producto',
                        'slug' => 'products-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'products', 'section' => 'products-edit']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'products-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'products', 'section' => 'products-show']
                    ],
                ]
            ],
            [
                'title' => 'Pedidos',
                'icon' => 'shopping-cart',
                'slug' => 'orders',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'orders-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'orders', 'section' => 'orders-index']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'orders-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'orders', 'section' => 'orders-show']
                    ],
                    [
                        'title' => 'Edición de Pedido',
                        'slug' => 'orders-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'orders', 'section' => 'orders-edit']
                    ],
                    [
                        'title' => 'Eliminación de Pedido',
                        'slug' => 'orders-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'orders', 'section' => 'orders-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Categorías',
                'icon' => 'folder',
                'slug' => 'categories',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'categories-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'categories', 'section' => 'categories-index']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'categories-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'categories', 'section' => 'categories-show']
                    ],
                    [
                        'title' => 'Creación de Categoría',
                        'slug' => 'categories-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'categories', 'section' => 'categories-create']
                    ],
                    [
                        'title' => 'Edición de Categoría',
                        'slug' => 'categories-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'categories', 'section' => 'categories-edit']
                    ],
                    [
                        'title' => 'Eliminación de Categoría',
                        'slug' => 'categories-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'categories', 'section' => 'categories-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Variables',
                'icon' => 'tag',
                'slug' => 'variables',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'variables-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'variables', 'section' => 'variables-index']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'variables-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'variables', 'section' => 'variables-show']
                    ],
                    [
                        'title' => 'Creación de Variable',
                        'slug' => 'variables-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'variables', 'section' => 'variables-create']
                    ],
                    [
                        'title' => 'Edición de Variable',
                        'slug' => 'variables-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'variables', 'section' => 'variables-edit']
                    ],
                    [
                        'title' => 'Eliminación de Variable',
                        'slug' => 'variables-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'variables', 'section' => 'variables-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Inventario',
                'icon' => 'package-search',
                'slug' => 'inventory',
                'children' => [
                    [
                        'title' => 'Dashboard',
                        'slug' => 'inventory-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'inventory', 'section' => 'inventory-index']
                    ],
                ]
            ],
            [
                'title' => 'Gestión de Envíos',
                'icon' => 'truck',
                'slug' => 'shipping',
                'children' => [
                    [
                        'title' => 'Recogida en Tienda',
                        'slug' => 'shipping-pickup',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'shipping', 'section' => 'shipping-pickup']
                    ],
                    [
                        'title' => 'Envío Local',
                        'slug' => 'shipping-local',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'shipping', 'section' => 'shipping-local']
                    ],
                    [
                        'title' => 'Envío Nacional',
                        'slug' => 'shipping-national',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'shipping', 'section' => 'shipping-national']
                    ],
                ]
            ],
            [
                'title' => 'Métodos de Pago',
                'icon' => 'credit-card',
                'slug' => 'payment-methods',
                'children' => [
                    [
                        'title' => 'Transferencia Bancaria',
                        'slug' => 'payment-method-bank-transfer',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'payment-methods', 'section' => 'payment-method-bank-transfer']
                    ],
                    [
                        'title' => 'Efectivo',
                        'slug' => 'payment-method-cash',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'payment-methods', 'section' => 'payment-method-cash']
                    ],
                    [
                        'title' => 'Datáfono',
                        'slug' => 'payment-method-card-terminal',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'payment-methods', 'section' => 'payment-method-card-terminal']
                    ],
                    [
                        'title' => 'Contra Entrega',
                        'slug' => 'payment-method-cash-on-delivery',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'payment-methods', 'section' => 'payment-method-cash-on-delivery']
                    ],
                ]
            ],
            [
                'title' => 'Sedes',
                'icon' => 'map-pin',
                'slug' => 'locations',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'locations-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'locations', 'section' => 'locations-index']
                    ],
                    [
                        'title' => 'Creación de Sede',
                        'slug' => 'locations-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'locations', 'section' => 'locations-create']
                    ],
                    [
                        'title' => 'Edición de Sede',
                        'slug' => 'locations-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'locations', 'section' => 'locations-edit']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'locations-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'locations', 'section' => 'locations-show']
                    ],
                    [
                        'title' => 'Eliminación de Sede',
                        'slug' => 'locations-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'locations', 'section' => 'locations-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Plan y Facturación',
                'icon' => 'credit-card',
                'slug' => 'billing',
                'children' => [
                    [
                        'title' => 'Gestión de Suscripción',
                        'slug' => 'billing-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'billing', 'section' => 'billing-index']
                    ],
                ]
            ],
            [
                'title' => 'Notificaciones de WhatsApp',
                'icon' => 'message-circle',
                'slug' => 'whatsapp-notifications',
                'children' => [
                    [
                        'title' => 'Configuración',
                        'slug' => 'whatsapp-notifications-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'whatsapp-notifications', 'section' => 'whatsapp-notifications-index']
                    ],
                ]
            ],
            [
                'title' => 'Diseño de Tienda',
                'icon' => 'palette',
                'slug' => 'store-design',
                'children' => [
                    [
                        'title' => 'Configuración',
                        'slug' => 'store-design-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'store-design', 'section' => 'store-design-index']
                    ],
                ]
            ],
            [
                'title' => 'Cupones',
                'icon' => 'ticket',
                'slug' => 'coupons',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'coupons-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'coupons', 'section' => 'coupons-index']
                    ],
                    [
                        'title' => 'Creación de Cupón',
                        'slug' => 'coupons-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'coupons', 'section' => 'coupons-create']
                    ],
                    [
                        'title' => 'Edición de Cupón',
                        'slug' => 'coupons-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'coupons', 'section' => 'coupons-edit']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'coupons-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'coupons', 'section' => 'coupons-show']
                    ],
                    [
                        'title' => 'Eliminación de Cupón',
                        'slug' => 'coupons-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'coupons', 'section' => 'coupons-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Sliders',
                'icon' => 'image',
                'slug' => 'sliders',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'sliders-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sliders', 'section' => 'sliders-index']
                    ],
                    [
                        'title' => 'Creación de Slider',
                        'slug' => 'sliders-create',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sliders', 'section' => 'sliders-create']
                    ],
                    [
                        'title' => 'Edición de Slider',
                        'slug' => 'sliders-edit',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sliders', 'section' => 'sliders-edit']
                    ],
                    [
                        'title' => 'Vista Detallada',
                        'slug' => 'sliders-show',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sliders', 'section' => 'sliders-show']
                    ],
                    [
                        'title' => 'Eliminación de Slider',
                        'slug' => 'sliders-destroy',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sliders', 'section' => 'sliders-destroy']
                    ],
                ]
            ],
            [
                'title' => 'Tickers Promocionales',
                'icon' => 'scroll-text',
                'slug' => 'tickers',
                'children' => [
                    [
                        'title' => 'Configuración',
                        'slug' => 'tickers-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'tickers', 'section' => 'tickers-index']
                    ],
                ]
            ],
            [
                'title' => 'Dashboard',
                'icon' => 'layout-dashboard',
                'slug' => 'dashboard',
                'children' => [
                    [
                        'title' => 'Vista Principal',
                        'slug' => 'dashboard-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'dashboard', 'section' => 'dashboard-index']
                    ],
                ]
            ],
            [
                'title' => 'Sidebar',
                'icon' => 'sidebar',
                'slug' => 'sidebar',
                'children' => [
                    [
                        'title' => 'Navegación',
                        'slug' => 'sidebar-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'sidebar', 'section' => 'sidebar-index']
                    ],
                ]
            ],
            [
                'title' => 'Navbar',
                'icon' => 'menu',
                'slug' => 'navbar',
                'children' => [
                    [
                        'title' => 'Barra de Navegación',
                        'slug' => 'navbar-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'navbar', 'section' => 'navbar-index']
                    ],
                ]
            ],
            [
                'title' => 'Footer',
                'icon' => 'layout',
                'slug' => 'footer',
                'children' => [
                    [
                        'title' => 'Pie de Página',
                        'slug' => 'footer-index',
                        'route' => 'tenant.admin.interactive-guide.show',
                        'params' => ['category' => 'footer', 'section' => 'footer-index']
                    ],
                ]
            ],
        ];
    }

    /**
     * Obtener breadcrumbs para una sección
     */
    private function getBreadcrumbs(string $fullSlug): array
    {
        $store = view()->shared('currentStore');
        $structure = $this->getNavigationStructure();
        $breadcrumbs = [
            ['title' => 'Guía Interactiva', 'url' => route('tenant.admin.interactive-guide.index', ['store' => $store->slug])]
        ];

        foreach ($structure as $parent) {
            foreach ($parent['children'] ?? [] as $child) {
                if ($child['slug'] === $fullSlug) {
                    $breadcrumbs[] = [
                        'title' => $parent['title'],
                        'url' => null
                    ];
                    $breadcrumbs[] = [
                        'title' => $child['title'],
                        'url' => null
                    ];
                    break 2;
                }
            }
        }

        return $breadcrumbs;
    }

    /**
     * Vista principal de Guía Interactiva
     */
    public function index(Request $request): View
    {
        // El middleware ya identificó la tienda
        $store = view()->shared('currentStore');
        
        if (!$store) {
            abort(404, 'Tienda no encontrada');
        }
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        $navigation = $this->getNavigationStructure();

        return view('tenant-admin::Core.interactive-guide.index', compact('store', 'navigation'));
    }

    /**
     * Vista de sección específica
     */
    public function show(Request $request): View
    {
        // El middleware ya identificó la tienda
        $store = view()->shared('currentStore');
        
        if (!$store) {
            abort(404, 'Tienda no encontrada');
        }
        
        // Verificar que el usuario sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            abort(403);
        }

        // Obtener category y section directamente del request para evitar conflictos con route model binding
        $category = $request->route('category');
        $section = $request->route('section');
        
        // Si category es un objeto (Store), significa que Laravel confundió los parámetros
        if (is_object($category)) {
            // Obtener los segmentos de la URL directamente
            $segments = $request->segments();
            // La estructura es: [store-slug, admin, interactive-guide, category, section]
            $category = $segments[3] ?? null;
            $section = $segments[4] ?? null;
        }
        
        if (!$category || !$section) {
            abort(404, 'Parámetros de ruta no válidos');
        }

        $navigation = $this->getNavigationStructure();
        
        // Primero verificar si el section ya es un slug completo que existe en la navegación
        $fullSlug = null;
        $sectionExists = false;
        $sectionTitle = '';
        $parentTitle = '';
        
        // Buscar si el section ya es un slug completo
        foreach ($navigation as $parent) {
            foreach ($parent['children'] ?? [] as $child) {
                if ($child['slug'] === $section) {
                    $fullSlug = $section;
                    $sectionExists = true;
                    $sectionTitle = $child['title'];
                    $parentTitle = $parent['title'];
                    break 2;
                }
            }
        }
        
        // Si no se encontró, construir el slug completo (si section ya incluye el category, usarlo directamente)
        if (!$fullSlug) {
            $fullSlug = str_starts_with($section, $category) ? $section : "{$category}-{$section}";
            
            // Validar que la sección existe
            foreach ($navigation as $parent) {
                foreach ($parent['children'] ?? [] as $child) {
                    if ($child['slug'] === $fullSlug) {
                        $sectionExists = true;
                        $sectionTitle = $child['title'];
                        $parentTitle = $parent['title'];
                        break 2;
                    }
                }
            }
        }

        if (!$sectionExists) {
            \Log::warning('Interactive Guide - Sección no encontrada', [
                'category' => $category,
                'section' => $section,
                'full_slug' => $fullSlug,
                'available_sections' => collect($navigation)->flatMap(function($parent) {
                    return collect($parent['children'] ?? [])->pluck('slug');
                })->toArray()
            ]);
            abort(404, "Sección '{$category}/{$section}' no encontrada. Verifica que la sección esté configurada en el controlador.");
        }

        $breadcrumbs = $this->getBreadcrumbs($fullSlug);

        // Cargar contenido del archivo MD
        $markdownContent = $this->loadMarkdownContent($fullSlug);
        $parsedContent = $this->parseMarkdownContent($markdownContent);

        // Intentar usar vista específica si existe, sino usar la genérica
        $viewPath = "tenant-admin::Core.interactive-guide.{$category}.{$fullSlug}";
        $viewExists = view()->exists($viewPath);
        
        if ($viewExists) {
            return view($viewPath, compact(
                'store',
                'navigation',
                'category',
                'section',
                'fullSlug',
                'sectionTitle',
                'parentTitle',
                'breadcrumbs',
                'parsedContent'
            ));
        }

        // Vista genérica como fallback
        return view('tenant-admin::Core.interactive-guide.show', compact(
            'store',
            'navigation',
            'category',
            'section',
            'fullSlug',
            'sectionTitle',
            'parentTitle',
            'breadcrumbs',
            'parsedContent'
        ));
    }

    /**
     * Cargar contenido del archivo Markdown
     */
    private function loadMarkdownContent(string $section): ?string
    {
        // Mapear sección a ruta del archivo MD
        $sectionMap = [
            'products-index' => 'products/products-index.md',
            'products-create' => 'products/products-create.md',
            'products-edit' => 'products/products-edit.md',
            'products-show' => 'products/products-show.md',
            'orders-index' => 'orders/orders-index.md',
            'orders-show' => 'orders/orders-show.md',
            'orders-edit' => 'orders/orders-edit.md',
            'orders-destroy' => 'orders/orders-destroy.md',
            'categories-index' => 'categories/categories-index.md',
            'categories-create' => 'categories/categories-create.md',
            'categories-edit' => 'categories/categories-edit.md',
            'categories-show' => 'categories/categories-show.md',
            'categories-destroy' => 'categories/categories-destroy.md',
            'variables-index' => 'variables/variables-index.md',
            'variables-create' => 'variables/variables-create.md',
            'variables-edit' => 'variables/variables-edit.md',
            'variables-show' => 'variables/variables-show.md',
            'variables-destroy' => 'variables/variables-destroy.md',
            'inventory-index' => 'inventory/inventory-index.md',
            'shipping-pickup' => 'shipping/shipping-pickup.md',
            'shipping-local' => 'shipping/shipping-local.md',
            'shipping-national' => 'shipping/shipping-national.md',
            'payment-method-bank-transfer' => 'payment-methods/payment-method-bank-transfer.md',
            'payment-method-cash' => 'payment-methods/payment-method-cash.md',
            'payment-method-card-terminal' => 'payment-methods/payment-method-card-terminal.md',
            'payment-method-cash-on-delivery' => 'payment-methods/payment-method-cash-on-delivery.md',
            'locations-index' => 'locations/locations-index.md',
            'locations-create' => 'locations/locations-create.md',
            'locations-edit' => 'locations/locations-edit.md',
            'locations-show' => 'locations/locations-show.md',
            'locations-destroy' => 'locations/locations-destroy.md',
            'billing-index' => 'billing/billing-index.md',
            'whatsapp-notifications-index' => 'whatsapp-notifications/whatsapp-notifications-index.md',
            'store-design-index' => 'store-design/store-design-index.md',
            'coupons-index' => 'coupons/coupons-index.md',
            'coupons-create' => 'coupons/coupons-create.md',
            'coupons-edit' => 'coupons/coupons-edit.md',
            'coupons-show' => 'coupons/coupons-show.md',
            'coupons-destroy' => 'coupons/coupons-destroy.md',
            'sliders-index' => 'sliders/sliders-index.md',
            'sliders-create' => 'sliders/sliders-create.md',
            'sliders-edit' => 'sliders/sliders-edit.md',
            'sliders-show' => 'sliders/sliders-show.md',
            'sliders-destroy' => 'sliders/sliders-destroy.md',
            'tickers-index' => 'tickers/tickers-index.md',
            'dashboard-index' => 'dashboard/dashboard-index.md',
            'sidebar-index' => 'sidebar/sidebar-index.md',
            'navbar-index' => 'navbar/navbar-index.md',
            'footer-index' => 'footer/footer-index.md',
        ];

        $filePath = base_path('tutorials-base/' . ($sectionMap[$section] ?? null));
        
        if (!$filePath || !file_exists($filePath)) {
            return null;
        }

        return file_get_contents($filePath);
    }

    /**
     * Parsear contenido Markdown y extraer elementos
     */
    private function parseMarkdownContent(?string $content): array
    {
        if (!$content) {
            return [
                'description' => 'Contenido no disponible aún.',
                'elements' => [],
                'sections' => []
            ];
        }

        // Extraer descripción (primer párrafo después del título)
        $description = '';
        $lines = explode("\n", $content);
        $foundTitle = false;
        $skipSeparator = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Saltar líneas vacías y separadores
            if (empty($line) || $line === '---') {
                if ($line === '---') $skipSeparator = true;
                continue;
            }
            
            // Detectar título principal
            if (preg_match('/^#\s+(.+)$/', $line, $matches)) {
                $foundTitle = true;
                continue;
            }
            
            // Obtener descripción después del título
            if ($foundTitle && !str_starts_with($line, '#') && !$skipSeparator) {
                $description = $line;
                break;
            }
            
            if ($skipSeparator && !str_starts_with($line, '#')) {
                $skipSeparator = false;
            }
        }

        // Extraer secciones y elementos
        $sections = [];
        $currentSection = null;
        $currentElement = null;
        $inSection = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Saltar líneas vacías y separadores
            if (empty($line) || $line === '---') {
                continue;
            }
            
            // Detectar encabezados de sección (##)
            if (preg_match('/^##\s+(.+)$/', $line, $matches)) {
                // Guardar sección anterior
                if ($currentSection) {
                    if ($currentElement) {
                        $currentSection['elements'][] = $currentElement;
                        $currentElement = null;
                    }
                    $sections[] = $currentSection;
                }
                
                // Nueva sección
                $currentSection = [
                    'title' => preg_replace('/^[📋🔘📊🔍🔧📋💬📝💡]/u', '', $matches[1]), // Remover emojis
                    'elements' => []
                ];
                $inSection = true;
                $currentElement = null;
            }
            // Detectar elementos (###)
            elseif (preg_match('/^###\s+(.+)$/', $line, $matches) && $currentSection) {
                // Guardar elemento anterior
                if ($currentElement) {
                    $currentSection['elements'][] = $currentElement;
                }
                
                // Nuevo elemento
                $currentElement = [
                    'title' => preg_replace('/^[📋🔘📊🔍🔧📋💬📝💡]/u', '', $matches[1]), // Remover emojis
                    'description' => ''
                ];
            }
            // Detectar sub-elementos (####)
            elseif (preg_match('/^####\s+(.+)$/', $line, $matches) && $currentElement) {
                // Agregar como parte de la descripción del elemento actual
                if (!empty($currentElement['description'])) {
                    $currentElement['description'] .= "\n\n";
                }
                $currentElement['description'] .= "**" . $matches[1] . "**";
            }
            // Agregar descripción al elemento actual
            elseif ($currentElement && !str_starts_with($line, '#')) {
                if (!empty($line)) {
                    if (!empty($currentElement['description']) && !str_ends_with($currentElement['description'], "\n")) {
                        $currentElement['description'] .= ' ';
                    }
                    $currentElement['description'] .= $line;
                }
            }
        }
        
        // Guardar última sección y elemento
        if ($currentElement && $currentSection) {
            $currentSection['elements'][] = $currentElement;
        }
        if ($currentSection) {
            $sections[] = $currentSection;
        }

        return [
            'description' => $description ?: 'Esta sección te ayuda a entender cada elemento de la interfaz.',
            'elements' => [],
            'sections' => $sections,
            'raw' => $content
        ];
    }
}
