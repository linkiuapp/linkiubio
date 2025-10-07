@php
use Illuminate\Support\Facades\Storage;
use App\Shared\Models\BillingSetting;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name', 'Linkiu.bio')}} - @yield('title', 'Super Linkiu')</title>
    
    <!-- Favicon -->
    @php
        // ✅ LEER DESDE BASE DE DATOS (persistente)
        $settings = BillingSetting::getInstance();
        $appFavicon = $settings->app_favicon;
        
        $faviconSrc = asset('favicon.ico'); // Default
        
        if ($appFavicon) {
            try {
                // ✅ Usar Storage::url() siempre - funciona en local Y en S3/Laravel Cloud
                $faviconSrc = Storage::disk('public')->url($appFavicon);
            } catch (\Exception $e) {
                \Log::error('Error generando URL de favicon en layout', [
                    'favicon_path' => $appFavicon,
                    'error' => $e->getMessage()
                ]);
            }
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconSrc }}">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter bg-black-50/70">
    <x-admin-sidebar />
    <x-admin-navbar />
    
    <!-- Main content -->
    <main class="main-content">
        @yield('content')
    </main>

    <x-admin-footer />
    
    @stack('scripts')
</body>
</html>