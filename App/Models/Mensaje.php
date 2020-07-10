<?php

namespace App\Models;

use App\Models\LoginModel;
use PDO;

class Mensaje extends \Core\Model
{
    public static $ip;
    public static $asunto;
    public static $descripcion;
    public static $archivo; 
    public static $id_usuario_recibe; 
    public static $padre;
    public static $usuario; 
    public static $buscar;
    public static $buscarenviado;

    public static function index()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo,  DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_envia) AS usuario FROM mensajes WHERE  id_usuario_recibe= ? ORDER BY fechar DESC");
            $stmt->execute([$_SESSION['eduflix']['id']]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function ver()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_envia) AS usuario FROM mensajes WHERE id_usuario_recibe= ? ORDER BY fechar DESC");
            $stmt->execute([$_SESSION['eduflix']['id']]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function verenviado()
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_recibe, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar, (SELECT nombre FROM usuarios WHERE id= id_usuario_recibe) AS usuario FROM mensajes WHERE id_usuario_envia= ? AND padre = ? ORDER BY fechar DESC");
            $stmt->execute([$_SESSION['eduflix']['id']], [$_SESSION['eduflix']['id']]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function enviados()
    {    
        try 
        {
            $db = static::getDB();
//$stmt = $db->prepare("SELECT id, asunto, id_usuario_recibe, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_recibe) AS usuario FROM mensajes WHERE borrado =? ORDER BY fechar DESC");
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_recibe, descripcion, archivo,  DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_recibe) AS usuario FROM mensajes WHERE id_usuario_envia= ? ORDER BY fechar DESC");            
            $stmt->execute([$_SESSION['eduflix']['id']]); 
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
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo, padre, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT usuario FROM usuarios WHERE id = id_usuario_envia) AS usuario FROM mensajes WHERE id=?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerR($id)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_recibe, descripcion, archivo,  DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT usuario FROM usuarios WHERE id = id_usuario_recibe) AS usuario FROM mensajes WHERE id=?");
            $stmt->execute([$id]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function buscar($buscar)
    {    
        try 
        {   
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_envia) AS usuario FROM mensajes WHERE asunto LIKE ?  AND id_usuario_recibe= ? ORDER BY fechar DESC");
            //$stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %h:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_envia) AS usuario FROM mensajes WHERE asunto LIKE ? OR id_usuario_envia LIKE ? ");
            $stmt->execute(['%'.$buscar.'%',$_SESSION['eduflix']['id']]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function buscarenviado($buscarenviado)
    {    
        try 
        {   
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id, asunto, id_usuario_recibe, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %H:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_recibe) AS usuario FROM mensajes WHERE asunto LIKE ?  AND id_usuario_envia= ? ORDER BY fechar DESC");
            //$stmt = $db->prepare("SELECT id, asunto, id_usuario_envia, descripcion, archivo, DATE_FORMAT(fechar, '%e de %M de %Y a las %h:%i')AS fechar,(SELECT nombre FROM usuarios WHERE id= id_usuario_envia) AS usuario FROM mensajes WHERE asunto LIKE ? OR id_usuario_envia LIKE ? ");
            $stmt->execute(['%'.$buscarenviado.'%', $_SESSION['eduflix']['id']]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public static function responder($asunto,$descripcion,$archivo, $id_usuario_recibe, $padre)
    {    
        $padre = $_GET['id'];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `mensajes` (`id`, `asunto`, `descripcion`, `archivo`, `id_usuario_envia`, `id_usuario_recibe`,`padre`,`ip`, `id_usuario`) 
                                                VALUES (NULL, ?, ?, ?, ? , ?, ?, ?)");
            $stmt->execute([$asunto, $descripcion, $archivo, $_SESSION['eduflix']['id'], $id_usuario_recibe, self::$ip,  $_SESSION['eduflix']['id']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


public static function buscaru($usuario)
    {    
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario=?");
            $stmt->execute([$usuario]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function agregar($asunto,$descripcion,$archivo, $id_usuario_recibe)
    {
    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("INSERT INTO `mensajes` (`id`, `asunto`, `descripcion`, `archivo`, `id_usuario_envia`, `id_usuario_recibe`,`ip`, `id_usuario`) 
                                                VALUES (NULL, ?, ?, ?, ? , ?, ?, ?)");
            $stmt->execute([$asunto, $descripcion, $archivo, $_SESSION['eduflix']['id'], $id_usuario_recibe, self::$ip,  $_SESSION['eduflix']['id']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizar($id, $asunto,$descripcion,$archivo, $id_usuario_recibe)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `mensajes` SET `asunto` = ?, `descripcion` = ?, `archivo` = ?, `id_usuario_recibe` = ? , `fecham` = current_timestamp(), `ip` = ?, `id_usuario` = ? WHERE `id` = ?");
            $stmt->execute([$asunto, $descripcion, $archivo, $id_usuario_recibe, self::$ip,$_SESSION['eduflix']['id'], $id]); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminar($id)
    {    
        try {
            $db = static::getDB();
            $stmt = $db->prepare("UPDATE `mensajes` SET `borrado` = '1' WHERE `id` = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUltimoID() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT MAX(id) AS id FROM mensajes");
            $stmt->execute([]); 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUltimoIDPadre() 
    {  
        try 
        {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT MAX(id) AS padre FROM mensajes");
            $stmt->execute([]);
            $padre = $stmt; 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}