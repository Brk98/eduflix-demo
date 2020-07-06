<?php

namespace App\Models\Admin;

use PDO;

class Categoria extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT categorias.id, categorias.categoria, categorias.activo, usuarios.usuario FROM `categorias` INNER JOIN usuarios ON categorias.id_usuario = usuarios.id WHERE categorias.borrado='0' ORDER BY `categorias`.`id` ASC");
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
            $stmt = $db->query("SELECT categorias.id, categorias.categoria, categorias.activo, usuarios.usuario FROM `categorias` INNER JOIN usuarios ON categorias.id_usuario = usuarios.id WHERE categorias.id=$id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($categoria, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("INSERT INTO `categorias` (`id`, `categoria`, `padre`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES (NULL, '$categoria', '0', '1', current_timestamp(), '', '', '1', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $categoria)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `categorias` SET `categoria` = '$categoria' WHERE `categorias`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `categorias` SET `borrado` = '1' WHERE `categorias`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}