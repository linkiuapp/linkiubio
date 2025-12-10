<?php

namespace App\Exceptions;

use App\Services\SystemDebugService;
use App\Jobs\LogErrorJob;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log error to database if monitoring is enabled
            $this->logErrorToDatabase($e);
            
            // Send automatic error notifications for critical errors
            $this->sendErrorNotification($e);
        });
    }

    /**
     * Log error to database
     */
    protected function logErrorToDatabase(Throwable $exception): void
    {
        // Solo loggear si está habilitado
        if (!env('MONITORING_ENABLED', false) || !env('MONITORING_LOG_ERRORS', false)) {
            return;
        }

        // Skip certain types of exceptions
        $skipExceptions = [
            \Illuminate\Http\Exceptions\HttpResponseException::class,
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Validation\ValidationException::class,
        ];

        foreach ($skipExceptions as $skipException) {
            if ($exception instanceof $skipException) {
                return;
            }
        }

        try {
            LogErrorJob::dispatch([
                'level' => $this->getErrorLevel($exception),
                'message' => $exception->getMessage(),
                'stack_trace' => $exception->getTraceAsString(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'route' => request()->route()?->getName(),
                'method' => request()->method(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
                'store_id' => request()->route('store')?->id,
                'context' => $this->getContext($exception),
                'request_data' => $this->sanitizeRequest(request()),
            ]);
        } catch (\Exception $e) {
            // No fallar si hay error al loggear
            Log::error('Failed to dispatch LogErrorJob', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get error level from exception
     */
    protected function getErrorLevel(Throwable $exception): string
    {
        if ($exception instanceof \ErrorException || 
            $exception instanceof \ParseError ||
            $exception instanceof \TypeError) {
            return 'ERROR';
        }

        if ($exception instanceof \Warning) {
            return 'WARNING';
        }

        return 'ERROR';
    }

    /**
     * Get context from exception
     */
    protected function getContext(Throwable $exception): array
    {
        $context = [];

        if (method_exists($exception, 'getContext')) {
            $context = $exception->getContext();
        }

        return array_merge($context, [
            'exception_class' => get_class($exception),
            'url' => request()->fullUrl(),
        ]);
    }

    /**
     * Sanitize request data
     */
    protected function sanitizeRequest($request): array
    {
        $data = $request->all();
        
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            'token',
            'api_key',
            'secret',
            'access_token',
            'refresh_token',
            'remember_token',
            'credit_card',
            'cvv',
            'card_number',
            '_token',
        ];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***REDACTED***';
            }
        }
        
        // Limitar tamaño
        if (count($data) > 20) {
            $data = array_slice($data, 0, 20, true);
            $data['_truncated'] = true;
        }
        
        return $data;
    }

    /**
     * Send error notification for critical errors
     */
    protected function sendErrorNotification(Throwable $exception): void
    {
        // Only send notifications for critical errors and if enabled
        if (!env('DEBUG_NOTIFICATIONS_ENABLED', false)) {
            return;
        }

        // Skip certain types of exceptions
        $skipExceptions = [
            \Illuminate\Http\Exceptions\HttpResponseException::class,
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Validation\ValidationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
        ];

        foreach ($skipExceptions as $skipException) {
            if ($exception instanceof $skipException) {
                return;
            }
        }

        // Only send for 500-level errors or specific critical exceptions
        $criticalExceptions = [
            \ErrorException::class,
            \ParseError::class,
            \TypeError::class,
            \ArgumentCountError::class,
            \ArithmeticError::class,
            \AssertionError::class,
        ];

        $isCritical = false;
        foreach ($criticalExceptions as $criticalException) {
            if ($exception instanceof $criticalException) {
                $isCritical = true;
                break;
            }
        }

        if (!$isCritical) {
            return;
        }

        try {
            $errorData = [
                'timestamp' => now()->toDateTimeString(),
                'level' => 'ERROR',
                'message' => $exception->getMessage(),
                'stack_trace' => $exception->getTraceAsString(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
            ];

            SystemDebugService::sendErrorNotification($errorData);
        } catch (\Exception $e) {
            // Don't let notification failures break the application
            Log::error('Failed to send error notification', [
                'notification_error' => $e->getMessage(),
                'original_error' => $exception->getMessage()
            ]);
        }
    }
}