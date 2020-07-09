<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Usuario extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $foto;
    public static $nombre;
    public static $apaterno;
    public static $amaterno;
    public static $email;
    public static $telefono;
    public static $usuario;
    public static $password;
    public static $role;
    public static $activo;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT role FROM roles WHERE id = id_rol) AS role FROM usuarios WHERE borrado='0'");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtener()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT role FROM roles WHERE id = id_rol) AS role FROM usuarios WHERE borrado='0' AND id=?");
            $stmt->execute([self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function roles()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM roles");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `usuarios` (`id`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `usuario`, `password`, `id_rol`, `activo`, `id_usuario`,  `ip`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([self::$nombre, self::$apaterno, self::$amaterno, self::$email, self::$telefono, self::$usuario, self::$password, self::$role, self::$activo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `usuarios` SET `foto` = ?, `nombre` = ?, `apaterno` = ?, `amaterno` = ?, `email` = ?, `telefono` = ?, `usuario` = ?, `password` = ?, `id_rol` = ?, `activo` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `id` = ?");
            $stmt->execute([self::$foto, self::$nombre, self::$apaterno, self::$amaterno, self::$email, self::$telefono, self::$usuario, self::$password, self::$role, self::$activo, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `usuarios` SET `borrado` = '1', `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `id` = ?");
            $stmt->execute([$_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUltimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM usuarios");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
