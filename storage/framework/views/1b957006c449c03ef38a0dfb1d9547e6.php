<?php
    // Usar el servicio para construir el sidebar de SuperAdmin
    $sidebarBuilder = new \App\Shared\Services\SidebarBuilderService();
    $sidebarItems = $sidebarBuilder->buildSuperAdminSidebar();
    $footer = $sidebarBuilder->buildSuperAdminFooter();
?>


<?php if (isset($component)) { $__componentOriginal865bd2cb1b4f3989fa8eebcafb926fd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal865bd2cb1b4f3989fa8eebcafb926fd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Sidebar.SidebarContentPush','data' => ['sidebarId' => 'super-admin-sidebar','items' => $sidebarItems,'footer' => $footer,'showToggle' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-content-push'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['sidebar-id' => 'super-admin-sidebar','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sidebarItems),'footer' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($footer),'show-toggle' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal865bd2cb1b4f3989fa8eebcafb926fd7)): ?>
<?php $attributes = $__attributesOriginal865bd2cb1b4f3989fa8eebcafb926fd7; ?>
<?php unset($__attributesOriginal865bd2cb1b4f3989fa8eebcafb926fd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal865bd2cb1b4f3989fa8eebcafb926fd7)): ?>
<?php $component = $__componentOriginal865bd2cb1b4f3989fa8eebcafb926fd7; ?>
<?php unset($__componentOriginal865bd2cb1b4f3989fa8eebcafb926fd7); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/admin/sidebar.blade.php ENDPATH**/ ?>