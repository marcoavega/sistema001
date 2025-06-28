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
require_once __DIR__ . '/../partials/layouts/lateral_menu_products.php';
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
            <i class="bi bi-list me-1"></i> Menú
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
          <h2 class="mb-0">Administración de Inventario</h2>
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

        <!-- Buscador / filtros del inventario -->
        <div class="mb-3 row g-2">
          <div class="col-12 col-md-4">
            <input type="text" id="inventory-search" class="form-control" placeholder="Buscar por nombre o código">
          </div>
          <!-- Ejemplo de filtro por categoría:
          <div class="col-12 col-md-3">
            <select id="filter-category" class="form-select">
              <option value="">Todas las categorías</option>
              <?php /* foreach ($categories as $cat): */ ?>
              <?php /* <option value="<?= $cat['id_category'] ?>"><?= htmlspecialchars($cat['name']) ?></option> */ ?>
              <?php /* endforeach; */ ?>
            </select>
          </div>
          -->
        </div>

        <!-- Tabla de inventario -->
        <div id="inventory-table"></div>

        <!-- Modales: Editar, Eliminar, Agregar Producto -->
        <?php
        // Incluye los modales específicos del inventario; crea estos archivos según necesites.
        // Por ejemplo:
        // include __DIR__ . '/../partials/modals/modal_add_product.php';
        // include __DIR__ . '/../partials/modals/modal_edit_product.php';
        // include __DIR__ . '/../partials/modals/modal_delete_product.php';
        ?>
      <?php endif; ?>
    </main>
  </div>
</div>

<?php
$content = ob_get_clean();
// Incluye el layout principal, que internamente incluye el navbar superior y los estilos de tu proyecto.
// Ajusta la ruta si tu proyecto usa otra estructura.
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script para gestión de inventario -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/admin-inventory.js">
    document.addEventListener("DOMContentLoaded", function(){
  var table = new Tabulator("#inventory-table", {
    index: "product_id",
    ajaxURL: BASE_URL + "api/inventory.php?action=get",
    ajaxConfig: "GET",
    layout: "fitColumns",
    responsiveLayout: "collapse",
    placeholder: "Cargando inventario...",
    columns: [
      { title: "ID", field: "product_id", width: 70, sorter: "number" },
      { title: "Nombre", field: "name" },
      { title: "SKU", field: "sku" },
      { title: "Categoría", field: "category_name" },
      { title: "Stock", field: "stock", hozAlign: "center" },
      { title: "Precio", field: "price", hozAlign: "right", formatter: "money" },
      { title: "Creado", field: "created_at", formatter: function(cell){ /* formato de fecha */ } },
      { title: "Actualizado", field: "updated_at", formatter: function(cell){ /* formato de fecha */ } },
      {
        title: "Acciones",
        hozAlign: "center",
        formatter: function(){
          return "<div class='btn-group'>" +
                   "<button class='btn btn-sm btn-info edit-btn me-1'>Editar</button>" +
                   "<button class='btn btn-sm btn-danger delete-btn'>Eliminar</button>" +
                 "</div>";
        },
        cellClick: function(e, cell){
          var rowData = cell.getRow().getData();
          if(e.target.classList.contains("edit-btn")){
            // Rellenar modal de edición con rowData...
          }
          if(e.target.classList.contains("delete-btn")){
            // Abrir modal de confirmación...
          }
        }
      },
    ],
  });

  // Filtro búsqueda en tiempo real
  var searchInput = document.getElementById("inventory-search");
  if(searchInput){
    searchInput.addEventListener("input", function(){
      var q = searchInput.value.toLowerCase();
      table.setFilter(function(data){
        return data.name.toLowerCase().includes(q) || data.sku.toLowerCase().includes(q);
      });
    });
  }

  // Agregar Producto
  document.getElementById("addProductBtn").addEventListener("click", function(){
    // Mostrar modal_add_product
  });

  // Exportaciones CSV/Excel/PDF/JSON: similares a admin-users.js, ajusta columnas y encabezados.
  // Por ejemplo, en exportPDFBtn, si quieres título centrado, etc.

  // ...
});

</script>
<!-- admin-inventory.js debe manejar:
     - Inicializar Tabulator en '#inventory-table'
     - Cargar datos vía AJAX: BASE_URL + 'api/inventory.php?action=get'
     - Manejadores para agregar/editar/eliminar producto, exportar, etc.
     - Filtros (search input), exportaciones CSV/Excel/PDF/JSON similares a admin-users.js,
       incluyendo centrado y estilo de títulos en PDF si lo deseas.
-->

