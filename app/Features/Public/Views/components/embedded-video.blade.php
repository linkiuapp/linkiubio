@php
    // Detectar plataforma y extraer ID del video
    $videoId = null;
    $platform = null;
    
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        $platform = 'youtube';
        // Extraer ID de YouTube
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
    } elseif (strpos($url, 'vimeo.com') !== false) {
        $platform = 'vimeo';
        // Extraer ID de Vimeo
        if (preg_match('/vimeo\.com\/(?:.*\/)?(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
    }
@endphp

@if($videoId && $platform)
    <div class="relative w-full" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
        <iframe 
            src="{{ $platform === 'youtube' ? 'https://www.youtube.com/embed/' . $videoId : 'https://player.vimeo.com/video/' . $videoId }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            class="absolute top-0 left-0 w-full h-full rounded-lg"
            style="border: 0;">
        </iframe>
    </div>
@else
    <div class="bg-gray-100 rounded-lg p-8 text-center">
        <p class="text-gray-600">URL de video no válida. Por favor, usa YouTube o Vimeo.</p>
    </div>
@endif
