<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class MisCursosModel extends \Core\Model
{
    public static $id;
    public static $id_grupo;
    
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT cursos.*, (SELECT categoria FROM categorias WHERE id=id_categoria) AS categoria, DATE_FORMAT(cursos.fechar, \"%M %d %Y\") AS fecha FROM cursos, cursos_grupos, grupos_usuarios WHERE cursos.borrado =? AND cursos_grupos.borrado =? AND grupos_usuarios.borrado =? AND cursos.id = cursos_grupos.id_curso AND cursos_grupos.id_grupo = grupos_usuarios.id_grupo and grupos_usuarios.id_usuario = ?");
            $stmt->execute([0, 0, 0, $_SESSION['eduflix']['id']]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtener()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT categoria FROM categorias WHERE id=id_categoria) AS categoria FROM cursos WHERE id=?");
            $stmt->execute([self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerGrupo()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT grupos.* FROM grupos, grupos_usuarios WHERE grupos.borrado = ? AND grupos_usuarios.borrado = ? AND grupos.id = grupos_usuarios.id_grupo AND grupos_usuarios.id_usuario = ?");
            $stmt->execute([0, 0, $_SESSION['eduflix']['id']]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerProfesores()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.* FROM usuarios, grupos_usuarios WHERE id_rol = 2 AND usuarios.id = grupos_usuarios.id_usuario AND grupos_usuarios.id_grupo = ?");
            $stmt->execute([self::$id_grupo]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function grupos()
    {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT grupos.* FROM grupos, cursos_grupos WHERE grupos.id = cursos_grupos.id_grupo AND cursos_grupos.id_curso = ?");
            $stmt->execute([self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
