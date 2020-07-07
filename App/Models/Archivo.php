<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class Archivo extends \Core\Model
{
    public static $ip;

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

    public static function obtener($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM archivos WHERE archivos.id=?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($nombre, $descripcion, $archivo, $privado)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `archivos` (`id`, `nombre`, `descripcion`, `archivo`, `id_usuario`, `privado`, `ip`, `borrado`) VALUES (NULL, ?, ?, ?, ?, ?, ?, '0')");
            $stmt->execute([$nombre, $descripcion, $archivo, $_SESSION['eduflix']['id'], $privado, self::$ip,]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $nombre, $descripcion, $archivo, $privado)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `archivos` SET `nombre` = ?, `descripcion` = ?, `archivo` = ?, `id_usuario` = ?, `privado` = ?, `fecham` = current_timestamp(), `ip` = ? WHERE `archivos`.`id` = ?");
            $stmt->execute([$nombre, $descripcion, $archivo, $_SESSION['eduflix']['id'], $privado, self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `archivos` SET `borrado` = '1', `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `archivos`.`id` = ?");
            $stmt->execute([$_SESSION['eduflix']['id'], self::$ip, $id]); 
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
