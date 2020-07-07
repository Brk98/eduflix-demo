<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Foro extends \Core\Model
{
    public static $ip;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT foros.id, foros.tema, foros.descripcion, foros_tipos.tipo, foros.activo, foros.fechar FROM foros INNER JOIN foros_tipos ON foros.id_tipo_foro = foros_tipos.id WHERE foros.borrado='0' ORDER BY `foros`.`id` ASC");
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
            $stmt = $db->prepare("SELECT foros.id, foros.tema, foros.descripcion, foros.id_tipo_foro, foros_tipos.tipo, foros.activo, foros.fechar FROM foros INNER JOIN foros_tipos ON foros.id_tipo_foro = foros_tipos.id WHERE foros.id=? ORDER BY `foros`.`id` ASC");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function tipo()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM foros_tipos ORDER BY `foros_tipos`.`id` ASC");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($tema, $descripcion, $archivo, $id_tipo_foro, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `foros` (`id`, `tema`, `descripcion`, `archivo`, `id_tipo_foro`, `activo`, `borrado`, `id_usuario`, `ip`) VALUES (NULL, ?, ?, ?, ?, ?, '0', ?, ?)");
            $stmt->execute([$tema, $descripcion, $archivo, $id_tipo_foro, $activo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $archivo, $tema, $descripcion, $id_tipo_foro, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `foros` SET `archivo` = ?, `tema` = ?, `descripcion` = ?, `id_tipo_foro` = ?, `activo` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `foros`.`id` = ?");
            $stmt->execute([$archivo, $tema, $descripcion, $id_tipo_foro, $activo, $_SESSION['eduflix']['id'], self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `foros` SET `borrado` = '1', `ip` = ?, `fecham` = current_timestamp() WHERE `foros`.`id` = ?");
            $stmt->execute([self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function obtenerUltimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM foros");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
