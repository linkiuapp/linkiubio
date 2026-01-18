<?php

/**
 * Script de prueba para verificar que el worker funciona
 * 
 * Uso en Laravel Cloud:
 * php test_queue_worker.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test 1: Verificar conexión a Redis
echo "📡 Test 1: Verificando conexión a Redis...\n";
try {
    $redis = \Illuminate\Support\Facades\Redis::connection();
    $redis->ping();
    echo "✅ Redis está funcionando\n\n";
} catch (\Exception $e) {
    echo "❌ Redis no funciona: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Verificar configuración de queue
echo "📋 Test 2: Configuración de Queue:\n";
echo "  - Driver: " . config('queue.default') . "\n";
echo "  - Conexión Redis: " . config('queue.connections.redis.connection') . "\n";
echo "  - Cola por defecto: " . config('queue.connections.redis.queue') . "\n";
echo "  - Retry after: " . config('queue.connections.redis.retry_after') . "s\n\n";

// Test 3: Despachar un job de prueba
echo "🚀 Test 3: Despachando job de prueba...\n";

class TestQueueJob implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use \Illuminate\Foundation\Queue\Queueable;

    public function __construct()
    {
        $this->onQueue('default');
    }

    public function handle(): void
    {
        \Illuminate\Support\Facades\Log::info('✅ TestQueueJob ejecutado correctamente!', [
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

try {
    TestQueueJob::dispatch();
    echo "✅ Job despachado correctamente a la cola 'default'\n";
    echo "👀 Ahora revisa los logs de Laravel Cloud para ver si aparece:\n";
    echo "   '✅ TestQueueJob ejecutado correctamente!'\n\n";
} catch (\Exception $e) {
    echo "❌ Error despachando job: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 4: Verificar cuántos jobs hay en la cola
echo "📊 Test 4: Verificando cola de Redis...\n";
try {
    $queueName = config('queue.connections.redis.queue', 'default');
    $fullQueueName = 'queues:' . $queueName;
    
    $jobsCount = $redis->llen($fullQueueName);
    echo "  - Jobs pendientes en 'default': " . $jobsCount . "\n";
    
    if ($jobsCount > 0) {
        echo "✅ Hay jobs en la cola esperando ser procesados\n";
        echo "⚠️  Si el worker está corriendo, debería procesarlos en segundos\n";
    } else {
        echo "ℹ️  No hay jobs pendientes (o ya fueron procesados)\n";
    }
} catch (\Exception $e) {
    echo "❌ Error verificando cola: " . $e->getMessage() . "\n";
}

echo "\n✅ Test completado!\n";
echo "👉 Si el TestQueueJob NO aparece en los logs, el worker NO está funcionando.\n";
