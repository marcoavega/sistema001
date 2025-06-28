<?php

// Se requiere el modelo `User`, que maneja la autenticación y gestión de usuarios en la base de datos.
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/Logger.php';  // 1. Importa el Logger


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

                // Registrar el login
            Logger::logAction($user['user_id'], 'login');

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
    // Si el usuario está logueado, guarda el evento
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user']['user_id'])) {
        Logger::logAction($_SESSION['user']['user_id'], 'logout');
    }

    // --- tu código existente para destruir la sesión ---
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

    
}
