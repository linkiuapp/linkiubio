@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <div class="space-y-3">
        <h1 class="h3">¿Qué significa estar verificado en Linkiu?
        </h1>
        <div class="flex flex-col items-center justify-center mb-6">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_verified.svg" alt="img_linkiu_v1_verified" class="h-48 w-auto" loading="lazy">
        </div>

        <div class="body-small text-brandNeutral-400 text-justify">
            <p>
                El sello <strong class="text-brandSuccess-400">&lt;Verificado por Linkiu&gt;</strong> reconoce a las tiendas que han superado nuestro proceso de validación y revisión interna. Este distintivo representa transparencia, confianza y compromiso con el buen uso de la plataforma.
            </p>
            <div class="my-4">
                <span class="body-lg-bold text-brandNeutral-400 block mb-2">¿Qué significa que una tienda esté verificada?</span>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Ha confirmado su identidad y datos de contacto.</li>
                    <li>Cumple las políticas de publicación y uso responsable de Linkiu.</li>
                    <li>Mantiene coherencia entre la información registrada y lo que muestra en su catálogo.</li>
                </ul>
            </div>
            <p class="my-3">
                <span>
                    Este sello <strong class="text-brandSuccess-400">no implica aval financiero ni garantía comercial</strong> sobre transacciones externas, pero sí respalda que el negocio ha completado un proceso de verificación documental y de cumplimiento básico.
                </span>
            </p>
            <p class="caption text-brandNeutral-400 mt-3">
                Linkiu realiza revisiones periódicas para asegurar que las tiendas cumplan las políticas de buen uso y transparencia.<br>
                Nuestra meta es construir una comunidad confiable, en constante evolución y alineada con nuestros valores. Cualquier tienda que incurra en irregularidades podrá ser reportada y suspendida.
            </p>
        </div>
    </div>
    <div class="space-y-3">
        <h3 class="h3 text-brandNeutral-400">¿Cómo puedo verificar mi tienda?</h3>
        <p class="body-small text-brandNeutral-400 text-justify">
            Para verificar tu tienda, debes completar el formulario de verificación y enviar los documentos requeridos. Una vez que tu tienda haya sido verificada, podrás acceder a las funciones avanzadas de la plataforma.
        </p>
    </div>
</div>
@endsection