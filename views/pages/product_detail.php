<?php
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}

$uri = $_GET['url'] ?? 'product_detail';
$segment = explode('/', trim($uri, '/'))[0];

$currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: " . BASE_URL . "product_not_found");
  exit();
}

$product_id = (int) $_GET['id'];

ob_start();


require_once __DIR__ . '/../../models/Database.php';

try {
  $pdo = (new Database())->getConnection();

  $stmt = $pdo->prepare("
    SELECT 
        product_id,
        product_code,
        barcode,
        product_name,
        product_description,
        location,
        price,
        stock,
        registration_date,
        category_id,
        supplier_id,
        unit_id,
        currency_id,
        image_url,
        subcategory_id,
        desired_stock,
        status,
        sale_price,
        weight,
        height,
        length,
        width,
        diameter,
        updated_at
    FROM products
    WHERE product_id = :product_id
    LIMIT 1
");

  $stmt->execute(['product_id' => $product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$product) {
    header("Location: " . BASE_URL . "product_not_found");
    exit();
  }
} catch (PDOException $e) {
  echo "Error en la base de datos: " . $e->getMessage();
  exit();
}

$username = htmlspecialchars($_SESSION['user']['username']);

$activeMenu = 'list_product'; // o 'list_product' si prefieres
// Incluir menú lateral de productos/inventario
require_once __DIR__ . '/../partials/layouts/lateral_menu_products.php';
?>

<div class="container-fluid m-0 p-0 min-vh-100" data-bs-theme="auto">
  <div class="row g-0">

    <!-- Barra lateral -->
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
              <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 <?= isset($activeMenu) && $activeMenu === $route ? 'bg-primary text-white fw-bold' : 'text-body' ?>"
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
                  <li class="breadcrumb-item"><a href="<?= BASE_URL ?>list_product" class="text-decoration-none">Inventario</a></li>
                  <li class="breadcrumb-item active">Detalle del Producto</li>
                </ol>
              </nav>
              <h4 class="mb-0 fw-bold">Detalle del Producto</h4>
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

      <!-- Contenido del producto -->
      <div class="container-fluid px-4 py-4">

        <!-- Tarjeta principal del producto -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
          <div class="card-header bg-gradient p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h2 class="mb-1 fw-bold"><?= htmlspecialchars($product['product_name']) ?></h2>
                <p class="mb-0 opacity-75">
                  <i class="bi bi-upc-scan me-2"></i>
                  Código: <?= htmlspecialchars($product['product_code']) ?>
                </p>
              </div>
              <div class="text-end">
                <span class="badge <?= $product['status'] ? 'bg-success' : 'bg-warning' ?> fs-6 px-3 py-2 rounded-pill">
                  <i class="bi bi-<?= $product['status'] ? 'check-circle' : 'exclamation-triangle' ?> me-1"></i>
                  <?= $product['status'] ? 'Activo' : 'Inactivo' ?>
                </span>
              </div>
            </div>
          </div>

          <div class="card-body p-0">
            <div class="row g-0">

              <!-- Imagen del producto -->
              <div class="col-md-5 p-4 bg-body-secondary d-flex align-items-center justify-content-center">
                <div class="text-center">
                  <?php if (!empty($product['image_url'])): ?>
                    <img src="<?= BASE_URL . htmlspecialchars($product['image_url']) ?>"
                      alt="Imagen del producto"
                      class="img-fluid rounded-3 shadow-sm border"
                      style="max-height: 300px; max-width: 100%; object-fit: contain;">
                  <?php else: ?>
                    <div class="bg-body rounded-3 shadow-sm border d-flex align-items-center justify-content-center" style="height: 300px; width: 100%; max-width: 300px;">
                      <div class="text-center text-muted">
                        <i class="bi bi-image fs-1 mb-3"></i>
                        <p class="mb-0">Sin imagen</p>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Información principal -->
              <div class="col-md-7 p-4">

                <?php if (!empty($product['product_description'])): ?>
                  <div class="mb-4">
                    <h5 class="text-primary mb-2">
                      <i class="bi bi-file-text me-2"></i>Descripción
                    </h5>
                    <p class="text-muted lh-lg"><?= nl2br(htmlspecialchars($product['product_description'])) ?></p>
                  </div>
                <?php endif; ?>

                <!-- Información clave en cards -->
                <div class="row g-3 mb-4">
                  <div class="col-sm-6">
                    <div class="card bg-primary bg-opacity-10 border-0 h-100">
                      <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-primary fs-2 mb-2"></i>
                        <h6 class="text-primary mb-1">Precio</h6>
                        <h4 class="fw-bold mb-0">$<?= number_format($product['price'], 2) ?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card bg-success bg-opacity-10 border-0 h-100">
                      <div class="card-body text-center">
                        <i class="bi bi-boxes text-success fs-2 mb-2"></i>
                        <h6 class="text-success mb-1">Stock</h6>
                        <h4 class="fw-bold mb-0"><?= intval($product['stock']) ?></h4>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex gap-2 flex-wrap">
                  <a href="<?= BASE_URL ?>list_product" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-2"></i>Volver al Inventario
                  </a>
                  <button class="btn btn-primary px-4">
                    <i class="bi bi-pencil me-2"></i>Editar Producto
                  </button>
                  <button class="btn btn-outline-primary px-4">
                    <i class="bi bi-printer me-2"></i>Imprimir
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Detalles técnicos en accordion -->
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-header bg-body py-3">
            <h5 class="mb-0 fw-bold">
              <i class="bi bi-info-circle text-primary me-2"></i>
              Información Detallada
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="accordion accordion-flush" id="productDetails">

              <!-- Información básica -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#basicInfo">
                    <i class="bi bi-info-square me-2 text-primary"></i>
                    Información Básica
                  </button>
                </h2>
                <div id="basicInfo" class="accordion-collapse collapse show" data-bs-parent="#productDetails">
                  <div class="accordion-body">
                    <div class="row g-4">
                      <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                          <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-upc text-primary"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Código de Barras</small>
                            <span class="fw-semibold"><?= htmlspecialchars($product['barcode']) ?></span>
                          </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                          <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-geo-alt text-success"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Ubicación</small>
                            <span class="fw-semibold"><?= htmlspecialchars($product['location']) ?></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                          <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-calendar text-info"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Fecha de Registro</small>
                            <span class="fw-semibold"><?= date("d/m/Y H:i", strtotime($product['registration_date'])) ?></span>
                          </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                          <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-clock text-warning"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Última Actualización</small>
                            <span class="fw-semibold"><?= date("d/m/Y H:i", strtotime($product['updated_at'])) ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Precios y ventas -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#priceInfo">
                    <i class="bi bi-currency-exchange me-2 text-success"></i>
                    Precios y Ventas
                  </button>
                </h2>
                <div id="priceInfo" class="accordion-collapse collapse" data-bs-parent="#productDetails">
                  <div class="accordion-body">
                    <div class="row g-4">
                      <div class="col-md-4">
                        <div class="text-center p-3 bg-primary bg-opacity-10 rounded-3">
                          <i class="bi bi-tag text-primary fs-3 mb-2"></i>
                          <h6 class="text-primary mb-1">Precio Base</h6>
                          <h4 class="fw-bold mb-0">$<?= number_format($product['price'], 2) ?></h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded-3">
                          <i class="bi bi-cash text-success fs-3 mb-2"></i>
                          <h6 class="text-success mb-1">Precio Venta</h6>
                          <h4 class="fw-bold mb-0">
                            <?= $product['sale_price'] !== null ? '$' . number_format($product['sale_price'], 2) : 'N/A' ?>
                          </h4>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="text-center p-3 bg-info bg-opacity-10 rounded-3">
                          <i class="bi bi-percent text-info fs-3 mb-2"></i>
                          <h6 class="text-info mb-1">Margen</h6>
                          <h4 class="fw-bold mb-0">
                            <?php
                            if ($product['sale_price'] !== null && $product['price'] > 0) {
                              $margin = (($product['sale_price'] - $product['price']) / $product['price']) * 100;
                              echo number_format($margin, 1) . '%';
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Dimensiones y peso -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#dimensions">
                    <i class="bi bi-rulers me-2 text-warning"></i>
                    Dimensiones y Peso
                  </button>
                </h2>
                <div id="dimensions" class="accordion-collapse collapse" data-bs-parent="#productDetails">
                  <div class="accordion-body">
                    <div class="row g-4">
                      <div class="col-md-3">
                        <div class="d-flex align-items-center">
                          <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-arrow-up text-warning"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Alto</small>
                            <span class="fw-semibold"><?= $product['height'] ?? 'N/A' ?> cm</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-center">
                          <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-arrow-right text-info"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Largo</small>
                            <span class="fw-semibold"><?= $product['length'] ?? 'N/A' ?> cm</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-center">
                          <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-arrows text-secondary"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Ancho</small>
                            <span class="fw-semibold"><?= $product['width'] ?? 'N/A' ?> cm</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-center">
                          <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-circle text-success"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Diámetro</small>
                            <span class="fw-semibold"><?= $product['diameter'] ?? 'N/A' ?> cm</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mt-4">
                        <div class="d-flex align-items-center justify-content-center">
                          <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-speedometer text-primary fs-5"></i>
                          </div>
                          <div>
                            <small class="text-muted d-block">Peso</small>
                            <h5 class="fw-bold mb-0"><?= $product['weight'] !== null ? $product['weight'] . ' kg' : 'N/A' ?></h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>