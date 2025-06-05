<?php

// Se requiere el modelo `User`, que maneja la autenticación y gestión de usuarios en la base de datos.
require_once __DIR__ . '/../models/User.php';


// **Definición de la clase `AuthController`**
// Esta clase maneja la autenticación de usuarios, incluyendo el registro, inicio de sesión y cierre de sesión.
class AuthController
{

    // **Método para iniciar sesión**
    public function login()
    {
        // Se inicia la sesión si no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Se verifica que la solicitud se haga con `POST`.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // **Validaciones antes del inicio de sesión**
            if (empty($username)) { // Verifica si la variable $username está vacía (no definida o sin valor)
                $_SESSION['error'] = "El nombre de usuario es obligatorio"; // Guarda un mensaje de error en la sesión
                error_log("Error de sesión: " . $_SESSION['error']); // Escribe el error en el log del servidor para fines de depuración
                header("Location: " . BASE_URL . "auth/login/"); // Redirige al usuario a la página de login
                exit(); // Detiene la ejecución del script para evitar que se siga procesando
            }

            if (empty($password)) {
                $_SESSION['error'] = "La contraseña es obligatoria";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

            // **Autenticación del usuario**
            $userModel = new User(); // Crea una nueva instancia del modelo User (posiblemente conectado a la base de datos)
            $user = $userModel->authenticate($username, $password); // Llama al método authenticate para verificar si el usuario y contraseña son válidos

            if ($user) { // Si se encuentra un usuario válido (no es false ni null)
                $_SESSION['user'] = [ // Guarda los datos principales del usuario en la sesión
                    'user_id' => $user['user_id'], // ID único del usuario
                    'username' => $user['username'], // Nombre de usuario
                    'email' => $user['email'], // Correo electrónico del usuario
                    'level_user' => $user['level_user'], // Nivel o rol del usuario (ej. Administrador, Director)
                    'created_at' => $user['created_at'], // Fecha de creación de la cuenta
                    'updated_at' => $user['updated_at'], // Última actualización del perfil
                    'img_url'    => $user['img_url'], // URL de la imagen de perfil del usuario
                    'description_level' => $user['description_level'] // Descripción del nivel de usuario
                    
                ];

                $_SESSION['flash'] = "Bienvenido, " . htmlspecialchars($user['username']); // Mensaje de bienvenida seguro contra inyección de HTML
                header("Location: " . BASE_URL . "dashboard"); // Redirige al usuario al panel principal después de iniciar sesión correctamente
                exit; // Detiene la ejecución para evitar seguir procesando el script
            } else {
                $_SESSION['error'] = "Error en login, Usuario o Contraseña Incorrectos"; // Guarda un mensaje de error en la sesión si no se encuentra el usuario
                error_log("Error de sesión: " . $_SESSION['error']); // Registra el error en el log del servidor
                header("Location: " . BASE_URL . "auth/login/"); // Redirige al usuario nuevamente al formulario de login
                exit(); // Detiene la ejecución del script
            }
        } else {
            include __DIR__ . '/../views/pages/login.php';
        }
    }

    // **Método para cerrar sesión**
    public function logout()
    {
        // Se inicia la sesión solo si no está activa.
        // Esto asegura que podamos manipular la sesión aunque aún no se haya iniciado explícitamente.
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia la sesión si no se ha iniciado aún
        }

        $_SESSION = array(); // Se vacía completamente la variable de sesión. Esto elimina todos los datos guardados del usuario (como 'user', 'flash', etc.)

        // Verifica si las sesiones usan cookies (lo normal en la mayoría de los servidores).
        if (ini_get("session.use_cookies")) {
            // Obtiene los parámetros actuales de la cookie de sesión.
            $params = session_get_cookie_params();

            // Elimina la cookie de sesión del navegador.
            // Esto se hace estableciendo una cookie con el mismo nombre pero con tiempo de expiración en el pasado (time() - 42000).
            setcookie(
                session_name(),     // Nombre de la cookie de sesión (por defecto: PHPSESSID)
                '',                 // Valor vacío para eliminar
                time() - 42000,     // Expiración pasada para forzar su eliminación
                $params["path"],    // Ruta donde se aplica la cookie
                $params["domain"],  // Dominio al que pertenece la cookie
                $params["secure"],  // Solo HTTPS si estaba activa
                $params["httponly"] // Evita que sea accedida desde JavaScript si estaba activa
            );
        }

        session_destroy(); // Destruye completamente la sesión en el servidor (el archivo de sesión es eliminado).

        // Redirige al usuario a la pantalla de login después de cerrar sesión.
        header("Location: " . BASE_URL . "auth/login/");
        exit(); // Detiene completamente la ejecución del script
    }
    
}
