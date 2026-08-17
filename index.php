<?php

/**
 * PUNTO DE ENTRADA PROVISORIO (Front Controller)
 * 
 * Activamos el reporte total de errores para el entorno de desarrollo y delegamos 
 * la ejecución al script de diagnóstico 'config/test-db.php'.
 */

// Forzar a PHP a mostrar errores en pantalla (Ideal para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// __DIR__ en la raíz apunta al directorio raíz del proyecto.
// Cargamos de forma segura el script de prueba ubicado en la carpeta config.
require_once __DIR__ . '/config/test-db.php';