<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    protected $fillable = [
        'sendgrid_api_key',
        'is_active',
        'api_validated_at',
        'from_email',
        'from_name',
        'verified_domain',
        'sender_store_management',
        'sender_tickets',
        'sender_billing',
        
        // Templates de Gestión de Tiendas
        'template_store_created',
        'template_store_created_vars',
        'template_store_verified',
        'template_store_verified_vars',
        'template_store_suspended',
        'template_store_suspended_vars',
        'template_store_reactivated',
        'template_store_reactivated_vars',
        'template_plan_changed',
        'template_plan_changed_vars',
        
        // Templates de Aprobación de Tiendas
        'template_store_pending_review',
        'template_store_pending_review_vars',
        'template_store_approved',
        'template_store_approved_vars',
        'template_store_rejected',
        'template_store_rejected_vars',
        'template_new_store_request_superadmin',
        'template_new_store_request_superadmin_vars',
        
        // Templates de Tickets
        'template_ticket_response',
        'template_ticket_response_vars',
        'template_ticket_resolved',
        'template_ticket_resolved_vars',
        'template_ticket_assigned',
        'template_ticket_assigned_vars',
        
        // Templates de Facturación
        'template_invoice_generated',
        'template_invoice_generated_vars',
        'template_payment_confirmed',
        'template_payment_confirmed_vars',
        'template_invoice_overdue',
        'template_invoice_overdue_vars',
        
        // Templates Nuevos
        'template_ticket_created_tenant',
        'template_ticket_created_tenant_vars',
        'template_ticket_created_superadmin',
        'template_ticket_created_superadmin_vars',
        'template_subscription_expiring_soon',
        'template_subscription_expiring_soon_vars',
        'template_password_changed_confirmation',
        'template_password_changed_confirmation_vars',
        'template_resend_store_credentials',
        'template_resend_store_credentials_vars',
        
        'test_emails',
        'stats'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'api_validated_at' => 'datetime',
        'template_store_created_vars' => 'array',
        'template_store_verified_vars' => 'array',
        'template_store_suspended_vars' => 'array',
        'template_store_reactivated_vars' => 'array',
        'template_plan_changed_vars' => 'array',
        'template_store_pending_review_vars' => 'array',
        'template_store_approved_vars' => 'array',
        'template_store_rejected_vars' => 'array',
        'template_new_store_request_superadmin_vars' => 'array',
        'template_ticket_response_vars' => 'array',
        'template_ticket_resolved_vars' => 'array',
        'template_ticket_assigned_vars' => 'array',
        'template_invoice_generated_vars' => 'array',
        'template_payment_confirmed_vars' => 'array',
        'template_invoice_overdue_vars' => 'array',
        'template_ticket_created_tenant_vars' => 'array',
        'template_ticket_created_superadmin_vars' => 'array',
        'template_subscription_expiring_soon_vars' => 'array',
        'template_password_changed_confirmation_vars' => 'array',
        'template_resend_store_credentials_vars' => 'array',
        'test_emails' => 'array',
        'stats' => 'array'
    ];

    /**
     * Obtener la instancia activa de configuración
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Lista de todas las plantillas disponibles
     */
    public static function getTemplateTypes()
    {
        return [
            'store_management' => [
                'title' => 'Gestión de Tiendas',
                'templates' => [
                    'store_created' => [
                        'name' => 'Nueva tienda creada (SuperAdmin)',
                        'description' => 'Se envía cuando SuperAdmin crea una tienda manualmente (NO por solicitud)',
                        'required_vars' => [
                            'admin_name' => 'Nombre del administrador',
                            'store_name' => 'Nombre de la tienda',
                            'admin_email' => 'Email del administrador',
                            'admin_password' => 'Contraseña generada',
                            'login_url' => 'URL para iniciar sesión',
                            'store_url' => 'URL de la tienda',
                            'plan_name' => 'Nombre del plan contratado',
                            'support_email' => 'Email de soporte'
                        ]
                    ],
                    'store_verified' => [
                        'name' => 'Tienda verificada',
                        'description' => 'Se envía cuando se verifica una tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'owner_name' => 'Nombre del dueño',
                            'verification_date' => 'Fecha de verificación'
                        ]
                    ],
                    'store_suspended' => [
                        'name' => 'Tienda suspendida',
                        'description' => 'Se envía cuando se suspende una tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'owner_name' => 'Nombre del dueño',
                            'suspension_reason' => 'Razón de la suspensión',
                            'support_email' => 'Email de soporte'
                        ]
                    ],
                    'store_reactivated' => [
                        'name' => 'Tienda reactivada',
                        'description' => 'Se envía cuando se reactiva una tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'owner_name' => 'Nombre del dueño',
                            'reactivation_date' => 'Fecha de reactivación'
                        ]
                    ],
                    'plan_changed' => [
                        'name' => 'Cambio de plan',
                        'description' => 'Se envía cuando cambia el plan de una tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'owner_name' => 'Nombre del dueño',
                            'old_plan' => 'Plan anterior',
                            'new_plan' => 'Plan nuevo',
                            'change_date' => 'Fecha del cambio'
                        ]
                    ],
                    'store_pending_review' => [
                        'name' => 'Solicitud en revisión',
                        'description' => 'Se envía cuando una solicitud de tienda queda pendiente de revisión',
                        'required_vars' => [
                            'admin_name' => 'Nombre del administrador',
                            'store_name' => 'Nombre de la tienda',
                            'business_type' => 'Tipo de negocio',
                            'business_document_type' => 'Tipo de documento',
                            'business_document_number' => 'Número de documento',
                            'estimated_time' => 'Tiempo estimado de revisión',
                            'support_email' => 'Email de soporte'
                        ]
                    ],
                    'store_approved' => [
                        'name' => 'Solicitud de tienda aprobada',
                        'description' => 'Se envía cuando SuperAdmin aprueba una solicitud de tienda pendiente',
                        'required_vars' => [
                            'admin_name' => 'Nombre del administrador',
                            'store_name' => 'Nombre de la tienda',
                            'admin_email' => 'Email del administrador',
                            'admin_password' => 'Contraseña de acceso',
                            'login_url' => 'URL de acceso al panel',
                            'store_url' => 'URL de la tienda',
                            'plan_name' => 'Nombre del plan',
                            'approval_date' => 'Fecha de aprobación',
                            'support_email' => 'Email de soporte'
                        ]
                    ],
                    'store_rejected' => [
                        'name' => 'Tienda rechazada',
                        'description' => 'Se envía cuando una solicitud de tienda es rechazada',
                        'required_vars' => [
                            'admin_name' => 'Nombre del administrador',
                            'store_name' => 'Nombre de la tienda',
                            'rejection_reason' => 'Motivo del rechazo',
                            'rejection_message' => 'Mensaje detallado',
                            'can_reapply_date' => 'Fecha en que puede re-aplicar',
                            'appeal_email' => 'Email para apelar'
                        ]
                    ],
                    'new_store_request' => [
                        'name' => 'Nueva solicitud (SuperAdmin)',
                        'description' => 'Notifica al SuperAdmin sobre nuevas solicitudes de tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'business_type' => 'Tipo de negocio',
                            'business_document_type' => 'Tipo de documento',
                            'business_document_number' => 'Número de documento',
                            'admin_name' => 'Nombre del administrador',
                            'admin_email' => 'Email del administrador',
                            'created_at' => 'Fecha de creación',
                            'review_url' => 'URL para revisar'
                        ]
                    ]
                ]
            ],
            'tickets' => [
                'title' => 'Tickets de Soporte',
                'templates' => [
                    'ticket_created_tenant' => [
                        'name' => 'Ticket creado (Tenant Admin)',
                        'description' => 'Confirmación al Tenant Admin cuando crea un ticket',
                        'required_vars' => [
                            'user_name' => 'Nombre del usuario',
                            'store_name' => 'Nombre de la tienda',
                            'ticket_number' => 'Número del ticket',
                            'ticket_title' => 'Título del ticket',
                            'ticket_content' => 'Contenido del ticket',
                            'priority' => 'Prioridad',
                            'created_at' => 'Fecha de creación',
                            'estimated_response_time' => 'Tiempo estimado de respuesta',
                            'ticket_url' => 'URL del ticket'
                        ]
                    ],
                    'ticket_created_superadmin' => [
                        'name' => 'Nuevo ticket (SuperAdmin)',
                        'description' => 'Notifica al SuperAdmin cuando se crea un nuevo ticket',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'user_name' => 'Nombre del usuario',
                            'user_email' => 'Email del usuario',
                            'ticket_number' => 'Número del ticket',
                            'ticket_title' => 'Título del ticket',
                            'ticket_content' => 'Contenido del ticket (primeros 200 caracteres)',
                            'priority' => 'Prioridad',
                            'created_at' => 'Fecha de creación',
                            'ticket_url' => 'URL para revisar ticket'
                        ]
                    ],
                    'ticket_response' => [
                        'name' => 'Nueva respuesta en ticket',
                        'description' => 'Se envía cuando hay una respuesta en un ticket',
                        'required_vars' => [
                            'ticket_number' => 'Número del ticket',
                            'ticket_title' => 'Título del ticket',
                            'response_content' => 'Contenido de la respuesta',
                            'responder_name' => 'Nombre de quien responde',
                            'ticket_url' => 'URL del ticket'
                        ]
                    ],
                    'ticket_resolved' => [
                        'name' => 'Ticket resuelto',
                        'description' => 'Se envía cuando se resuelve un ticket',
                        'required_vars' => [
                            'ticket_number' => 'Número del ticket',
                            'ticket_title' => 'Título del ticket',
                            'resolution_date' => 'Fecha de resolución',
                            'resolution_summary' => 'Resumen de la solución'
                        ]
                    ],
                    'ticket_assigned' => [
                        'name' => 'Ticket asignado',
                        'description' => 'Se envía cuando se asigna un ticket a un agente',
                        'required_vars' => [
                            'ticket_number' => 'Número del ticket',
                            'ticket_title' => 'Título del ticket',
                            'assigned_to' => 'Asignado a',
                            'priority' => 'Prioridad'
                        ]
                    ]
                ]
            ],
            'billing' => [
                'title' => 'Facturación',
                'templates' => [
                    'invoice_generated' => [
                        'name' => 'Factura generada',
                        'description' => 'Se envía cuando se genera una nueva factura',
                        'required_vars' => [
                            'invoice_number' => 'Número de factura',
                            'amount' => 'Monto total',
                            'due_date' => 'Fecha de vencimiento',
                            'store_name' => 'Nombre de la tienda',
                            'invoice_url' => 'URL de la factura'
                        ]
                    ],
                    'payment_confirmed' => [
                        'name' => 'Pago confirmado',
                        'description' => 'Se envía cuando se confirma un pago',
                        'required_vars' => [
                            'invoice_number' => 'Número de factura',
                            'amount' => 'Monto pagado',
                            'payment_date' => 'Fecha de pago',
                            'payment_method' => 'Método de pago',
                            'next_due_date' => 'Próximo vencimiento'
                        ]
                    ],
                    'invoice_overdue' => [
                        'name' => 'Factura vencida',
                        'description' => 'Se envía cuando una factura está vencida',
                        'required_vars' => [
                            'invoice_number' => 'Número de factura',
                            'amount' => 'Monto adeudado',
                            'days_overdue' => 'Días de atraso',
                            'payment_url' => 'URL para pagar',
                            'suspension_date' => 'Fecha de posible suspensión'
                        ]
                    ],
                    'subscription_expiring_soon' => [
                        'name' => 'Suscripción por vencer',
                        'description' => 'Alerta al admin de tienda cuando su suscripción está por vencer (7 días antes)',
                        'required_vars' => [
                            'admin_name' => 'Nombre del admin',
                            'store_name' => 'Nombre de la tienda',
                            'plan_name' => 'Nombre del plan',
                            'expiration_date' => 'Fecha de vencimiento',
                            'days_remaining' => 'Días restantes',
                            'renewal_amount' => 'Monto de renovación',
                            'payment_url' => 'URL para pagar',
                            'support_email' => 'Email de soporte',
                            'support_phone' => 'Teléfono de soporte'
                        ]
                    ]
                ]
            ],
            'security' => [
                'title' => 'Seguridad y Accesos',
                'templates' => [
                    'password_changed_confirmation' => [
                        'name' => 'Contraseña cambiada',
                        'description' => 'Confirma que la contraseña fue actualizada exitosamente',
                        'required_vars' => [
                            'user_name' => 'Nombre del usuario',
                            'change_date' => 'Fecha del cambio',
                            'ip_address' => 'IP desde donde se cambió',
                            'device_info' => 'Información del dispositivo',
                            'support_email' => 'Email de soporte si no fue el usuario'
                        ]
                    ],
                    'resend_store_credentials' => [
                        'name' => 'Reenviar accesos de tienda',
                        'description' => 'Reenvía las credenciales de acceso a la tienda (desde edición de tienda en SuperAdmin)',
                        'required_vars' => [
                            'admin_name' => 'Nombre del admin',
                            'store_name' => 'Nombre de la tienda',
                            'admin_email' => 'Email del admin',
                            'login_url' => 'URL de acceso al panel',
                            'store_url' => 'URL de la tienda',
                            'plan_name' => 'Nombre del plan',
                            'note' => 'Nota adicional (ej: "Tus credenciales fueron reenviadas por solicitud del SuperAdmin")',
                            'support_email' => 'Email de soporte'
                        ]
                    ]
                ]
            ]
        ];
    }
}
