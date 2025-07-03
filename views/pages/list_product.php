<?php
// Archivo: views/pages/list_product.php

// Verificación de sesión
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}

// Obtener segmento de URL para destacar menú activo
$uri = $_GET['url'] ?? 'list_product';
$segment = explode('/', trim($uri, '/'))[0];

// Iniciar buffer de salida
ob_start();

// Conexión a la base de datos
require_once __DIR__ . '/../../models/Database.php';
$pdo = (new Database())->getConnection();

// Nombre de usuario para mostrar
$username = htmlspecialchars($_SESSION['user']['username']);

// Incluir menú lateral de productos/inventario
require_once __DIR__ . '/../partials/layouts/lateral_menu_products.php';
?>



<div class="container-fluid m-0 p-0 min-vh-100" data-bs-theme="auto">
  <div class="row g-0">

    <!-- Barra lateral con gradiente moderno -->
    <nav class="col-md-2 d-none d-md-block sidebar min-vh-100">
      <div class="pt-4 px-3">
        <div class="text-center mb-4">
          <div class=" rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-box-seam text-primary fs-3"></i>
          </div>
          <h6 class=" mt-2 mb-0">Inventario</h6>
        </div>

        <ul class="nav flex-column">
          <?php foreach ($menuItems as $route => $item): ?>
            <li class="nav-item mb-2">
              <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 <?= $segment === $route ? 'bg-primary text-white fw-bold' : 'text-body' ?>"
              href="<?= BASE_URL . $route ?>" style="transition: all 0.3s ease;">
                <i class="bi bi-<?= $item['icon'] ?> me-3 fs-5"></i>
                <span class="fw-medium"><?= $item['label'] ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </nav>

    <!-- Contenido principal -->
    <main class="col-12 col-md-10">

      <!-- Header con breadcrumb moderno -->
      <div class="bg-body shadow-sm border-bottom">
        <div class="container-fluid px-4 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                  <li class="breadcrumb-item"><a href="<?= BASE_URL ?>dashboard" class="text-decoration-none">Dashboard</a></li>
                  <li class="breadcrumb-item active">Inventario de Productos</li>
                </ol>
              </nav>
              <h4 class="mb-0 fw-bold">Gestión de Inventario</h4>
              <small class="text-muted">Bienvenido, <?= $username ?></small>
            </div>

            <!-- Menú móvil mejorado -->
            <div class="d-md-none">
              <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Menú móvil offcanvas -->
      <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header bg-primary-subtle">
          <h5 class="offcanvas-title">
            <i class="bi bi-box-seam me-2"></i>Inventario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body bg-body">
          <ul class="nav flex-column">
            <?php foreach ($menuItems as $route => $item): ?>
              <li class="nav-item mb-2">
                <a class="nav-link text-body d-flex align-items-center px-3 py-2 rounded-3 <?= $segment === $route ? 'active bg-primary text-white' : '' ?>"
                  href="<?= BASE_URL . $route ?>">
                  <i class="bi bi-<?= $item['icon'] ?> me-3"></i> <?= $item['label'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Verificación de permisos -->
      <?php if ($_SESSION['user']['level_user'] != 1): ?>
        <div class="container-fluid px-4 py-5">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-5">
                  <div class="mb-4">
                    <i class="bi bi-shield-exclamation text-warning" style="font-size: 4rem;"></i>
                  </div>
                  <h3 class="fw-bold text-warning mb-3">Acceso Denegado</h3>
                  <p class="text-muted mb-4">No tienes los permisos necesarios para acceder a esta sección del sistema.</p>
                  <a href="<?= BASE_URL ?>dashboard" class="btn btn-primary px-4">
                    <i class="bi bi-house me-2"></i>Volver al Dashboard
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>

        <div class="container-fluid px-4 py-4">

          <!-- Panel de estadísticas rápidas -->
          <div class="row g-3 mb-4">
            <div class="col-md-3">
              <div class="card bg-primary bg-opacity-10 border-0 h-100">
                <div class="card-body text-center">
                  <i class="bi bi-boxes text-primary fs-2 mb-3"></i>
                  <h6 class="text-primary mb-1">Total Productos</h6>
                  <h4 class="fw-bold mb-0" id="totalProducts">-</h4>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-success bg-opacity-10 border-0 h-100">
                <div class="card-body text-center">
                  <i class="bi bi-check-circle text-success fs-2 mb-3"></i>
                  <h6 class="text-success mb-1">En Stock</h6>
                  <h4 class="fw-bold mb-0" id="inStock">-</h4>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-warning bg-opacity-10 border-0 h-100">
                <div class="card-body text-center">
                  <i class="bi bi-exclamation-triangle text-warning fs-2 mb-3"></i>
                  <h6 class="text-warning mb-1">Stock Bajo</h6>
                  <h4 class="fw-bold mb-0" id="lowStock">-</h4>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-info bg-opacity-10 border-0 h-100">
                <div class="card-body text-center">
                  <i class="bi bi-currency-dollar text-info fs-2 mb-3"></i>
                  <h6 class="text-info mb-1">Valor Total</h6>
                  <h4 class="fw-bold mb-0" id="totalValue">-</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Panel de control principal -->
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header p-4">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h3 class="mb-1 fw-bold">Listado de Productos</h3>
                  <p class="mb-0 opacity-75">Gestiona tu inventario completo desde aquí</p>
                </div>
                <div>
                  <button id="addProductBtn" class="btn btn-info btn-lg px-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body p-4">

              <!-- Barra de herramientas -->
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="table-search" class="form-control form-control-lg ps-5 rounded-pill border-2"
                      placeholder="Buscar productos por código, nombre o categoría...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex gap-2 justify-content-md-end">
                    <div class="dropdown">
                      <button class="btn btn-outline-primary dropdown-toggle rounded-pill px-4" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-2"></i>Exportar
                      </button>
                      <ul class="dropdown-menu shadow-lg border-0 rounded-3">
                        <li>
                          <h6 class="dropdown-header fw-bold">Formatos disponibles</h6>
                        </li>
                        <li>
                          <button id="exportCSVBtn" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-filetype-csv text-success me-2"></i>Exportar a CSV
                          </button>
                        </li>
                        <li>
                          <button id="exportExcelBtn" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-file-earmark-excel text-success me-2"></i>Exportar a Excel
                          </button>
                        </li>
                        <li>
                          <button id="exportPDFBtn" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Exportar a PDF
                          </button>
                        </li>
                        <li>
                          <button id="exportJSONBtn" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-filetype-json text-info me-2"></i>Exportar a JSON
                          </button>
                        </li>
                      </ul>
                    </div>

                    <button class="btn btn-outline-secondary rounded-pill px-4" id="refreshTable">
                      <i class="bi bi-arrow-clockwise me-2"></i>Actualizar
                    </button>
                  </div>
                </div>
              </div>

              <!-- Filtros avanzados (colapsable) -->
              <div class="mb-4">
                <button class="btn btn-link text-decoration-none p-0 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                  <i class="bi bi-funnel me-2"></i>Filtros Avanzados
                  <i class="bi bi-chevron-down ms-1"></i>
                </button>
                <div class="collapse mt-3" id="advancedFilters">
                  <div class="card bg-body-secondary border-0">
                    <div class="card-body">
                      <div class="row g-3">
                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Estado</label>
                          <select class="form-select" id="statusFilter">
                            <option value="">Todos</option>
                            <option value="1">Activos</option>
                            <option value="0">Inactivos</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Stock</label>
                          <select class="form-select" id="stockFilter">
                            <option value="">Todos</option>
                            <option value="low">Stock Bajo</option>
                            <option value="normal">Stock Normal</option>
                            <option value="high">Stock Alto</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Precio Desde</label>
                          <input type="number" class="form-control" id="priceFromFilter" placeholder="0.00" step="0.01">
                        </div>
                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Precio Hasta</label>
                          <input type="number" class="form-control" id="priceToFilter" placeholder="999.99" step="0.01">
                        </div>
                      </div>
                      <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary" id="applyFilters">
                          <i class="bi bi-check2 me-2"></i>Aplicar Filtros
                        </button>
                        <button class="btn btn-outline-secondary" id="clearFilters">
                          <i class="bi bi-x-circle me-2"></i>Limpiar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Contenedor de la tabla -->
              <div class="table-responsive">
                <div id="products-table" class="border rounded-3"></div>
              </div>

              <!-- Información de paginación -->
              <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="text-muted">
                  <small>Mostrando <span id="currentItems">0</span> de <span id="totalItems">0</span> productos</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                  <small class="text-muted">Productos por página:</small>
                  <select class="form-select form-select-sm" style="width: auto;" id="pageSize">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50" selected>50</option>
                    <option value="100">100</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Incluir modales -->
        <?php
        include __DIR__ . '/../partials/modals/modal_add_product.php';
        include __DIR__ . '/../partials/modals/modal_edit_product.php';
        include __DIR__ . '/../partials/modals/modal_delete_product.php';
        ?>
      <?php endif; ?>
    </main>
  </div>
</div>

<style>
  .sidebar .nav-link:hover {
    transform: translateX(5px);
  }

  .transition-all {
    transition: all 0.3s ease;
  }

  .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .card:hover {
    transform: translateY(-2px);
  }

  /* Estilos para tabla Tabulator */
  .tabulator {
    border: none !important;
    background: transparent !important;
  }

  .tabulator-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    border: none !important;
  }

  .tabulator-row:hover {
    background-color: rgba(13, 110, 253, 0.1) !important;
  }

  .tabulator-selected {
    background-color: rgba(13, 110, 253, 0.2) !important;
  }


  /* Asegurar que los textos sean legibles en ambos temas */
  .text-body {
    color: var(--bs-body-color) !important;
  }

  .bg-body {
    background-color: var(--bs-body-bg) !important;
  }

  .bg-body-secondary {
    background-color: var(--bs-secondary-bg) !important;
  }

  /* Animaciones sutiles */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .card {
    animation: fadeInUp 0.5s ease-out;
  }

  /* Botones con efectos */
  .btn {
    transition: all 0.3s ease;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  /* Efectos para inputs */
  .form-control:focus {
    transform: scale(1.02);
    transition: transform 0.2s ease;
  }





/* Estilos modernos para Tabulator - Responsive */

/* Contenedor principal de la tabla */
#products-table {
  border-radius: 12px !important;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  transition: all 0.3s ease;
}

