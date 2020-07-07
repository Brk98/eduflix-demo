<?php

namespace App\Models\Admin;

use App\Models\LoginModel;

use PDO;

class Grupo extends \Core\Model
{

    public static $ip;

    public static function index()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT usuario FROM usuarios WHERE id= id_usuario) AS usuario FROM `grupos` WHERE borrado=? ORDER BY `grupos`.`id` ASC");
            $stmt->execute(['0']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtener($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM `grupos` WHERE id=?");
            $stmt->execute([$id]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($grupo, $descripcion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `grupos` (`id`, `grupo`, `descripcion`, `activo`, `ip`, `id_usuario`) 
            VALUES (NULL,?,?,'1',?, ?)");
            $stmt->execute([$grupo,$descripcion, self::$ip, $_SESSION['eduflix']['id']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $grupo, $descripcion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `grupo` = ?, `descripcion` = ?, `fecham` = current_timestamp() ,`id_usuario` = ?, `ip` = ? WHERE `id` = ?");
            $stmt->execute([$grupo, $descripcion ,$_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `borrado` = ?, `id_usuario` = ?, `ip` = ? WHERE `id` = ?");
            $stmt->execute(['1',$_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
