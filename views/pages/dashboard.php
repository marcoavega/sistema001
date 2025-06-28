<?php
// Verifica si el usuario ha iniciado sesión y tiene un user_id asignado.
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    // Si no hay sesión activa, redirige al login para evitar accesos no autorizados.
    header("Location: " . BASE_URL . "auth/login/");
    exit(); // Detiene la ejecución del script inmediatamente.
}

// Obtiene la URL actual desde la variable GET y determina el segmento principal de navegación.
$uri = $_GET['url'] ?? 'dashboard'; // Si no hay parámetro 'url', se usa 'dashboard' por defecto.
$segment = explode('/', trim($uri, '/'))[0]; // Extrae la primera parte de la URL para identificar la sección activa.

// Inicia el almacenamiento en búfer de salida. Esto permite almacenar contenido dinámico antes de enviarlo al navegador.
ob_start();

// Convierte el nombre de usuario en un formato seguro para evitar ataques XSS.
$username = htmlspecialchars($_SESSION['user']['username']);

// Definición de los elementos del menú de navegación lateral.
// Se usa un array asociativo donde cada sección tiene un ícono y un nombre descriptivo.
$menuItems = [
    'dashboard'   => ['icon' => 'house-fill',   'label' => 'Panel de Control'],
    'settings'    => ['icon' => 'gear-fill',    'label' => 'Configuración'],
];

?>

<!-- Contenedor principal que incluye la barra lateral y el área de contenido -->
<div class="container-fluid m-0 p-0">
  <div class="row m-0 p-0">
  
    <!-- Sidebar fijo en pantallas medianas y grandes (md+) -->
    <nav class="col-md-2 d-none d-md-block sidebar min-vh-100 m-0 p-0">
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
      
      <!-- Menú desplegable solo visible en móviles -->
      <div class="d-md-none mb-3">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="mobileMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-list me-1"></i> Menú
          </button>
          <ul class="dropdown-menu w-100" aria-labelledby="mobileMenuBtn">
            <?php foreach ($menuItems as $route => $item): ?>
              <li>
                <a class="dropdown-item <?= $segment === $route ? 'active fw-bold' : '' ?>" 
                   href="<?= BASE_URL . $route ?>">
                  <i class="bi bi-<?= $item['icon'] ?> me-1"></i> <?= $item['label'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Título del panel de control y bienvenida al usuario -->
      <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
        <h1 class="h2">Panel de Control</h1>
        <span class="text-muted">Bienvenido, <?= $username ?>.</span>
      </div>

      <!-- Secciones de estadísticas (tiles) -->
      <div class="row">
        <?php 
        // Definición de secciones de estadísticas 
        $stats = [
          ['icon' => 'people-fill', 'label' => 'Usuarios', 'color' => 'text-primary'],
          ['icon' => 'box-seam', 'label' => 'Productos', 'color' => 'text-success'],
          ['icon' => 'cart-check', 'label' => 'Órdenes', 'color' => 'text-warning'],
          ['icon' => 'graph-up', 'label' => 'Reportes', 'color' => 'text-danger'],
        ];
        
        foreach ($stats as $stat): ?>
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <i class="bi bi-<?= $stat['icon'] ?> display-4 <?= $stat['color'] ?> mb-2"></i>
              <h6><?= $stat['label'] ?></h6>
              <h2>--</h2> <!-- Aquí podrían mostrarse valores dinámicos -->
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Sección de accesos rápidos -->
      <div class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2">
          <a href="<?= BASE_URL ?>admin_users" class="btn btn-outline-primary"><i class="bi bi-people-fill fs-4 me-1"></i> Usuarios</a>
          <a href="<?= BASE_URL ?>products" class="btn btn-outline-success"><i class="bi bi-box-seam fs-4 me-1"></i> Productos</a>
          <a href="<?= BASE_URL ?>orders" class="btn btn-outline-warning"><i class="bi bi-cart-check fs-4 me-1"></i> Órdenes</a>
          <a href="<?= BASE_URL ?>reports" class="btn btn-outline-danger"><i class="bi bi-graph-up fs-4 me-1"></i> Reportes</a>
        </div>
      </div>

      <!-- Sección de actividad reciente con Tabulator -->
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Actividad Reciente</h5>
        </div>
        <div class="card-body">
          <div id="recent-activity-table"></div>
        </div>
      </div>
      
    </main>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script para inicializar Tabulator -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var activityData = [];
    new Tabulator("#recent-activity-table", {
      layout: "fitColumns",
      placeholder: "No hay actividad reciente",
      data: activityData,
      columns: [
        { title: "Fecha", field: "date", sorter: "date", hozAlign: "center" },
        { title: "Usuario", field: "user", hozAlign: "left" },
        { title: "Acción", field: "action", hozAlign: "left" },
        { title: "Detalle", field: "detail", hozAlign: "left" }
      ],
    });
  });
</script>