/* Header de la tabla */
.tabulator .tabulator-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-bottom: 2px solid #dee2e6;
  font-weight: 600;
}

.tabulator .tabulator-header .tabulator-col {
  border-right: 1px solid #dee2e6;
  padding: 12px 8px;
}

.tabulator .tabulator-header .tabulator-col-title {
  font-size: 0.875rem;
  font-weight: 600;
  color: #495057;
}

/* Filas de la tabla */
.tabulator .tabulator-tableHolder .tabulator-table .tabulator-row {
  border-bottom: 1px solid #f1f3f4;
  transition: all 0.2s ease;
}

.tabulator .tabulator-tableHolder .tabulator-table .tabulator-row:hover {
  background-color: #f8f9fa !important;
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.tabulator .tabulator-tableHolder .tabulator-table .tabulator-row .tabulator-cell {
  padding: 12px 8px;
  border-right: 1px solid #f1f3f4;
  vertical-align: middle;
}

/* Botones de acción mejorados */
.btn-group-sm .btn {
  padding: 0.375rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 6px;
  margin: 0 2px;
  transition: all 0.2s ease;
}

.btn-outline-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(13, 110, 253, 0.25);
}

.btn-outline-danger:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(220, 53, 69, 0.25);
}

/* Paginación moderna */
.tabulator .tabulator-footer {
  background: #f8f9fa;
  border-top: 2px solid #dee2e6;
  padding: 15px;
}

