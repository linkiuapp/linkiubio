<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReleaseNotesController extends Controller
{
    /**
     * Mostrar página pública de nuevas actualizaciones
     */
    public function index(): View
    {
        // Últimas 5 versiones basadas en el trabajo reciente del proyecto
        $versions = [
            [
                'version' => '3.8.0',
                'date' => '8 de enero, 2026',
                'date_raw' => '2026-01-08',
                'is_current' => true,
                'items' => [
                    ['type' => 'new', 'description' => 'Sistema de Ticker (anuncios deslizantes) para páginas públicas'],
                    ['type' => 'fix', 'description' => 'Mejoras en el sistema de tickets y gestión de estados'],
                    ['type' => 'fix', 'description' => 'Correcciones en la visualización de enlaces internos en sliders'],
                ]
            ],
            [
                'version' => '3.7.11',
                'date' => '6 de enero, 2026',
                'date_raw' => '2026-01-06',
                'is_current' => false,
                'items' => [
                    ['type' => 'new', 'description' => 'Páginas públicas: FAQ, Contacto, Nosotros, Nuevas Actualizaciones'],
                    ['type' => 'fix', 'description' => 'Estados activos dinámicos en navbar y footer'],
                    ['type' => 'fix', 'description' => 'Integración de modal de Calendly en todas las páginas públicas'],
                ]
            ],
            [
                'version' => '3.7.10',
                'date' => '26 de diciembre, 2025',
                'date_raw' => '2025-12-26',
                'is_current' => false,
                'items' => [
                    ['type' => 'new', 'description' => 'Optimizaciones de rendimiento en Dashboard (-63% tiempo de carga)'],
                    ['type' => 'fix', 'description' => 'Reducción de queries en dashboard de 11 a 5 (-55%)'],
                    ['type' => 'fix', 'description' => 'Mejora en LCP (Largest Contentful Paint) con pre-carga de banners'],
                ]
            ],
            [
                'version' => '3.7.9',
                'date' => '25 de diciembre, 2025',
                'date_raw' => '2025-12-25',
                'is_current' => false,
                'items' => [
                    ['type' => 'new', 'description' => 'Sistema de gestión de mesas y códigos QR para restaurantes'],
                    ['type' => 'fix', 'description' => 'Implementación de multi-tenancy en sistema de mesas'],
                    ['type' => 'fix', 'description' => 'Creación de TableService para mejorar arquitectura'],
                    ['type' => 'fix', 'description' => 'Optimización con cache y paginación en mesas'],
                ]
            ],
            [
                'version' => '3.7.8',
                'date' => '19 de diciembre, 2025',
                'date_raw' => '2025-12-19',
                'is_current' => false,
                'items' => [
                    ['type' => 'new', 'description' => 'Sistema de cupones de descuento integrado'],
                    ['type' => 'fix', 'description' => 'Mejoras en la gestión de inventario'],
                    ['type' => 'fix', 'description' => 'Correcciones menores de errores'],
                ]
            ],
        ];

        return view('public::release-notes.index', compact('versions'));
    }
}
