<?php

/**
 * CONTROLADOR: CategoriaController
 */

require_once __DIR__ . '/../models/CategoriaModel.php';

class CategoriaController {
    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index() {
        $categorias = $this->categoriaModel->all();
        require_once __DIR__ . '/../views/categorias/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            if (!empty($nombre)) {
                $this->categoriaModel->create($nombre, $descripcion);
                header('Location: /unlz-backend-mvc-base-2026/categorias');
                exit;
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->categoriaModel->delete($id);
            }
            header('Location: /unlz-backend-mvc-base-2026/categorias');
            exit;
        }
    }
}