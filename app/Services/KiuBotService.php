<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * KiuBot - Asistente para mejorar textos
 * 
 * Mejora descripciones de productos, corrige ortografía
 * y hace textos más atractivos y profesionales.
 */
class KiuBotService
{
    protected $client;
    protected $model;
    protected $maxTokens;
    protected $temperature;

    public function __construct()
    {
        $apiKey = config('services.openai.api_key');
        
        if (!$apiKey) {
            throw new Exception('OPENAI_API_KEY no está configurada en el archivo .env');
        }

        $this->client = OpenAI::client($apiKey);
        $this->model = config('services.openai.model', 'gpt-4o-mini');
        $this->maxTokens = (int) config('services.openai.max_tokens', 500);
        $this->temperature = (float) config('services.openai.temperature', 0.7);
    }

    /**
     * Mejorar descripción de producto
     * 
     * @param string $originalText Texto original a mejorar
     * @param string $productName Nombre del producto (opcional, para contexto)
     * @param string $vertical Vertical del negocio (restaurant, ecommerce, hotel)
     * @return array ['success' => bool, 'improved_text' => string, 'error' => string|null]
     */
    public function improveProductDescription(string $originalText, ?string $productName = null, string $vertical = 'ecommerce'): array
    {
        try {
            // Validar que el texto no esté vacío
            if (empty(trim($originalText))) {
                return [
                    'success' => false,
                    'improved_text' => null,
                    'error' => 'El texto original está vacío'
                ];
            }

            // Construir el prompt
            $prompt = $this->buildProductDescriptionPrompt($originalText, $productName, $vertical);
            
            // Construir el mensaje de sistema según el vertical
            $systemMessage = $this->buildSystemMessage($vertical);

            // Llamar a OpenAI
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemMessage
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            // Extraer el texto mejorado (manejar tanto array como objeto)
            $improvedText = null;
            
            if (is_array($response)) {
                $improvedText = $response['choices'][0]['message']['content'] ?? null;
            } elseif (is_object($response)) {
                $improvedText = $response->choices[0]->message->content ?? null;
            }

            if (!$improvedText) {
                throw new Exception('OpenAI no devolvió ningún texto. Respuesta: ' . json_encode($response));
            }

            // Log de éxito
            Log::info('KiuBot: Descripción mejorada exitosamente', [
                'original_length' => strlen($originalText),
                'improved_length' => strlen($improvedText),
                'model' => $this->model,
                'tokens_used' => $response->usage->totalTokens ?? 0
            ]);

            return [
                'success' => true,
                'improved_text' => trim($improvedText),
                'error' => null,
                'tokens_used' => $response->usage->totalTokens ?? 0
            ];

        } catch (Exception $e) {
            Log::error('KiuBot: Error al mejorar descripción', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'improved_text' => null,
                'error' => 'Error al comunicarse con KiuBot: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Construir mensaje de sistema según el vertical
     */
    protected function buildSystemMessage(string $vertical): string
    {
        $expertise = match($vertical) {
            'restaurant' => 'experto en gastronomía y restaurantes',
            'hotel' => 'experto en hotelería y turismo',
            default => 'experto en ecommerce y ventas online'
        };

        return "Eres KiuBot, un asistente {$expertise}. Tu objetivo es mejorar descripciones de productos/servicios haciéndolas más atractivas, persuasivas y profesionales. Creas descripciones que conectan emocionalmente con los clientes y los motivan a comprar. Mantienes un tono natural y correcto en español. Nunca uses emojis.";
    }

    /**
     * Construir el prompt para mejorar descripción de producto
     */
    protected function buildProductDescriptionPrompt(string $originalText, ?string $productName, string $vertical): string
    {
        $contextType = match($vertical) {
            'restaurant' => 'un menú de restaurante',
            'hotel' => 'servicios de hotel',
            default => 'un ecommerce'
        };

        $prompt = "Mejora la siguiente descripción de producto para {$contextType}:\n\n";
        
        if ($productName) {
            $prompt .= "**Producto:** {$productName}\n\n";
        }
        
        $prompt .= "**Descripción original:**\n{$originalText}\n\n";
        $prompt .= "**Instrucciones:**\n";
        $prompt .= "1. Corrige cualquier error ortográfico o gramatical\n";
        $prompt .= "2. Hazla más atractiva y persuasiva sin exagerar\n";
        $prompt .= "3. Crea una descripción que conecte emocionalmente y motive a comprar\n";
        $prompt .= "4. Mantén un tono profesional pero cercano\n";
        $prompt .= "5. Resalta los beneficios y el valor del producto\n";
        $prompt .= "6. Usa párrafos cortos y fáciles de leer\n";
        $prompt .= "7. Máximo 20 palabras\n";
        $prompt .= "8. Usa español de Colombia/Latinoamérica\n";
        $prompt .= "9. NO uses emojis\n";
        $prompt .= "10. Devuelve SOLO el texto mejorado, sin comentarios adicionales\n\n";
        $prompt .= "**Texto mejorado:**";

        return $prompt;
    }

    /**
     * Generar múltiples variaciones de un texto
     * 
     * @param string $originalText Texto original
     * @param int $variations Número de variaciones a generar (1-3)
     * @return array
     */
    public function generateVariations(string $originalText, int $variations = 2): array
    {
        $results = [];

        for ($i = 0; $i < min($variations, 3); $i++) {
            $result = $this->improveProductDescription($originalText);
            if ($result['success']) {
                $results[] = $result['improved_text'];
            }
        }

        return [
            'success' => !empty($results),
            'variations' => $results,
            'count' => count($results)
        ];
    }

    /**
     * Mejorar nombre de producto (futuro)
     */
    public function improveProductName(string $originalName): array
    {
        // TODO: Implementar mejora de nombres
        return [
            'success' => false,
            'error' => 'Función no implementada aún'
        ];
    }

    /**
     * Generar meta description SEO (futuro)
     */
    public function generateMetaDescription(string $productName, string $description): array
    {
        // TODO: Implementar generación de meta description
        return [
            'success' => false,
            'error' => 'Función no implementada aún'
        ];
    }
}

