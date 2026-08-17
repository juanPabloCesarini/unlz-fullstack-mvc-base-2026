<?php

/**
 * CLASE: CategoriaModel
 * Hereda todos los métodos genéricos de Model (all, find, delete).
 */

require_once __DIR__ . '/Model.php';

class CategoriaModel extends Model {
    protected $table = 'categorias';

    /**
     * Insertar una nueva categoría usando Prepared Statements para evitar Inyección SQL
     */
    public function create($nombre, $descripcion) {
        $sql = "INSERT INTO {$this->table} (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion
        ]);
    }

    /**
     * Actualizar una categoría existente
     */
    public function update($id, $nombre, $descripcion) {
        $sql = "UPDATE {$this->table} SET nombre = :nombre, descripcion = :descripcion WHERE id = :id AND deleted_at IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'          => $id,
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion
        ]);
    }
}