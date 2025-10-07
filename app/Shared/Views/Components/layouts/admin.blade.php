@php
use Illuminate\Support\Facades\Storage;
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
        $tempFavicon = session('temp_app_favicon');
        $appFavicon = $tempFavicon ?: env('APP_FAVICON');
        
        if ($appFavicon) {
            try {
                // Temporalmente simplificado para evitar problemas con fileinfo
                $faviconSrc = asset('storage/' . $appFavicon);
                /*
                if (config('filesystems.disks.s3.bucket')) {
                    $faviconSrc = Storage::disk('public')->url($appFavicon);
                } else {
                    $faviconSrc = asset('storage/' . $appFavicon);
                }
                */
            } catch (\Exception $e) {
                $faviconSrc = asset('storage/' . $appFavicon);
            }
        } else {
            $faviconSrc = asset('favicon.ico');
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