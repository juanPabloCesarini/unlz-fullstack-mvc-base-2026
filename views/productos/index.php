<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2 class="mb-4">Gestión de Productos</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Nuevo Producto</div>
            <div class="card-body">
                <form action="/unlz-backend-mvc-base-2026/productos/crear" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Subcategoría</label>
                        <select name="subcategoria_id" class="form-select" required>
                            <option value="">Seleccione una subcategoría...</option>
                            <?php foreach ($subcategorias as $sub): ?>
                            <option value="<?= $sub['id'] ?>"><?= htmlspecialchars($sub['nombre']) ?>
                                (<?= htmlspecialchars($sub['categoria_nombre']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-striped border shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Subcategoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $prod): ?>
                <tr>
                    <td>
                        <img src="/unlz-backend-mvc-base-2026/public/uploads/<?= htmlspecialchars($prod['imagen']) ?>"
                            alt="<?= htmlspecialchars($prod['nombre']) ?>"
                            style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                    </td>
                    <td><?= htmlspecialchars($prod['nombre']) ?></td>
                    <td><span
                            class="badge bg-info text-dark"><?= htmlspecialchars($prod['subcategoria_nombre']) ?></span>
                    </td>
                    <td>$<?= number_format($prod['precio'], 2, ',', '.') ?></td>
                    <td><?= $prod['stock'] ?></td>
                    <td>
                        <form action="/unlz-backend-mvc-base-2026/productos/eliminar" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay productos cargados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>