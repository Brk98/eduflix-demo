<?php

namespace App\Models\Admin;

use PDO;

class Foro extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT foros.id, foros.tema, foros.descripcion, foros_tipos.tipo, foros.activo, foros.fechar FROM foros INNER JOIN foros_tipos ON foros.id_tipo_foro = foros_tipos.id WHERE foros.borrado='0' ORDER BY `foros`.`id` ASC");
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
            $stmt = $db->query("SELECT foros.id, foros.tema, foros.descripcion, foros.id_tipo_foro, foros_tipos.tipo, foros.activo, foros.fechar FROM foros INNER JOIN foros_tipos ON foros.id_tipo_foro = foros_tipos.id WHERE foros.id='$id' ORDER BY `foros`.`id` ASC");
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
            $stmt = $db->query("SELECT * FROM foros_tipos ORDER BY `foros_tipos`.`id` ASC");
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
            $stmt = $db->query("INSERT INTO `foros` (`id`, `tema`, `descripcion`, `archivo`, `id_tipo_foro`, `activo`, `borrado`) VALUES (NULL, '$tema', '$descripcion', '$archivo', '$id_tipo_foro', '$activo', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $archivo, $tema, $descripcion, $id_tipo_foro, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `foros` SET `archivo` = '$archivo', `tema` = '$tema', `descripcion` = '$descripcion', `descripcion` = '$descripcion', `id_tipo_foro` = '$id_tipo_foro', `activo` = '$activo' WHERE `foros`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `foros` SET `borrado` = '1' WHERE `foros`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function ultimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT MAX(id) AS id FROM foros");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
