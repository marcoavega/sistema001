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
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <!-- Header con gradiente -->
      <div class="modal-header bg-gradient position-relative overflow-hidden">
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
          <div class="d-flex align-items-center justify-content-center h-100">
            <i class="fas fa-cube" style="font-size: 120px;"></i>
          </div>
        </div>
        <div class="position-relative">
          <h4 class="modal-title fw-bold mb-0" id="addProductModalLabel">
            <i class="fas fa-plus-circle me-2"></i>
            Agregar Nuevo Producto
          </h4>
          <small class="opacity-75">Complete la información del producto</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4">
        <form id="addProductForm" enctype="multipart/form-data">
          
          <!-- Información Básica -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3">
              <h6 class="card-title mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Información Básica
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="new-product-code" class="form-label fw-semibold">
                    <i class="fas fa-barcode me-1 text-muted"></i>
                    Código de Producto
                  </label>
                  <div class="input-group">
                      <i class="fas fa-hashtag text-muted"></i>
                    </span>
                    <input type="text" class="form-control ps-0" id="new-product-code" name="product_code" required placeholder=" Ej. PROD001">
                  </div>
                </div>
                
                <div class="col-md-6">
                  <label for="new-barcode" class="form-label fw-semibold">
                    <i class="fas fa-qrcode me-1 text-muted"></i>
                    Código de Barras
                  </label>
                  <div class="input-group">
                      <i class="fas fa-barcode text-muted"></i>
                    </span>
                    <input type="text" class="form-control ps-0" id="new-barcode" placeholder=" 7501234567890">
                  </div>
                </div>
                
                <div class="col-12">
                  <label for="new-product-name" class="form-label fw-semibold">
                    <i class="fas fa-tag me-1 text-muted"></i>
                    Nombre del Producto
                  </label>
                  <input type="text" class="form-control form-control-lg" id="new-product-name" name="product_name" required placeholder="Ingrese el nombre del producto">
                </div>
                
                <div class="col-12">
                  <label for="product_description" class="form-label fw-semibold">
                    <i class="fas fa-align-left me-1 text-muted"></i>
                    Descripción del Producto
                  </label>
                  <textarea name="product_description" id="product_description" rows="3" class="form-control" placeholder="Descripción detallada del producto..."></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- Clasificación -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3">
              <h6 class="card-title mb-0">
                <i class="fas fa-sitemap me-2"></i>
                Clasificación
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="new-category" class="form-label fw-semibold">
                    <i class="fas fa-folder me-1 text-muted"></i>
                    Categoría
                  </label>
                  <select id="new-category" name="category_id" class="form-select form-select-lg" required>
                    <option value="">🏷️ Selecciona categoría</option>
                    <?php foreach ($categories as $cat): ?>
                      <option value="<?= htmlspecialchars($cat['category_id']) ?>">
                        <?= htmlspecialchars($cat['category_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="col-md-6">
                  <label for="new-subcategory" class="form-label fw-semibold">
                    <i class="fas fa-folder-open me-1 text-muted"></i>
                    Subcategoría
                  </label>
                  <select class="form-select form-select-lg" id="new-subcategory" name="subcategory_id" required>
                    <option value="">📂 Seleccionar Subcategoría</option>
                    <?php foreach ($subcategories as $sub): ?>
                      <option value="<?= htmlspecialchars($sub['subcategory_id']) ?>">
                        <?= htmlspecialchars($sub['subcategory_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Inventario y Precios -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3">
              <h6 class="card-title mb-0">
                <i class="fas fa-calculator me-2"></i>
                Inventario y Precios
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="new-price" class="form-label fw-semibold">
                    <i class="fas fa-dollar-sign me-1 text-muted"></i>
                    Precio
                  </label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text text-white">$</span>
                    <input type="number" step="0.01" class="form-control" id="new-price" name="price" required placeholder="0.00">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <label for="new-stock" class="form-label fw-semibold">
                    <i class="fas fa-boxes me-1 text-muted"></i>
                    Stock Actual
                  </label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text  text-white">
                      <i class="fas fa-cubes"></i>
                    </span>
                    <input type="number" class="form-control" id="new-stock" name="stock" required placeholder="0">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <label for="new-desired-stock" class="form-label fw-semibold">
                    <i class="fas fa-bullseye me-1 text-muted"></i>
                    Stock Deseado
                  </label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text text-dark">
                      <i class="fas fa-target"></i>
                    </span>
                    <input type="number" class="form-control" id="new-desired-stock" name="desired_stock" placeholder="0">
                  </div>
                </div>
                
                <div class="col-md-6">
                  <label for="new-unit" class="form-label fw-semibold">
                    <i class="fas fa-ruler me-1 text-muted"></i>
                    Unidad de Medida
                  </label>
                  <select class="form-select form-select-lg" id="new-unit" name="unit_id" required>
                    <option value="">📏 Seleccionar Unidad</option>
                    <?php foreach ($units as $unit): ?>
                      <option value="<?= htmlspecialchars($unit['unit_id']) ?>">
                        <?= htmlspecialchars($unit['unit_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="col-md-6">
                  <label for="new-currency" class="form-label fw-semibold">
                    <i class="fas fa-coins me-1 text-muted"></i>
                    Moneda
                  </label>
                  <select class="form-select form-select-lg" id="new-currency" name="currency_id" required>
                    <option value="">💰 Seleccionar Moneda</option>
                    <?php foreach ($currencies as $cur): ?>
                      <option value="<?= htmlspecialchars($cur['currency_id']) ?>">
                        <?= htmlspecialchars($cur['currency_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Información Adicional -->
          <div class="card border-0 shadow-sm">
            <div class="card-header border-0 py-3">
              <h6 class="card-title mb-0">
                <i class="fas fa-cogs me-2"></i>
                Información Adicional
              </h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="new-supplier" class="form-label fw-semibold">
                    <i class="fas fa-truck me-1 text-muted"></i>
                    Proveedor
                  </label>
                  <select class="form-select form-select-lg" id="new-supplier" name="supplier_id" required>
                    <option value="">🏢 Seleccionar Proveedor</option>
                    <?php foreach ($suppliers as $sup): ?>
                      <option value="<?= htmlspecialchars($sup['supplier_id']) ?>">
                        <?= htmlspecialchars($sup['supplier_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="col-md-6">
                  <label for="new-location" class="form-label fw-semibold">
                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                    Ubicación
                  </label>
                  <div class="input-group input-group-lg">
                      <i class="fas fa-warehouse text-muted"></i>
                    </span>
                    <input type="text" class="form-control" id="new-location" name="location" placeholder="Ej. Estante A-1">
                  </div>
                </div>
                
                <div class="col-md-6">
                  <label for="new-status" class="form-label fw-semibold">
                    <i class="fas fa-toggle-on me-1 text-muted"></i>
                    Estado
                  </label>
                  <select class="form-select form-select-lg" id="new-status" name="status">
                    <option value="1" selected>✅ Activo</option>
                    <option value="0">❌ Inactivo</option>
                  </select>
                </div>
                
                <div class="col-md-6">
                  <label for="new-image" class="form-label fw-semibold">
                    <i class="fas fa-image me-1 text-muted"></i>
                    Imagen del Producto
                  </label>
                  <div class="input-group">
                    <input type="file" class="form-control form-control-lg" id="new-image" name="image_file" accept="image/*">
                    <label class="input-group-text text-white" for="new-image">
                      <i class="fas fa-upload"></i>
                    </label>
                  </div>
                  <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Formatos soportados: JPG, PNG, GIF (Máx. 5MB)
                  </div>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>

      <!-- Footer con botones mejorados -->
      <div class="modal-footer border-0 p-4">
        <div class="d-flex gap-2 w-100 justify-content-end">
          <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>
            Cancelar
          </button>
          <button type="button" class="btn btn-primary btn-lg px-4 shadow" id="saveNewProductBtn">
            <i class="fas fa-save me-2"></i>
            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
            Guardar Producto
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /*
.bg-gradient {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
*/

.form-control:focus, .form-select:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.card {
  transition: transform 0.2s ease-in-out;
}

.card:hover {
  transform: translateY(-2px);
}

.input-group-text {
  border: 1px solid #dee2e6;
}

.form-control.border-start-0 {
  border-left: none !important;
}

.input-group-text.border-end-0 {
  border-right: none !important;
}

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

.modal.show .modal-dialog {
  animation: fadeInUp 0.3s ease-out;
}

.btn {
  transition: all 0.2s ease-in-out;
}

.btn:hover {
  transform: translateY(-1px);
}
</style>