<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Conferencia extends \Core\Model
{
    public static $ip;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT conferencias.id, conferencias.conferencia, conferencias.descripcion, conferencias.fecha, conferencias.horario, conferencias.duracion, conferencias.activo, usuarios.usuario FROM `conferencias` INNER JOIN usuarios ON conferencias.id_usuario = usuarios.id WHERE conferencias.borrado='0' ORDER BY `conferencias`.`id` ASC");
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
            $stmt = $db->prepare("SELECT conferencias.id, conferencias.conferencia, conferencias.descripcion, conferencias.fecha, conferencias.horario, conferencias.duracion, conferencias.activo, usuarios.usuario, conferencias.id_usuario FROM `conferencias` INNER JOIN usuarios ON conferencias.id_usuario = usuarios.id WHERE conferencias.id=?");
            $stmt->execute([$id]); 
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
            $stmt = $db->prepare("INSERT INTO `conferencias` (`id`, `conferencia`, `descripcion`, `fecha`, `horario`, `duracion`, `activo`, `fechar`, `fecham`, `id_usuario`, `borrado`, `ip`) VALUES (NULL, ?, ?, ?, ?, ?, '1', current_timestamp(), '', ?, '0', ?)");
            $stmt->execute([$conferencia, $descripcion, $fecha, $horario, $duracion, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $conferencia, $descripcion, $fecha, $horario, $duracion)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `conferencias` SET `conferencia` = ?, `descripcion` = ?, `fecha` = ?, `horario` = ?, `duracion` = ?, `id_usuario` = ?, `ip` = ? WHERE `conferencias`.`id` = ?");
            $stmt->execute([$conferencia, $descripcion, $fecha, $horario, $duracion, $_SESSION['eduflix']['id'], self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `conferencias` SET `borrado` = '1', `id_usuario` = ?, `ip` = ? WHERE `conferencias`.`id` = ?");
            $stmt->execute([$_SESSION['eduflix']['id'], self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
