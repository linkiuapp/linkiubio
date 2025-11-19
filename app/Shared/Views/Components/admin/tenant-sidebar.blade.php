@php
    // Usar el servicio para construir el sidebar según el vertical
    $sidebarBuilder = new \App\Shared\Services\SidebarBuilderService($store);
    $sidebarItems = $sidebarBuilder->buildTenantAdminSidebar();
    $footer = $sidebarBuilder->buildFooter();
@endphp

{{-- COMPONENT: Sidebar Content Push --}}
<x-sidebar-content-push 
    sidebar-id="tenant-admin-sidebar"
    :items="$sidebarItems"
    :footer="$footer"
    :show-toggle="true"
/>
