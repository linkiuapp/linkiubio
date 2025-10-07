<?php
require_once "../vendor/autoload.php";
$app = require_once "../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header("Content-Type: text/plain");

echo "=== DIAGNÓSTICO FINAL - FORZAR MAILER ===\n\n";

try {
    $emailConfig = App\Shared\Models\EmailConfiguration::getActive();
    
    if ($emailConfig) {
        // Aplicar configuración
        $emailConfig->applyToMail();
        
        // Configuración SSL
        config([
            "mail.mailers.smtp.verify_peer" => false,
            "mail.mailers.smtp.verify_peer_name" => false,
            "mail.mailers.smtp.allow_self_signed" => true,
            "mail.mailers.smtp.stream_options" => [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true,
                    "crypto_method" => STREAM_CRYPTO_METHOD_TLS_CLIENT,
                ]
            ]
        ]);
        
        echo "Configuración aplicada correctamente\n\n";
        
        // FORZAR recreación del mailer
        app()->forgetInstance("mail.manager");
        app()->forgetInstance("mailer");
        
        echo "Mailer instances cleared\n\n";
        
        // Probar envío
        use Illuminate\Support\Facades\Mail;
        
        Mail::raw("Test desde web context con mailer forzado", function ($message) {
            $message->to("mrgrafista@gmail.com")
                    ->subject("Test Web Context - Mailer Forzado")
                    ->from(config("mail.from.address"), config("mail.from.name"));
        });
        
        echo "✅ EMAIL ENVIADO EXITOSAMENTE!\n";
        
    } else {
        echo "❌ No hay configuración\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== FIN ===";
?>
