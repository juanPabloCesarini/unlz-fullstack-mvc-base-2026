<?php require_once __DIR__ . '/../layout/header.php'; ?>

<h2 class="mb-4">Gestión de Subcategorías</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Nueva Subcategoría</div>
            <div class="card-body">
                <form action="/unlz-backend-mvc-base-2026/subcategorias/crear" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Categoría Padre</label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Seleccione una categoría...</option>
                            <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Guardar Subcategoría</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-striped border shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Categoría Padre</th>
                    <th>Nombre Subcategoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subcategorias)): ?>
                <?php foreach ($subcategorias as $sub): ?>
                <tr>
                    <td><?= $sub['id'] ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($sub['categoria_nombre']) ?></span></td>
                    <td><?= htmlspecialchars($sub['nombre']) ?></td>
                    <td>
                        <form action="/unlz-backend-mvc-base-2026/subcategorias/eliminar" method="POST"
                            class="d-inline">
                            <input type="hidden" name="id" value="<?= $sub['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar esta subcategoría?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay subcategorías cargadas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>