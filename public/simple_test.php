<?php
echo "<h1>Test Simple</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "SAPI: " . php_sapi_name() . "<br>";

// Test básico sin Laravel
try {
    echo "Working Directory: " . getcwd() . "<br>";
    echo "Script: " . __FILE__ . "<br>";
    
    // Verificar si existe autoload
    if (file_exists('/home/wwlink/linkiubio_app/vendor/autoload.php')) {
        echo "Autoload exists: YES<br>";
        require '/home/wwlink/linkiubio_app/vendor/autoload.php';
        echo "Autoload loaded: YES<br>";
    } else {
        echo "Autoload exists: NO<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
