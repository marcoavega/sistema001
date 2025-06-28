<?php
// Verifica sesión
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

ob_start();
?>

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
    <div class="mb-4">
        <i class="bi bi-box-seam display-1 text-danger"></i>
    </div>

    <h1 class="display-4 fw-bold">Producto no encontrado</h1>
    <p class="lead text-muted mb-4">Parece que el producto que estás buscando no existe o fue eliminado del inventario.</p>

    <a href="<?= BASE_URL ?>list_product" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-arrow-left-circle me-2"></i> Volver al Inventario
    </a>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
