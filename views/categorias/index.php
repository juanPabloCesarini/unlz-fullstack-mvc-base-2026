<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2 class="mb-4">Gestión de Categorías</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Nueva Categoría</div>
            <div class="card-body">
                <form action="/unlz-backend-mvc-base-2026/categorias/crear" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Guardar Categoría</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-striped border shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['nombre']) ?></td>
                    <td><?= htmlspecialchars($cat['descripcion']) ?></td>
                    <td>
                        <form action="/unlz-backend-mvc-base-2026/categorias/eliminar" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>