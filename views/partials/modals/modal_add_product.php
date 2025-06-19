<?php 
// Modal: Agregar Producto
// Ruta: views/partials/modals/modal_add_product.php

// Verificar sesión (opcional si ya está verificado en la vista padre)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a DB para cargar listas desplegables
require_once __DIR__ . '/../../../models/Database.php';
$pdo = (new Database())->getConnection();

// Cargar categorías
$categories = [];
try {
    $stmt = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error cargando categorías: " . $e->getMessage());
}

// Cargar proveedores (suppliers)
$suppliers = [];
try {
    $stmt = $pdo->query("SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name");
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error cargando proveedores: " . $e->getMessage());
}

// Cargar unidades
$units = [];
try {
    $stmt = $pdo->query("SELECT unit_id, unit_name FROM units ORDER BY unit_name");
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error cargando unidades: " . $e->getMessage());
}

// Cargar monedas (currencies)
$currencies = [];
try {
    $stmt = $pdo->query("SELECT currency_id, currency_name FROM currencies ORDER BY currency_name");
    $currencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error cargando monedas: " . $e->getMessage());
}

// Cargar subcategorías
$subcategories = [];
try {
    $stmt = $pdo->query("SELECT subcategory_id, subcategory_name FROM subcategories ORDER BY subcategory_name");
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error cargando subcategorías: " . $e->getMessage());
}
?>

<!-- Modal Agregar Producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="addProductForm" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="new-product-code" class="form-label">Código de Producto</label>
              <input type="text" class="form-control" id="new-product-code" name="product_code" required>
            </div>
            <div class="col-md-6">
              <label for="new-product-name" class="form-label">Nombre de Producto</label>
              <input type="text" class="form-control" id="new-product-name" name="product_name" required>
            </div>
            <div class="col-md-6">
              <label for="new-location" class="form-label">Ubicación</label>
              <input type="text" class="form-control" id="new-location" name="location" required>
            </div>
            <div class="col-md-3">
              <label for="new-price" class="form-label">Precio</label>
              <input type="number" step="0.01" class="form-control" id="new-price" name="price" required>
            </div>
            <div class="col-md-3">
              <label for="new-stock" class="form-label">Stock</label>
              <input type="number" class="form-control" id="new-stock" name="stock" required>
            </div>

            <div class="col-md-6">
              <label for="new-category" class="form-label">Categoría</label>
              <select id="new-category" name="category_id" class="form-select" required>
                <option value="">-- Selecciona categoría --</option>
                <?php foreach($categories as $cat): ?>
                  <option value="<?= htmlspecialchars($cat['category_id']) ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="new-supplier" class="form-label">Proveedor</label>
              <select id="new-supplier" name="supplier_id" class="form-select" required>
                <option value="">-- Selecciona proveedor --</option>
                <?php foreach ($suppliers as $sup): ?>
                  <option value="<?= htmlspecialchars($sup['supplier_id']) ?>">
                    <?= htmlspecialchars($sup['supplier_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-unit" class="form-label">Unidad</label>
              <select id="new-unit" name="unit_id" class="form-select" required>
                <option value="">-- Selecciona unidad --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= htmlspecialchars($unit['unit_id']) ?>">
                    <?= htmlspecialchars($unit['unit_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-currency" class="form-label">Moneda</label>
              <select id="new-currency" name="currency_id" class="form-select" required>
                <option value="">-- Selecciona moneda --</option>
                <?php foreach ($currencies as $cur): ?>
                  <option value="<?= htmlspecialchars($cur['currency_id']) ?>">
                    <?= htmlspecialchars($cur['currency_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-subcategory" class="form-label">Subcategoría</label>
              <select id="new-subcategory" name="subcategory_id" class="form-select" required>
                <option value="">-- Selecciona subcategoría --</option>
                <?php foreach ($subcategories as $sub): ?>
                  <option value="<?= htmlspecialchars($sub['subcategory_id']) ?>">
                    <?= htmlspecialchars($sub['subcategory_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="new-desired-stock" class="form-label">Stock Deseado</label>
              <input type="number" class="form-control" id="new-desired-stock" name="desired_stock" min="0">
            </div>
            <div class="col-md-4">
              <label for="new-status" class="form-label">Activo</label>
              <select class="form-select" id="new-status" name="status">
                <option value="1" selected>Sí</option>
                <option value="0">No</option>
              </select>
            </div>

            <div class="col-md-4">
              <label for="new-image" class="form-label">Imagen del Producto</label>
              <input type="file" class="form-control" id="new-image" name="image_file" accept="image/*">
              <small class="text-muted">La carga de imagen debe manejarse por separado en el backend si se desea almacenar.</small>
            </div>

            <!-- Si deseas otros campos opcionales como sale_price, weight, etc., agrégalos aquí con IDs y name apropiados -->
            <!-- Ejemplo:
            <div class="col-md-4">
              <label for="new-sale-price" class="form-label">Precio de Venta</label>
              <input type="number" step="0.0001" class="form-control" id="new-sale-price" name="sale_price">
            </div>
            -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="saveNewProductBtn">Guardar Producto</button>
      </div>
    </div>
  </div>
</div>
