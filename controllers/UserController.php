<?php
// Se requiere el modelo de usuario y la conexión a la base de datos para gestionar las operaciones de usuario.
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Database.php';

// Definición de la clase `UserController`, que se encarga de manejar las operaciones sobre usuarios.
class UserController
{

    // Propiedad privada que almacena la instancia del modelo de usuario.
    private $userModel;

    // **Constructor**: Se ejecuta cuando se instancia la clase.
    public function __construct()
    {
        $this->userModel = new User(); // Se crea una instancia del modelo `User`.
    }

    // **Método para obtener todos los usuarios**
    public function getAllUsers()
    {
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.

        // Se ejecuta una consulta SQL para obtener todos los usuarios y sus datos principales.
        $stmt = $pdo->query("SELECT 
    users.user_id,
    users.username,
    users.email,
    users.level_user,
    users.created_at,
    users.updated_at,
    users.img_url,
    levels_users.description_level
FROM users
JOIN levels_users ON users.level_user = levels_users.id_level_user
ORDER BY users.user_id ASC
");

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve el resultado como un array asociativo.
    }

    // **Método para actualizar un usuario**
    public function updateUser($data)
{
    $dbInstance = new Database();
    $pdo = $dbInstance->getConnection();

    // Comenzar con el update dinámico
    $fields = [
        'username = :username',
        'email = :email',
        'level_user = :level_user'
    ];

    // Si viene una nueva contraseña, la añadimos
    if (!empty($data['password'])) {
        $fields[] = 'password = :password';
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
    }

    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);

    // Bind comunes
    $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);

    // Bind condicional para password
    if (!empty($data['password'])) {
        $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
    }

    if ($stmt->execute()) {
        // Obtener el usuario actualizado
        $query = $pdo->prepare("SELECT 
            users.user_id,
            users.username,
            users.email,
            users.level_user,
            users.created_at,
            users.updated_at,
            users.img_url,
            levels_users.description_level
        FROM users
        JOIN levels_users ON users.level_user = levels_users.id_level_user
        WHERE users.user_id = :user_id");

        $query->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $query->execute();

        $updatedUser = $query->fetch(PDO::FETCH_ASSOC);

        return [
            "success" => true,
            "user" => $updatedUser
        ];
    } else {
        return ["success" => false, "message" => "No se pudo actualizar"];
    }
}


    // **Método para actualizar el perfil del usuario**
    public function updateProfile($userID, $data)
    {
        $db = (new Database())->getConnection();

        // Validar que no haya otro usuario con el mismo nombre
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username AND user_id != :id");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'El nombre de usuario ya está registrado por otro usuario.'
            ];
        }

        // Validar que no haya otro usuario con el mismo email
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :id");
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'El correo electrónico ya está registrado por otro usuario.'
            ];
        }

        // Comenzar con el update dinámico
        $fields = [];
        if (isset($data['username'])) $fields[] = 'username = :username';
        if (isset($data['email'])) $fields[] = 'email = :email';
        if (isset($data['password'])) $fields[] = 'password = :password';
        if (isset($data['img_url'])) $fields[] = 'img_url = :img_url';

        if (empty($fields)) {
            return ['success' => false, 'message' => 'No hay datos para actualizar.'];
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE user_id = :id";
        $stmt = $db->prepare($sql);

        // Asignar valores
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        if (isset($data['username'])) $stmt->bindParam(':username', $data['username']);
        if (isset($data['email'])) $stmt->bindParam(':email', $data['email']);
        if (isset($data['img_url'])) $stmt->bindParam(':img_url', $data['img_url']);
        if (isset($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return [
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $stmt->errorInfo()[2]
            ];
        }
    }



    // **Método para eliminar un usuario**
    public function deleteUser($userID)
    {
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.

        // Se prepara la consulta SQL para eliminar el usuario por su ID.
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Se ejecuta la consulta y se captura cualquier error.
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ["success" => false, "message" => "No se pudo eliminar: " . $errorInfo[2]];
        }
    }

    // **Método para crear un nuevo usuario**
    public function createUser($data)
    {
        $db = (new Database())->getConnection();

        // Validación básica y segura
        if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['level_user'])) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
        }

        // Validar el correo electrónico con filtro
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'El correo electrónico no es válido'];
        }

        // Validar longitud mínima del nombre de usuario
        if (strlen($data['username']) < 3) {
            return ['success' => false, 'message' => 'El nombre de usuario debe tener al menos 3 caracteres'];
        }

        // Validar longitud mínima de la contraseña
        if (strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'];
        }

        // Validar que el nivel sea un número entero
        if (!filter_var($data['level_user'], FILTER_VALIDATE_INT)) {
            return ['success' => false, 'message' => 'El nivel de usuario debe ser un número entero'];
        }

        // Comprobamos si ya existe un usuario con el mismo email o username
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
        $checkStmt->bindParam(':email', $data['email']);
        $checkStmt->bindParam(':username', $data['username']);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Ya existe un usuario con ese correo o nombre de usuario'];
        }

        // Crear el usuario
        $stmt = $db->prepare("INSERT INTO users (username, email, password, level_user) VALUES (:username, :email, :password, :level_user)");
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $id = $db->lastInsertId();

            $new = $db->prepare("SELECT * FROM users WHERE user_id = :id");
            $new->bindParam(':id', $id, PDO::PARAM_INT);
            $new->execute();
            $user = $new->fetch(PDO::FETCH_ASSOC);

            return ['success' => true, 'user' => $user];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ['success' => false, 'message' => 'No se pudo crear el usuario: ' . $errorInfo[2]];
        }
    }
}
