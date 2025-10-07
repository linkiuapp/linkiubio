<?php
echo "<h1>Test Laravel SMTP</h1>";

try {
    require '../vendor/autoload.php';
    echo "✅ Autoload loaded<br>";
    
    $app = require '../bootstrap/app.php';
    echo "✅ App loaded<br>";
    
    $app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();
    echo "✅ Laravel bootstrapped<br>";
    
    echo "<h2>Configuración SMTP:</h2>";
    echo "Host: " . config('mail.mailers.smtp.host', 'NULL') . "<br>";
    echo "Port: " . config('mail.mailers.smtp.port', 'NULL') . "<br>";
    echo "Username: " . config('mail.mailers.smtp.username', 'NULL') . "<br>";
    echo "Password: " . (config('mail.mailers.smtp.password') ? 'CONFIGURADA' : 'NULL') . "<br>";
    echo "Encryption: " . config('mail.mailers.smtp.encryption', 'NULL') . "<br>";
    
    echo "<h2>Test EmailService desde WEB:</h2>";
    $result = App\Services\EmailService::sendTestEmail('mrgrafista@gmail.com');
    echo 'Resultado: ' . ($result['success'] ? '<b style="color:green">ÉXITO</b>' : '<b style="color:red">ERROR</b>') . "<br>";
    if (!$result['success']) {
        echo 'Error: ' . htmlspecialchars($result['message']) . "<br>";
    }
    
    echo "<h2>Test Controlador desde WEB:</h2>";
    $controller = new App\Features\SuperLinkiu\Controllers\EmailController();
    $request = new Illuminate\Http\Request();
    $request->merge(['test_email' => 'mrgrafista@gmail.com']);
    
    $response = $controller->sendTest($request);
    $data = $response->getData(true);
    echo 'Controlador resultado: ' . ($data['success'] ? '<b style="color:green">ÉXITO</b>' : '<b style="color:red">ERROR</b>') . "<br>";
    if (!$data['success']) {
        echo 'Controlador error: ' . htmlspecialchars($data['message']) . "<br>";
    }
    
} catch (Exception $e) {
    echo "<b style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</b><br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
}
