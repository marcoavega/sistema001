<?php
// Verifica si el usuario está logueado, si no, redirige
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}

ob_start();
?>

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
  <div class="mb-4">
    <i class="bi bi-emoji-frown display-1 text-danger"></i>
  </div>

  <h1 class="display-4 fw-bold">404 - Página no encontrada</h1>
  <p class="lead text-muted mb-4">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>

  <a href="<?= BASE_URL ?>dashboard" class="btn btn-primary btn-lg">
    <i class="bi bi-house-door-fill me-1"></i> Volver al inicio
  </a>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
