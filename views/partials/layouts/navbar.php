<?php
// Obtiene el segmento desde el parámetro 'url' en GET (si no está definido, usa 'dashboard' por defecto).
$uri = $_GET['url'] ?? 'dashboard';

// Divide la URL en partes separadas utilizando "/" para obtener el primer segmento (nombre de la página o sección actual).
$segment = explode('/', trim($uri, '/'))[0];
?>

<style>
/* Estilos personalizados para el navbar moderno */
.navbar-modern {
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.navbar-brand-modern:hover {
    transform: scale(1.05);
    filter: brightness(1.2);
}

.nav-link-modern {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
    padding: 0.75rem 1rem !important;
    margin: 0 0.25rem;
    position: relative;
    overflow: hidden;
}

.nav-link-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.nav-link-modern:hover::before {
    left: 100%;
}

.nav-link-modern:hover {
    
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.nav-link-modern.active {
    background: rgba(255, 255, 255, 0.2) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-1px);
}

.nav-link-modern.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 3px;
    background: #000000;
    border-radius: 2px;
}

.nav-icon {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
    transition: transform 0.3s ease;
}

.nav-link-modern:hover .nav-icon {
    transform: scale(1.1);
}

.btn-theme-toggle {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-theme-toggle:hover {
    background: rgba(0, 0, 0, 0.2);
    transform: rotate(180deg) scale(1.1);
    border-color: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-options {
    background: rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.btn-options:hover {
    background: rgba(0, 0, 0, 0.2);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.dropdown-menu-modern {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    padding: 0.75rem 0;
    margin-top: 0.5rem;
}

.dropdown-item-modern {
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border-radius: 0;
    display: flex;
    align-items: center;
}

.dropdown-item-modern:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    transform: translateX(5px);
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.user-avatar:hover {
    transform: scale(1.1);
    border-color: #fff;
}

.navbar-toggler-modern {
    border: none;
    padding: 0.5rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
}

.navbar-toggler-modern:focus {
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
}


@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}


@media (max-width: 991.98px) {
    .nav-link-modern {
        text-align: center;
        margin: 0.25rem 0;
    }
    
    .search-container {
        max-width: none;
        margin: 1rem 0;
    }
}
</style>

<!-- Navbar Moderno -->
<nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container-fluid px-3">
        
        <!-- Brand/Logo -->
        <a class="navbar-brand navbar-brand-modern d-flex align-items-center" href="<?= BASE_URL ?>dashboard">
            <i class="bi bi-gem me-2" style="font-size: 1.8rem;"></i>
            <span>Mi Aplicación</span>
        </a>

        <!-- Toggler para móviles -->
        <button class="navbar-toggler navbar-toggler-modern" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar" aria-controls="mainNavbar"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            
            <!-- Menú principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                    <a class="nav-link nav-link-modern d-flex flex-column align-items-center <?= $segment === 'dashboard' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>dashboard">
                        <i class="bi bi-house-door-fill nav-icon"></i>
                        <span class="small">Inicio</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-modern d-flex flex-column align-items-center <?= $segment === 'admin_users' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>admin_users">
                        <i class="bi bi-people-fill nav-icon"></i>
                        <span class="small">Usuarios</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-modern d-flex flex-column align-items-center <?= $segment === 'inventory' ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>inventory">
                        <i class="bi bi-box-seam nav-icon"></i>
                        <span class="small">Inventario</span>
                    </a>
                </li>

            </ul>


            <!-- Controles del lado derecho -->
            <div class="d-flex align-items-center gap-2">

            
                <!-- Toggle de tema -->
                <button class="btn btn-theme-toggle" id="themeToggleBtn" title="Cambiar tema">
                    <i class="bi bi-sun-fill" id="iconLight"></i>
                    <i class="bi bi-moon-fill d-none" id="iconDark"></i>
                </button>

                <!-- Menú de usuario -->
                <div class="dropdown">
                    <button class="btn btn-options dropdown-toggle d-flex align-items-center" type="button" id="optionsMenu"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($_SESSION['user']['img_url'])): ?>
                            <img src="<?= BASE_URL . ltrim($_SESSION['user']['img_url'], '/') ?>"
                                alt="Avatar" class="user-avatar me-2">
                        <?php else: ?>
                            <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
                        <?php endif; ?>
                        <span class="d-none d-lg-inline">
                            <?= $_SESSION['user']['name'] ?? 'Usuario' ?>
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern" aria-labelledby="optionsMenu">
                        <li>
                            <h6 class="dropdown-header">
                                <i class="bi bi-person-circle me-2"></i>
                                Mi Cuenta
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item dropdown-item-modern" href="<?= BASE_URL ?>profile">
                                <i class="bi bi-person-fill me-3"></i>
                                <div>
                                    <strong>Perfil</strong>
                                    <small class="text-muted d-block">Editar información personal</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item dropdown-item-modern" href="<?= BASE_URL ?>preferences">
                                <i class="bi bi-gear me-3"></i>
                                <div>
                                    <strong>Preferencias</strong>
                                    <small class="text-muted d-block">Configurar aplicación</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item dropdown-item-modern" href="<?= BASE_URL ?>help">
                                <i class="bi bi-question-circle me-3"></i>
                                <div>
                                    <strong>Ayuda</strong>
                                    <small class="text-muted d-block">Soporte y documentación</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item dropdown-item-modern text-danger" id="logoutButton">
                                <i class="bi bi-box-arrow-right me-3"></i>
                                <div>
                                    <strong>Cerrar Sesión</strong>
                                    <small class="text-muted d-block">Salir de la aplicación</small>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>

<!-- Espaciador para navbar fijo -->
<div style="height: 80px;"></div>

<?php
// Incluye el modal de cierre de sesión
include __DIR__ . '/../modals/modal-logout.php';
?>

<!-- Contenedor principal -->
<div class="container-fluid">
    <?php
    // Se carga dinámicamente el contenido de cada página
    echo $content;
    ?>
</div>



</body>
</html>