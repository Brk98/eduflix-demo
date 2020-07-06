<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 */
class LoginModel extends \Core\Model
{

    public static $usuario = "";
    public static $password = "";

     
    /**
     * Validamos si el usuario existe en la base de datos
     *
     * @return array
     */
    public static function validarUsuario()
    {
       
        try {
           
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario=? AND password=? AND activo =1 AND borrado = 0");
            $stmt->execute([self::$usuario,self::$password]); 
            $usuario = $stmt->fetch();

            return $usuario;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
