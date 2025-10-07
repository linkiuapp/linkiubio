<?php
echo "=== DIAGNÓSTICO SIMPLE ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Working Directory: " . getcwd() . "\n";
echo "File exists: " . (file_exists("../app/Services/EmailService.php") ? "YES" : "NO") . "\n";
echo "=== FIN ===";
?>
