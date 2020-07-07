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
            $stmt = $db->prepare("SELECT grupos.id, grupos.grupo, grupos.descripcion, grupos.activo, usuarios.usuario FROM `grupos` INNER JOIN usuarios ON grupos.id_usuario = usuarios.id WHERE grupos.borrado='0' ORDER BY `grupos`.`id` ASC");
            $stmt->execute([]);
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
            $stmt = $db->prepare("SELECT grupos.id, grupos.grupo, grupos.descripcion, grupos.id_usuario FROM `grupos` INNER JOIN usuarios ON grupos.id_usuario = usuarios.id WHERE grupos.id=?");
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
            $stmt = $db->prepare("INSERT INTO `grupos` (`id`, `grupo`, `descripcion`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) 
            VALUES (NULL,?,?,'1', current_timestamp(), '',?, ?, '0')");
            $stmt->execute([$grupo,$descripcion, $_SESSION['eduflix']['id'], self::$ip]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $grupo, $descripcion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `grupo` = '?', `descripcion` = '?', `id_usuario` = ?, `ip` = ? WHERE `grupos`.`id` = ?");
            $stmt->execute([$grupo,$descripcion, $_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `borrado` = '1', `id_usuario` = ?, `ip` = ? WHERE `grupos`.`id` = '?'");
            $stmt->execute([$_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
