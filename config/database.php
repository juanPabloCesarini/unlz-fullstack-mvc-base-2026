<?php
/**
 * CLASE: Database (Patrón Singleton con PDO)
 * 
 * ¿Por qué usamos el Patrón Singleton?
 * Si cada consulta a la base de datos abriera una nueva conexión, el servidor MySQL agotaría
 * rápidamente su memoria. El patrón Singleton garantiza que exista UNA SOLA instancia de la
 * conexión PDO viva durante todo el ciclo de vida de la petición HTTP.
 */

require_once __DIR__ . '/env.php';

// Cargar el archivo .env ubicado en la raíz del proyecto (__DIR__ apunta al directorio 'config')
Env::load(__DIR__ . '/../.env');

class Database {
    // La propiedad estática mantendrá la única conexión PDO creada.
    private static $pdo = null;

    public static function getConnection() {
        // Si no existe una conexión previa, la creamos (Lazy Initialization).
        if (self::$pdo === null) {
            try {
                // Leemos las variables del .env con el operador Null Coalescing (??) como valor por defecto.
                $host    = $_ENV['DB_HOST'] ?? 'localhost';
                $db      = $_ENV['DB_NAME'] ?? 'unlz_app_2c_2026';
                $user    = $_ENV['DB_USER'] ?? 'root';
                $pass    = $_ENV['DB_PASS'] ?? '';
                $port    = $_ENV['DB_PORT'] ?? '3306';
                $charset = 'utf8mb4';

                // DSN (Data Source Name): String con la dirección y parámetros de la BD.
                $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

                /**
                 * OPCIONES DE CONFIGURACIÓN DE PDO:
                 * 1. PDO::ATTR_ERRMODE => ERRMODE_EXCEPTION: Ante un error SQL, PDO lanza una excepción
                 *    que podemos capturar con try/catch, evitando exponer errores crudos al usuario.
                 * 2. PDO::ATTR_DEFAULT_FETCH_MODE => FETCH_ASSOC: Retorna los resultados SQL como arrays
                 *    asociativos ('columna' => 'valor'), eliminando duplicados numéricos de memoria.
                 * 3. PDO::ATTR_EMULATE_PREPARES => false: Desactiva la emulación y usa Prepared Statements
                 *    nativos del motor MySQL. Esto es la principal defensa contra inyecciones SQL (SQLi).
                 */
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Interceptamos cualquier falla crítica en la conexión sin revelar contraseñas.
                die("Error de conexión a la Base de Datos: " . $e->getMessage());
            }
        }

        // Retornamos la conexión existente
        return self::$pdo;
    }
}