.tabulator .tabulator-footer .tabulator-paginator {
  color: #495057;
  font-weight: 500;
}

.tabulator .tabulator-footer .tabulator-pages {
  margin: 0 15px;
}

.tabulator .tabulator-footer .tabulator-page {
  background: transparent;
  border: 1px solid #dee2e6;
  color: #495057;
  margin: 0 2px;
  padding: 8px 12px;
  border-radius: 6px;
  transition: all 0.2s ease;
  font-weight: 500;
}

.tabulator .tabulator-footer .tabulator-page:hover {
  background: #e9ecef;
  transform: translateY(-1px);
}

.tabulator .tabulator-footer .tabulator-page.active {
  background: #007bff;
  color: white;
  border-color: #007bff;
}

/* Selector de tamaño de página */
.tabulator .tabulator-footer .tabulator-page-size {
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  padding: 6px 12px;
  font-weight: 500;
  color: #495057;
}

/* Loading placeholder mejorado */
.tabulator .tabulator-placeholder {
  color: #6c757d;
  font-weight: 500;
  font-size: 1rem;
  padding: 40px;
  background: #f8f9fa;
}

/* Responsive collapse mejorado */
.tabulator .tabulator-responsive-collapse {
  background: #f8f9fa;
  border-top: 1px solid #dee2e6;
  padding: 10px 15px;
}

.tabulator .tabulator-responsive-collapse-toggle {
  background: #007bff;
  color: white;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  border: none;
  font-size: 12px;
  transition: all 0.2s ease;
}

.tabulator .tabulator-responsive-collapse-toggle:hover {
  background: #0056b3;
  transform: scale(1.1);
}

/* Badges y elementos mejorados */
.badge {
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.375rem 0.75rem;
  border-radius: 6px;
}

/* Links hover effect */
.hover-primary:hover {
  color: #007bff !important;
  text-decoration: underline !important;
}


</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script JS -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/products-table.js"></script>

<script>
  // Script para actualizar estadísticas (opcional)
  document.addEventListener('DOMContentLoaded', function() {
    // Aquí puedes añadir código para cargar las estadísticas
    // Por ejemplo, una llamada AJAX para obtener los totales

    // Simulación de carga de estadísticas
    setTimeout(() => {
      document.getElementById('totalProducts').textContent = '0';
      document.getElementById('inStock').textContent = '0';
      document.getElementById('lowStock').textContent = '0';
      document.getElementById('totalValue').textContent = '$0.00';
    }, 500);
  });
</script>