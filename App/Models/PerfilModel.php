<?php

namespace App\Models;

use PDO;

class PerfilModel extends \Core\Model
{
    public static $ip;

    public static function editar()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT usuarios.id, usuarios.foto, usuarios.usuario, usuarios.password, usuarios.nombre, usuarios.apaterno, usuarios.amaterno, usuarios.activo, usuarios.email, usuarios.telefono, usuarios.fechar FROM usuarios WHERE usuarios.id=?");
            $stmt->execute([$_SESSION['eduflix']['id']]); 
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

    public static function actualizar($id, $foto, $nombre, $apaterno, $amaterno, $email, $telefono, $password, $activo)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `usuarios` SET `foto` = ?, `nombre` = ?, `apaterno` = ?, `amaterno` = ?, `email` = ?, `telefono` = ?, `password` = ?, `activo` = ?, `ip` = ?, `fecham` = current_timestamp() WHERE `usuarios`.`id` = ?");
            $stmt->execute([$foto, $nombre, $apaterno, $amaterno, $email, $telefono, $password, $activo, self::$ip, $id]); 
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
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
