/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // Asegúrate de que Tailwind escanee tus archivos Blade y otros donde uses clases
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    // Feature-based Architecture - Incluir archivos Blade en Features y Shared
    './app/Features/**/*.blade.php',
    './app/Shared/**/*.blade.php',
    // Preline UI components
    './node_modules/preline/dist/*.js',
  ],
  safelist: [
    // Clases de estado de cupones generadas dinámicamente desde PHP
    'text-brandWarning-400',
    'bg-brandWarning-50',
    'border-brandWarning-400',
    'text-brandError-400',
    'bg-brandError-50',
    'border-brandError-400',
    'text-brandSuccess-400',
    'bg-brandSuccess-50',
    'border-brandSuccess-400',
    'text-brandInfo-400',
    'bg-brandInfo-50',
    'border-brandInfo-400',
    // Clases para alerts del Design System
    'bg-brandWarning-100',
    'bg-brandInfo-100',

    
    // Clases de animación para componentes
    'animate-ping',
    'animate-spin',
    'group-hover:scale-105',
    'group-focus:scale-105', 
    'transition-transform',
    'duration-500',
    'ease-in-out',
    'group',
    
    // Clases de spinner para botones loading
    'border-current',
    'border-t-transparent',
    'w-3', 'h-3', 'w-4', 'h-4', 'w-5', 'h-5',
    'border-2', 'border-4',
    'inline-block',
    'px-3',
    'px-4',
    'ps-4',
    'ps-11',
    'pe-3',
    'p-3.5',
    'p-4',
    'sm:py-2',
    'sm:py-3',
    'sm:p-5',
    'sm:text-sm',
    'focus:border-blue-500',
    'focus:border-red-500',
    'focus:border-teal-500',
    'focus:ring-blue-500',
    'focus:ring-red-500',
    'focus:ring-teal-500',
    'focus:ring-neutral-600',
    'disabled:opacity-50',
    'disabled:pointer-events-none',
    'peer-disabled:opacity-50',
    'peer-disabled:pointer-events-none',
    'placeholder:text-transparent',
    'peer-focus:scale-90',
    'peer-focus:translate-x-0.5',
    'peer-focus:-translate-y-1.5',
    'peer-focus:text-gray-500',
    'peer-not-placeholder-shown:scale-90',
    'peer-not-placeholder-shown:translate-x-0.5',
    'peer-not-placeholder-shown:-translate-y-1.5',
    'peer-not-placeholder-shown:text-gray-500',
    'focus:pt-6',
    'focus:pb-2',
    'not-placeholder-shown:pt-6',
    'not-placeholder-shown:pb-2',
    'autofill:pt-6',
    'autofill:pb-2',
    'shrink-0',
    'size-4',
    
    // Clases para floating labels
    'placeholder-transparent',
    'transition-all',
    'peer-focus:scale-90',
    'peer-focus:translate-x-0.5',
    'peer-focus:-translate-y-1.5',
    'peer-focus:text-gray-600',
    'peer-placeholder-shown:scale-100',
    'peer-placeholder-shown:translate-x-0',
    'peer-placeholder-shown:translate-y-0',
    'text-brandWarning-300',
    'text-brandInfo-300',
    'bg-brandSuccess-100',
    'bg-brandError-100',
    'text-brandSuccess-300',
    'text-brandError-300',
  ],
  theme: {
    extend: {
      // Tipografías personalizadas
      fontFamily: {
        'heading': ['Inter', 'sans-serif'],
        'body': ['Inter', 'sans-serif'],
        'sans': ['Inter', 'sans-serif'], // Por defecto Inter
      },



      fontSize: {
        'xs': ['10px', { lineHeight: '12px', letterSpacing: '0.025em' }],
        'sm': ['12px', { lineHeight: '14px', letterSpacing: '0.025em' }],
        '2xs': ['14px', { lineHeight: '16px', letterSpacing: '0.025em' }],
        'base': ['16px', { lineHeight: '18px', letterSpacing: '0.025em' }],
        'basex': ['20px', { lineHeight: '22px', letterSpacing: '0.025em' }],
        'lg': ['24px', { lineHeight: '26px', letterSpacing: '0.025em' }],
        'xl': ['32px', { lineHeight: '34px', letterSpacing: '0.025em' }],
        '2xl': ['40px', { lineHeight: '42px', letterSpacing: '0.025em' }],
        '3xl': ['48px', { lineHeight: '40px', letterSpacing: '0.025em' }],
        '4xl': ['56px', { lineHeight: '58px', letterSpacing: '0.025em' }],
        '5xl': ['64px', { lineHeight: '66px', letterSpacing: '0.025em' }],
        '6xl': ['72px', { lineHeight: '74px', letterSpacing: '0.025em' }],


        // Tipografía nueva
        'h1': ['72px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h2': ['64px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h3': ['56px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h4': ['48px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h5': ['40px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h6': ['32px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'h7': ['24px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'body-large': ['20px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'body-regular': ['16px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'body-small': ['14px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'caption': ['12px', { lineHeight: '120%', letterSpacing: '0.025em' }],
        'small': ['10px', { lineHeight: '120%', letterSpacing: '0.025em' }],
      },
      
      // Pesos tipográficos
      fontWeight: {
        'light': '300',
        'normal': '400',
        'semibold': '600',
        'bold': '700',
        'black': '900',

        // Pesos tipográficos nuevos
        'light': '300',
        'regular': '400',
        'medium': '600',
        'bold': '700',
        'extrabold': '800',
      },
      colors: {


        // ---- Escala de blancos (renombrada)
        brandWhite: {
          50:  '#fdfdff',
          100: '#f2f1fd',
          200: '#eceafc',
          300: '#e8e6fb',
          400: '#8e8c99',
        },

        // ---- Neutrales
        brandNeutral: {
          50:  '#e8e8e8',
          100: '#9f9fa1',
          200: '#77777a',
          300: '#3d3c40',
          400: '#151419',
          500: '#0d0c0f',
        },

        // ---- Success (verde emerald)
        brandSuccess: {
          50:  '#d1fae5',
          100: '#6ee7b7',
          200: '#10b981',
          300: '#047857',
          400: '#064e3b',
        },

        // ---- Warning (amber)
        brandWarning: {
          50:  '#fef3c7',
          100: '#fcd34d',
          200: '#f59e0b',
          300: '#b45309',
          400: '#78350f',
        },

        // ---- Error (rojo)
        brandError: {
          50:  '#fee2e2',
          100: '#fca5a5',
          200: '#ef4444',
          300: '#b91c1c',
          400: '#7f1d1d',
        },

        // ---- Info (cyan/blue)
        brandInfo: {
          50:  '#e0f2fe',
          100: '#7dd3fc',
          200: '#0ea5e9',
          300: '#0369a1',
          400: '#0c4a6e',
        },

        // ---- Brand Primary (indigo/violet)
        brandPrimary: {
          50:  '#e0e7ff',
          100: '#a5b4fc',
          200: '#6366f1',
          300: '#4338ca',
          400: '#312e81',
        },

        // ---- Brand Secondary (pink/magenta)
        brandSecondary: {
          50:  '#fbcfe8',
          100: '#f472b6',
          200: '#ec4899',
          300: '#be185d',
          400: '#831843',
        },

        primary: {
          50: '#fbe9f6',
          75: '#f0a6db',
          100: '#ea82cc',
          200: '#e04cb6',
          300: '#da27a7',
          400: '#991b75',
          500: '#851866',
        },
        secondary: {
          50: '#e6e8ed',
          75: '#96a2b4',
          100: '#6b7b95',
          200: '#2b4267',
          300: '#001b48',
          400: '#001332',
          500: '#00102c',
        },

        // Paleta Error (Rojo nuevo)

        error: {
          50: '#fdeaec',
          75: '#f8a9b3',
          100: '#f58693',
          200: '#f05265',
          300: '#ed2e45',
          400: '#a62030',
          500: '#911c2a',
        },

        // Paleta Info (Azul nuevo)
        info: {
          50: '#e6e6ff',
          75: '#9696ff',
          100: '#6b6bfe',
          200: '#2b2bfe',
          300: '#0000fe',
          400: '#0000b2',
          500: '#00009b',
        },

        // Paleta Success (Verde nuevo)
        success: {
          50: '#e6f9f1',
          75: '#96e8c4',
          100: '#6bdfab',
          200: '#2bd187',
          300: '#00c76f',
          400: '#008b4e',
          500: '#007944',
        },

        // Paleta Warning (Amarillo nuevo)
        warning: {
          50: '#fff7e7',
          75: '#ffdd9c',
          100: '#ffcf73',
          200: '#ffbb36',
          300: '#ffad0d',
          400: '#b37909',
          500: '#9c6a08',
        },

        // Paleta Texto (Negro nuevo)
        black: {
          50: '#e8e8e9',
          75: '#a2a2a3',
          100: '#7b7b7d',
          200: '#434344',
          300: '#1c1c1e',
          400: '#141415',
          500: '#111112',
        },

        // Paleta Disabled (Grises nuevos)
        disabled: {
          50: '#fdfdfd',
          75: '#f8f8f8',
          100: '#f6f6f6',
          200: '#f2f2f2',
          300: '#efefef',
          400: '#a7a7a7',
          500: '#929292',
        },


        // Paleta Accent (Blanco nuevo)
        accent: {
          50: '#fdfdff',
          75: '#f6f5fd',
          100: '#f2f1fd',
          200: '#eceafc',
          300: '#e8e6fb',
          400: '#a2a1b0',
          500: '#8e8c99',
        },

        // Paleta Gray (Alias que combina white/black según reglas de diseño)
        grayer: {
          50: '#F0F0F0',   // Del sistema black
          100: '#EFF6FD',  // Del sistema white
          200: '#E8F2FC',  // Del sistema white
          300: '#DEECFB',  // Del sistema white
          400: '#7b7b7d',  // Del sistema black
          500: '#434344',  // Del sistema black
          600: '#3A4550',  // Del sistema white
          700: '#1c1c1e',  // Del sistema black
          800: '#141415',  // Del sistema black
          900: '#111112',  // Del sistema black
        },



      },
    },
  },
  plugins: [
    require('@tailwindcss/forms')({
      strategy: 'base', // Aplica estilos base a todos los inputs automáticamente
    }),
    // Plugin personalizado para soportar not-placeholder-shown (floating labels)
    function({ addVariant }) {
      addVariant('not-placeholder-shown', '&:not(:placeholder-shown)');
    },
    // Preline UI plugin (condicional para evitar errores de build)
    ...(function() {
      try {
        return [require('preline/plugin')];
      } catch (e) {
        console.warn('Preline plugin not available:', e.message);
        return [];
      }
    })()
  ],
  darkMode: 'class', // Asumo que usas dark mode basado en tus clases `dark:bg-neutral-600`
}