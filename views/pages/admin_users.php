<?php
// Archivo: views/pages/admin_users.php
// Se verifica si el usuario ha iniciado sesión antes de acceder a la página.
if (!isset($_SESSION['user'])) {
  // Si no hay sesión activa, se redirige al login para evitar accesos no autorizados.
  header("Location: " . BASE_URL . "auth/login/");
  exit(); // Detiene la ejecución del script inmediatamente.
}

// Se obtiene la URL actual desde la variable GET y se determina el segmento principal de navegación.
$uri = $_GET['url'] ?? 'admin_users'; // Si no hay parámetro 'url', se usa "admin_users" por defecto.
$segment = explode('/', trim($uri, '/'))[0]; // Extrae la primera parte de la URL para identificar la sección activa.

ob_start(); // Inicia el almacenamiento en búfer de salida, permitiendo capturar contenido antes de enviarlo al navegador.

// Se carga el archivo Database.php para obtener la conexión PDO con la base de datos.
require_once __DIR__ . '/../../models/Database.php';
$pdo = (new Database())->getConnection(); // Se crea la instancia de conexión con la base de datos.

// Se ejecuta una consulta SQL para obtener los niveles de usuario desde la tabla "levels_users".
$stmt = $pdo->query("SELECT id_level_user, description_level FROM levels_users ORDER BY level");
$levels = $stmt->fetchAll(PDO::FETCH_ASSOC); // Se almacena el resultado en un array asociativo.

$username = htmlspecialchars($_SESSION['user']['username']); // Se sanitiza el nombre de usuario para evitar ataques XSS.

// Se define el menú lateral con íconos y etiquetas descriptivas.
$menuItems = [
  'admin_users' => ['icon' => 'people-fill', 'label' => 'Usuarios'],
];
?>

<!-- Contenedor principal -->
<div class="container-fluid m-0 p-0">
  <div class="row g-0">
    
    <!-- Barra lateral para pantallas medianas y grandes -->
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

      <!-- Verificación de permisos: Solo usuarios de nivel 1 pueden acceder -->
      <?php if ($_SESSION['user']['level_user'] != 1): ?>
        <h2>Acceso Denegado</h2>
        <div class="alert alert-danger">No tienes permiso para ver esta página.</div>
      <?php else: ?>
        <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
          <h2 class="mb-0">Administración de Usuarios</h2>
          <span class="text-muted">Bienvenido, <?= $username ?>.</span>
        </div>

        <!-- Botones de acción -->
        <div class="row mb-3 g-2">
          <div class="col-12 col-md-auto">
            <button id="addUserBtn" class="btn btn-primary">Agregar Usuario</button>
            <!-- id="addUserBtn" se usa en JavaScript para abrir el formulario modal de agregar usuario -->
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportCSVBtn" class="btn btn-outline-primary">Exportar a CSV</button>
            <!-- id="exportCSVBtn" activa la exportación de usuarios en formato CSV -->
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportExcelBtn" class="btn btn-outline-success">Exportar a Excel</button>
            <!-- id="exportExcelBtn" activa la exportación de datos en formato Excel -->
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportPDFBtn" class="btn btn-outline-danger">Exportar a PDF</button>
            <!-- id="exportPDFBtn" genera un archivo PDF con los datos de usuarios -->
          </div>
          <div class="col-12 col-md-auto">
            <button id="exportJSONBtn" class="btn btn-outline-secondary">Exportar a JSON</button>
            <!-- id="exportJSONBtn" exporta los datos en formato JSON -->
          </div>
        </div>

        <!-- Buscador de usuarios -->
        <div class="mb-3">
          <input type="text" id="table-search" class="form-control" placeholder="Buscar usuarios por nombre o email">
          <!-- id="table-search" permite buscar dinámicamente usuarios en la tabla con JavaScript -->
        </div>

        <!-- Tabla de usuarios -->
        <div id="users-table"></div>
        <!-- id="users-table" es donde se cargan los datos dinámicamente con Tabulator.js -->

        <!-- Modales: Editar y Eliminar Usuario -->
        <?php
        include __DIR__ . '/../partials/modals/modal_edit_user.php';
        include __DIR__ . '/../partials/modals/modal_delete_user.php';
        ?>

        <!-- Modal: Agregar Usuario -->
        <?php
        include __DIR__ . '/../partials/modals/modal_add_user.php';
        ?>

      <?php endif; ?>
    </main>

  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script para gestión de usuarios -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/admin-users.js"></script>
<!-- Este script maneja todas las interacciones con la tabla de usuarios, incluyendo búsquedas, ediciones y eliminaciones -->
