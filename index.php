<?php

/**
 * FRONT CONTROLLER (Punto Único de Entrada)
 * 
 * ¿Por qué usamos un Front Controller?
 * Todas las peticiones HTTP pasan obligatoriamente por este archivo.
 * Esto permite centralizar la configuración de errores, el inicio de sesiones,
 * la carga de variables de entorno y el ruteo hacia los controladores.
 */

// ------------------------------------------------------------------------------
// CONFIGURACIÓN DE ERRORES SEGÚN ENTORNO
// ------------------------------------------------------------------------------
// NOTA PEDAGÓGICA:
// En entorno de DESARROLLO (local) usamos display_errors = 1 para ver el detalle.
// En entorno de PRODUCCIÓN (deploy) pasamos a 0 para no exponer rutas o claves.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión global si no fue iniciada antes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carga del Ruteador
require_once __DIR__ . '/config/Router.php';

/* 
 * NOTA DE DIAGNÓSTICO DE BASE DE DATOS:
 * Si se necesita verificar la conexión PDO aislada en clase, descomentar la siguiente línea:
 * require_once __DIR__ . '/config/test-db.php'; exit;
 */

$router = new Router();

// ==============================================================================
// REGISTRO DE RUTAS AMIGABLES (GET / POST)
// ==============================================================================

// --- Rutas de Autenticación ---
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');

$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');

$router->get('/forgot-password', 'AuthController@forgotPassword');
$router->post('/forgot-password', 'AuthController@forgotPassword');

$router->get('/reset-password', 'AuthController@resetPassword');
$router->post('/reset-password', 'AuthController@resetPassword');

$router->post('/logout', 'AuthController@logout');

// --- Rutas de Categorías ---
$router->get('/categorias', 'CategoriaController@index');
$router->post('/categorias/crear', 'CategoriaController@store');
$router->post('/categorias/eliminar', 'CategoriaController@delete');

// --- Rutas de Subcategorías ---
$router->get('/subcategorias', 'SubcategoriaController@index');
$router->post('/subcategorias/crear', 'SubcategoriaController@store');
$router->post('/subcategorias/eliminar', 'SubcategoriaController@delete');

// --- Rutas de Productos ---
$router->get('/productos', 'ProductoController@index');
$router->post('/productos/crear', 'ProductoController@store');
$router->post('/productos/eliminar', 'ProductoController@delete');

// --- Ruta por Defecto (Home / Dashboard Público) ---
$router->get('/', 'HomeController@index');
$router->post('/', 'HomeController@index');

$router->get('/dashboard', 'HomeController@index');
$router->post('/dashboard', 'HomeController@index');

// Despachar la petición actual
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);