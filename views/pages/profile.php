<?php
// Verifica si hay una sesión activa del usuario.
if (!isset($_SESSION['user'])) {
    // Si no hay sesión de usuario, se redirige a la página de inicio de sesión para evitar accesos no autorizados.
    header("Location: " . BASE_URL . "auth/login/");
    exit(); // Se detiene la ejecución del script para evitar que el usuario acceda a contenido sin permiso.
}

// Extrae los datos del usuario desde la sesión activa.
$user = $_SESSION['user']; // Se asigna la información del usuario a una variable para facilitar su uso en el código.

$username   = htmlspecialchars($user['username']); // Se convierte el nombre de usuario en formato seguro para evitar inyecciones HTML.
$email      = htmlspecialchars($user['email']); // Se protege el email de posibles ataques XSS.
$level_user = htmlspecialchars($user['level_user']); // Se asegura que el nivel de usuario esté limpio de caracteres peligrosos.
$level_name = $user['description_level'] ?? 'No disponible'; 
$created_at = isset($user['created_at']) ? htmlspecialchars($user['created_at']) : 'No disponible'; 
// Se verifica si la fecha de creación está definida, si no, se muestra "No disponible".
$updated_at = isset($user['updated_at']) ? htmlspecialchars($user['updated_at']) : 'No disponible'; 
// Se aplica la misma validación para la fecha de actualización.

// Se determina la imagen de perfil, usando una ruta predeterminada si el usuario no tiene una personalizada.
$img = !empty($user['img_url'])
         ? BASE_URL . $user['img_url']
         : BASE_URL . "assets/images/users/user.png"; 
// Si la imagen de usuario está definida en la sesión, se usa esa URL, de lo contrario, se carga una imagen genérica.

ob_start(); // Inicia el almacenamiento en búfer de salida para manejar el contenido dinámico.
?>

<!-- Contenedor principal -->
<div class="container mt-5">
  <h2 class="mb-4 text-center text-md-start">Mi Perfil</h2>
  
  <!-- Card con información del perfil -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="row">
        <!-- Columna de imagen y botón de edición -->
        <div class="col-md-4 text-center">
          <img src="<?php echo $img; ?>" alt="Imagen de Perfil" class="img-fluid rounded-circle mb-3" style="max-width: 200px; object-fit: cover;">
          <!-- Imagen de perfil con estilos para asegurar que se adapte correctamente. -->
          <button class="btn btn-primary" id="edit-profile-btn">Editar Perfil</button>
          <!-- Botón para acceder a la edición del perfil. -->
        </div>
        
        <!-- Columna con la información del usuario -->
        <div class="col-md-8">
          <h5 class="mb-3">Datos del Perfil</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Usuario:</strong> <?php echo $username; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
            <li class="list-group-item"><strong>Nivel:</strong> <?php echo $level_name; ?></li>
            <li class="list-group-item"><strong>Creado:</strong> <?php echo $created_at; ?></li>
            <li class="list-group-item"><strong>Actualizado:</strong> <?php echo $updated_at; ?></li>
            <!-- Se muestran los datos del usuario obtenidos de la sesión en una lista ordenada. -->
          </ul>
        </div>

      </div>
    </div>
  </div>
  
  <!-- Sección de actividad reciente usando Tabulator -->
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Mi Actividad Reciente</h5>
    </div>
    <div class="card-body">
      <div id="activity-table"></div>
      <!-- Contenedor donde se inicializará Tabulator para mostrar la actividad reciente. -->
    </div>
  </div>
  
</div>

<!-- Modal de edición de perfil -->
<?php
include __DIR__ . '/../partials/modals/modal_edit_profile.php'; 
// Se incluye el modal para editar la información del usuario.
?>

<?php
$content = ob_get_clean(); // Se almacena el contenido dinámico para ser renderizado correctamente.
include __DIR__ . '/../partials/layouts/navbar.php'; 
// Se incluye el navbar para la navegación dentro del sistema.
?>



<!-- Lógica del perfil -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/profile.js"></script>
<!-- Se carga el archivo de lógica del perfil, donde se gestionan acciones como la edición. -->

<!-- Inicialización de Tabulator para la actividad reciente -->
<script>
  var activityData = []; // Se inicializa un array vacío que puede ser actualizado con datos del servidor.

  var table = new Tabulator("#activity-table", {
    layout: "fitColumns", // Ajusta automáticamente las columnas al ancho del contenedor.
    placeholder: "No hay actividad reciente", // Mensaje mostrado si no hay datos disponibles.
    data: activityData, // Datos que se mostrarán en la tabla (pueden venir de una API).
    columns: [
      { title: "Fecha", field: "date", sorter: "date", hozAlign: "center" },
      { title: "Acción", field: "action", hozAlign: "center" },
      { title: "Detalle", field: "detail" }
    ]
  });
</script>
