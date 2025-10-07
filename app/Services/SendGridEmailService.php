<?php

namespace App\Services;

use App\Models\EmailConfiguration;
use SendGrid;
use SendGrid\Mail\Mail;
use Illuminate\Support\Facades\Log;

class SendGridEmailService
{
    private ?SendGrid $client = null;
    private ?EmailConfiguration $config = null;

    public function __construct()
    {
        $this->config = EmailConfiguration::getActive();
        
        if ($this->config && $this->config->sendgrid_api_key) {
            try {
                $this->client = new SendGrid($this->config->sendgrid_api_key);
            } catch (\Exception $e) {
                Log::error('Error inicializando SendGrid: ' . $e->getMessage());
            }
        }
    }

    /**
     * Validar API Key de SendGrid
     */
    public function validateApiKey(string $apiKey): array
    {
        try {
            $sg = new SendGrid($apiKey);
            
            // Intentar obtener información de la cuenta para validar
            $response = $sg->client->user()->profile()->get();
            
            if ($response->statusCode() === 200) {
                $body = json_decode($response->body(), true);
                
                return [
                    'success' => true,
                    'message' => 'API Key válida',
                    'account_info' => [
                        'email' => $body['email'] ?? null,
                        'username' => $body['username'] ?? null
                    ]
                ];
            }
            
            return [
                'success' => false,
                'message' => 'API Key inválida',
                'error' => $response->body()
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error validando API Key',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validar un template ID y obtener sus variables
     */
    public function validateTemplate(string $templateId): array
    {
        if (!$this->client) {
            return [
                'success' => false,
                'message' => 'SendGrid no está configurado'
            ];
        }

        try {
            // Log para debugging
            Log::info('Intentando validar template', [
                'template_id' => $templateId,
                'has_client' => !is_null($this->client)
            ]);
            
            // Obtener información del template
            $response = $this->client->client->templates()->_($templateId)->get();
            
            Log::info('Respuesta de SendGrid', [
                'status' => $response->statusCode(),
                'body' => $response->body()
            ]);
            
            if ($response->statusCode() === 200) {
                $template = json_decode($response->body(), true);
                
                // Obtener la versión activa del template
                $activeVersion = null;
                if (isset($template['versions']) && is_array($template['versions'])) {
                    foreach ($template['versions'] as $version) {
                        if (isset($version['active']) && $version['active'] == 1) {
                            $activeVersion = $version;
                            break;
                        }
                    }
                }
                
                // Extraer variables del contenido HTML
                $variables = [];
                if ($activeVersion) {
                    $html = $activeVersion['html_content'] ?? '';
                    $subject = $activeVersion['subject'] ?? '';
                    $plainText = $activeVersion['plain_content'] ?? '';
                    
                    // Buscar variables en formato {{variable}} o {{ variable }}
                    $content = $html . ' ' . $subject . ' ' . $plainText;
                    // Regex mejorada para capturar solo nombres de variables válidos (letras, números, guiones bajos)
                    preg_match_all('/\{\{\s*([a-zA-Z_][a-zA-Z0-9_]*)\s*\}\}/', $content, $matches);
                    
                    if (!empty($matches[1])) {
                        $variables = array_unique($matches[1]);
                        // Limpiar espacios
                        $variables = array_map('trim', $variables);
                        // Filtrar variables de sistema de SendGrid
                        $variables = array_filter($variables, function($var) {
                            $systemVars = ['unsubscribe', 'unsubscribe_preferences', 'weblink', 'sender_name', 'sender_address'];
                            return !in_array(strtolower($var), $systemVars);
                        });
                        $variables = array_values($variables); // Reindexar
                    }
                }
                
                Log::info('Template validado exitosamente', [
                    'template_name' => $template['name'] ?? 'Sin nombre',
                    'variables_found' => count($variables),
                    'variables' => $variables
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Template válido',
                    'template_name' => $template['name'] ?? 'Sin nombre',
                    'variables' => $variables,
                    'active_version' => $activeVersion ? ($activeVersion['name'] ?? 'Active') : null
                ];
            }
            
            Log::warning('Template no encontrado', [
                'template_id' => $templateId,
                'status_code' => $response->statusCode(),
                'response_body' => $response->body()
            ]);
            
            return [
                'success' => false,
                'message' => 'Template no encontrado. Código: ' . $response->statusCode(),
                'status_code' => $response->statusCode(),
                'details' => json_decode($response->body(), true)
            ];
            
        } catch (\Exception $e) {
            Log::error('Excepción validando template', [
                'template_id' => $templateId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error validando template: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Enviar email usando template dinámico
     */
    public function sendWithTemplate(string $templateId, string $to, array $variables = [], string $toName = null, string $category = 'store_management'): array
    {
        if (!$this->client || !$this->config) {
            return [
                'success' => false,
                'message' => 'SendGrid no está configurado'
            ];
        }

        try {
            // Determinar el email remitente según la categoría
            $fromEmail = $this->getSenderEmailByCategory($category);
            $fromName = $this->config->from_name ?? 'Linkiu';
            
            Log::info('Preparando envío de email', [
                'template_id' => $templateId,
                'to' => $to,
                'from_email' => $fromEmail,
                'from_name' => $fromName,
                'category' => $category,
                'variables' => $variables
            ]);
            
            $email = new Mail();
            
            // Configurar remitente con el email de la categoría
            $email->setFrom($fromEmail, $fromName);
            
            // Configurar template
            $email->setTemplateId($templateId);
            
            // Crear personalization manualmente para evitar problemas con arrays
            $personalization = new \SendGrid\Mail\Personalization();
            $personalization->addTo(new \SendGrid\Mail\To($to, $toName ?? $to));
            
            // Agregar variables dinámicas correctamente
            if (!empty($variables)) {
                // Asegurar que todas las variables sean strings simples
                foreach ($variables as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $value = json_encode($value);
                    }
                    $personalization->addDynamicTemplateData($key, (string)$value);
                }
            }
            
            $email->addPersonalization($personalization);
            
            Log::info('Enviando email a SendGrid...');
            
            // Enviar
            $response = $this->client->send($email);
            
            Log::info('Respuesta de SendGrid para envío', [
                'status_code' => $response->statusCode(),
                'body' => $response->body()
            ]);
            
            if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
                // Actualizar estadísticas
                $this->updateStats('sent');
                
                return [
                    'success' => true,
                    'message' => 'Email enviado exitosamente',
                    'message_id' => $response->headers()['X-Message-Id'] ?? null
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Error enviando email. Código: ' . $response->statusCode(),
                'status_code' => $response->statusCode(),
                'error' => $response->body()
            ];
            
        } catch (\Exception $e) {
            Log::error('Excepción enviando email con SendGrid', [
                'template_id' => $templateId,
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Error enviando email: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Enviar email de prueba con datos dummy
     */
    public function sendTestEmail(string $templateId, string $to, string $templateType): array
    {
        // Obtener variables dummy según el tipo de template
        $dummyData = $this->getDummyData($templateType);
        
        // Agregar indicador de que es un email de prueba
        $dummyData['test_mode'] = 'ESTE ES UN EMAIL DE PRUEBA';
        
        // Determinar la categoría según el tipo de template
        $category = $this->getCategoryFromTemplateType($templateType);
        
        return $this->sendWithTemplate($templateId, $to, $dummyData, 'Test User', $category);
    }

    /**
     * Obtener email remitente según la categoría
     */
    private function getSenderEmailByCategory(string $category): string
    {
        if (!$this->config) {
            return 'noreply@linkiu.email';
        }

        return match($category) {
            'tickets' => $this->config->sender_tickets ?? 'soporte@linkiu.email',
            'billing' => $this->config->sender_billing ?? 'facturas@linkiu.email',
            'store_management' => $this->config->sender_store_management ?? 'tiendas@linkiu.email',
            default => $this->config->sender_store_management ?? 'tiendas@linkiu.email'
        };
    }

    /**
     * Determinar categoría según el tipo de template
     */
    private function getCategoryFromTemplateType(string $templateType): string
    {
        if (str_starts_with($templateType, 'ticket_')) {
            return 'tickets';
        }
        
        if (str_starts_with($templateType, 'invoice_') || str_starts_with($templateType, 'payment_')) {
            return 'billing';
        }
        
        return 'store_management';
    }

    /**
     * Obtener datos dummy para pruebas según el tipo de template
     */
    private function getDummyData(string $templateType): array
    {
        $dummyData = [
            // Gestión de Tiendas
            'store_created' => [
                'first_name' => 'Juan',
                'store_name' => 'Tienda de Prueba',
                'owner_name' => 'Juan Pérez',
                'admin_email' => 'admin@tiendaprueba.com',
                'admin_password' => 'Password123!',
                'login_url' => 'https://linkiu.com/admin/login',
                'plan_name' => 'Plan Explorer'
            ],
            'store_verified' => [
                'first_name' => 'Juan',
                'store_name' => 'Tienda de Prueba',
                'owner_name' => 'Juan Pérez',
                'verification_date' => date('d/m/Y')
            ],
            'store_suspended' => [
                'first_name' => 'Juan',
                'store_name' => 'Tienda de Prueba',
                'owner_name' => 'Juan Pérez',
                'suspension_reason' => 'Falta de pago',
                'support_email' => 'soporte@linkiu.com'
            ],
            'store_reactivated' => [
                'first_name' => 'Juan',
                'store_name' => 'Tienda de Prueba',
                'owner_name' => 'Juan Pérez',
                'reactivation_date' => date('d/m/Y')
            ],
            'plan_changed' => [
                'first_name' => 'Juan',
                'store_name' => 'Tienda de Prueba',
                'owner_name' => 'Juan Pérez',
                'old_plan' => 'Plan Explorer',
                'new_plan' => 'Plan Master',
                'change_date' => date('d/m/Y')
            ],
            
            // Tickets
            'ticket_response' => [
                'first_name' => 'Juan',
                'ticket_number' => 'TK-2024-001',
                'ticket_title' => 'Problema con el catálogo',
                'response_content' => 'Hemos revisado tu caso y encontramos la solución...',
                'responder_name' => 'Agente de Soporte',
                'ticket_url' => 'https://linkiu.com/tickets/TK-2024-001'
            ],
            'ticket_resolved' => [
                'first_name' => 'Juan',
                'ticket_number' => 'TK-2024-001',
                'ticket_title' => 'Problema con el catálogo',
                'resolution_date' => date('d/m/Y'),
                'resolution_summary' => 'El problema fue resuelto actualizando la configuración...'
            ],
            'ticket_assigned' => [
                'first_name' => 'Juan',
                'ticket_number' => 'TK-2024-001',
                'ticket_title' => 'Problema con el catálogo',
                'assigned_to' => 'María García',
                'priority' => 'Alta'
            ],
            
            // Facturación
            'invoice_generated' => [
                'first_name' => 'Juan',
                'invoice_number' => 'INV-2024-001',
                'amount' => '$50.00',
                'due_date' => date('d/m/Y', strtotime('+15 days')),
                'store_name' => 'Tienda de Prueba',
                'invoice_url' => 'https://linkiu.com/invoices/INV-2024-001'
            ],
            'payment_confirmed' => [
                'first_name' => 'Juan',
                'invoice_number' => 'INV-2024-001',
                'amount' => '$50.00',
                'payment_date' => date('d/m/Y'),
                'payment_method' => 'Transferencia bancaria',
                'next_due_date' => date('d/m/Y', strtotime('+30 days'))
            ],
            'invoice_overdue' => [
                'first_name' => 'Juan',
                'invoice_number' => 'INV-2024-001',
                'amount' => '$50.00',
                'days_overdue' => '5',
                'payment_url' => 'https://linkiu.com/pay/INV-2024-001',
                'suspension_date' => date('d/m/Y', strtotime('+5 days'))
            ]
        ];

        return $dummyData[$templateType] ?? [];
    }

    /**
     * Actualizar estadísticas de envío
     */
    private function updateStats(string $action): void
    {
        if (!$this->config) return;

        $stats = $this->config->stats ?? [];
        
        if (!isset($stats[$action])) {
            $stats[$action] = 0;
        }
        
        $stats[$action]++;
        $stats['last_' . $action] = now()->toISOString();
        
        $this->config->update(['stats' => $stats]);
    }

    /**
     * Métodos helper para enviar emails específicos
     */
    public function sendStoreCreatedEmail($store, $admin, $password)
    {
        $config = EmailConfiguration::getActive();
        if (!$config || !$config->template_store_created) {
            Log::warning('Template store_created no configurado');
            return false;
        }

        return $this->sendWithTemplate(
            $config->template_store_created,
            $admin->email,
            [
                'store_name' => $store->name,
                'owner_name' => $admin->name,
                'admin_email' => $admin->email,
                'admin_password' => $password,
                'login_url' => route('tenant.admin.login', $store->slug),
                'plan_name' => $store->plan->name ?? 'Sin plan'
            ],
            $admin->name
        );
    }

    public function sendInvoicePaidEmail($invoice)
    {
        $config = EmailConfiguration::getActive();
        if (!$config || !$config->template_payment_confirmed) {
            Log::warning('Template payment_confirmed no configurado');
            return false;
        }

        $store = $invoice->store;
        $admin = $store->admins()->first();
        
        if (!$admin) {
            Log::warning('No se encontró admin para la tienda ' . $store->id);
            return false;
        }

        return $this->sendWithTemplate(
            $config->template_payment_confirmed,
            $admin->email,
            [
                'invoice_number' => $invoice->invoice_number,
                'amount' => '$' . number_format($invoice->amount, 2),
                'payment_date' => $invoice->paid_date->format('d/m/Y'),
                'payment_method' => 'Manual',
                'next_due_date' => $invoice->due_date->addMonth()->format('d/m/Y'),
                'store_name' => $store->name
            ],
            $admin->name
        );
    }

    // Agregar más métodos helper según necesites...
}
