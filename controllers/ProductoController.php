<?php

/**
 * CONTROLADOR: ProductoController
 */

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../models/SubcategoriaModel.php';

class ProductoController {
    private $productoModel;
    private $subcategoriaModel;

    public function __construct() {
        $this->productoModel     = new ProductoModel();
        $this->subcategoriaModel = new SubcategoriaModel();
    }

    public function index() {
        $productos     = $this->productoModel->getAllWithSubcategory();
        $subcategorias = $this->subcategoriaModel->all();
        require_once __DIR__ . '/../views/productos/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subcategoria_id = $_POST['subcategoria_id'] ?? null;
            $nombre          = trim($_POST['nombre'] ?? '');
            $descripcion     = trim($_POST['descripcion'] ?? '');
            $precio          = $_POST['precio'] ?? 0;
            $stock           = $_POST['stock'] ?? 0;

            $imagen = 'default.png';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $imagen = uniqid('prod_') . '.' . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../public/uploads/' . $imagen);
            }

            if ($subcategoria_id && !empty($nombre)) {
                $this->productoModel->create($subcategoria_id, $nombre, $descripcion, $precio, $stock, $imagen);
                header('Location: /unlz-backend-mvc-base-2026/productos');
                exit;
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->productoModel->delete($id);
            }
            header('Location: /unlz-backend-mvc-base-2026/productos');
            exit;
        }
    }
}