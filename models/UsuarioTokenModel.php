<?php

/**
 * CLASE: UsuarioTokenModel
 * Gestiona la emisión y validación de tokens temporales para restablecer contraseñas.
 */

require_once __DIR__ . '/Model.php';

class UsuarioTokenModel extends Model {
    protected $table = 'usuarios_tokens';

    /**
     * Guardar un nuevo token de recuperación de contraseña con tiempo de expiración
     */
    public function createToken($usuario_id, $token, $expiracion) {
        $sql = "INSERT INTO {$this->table} (usuario_id, token, expiracion) 
                VALUES (:usuario_id, :token, :expiracion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':token'      => $token,
            ':expiracion' => $expiracion
        ]);
    }

    /**
     * Validar que un token exista, no haya sido usado y no esté vencido
     */
    public function verifyToken($token) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE token = :token AND usado = 0 AND expiracion > NOW() 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':token' => $token]);
        return $stmt->fetch();
    }

    /**
     * Marcar un token como consumido/usado para que no pueda reutilizarse
     */
    public function markAsUsed($id) {
        $sql = "UPDATE {$this->table} SET usado = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}