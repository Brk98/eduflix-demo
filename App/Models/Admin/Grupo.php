<?php

namespace App\Models\Admin;

use PDO;

class Grupo extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT grupos.id, grupos.grupo, grupos.descripcion, grupos.fecha, grupos.activo, usuarios.usuario FROM `grupos` INNER JOIN usuarios ON grupos.id_usuario = usuarios.id WHERE grupos.borrado='0' ORDER BY `grupos`.`id` ASC");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function elemento($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT grupos.id, grupos.grupo, grupos.descripcion, grupos.fecha, grupos.id_usuario FROM `grupos` INNER JOIN usuarios ON grupos.id_usuario = usuarios.id WHERE grupos.id=$id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($grupo, $descripcion, $fecha)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("INSERT INTO `grupos` (`id`, `grupo`, `descripcion`, `fecha`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES (NULL, '$grupo', '$descripcion', '$fecha','1', current_timestamp(), '', '', '1', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $grupo, $descripcion, $fecha)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `grupos` SET `grupo` = '$grupo', `descripcion` = '$descripcion', `fecha` = '$fecha' WHERE `grupos`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `grupos` SET `borrado` = '1' WHERE `grupos`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}