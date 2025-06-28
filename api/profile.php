<?php
// **Establece el encabezado para asegurarse de que la respuesta sea en formato JSON**
// `header('Content-Type: application/json');` le indica al navegador y al cliente que la respuesta
// será en formato JSON, lo que facilita su interpretación en aplicaciones web.
header('Content-Type: application/json');

// **Inicia la sesión** para poder acceder a los datos del usuario actual.
session_start();

// ------------------------------------------------------------------
// **Verificación de la sesión**
// Se comprueba si el usuario está autenticado antes de permitir cualquier acción.
// Si no hay una sesión activa o el ID del usuario no está definido, se devuelve un error.
// ------------------------------------------------------------------
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    echo json_encode(["success" => false, "message" => "Acceso no autorizado"]);
    exit(); // Detiene la ejecución para evitar que el código continúe.
}

// **Incluye los archivos de configuración y el controlador de usuarios**
// `require_once` se usa para evitar la inclusión duplicada de archivos.
require_once __DIR__ . '/../config/config.php'; // Carga configuración global.
require_once __DIR__ . '/../controllers/UserController.php'; // Controlador para gestionar usuarios.

// **Obtiene la acción enviada en la solicitud HTTP**
// Si la acción no está definida en `$_GET['action']`, se asigna una cadena vacía (`''`).
$action = $_GET['action'] ?? '';

// ------------------------------------------------------------------
// **Caso: Actualización de perfil**
// Si la acción enviada es 'update', se procede a actualizar los datos del usuario.
// ------------------------------------------------------------------
if ($action === 'update') {
    // **Recibir datos vía POST**
    // Se usa `trim()` para eliminar espacios innecesarios en los datos ingresados.
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // No se usa `trim()` porque las contraseñas pueden contener espacios.
    $passwordConfirm = $_POST['password_confirm'] ?? ''; // Confirmación de contraseña.

    // **Validación básica de datos**
    // Se verifica que los campos obligatorios no estén vacíos.
    if (empty($username) || empty($email)) {
        echo json_encode(["success" => false, "message" => "Datos inválidos"]);
        exit();
    }

    // **Se prepara el array de datos que serán actualizados**
    $data = [];
    $data['username'] = $username;
    $data['email'] = $email;
    if (!empty($password)) {
        $data['password'] = $password; // Solo se actualiza la contraseña si se proporciona.
    }


    

    if (!empty($password) && $password !== $passwordConfirm) {
        echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden"]);
        exit();
    }


    // ------------------------------------------------------------------
    // **Procesar la imagen de perfil si se envió**
    // Se verifica si el usuario subió una imagen y si no hay errores en la carga.
    // ------------------------------------------------------------------
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === 0) {
        // **Validar tipo de archivo**
        // Solo se permiten imágenes JPEG, PNG y GIF.
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['user_image']['type'], $allowedTypes)) {
            echo json_encode(["success" => false, "message" => "Tipo de imagen no permitido."]);
            exit();
        }

        // **Validar tamaño del archivo**
        // El límite de tamaño es de 2MB (2097152 bytes).
        $maxSize = 2097152;
        if ($_FILES['user_image']['size'] > $maxSize) {
            echo json_encode(["success" => false, "message" => "El tamaño de la imagen debe ser menor a 2MB."]);
            exit();
        }

        // **Obtener la extensión de la imagen en minúsculas**
        $ext = strtolower(pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION));

        // **Definir la ruta donde se guardará la imagen**
        $destinationDir = __DIR__ . "/../assets/images/users/";

        // Si el directorio de imágenes no existe, lo crea con permisos 0755.
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        // **Nombre del archivo basado en el nombre de usuario**
        $destination = $destinationDir . $username . "." . $ext;

        // **Mover el archivo desde la ubicación temporal al destino**
        if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $destination)) {
            echo json_encode(["success" => false, "message" => "Error al subir la imagen."]);
            exit();
        }

        // **Guardar la URL relativa de la imagen en el array de datos**
        $data['img_url'] = "assets/images/users/" . $username . "." . $ext;

        // **Actualizar la sesión para que se muestre la imagen en la interfaz**
        $_SESSION['user']['img_url'] = $data['img_url'];
    }

    // ------------------------------------------------------------------
    // **Actualización de perfil en la base de datos**
    // Se crea una instancia del controlador de usuarios y se ejecuta la actualización.
    // ------------------------------------------------------------------
    $userController = new UserController();
    $userID = $_SESSION['user']['user_id'];
    $updateResult = $userController->updateProfile($userID, $data);

    // ------------------------------------------------------------------
    // **Si la actualización es exitosa, también se actualiza la sesión**
    // Esto permite que los nuevos valores se reflejen en el sistema sin necesidad de un nuevo inicio de sesión.
    // ------------------------------------------------------------------
    if ($updateResult['success']) {
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        if (isset($data['img_url'])) {
            $_SESSION['user']['img_url'] = $data['img_url'];
        }
        echo json_encode([
            "success" => true,
            "message" => "Perfil actualizado correctamente",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $updateResult['message'],
        ]);
    }
    exit();
}

// ------------------------------------------------------------------
// **Si la acción enviada no es válida, se devuelve un mensaje de error**
// Esto evita que se ejecuten procesos desconocidos y ayuda a la depuración.
// ------------------------------------------------------------------
echo json_encode(["success" => false, "message" => "Acción no válida"]);
exit();
