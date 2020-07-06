<?php

namespace App\Models;

use PDO;

class Usuario extends \Core\Model
{
    public static function tabla()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT usuarios.id, usuarios.usuario, usuarios.nombre, usuarios.apaterno, usuarios.amaterno, usuarios.email, usuarios.telefono, usuarios.fechar, roles.role FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.borrado='0'");
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
            $stmt = $db->query("SELECT usuarios.id, usuarios.foto, usuarios.usuario, usuarios.password, usuarios.nombre, usuarios.apaterno, usuarios.amaterno, usuarios.activo, usuarios.email, usuarios.telefono, usuarios.fechar, usuarios.id_rol, roles.role FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.id=$id");
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
            $stmt = $db->query("SELECT * FROM roles");
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
            $stmt = $db->query("INSERT INTO `usuarios` (`id`, `foto`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `usuario`, `password`, `id_rol`, `activo`, `borrado`) VALUES (NULL, '$foto', '$nombre', '$apaterno', '$amaterno', '$email', '$telefono', '$usuario', '$password', '$role', '$activo', '0')");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $foto, $nombre, $apaterno, $amaterno, $email, $telefono, $usuario, $password, $role, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `usuarios` SET `foto` = '$foto', `nombre` = '$nombre', `apaterno` = '$apaterno', `amaterno` = '$amaterno', `email` = '$email', `telefono` = '$telefono', `usuario` = '$usuario', `password` = '$password', `id_rol` = '$role', `activo` = '$activo' WHERE `usuarios`.`id` = $id");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->query("UPDATE `usuarios` SET `borrado` = '1' WHERE `usuarios`.`id` = '$id'");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function ultimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->query("SELECT MAX(id) AS id FROM usuarios");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
