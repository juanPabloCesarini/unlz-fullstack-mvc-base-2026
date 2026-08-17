<?php

/**
 * ARCHIVO DE DIAGNÓSTICO Y PRUEBA: test-db.php
 * 
 * ¿Por qué existe este archivo?
 * Sirve como un script de verificación independiente para confirmar que la conexión 
 * a la Base de Datos mediante PDO y la lectura de las variables del archivo .env 
 * funcionan correctamente.
 */

require_once __DIR__ . '/database.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Prueba de Conexión - UNLZ App</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f4f6f9; padding: 40px; }
        .card { max-width: 600px; margin: 0 auto; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .success { background: #e8f8f5; border-left: 5px solid #2ecc71; color: #1e8449; }
        .error { background: #fadbd8; border-left: 5px solid #e74c3c; color: #922b21; }
        h2 { margin-top: 0; }
        ul { margin-bottom: 0; }
    </style>
</head>
<body>
    <div class='card'>";

try {
    // Intentamos obtener la conexión PDO Singleton
    $db = Database::getConnection();

    // Consultamos la versión del motor MySQL para verificar comunicación bidireccional
    $version = $db->query('SELECT VERSION() AS version')->fetch();

    echo "<div class='card success'>
            <h2>¡Conexión PDO Exitosa!</h2>
            <p>La base de datos respondió correctamente utilizando la configuración del archivo <strong>.env</strong>.</p>
            <ul>
                <li><strong>Base de Datos:</strong> " . htmlspecialchars($_ENV['DB_NAME'] ?? 'No definida') . "</li>
                <li><strong>Host:</strong> " . htmlspecialchars($_ENV['DB_HOST'] ?? 'No definido') . "</li>
                <li><strong>Versión MySQL/MariaDB:</strong> " . htmlspecialchars($version['version']) . "</li>
            </ul>
          </div>";
} catch (Exception $e) {
    echo "<div class='card error'>
            <h2>Error en la Conexión</h2>
            <p>No se pudo establecer la comunicación con el servidor de Base de Datos.</p>
            <p><strong>Detalle:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "  </div>
</body>
</html>";