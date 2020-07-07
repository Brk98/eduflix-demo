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
            $stmt = $db->prepare("SELECT categorias.id, categorias.categoria, categorias.activo, usuarios.usuario FROM `categorias` INNER JOIN usuarios ON categorias.id_usuario = usuarios.id WHERE categorias.borrado='0' ORDER BY `categorias`.`id` ASC");
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
            $stmt = $db->prepare("SELECT categorias.id, categorias.categoria, categorias.activo, usuarios.usuario FROM `categorias` INNER JOIN usuarios ON categorias.id_usuario = usuarios.id WHERE categorias.id=?");
            $stmt = execute([$id]);
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
            $stmt = $db->prepare("INSERT INTO `categorias` (`id`, `categoria`, `padre`, `activo`, `fechar`, `fecham`, `ip`, `id_usuario`, `borrado`) VALUES (NULL,? '0',current_timestamp(), current_timestamp(), ?, '?', '0')");
            $stmt->execute([$categoria, $_SESSION['eduflix']['id'], self::$ip]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $categoria)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `categorias` SET `categoria` = '?', `fecham` = current_timestamp(), `id_usuario` = ?, `ip` = ? WHERE `categorias`.`id` = ?");
            $stmt->execute([$categoria, $_SESSION['eduflix']['id'], self::$ip, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `categorias` SET `borrado` = '1' WHERE `categorias`.`id` = '?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
