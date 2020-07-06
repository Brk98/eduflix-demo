<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Curso extends \Core\Model
{
    public static $ip;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT cursos.id, cursos.codigo, cursos.curso, categorias.categoria, cursos.activo, cursos.fechar FROM cursos INNER JOIN categorias ON cursos.id_categoria = categorias.id WHERE cursos.borrado='0' ORDER BY `cursos`.`id` ASC");
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
            $stmt = $db->prepare("SELECT cursos.id, cursos.codigo, cursos.curso, cursos.descripcion, cursos.imagen, cursos.id_categoria, categorias.categoria, cursos.activo, cursos.fechar FROM cursos INNER JOIN categorias ON cursos.id_categoria = categorias.id WHERE cursos.id=? ORDER BY `cursos`.`id` ASC");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function categorias()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM categorias WHERE categorias.borrado='0' ORDER BY `categorias`.`id` ASC");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($codigo, $curso, $descripcion, $id_categoria, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `cursos` (`id`, `codigo`, `curso`, `descripcion`, `id_categoria`, `activo`, `imagen`, `borrado`, `ip`, `id_usuario`) VALUES (NULL, ?, ?, ?, ?, ?, '', '0', ?, ?)");
            $stmt->execute([$codigo, $curso, $descripcion, $id_categoria, $activo, self::$ip, $_SESSION['eduflix']['id']]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $imagen, $codigo, $curso, $descripcion, $id_categoria, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `cursos` SET `imagen` = ?, `codigo` = ?, `curso` = ?, `descripcion` = ?, `id_categoria` = ?, `activo` = ?, `id_usuario` = ? , `ip` = ? WHERE `cursos`.`id` = ?");
            $stmt->execute([$imagen, $codigo, $curso, $descripcion, $id_categoria, $activo,$_SESSION['eduflix']['id'], self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `cursos` SET `borrado` = '1', `id_usuario` = ?, `ip` = ? WHERE `cursos`.`id` = ?");
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
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM cursos");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
