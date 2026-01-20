<?php

namespace App\Services;

use OpenAI;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Servicio para generar descripciones de herramientas usando IA
 */
class ToolDescriptionService
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
        $this->maxTokens = 300;
        $this->temperature = 0.7;
    }

    /**
     * Generar descripción general de la herramienta
     * 
     * @param string $toolName Nombre de la herramienta
     * @param string|null $category Categoría (opcional)
     * @return array ['success' => bool, 'description' => string, 'error' => string|null]
     */
    public function generateDescription(string $toolName, ?string $category = null): array
    {
        try {
            $prompt = $this->buildDescriptionPrompt($toolName, $category);
            
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Eres un asistente experto en describir herramientas y servicios tecnológicos de forma clara y profesional.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            $description = is_object($response) 
                ? $response->choices[0]->message->content 
                : $response['choices'][0]['message']['content'];

            if (!$description) {
                throw new Exception('OpenAI no devolvió ninguna descripción');
            }

            Log::info('ToolDescriptionService: Descripción generada exitosamente', [
                'tool_name' => $toolName,
            ]);

            return [
                'success' => true,
                'description' => trim($description),
                'error' => null
            ];

        } catch (\Exception $e) {
            Log::error('ToolDescriptionService: Error generando descripción', [
                'tool_name' => $toolName,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'description' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generar descripción de uso en Linkiu
     * 
     * @param string $toolName Nombre de la herramienta
     * @param string $description Descripción general de la herramienta
     * @return array ['success' => bool, 'usage' => string, 'error' => string|null]
     */
    public function generateUsageInLinkiu(string $toolName, string $description): array
    {
        try {
            $prompt = $this->buildUsagePrompt($toolName, $description);
            
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Eres un asistente experto que explica cómo se usan herramientas tecnológicas en plataformas de e-commerce y gestión de negocios.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            $usage = is_object($response) 
                ? $response->choices[0]->message->content 
                : $response['choices'][0]['message']['content'];

            if (!$usage) {
                throw new Exception('OpenAI no devolvió ninguna descripción de uso');
            }

            Log::info('ToolDescriptionService: Uso en Linkiu generado exitosamente', [
                'tool_name' => $toolName,
            ]);

            return [
                'success' => true,
                'usage' => trim($usage),
                'error' => null
            ];

        } catch (\Exception $e) {
            Log::error('ToolDescriptionService: Error generando uso en Linkiu', [
                'tool_name' => $toolName,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'usage' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Construir prompt para descripción general
     */
    protected function buildDescriptionPrompt(string $toolName, ?string $category): string
    {
        $prompt = "Genera una descripción clara y concisa (máximo 150 palabras) sobre qué es y para qué sirve la herramienta: {$toolName}";
        
        if ($category) {
            $prompt .= " en la categoría de {$category}";
        }
        
        $prompt .= ".\n\n";
        $prompt .= "La descripción debe:\n";
        $prompt .= "1. Explicar qué es la herramienta\n";
        $prompt .= "2. Mencionar sus principales funcionalidades\n";
        $prompt .= "3. Ser clara y profesional\n";
        $prompt .= "4. Estar en español de Colombia\n";
        $prompt .= "5. NO usar emojis\n\n";
        $prompt .= "Descripción:";

        return $prompt;
    }

    /**
     * Construir prompt para uso en Linkiu
     */
    protected function buildUsagePrompt(string $toolName, string $description): string
    {
        $prompt = "Basándote en esta descripción de la herramienta:\n\n";
        $prompt .= "Nombre: {$toolName}\n";
        $prompt .= "Descripción: {$description}\n\n";
        $prompt .= "Genera una explicación clara (máximo 150 palabras) sobre cómo y para qué se usa esta herramienta específicamente en Linkiu, ";
        $prompt .= "que es una plataforma de e-commerce y gestión de negocios en línea.\n\n";
        $prompt .= "La explicación debe:\n";
        $prompt .= "1. Mencionar casos de uso específicos en Linkiu\n";
        $prompt .= "2. Explicar qué funcionalidades de Linkiu dependen de esta herramienta\n";
        $prompt .= "3. Ser clara y específica\n";
        $prompt .= "4. Estar en español de Colombia\n";
        $prompt .= "5. NO usar emojis\n\n";
        $prompt .= "Uso en Linkiu:";

        return $prompt;
    }
}
