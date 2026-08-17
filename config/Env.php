<?php

/**
 * CLASE HELPER: Env
 * 
 * ¿Por qué existe este archivo?
 * En proyectos profesionales, las credenciales (claves de BD, contraseñas de mail) NO se escriben
 * directamente en el código ("hardcodeo"), sino que se leen desde un archivo de entorno (.env).
 * Como no estamos utilizando Composer para descargar librerías externas (como vlucas/phpdotenv),
 * construimos nuestro propio parseador nativo para leer el .env y cargar los datos en PHP.
 */

class Env {
    public static function load($path) {
        // file_exists(): Verifica si el archivo .env existe en la raíz para evitar un error fatal.
        if (!file_exists($path)) {
            return false;
        }

        // file(): Lee todo el archivo y devuelve un array donde cada elemento es una línea del .env.
        // FILE_IGNORE_NEW_LINES: Elimina los saltos de línea (\n, \r) al final de cada elemento.
        // FILE_SKIP_EMPTY_LINES: Saltea las líneas en blanco.
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignoramos las líneas que son comentarios (comienzan con #)
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Separamos la clave del valor buscando la posición del primer signo '='
            if (strpos($line, '=') !== false) {
                // explode(): Divide un string en un array utilizando un delimitador (el '=').
                // El parámetro 2 indica que solo divida en máximo 2 partes (clave y valor).
                list($key, $value) = explode('=', $line, 2);

                // trim(): Elimina espacios en blanco al inicio y al final.
                $key   = trim($key);
                $value = trim($value, "\"'\r\n "); // Limpiamos comillas dobles, simples y saltos de línea

                // Validamos que la variable no exista previamente para no sobrescribir variables del sistema.
                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    // putenv(): Registra la variable en el entorno del sistema PHP.
                    putenv(sprintf('%s=%s', $key, $value));

                    // Cargamos los superglobales $_ENV y $_SERVER para acceder a las variables fácilmente.
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
        return true;
    }
}