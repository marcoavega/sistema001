<?php
// **Verificación y configuración de la sesión**
if (session_status() === PHP_SESSION_NONE) {
    // `session_status()` verifica el estado actual de la sesión.
    // `PHP_SESSION_NONE` indica que no hay una sesión activa, por lo que se debe iniciar.

    session_set_cookie_params([
        'lifetime' => 0, // La sesión expira cuando se cierra el navegador.
        'path'     => ini_get('session.cookie_path'), // Obtiene el valor configurado en PHP para la ruta de cookies.
        'domain'   => '', // En desarrollo, puede dejarse vacío o ajustarse según el servidor.
        'secure'   => false, // `false` indica que la cookie de sesión no requiere HTTPS (para entornos sin SSL).
        'httponly' => true, // La cookie solo será accesible vía HTTP, evitando accesos desde JavaScript y reforzando seguridad.
        'samesite' => 'Lax'  // `Lax` permite compartir cookies en el mismo sitio sin riesgos de CSRF en formularios.
    ]);

    session_start(); // Inicia la sesión para almacenar datos del usuario en la variable global $_SESSION.
}

// **Control de tiempo de sesión**
$expirationTime = 36000; // Se define el tiempo de vida de la sesión en segundos (1 hora).

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $expirationTime) {
    // `$_SESSION['LAST_ACTIVITY']` almacena el tiempo de la última actividad del usuario.
    // Si la diferencia entre el tiempo actual (`time()`) y `LAST_ACTIVITY` supera `$expirationTime`, la sesión expira.

    session_unset(); // Elimina todas las variables de sesión activas.
    session_destroy(); // Destruye la sesión completamente.

    header("Location: " . BASE_URL . "auth/login/"); // Redirige al usuario al login tras la expiración de la sesión.
    exit(); // Finaliza la ejecución del script para evitar que siga procesando código después de la redirección.
}

// **Actualizar la actividad de la sesión**
$_SESSION['LAST_ACTIVITY'] = time(); // Cada vez que se ejecuta el script, se actualiza el timestamp de la sesión.
?>
