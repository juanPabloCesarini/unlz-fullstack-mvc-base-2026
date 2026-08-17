<?php

/**
 * CLASE: ProductoModel
 * Maneja la lógica de la tabla 'productos' y sus consultas cruzadas (JOIN).
 */

require_once __DIR__ . '/Model.php';

class ProductoModel extends Model {
    protected $table = 'productos';

    /**
     * Trae todos los productos uniendo el nombre de la subcategoría
     */
    public function getAllWithSubcategory() {
        $sql = "SELECT p.*, s.nombre AS subcategoria_nombre 
                FROM {$this->table} p
                INNER JOIN subcategorias s ON p.subcategoria_id = s.id
                WHERE p.deleted_at IS NULL AND s.deleted_at IS NULL
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Insertar un nuevo producto
     */
    public function create($subcategoria_id, $nombre, $descripcion, $precio, $stock, $imagen) {
        $sql = "INSERT INTO {$this->table} (subcategoria_id, nombre, descripcion, precio, stock, imagen) 
                VALUES (:subcategoria_id, :nombre, :descripcion, :precio, :stock, :imagen)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':subcategoria_id' => $subcategoria_id,
            ':nombre'          => $nombre,
            ':descripcion'     => $descripcion,
            ':precio'          => $precio,
            ':stock'           => $stock,
            ':imagen'          => $imagen
        ]);
    }
}