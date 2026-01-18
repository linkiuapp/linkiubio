<?php

/**
 * SCRIPT PELIGROSO: Purga toda la cola de Redis
 * 
 * ⚠️  ADVERTENCIA: Esto eliminará TODOS los jobs pendientes
 * 
 * Uso:
 * php purge_queue.php confirm
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Verificar confirmación
if (!isset($argv[1]) || $argv[1] !== 'confirm') {
    echo "⚠️  ADVERTENCIA: Este script eliminará TODOS los jobs pendientes en la cola.\n\n";
    echo "Si estás SEGURO de que quieres hacer esto, ejecuta:\n";
    echo "php purge_queue.php confirm\n\n";
    echo "Recomendación: Primero ejecuta 'php inspect_queue.php' para ver qué hay en la cola.\n";
    exit(1);
}

echo "🗑️  Purgando cola de Redis...\n\n";

$redis = \Illuminate\Support\Facades\Redis::connection();
$queueName = 'queues:default';

$totalJobs = $redis->llen($queueName);

echo "📊 Jobs antes de purgar: $totalJobs\n";

if ($totalJobs == 0) {
    echo "✅ La cola ya está vacía.\n";
    exit(0);
}

echo "⏳ Eliminando...\n";

// Purgar la cola
$redis->del($queueName);

$remainingJobs = $redis->llen($queueName);

echo "✅ Cola purgada!\n";
echo "📊 Jobs eliminados: " . ($totalJobs - $remainingJobs) . "\n";
echo "📊 Jobs restantes: $remainingJobs\n\n";

if ($remainingJobs == 0) {
    echo "🎉 La cola está completamente vacía ahora.\n";
    echo "👉 Puedes probar de nuevo el validador de comprobantes.\n";
} else {
    echo "⚠️  Aún quedan jobs. Intenta ejecutar de nuevo.\n";
}
