<?php
// Archivo: views/pages/admin_inventory.php

// Verificación de sesión
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

// Obtener segmento de URL para destacar menú activo
$uri = $_GET['url'] ?? 'inventory';
$segment = explode('/', trim($uri, '/'))[0];

// Iniciar buffer
ob_start();

// Conexión a BD si necesitas cargar datos (por ejemplo categorías):
require_once __DIR__ . '/../../models/Database.php';
$pdo = (new Database())->getConnection();

// Ejemplo: cargar categorías o datos necesarios para filtros en el inventario
// $stmt = $pdo->query("SELECT id_category, name FROM categories ORDER BY name");
// $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nombre de usuario para mostrar
$username = htmlspecialchars($_SESSION['user']['username']);

// Definir ítems del menú lateral, agregando 'inventory'
require_once __DIR__ . '/../partials/layouts/lateral_menu_produts.php';
?>

<div class="container-fluid m-0 p-0">
  <div class="row g-0">
    <!-- Sidebar lateral -->
    <nav class="col-md-2 d-none d-md-block sidebar min-vh-100">
      <ul class="nav flex-column pt-3">
        <?php foreach ($menuItems as $route => $item): ?>
          <li class="nav-item mb-2">
            <a class="nav-link text-body d-flex align-items-center <?= $segment === $route ? 'active fw-bold' : '' ?>"
              href="<?= BASE_URL . $route ?>">
              <i class="bi bi-<?= $item['icon'] ?> me-2"></i> <?= $item['label'] ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <!-- Contenido principal -->
    <main class="col-12 col-md-10 px-4 py-3">
      <!-- Menú desplegable para pantallas pequeñas -->
      <div class="d-md-none mb-3">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="mobileMenuBtn" data-bs-toggle="dropdown">
            <i class="bi bi-list me-1"></i>
          </button>
          <ul class="dropdown-menu w-100" aria-labelledby="mobileMenuBtn">
            <?php foreach ($menuItems as $route => $item): ?>
              <li>
                <a class="dropdown-item <?= $segment === $route ? 'active fw-bold' : '' ?>" href="<?= BASE_URL . $route ?>">
                  <i class="bi bi-<?= $item['icon'] ?> me-1"></i> <?= $item['label'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Verificación de permisos: ajustar según tu lógica -->
      <?php if ($_SESSION['user']['level_user'] != 1): ?>
        <h2>Acceso Denegado</h2>
        <div class="alert alert-danger">No tienes permiso para ver esta página.</div>
      <?php else: ?>
        <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
          <h2 class="mb-0">Administración de Inventario Listado de Productos.</h2>
          <span class="text-muted">Bienvenido, <?= $username ?>.</span>
        </div>

        <!-- Botones de acción -->
        <div class="row mb-3 g-2">
          <div class="col-12 col-md-auto">
            <button id="addProductBtn" class="btn btn-primary">Agregar Producto</button>
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportCSVBtn" class="btn btn-outline-primary">Exportar a CSV</button>
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportExcelBtn" class="btn btn-outline-success">Exportar a Excel</button>
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportPDFBtn" class="btn btn-outline-danger">Exportar a PDF</button>
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportJSONBtn" class="btn btn-outline-secondary">Exportar a JSON</button>
          </div>
        </div>

       
        <!-- Buscador de usuarios -->
        <div class="mb-3">
          <input type="text" id="table-search" class="form-control" placeholder="Buscar Productos por nombre o código">
          <!-- id="table-search" permite buscar dinámicamente usuarios en la tabla con JavaScript -->
        </div>

        <!-- Tabla de usuarios -->
        <div id="products-table"></div>
        <!-- id="users-table" es donde se cargan los datos dinámicamente con Tabulator.js -->

        <!-- Modales: Editar y Eliminar Usuario -->
        <?php
        include __DIR__ . '/../partials/modals/modal_edit_user.php';
        include __DIR__ . '/../partials/modals/modal_delete_user.php';
        ?>

        <!-- Modal: Agregar Usuario -->
        <?php
        include __DIR__ . '/../partials/modals/modal_add_user.php';
        ?>

      <?php endif; ?>
    </main>

  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script para gestión de usuarios -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/products-table.js"></script>
<!-- Este script maneja todas las interacciones con la tabla de usuarios, incluyendo búsquedas, ediciones y eliminaciones -->
