<?php

// Definición de la clase `RouteController`, encargada de gestionar la carga de páginas dinámicas.
class RouteController {

    // **Método para cargar la página solicitada**
    public function loadPage($url) {
        
        // Se define el directorio donde están almacenadas las vistas.
        $viewsDirectory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR;
        // `__DIR__` obtiene el directorio actual donde se encuentra el archivo.
        // `DIRECTORY_SEPARATOR` garantiza la compatibilidad con Windows y Linux al manejar rutas de directorios.
        // Se concatena la estructura de la ruta hasta llegar a la carpeta `views/pages/`, donde están las vistas.

        // Se limpia la URL eliminando espacios y caracteres `/` al inicio y al final.
        $url = trim($url, "/ ");
        // `trim($url, "/ ")` remueve caracteres innecesarios para evitar rutas incorrectas.

        // Se construye la ruta del archivo que debería cargarse.
        $file = $viewsDirectory . $url . '.php';
        // Se concatena la ruta del directorio con el nombre de la página solicitada en `$url`, asegurando que sea un archivo `.php`.

        // **Verificación de existencia del archivo**
        if (file_exists($file)) {
            include $file; // Si el archivo existe, se incluye su contenido en la ejecución del script.
        } else {
            include $viewsDirectory . '404.php'; // Si la página solicitada no existe, se carga la vista de error `404.php`.
        }
    }

}
?>
