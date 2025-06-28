<?php
// controllers/Logger.php

require_once __DIR__ . '/../models/Database.php';

class Logger
{
    /**
     * Registra una acción de usuario en la tabla user_logs.
     *
     * @param int    $user_id El ID del usuario.
     * @param string $action  'login' o 'logout'.
     */
    public static function logAction(int $user_id, string $action): void
    {
        try {
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("
                INSERT INTO user_logs (user_id, action)
                VALUES (:user_id, :action)
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':action'  => $action,
            ]);
        } catch (\PDOException $e) {
            // Para depuración, registra el error en el log de PHP
            error_log("Logger error: " . $e->getMessage());
        }
    }
}
