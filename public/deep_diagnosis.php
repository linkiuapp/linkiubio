<?php
require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>Diagnóstico Profundo CLI vs WEB</h1>";

echo "<h2>1. Usuario y contexto:</h2>";
echo "PHP SAPI: " . php_sapi_name() . "<br>";
echo "User (posix): " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : 'N/A') . "<br>";
echo "User (env): " . ($_ENV['USER'] ?? 'NO SET') . "<br>";
echo "Home (env): " . ($_ENV['HOME'] ?? 'NO SET') . "<br>";

echo "<h2>2. Variables de entorno completas MAIL:</h2>";
foreach ($_ENV as $key => $value) {
    if (strpos($key, 'MAIL_') === 0) {
        echo "$key: " . ($key === 'MAIL_PASSWORD' ? '***' : $value) . "<br>";
    }
}

echo "<h2>3. Raw fsockopen test:</h2>";
$socket = @fsockopen('ssl://mail.linkiu.email', 465, $errno, $errstr, 10);
if ($socket) {
    echo "✅ fsockopen SSL: OK<br>";
    fclose($socket);
} else {
    echo "❌ fsockopen SSL: $errstr ($errno)<br>";
}

echo "<h2>4. Raw stream_socket_client test:</h2>";
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ]
]);
$socket = @stream_socket_client('ssl://mail.linkiu.email:465', $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);
if ($socket) {
    echo "✅ stream_socket_client SSL: OK<br>";
    fclose($socket);
} else {
    echo "❌ stream_socket_client SSL: $errstr ($errno)<br>";
}

echo "<h2>5. Config vs ENV comparison:</h2>";
echo "MAIL_HOST env: " . (getenv('MAIL_HOST') ?: 'NO') . "<br>";
echo "MAIL_HOST config: " . config('mail.mailers.smtp.host') . "<br>";
echo "MAIL_PASSWORD env: " . (getenv('MAIL_PASSWORD') ? 'YES' : 'NO') . "<br>";
echo "MAIL_PASSWORD config: " . (config('mail.mailers.smtp.password') ? 'YES' : 'NO') . "<br>";
?>
