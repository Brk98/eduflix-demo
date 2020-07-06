<?php

namespace App\Models\Admin;

use PDO;

class Curso extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT cursos.id, cursos.codigo, cursos.curso, categorias.categoria, cursos.activo, cursos.fechar FROM cursos INNER JOIN categorias ON cursos.id_categoria = categorias.id WHERE cursos.borrado='0' ORDER BY `cursos`.`id` ASC");
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
            $stmt = $db->query("SELECT cursos.id, cursos.codigo, cursos.curso, cursos.descripcion, cursos.imagen, cursos.id_categoria, categorias.categoria, cursos.activo, cursos.fechar FROM cursos INNER JOIN categorias ON cursos.id_categoria = categorias.id WHERE cursos.id='$id' ORDER BY `cursos`.`id` ASC");
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
            $stmt = $db->query("SELECT * FROM categorias WHERE categorias.borrado='0' ORDER BY `categorias`.`id` ASC");
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
            $stmt = $db->query("INSERT INTO `cursos` (`id`, `codigo`, `curso`, `descripcion`, `id_categoria`, `activo`, `imagen`, `borrado`) VALUES (NULL, '$codigo', '$curso', '$descripcion', '$id_categoria', '$activo', '', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $imagen, $codigo, $curso, $descripcion, $id_categoria, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `cursos` SET `imagen` = '$imagen', `codigo` = '$codigo', `curso` = '$curso', `descripcion` = '$descripcion', `id_categoria` = '$id_categoria', `activo` = '$activo' WHERE `cursos`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `cursos` SET `borrado` = '1' WHERE `cursos`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function ultimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT MAX(id) AS id FROM cursos");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
