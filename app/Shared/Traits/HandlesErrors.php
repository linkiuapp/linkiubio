<?php

namespace App\Shared\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

trait HandlesErrors
{
    /**
     * Manejar error y devolver respuesta apropiada
     */
    protected function handleError(\Exception $e, string $userMessage = null, string $context = ''): JsonResponse|RedirectResponse
    {
        // Log del error completo
        Log::error("Error en {$context}: " . $e->getMessage(), [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'user' => auth()->user()?->email,
            'url' => request()->fullUrl()
        ]);
        
        // Mensaje amigable para el usuario
        $message = $userMessage ?? $this->getUserFriendlyMessage($e);
        
        // Si es una petición AJAX/JSON
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'error_code' => $this->getErrorCode($e)
            ], $this->getHttpStatusCode($e));
        }
        
        // Si es una petición web normal
        return back()
            ->withInput()
            ->with('error', $message);
    }
    
    /**
     * Obtener mensaje amigable según el tipo de error
     */
    private function getUserFriendlyMessage(\Exception $e): string
    {
        // Errores de validación
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return 'Por favor, verifica los datos ingresados.';
        }
        
        // Errores de base de datos
        if ($e instanceof \Illuminate\Database\QueryException) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return 'Este registro ya existe. Por favor, verifica los datos.';
            }
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                return 'No se puede realizar esta acción porque hay registros relacionados.';
            }
            return 'Error al procesar la información. Por favor, intenta nuevamente.';
        }
        
        // Errores de autorización
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return 'No tienes permisos para realizar esta acción.';
        }
        
        // Errores de modelo no encontrado
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return 'El registro solicitado no fue encontrado.';
        }
        
        // Error genérico
        return 'Ha ocurrido un error inesperado. Por favor, intenta nuevamente o contacta soporte si el problema persiste.';
    }
    
    /**
     * Obtener código de error para tracking
     */
    private function getErrorCode(\Exception $e): string
    {
        return 'ERR_' . strtoupper(substr(md5(get_class($e)), 0, 6));
    }
    
    /**
     * Obtener código HTTP apropiado
     */
    private function getHttpStatusCode(\Exception $e): int
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return 422;
        }
        
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return 403;
        }
        
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return 404;
        }
        
        return 500;
    }
    
    /**
     * Manejar operación con try-catch automático
     */
    protected function tryOperation(callable $operation, string $successMessage = null, string $errorMessage = null)
    {
        try {
            $result = $operation();
            
            if ($successMessage) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $successMessage,
                        'data' => $result
                    ]);
                }
                
                return is_a($result, RedirectResponse::class) 
                    ? $result->with('success', $successMessage)
                    : redirect()->back()->with('success', $successMessage);
            }
            
            return $result;
            
        } catch (\Exception $e) {
            return $this->handleError($e, $errorMessage, debug_backtrace()[1]['function'] ?? 'unknown');
        }
    }
}


