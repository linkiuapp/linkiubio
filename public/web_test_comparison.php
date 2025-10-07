<?php
// Script para acceso web directo
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>TEST WEB vs CLI</h1>";

echo "<h2>1. Configuración:</h2>";
echo "Config password: " . (config('mail.mailers.smtp.password') ? 'CONFIGURADA' : 'NULL') . "<br>";
echo "Config host: " . config('mail.mailers.smtp.host', 'NULL') . "<br>";
echo "Config port: " . config('mail.mailers.smtp.port', 'NULL') . "<br>";
echo "Config username: " . config('mail.mailers.smtp.username', 'NULL') . "<br>";

echo "<h2>2. PHP Info:</h2>";
echo "SAPI: " . php_sapi_name() . "<br>";
echo "User: " . get_current_user() . "<br>";
echo "UID: " . getmyuid() . "<br>";

echo "<h2>3. Test EmailService:</h2>";
try {
    $result = App\Services\EmailService::sendTestEmail('mrgrafista@gmail.com');
    echo 'EmailService resultado: ' . ($result['success'] ? 'ÉXITO' : 'ERROR') . "<br>";
    if (!$result['success']) {
        echo 'EmailService error: ' . htmlspecialchars($result['message']) . "<br>";
    }
} catch (Exception $e) {
    echo 'EmailService excepción: ' . htmlspecialchars($e->getMessage()) . "<br>";
}

echo "<h2>4. Test Controlador:</h2>";
try {
    $controller = new App\Features\SuperLinkiu\Controllers\EmailController();
    $request = new Illuminate\Http\Request();
    $request->merge(['test_email' => 'mrgrafista@gmail.com']);
    
    $response = $controller->sendTest($request);
    $data = $response->getData(true);
    echo 'Controlador resultado: ' . ($data['success'] ? 'ÉXITO' : 'ERROR') . "<br>";
    if (!$data['success']) {
        echo 'Controlador error: ' . htmlspecialchars($data['message']) . "<br>";
    }
} catch (Exception $e) {
    echo 'Controlador excepción: ' . htmlspecialchars($e->getMessage()) . "<br>";
}

echo "<h2>5. OPcache Info:</h2>";
if (function_exists('opcache_get_status')) {
    $opcache = opcache_get_status();
    echo "OPcache enabled: " . ($opcache ? 'YES' : 'NO') . "<br>";
    if ($opcache) {
        echo "OPcache hits: " . $opcache['opcache_statistics']['hits'] . "<br>";
        echo "OPcache cache_full: " . ($opcache['cache_full'] ? 'YES' : 'NO') . "<br>";
    }
} else {
    echo "OPcache not available<br>";
}
