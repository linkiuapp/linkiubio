<?php
require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>Test Email via Script CLI</h1>";

$email = $_GET['email'] ?? 'mrgrafista@gmail.com';
$command = "cd /home/wwlink/linkiubio_app && php email_test_cli.php '$email' 2>&1";

exec($command, $output, $return_code);

echo "Email: " . htmlspecialchars($email) . "<br>";
echo "Return code: " . $return_code . "<br>";
echo "Output: <pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";

$json_output = end($output);
$data = json_decode($json_output, true);

if ($data && isset($data['success'])) {
    echo "Resultado: " . ($data['success'] ? '✅ <b style="color:green">ÉXITO VIA SCRIPT CLI</b>' : '❌ ERROR') . "<br>";
    echo "Mensaje: " . htmlspecialchars($data['message']) . "<br>";
}
?>
