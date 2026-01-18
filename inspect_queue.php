<?php

/**
 * Inspeccionar qué jobs hay en la cola de Redis
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Inspeccionando cola de Redis...\n\n";

$redis = \Illuminate\Support\Facades\Redis::connection();
$queueName = 'queues:default';

// Obtener los primeros 10 jobs
$jobs = $redis->lrange($queueName, 0, 9);

echo "📊 Total de jobs en cola: " . $redis->llen($queueName) . "\n\n";
echo "📋 Primeros 10 jobs:\n";
echo str_repeat('=', 80) . "\n\n";

$jobTypes = [];

foreach ($jobs as $index => $job) {
    $decoded = json_decode($job, true);
    
    if (isset($decoded['displayName'])) {
        $jobType = $decoded['displayName'];
        $jobTypes[$jobType] = ($jobTypes[$jobType] ?? 0) + 1;
        
        echo ($index + 1) . ". " . $jobType . "\n";
        
        // Mostrar tiempo de creación si existe
        if (isset($decoded['pushedAt'])) {
            $pushedAt = date('Y-m-d H:i:s', $decoded['pushedAt']);
            echo "   Creado: $pushedAt\n";
        }
        
        echo "\n";
    }
}

echo str_repeat('=', 80) . "\n\n";
echo "📈 Resumen de tipos de jobs (muestra):\n";
foreach ($jobTypes as $type => $count) {
    echo "  - $type: $count jobs\n";
}

echo "\n💡 Recomendación:\n";
echo "Si la mayoría son SendEmailJob antiguos, considera purgar la cola.\n";
echo "Si son jobs importantes (ValidatePaymentProofJob, OptimizeImageJob), aumenta workers.\n";
