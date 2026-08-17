<?php

/**
 * CLASE PADRE ABSTRACTA: Model
 * 
 * ¿Por qué creamos este Modelo Base?
 * En un sistema MVC, la mayoría de las tablas (categorías, productos, usuarios) comparten 
 * operaciones básicas (SELECT, DELETE, etc.). Para no repetir las mismas consultas SQL en 
 * cada archivo, centralizamos la conexión PDO y los métodos comunes aquí.
 */

require_once __DIR__ . '/../config/database.php';

abstract class Model {
    protected $db;
    protected $table; // Nombre de la tabla MySQL (se define en la clase hija)

    public function __construct() {
        // Reutilizamos la única conexión PDO desde el Singleton
        $this->db = Database::getConnection();
    }

    /**
     * Obtener todos los registros activos (sin borrado lógico)
     */
    public function all() {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar un registro activo por su ID principal
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND deleted_at IS NULL LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Borrado Lógico (Soft Delete):
     * En lugar de DELETE FROM, actualizamos la columna 'deleted_at'. Esto preserva 
     * la integridad referencial para auditorías o reportes históricos.
     */
    public function delete($id) {
        $sql = "UPDATE {$this->table} SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}