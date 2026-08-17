<?php

/**
 * CONTROLADOR: AuthController
 * Maneja todo el ciclo de autenticación con URLs amigables y tokens de recuperación.
 */

require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../models/UsuarioTokenModel.php';

class AuthController {
    private $usuarioModel;
    private $tokenModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->tokenModel   = new UsuarioTokenModel();
    }

    /**
     * Procesar / Mostrar Login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $usuario = $this->usuarioModel->findByEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id']   = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nombre'];
                $_SESSION['user_role'] = $usuario['rol'];

                header('Location: /unlz-backend-mvc-base-2026/dashboard');
                exit;
            } else {
                $error = "Credenciales inválidas.";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    /**
     * Procesar / Mostrar Registro de Nuevos Usuarios
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre   = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($nombre) || empty($email) || empty($password)) {
                $error = "Todos los campos obligatorios deben completarse.";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Verificar si el email ya existe
            if ($this->usuarioModel->findByEmail($email)) {
                $error = "El correo electrónico ya se encuentra registrado.";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Encriptación segura de la contraseña con BCRYPT
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);

            if ($this->usuarioModel->create($nombre, $apellido, $email, $hashPassword, 'cliente')) {
                header('Location: /unlz-backend-mvc-base-2026/login');
                exit;
            } else {
                $error = "Error al registrar el usuario.";
                require_once __DIR__ . '/../views/auth/register.php';
            }
        } else {
            require_once __DIR__ . '/../views/auth/register.php';
        }
    }

    /**
     * Solicitud de Recupero de Contraseña (Envío de Token/Mail)
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $usuario = $this->usuarioModel->findByEmail($email);

            if ($usuario) {
                // Generar token único de 64 caracteres
                $token = bin2hex(random_bytes(32));
                // Expiración en 1 hora
                $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->tokenModel->createToken($usuario['id'], $token, $expiracion);

                // Acá llamaremos al servicio de mail con Gmail/SMTP.
                // Por el momento, guardamos el mensaje de éxito para la vista.
                $success = "Se han enviado las instrucciones a tu casilla de correo.";
            } else {
                $error = "El correo ingresado no pertenece a ningún usuario registrado.";
            }
            require_once __DIR__ . '/../views/auth/forgot-password.php';
        } else {
            require_once __DIR__ . '/../views/auth/forgot-password.php';
        }
    }

    /**
     * Redefinición de Contraseña usando el Token
     */
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token       = trim($_POST['token'] ?? '');
            $newPassword = trim($_POST['password'] ?? '');

            $tokenData = $this->tokenModel->verifyToken($token);

            if ($tokenData) {
                $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Actualizar password y marcar token como usado
                $this->usuarioModel->updatePassword($tokenData['usuario_id'], $hashPassword);
                $this->tokenModel->markAsUsed($tokenData['id']);

                header('Location: /unlz-backend-mvc-base-2026/login');
                exit;
            } else {
                $error = "El token es inválido o ha expirado.";
                require_once __DIR__ . '/../views/auth/reset-password.php';
            }
        } else {
            $token = $_GET['token'] ?? '';
            require_once __DIR__ . '/../views/auth/reset-password.php';
        }
    }

    /**
     * Cerrar Sesión
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /unlz-backend-mvc-base-2026/login');
        exit;
    }
}