<?php

namespace App\Models\Admin;

use App\Models\LoginModel;

use PDO;

class Categoria extends \Core\Model
{

    public static $ip;

    public static function index()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *,(SELECT usuario FROM usuarios WHERE id= id_usuario) AS usuario FROM `categorias`  WHERE borrado=? ORDER BY `id` ASC");
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
            $stmt = $db->prepare("SELECT * FROM `categorias` WHERE id=?");
            $stmt->execute([$id]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($categoria)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `categorias` (`id`, `categoria`, `padre`, `activo`,`ip`, `id_usuario`) 
            VALUES (NULL,?, '0','1',?, ?)");
            $stmt->execute([$categoria, self::$ip, $_SESSION['eduflix']['id']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $categoria, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `categorias` SET `categoria` = ?, `activo` = ?, `fecham` = current_timestamp(), `id_usuario` = ?, `ip` = ? WHERE `id` = ?");
            $stmt->execute([$categoria, $activo, $_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `categorias` SET `borrado` = '1' WHERE `id` = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
