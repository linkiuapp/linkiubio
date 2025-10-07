<?php
require_once "../vendor/autoload.php";
$app = require_once "../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header("Content-Type: text/plain");

echo "=== DIAGNÓSTICO WEB SIMPLE ===\n\n";

try {
    echo "1. CONFIGURACIÓN ACTUAL:\n";
    echo "Host: " . config("mail.mailers.smtp.host") . "\n";
    echo "Username: " . config("mail.mailers.smtp.username") . "\n\n";

    echo "2. EMAIL CONFIGURATION:\n";
    $emailConfig = App\Shared\Models\EmailConfiguration::getActive();
    if ($emailConfig) {
        echo "✅ Configuración encontrada\n";
        echo "Host: " . $emailConfig->smtp_host . "\n";
        echo "Username: " . $emailConfig->smtp_username . "\n\n";
    } else {
        echo "❌ No configuración\n\n";
    }

    echo "3. PROBAR SEND TEST EMAIL:\n";
    $result = App\Services\EmailService::sendTestEmail("mrgrafista@gmail.com");
    echo "Success: " . ($result["success"] ? "SÍ" : "NO") . "\n";
    echo "Message: " . $result["message"] . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== FIN ===";
?>
