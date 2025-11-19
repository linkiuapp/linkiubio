# Ecommerce Vertical

## Descripción

El vertical **Ecommerce** utiliza únicamente las funcionalidades **Core** del sistema. No tiene controllers adicionales específicos.

## Funcionalidades Disponibles

Todas las funcionalidades Core están disponibles para Ecommerce:

- ✅ Dashboard
- ✅ Pedidos
- ✅ Categorías
- ✅ Variables
- ✅ Productos
- ✅ Gestión de Envíos
- ✅ Métodos de Pago
- ✅ Sedes
- ✅ Notificaciones de WhatsApp
- ✅ Diseño de Tienda
- ✅ Cupones
- ✅ Sliders
- ✅ Soporte y Tickets
- ✅ Anuncios de Linkiu
- ✅ Mi Cuenta
- ✅ Clave Maestra
- ✅ Perfil del Negocio
- ✅ Facturación

## Controllers Core Utilizados

Todos los controllers en `app/Features/TenantAdmin/Controllers/Core/` están disponibles para tiendas con vertical `ecommerce`.

## Notas

- Este vertical no requiere controllers adicionales
- La lógica específica de Ecommerce se maneja en los controllers Core
- El sidebar se construye automáticamente según el vertical usando `SidebarBuilderService`
