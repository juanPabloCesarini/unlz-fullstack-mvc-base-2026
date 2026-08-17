<?php

/**
 * CLASE: Router
 * 
 * ¿Por qué existe esta clase?
 * Mantiene la tabla de mapeo entre las URLs amigables (ej: '/login', '/productos') 
 * y los controladores que deben procesar cada solicitud.
 * Soporta métodos HTTP (GET y POST) para mayor seguridad.
 */

class Router {
    private $routes = [];

    /**
     * Registrar una ruta GET
     */
    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Registrar una ruta POST
     */
    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        // Normalizamos la ruta removiendo barras sobrantes
        $path = rtrim($path, '/');
        $path = $path === '' ? '/' : $path;

        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler
        ];
    }

    /**
     * Despachar la petición entrante buscando coincidencia en la tabla de rutas
     */
    public function dispatch($requestUri, $requestMethod) {
        // Limpiamos parámetros de consulta de la URL (Query Strings como ?foo=bar)
        $parsedUrl = parse_url($requestUri, PHP_URL_PATH);

        // Removemos la carpeta base del proyecto de la ruta para trabajar con paths relativos amigables
        $baseFolder = '/unlz-backend-mvc-base-2026';
        if (strpos($parsedUrl, $baseFolder) === 0) {
            $parsedUrl = substr($parsedUrl, strlen($baseFolder));
        }

        $parsedUrl = rtrim($parsedUrl, '/');
        $parsedUrl = $parsedUrl === '' ? '/' : $parsedUrl;

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $parsedUrl) {
                list($controllerName, $methodName) = explode('@', $route['handler']);

                $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName();

                    if (method_exists($controller, $methodName)) {
                        return $controller->$methodName();
                    }
                }
            }
        }

        // Si no existe coincidencia, enviamos un error 404
        http_response_code(404);
        echo "<h1 style='font-family: sans-serif; text-align: center; margin-top: 50px;'>Error 404 - Página no encontrada</h1>";
    }
}