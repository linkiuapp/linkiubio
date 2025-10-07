<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Services\SendGridEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailConfigurationController extends Controller
{
    private SendGridEmailService $sendGridService;

    public function __construct()
    {
        $this->sendGridService = new SendGridEmailService();
    }

    /**
     * Mostrar la vista de configuración
     */
    public function index()
    {
        $config = EmailConfiguration::first() ?? new EmailConfiguration();
        $templateTypes = EmailConfiguration::getTemplateTypes();
        
        return view('superlinkiu::email.configuration', compact('config', 'templateTypes'));
    }

    /**
     * Validar y guardar API Key
     */
    public function validateApiKey(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string'
        ]);

        $service = new SendGridEmailService();
        $result = $service->validateApiKey($request->api_key);

        if ($result['success']) {
            // Guardar o actualizar configuración
            $config = EmailConfiguration::first() ?? new EmailConfiguration();
            $config->sendgrid_api_key = $request->api_key;
            $config->api_validated_at = now();
            $config->is_active = true;
            $config->save();

            return response()->json([
                'success' => true,
                'message' => 'API Key validada y guardada exitosamente',
                'account_info' => $result['account_info'] ?? null
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'error' => $result['error'] ?? null
        ], 400);
    }

    /**
     * Validar un template específico
     */
    public function validateTemplate(Request $request)
    {
        $request->validate([
            'template_id' => 'required|string',
            'template_type' => 'required|string'
        ]);

        $result = $this->sendGridService->validateTemplate($request->template_id);

        if ($result['success']) {
            // Guardar template ID y variables
            $config = EmailConfiguration::first();
            if ($config) {
                $templateField = 'template_' . $request->template_type;
                $varsField = 'template_' . $request->template_type . '_vars';
                
                $config->$templateField = $request->template_id;
                $config->$varsField = $result['variables'];
                $config->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Template validado exitosamente',
                'template_name' => $result['template_name'],
                'variables' => $result['variables']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'error' => $result['error'] ?? null
        ], 400);
    }

    /**
     * Enviar email de prueba
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'template_id' => 'required|string',
            'template_type' => 'required|string',
            'test_email' => 'required|email'
        ]);

        $result = $this->sendGridService->sendTestEmail(
            $request->template_id,
            $request->test_email,
            $request->template_type
        );

        if ($result['success']) {
            // Guardar email de prueba
            $config = EmailConfiguration::first();
            if ($config) {
                $testEmails = $config->test_emails ?? [];
                $testEmails[] = [
                    'email' => $request->test_email,
                    'template' => $request->template_type,
                    'sent_at' => now()->toISOString()
                ];
                $config->test_emails = $testEmails;
                $config->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Email de prueba enviado exitosamente a ' . $request->test_email
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'error' => $result['error'] ?? null
        ], 400);
    }

    /**
     * Guardar configuración general
     */
    public function saveConfiguration(Request $request)
    {
        $request->validate([
            'from_email' => 'required|email',
            'from_name' => 'required|string|max:255'
        ]);

        $config = EmailConfiguration::first() ?? new EmailConfiguration();
        $config->from_email = $request->from_email;
        $config->from_name = $request->from_name;
        $config->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración guardada exitosamente'
        ]);
    }

    /**
     * Guardar configuración de remitentes por categoría
     */
    public function saveSenderConfig(Request $request)
    {
        $request->validate([
            'verified_domain' => 'required|string',
            'sender_store_management' => 'required|email',
            'sender_tickets' => 'required|email',
            'sender_billing' => 'required|email'
        ]);

        $config = EmailConfiguration::first() ?? new EmailConfiguration();
        $config->verified_domain = $request->verified_domain;
        $config->sender_store_management = $request->sender_store_management;
        $config->sender_tickets = $request->sender_tickets;
        $config->sender_billing = $request->sender_billing;
        $config->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración de remitentes guardada exitosamente'
        ]);
    }

    /**
     * Obtener estadísticas de envío
     */
    public function getStats()
    {
        $config = EmailConfiguration::first();
        
        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'No hay configuración'
            ]);
        }

        return response()->json([
            'success' => true,
            'stats' => $config->stats ?? [],
            'is_active' => $config->is_active,
            'api_validated_at' => $config->api_validated_at
        ]);
    }

    /**
     * Desactivar SendGrid (volver a sistema anterior)
     */
    public function deactivate()
    {
        $config = EmailConfiguration::first();
        
        if ($config) {
            $config->is_active = false;
            $config->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'SendGrid desactivado. Usando sistema de email anterior.'
        ]);
    }
}
