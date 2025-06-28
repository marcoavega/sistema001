<?php
// Modal: Editar Producto
// Ruta: views/partials/modals/modal_edit_product.php



// Cargar listas desplegables.
$categories = $suppliers = $units = $currencies = $subcategories = [];
try {
  $categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
}
try {
  $suppliers = $pdo->query("SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
}
try {
  $units = $pdo->query("SELECT unit_id, unit_name FROM units ORDER BY unit_name")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
}
try {
  $currencies = $pdo->query("SELECT currency_id, currency_name FROM currencies ORDER BY currency_name")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
}
try {
  $subcategories = $pdo->query("SELECT subcategory_id, subcategory_name FROM subcategories ORDER BY subcategory_name")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
}
?>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="editProductForm" enctype="multipart/form-data">
          <input type="hidden" id="edit-product-id" name="product_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit-product-code" class="form-label">Código de Producto</label>
              <input type="text" class="form-control" id="edit-product-code" name="product_code" required>
            </div>
            <div class="col-md-6">
              <label for="edit-product-name" class="form-label">Nombre de Producto</label>
              <input type="text" class="form-control" id="edit-product-name" name="product_name" required>
            </div>
            <div class="col-md-12">
              <label for="edit-product-description" class="form-label">Descripción</label>
              <textarea class="form-control" id="edit-product-description" name="product_description" rows="3"></textarea>
            </div>
            <div class="col-md-6">
              <label for="edit-location" class="form-label">Ubicación</label>
              <input type="text" class="form-control" id="edit-location" name="location" required>
            </div>
            <div class="col-md-3">
              <label for="edit-price" class="form-label">Precio</label>
              <input type="number" step="0.01" class="form-control" id="edit-price" name="price" required>
            </div>
            <div class="col-md-3">
              <label for="edit-stock" class="form-label">Stock</label>
              <input type="number" class="form-control" id="edit-stock" name="stock" required>
            </div>

            <div class="col-md-6">
              <label for="edit-category" class="form-label">Categoría</label>
              <select id="edit-category" name="category_id" class="form-select" required>
                <option value="">-- Selecciona categoría --</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= htmlspecialchars($cat['category_id']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit-supplier" class="form-label">Proveedor</label>
              <select id="edit-supplier" name="supplier_id" class="form-select" required>
                <option value="">-- Selecciona proveedor --</option>
                <?php foreach ($suppliers as $sup): ?>
                  <option value="<?= htmlspecialchars($sup['supplier_id']) ?>"><?= htmlspecialchars($sup['supplier_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="edit-unit" class="form-label">Unidad</label>
              <select id="edit-unit" name="unit_id" class="form-select" required>
                <option value="">-- Selecciona unidad --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= htmlspecialchars($unit['unit_id']) ?>"><?= htmlspecialchars($unit['unit_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="edit-currency" class="form-label">Moneda</label>
              <select id="edit-currency" name="currency_id" class="form-select" required>
                <option value="">-- Selecciona moneda --</option>
                <?php foreach ($currencies as $cur): ?>
                  <option value="<?= htmlspecialchars($cur['currency_id']) ?>"><?= htmlspecialchars($cur['currency_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="edit-subcategory" class="form-label">Subcategoría</label>
              <select id="edit-subcategory" name="subcategory_id" class="form-select" required>
                <option value="">-- Selecciona subcategoría --</option>
                <?php foreach ($subcategories as $sub): ?>
                  <option value="<?= htmlspecialchars($sub['subcategory_id']) ?>"><?= htmlspecialchars($sub['subcategory_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="edit-desired-stock" class="form-label">Stock Deseado</label>
              <input type="number" class="form-control" id="edit-desired-stock" name="desired_stock" min="0">
            </div>
            <div class="col-md-4">
              <label for="edit-status" class="form-label">Activo</label>
              <select class="form-select" id="edit-status" name="status">
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
            <!-- Dentro del form de edición, en modal_edit_product.php -->
            <div class="col-md-6">
              <label for="edit-image" class="form-label">Imagen del Producto (opcional, reemplaza la anterior)</label>
              <input type="file" class="form-control" id="edit-image" name="image_file" accept="image/*">
              <!-- Muestra la imagen actual quizás en un <img> si lo deseas -->
              <!-- <img id="current-image-preview" src="..." alt="Imagen actual" class="img-thumbnail mt-2" style="max-width:150px;"> -->
            </div>

            <!-- Otros campos opcionales si los manejes -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="saveEditProductBtn">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>