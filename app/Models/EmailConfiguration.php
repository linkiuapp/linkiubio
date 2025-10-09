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
                        'name' => 'Nueva tienda creada',
                        'description' => 'Se envía cuando se crea una nueva tienda',
                        'required_vars' => [
                            'store_name' => 'Nombre de la tienda',
                            'owner_name' => 'Nombre del dueño',
                            'admin_email' => 'Email del administrador',
                            'admin_password' => 'Contraseña generada',
                            'login_url' => 'URL para iniciar sesión',
                            'plan_name' => 'Nombre del plan contratado'
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
                    ]
                ]
            ],
            'tickets' => [
                'title' => 'Tickets de Soporte',
                'templates' => [
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
                    ]
                ]
            ]
        ];
    }
}
