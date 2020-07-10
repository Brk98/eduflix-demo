<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Curso extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $codigo;
    public static $curso;
    public static $descripcion;
    public static $id_categoria;
    public static $id_grupo;
    public static $activo;
    public static $imagen;
    public static $id_usuario;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT categoria FROM categorias WHERE id=id_categoria) AS categoria FROM cursos WHERE borrado=?");
            $stmt->execute([0]); 
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
            $stmt = $db->prepare("SELECT *, (SELECT categoria FROM categorias WHERE id=id_categoria), DATE_FORMAT(fechar, \"%M %d %Y\") AS fecha FROM cursos WHERE borrado=? AND id = ?");
            $stmt->execute([0, self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUsuarios() {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.*, (SELECT grupo FROM grupos WHERE id = grupos_usuarios.id_grupo) AS grupo, (SELECT role FROM roles WHERE id = usuarios.id_rol) AS role FROM usuarios, grupos_usuarios, cursos_grupos WHERE usuarios.borrado = ? AND grupos_usuarios.borrado = ? AND cursos_grupos.borrado = ? AND usuarios.id = grupos_usuarios.id_usuario AND grupos_usuarios.id_grupo AND grupos_usuarios.id_grupo = cursos_grupos.id_grupo AND cursos_grupos.id_curso = ?");
            $stmt->execute([0, 0, 0, self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function obtenerGrupos() {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT grupos.*, (SELECT generacion FROM generaciones WHERE id = grupos.id_generacion) AS generacion FROM grupos, cursos, cursos_grupos WHERE grupos.borrado = ? AND grupos.id = cursos_grupos.id_grupo AND cursos_grupos.borrado = ? AND cursos_grupos.id_curso = cursos.id AND cursos.borrado = ? AND cursos.id = ? AND cursos_grupos.borrado = ?");
            $stmt->execute([0, 0, 0, self::$id, 0]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function verificarInscrito($id_grupo) {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM cursos_grupos WHERE borrado = '0' AND id_grupo = ? AND id_curso = ?");
            $stmt->execute([$id_grupo, self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function obtenerTodosGrupos() {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT grupos.*, (SELECT generacion FROM generaciones WHERE id=grupos.id_generacion) AS generacion FROM grupos WHERE grupos.borrado = ?");
            $stmt->execute([0]); 
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
            $stmt = $db->prepare("SELECT * FROM categorias WHERE borrado='0'");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `cursos` (`codigo`, `curso`, `descripcion`, `id_categoria`, `activo`, `ip`, `id_usuario`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([self::$codigo, self::$curso, self::$descripcion, self::$id_categoria, self::$activo, self::$ip, $_SESSION['eduflix']['id']]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `cursos` SET `imagen` = ?, `codigo` = ?, `curso` = ?, `descripcion` = ?, `id_categoria` = ?, `activo` = ?, `id_usuario` = ? , `ip` = ?, `fecham` = current_timestamp() WHERE `cursos`.`id` = ?");
            $stmt->execute([self::$imagen, self::$codigo, self::$curso, self::$descripcion, self::$id_categoria, self::$activo, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `cursos` SET `borrado` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `cursos`.`id` = ?");
            $stmt->execute([1, $_SESSION['eduflix']['id'], self::$ip, self::$id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregarGrupo()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT cursos_grupos (id_curso, id_grupo, id_usuario, ip) VALUES (?, ?, ?, ?)");
            $stmt->execute([self::$id, self::$id_grupo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminarGrupo()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `cursos_grupos` SET `borrado` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `cursos_grupos`.`id_curso` = ? AND `cursos_grupos`.`id_grupo` = ?");
            $stmt->execute([1, $_SESSION['eduflix']['id'], self::$ip, self::$id, self::$id_grupo]); 
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
