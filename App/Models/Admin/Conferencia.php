<?php

namespace App\Models\Admin;

use PDO;

class Conferencia extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT conferencias.id, conferencias.conferencia, conferencias.descripcion, conferencias.fecha, conferencias.horario, conferencias.duracion, conferencias.activo, usuarios.usuario FROM `conferencias` INNER JOIN usuarios ON conferencias.id_usuario = usuarios.id WHERE conferencias.borrado='0' ORDER BY `conferencias`.`id` ASC");
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
            $stmt = $db->query("SELECT conferencias.id, conferencias.conferencia, conferencias.descripcion, conferencias.fecha, conferencias.horario, conferencias.duracion, conferencias.activo, usuarios.usuario, conferencias.id_usuario FROM `conferencias` INNER JOIN usuarios ON conferencias.id_usuario = usuarios.id WHERE conferencias.id=$id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($conferencia, $descripcion, $fecha, $horario, $duracion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("INSERT INTO `conferencias` (`id`, `conferencia`, `descripcion`, `fecha`, `horario`, `duracion`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES (NULL, '$conferencia', '$descripcion', '$fecha', '$horario', '$duracion', '1', current_timestamp(), '', '', '1', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $conferencia, $descripcion, $fecha, $horario, $duracion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `conferencias` SET `conferencia` = '$conferencia', `descripcion` = '$descripcion', `fecha` = '$fecha', `horario` = '$horario', `duracion` = '$duracion' WHERE `conferencias`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `conferencias` SET `borrado` = '1' WHERE `conferencias`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
