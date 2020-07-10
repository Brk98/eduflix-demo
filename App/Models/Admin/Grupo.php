<?php

namespace App\Models\Admin;

use App\Models\LoginModel;

use PDO;

class Grupo extends \Core\Model
{
    public static $ip;
    public static $id;
    public static $grupo;
    public static $descripcion;
    public static $activo;
    public static $id_generacion;
    public static $id_usuario;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT *, (SELECT generacion FROM generaciones WHERE id=id_generacion) AS generacion FROM `grupos` WHERE borrado=?");
            $stmt->execute(['0']);
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
            $stmt = $db->prepare("SELECT *, (SELECT generacion FROM generaciones WHERE id=id_generacion) AS generacion FROM `grupos` WHERE id=? AND borrado = ?");
            $stmt->execute([self::$id, 0]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function generacionesObtener()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM `generaciones` WHERE borrado = ?");
            $stmt->execute([0]);
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
            $stmt = $db->prepare("INSERT INTO `grupos` (`grupo`, `descripcion`, `activo`, `id_generacion`, `ip`, `id_usuario`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([self::$grupo, self::$descripcion, self::$activo, self::$id_generacion, self::$ip, $_SESSION['eduflix']['id']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregarUsuario()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM grupos_usuarios WHERE id_usuario = ?");
            $stmt->execute([self::$id_usuario]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Verifica si existe
            if (count($results) == 1)
            {
                // Si existe pero está deshabilitado lo habilita
                if ($results[0]['borrado'] == 1)
                {
                    $stmt = $db->prepare("UPDATE grupos_usuarios SET borrado = ?, id_grupo = ? WHERE id_usuario = ?");
                    $stmt->execute([0, self::$id, self::$id_usuario]); 
                }
            } 
            else 
            {
                // Si no existe lo crea
                $stmt = $db->prepare("INSERT grupos_usuarios (id_grupo, id_usuario, ip) VALUES (?, ?, ?)");
                $stmt->execute([self::$id, self::$id_usuario, self::$ip]); 
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUsuarios() {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.*, (SELECT role FROM roles WHERE id=id_rol) AS role FROM usuarios, grupos_usuarios WHERE usuarios.borrado = ? AND grupos_usuarios.borrado = ? AND usuarios.id = grupos_usuarios.id_usuario AND grupos_usuarios.id_grupo = ?");
            $stmt->execute([0, 0, self::$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function obtenerTodosUsuarios() {
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.*, (SELECT role FROM roles WHERE id = usuarios.id_rol) AS role, (SELECT id_grupo FROM grupos_usuarios WHERE id_usuario = usuarios.id AND grupos_usuarios.borrado = ?) AS id_grupo FROM usuarios WHERE usuarios.borrado = ?");
            $stmt->execute([0, 0]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function eliminarUsuario()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos_usuarios` SET `borrado` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `grupos_usuarios`.`id_grupo` = ? AND `grupos_usuarios`.`id_usuario` = ?");
            $stmt->execute([1, self::$ip, self::$id, self::$id_usuario]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar()
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `grupo` = ?, `descripcion` = ?, `activo` = ?, `id_generacion` = ?, `fecham` = current_timestamp() ,`id_usuario` = ?, `ip` = ? WHERE `id` = ?");
            $stmt->execute([self::$grupo, self::$descripcion, self::$activo, self::$id_generacion, $_SESSION['eduflix']['id'], self::$ip, self::$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar()
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `grupos` SET `borrado` = ?, `id_usuario` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `id` = ?");
            $stmt->execute(['1',$_SESSION['eduflix']['id'], self::$ip, self::$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
