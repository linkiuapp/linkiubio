<?php

namespace App\Features\DesignSystem\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ComponentLibraryController extends Controller
{
    /**
     * Página principal - redirige a colores
     */
    public function index()
    {
        return redirect()->route('design-system.colores');
    }

    /**
     * Mostrar sistema de colores
     */
    public function colores(): View
    {
        // Colores del sistema
        $colorPalette = [
            'brandWhite' => [
                'name' => 'Brand White',
                'shades' => [
                    '50' => '#fdfdff',
                    '100' => '#f2f1fd',
                    '200' => '#eceafc',
                    '300' => '#e8e6fb',
                    '400' => '#8e8c99',
                ]
            ],
            'brandNeutral' => [
                'name' => 'Brand Neutral',
                'shades' => [
                    '50' => '#e8e8e8',
                    '100' => '#9f9fa1',
                    '200' => '#77777a',
                    '300' => '#3d3c40',
                    '400' => '#151419',
                    '500' => '#0d0c0f',
                ]
            ],
            'brandSuccess' => [
                'name' => 'Success',
                'shades' => [
                    '50' => '#d1fae5',
                    '100' => '#6ee7b7',
                    '200' => '#10b981',
                    '300' => '#047857',
                    '400' => '#064e3b',
                ]
            ],
            'brandWarning' => [
                'name' => 'Warning',
                'shades' => [
                    '50' => '#fef3c7',
                    '100' => '#fcd34d',
                    '200' => '#f59e0b',
                    '300' => '#b45309',
                    '400' => '#78350f',
                ]
            ],
            'brandError' => [
                'name' => 'Error',
                'shades' => [
                    '50' => '#fee2e2',
                    '100' => '#fca5a5',
                    '200' => '#ef4444',
                    '300' => '#b91c1c',
                    '400' => '#7f1d1d',
                ]
            ],
            'brandInfo' => [
                'name' => 'Info',
                'shades' => [
                    '50' => '#e0f2fe',
                    '100' => '#7dd3fc',
                    '200' => '#0ea5e9',
                    '300' => '#0369a1',
                    '400' => '#0c4a6e',
                ]
            ],
            'brandPrimary' => [
                'name' => 'Primary',
                'shades' => [
                    '50' => '#e0e7ff',
                    '100' => '#a5b4fc',
                    '200' => '#6366f1',
                    '300' => '#4338ca',
                    '400' => '#312e81',
                ]
            ],
            'brandSecondary' => [
                'name' => 'Secondary',
                'shades' => [
                    '50' => '#fbcfe8',
                    '100' => '#f472b6',
                    '200' => '#ec4899',
                    '300' => '#be185d',
                    '400' => '#831843',
                ]
            ],
        ];

        // Tipografías del sistema
        $typography = [
            'headings' => [
                ['class' => 'h1', 'label' => 'H1 (Bold)', 'size' => '30px → 48px', 'lineHeight' => '1.2'],
                ['class' => 'h2', 'label' => 'H2 (Semibold)', 'size' => '24px → 36px', 'lineHeight' => '1.25'],
                ['class' => 'h3', 'label' => 'H3 (Semibold)', 'size' => '20px → 28px', 'lineHeight' => '1.3'],
                ['class' => 'h3-medium', 'label' => 'H3 Medium', 'size' => '20px → 28px', 'lineHeight' => '1.3'],
                ['class' => 'h4', 'label' => 'H4 (Medium)', 'size' => '18px → 24px', 'lineHeight' => '1.35'],
            ],
            'body' => [
                ['class' => 'body-lg', 'label' => 'Body Large (Regular)', 'size' => '16px → 18px', 'lineHeight' => '1.55'],
                ['class' => 'body-lg-medium', 'label' => 'Body Large (Medium)', 'size' => '16px → 18px', 'lineHeight' => '1.55'],
                ['class' => 'body-lg-bold', 'label' => 'Body Large (Bold)', 'size' => '16px → 18px', 'lineHeight' => '1.5'],
                ['class' => 'body-small', 'label' => 'Body Small (Regular)', 'size' => '14px → 16px', 'lineHeight' => '1.5'],
            ],
            'caption' => [
                ['class' => 'caption', 'label' => 'Caption (Medium)', 'size' => '12px → 14px', 'lineHeight' => '1.4'],
                ['class' => 'caption-strong', 'label' => 'Caption (Semibold)', 'size' => '12px → 14px', 'lineHeight' => '1.4'],
            ]
        ];

        return view('design-system::colores', compact('colorPalette'));
    }

