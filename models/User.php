<?php

require_once __DIR__ . '/../config/config.php';

class User {

    private $db;

    public function __construct(){
        
        require_once __DIR__ . '/Database.php';

        $database = new Database();

        $this->db = $database->getConnection();

    }

    public function authenticate($username, $password){
        //$sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $sql = "SELECT users.*, levels_users.description_level FROM users LEFT JOIN levels_users ON users.level_user = levels_users.level WHERE users.username = :username LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam('username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            return $user;
        }

        return false;
    }

     public function updateUserById($userID, $data){
        $sql = "UPDATE users SET username = :username, email = :email, level_user = :level_user, img_url = :img_url WHERE user_ir = :user_id";
        
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':level_user', $data['level_user']);
        $stmt->bindParam(":img_url", $data['img_url']);
          $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

          return $stmt->execute();
     }


      // **Método para eliminar un usuario por su ID**
    public function deleteUserById($userID)
    {
        // Se define la consulta SQL para eliminar el usuario de la base de datos.
        $sql = "DELETE FROM users WHERE user_id = :user_id";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vincula el parámetro `:user_id` con el ID recibido.
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Se ejecuta la consulta y se devuelve `true` si fue exitosa.
        return $stmt->execute();
    }


}