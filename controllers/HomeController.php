<?php

/**
 * CONTROLADOR: HomeController
 */

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../models/CategoriaModel.php';
require_once __DIR__ . '/../models/SubcategoriaModel.php';

class HomeController {
    private $productoModel;
    private $categoriaModel;
    private $subcategoriaModel;

    public function __construct() {
        $this->productoModel     = new ProductoModel();
        $this->categoriaModel    = new CategoriaModel();
        $this->subcategoriaModel = new SubcategoriaModel();
    }

    public function index() {
        // Variables enviadas explícitamente a la vista
        $categorias    = $this->categoriaModel->all();
        $subcategorias = $this->subcategoriaModel->getAllWithCategory();

        $subcategoria_id = $_POST['subcategoria_id'] ?? ($_GET['subcategoria_id'] ?? null);

        if ($subcategoria_id) {
            $productos = $this->productoModel->getBySubcategory($subcategoria_id);
        } else {
            $productos = $this->productoModel->getAllWithSubcategory();
        }

        require_once __DIR__ . '/../views/home/index.php';
    }
}