    /**
     * Mostrar sistema tipográfico
     */
    public function tipografias(): View
    {
        // Tipografías del sistema
        $typography = [
            'headings' => [
                ['class' => 'h1', 'label' => 'H1 (Bold)', 'size' => '30px → 48px', 'lineHeight' => '1.2'],
                ['class' => 'h2', 'label' => 'H2 (Semibold)', 'size' => '24px → 36px', 'lineHeight' => '1.25'],
                ['class' => 'h3', 'label' => 'H3 (Semibold)', 'size' => '20px → 28px', 'lineHeight' => '1.3'],
                ['class' => 'h3-medium', 'label' => 'H3 Medium', 'size' => '20px → 28px', 'lineHeight' => '1.3'],
                ['class' => 'h4', 'label' => 'H4 (Medium)', 'size' => '18px → 24px', 'lineHeight' => '1.35'],
            ],
            'body' => [
                ['class' => 'body-lg', 'label' => 'Body Large (Regular)', 'size' => '16px → 18px', 'lineHeight' => '1.55'],
                ['class' => 'body-lg-medium', 'label' => 'Body Large (Medium)', 'size' => '16px → 18px', 'lineHeight' => '1.55'],
                ['class' => 'body-lg-bold', 'label' => 'Body Large (Bold)', 'size' => '16px → 18px', 'lineHeight' => '1.5'],
                ['class' => 'body-small', 'label' => 'Body Small (Regular)', 'size' => '14px → 16px', 'lineHeight' => '1.5'],
            ],
            'caption' => [
                ['class' => 'caption', 'label' => 'Caption (Medium)', 'size' => '12px → 14px', 'lineHeight' => '1.4'],
                ['class' => 'caption-strong', 'label' => 'Caption (Semibold)', 'size' => '12px → 14px', 'lineHeight' => '1.4'],
            ]
        ];

        return view('design-system::tipografias', compact('typography'));
    }

    /**
     * Mostrar sistema de estados y contrastes
     */
    public function estados(): View
    {
        return view('design-system::estados');
    }

    /**
     * Mostrar sistema de iconos
     */
    public function iconos(): View
    {
        // Tamaños de iconos (basados en uso real en Tenant/Storefront)
        $iconSizes = [
            'contexts' => [
                ['size' => 'w-3 h-3', 'px' => '12px', 'label' => 'XS', 'uso' => 'Botones small, badges inline', 'mobile' => true],
                ['size' => 'w-4 h-4', 'px' => '16px', 'label' => 'SM', 'uso' => 'Badges, heart/favoritos, compartir', 'mobile' => true],
                ['size' => 'w-5 h-5', 'px' => '20px', 'label' => 'MD', 'uso' => 'Botones medium, carrito (DEFAULT)', 'mobile' => true],
                ['size' => 'w-6 h-6', 'px' => '24px', 'label' => 'LG', 'uso' => 'Botones large, headers, tabs', 'mobile' => true],
                ['size' => 'w-8 h-8', 'px' => '32px', 'label' => 'XL', 'uso' => 'Features, secciones destacadas', 'mobile' => true],
                ['size' => 'w-14 h-14', 'px' => '56px', 'label' => '2XL', 'uso' => 'Iconos de categorías, placeholders', 'mobile' => true],
                ['size' => 'w-16 h-16', 'px' => '64px', 'label' => '3XL', 'uso' => 'Estados vacíos, ilustraciones', 'mobile' => true],
            ],
            'devices' => [
                'mobile' => [
                    'name' => 'Mobile (320px-640px)',
                    'minTouch' => 'w-10 h-10',
                    'recommended' => ['w-4 h-4', 'w-5 h-5', 'w-6 h-6', 'w-8 h-8'],
                    'avoid' => ['w-3 h-3'],
                    'note' => 'En Tenant: w-4 para badges, w-5 para botones principales, w-6 para botones destacados'
                ],
                'tablet' => [
                    'name' => 'Tablet (641px-1024px)',
                    'minTouch' => 'w-8 h-8',
                    'recommended' => ['w-5 h-5', 'w-6 h-6', 'w-8 h-8'],
                    'avoid' => [],
                    'note' => 'Balance entre mobile y desktop'
                ],
                'desktop' => [
                    'name' => 'Desktop (1025px+)',
                    'minTouch' => 'w-6 h-6',
                    'recommended' => ['w-4 h-4', 'w-5 h-5', 'w-6 h-6'],
                    'avoid' => [],
                    'note' => 'En Tenant: w-4 para inline, w-5 para botones, w-6 para headers'
                ],
            ]
        ];

        return view('design-system::iconos', compact('iconSizes'));
    }


}

