<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand font-monospace" href="/unlz-backend-mvc-base-2026/dashboard">UNLZ App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/unlz-backend-mvc-base-2026/dashboard">Inicio /
                        Catálogo</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a class="nav-link" href="/unlz-backend-mvc-base-2026/categorias">Categorías</a>
                </li>
                <li class="nav-item"><a class="nav-link"
                        href="/unlz-backend-mvc-base-2026/subcategorias">Subcategorías</a></li>
                <li class="nav-item"><a class="nav-link" href="/unlz-backend-mvc-base-2026/productos">Productos</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <span class="nav-link text-info">Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </li>
                <li class="nav-item">
                    <form action="/unlz-backend-mvc-base-2026/logout" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2">Cerrar Sesión</button>
                    </form>
                </li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/unlz-backend-mvc-base-2026/login">Ingresar</a></li>
                <li class="nav-item"><a class="nav-link" href="/unlz-backend-mvc-base-2026/register">Registrarse</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>