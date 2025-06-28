<?php
// Se incluye el archivo del encabezado con los metadatos y los estilos del sistema.
include __DIR__ . '/../partials/head.php';

// Se incluye el botón para alternar entre tema oscuro y claro.
include __DIR__ . '/../partials/button-theme.php';
?>

<!-- Contenedor principal que garantiza que el contenido ocupe toda la pantalla -->
<div class="d-flex flex-column" style="min-height: 100vh;">
    <!-- 'd-flex flex-column' estructura el contenido en una dirección vertical.
         'min-height: 100vh' garantiza que el contenedor abarque toda la altura de la pantalla. -->

    <!-- Área principal del login: ocupa el espacio disponible y se centra en la pantalla -->
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <!-- 'container-fluid' hace que el contenedor ocupe todo el ancho disponible.
             'flex-grow-1' expande el contenido verticalmente para que ocupe el espacio disponible.
             'align-items-center justify-content-center' centra el formulario tanto vertical como horizontalmente. -->

        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <!-- Se usa 'card' para estructurar el formulario con borde y sombra suave ('shadow-lg') para mejorar la apariencia.
                 'width: 100%' permite que el formulario sea flexible dentro del contenedor.
                 'max-width: 400px' evita que el formulario se extienda demasiado en pantallas grandes. -->

            <div class="card-body text-center">
                <!-- Contenedor con el contenido principal centrado dentro de la tarjeta. -->

                <!-- Imagen del logo de la empresa -->
                <img src="<?php echo BASE_URL; ?>assets/images/logo/logo_empresa.png" 
                     alt="Logo de la Empresa" 
                     class="img-fluid rounded-circle mb-3" 
                     style="max-height: 100px; object-fit: contain;">
                <!-- Se carga la imagen del logo con 'img-fluid' para asegurarse de que sea responsiva.
                     'rounded-circle' le da un aspecto circular para un diseño moderno.
                     'max-height: 100px' limita su tamaño para que no sobresalga demasiado.
                     'object-fit: contain' evita recortes en la imagen. -->

                <!-- Título del formulario -->
                <h2 class="card-title text-center mb-4">Iniciar Sesión.</h2>
                <!-- Se centra el título y se le agrega margen inferior ('mb-4') para mejorar el espaciado. -->

                <!-- Formulario de inicio de sesión -->
                <form action="<?php echo BASE_URL; ?>auth/login" method="POST">
                    <!-- 'action' define la ruta a la cual se enviarán los datos del formulario.
                         'method="POST"' se usa para enviar datos de forma segura. -->

                    <!-- Campo: Nombre de Usuario -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <!-- Etiqueta asociada al campo de nombre de usuario. -->

                        <div class="input-group">
                            <!-- 'input-group' agrupa el icono y el campo de entrada para mejorar la apariencia. -->
                            <span class="input-group-text" id="username-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   placeholder="Tu nombre de usuario"
                                   aria-describedby="username-addon"
                                   autocomplete="username">
                            <!-- 'type="text"' define un campo de texto.
                                 'name="username"' permite que el backend lo procese.
                                 'placeholder' muestra un texto guía dentro del campo.
                                 'aria-describedby' mejora la accesibilidad asociando el campo con su icono.
                                 'autocomplete="username"' permite que el navegador complete automáticamente el nombre de usuario. -->
                        </div>
                    </div>

                    <!-- Campo: Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Tu contraseña">
                            <!-- 'type="password"' oculta el texto para mayor seguridad. -->
                        </div>
                    </div>

                    <!-- Botón de inicio de sesión -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info">Ingresar</button>
                        <!-- 'btn-info' aplica un estilo azul al botón, indicando una acción primaria. -->
                    </div>

                    <hr>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Se incluye el modal de inicio de sesión, que puede contener mensajes de error o confirmaciones.
include __DIR__ . '/../partials/modals/modals-login.php';
?>
