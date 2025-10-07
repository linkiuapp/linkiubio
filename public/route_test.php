<?php
require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "<h1>Test de Rutas SuperLinkiu</h1>";

try {
    echo "<h2>Rutas disponibles:</h2><ul>";
    
    // Listar rutas de superlinkiu
    $routes = collect(app('router')->getRoutes())->filter(function($route) {
        return str_contains($route->getName() ?? '', 'superlinkiu');
    });
    
    foreach ($routes->take(15) as $route) {
        echo "<li><strong>" . ($route->getName() ?? 'sin nombre') . "</strong> → /" . $route->uri() . "</li>";
    }
    echo "</ul>";
    
    echo "<h2>URLs importantes:</h2>";
    echo "<ul>";
    echo "<li><a href='" . route('superlinkiu.login', [], false) . "'>Login SuperLinkiu</a></li>";
    echo "<li><a href='" . route('superlinkiu.email.index', [], false) . "'>Email Dashboard</a></li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<h2 style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
