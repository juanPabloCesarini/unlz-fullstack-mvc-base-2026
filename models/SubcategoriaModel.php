<?php

/**
 * CLASE: SubcategoriaModel
 * Maneja las subcategorías vinculadas a una Categoría principal.
 */

require_once __DIR__ . '/Model.php';

class SubcategoriaModel extends Model {
    protected $table = 'subcategorias';

    /**
     * Obtiene subcategorías uniendo el nombre de la categoría padre (JOIN)
     */
    public function getAllWithCategory() {
        $sql = "SELECT s.*, c.nombre AS categoria_nombre 
                FROM {$this->table} s
                INNER JOIN categorias c ON s.categoria_id = c.id
                WHERE s.deleted_at IS NULL AND c.deleted_at IS NULL
                ORDER BY s.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtiene todas las subcategorías pertenecientes a una categoría específica
     */
    public function getByCategory($categoria_id) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE categoria_id = :categoria_id AND deleted_at IS NULL 
                ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':categoria_id' => $categoria_id]);
        return $stmt->fetchAll();
    }

    public function create($categoria_id, $nombre, $descripcion) {
        $sql = "INSERT INTO {$this->table} (categoria_id, nombre, descripcion) 
                VALUES (:categoria_id, :nombre, :descripcion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':categoria_id' => $categoria_id,
            ':nombre'       => $nombre,
            ':descripcion'  => $descripcion
        ]);
    }

    public function update($id, $categoria_id, $nombre, $descripcion) {
        $sql = "UPDATE {$this->table} 
                SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion 
                WHERE id = :id AND deleted_at IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'           => $id,
            ':categoria_id' => $categoria_id,
            ':nombre'       => $nombre,
            ':descripcion'  => $descripcion
        ]);
    }
}