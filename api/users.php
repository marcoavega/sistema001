<?php
// **Establece el encabezado para asegurarse de que la respuesta sea en formato JSON**.
// `header('Content-Type: application/json')` le indica al navegador y al cliente que la respuesta
// será en formato JSON, lo que facilita su interpretación en aplicaciones web.
header('Content-Type: application/json');

// **Importa archivos requeridos**.
// `require_once` se usa para incluir archivos sin riesgo de duplicación.
require_once __DIR__ . '/../config/config.php'; // Carga la configuración global del sistema.
require_once __DIR__ . '/../controllers/UserController.php'; // Importa el controlador de usuarios.

// **Obtiene la acción enviada en la petición HTTP**.
// `$_GET['action'] ?? ''` significa que si no se envía `action`, la variable tendrá un valor vacío (`''`).
$action = $_GET['action'] ?? '';

// **Crea una instancia del controlador de usuarios** para gestionar las operaciones.
$userController = new UserController();

// **Maneja las diferentes acciones solicitadas en la API**.
// `switch` permite ejecutar distintas partes del código según el valor de `$action`.
switch ($action) {

    case 'get':
        // **Obtiene todos los usuarios desde el controlador**.
        $users = $userController->getAllUsers();

        // **Convierte el resultado en JSON y lo muestra**.
        echo json_encode($users);
        break;

    case 'update':
        // **Recibe y decodifica los datos enviados en la solicitud**.
        // `file_get_contents("php://input")` obtiene el cuerpo de la petición HTTP.
        // `json_decode(..., true)` convierte el JSON en un array asociativo.
        $data = json_decode(file_get_contents("php://input"), true);

        // **Actualiza la información del usuario con los datos recibidos**.
        $result = $userController->updateUser($data['userData'] ?? []);

        // **Envía la respuesta JSON según el resultado obtenido**.
        if ($result['success']) {
            echo json_encode([
                "success" => true,
                "message" => "Usuario actualizado correctamente",
                "updatedData" => $result['user'] // Aquí debe estar description_level
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No se pudo actualizar"
            ]);
        }
        break;

    case 'delete':
        // **Recibe el user_id desde el JSON para eliminar un usuario**.
        $data = json_decode(file_get_contents("php://input"), true);
        $userID = $data['user_id'] ?? null;

        // **Validar que se haya proporcionado un ID válido**
        if ($userID === null || !is_numeric($userID)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID de usuario no proporcionado o inválido.'
            ]);
            break;
        }

        // **Elimina al usuario según el ID recibido**.
        $result = $userController->deleteUser((int)$userID);

        // **Devuelve el resultado en formato JSON**.
        echo json_encode($result);
        break;


    case 'create':
        // **Recibe los datos enviados en formato JSON**.
        $data = json_decode(file_get_contents('php://input'), true)['userData'] ?? [];

        // **Llama al controlador para crear un usuario con los datos recibidos**.
        $result = $userController->createUser($data);

        // **Devuelve la respuesta JSON según el éxito o fallo en la creación del usuario**.
        if ($result['success']) {
            echo json_encode(['success' => true, 'newUser' => $result['user']]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        break;

    default:
        // **Si la acción solicitada no está definida, se envía un mensaje de error en formato JSON**.
        echo json_encode(["error" => "Acción no definida"]);
        break;
}

// **Finaliza la ejecución del script para evitar procesamiento innecesario**.
exit();
