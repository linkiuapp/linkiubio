<?php
require_once "../vendor/autoload.php";
$app = require_once "../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header("Content-Type: text/plain");

echo "=== DIAGNÓSTICO COMPLETO SMTP ===\n\n";

try {
    $emailConfig = App\Shared\Models\EmailConfiguration::getActive();
    
    echo "1. ANTES de applyToMail():\n";
    echo "Host: " . config("mail.mailers.smtp.host") . "\n";
    echo "Port: " . config("mail.mailers.smtp.port") . "\n";
    echo "Username: " . config("mail.mailers.smtp.username") . "\n";
    echo "Password: " . config("mail.mailers.smtp.password") . "\n";
    echo "Encryption: " . config("mail.mailers.smtp.encryption") . "\n";
    echo "Verify Peer: " . (config("mail.mailers.smtp.verify_peer") ? "true" : "false") . "\n\n";
    
    if ($emailConfig) {
        $emailConfig->applyToMail();
        
        echo "2. DESPUÉS de applyToMail():\n";
        echo "Host: " . config("mail.mailers.smtp.host") . "\n";
        echo "Port: " . config("mail.mailers.smtp.port") . "\n";
        echo "Username: " . config("mail.mailers.smtp.username") . "\n";
        echo "Password: " . config("mail.mailers.smtp.password") . "\n";
        echo "Encryption: " . config("mail.mailers.smtp.encryption") . "\n";
        echo "Verify Peer: " . (config("mail.mailers.smtp.verify_peer") ? "true" : "false") . "\n\n";
        
        // Aplicar configuración SSL como en EmailService
        config([
            "mail.mailers.smtp.verify_peer" => false,
            "mail.mailers.smtp.verify_peer_name" => false,
            "mail.mailers.smtp.allow_self_signed" => true,
        ]);
        
        echo "3. DESPUÉS de configuración SSL:\n";
        echo "Verify Peer: " . (config("mail.mailers.smtp.verify_peer") ? "true" : "false") . "\n";
        echo "Verify Peer Name: " . (config("mail.mailers.smtp.verify_peer_name") ? "true" : "false") . "\n";
        echo "Allow Self Signed: " . (config("mail.mailers.smtp.allow_self_signed") ? "true" : "false") . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== FIN ===";
?>
