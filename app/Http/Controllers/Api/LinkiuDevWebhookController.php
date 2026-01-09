<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LinkiuDevWebhookController extends Controller
{
    /**
     * Procesar webhook de Infobip para respuestas de WhatsApp
     * 
     * Endpoint: POST /api/webhooks/linkiudev/whatsapp
     */
    public function handleInfobipWebhook(Request $request)
    {
        Log::info('LinkiuDev Webhook: Recibido', [
            'payload' => $request->all()
        ]);

        try {
            $results = $request->input('results', []);

            foreach ($results as $result) {
                $this->processMessage($result);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('LinkiuDev Webhook: Error procesando', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Procesar un mensaje individual
     */
    protected function processMessage(array $result): void
    {
        // Estructura de Infobip incoming message
        $from = $result['from'] ?? null;
        $messageId = $result['messageId'] ?? null;
        $content = $result['content'] ?? [];
        $contextMessageId = $result['context']['messageId'] ?? null; // ID del mensaje al que responde

        // El contenido puede ser texto o interactivo
        $text = null;
        
        if (isset($content['text'])) {
            $text = $content['text'];
        } elseif (isset($content['interactive']['buttonReply']['id'])) {
            // Si es respuesta a botón
            $text = $content['interactive']['buttonReply']['id'];
        } elseif (isset($content['interactive']['listReply']['id'])) {
            // Si es respuesta a lista
            $text = $content['interactive']['listReply']['id'];
        }

        if (!$from || !$text) {
            Log::warning('LinkiuDev Webhook: Mensaje sin from o text', [
                'result' => $result
            ]);
            return;
        }

        Log::info('LinkiuDev Webhook: Procesando mensaje', [
            'from' => $from,
            'text' => $text,
            'context_message_id' => $contextMessageId
        ]);

        // Si hay un mensaje de contexto (es una respuesta), procesarlo
        if ($contextMessageId) {
            $whatsappService = app(DevWhatsAppService::class);
            $result = $whatsappService->processWebhookResponse($contextMessageId, $from, $text);

            Log::info('LinkiuDev Webhook: Respuesta procesada', [
                'result' => $result
            ]);
        }
    }

    /**
     * Verificar estado del webhook (GET para configuración en Infobip)
     */
    public function verifyWebhook(Request $request)
    {
        // Infobip puede enviar una verificación GET
        return response()->json([
            'status' => 'active',
            'service' => 'LinkiuDev WhatsApp Webhook',
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Procesar delivery reports de Infobip
     */
    public function handleDeliveryReport(Request $request)
    {
        Log::info('LinkiuDev Webhook: Delivery Report', [
            'payload' => $request->all()
        ]);

        try {
            $results = $request->input('results', []);

            foreach ($results as $result) {
                $messageId = $result['messageId'] ?? null;
                $status = $result['status']['name'] ?? null;

                if ($messageId && $status) {
                    // Actualizar el log de notificación si existe
                    $log = \App\Features\SuperLinkiu\Models\DevNotificationLog::where('message_id', $messageId)->first();
                    
                    if ($log) {
                        $newStatus = match(strtoupper($status)) {
                            'DELIVERED' => 'delivered',
                            'SEEN', 'READ' => 'read',
                            'REJECTED', 'UNDELIVERABLE', 'EXPIRED' => 'failed',
                            default => $log->status
                        };

                        if ($newStatus !== $log->status) {
                            $log->update(['status' => $newStatus]);
                            
                            Log::info('LinkiuDev Webhook: Status actualizado', [
                                'message_id' => $messageId,
                                'old_status' => $log->status,
                                'new_status' => $newStatus
                            ]);
                        }
                    }
                }
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('LinkiuDev Webhook: Error en delivery report', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }
}
