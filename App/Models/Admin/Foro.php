<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Foro extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $tema;
    public static $descripcion;
    public static $archivo;
    public static $id_tipo_foro;
    public static $activo;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT tipo FROM foros_tipos WHERE id = id_tipo_foro) AS tipo FROM foros WHERE borrado='0'");
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
            $stmt = $db->prepare("SELECT *, (SELECT tipo FROM foros_tipos WHERE id = id_tipo_foro) AS tipo FROM foros WHERE borrado='0' AND foros.id=?");
            $stmt->execute([self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function tipo()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM foros_tipos ORDER BY `foros_tipos`.`id` ASC");
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
            $stmt = $db->prepare("INSERT INTO `foros` (`id`, `tema`, `descripcion`, `id_tipo_foro`, `activo`, `id_usuario`, `ip`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([self::$tema, self::$descripcion, self::$id_tipo_foro, self::$activo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `foros` SET `archivo` = ?, `tema` = ?, `descripcion` = ?, `id_tipo_foro` = ?, `activo` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `foros`.`id` = ?");
            $stmt->execute([self::$archivo, self::$tema, self::$descripcion, self::$id_tipo_foro, self::$activo, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `foros` SET `borrado` = '1', `ip` = ?, `fecham` = current_timestamp() WHERE `id` = ?");
            $stmt->execute([self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function obtenerUltimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM foros");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
