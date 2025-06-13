<?php
// Obtiene el segmento desde el parámetro 'url' en GET (si no está definido, usa 'dashboard' por defecto).
$uri = $_GET['url'] ?? 'dashboard';

// Divide la URL en partes separadas utilizando "/" para obtener el primer segmento (nombre de la página o sección actual).
$segment = explode('/', trim($uri, '/'))[0];
?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar shadow-sm bg-dark-subtle m-0 p-0">
    <!-- 'navbar-expand-lg' permite que el menú se expanda en pantallas grandes y se colapse en móviles.
         'shadow-sm' agrega una sombra ligera para mejorar la estética del navbar.
         'bg-dark-subtle' asigna un fondo oscuro sutil para contrastar con el contenido.
         'm-0 p-0' elimina márgenes y padding innecesarios. -->

    <div class="container-fluid">
        <!-- 'container-fluid' asegura que el navbar ocupe todo el ancho disponible. -->

        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>dashboard">Mi Aplicación</a>
        <!-- Logo o nombre de la aplicación, vinculado a la página de inicio.
             'fw-bold' enfatiza la fuente en negrita para mayor visibilidad. -->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar" aria-controls="mainNavbar"
            aria-expanded="false" aria-label="Toggle navigation">
            <!-- Botón de menú colapsable en dispositivos móviles.
                 'data-bs-toggle="collapse"' permite expandir o contraer el menú.
                 'data-bs-target' apunta a la sección que será colapsada (id="mainNavbar"). -->
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex-column flex-lg-row" id="mainNavbar">
            <!-- 'collapse navbar-collapse' permite que el menú se colapse en pantallas pequeñas.
                 'flex-column flex-lg-row' coloca los elementos en columnas en móviles y en fila en pantallas grandes. -->

            <!-- Menú principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                <!-- 'me-auto' empuja los elementos del menú hacia la izquierda.
                     'mb-2 mb-lg-0' añade margen inferior solo en pantallas pequeñas.
                     'text-center' centra los elementos en dispositivos móviles. -->

                <li class="nav-item px-2">
                    <a class="nav-link text-body d-flex flex-column align-items-center <?= $segment === 'dashboard' ? 'active fw-bold' : '' ?>"
                        href="<?= BASE_URL ?>dashboard">
                        <!-- Si el segmento actual es 'dashboard', se resalta la opción con 'active fw-bold'. -->
                        <i class="bi bi-house-door-fill fs-6 mb-1"></i>
                        <span class="fs-6">Inicio</span>
                    </a>
                </li>

                <li class="nav-item px-2">
                    <a class="nav-link text-body d-flex flex-column align-items-center <?= $segment === 'admin_users' ? 'active fw-bold' : '' ?>"
                        href="<?= BASE_URL ?>admin_users">
                        <!-- Si el segmento actual es 'admin_users', se resalta la opción con 'active fw-bold'. -->
                        <i class="bi bi-people-fill fs-6 mb-1"></i>
                        <span class="fs-6">Usuarios</span>
                    </a>
                </li>


                <li class="nav-item px-2">
                    <a
                        class="nav-link text-body d-flex flex-column align-items-center <?= $segment === 'inventory' ? 'active fw-bold' : '' ?>"
                        href="<?= BASE_URL ?>inventory">
                        <!-- Icono de inventario: aquí usamos 'bi-box-seam', ajústalo si prefieres otro -->
                        <i class="bi bi-box-seam fs-6 mb-1"></i>
                        <span class="fs-6">Inventario</span>
                    </a>
                </li>


                <!-- Se pueden añadir más ítems según las rutas de la aplicación. -->
            </ul>

            <!-- Bloque derecho (Opciones adicionales y cambio de tema) -->
            <div class="d-flex align-items-center">

                <!-- Botón para alternar entre tema claro y oscuro -->
                <button class="btn btn-outline-secondary me-3" id="themeToggleBtn" title="Cambiar tema">
                    <i class="bi bi-sun-fill fs-6" id="iconLight"></i>
                    <i class="bi bi-moon-fill fs-6 d-none" id="iconDark"></i>
                </button>

                <!-- Menú desplegable con opciones -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="optionsMenu"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear-fill"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="optionsMenu">
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>profile">
                                <!-- Si el usuario tiene una imagen de perfil en sesión, se muestra junto con el enlace al perfil. -->
                                <?php if (!empty($_SESSION['user']['img_url'])): ?>
                                    <img src="<?= BASE_URL . ltrim($_SESSION['user']['img_url'], '/') ?>"
                                        alt="Foto de usuario"
                                        class="rounded-circle me-3"
                                        style="width:32px;height:32px;object-fit:cover;">
                                <?php endif; ?>
                                Perfil
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item" id="logoutButton">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                            </button>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
    </div>

</nav>

<?php
// Incluye el modal de cierre de sesión (probablemente usado para confirmar la acción antes de ejecutar el logout).
include __DIR__ . '/../modals/modal-logout.php';
?>

<!-- ==============================================
         Contenedor principal para el contenido dinámico
============================================== -->
<div class="container-fluid mt-0 m-0 p-0">
    <?php
    // Se carga dinámicamente el contenido de cada página, según la URL procesada.
    echo $content;
    ?>
</div>

</body>

</html>