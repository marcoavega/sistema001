<?php 
// views/partials/modals/modal_add_product.php

require_once __DIR__ . '/../../../models/Database.php';
$pdo = (new Database())->getConnection();

// Cargar listas desplegables:
$categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name")->fetchAll(PDO::FETCH_ASSOC);
$suppliers  = $pdo->query("SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name")->fetchAll(PDO::FETCH_ASSOC);
$units      = $pdo->query("SELECT unit_id, unit_name FROM units ORDER BY unit_name")->fetchAll(PDO::FETCH_ASSOC);
$currencies = $pdo->query("SELECT currency_id, currency_name FROM currencies ORDER BY currency_name")->fetchAll(PDO::FETCH_ASSOC);
$subcategories = $pdo->query("SELECT subcategory_id, subcategory_name FROM subcategories ORDER BY subcategory_name")->fetchAll(PDO::FETCH_ASSOC);
?>
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
              <input type="text" class="form-control" id="new-location" name="location">
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
              <select class="form-select" id="new-supplier" name="supplier_id" required>
                <option value="">-- Seleccionar Proveedor --</option>
                <?php foreach ($suppliers as $sup): ?>
                  <option value="<?= htmlspecialchars($sup['supplier_id']) ?>"><?= htmlspecialchars($sup['supplier_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-unit" class="form-label">Unidad</label>
              <select class="form-select" id="new-unit" name="unit_id" required>
                <option value="">-- Seleccionar Unidad --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= htmlspecialchars($unit['unit_id']) ?>"><?= htmlspecialchars($unit['unit_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-currency" class="form-label">Moneda</label>
              <select class="form-select" id="new-currency" name="currency_id" required>
                <option value="">-- Seleccionar Moneda --</option>
                <?php foreach ($currencies as $cur): ?>
                  <option value="<?= htmlspecialchars($cur['currency_id']) ?>"><?= htmlspecialchars($cur['currency_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-subcategory" class="form-label">Subcategoría</label>
              <select class="form-select" id="new-subcategory" name="subcategory_id" required>
                <option value="">-- Seleccionar Subcategoría --</option>
                <?php foreach ($subcategories as $sub): ?>
                  <option value="<?= htmlspecialchars($sub['subcategory_id']) ?>"><?= htmlspecialchars($sub['subcategory_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="new-desired-stock" class="form-label">Stock Deseado</label>
              <input type="number" class="form-control" id="new-desired-stock" name="desired_stock">
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
            </div>
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
