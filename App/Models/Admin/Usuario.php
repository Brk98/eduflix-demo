<?php

namespace App\Models\Admin;

use App\Models\LoginModel;
use PDO;

class Usuario extends \Core\Model
{
    public static $ip;

    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.id, usuarios.usuario, usuarios.nombre, usuarios.apaterno, usuarios.amaterno, usuarios.email, usuarios.telefono, usuarios.fechar, roles.role FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.borrado='0'");
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
            $stmt = $db->prepare("SELECT usuarios.id, usuarios.foto, usuarios.usuario, usuarios.password, usuarios.nombre, usuarios.apaterno, usuarios.amaterno, usuarios.activo, usuarios.email, usuarios.telefono, usuarios.fechar, usuarios.id_rol, roles.role FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.id=?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function roles()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM roles");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function agregar($foto, $nombre, $apaterno, $amaterno, $email, $telefono, $usuario, $password, $role, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `usuarios` (`id`, `foto`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `usuario`, `password`, `id_rol`, `activo`, `borrado`,  `id_usuario`,  `ip`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?)");
            $stmt->execute([$foto, $nombre, $apaterno, $amaterno, $email, $telefono, $usuario, $password, $role, $activo, $_SESSION['eduflix']['id'], self::$ip]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $foto, $nombre, $apaterno, $amaterno, $email, $telefono, $usuario, $password, $role, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `usuarios` SET `foto` = ?, `nombre` = ?, `apaterno` = ?, `amaterno` = ?, `email` = ?, `telefono` = ?, `usuario` = ?, `password` = ?, `id_rol` = ?, `activo` = ?, `id_usuario` = ?, `ip` = ? WHERE `usuarios`.`id` = ?");
            $stmt->execute([$foto, $nombre, $apaterno, $amaterno, $email, $telefono, $usuario, $password, $role, $activo, $_SESSION['eduflix']['id'], self::$ip, $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `usuarios` SET `borrado` = '1', `id_usuario` = ?, `ip` = ? WHERE `usuarios`.`id` = ?");
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
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM usuarios");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
