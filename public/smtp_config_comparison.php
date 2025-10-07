<?php
require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>Comparación Configuración SMTP Detallada</h1>";

echo "<h2>1. Configuración Mail Manager:</h2>";
$mailManager = app('mail.manager');
$mailer = $mailManager->mailer('smtp');
echo "Mail Manager creado: " . (is_object($mailManager) ? 'YES' : 'NO') . "<br>";

echo "<h2>2. Configuración SMTP del Manager:</h2>";
$config = config('mail.mailers.smtp');
echo "<pre>";
print_r($config);
echo "</pre>";

echo "<h2>3. Test directo con Swift/Symfony:</h2>";
try {
    $transport = new Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport(
        config('mail.mailers.smtp.host'),
        config('mail.mailers.smtp.port'),
        config('mail.mailers.smtp.encryption') === 'ssl'
    );
    
    $transport->setUsername(config('mail.mailers.smtp.username'));
    $transport->setPassword(config('mail.mailers.smtp.password'));
    
    echo "Transport creado: YES<br>";
    
    // Test de conexión
    $transport->start();
    echo "✅ Transport started successfully<br>";
    
} catch (Exception $e) {
    echo "❌ Transport error: " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "File: " . basename($e->getFile()) . "<br>";
}

echo "<h2>4. Verificar Mail From Config:</h2>";
echo "From Address: " . config('mail.from.address') . "<br>";
echo "From Name: " . config('mail.from.name') . "<br>";

echo "<h2>5. Debug configureSMTP():</h2>";
// Llamar el método directamente para debug
echo "Llamando configureSMTP...<br>";
try {
    // Acceder al método privado usando reflection
    $reflection = new ReflectionClass('App\Services\EmailService');
    $method = $reflection->getMethod('configureSMTP');
    $method->setAccessible(true);
    $method->invoke(null);
    
    echo "✅ configureSMTP ejecutado<br>";
    
    // Ver qué configuración quedó después
    $newConfig = config('mail.mailers.smtp');
    echo "<h3>Config después de configureSMTP:</h3>";
    echo "<pre>";
    print_r($newConfig);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "❌ configureSMTP error: " . htmlspecialchars($e->getMessage()) . "<br>";
}
