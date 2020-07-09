<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Generacion extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $generacion;
    public static $descripcion;
    public static $activo;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT usuario FROM usuarios WHERE id=id_usuario) AS usuario FROM generaciones WHERE borrado='?'");
            $stmt->execute([0]); 
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
            $stmt = $db->prepare("SELECT *, (SELECT usuario FROM usuarios WHERE id=id_usuario) AS usuario FROM generaciones WHERE id=?");
            $stmt->execute([self::$id]); 
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
            $stmt = $db->prepare("INSERT INTO generaciones (generacion, descripcion, activo, id_usuario, ip) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([self::$generacion, self::$descripcion, self::$activo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE generaciones SET generacion = ?, descripcion = ?, activo = ?, id_usuario = ?, ip = ?, fecham = current_timestamp() WHERE id = ?");
            $stmt->execute([self::$generacion, self::$descripcion, self::$activo, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE generaciones SET borrado = ?, id_usuario = ?, ip = ?, fecham = current_timestamp() WHERE id = ?");
            $stmt->execute([1, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
