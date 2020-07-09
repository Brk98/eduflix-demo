<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class MisArchivosModel extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $nombre;
    public static $descripcion;
    public static $archivo;
    public static $privado;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM archivos WHERE archivos.id_usuario = ? AND archivos.borrado ='0'");
            $stmt->execute([$_SESSION['eduflix']['id']]); 
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
            $stmt = $db->prepare("SELECT * FROM archivos WHERE archivos.id=?");
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
            $stmt = $db->prepare("INSERT INTO `archivos` (`id`, `nombre`, `descripcion`, `archivo`, `id_usuario`, `privado`, `ip`, `borrado`) VALUES (NULL, ?, ?, ?, ?, ?, ?, '0')");
            $stmt->execute([self::$nombre, self::$descripcion, self::$archivo, $_SESSION['eduflix']['id'], self::$privado, self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `archivos` SET `nombre` = ?, `descripcion` = ?, `archivo` = ?, `id_usuario` = ?, `privado` = ?, `fecham` = current_timestamp(), `ip` = ? WHERE `archivos`.`id` = ?");
            $stmt->execute([self::$nombre, self::$descripcion, self::$archivo, $_SESSION['eduflix']['id'], self::$privado, self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `archivos` SET `borrado` = '1', `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `archivos`.`id` = ?");
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
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM archivos");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
