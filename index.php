<?php
// Importa la configuración del sistema, donde pueden estar las credenciales, rutas base y otros parámetros importantes
require_once 'config/config.php';

// Inicia la sesión del usuario, asegurando que las variables de sesión estén disponibles en todas las páginas
include __DIR__ . '/views/inc/session_start.php';

// Incluye el archivo "head.php", contiene la estructura del encabezado HTML (metadatos, enlaces a CSS, etc.)
include __DIR__ . '/views/partials/head.php';

// Obtiene la URL enviada en la petición GET y, si no se proporciona, por defecto carga 'login'
$url = isset($_GET['url']) ? $_GET['url'] : 'login';

// Divide la URL en partes separadas usando "/"
// Ejemplo: "auth/login" se dividiría en ['auth', 'login']
$parts = explode('/', $url);

// Si la primera parte de la URL es "auth", significa que es una acción de autenticación
if ($parts[0] == 'auth'){
    
    // Importa el controlador de autenticación, el cual maneja el inicio de sesión, registro y cierre de sesión
    require_once 'controllers/AuthController.php';
    
    // Crea una instancia del controlador de autenticación
    $auth = new AuthController();

    // Obtiene la segunda parte de la URL como la acción a ejecutar-
    // Ejemplo: si la URL es "auth/login", $action será "login"
    $action = isset($parts[1]) ? trim($parts[1], "/ ") : '';

    // Verifica si la acción existe como un método dentro de AuthController
    if ($action !== "" && method_exists($auth, $action)) {
        // Si el método existe, se ejecuta dinámicamente
        $auth->$action();
    } else {
        // Si el método no existe, muestra un mensaje de error
        echo "<h1>Error: Acción no encontrada en AuthController.</h1>";
    }
} else {
    
    // Si la URL no está relacionada con autenticación, se usa RouteController para cargar la página correspondiente
    require_once 'controllers/RouteController.php';

    // Se crea una instancia del controlador de rutas
    $controller = new RouteController();

    // Se carga la página que corresponde a la URL proporcionada
    $controller->loadPage($url);
}

// Incluye el pie de página, donde pueden estar los scripts de cierre y otras configuraciones finales
include __DIR__ . '/views/partials/footer.php';

