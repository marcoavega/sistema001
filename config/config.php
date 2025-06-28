<?php
// **Configuración de errores en PHP**
// Se activan los mensajes de error para desarrollo, facilitando la detección de problemas.
ini_set('display_errors', 1); // Muestra los errores en pantalla.
ini_set('display_startup_errors', 1); // Muestra errores que ocurren durante el arranque de PHP.
error_reporting(E_ALL); // Se configuran todos los niveles de error para reportar cualquier problema.

// **Definición de constantes globales**
// Estas constantes se usan en todo el sistema para evitar redundancia y facilitar cambios futuros.

// **URL Base del sistema**
define('BASE_URL', 'http://localhost/sistema001/');
// Define la URL base del sistema, útil para generar enlaces en la aplicación.

// **Nombre de la aplicación**
define('APP_NAME','SISTEMA DE GESTIÓN'); 
// Define el nombre del sistema, puede ser útil para mostrarlo en títulos y encabezados.

// **Credenciales de la Base de Datos**
define('DB_HOST','localhost'); // Dirección del servidor de la base de datos.
define('DB_NAME','sistema'); // Nombre de la base de datos usada por la aplicación.
define('DB_USER','root'); // Usuario de la base de datos (en entornos de producción se recomienda cambiar esto).
define('DB_PASS',''); // Contraseña del usuario de la base de datos (en producción nunca debe estar en código público).

// **Configuración de la sesión**
define('APP_SESSION_NAME','sistema001_session'); 
// Define el nombre de la cookie de sesión, usado para evitar colisiones con otras aplicaciones en el mismo servidor.

define('APP_SESSION_TIME','3600'); // 1 hora (3600 segundos) 
// Establece la duración de la sesión, tras este tiempo inactivo el usuario debe volver a autenticarse.

define('PRODUCT_IMAGE_DIR', __DIR__ . '/../../assets/images/products/'); 
// ruta absoluta en el FS al directorio de imágenes de productos
define('PRODUCT_IMAGE_URL_PATH', BASE_URL . 'assets/images/products/'); 
// URL base para servir las imágenes (para guardar en BD se guarda solo el nombre o ruta relativa).

?>
