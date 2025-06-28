<?php

// Se requiere el archivo de configuración, donde se encuentran las constantes 
// para la conexión a la base de datos, como el nombre del host, usuario y contraseña.
require_once __DIR__ . '/../config/config.php';

// Se define la clase `Database`, que maneja la conexión a la base de datos.
class Database
{

    // Propiedad privada para almacenar la conexión PDO con la base de datos.
    private $connection;

    // **Método constructor**: Se ejecuta automáticamente cuando se crea una instancia de la clase.
    public function __construct()
    {
        try {
            // Se construye la cadena de conexión DSN con las credenciales definidas en `config.php`
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            // `DB_HOST` y `DB_NAME` son constantes definidas en el archivo de configuración.
            // `charset=utf8mb4` garantiza la compatibilidad con caracteres especiales y emojis.

            // Se crea la conexión utilizando PDO (PHP Data Objects).
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            // `DB_USER` y `DB_PASS` son las credenciales de acceso a la base de datos.
            // Se pasan como segundo y tercer argumento al objeto PDO.

            // Se establecen atributos de configuración para mejorar el manejo de errores.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // `PDO::ATTR_ERRMODE` define cómo manejar errores.
            // `PDO::ERRMODE_EXCEPTION` hace que PDO lance excepciones en caso de error.
        } 
        
        // Se captura cualquier error en la conexión usando `PDOException`.
        catch (PDOException $e) {
            // Si ocurre un error, se detiene la ejecución y se muestra un mensaje de fallo.
            die("Fallo en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // **Método para obtener la conexión a la base de datos**
    public function getConnection()
    {
        return $this->connection; // Retorna la conexión PDO creada en el constructor.
    }

}
