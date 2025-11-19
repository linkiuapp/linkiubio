@php
    // Usar el servicio para construir el sidebar de SuperAdmin
    $sidebarBuilder = new \App\Shared\Services\SidebarBuilderService();
    $sidebarItems = $sidebarBuilder->buildSuperAdminSidebar();
    $footer = $sidebarBuilder->buildSuperAdminFooter();
@endphp

{{-- COMPONENT: Sidebar Content Push --}}
<x-sidebar-content-push 
    sidebar-id="super-admin-sidebar"
    :items="$sidebarItems"
    :footer="$footer"
    :show-toggle="true"
/>
