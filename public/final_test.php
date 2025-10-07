<?php
require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>Test Final Deploy Completo</h1>";

echo "<h2>1. Configuración:</h2>";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host', 'NULL') . "<br>";
echo "MAIL_PASSWORD: " . (config('mail.mailers.smtp.password') ? 'CONFIGURADA' : 'NULL') . "<br>";
echo "APP_ENV: " . config('app.env') . "<br>";

echo "<h2>2. Test EmailService:</h2>";
try {
    $result = App\Services\EmailService::sendTestEmail('mrgrafista@gmail.com');
    echo 'Resultado: ' . ($result['success'] ? '<b style="color:green">ÉXITO</b>' : '<b style="color:red">ERROR</b>') . "<br>";
    if (!$result['success']) {
        echo 'Error: ' . htmlspecialchars($result['message']) . "<br>";
    }
} catch (Exception $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage()) . "<br>";
}

echo "<h2>3. Info del sistema:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Laravel Version: " . app()->version() . "<br>";
echo "Working Directory: " . getcwd() . "<br>";
