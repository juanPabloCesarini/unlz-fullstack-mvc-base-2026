<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Filtrar Subcategorías</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="/unlz-backend-mvc-base-2026/dashboard" class="list-group-item list-group-item-action">Todas las
                    subcategorías</a>
                <?php foreach ($subcategorias as $sub): ?>
                <form action="/unlz-backend-mvc-base-2026/dashboard" method="POST" class="d-inline">
                    <input type="hidden" name="subcategoria_id" value="<?= $sub['id'] ?>">
                    <button type="submit" class="list-group-item list-group-item-action w-100 text-start">
                        <?= htmlspecialchars($sub['nombre']) ?>
                        <small class="text-muted">(<?= htmlspecialchars($sub['categoria_nombre']) ?>)</small>
                    </button>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Catálogo de Productos</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $prod): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="/unlz-backend-mvc-base-2026/public/uploads/<?= htmlspecialchars($prod['imagen']) ?>"
                        class="card-img-top" alt="<?= htmlspecialchars($prod['nombre']) ?>"
                        style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <span
                            class="badge bg-secondary mb-2"><?= htmlspecialchars($prod['subcategoria_nombre']) ?></span>
                        <h5 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h5>
                        <p class="card-text text-truncate"><?= htmlspecialchars($prod['descripcion']) ?></p>
                        <h6 class="text-success fw-bold">$<?= number_format($prod['precio'], 2, ',', '.') ?></h6>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No se encontraron productos en esta categoría.</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>