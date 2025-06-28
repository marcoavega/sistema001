<?php
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}

$uri = $_GET['url'] ?? 'product_detail';
$segment = explode('/', trim($uri, '/'))[0];

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

$menuItems = [
  'inventory' => ['icon' => 'box-seam', 'label' => 'Inventario'],
  'list_product' => ['icon' => 'list-ul', 'label' => 'Listado de Productos'],
];
?>

<div class="container-fluid m-0 p-0">
  <div class="row g-0">

    <!-- Barra lateral -->
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
      <!-- Menú móvil -->
      <div class="d-md-none mb-3">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-list me-1"></i> Menú
          </button>
          <ul class="dropdown-menu w-100">
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

      <!-- Detalles del producto -->
      <h1 class="mb-2"><?= htmlspecialchars($product['product_name']) ?></h1>

      <?php if (!empty($product['product_description'])): ?>
        <p class="text-muted"><?= nl2br(htmlspecialchars($product['product_description'])) ?></p>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-4">
          <?php if (!empty($product['image_url'])): ?>
            <img src="<?= BASE_URL . htmlspecialchars($product['image_url']) ?>"
              alt="Imagen del producto"
              class="img-fluid rounded shadow-sm"
              style="max-height:200px; object-fit:contain;">
          <?php else: ?>
            <img src="<?= BASE_URL ?>assets/images/no-image.png"
              alt="No Image"
              class="img-fluid rounded shadow-sm"
              style="max-height:200px; object-fit:contain;">
          <?php endif; ?>
        </div>

        <div class="col-md-8">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Código</th>
                <td><?= $product['product_code'] ?></td>
              </tr>
              <tr>
                <th>Ubicación</th>
                <td><?= $product['location'] ?></td>
              </tr>
              <tr>
                <th>Precio</th>
                <td>$<?= number_format($product['price'], 2) ?></td>
              </tr>
              <tr>
                <th>Stock</th>
                <td><?= intval($product['stock']) ?></td>
              </tr>
              <tr>
                <th>Registrado</th>
                <td><?= date("d/m/Y H:i", strtotime($product['registration_date'])) ?></td>
              </tr>
              <tr>
                <th>Estado</th>
                <td><?= $product['status'] ? 'Activo' : 'Inactivo' ?></td>
              </tr>
              <tr>
                <th>Precio Venta</th>
                <td><?= $product['sale_price'] !== null ? '$' . number_format($product['sale_price'], 4) : 'N/A' ?></td>
              </tr>
              <tr>
                <th>Peso</th>
                <td><?= $product['weight'] !== null ? $product['weight'] . ' kg' : 'N/A' ?></td>
              </tr>
              <tr>
                <th>Dimensiones</th>
                <td>
                  <?= $product['height'] ?? 'N/A' ?> x <?= $product['length'] ?? 'N/A' ?> x <?= $product['width'] ?? 'N/A' ?> cm
                </td>
              </tr>
              <tr>
                <th>Diámetro</th>
                <td><?= $product['diameter'] ?? 'N/A' ?> cm</td>
              </tr>
              <tr>
                <th>Actualizado</th>
                <td><?= date("d/m/Y H:i", strtotime($product['updated_at'])) ?></td>
              </tr>
            </tbody>
          </table>

          <a href="<?= BASE_URL ?>list_product" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Volver al Inventario
          </a>
        </div>
      </div>
    </main>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>