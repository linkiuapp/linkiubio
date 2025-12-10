<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Monitoring Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración del sistema de monitoreo de la aplicación.
    |
    */

    'enabled' => env('MONITORING_ENABLED', false),
    'log_traffic' => env('MONITORING_LOG_TRAFFIC', false),
    'log_errors' => env('MONITORING_LOG_ERRORS', true),
];

