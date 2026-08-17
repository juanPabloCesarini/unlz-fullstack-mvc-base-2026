<?php

/**
 * CONTROLADOR: SubcategoriaController
 */

require_once __DIR__ . '/../models/SubcategoriaModel.php';
require_once __DIR__ . '/../models/CategoriaModel.php';

class SubcategoriaController {
    private $subcategoriaModel;
    private $categoriaModel;

    public function __construct() {
        $this->subcategoriaModel = new SubcategoriaModel();
        $this->categoriaModel    = new CategoriaModel();
    }

    public function index() {
        $subcategorias = $this->subcategoriaModel->getAllWithCategory();
        $categorias    = $this->categoriaModel->all();
        require_once __DIR__ . '/../views/subcategorias/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria_id = $_POST['categoria_id'] ?? null;
            $nombre       = trim($_POST['nombre'] ?? '');
            $descripcion  = trim($_POST['descripcion'] ?? '');

            if ($categoria_id && !empty($nombre)) {
                $this->subcategoriaModel->create($categoria_id, $nombre, $descripcion);
                header('Location: /unlz-backend-mvc-base-2026/subcategorias');
                exit;
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->subcategoriaModel->delete($id);
            }
            header('Location: /unlz-backend-mvc-base-2026/subcategorias');
            exit;
        }
    }
}