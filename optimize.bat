@echo off
echo ========================================
echo   OPTIMIZANDO LARAVEL PARA DESARROLLO
echo ========================================
echo.

echo [1/6] Limpiando cache anterior...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo.
echo [2/6] Optimizando Composer...
composer dump-autoload -o

echo.
echo [3/6] Cacheando configuracion...
php artisan config:cache

echo.
echo [4/6] Cacheando rutas...
php artisan route:cache

echo.
echo [5/6] Cacheando vistas...
php artisan view:cache

echo.
echo [6/6] Optimizando Laravel...
php artisan optimize

echo.
echo ========================================
echo   OPTIMIZACION COMPLETADA!
echo ========================================
echo.
echo Recomendaciones adicionales:
echo - Asegurate de que opcache este habilitado en php.ini
echo - Aumenta memory_limit en php.ini a 256M o mas
echo - Desactiva xdebug si no lo estas usando
echo.
pause


