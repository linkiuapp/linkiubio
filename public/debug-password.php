<?php
require_once "../vendor/autoload.php";
$app = require_once "../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header("Content-Type: text/plain");

echo "=== DIAGNÓSTICO DE CONTRASEÑA ===\n\n";

try {
    $emailConfig = App\Shared\Models\EmailConfiguration::getActive();
    if ($emailConfig) {
        echo "Password encrypted: " . $emailConfig->getAttributes()["smtp_password"] . "\n";
        echo "Password decrypted: " . $emailConfig->smtp_password . "\n";
        echo "Password length: " . strlen($emailConfig->smtp_password) . "\n";
        echo "Expected password: t1fChP1pYbDYVt80e6\n";
        echo "Passwords match: " . ($emailConfig->smtp_password === "t1fChP1pYbDYVt80e6" ? "YES" : "NO") . "\n\n";
        
        echo "Config after applyToMail:\n";
        $emailConfig->applyToMail();
        echo "Config password: " . config("mail.mailers.smtp.password") . "\n";
        echo "Config password length: " . strlen(config("mail.mailers.smtp.password")) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== FIN ===";
?>
