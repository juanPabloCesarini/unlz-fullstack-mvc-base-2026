<?php

/**
 * CLASE: UsuarioModel
 * Encargada de la autenticación, registros y búsqueda de cuentas de usuario.
 */

require_once __DIR__ . '/Model.php';

class UsuarioModel extends Model {
    protected $table = 'usuarios';

    /**
     * Buscar un usuario por su correo electrónico (útil para Login y Recupero de clave)
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Registrar un nuevo usuario.
     * Importante: El parámetro $password ya debe venir hasheado con password_hash().
     */
    public function create($nombre, $apellido, $email, $password, $rol = 'cliente') {
        $sql = "INSERT INTO {$this->table} (nombre, apellido, email, password, rol) 
                VALUES (:nombre, :apellido, :email, :password, :rol)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'   => $nombre,
            ':apellido' => $apellido,
            ':email'    => $email,
            ':password' => $password,
            ':rol'      => $rol
        ]);
    }

    /**
     * Actualizar la contraseña de un usuario a partir de su ID
     */
    public function updatePassword($id, $newPasswordHash) {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id AND deleted_at IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'       => $id,
            ':password' => $newPasswordHash
        ]);
    }
}